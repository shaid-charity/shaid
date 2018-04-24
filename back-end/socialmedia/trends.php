<?php
    require_once('wrapper/TwitterAPIExchange.php');
    require_once 'config.php';
    require_once '../includes/settings.php';
    require_once '../includes/config.php';

    /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
    $settings = array(
        'oauth_access_token' => $oAuthToken,
        'oauth_access_token_secret' => $oAuthSecret,
        'consumer_key' => $consumerKey,
        'consumer_secret' => $consumerSecret
    );

    $url = "https://api.twitter.com/1.1/trends/place.json";

    $requestMethod = "GET";

    $getfield = '?id=30079'; //Newcastle: 30079

    $twitter = new TwitterAPIExchange($settings);
    $string = json_decode($twitter->setGetfield($getfield)
                 ->buildOauth($url, $requestMethod)
                 ->performRequest(), $assoc=TRUE);

    if($string["errors"][0]["message"] != "") {
      echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
      exit();
    }

    //get keywords from text file
    $key_file = fopen("keywords.txt", "r") or die("Unable to access keywords!");
    $key_string = fread($key_file,filesize("keywords.txt"));
    fclose($key_file);

    $current_word = "";
    $keywords = array();
    for($i=0; $i<strlen($key_string); $i++){
      if($key_string[$i]== " "){
        array_push($keywords, $current_word);
        $current_word="";
      }else{
        if($i == strlen($key_string)-1){
          array_push($keywords, $current_word);
          $current_word="";
        }else{
          $current_word.=$key_string[$i];
        }
      }
    }
    $new_keywords = "";
    if(isset($_POST['add_key'])){
      $new_word = htmlspecialchars($_POST['add_keyword']);
      if(!empty($new_word)){
        array_push($keywords,$new_word);

        foreach($keywords as $key){
          $new_keywords.=$key;
          $new_keywords.=" ";
        }
        file_put_contents("keywords.txt", $new_keywords);
        echo "<br>".$new_word." has been added to your list of keywords.<br>";
      }
    }

    if(isset($_POST['del_key'])){
      $old_word = htmlspecialchars($_POST['del_keyword']);
      if(!empty($old_word)){
        if (($del_this = array_search($old_word, $keywords)) !== false) {
          unset($keywords[$del_this]);
        }
        foreach($keywords as $key){
          $new_keywords.=$key;
          $new_keywords.=" ";
        }
        file_put_contents("keywords.txt", $new_keywords);
        echo "<br>".$old_word." has been deleted from your list of keywords.<br>";
      }
    }

    $key_trending = array();

    /** $keywords_timer = gettimeofday();**/
    /** if($keywords_timer == "0.0"){**/
    /**   $key_trending = array();**/
    /** }**/


    echo "<br><h3>Your current keywords are:</h3>";
    foreach($keywords as $word){
      echo $word."<br>";
    }

    echo "<h3>Current trends:</h1>";
    $counter = 0; /** Twitter always gives 50 (cannot change), only display 20 **/
    $overrideLimit = False;
    foreach($string[0]["trends"] as $items)
      {
        foreach($keywords as $key){
          if(strpos(strtolower($items['name']),strtolower($key))!==false){
            //echo "KEY FOUND: ".$key."\n";
            array_push($key_trending,$items['name']);
            $overrideLimit = True;
          }
        }
        $counter +=1;
        if(($counter <= 20) || $overrideLimit){
          echo $items['name']."<br>";
          $overrideLimit = False;
        }
      }


    if(count($key_trending)==0){
      echo "<br>None of your key words are currently trending in the top 50.<br>";
    }else{
      echo "<br>\nThe following are trends of interest: \n";
      foreach($key_trending as $trend){
        echo "<strong>".$trend."\n"."</strong>";
      }
    }



    //email

    if(isset($_POST['email_button'])){
      echo 'testing';
      $to      = 'matthew.accounts@gmx.com';
      $subject = 'Your current trends!';
      $message = '<h2>The following of your keywords are trending:</h2>'."\n";

      // Test using SwiftMailer
      // Create the Transport
      $transport = new Swift_SmtpTransport(EMAIL_SERVER, EMAIL_PORT, 'tls');
      $transport->setUsername(EMAIL_ADDRESS);
      $transport->setPassword(EMAIL_PASSWORD);

      // Create a mailer
      $mailer = new Swift_Mailer($transport);

      // Get a version of the message without any HTML tags
      // We can then send the plain text version as a backup, in case the HTML version won't load
      $messageNoHTML = strip_tags($message);

      // Create the message - recipient will be set later
      $message = new Swift_Message($subject);
      $message->setFrom(array(EMAIL_ADDRESS => EMAIL_NAME));
      $message->setBody($messageNoHTML);
      $message->addPart($message, 'text/html');

      // Send

      $message->setTo($to);

      $sent = $mailer->send($message, $failed);

      
      if(empty($key_trending)){
        $message.="Sorry, none of your keywords are trending."."\n";
      }else{
        foreach($key_trending as $trend){
          $message.="<strong>".$trend."</strong>"."\n";
        }
      }

      $headers = 'From: testhannah1996@gmail.com' . "\r\n" .
        'Reply-To: testhannah1996@gmail.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

      $mail=mail($to, $subject, $message, $headers);
      if($mail){
        echo "\n"."Email sent";
      }else{
        echo "\n"."Mail sending failed.";
      }
    }
?>
