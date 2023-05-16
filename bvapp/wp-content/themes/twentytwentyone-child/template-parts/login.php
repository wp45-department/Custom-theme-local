<?php
/* Template Name: Login */
if ( is_user_logged_in() ) {
    wp_redirect( home_url('dashboard'), 301 );
}
get_header();

?>
<!-- login Section Start -->
<section class="login-sec-main">
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
                                            <div class="col-sm-4"></div>
                                            <div class="col-sm-4">
                                                <div class="login-table-box">
                                                    <div class="login-table-title">Sign In</div>
                                                    <div class="login-table-box-inner">
                                                        <div class="login-logo">
                                                            <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/my-account-login.png"
                                                                style="width: 100px" />
                                                        </div>
                                                        <form class="login-form" id="login-from-submit" method="post">
                                                            <input type="hidden" name="action" value="owner_user_login">
                                                            <div class="form-field">
                                                                <input class="form-control text-white" name="email"
                                                                    type="email" placeholder="Email" required />
                                                            </div>
                                                            <div class="form-field">
                                                                <input class="form-control text-white" name="password"
                                                                    type="password" placeholder="Password" required />
                                                            </div>
                                                            <div class="form-group">
                                                                <input type="checkbox" value="1" id="user_remember_me"
                                                                    name="rememberme" />
                                                                <label for="user_remember_me">Remember me</label>
                                                            </div>
                                                            <div class="login-btn-block">
                                                                <div class="login-submit-btn">
                                                                    <button class="submit-btn btn" type="submit">
                                                                        Submit
                                                                    </button>
                                                                </div>
                                                                <div class="login-btn-content">
                                                                    <a href="<?php echo home_url('register');?>">Sign
                                                                        up</a>
                                                                    <a href="javascript:void(0)">Forgot your
                                                                        password?</a>
                                                                </div>
                                                            </div>
                                                            <div id="responce_error"></div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-4"></div>
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
<!-- login Section End -->
<?php
get_footer();