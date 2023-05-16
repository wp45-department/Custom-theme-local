<?php
/* Template Name: Register */
if ( is_user_logged_in() ) {
    wp_redirect( home_url('dashboard'), 301 );
}
get_header();
?>
<!-- Sign Up Section Start -->
<section class="signup-sec-main">
    <div class="container-fluid">
        <div class="login-inner">
            <div class="login-con-block">
                <table style="width: 100%; height: 100%; background-color: transparent">
                    <tbody>
                        <tr>
                            <td class="custom-login-bg">
                                <div class="login-table-block">
                                    <div class="container">
                                        <div class="row">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-6">
                                                <div class="login-table-box">
                                                    <div class="login-table-title">Sign Up</div>
                                                    <div class="login-table-box-inner">
                                                        <div class="login-logo">
                                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/my-account-login.png"
                                                                style="width: 100px" />
                                                        </div>
                                                        <form class="signup-form" id="register-from-submit"
                                                            method="post">
                                                            <input type="hidden" name="action"
                                                                value="owner_user_register">
                                                            <div class="form-field">
                                                                <label>Email</label>
                                                                <input class="form-control text-white" name="email"
                                                                    type="email" placeholder="" required />
                                                            </div>
                                                            <div class="form-field">
                                                                <label>First name</label>
                                                                <input class="form-control text-white" name="first_name"
                                                                    type="text" placeholder="" required />
                                                            </div>
                                                            <div class="form-field">
                                                                <label>Last name</label>
                                                                <input class="form-control text-white" name="last_name"
                                                                    type="text" placeholder="" required />
                                                            </div>
                                                            <div class="form-field">
                                                                <label>Password</label>
                                                                <div class="form-password-box">
                                                                    <input class="form-control" name="password"
                                                                        type="password" placeholder="" required />6
                                                                    characters minimum
                                                                </div>
                                                            </div>
                                                            <div class="form-field">
                                                                <label>Password Confirmation</label>
                                                                <div class="form-password-box">
                                                                    <input class="form-control" type="password"
                                                                        placeholder="" name="conf_password" required />
                                                                </div>
                                                            </div>
                                                            <?php /*<div class="form-field">
                                                                <label>Select User Type</label>
                                                                <div class="form-password-box">
                                                                    <select class="form-control text-white"
                                                                        name="usertype" required>
                                                                        <option value="">-- Select --</option>
                                                                        <option value="1">Company</option>
                                                                        <option value="2">Viewer</option>
                                                                    </select>
                                                                </div>
                                                            </div> */ ?>
                                                            <div class="login-btn-block">
                                                                <div class="login-submit-btn">
                                                                    <button class="submit-btn btn" type="submit">
                                                                        Sign Up
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <div id="responce_error"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3"></div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</section>
<!-- Sign Up Section End -->
<?php
get_footer();