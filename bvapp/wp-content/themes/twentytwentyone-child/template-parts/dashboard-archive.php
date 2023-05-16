<?php
/* Template Name: Owner Dashboard Archive*/
if (!is_user_logged_in() ) {
    wp_redirect( home_url('login'), 301 );
}
$user = wp_get_current_user();
$UserId = $user->ID;
if($user->roles[0]!='owner' || $user->roles[0]!='administrator'){
   // wp_redirect( home_url('/'), 301 );
}
//echo '<pre>'; print_r($user->roles[0]); echo '</pre>';exit();
get_header();
if($user->roles[0]=='owner' || $user->roles[0]=='administrator'){
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
                'post_status' => 'publish',
                'posts_per_page' => -1, 
                'orderby' => 'title', 
                'order' => 'ASC',
                // 'meta_query' => array(  
                    
                //     array(
                //         'key' => 'owner_list',
                //         'value' => $UserId,
                //         'compare' => '=',
                //     ),
                //     array(
                //         'key' => 'archive',
                //         'value' => '',
                //         'compare' => '!=',                        
                //     )
                // )
            );
            if($user->roles[0]=='owner'){
                $args['meta_query']=array(                      
                    array(
                        'key' => 'owner_list',
                        'value' => $UserId,
                        'compare' => 'LIKE',
                    ),
                    array(
                        'key' => 'archive',
                        'value' => '',
                        'compare' => '!=',                        
                    ));
            }
            if($user->roles[0]=='administrator'){
                $args['meta_query']=array(  
                                       
                    array(
                        'key' => 'archive',
                        'value' => '',
                        'compare' => '!=',                        
                    ));
            }
            $loop = new WP_Query( $args );
           if($loop->have_posts()): 
            while ( $loop->have_posts() ) : $loop->the_post(); 
            ?>
            <div class="demo-box-block tourblock<?php echo get_the_ID();?>">
                <div class="demo-title">
                    <ul class="demo-list">
                        <li>
                            <a href="javascript:Void(0);"><span class="force-item">Action</span>
                            </a>
                        </li>
                        <li class="divider" role="separator"></li>
                        <li>
                            <a href="javascript:void(0)" data-tourid=<?php echo get_the_ID();?>
                                class="restoretourfromarchive"><span class="force-item"> Restore </span>
                            </a>
                        </li>
                        <li>
                            <a href="javascript:void(0)" data-tourid=<?php echo get_the_ID();?>
                                class="deletepermanently"><span class="force-item">Delete Permanently</span>
                            </a>
                        </li>
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
<?php 
get_footer();