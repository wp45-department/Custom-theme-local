<?php
/**
 * The header.
 *
 * This is the template that displays all of the <head> section and everything up until main.
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package WordPress
 * @subpackage Twenty_Twenty_One
 * @since Twenty Twenty-One 1.0
 */

?>
<!doctype html>
<html <?php language_attributes(); ?> <?php twentytwentyone_the_html_classes(); ?>>

<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Favicon -->
    <link rel="shortcut icon" href="img/logo/main.svg" type="image/x-icon" />

    <!-- Bootstrap CSS -->
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.1.1/css/all.css" />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
    <!-- Custom Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />


    <link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/assets/css/style.css" />
    <?php wp_head(); ?>
    <script type="text/javascript">
    var ajaxurl = "<?php echo admin_url('admin-ajax.php'); ?>";
    var site_url = "<?php echo site_url(); ?>";
    </script>

</head>

<body <?php body_class(); ?>>
    <div class="loading" id="loadershowhide">Loading&#8230;</div>

    <?php wp_body_open(); ?>
    <!-- Header Section Start -->
    <header class="header-sec-main">
        <div class="container-fluid">
            <div class="header-inner">
                <a href="<?php echo site_url(); ?>" class="header-logo">
                    <img src="<?php echo get_stylesheet_directory_uri(); ?>/assets/image/logo.png" />
                </a>
                <?php if ( is_user_logged_in() ) {
                $current_user = wp_get_current_user();        
                ?>

                <ul class="header-user-block" style="height: 68px">

                    <li class="header-user-list d-inline-block">
                        <div class="dropdown">
                            <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img src="https://secure.gravatar.com/avatar/bdc3c91056012252f391f51f7ec9f44d?default=https%3A%2F%2Fstorage.googleapis.com%2Fblockvue-assets%2Fuser-circle.png&amp;secure=true"
                                    width="36" height="36" />
                                <?php echo $current_user->user_firstname;?> <?php echo $current_user->user_lastname;?>
                            </button>
                            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <a class="dropdown-item" href="<?php echo home_url( 'dashboard'); ?>">Dashboard</a>
                                <?php if($current_user->roles[0]=='administrator'){ ?>
                                <a class="dropdown-item"
                                    href="<?php echo site_url();?>/admin-dashboard/add-new-tour/">Add
                                    New
                                    Tour</a>
                                <a class="dropdown-item"
                                    href="<?php echo site_url();?>/admin-dashboard/archive/">Archive</a>
                                <?php } ?>
                                <?php if($current_user->roles[0]=='owner'){ ?>
                                <a class="dropdown-item" href="<?php echo site_url();?>/dashboard/archive/">Archive</a>
                                <?php } ?>
                                <a class="dropdown-item" href="<?php echo site_url();?>/my-account/">My Account</a>
                                <a class="dropdown-item"
                                    href="<?php echo esc_url( wp_logout_url(home_url('login')) ); ?>">Logout</a>
                            </div>
                        </div>
                    </li>



                </ul>


                <?php } ?>
            </div>
        </div>
    </header>