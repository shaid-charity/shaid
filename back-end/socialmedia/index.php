<!--
This document does not run on all versions of php. It works with PHP 7.1.7
I ran it from terminal using php -S localhost:8000
-->
<!DOCTYPE html>
<html lang="en">
<head>
  <title>SHAID Social Media</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=2016556085255853&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
  }
  (document, 'script', 'facebook-jssdk'));
</script>

<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Logo?</a>
    </div>
    <div class="collapse navbar-collapse" id="myNavbar">
      <ul class="nav navbar-nav">
        <li><a href="#">Home</a></li>
        <li><a href="#">Main site</a></li>
        <li><a href="#">Other</a></li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid text-center">
  <div class="row content">
    <div class="col-sm-6 text-left">

      <form id=form1 method = "post" >
        <h4>Posting to social medias</h4>
        Enter text below:
        <br>
        <textarea  id= "input" name = "input" form = "form1"  value = "h" rows="8" cols="80"></textarea>
        <br>
        <label><input name="test[]" value='Facebook' type="checkbox">Facebook</label>
        <label><input name="test[]" value='Twitter' type="checkbox">Twitter</label>
        <input type = "submit" name="submit" id="search" value = "Send">
      </form>

    <?php

    //TWITTER
    $consumerKey    = 'PErpyYJif6jXHajdni3PNDfh3';
    $consumerSecret = 'heNVbOL8FcezVjz0ztMvwPGSs7UspkwBe9wZUsf0e5dTi2D969';
    $oAuthToken     = '953755545407836161-A94KWSNbqkPne4yXwsRbHFeLk88s42a';
    $oAuthSecret    = 'HQHcLCJD6zE5Z32t9jIBzQuhqmm0OsYUx86EsN7vYu7dL';

    require_once('index.php');
    require "twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;
    // create a new instance
    $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

    //FACEBOOK - app not live yet so only admin can see posts

    define('FACEBOOK_SDK_V4_SRC_DIR', __DIR__ . '/src/Facebook/');
    require_once(__DIR__ . '/src/Facebook/autoload.php');

    $fb = new Facebook\Facebook([
        'app_id' => '2016556085255853',
        'app_secret' => '4e8540e164419ca7ac4309f3898318b2',
        'default_graph_version' => 'v2.2',
        $accessToken = "EAAcqDA0hnq0BAPhGZCwDqX6siOVDVLGzQZCPK9ZAksZCr92wGDAfFVk8dRvmWvTYgl0ZCQ1FNveTyW4lgEHptLiCl5Ek6Kr5ngTGqpaE90NBPJ5rwYEZCuwPzHd1DS5xUvBtpcZAj7onsjTaYZB6cZAVnTCLhkTqd0sFb1EcrYIPvcgZDZD",
    ]);

    //POST
    if(isset($_POST['submit']))
    {
      $box = $_POST["test"];
      if(!empty($box)){
        $sm = implode('', $box);
        if(strpos($sm, 'Facebook') !== false){

          $text = htmlspecialchars($_POST['input']);
          if(isset($accessToken)) {
              $message = [
                  'message' => "$text",
              ];

              try {
                  $response = $fb->post('/2066571940241754/feed', $message, $accessToken);
                  echo nl2br("\nPosted to Facebook \n");
              } catch(Facebook\Exceptions\FacebookResponseException $e) {
                  echo 'Graph returned an error: '.$e->getMessage();
                  exit;
              } catch(Facebook\Exceptions\FacebookSDKException $e) {
                  echo 'Facebook SDK returned an error: '.$e->getMessage();
                  exit;
              }
            }
          }

        if(strpos($sm, 'Twitter') !== false){
          $text = htmlspecialchars($_POST['input']);
          if(strlen($text)<=280){
            $tweet->post('statuses/update', array('status' => "$text"));
            echo nl2br("\nPosted to Twitter \n");
          }
          elseif (strpos($sm, 'Facebook') !== false){
            echo("Message is longer than 280 characters, will be shortened and a link to the Facebook post will be provided");
            $text = substr($text, 0,250);
            $link = "https://fb.me/SHAIDTest";
            $text = $text."...". $link;
            $tweet->post('statuses/update', array('status' => "$text"));
            echo nl2br("\nPosted to Twitter \n");

          }

          else {
            echo("Message is ".(strlen($text)-280) ." characters too long, unable to post to Twitter");
          }
        }
    }
    }

    //Future things to add: Add other social medias?
    //                      Option to add pictures etc.
    //                      Could add login buttons to make more transferrable
    ?>

    <div class="container-fluid text-center">
      <div class="row content">
        <div class="col-sm-6 text-left">

        <a class="twitter-timeline" data-width="220" data-height="300" href="https://twitter.com/test19022018?ref_src=twsrc%5Etfw">Tweets by test19022018</a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="col-sm-6 text-left">
        <div class="fb-page" data-href="https://www.facebook.com/SHAIDTest" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
          <blockquote cite="https://www.facebook.com/SHAIDTest" class="fb-xfbml-parse-ignore">
          <a href="https://www.facebook.com/SHAIDTest">Test2</a>
          </blockquote>
        </div>
        </div>
      </div>
    </div>
  </div>

    <div class="col-sm-1 text-center">
    <hr style="border:none; border-left:1px solid hsla(200, 10%, 50%,100);height:100vh;width:1px;">
    </div>

    <div class="col-sm-5 text-left">
      <h1>Add tracking trends here?</h1>
      <button type="button"> Email Current Top Trends</button>
      <br>
      <form id=form2 method = "post" >
        <input type="text" name="keyword[]"/>
        <input type = "submit" name="submit" id="add_key" value = "Add Keyword">
      </form>

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



          if(isset($_POST['add_key'])){
              array_push($keywords,"ISSET");
              $new_word = $_POST['keyword'];
              if(!empty($new_word)){
                array_push($keywords,$new_word);
                echo "\n".$new_word." has been added to your list of keywords.\n";
              }

          }

          $key_trending = array();

          /** $keywords_timer = gettimeofday();**/
          /** if($keywords_timer == "0.0"){**/
          /**   $key_trending = array();**/
          /** }**/

          echo "\nYour current keywords are:\n";
          foreach($keywords as $word){
            echo $word."\n";
          }
          echo "\n";


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
            echo "\nNone of your key words are currently trending.";
          }else{
            echo "\nThe following are trends of interest: \n";
            foreach($key_trending as $trend){
              echo $trend."\n";
            }
          }

      ?>


    </div>

  </div>
</div>


</body>
</html>
