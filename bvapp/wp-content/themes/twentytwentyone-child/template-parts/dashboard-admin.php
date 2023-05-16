<?php
/* Template Name: Admin Dashboard */
if (!is_user_logged_in() ) {
    wp_redirect( home_url('login'), 301 );
}
$user = wp_get_current_user();
$UserId = $user->ID;
if($user->roles[0]!='administrator'){
    wp_redirect( home_url(), 301 );
}
//echo '<pre>'; print_r($user->roles[0]); echo '</pre>';exit();
get_header();
if($user->roles[0]=='administrator'){
?>
<!-- Demo Section Start -->
<section class="demo-sec-main">
    <div class="container-fluid">
        <div class="demo-inner">
            <div class="demo-box-main-title">
                <h4 style="clear: both"><?php the_title()?></h4>
            </div>
            <hr style="margin-left: 16px">
            <?php 
            $args = array(  
                'post_type' => 'tours',                
                'posts_per_page' => -1, 
                'orderby' => 'date', 
                'order' => 'desc',
                'meta_query' => array(  
                                      
                    array(
                        'key' => 'archive',
                        'value' => '',
                        'compare' => '=',                        
                    )
                )
                
            );
            $loop = new WP_Query( $args );
           if($loop->have_posts()): 
            while ( $loop->have_posts() ) : $loop->the_post();             

            ?>
            <div class="demo-box-block tourblock<?php echo get_the_ID();?>">
                <div class="demo-title">
                    <ul class="demo-list">
                        <li>
                            <a target="_blank" href="<?php echo get_the_permalink(); ?>"><span class="force-item">Open
                                    Tour</span>
                            </a>
                        </li>
                        <li class="divider" role="separator"></li>
                        <li>
                            <?php 
                            $is_live = get_post_field( 'live');
                            if(empty($is_live)){?>
                            <a class="makeitlivetour" data-tourid=<?php echo get_the_ID();?>
                                href="javascript:void(0)"><span class="force-item"><i
                                        class="fa fa-close"></i>&nbsp;&nbsp; Live
                                </span>
                            </a>
                            <?php }else{?>

                            <a class="makeitunlivetour" data-tourid=<?php echo get_the_ID();?>
                                href="javascript:void(0)"><span class="force-item"> <i
                                        class="fa fa-check"></i>&nbsp;&nbsp; Live
                                </span>
                            </a>
                            <?php } ?>
                        </li>
                        <li class="divider" role="separator"></li>
                        <li>
                            <a data-turbolinks="false" data-bs-toggle="modal" data-tourid=<?php echo get_the_ID();?>
                                class="exampleModalEdit" data-bs-target="#exampleModalEdit"
                                href="javascript:void(0)"><span class="force-item">Edit</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-tourid=<?php echo get_the_ID();?>
                                class="senttoarchivetour"><span class="force-item">Delete</span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)">
                                <span class="force-item">Email</span>
                            </a>
                        </li>
                        <?php 
                        $google_properties_id= get_field( 'google_properties_id');
                        $google_analytics_code= get_field( 'google_analytics_code');
                        $google_analytics_status = get_post_field( 'google_analytics_status');
                        if($google_properties_id!='' && $google_analytics_code!='' && !empty($google_analytics_status)){
                        ?>
                        <li>
                            <a data-turbolinks="false" data-bs-toggle="modal" data-tourid=<?php echo get_the_ID();?>
                                class="exampleModalaViewAnalitis" data-bs-target="#exampleModalView"
                                href="javascript:void(0)"><span class="force-item">View analytics</span>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </div>
                <div class="demo-img"
                    style=" background-image: url('<?php echo get_the_post_thumbnail_url(); ?>') !important;">
                    <span class="custom-tour-title"><?php the_title(); ?></span>
                    <a href="javascript:void(0)" class="demo-edit-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 192 512">
                            <path
                                d="M96 184c39.8 0 72 32.2 72 72s-32.2 72-72 72-72-32.2-72-72 32.2-72 72-72zM24 80c0 39.8 32.2 72 72 72s72-32.2 72-72S135.8 8 96 8 24 40.2 24 80zm0 352c0 39.8 32.2 72 72 72s72-32.2 72-72-32.2-72-72-72-72 32.2-72 72z" />
                        </svg>
                    </a>
                </div>
            </div>
            <?php endwhile; 
            else:
                echo '<h2 style="margin-left: 16px">No archive tours found</h2>';
            endif; ?>




        </div>
    </div>
</section>
<?php }?>

<!-- Modal -->
<div class="modal fade" id="exampleModalEdit" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="modal-content-edit">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

        </div>
    </div>
</div>

<div class="modal fade" id="exampleModalView" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content" id="modal-content-edit">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">View analytics</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body text-center">

                <div class="spinner-border" role="status">
                    <span class="visually-hidden">Loading...</span>
                </div>
            </div>

        </div>
    </div>
</div>
<?php 
get_footer();