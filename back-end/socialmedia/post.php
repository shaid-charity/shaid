<div class="text-left container">

      <form id=form1 method = "post" >
        <div class="page-header">
          <h1>Posting to social media</h1>
        </div>
        <br />
        Enter text below:
        <br>
        <textarea  id= "input" name = "input" form = "form1" spellcheck="true" value = "h" rows="8" cols="75"></textarea>
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

    //require_once('index.php');
    require "twitteroauth/autoload.php";
    use Abraham\TwitterOAuth\TwitterOAuth;
    // create a new instance
    $tweet = new TwitterOAuth($consumerKey, $consumerSecret, $oAuthToken, $oAuthSecret);

    //FACEBOOK    - app not live yet so only admin can see posts

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
  </body>
</html>