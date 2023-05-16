<?php
/* Template Name: My Account */
if (!is_user_logged_in() ) {
   wp_redirect( home_url('login'), 301 );
}
get_header();
$user = wp_get_current_user();
$UserId = $user->ID;
//print_r($user );
$user_login_name = $user->user_login;
$user_email = $user->user_email;
$display_name = $user->display_name;
$UserId = $user->ID;
$first_name = $user->first_name;
$last_name = $user->last_name;

?>
<!-- Demo Section Start -->

<section class="demo-sec-main">
    <div class="container-fluid">
        <div class="demo-inner">
            <div class="demo-box-main-title">
                <h4 style="clear: both"><?php the_title()?></h4>
            </div>
            <hr style="margin-left: 16px">


            <form class="myaccount ps-3" id="myaccount-form-sumbit" method="post">
                <div id="rep_error"> </div>
                <input type="hidden" value="update_profile_data" name="action" />
                <!-- 2 column grid layout with text inputs for the first and last names -->
                <div class="row mb-4">
                    <div class="col">
                        <div class="form-outline">
                            <label class="form-label" for="form6Example1">First Name</label>
                            <input type="text" id="form6Example1" class="form-control" name="first_name" required
                                value="<?php echo $first_name ;?>" />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-outline">
                            <label class="form-label" for="form6Example2"> Last Name</label>
                            <input type="text" id="form6Example2" name="last_name" class="form-control" required
                                value="<?php echo $last_name   ;?>" />
                        </div>
                    </div>
                </div>


                <!-- Email input -->
                <div class="form-outline mb-4">
                    <label class="form-label" for="form6Example5">Email</label>
                    <input type="email" name="email" id="form6Example5" class="form-control" required
                        value="<?php echo $user_email ; ?>" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form6Example5">Current Password </label>
                    <input type="password" id="form6Example5" class="form-control" name="current_password" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form6Example5"> New Password </label>
                    <input type="password" id="form6Example5" class="form-control" name="password" />
                </div>

                <div class="form-outline mb-4">
                    <label class="form-label" for="form6Example5"> Password Confirmation </label>
                    <input type="password" id="form6Example5" class="form-control" name="conf_password" />
                </div>



                <!-- Submit button -->
                <button type="submit" class="btn btn-primary btn-block mb-4">Update Profile</button>
            </form>

        </div>
    </div>

</section>


<?php
get_footer();