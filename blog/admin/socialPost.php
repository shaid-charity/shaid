<?php
  $title = "Social Media Posting";
  define('CURRENT_PAGE', 'socialPost');

  require_once '../includes/settings.php';
  require_once '../includes/config.php';
  require_once 'header.php';

?>
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
    require_once '../socialmedia/config.php';
    require_once '../socialmedia/post.php';
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

