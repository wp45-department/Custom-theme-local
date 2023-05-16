<?php
/*
Template Name: Form
*/
?>
<?php get_header(); ?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<h2>HTML Forms</h2>
<div id="result"></div>
<form id="contactform" style="margin-top:100px;" method="POST" action= "<?php echo admin_url('admin-ajax.php'); ?>">

  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname"><br>
  <input type="hidden" id="fname" name="action" value="get_data"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname"><br><br>
  <input type="submit" value="Submit">
</form> 
<script>

$("#contactform").on("submit", function(e){
    e.preventDefault();
   //Code: Action (like ajax...)

   var form= $("#contactform");


   $.ajax({
    type: form.attr('method'),
    url: form.attr('action'),
    data: form.serialize(),
    success: function (data) {
    $('#result').html(data);

    }
});


 });
</script>
<?php get_footer() ?>