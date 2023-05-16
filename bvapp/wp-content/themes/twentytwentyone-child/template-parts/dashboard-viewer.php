<?php
/* Template Name: Viewer Dashboard */
if (!is_user_logged_in() ) {
    wp_redirect( home_url('login'), 301 );
}
$user = wp_get_current_user();
$UserId = $user->ID;
//echo '<pre>'; print_r($user->roles[0]); echo '</pre>';exit();
if($user->roles[0]!='viewer'){    
    wp_redirect( home_url(), 301 );
}
get_header();
if($user->roles[0]=='viewer'){?>
<section class="demo-sec-main">
    <div class="container-fluid">
        <div class="demo-inner">
            <?php 
            $args = array(  
                'post_type' => 'tours',
                'post_status' => 'publish',
                'posts_per_page' => -1, 
                'orderby' => 'title', 
                'order' => 'ASC',
                'meta_query' => array(
                array(
                        'key' => 'viewer_list',
                        'value' => $UserId,
                        'compare' => 'LIKE'
                    ),                                         
                    array(
                        'key' => 'archive',
                        'value' => '',
                        'compare' => '='                        
                    ),
                    array(
                        'key' => 'live',
                        'value' => '',
                        'compare' => '!=',                        
                    ),
                    
                )            
            );
            $loop = new WP_Query( $args );
           if($loop->have_posts()): 
            while ( $loop->have_posts() ) : $loop->the_post(); 
            ?>
            <div class="demo-box-block">
                <div class="demo-title">
                    <ul class="demo-list">
                        <li>
                            <a target="_blank" href="<?php echo get_the_permalink(); ?>"><span class="force-item">Open
                                    Tour</span>
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
                echo '<h2>No tours assigned to you</h2>';
            endif; ?>




        </div>
    </div>
</section>
<?php } ?>

<!-- Modal -->
<div class="modal fade" id="exampleModalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<div class="modal fade" id="exampleModalView" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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