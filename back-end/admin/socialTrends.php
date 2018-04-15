<?php
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
      <button type="button"> Email Current Top Trends</button>
      <br>
      <br>
      <form id=form2 method = "post" >
        <input type="text" id="keyword" name="keyword">
        <button type = "add_key" name="add_key" id="add_key">Add Keyword </button>
      </form>
    <?php require_once '../socialmedia/trends.php';?>

</div>
</body>
</html>