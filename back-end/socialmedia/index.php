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


<nav class="navbar navbar-inverse">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <img src="logo-small.png" style="width:97.5px;height:50px;">
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
        <h4><center>Posting to social medias</center></h4>
        Enter text below:
        <br>
        <textarea  id= "input" name = "input" form = "form1" spellcheck="true" value = "h" rows="8" cols="75"></textarea>
        <br>
        <label><input name="test[]" value='Facebook' type="checkbox">Facebook</label>
        <label><input name="test[]" value='Twitter' type="checkbox">Twitter</label>
        <input type = "submit" name="submit" id="search" value = "Send">
      </form>

    <?php
    require_once 'config.php';
    require_once 'post.php';
    ?>

    <div class="container-fluid text-center">
      <div class="row content">
        <div class="col-sm-6 text-left">

        <a class="twitter-timeline" data-width="220" data-height="500" href="https://twitter.com/test19022018?ref_src=twsrc%5Etfw">Tweets by test19022018</a>
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



    <div class="col-sm-6 text-left" style="background-color: #f1f1f1">
      <h4><center>Twitter trends</center></h4>
      <br>
      <button type="button"> Email Current Top Trends</button>
      <br>
      <br>
      <form id=form2 method = "post" >
        <input type="text" id="add_keyword" name="add_keyword">
        <button type = "add_key" name="add_key" id="add_key">Add Keyword </button>
        <br>
        <input type="text" id="del_keyword" name="del_keyword">
        <button type = "del_key" name="del_key" id="del_key">Delete Keyword </button>
      </form>

      <?php
        require_once 'trends.php';
      ?>

    </div>
  </div>
</div>

</body>
<br>
<footer class="footer text-center" style="background-color: #222222">
<div class="privacy">
    <a href="https://docs.google.com/document/d/1YYyh0I6En1-aSbdt5CmT79SlQSY7xIRYgrg2ZSigkyo/edit?usp=sharing" style="color: #808080"> Privacy policy </a>
</div>
</footer>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_GB/sdk.js#xfbml=1&version=v2.12&appId=.<?php $app_id; ?>.&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
  }
  (document, 'script', 'facebook-jssdk'));
</script>
</html>
