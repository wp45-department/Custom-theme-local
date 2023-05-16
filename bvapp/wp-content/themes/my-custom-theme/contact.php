<?php
/*
Template Name: Form
*/
?>
<?php get_header(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

<h2>HTML Forms</h2>

<form id="contactform" style="margin-top:100px;">
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname"><br><br>
  <input type="submit" value="Submit">
</form> 
<script>

</script>
<?php get_footer() ?>