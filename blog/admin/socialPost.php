<?php
  $title = "Social Media Posting";
  define('CURRENT_PAGE', 'socialPost');

  require_once '../includes/settings.php';
  require_once '../includes/config.php';
  require_once 'header.php';

?>
<div class="text-left container">
  <form id="form1" method = "post" >
    <div class="page-header">
      <h1>Posting to social media</h1>
    </div>
    <br />
    Enter text below:
    <br>
    <textarea  id= "input" class="form-control" name = "input" form = "form1" spellcheck="true" value = "h" rows="8" cols="75"></textarea>
    <br>
    <div class="form-group">
      <input id="facebookCheckbox" name="test[]" class="form-check-input" value='Facebook' type="checkbox">
      <label for="facebookCheckbox" class="form-check-label">Facebook</label>
    </div>
    <div class="form-group">
      <input id="twitterCheckbox" name="test[]" class="form-check-input" value='Twitter' type="checkbox">
      <label for="twitterCheckbox" class="form-check-label">Twitter</label>
    </div>
    <input type = "submit" name="submit" id="search" class="btn btn-primary" value = "Send">
  </form>

    <?php
    require_once '../socialmedia/social.config.php';
    require_once '../socialmedia/post.php';
    ?>

    <div class="container-fluid text-center">
      <div class="row content">
        <div class="col-sm-6 text-left">

        <a class="twitter-timeline" data-width="220" data-height="500" href="https://twitter.com/<?php echo $twitter_name; ?>?ref_src=twsrc%5Etfw">Tweets by <?php echo $twitter_name; ?></a>
        <script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
        </div>
        <div class="col-sm-6 text-left">

        <div class="fb-page" data-href="https://www.facebook.com/<?php echo $page_name; ?>" data-tabs="timeline" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="false">
          <blockquote cite="https://www.facebook.com/<?php echo $page_name; ?>" class="fb-xfbml-parse-ignore">
          <a href="https://www.facebook.com/<?php echo $page_name; ?>"><?php echo $page_name; ?></a>
          </blockquote>
        </div>
        </div>
      </div>
    </div>
  </div>
  </body>
  <script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=<?php echo $app_id; ?>&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
  }
  (document, 'script', 'facebook-jssdk'));
</script>
</html>
