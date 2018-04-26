<?php
  $title = "Social Media Trends";
  define('CURRENT_PAGE', 'socialTrends');

  require_once '../includes/settings.php';
  require_once '../includes/config.php';
  require_once 'header.php';
?>
<div class="text-left container">
    <div class="page-header">
      <h1>Twitter trends</h1>
    </div>
    <br />
    <form id=forme method = "post" >
      <button type="email_button" id="email_button" class="btn btn-primary" name ="email_button"> Email Current Top Trends</button>
    </form>
      <br>
      <br>
      <form id=form2 method = "post" >
        <input type="text" id="add_keyword" class="form-control" name="add_keyword">
        <button type = "add_key" name="add_key" id="add_key" class="btn btn-primary">Add Keyword </button>
        <br>
        <input type="text" id="del_keyword" class="form-control" name="del_keyword">
        <button type = "del_key" name="del_key" id="del_key" class="btn btn-danger">Delete Keyword </button>
      </form>
    <?php
      require_once '../socialmedia/trends.php';
    ?>

</div>
</body>
</html>
