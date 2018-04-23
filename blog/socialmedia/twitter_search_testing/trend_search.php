<!DOCTYPE html>
<html lang="en">
<head>
  <title>SHAID Social Media</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
</head>
<body>
  //getting inputs
  <input type="text" name="keyword[]"/>



<?php

  require_once('./wrapper/TwitterAPIExchange.php');

  /** Set access tokens here - see: https://dev.twitter.com/apps/ **/
  $settings = array(
      'oauth_access_token' => "703944336950558720-utt80LMNGr2d7XHfUTArdgE2NmJr0ME",
      'oauth_access_token_secret' => "fuM6RTVqH16VVBBpUpQzWtzUefyQNeb1oDI5Rq5DYRInA",
      'consumer_key' => "lvW8nadoeKijsBF6zFrGKjHVr",
      'consumer_secret' => "NmEOvOHkLOhHsDyk00smEirmTZ72lmTgvGgsAYNxuRMxoW16qL"
  );

  $url = "https://api.twitter.com/1.1/trends/place.json";

  $requestMethod = "GET";

  $getfield = '?id=30079'; //Newcastle: 30079

  $twitter = new TwitterAPIExchange($settings);
  $string = json_decode($twitter->setGetfield($getfield)
               ->buildOauth($url, $requestMethod)
               ->performRequest(), $assoc=TRUE);

  if($string["errors"][0]["message"] != "") {echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";exit();}

  //TO DO: add function to edit/view the keywords
  $keywords = array("homeless","fire","sleeping rough");

  $new_word = $_POST['keyword'];
  if($new_word !== ""){
    array_psuh($keywords,$new_word);
  }

  $key_trending = array();

  $keywords_timer = gettimeofday();
  if($keywords_timer == 0.0){
    $key_trending = array();
  }


  foreach($string[0]["trends"] as $items)
    {
      foreach($keywords as $key){
        if(strpos($items['name'],$key)!==false){
          //echo "KEY FOUND: ".$key."\n";
          array_push($key_trending,$items['name']);
        }
      }
      echo $items['name']."\n";
    }


  if(count($key_trending)==0){
    echo "None of your key words are currently trending.";
  }else{
    echo "The following are trends of interest: \n";
    foreach($key_trending as $trend){
      echo $trend."\n";
  }

  //TO DO: add links to email messages

  require_once "./mail/Mail.php";

  $from = '<testhannah1996@gmail.com>';
  $to = '<testhannah1996@gmail.com>';
  $subject = 'Your keyword is trending!';
  //ADD MULTIPLE TRENDS, LINK TO EMAIL MESSAGE
  $body = "One of your keywords is trending!\n".$key_trending[0]." is now trending.";

  $headers = array(
      'From' => $from,
      'To' => $to,
      'Subject' => $subject
  );

  $smtp = Mail::factory('smtp', array(
          'host' => 'ssl://smtp.gmail.com',
          'port' => '465',
          'auth' => true,
          'username' => 'testhannah1996@gmail.com',
          'password' => 'testtesttest'
      ));

  $mail = $smtp->send($to, $headers, $body);

  if (PEAR::isError($mail)) {
      echo('<p>' . $mail->getMessage() . '</p>');
  } else {
      echo('<p>Message successfully sent!</p>');
  }
?>
</body>
