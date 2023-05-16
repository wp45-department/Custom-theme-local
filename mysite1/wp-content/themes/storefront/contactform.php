<?php
/*
Template Name: Contact Form
*/
?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
<form id="enquiry">
  <div class="form-group">
  <label for="fname">First name:</label><br>
  <input type="text" id="fname" name="fname"><br>
  <label for="lname">Last name:</label><br>
  <input type="text" id="lname" name="lname"><br><br>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<script>
jQuery('#enquiry').submit(function(event){
    event.preventDefault();
    var endpoint = '<?php echo admin_url('admin-ajax.php') ?>';
    var form = $('#enquiry').serialize();
    console.log(form);
});
</script>