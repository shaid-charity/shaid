      <?php
          require_once('wrapper/TwitterAPIExchange.php');

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

          if($string["errors"][0]["message"] != "") {
            echo "<h3>Sorry, there was a problem.</h3><p>Twitter returned the following error message:</p><p><em>".$string[errors][0]["message"]."</em></p>";
            exit();
          }

          $keywords = array("homelessness","tragedy","sleeping rough", "fire");

          if(isset($_POST['add_key'])){
            $new_word = htmlspecialchars($_POST['add_keyword']);
            if(!empty($new_word)){
              array_push($keywords,$new_word);
              echo "<br>".$new_word." has been added to your list of keywords.<br>";
            }
          }

          if(isset($_POST['del_key'])){
            $old_word = htmlspecialchars($_POST['del_keyword']);
            if(!empty($old_word)){
              if (($del_this = array_search($old_word, $keywords)) !== false) {
                unset($keywords[$del_this]);
              }
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
      ?>
