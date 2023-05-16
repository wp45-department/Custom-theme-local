<?php 
/*
* Creating a function to create our CPT
*/
require_once __DIR__ . '/vendor/autoload.php';

if( function_exists('acf_add_options_page') ) {
	
	acf_add_options_page(array(
		'page_title'    => 'Google anlytics settings',
		'menu_title'    => 'Google anlytics settings',
		'menu_slug'     => 'theme-general-settings',
		'capability'    => 'edit_posts',
		'redirect'      => false
	));
		
}


function custom_post_type() {
  
	// Set UI labels for Custom Post Type
		$labels = array(
			'name'                => _x( 'Tours', 'Post Type General Name', 'twentytwentyone' ),
			'singular_name'       => _x( 'Tour', 'Post Type Singular Name', 'twentytwentyone' ),
			'menu_name'           => __( 'Tours', 'twentytwentyone' ),
			'parent_item_colon'   => __( 'Parent Tour', 'twentytwentyone' ),
			'all_items'           => __( 'All Tours', 'twentytwentyone' ),
			'view_item'           => __( 'View Tour', 'twentytwentyone' ),
			'add_new_item'        => __( 'Add New Tour', 'twentytwentyone' ),
			'add_new'             => __( 'Add New', 'twentytwentyone' ),
			'edit_item'           => __( 'Edit Tour', 'twentytwentyone' ),
			'update_item'         => __( 'Update Tour', 'twentytwentyone' ),
			'search_items'        => __( 'Search Tour', 'twentytwentyone' ),
			'not_found'           => __( 'Not Found', 'twentytwentyone' ),
			'not_found_in_trash'  => __( 'Not found in Trash', 'twentytwentyone' ),
		);
		  
	// Set other options for Custom Post Type
		  
		$args = array(
			'label'               => __( 'Tours', 'twentytwentyone' ),
			'description'         => __( 'Tour news and reviews', 'twentytwentyone' ),
			'labels'              => $labels,
			// Features this CPT supports in Post Editor
			'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
			// You can associate this CPT with a taxonomy or custom taxonomy. 
			'taxonomies'          => array( 'genres' ),
			/* A hierarchical CPT is like Pages and can have
			* Parent and child items. A non-hierarchical CPT
			* is like Posts.
			*/
			'hierarchical'        => false,
			'public'              => true,
			'show_ui'             => true,
			'show_in_menu'        => true,
			'show_in_nav_menus'   => true,
			'show_in_admin_bar'   => true,
			'menu_position'       => 5,
			'can_export'          => true,
			'has_archive'         => true,
			'exclude_from_search' => false,
			'menu_icon'           => 'dashicons-admin-home',
			'publicly_queryable'  => true,
			'capability_type'     => 'post',
			'show_in_rest' => true,
	  
		);
		  
		// Registering your Custom Post Type
		register_post_type( 'tours', $args );
	  
	}
	  
	/* Hook into the 'init' action so that the function
	* Containing our post type registration is not 
	* unnecessarily executed. 
	*/
	  
	add_action( 'init', 'custom_post_type', 0 );


function wdm_add_rewrite_rules()
{
	add_rewrite_rule( '^test/([^/]+)/overview/?$','index.php?author_name=$matches[1]&wdm_overview=1','top');
}
add_action('init','wdm_add_rewrite_rules');


function add_custom_meta_boxes() {
	add_meta_box( 
		'wp_tour_zip_upload',
		'Tours Zip File',
		'wp_tour_zip_upload',
		'tours',
		'advanced',
		'high'
	) ;
}
add_action( 'add_meta_boxes', 'add_custom_meta_boxes' );

function wp_tour_zip_upload() {	
	
	wp_nonce_field( plugin_basename(__FILE__), 'wp_tour_zip_upload_nonce' );
	$html = '<p class="description">Upload your Zip here.</p>';
	$html .= '<input id="wp_tour_zip_upload" name="wp_tour_zip_upload" size="25" type="file" value="" />';

	global $post;
    $post_slug = $post->post_name;	
	$path = get_stylesheet_directory()."/tours_source/".$post_slug;
	if( file_exists($path) && $post_slug!='') {
		$html .= '<p class="description" style="position: absolute;right: 20px;top: 0;color: green;"><b>The Bundle is already uploaded</b></p>';
	}

	$filearray = get_post_meta( get_the_ID(), 'wp_tour_zip_upload', true );
	
	echo $html; 
}

function save_custom_meta_data( $id ) {
	if(is_admin()){
		if ( ! empty( $_FILES['wp_tour_zip_upload']['name'] ) ) {
			$supported_types = array( 'application/zip' );
			$arr_file_type = wp_check_filetype( basename( $_FILES['wp_tour_zip_upload']['name'] ) );
			$uploaded_type = $arr_file_type['type'];

			if ( in_array( $uploaded_type, $supported_types ) ) {			
				
				$name_file  = get_post_field( 'post_name',$id ).'.zip';                    
				$foldername= get_post_field( 'post_name',$id );
				$upload_dir = get_stylesheet_directory();                       

				$filename = wp_unique_filename( $user_dirname, $_FILES['file']['name'] );
				move_uploaded_file($_FILES['wp_tour_zip_upload']['tmp_name'], $upload_dir .'/tours_source/'. $name_file);
				// save into database $upload_dir['baseurl'].'/product-images/'.$filename;
				
				if (!file_exists($upload_dir .'/tours_source/'.$foldername)) {                
					mkdir($upload_dir .'/tours_source/'.$foldername, 0777, true);                
				}
				sleep(5);
				WP_Filesystem();
				$destination = wp_upload_dir();
				$destination_path = $destination['path'];
				$unzipfile = unzip_file( $upload_dir .'/tours_source/'. $name_file, $upload_dir .'/tours_source/'.$foldername);

				if ( $unzipfile ) {
					echo 'Successfully unzipped the file!';       
				} else {
					echo 'There was an error unzipping the file.';       
				}			
				
			}
			else {
				//wp_die( "The file type that you've uploaded is not a Zip." );
			}
		}
	}
}
add_action( 'save_post', 'save_custom_meta_data' );

function update_edit_form() {
	echo ' enctype="multipart/form-data"';
}
add_action( 'post_edit_form_tag', 'update_edit_form' );
function child_enqueue_styles() {

	// dequeue the Twenty Twenty-One parent style
	wp_dequeue_style( 'twenty-twenty-one-style' );
	
	// Theme stylesheet
	wp_enqueue_style( 'child-style', get_stylesheet_uri(), array(), wp_get_theme()->get('Version') );

}
add_action( 'wp_enqueue_scripts', 'child_enqueue_styles', 11 );

add_action("wp_ajax_owner_user_login", "owner_user_login");
add_action("wp_ajax_nopriv_owner_user_login", "owner_user_login");

function owner_user_login() {
	if ( empty( $credentials ) ) {
		$credentials = array(); 
		if ( ! empty( $_POST['email'] ) ) {
			$credentials['user_login'] = wp_unslash( $_POST['email'] );
		}
		if ( ! empty( $_POST['password'] ) ) {
			$credentials['user_password'] = $_POST['password'];
		}
		if ( ! empty( $_POST['rememberme'] ) ) {
			$credentials['remember'] = $_POST['rememberme'];
		}
	}
	if ( ! empty( $credentials['remember'] ) ) {
		$credentials['remember'] = true;
	} else {
		$credentials['remember'] = false;
	}    
	$user = wp_signon( $credentials, false );
	
	if ( is_wp_error( $user ) ) {		
		echo $user->get_error_message();exit;
	}else{        
		if($user->roles[0]=='administrator'){
			echo 1;exit;
		}	
		if($user->roles[0]=='owner'){
			echo 2;exit;
		}
		if($user->roles[0]=='viewer'){
			echo 3;exit;
		}
	}
}


add_action("wp_ajax_owner_user_register", "owner_user_register");
add_action("wp_ajax_nopriv_owner_user_register", "owner_user_register");

function owner_user_register() {
	$email = $_POST['email'];
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$password = $_POST['password'];
	$conf_password = $_POST['conf_password'];
	$usertype = $_POST['usertype'];

	if (email_exists( $email ) ) {
		echo 'User already exists';exit;
	}
	if($password!= $conf_password){
		echo 'Password and Confirm not match';exit;
	}
	
	$user_id = wp_create_user( $email, $password, $email );
	if ( is_wp_error( $result ) ) {
		echo $user->get_error_message();exit;
	}else{ 
		$user = get_user_by( 'id', $user_id );
		$user->remove_role( 'subscriber' ); 
		$user->set_role( 'viewer' );  
		// if($usertype==1){
		// 	$user->set_role( 'owner' );  
		// }else{
		// 	$user->set_role( 'viewer' );  
		// }   		
		wp_update_user( array ('ID' => $user_id, 'display_name' => $first_name.' '.$last_name,'first_name' => $first_name,'last_name' => $last_name));        
		echo 1;exit;
	}
}

function custom_fun_restrict_admin() {
	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return;
	}
	if ( ! current_user_can( 'manage_options' ) ) {
		wp_redirect( home_url() );
		exit;
	}
}
add_action( 'admin_init', 'custom_fun_restrict_admin', 1 );

add_action("wp_ajax_tour_edit_ajax", "tour_edit_ajax_fun");
add_action("wp_ajax_nopriv_tour_edit_ajax", "tour_edit_ajax_fun");

function tour_edit_ajax_fun() {
	$user = wp_get_current_user();
	$tourid = $_POST['tourid'];
	$logo= get_field('logo',$tourid); 
	$tour_type= get_field('tour_type',$tourid); 
	$info_below_logo= get_field('info_below_logo',$tourid); 
	$tag_lines_and_name= get_field('tag_lines_and_name',$tourid); 
	$tv_video_url= get_field('tv_video_url',$tourid); 
	$bottom_logo= get_field('bottom_logo',$tourid); 
	$bottom_disclaimer_text= get_field('bottom_disclaimer_text',$tourid); 
	$feature_image= get_the_post_thumbnail_url($tourid);
	$google_analytics_code= get_field('google_analytics_code',$tourid);
	$google_properties_id= get_field('google_properties_id',$tourid);
	$owner_list= get_field('owner_list',$tourid);	
	$viewer_list= get_field('viewer_list',$tourid);
	$args = array('role'    => 'owner','orderby' => 'user_nicename','order'   => 'ASC');
	$users_owner_list = get_users( $args );
	$args_views = array('role'    => 'viewer','orderby' => 'user_nicename','order'   => 'ASC');
	$users_viewer_list = get_users( $args_views );
?>
<form class="edti-tour-form-byowner" id="edti-tour-form-byowner" method="post" enctype="multipart/form-data">
    <input type="hidden" value="<?php echo $tourid;?>" name="tourid">
    <input type="hidden" value="<?php echo $tour_type;?>" name="tour_type">
    <input type="hidden" value="update_tour_form_byowner" name="action">

    <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit : <?php echo get_the_title($tourid);?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="exampleInputEmail1"><strong>Logo</strong></label>
                    <input type="file" class="form-control" name="logo">
                </div>
                <div class="col-sm-6">
                    <label for="exampleInputEmail1">Preview</label><br>
                    <img width="150" src="<?php echo $logo;?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="exampleInputEmail1"><strong>Feature Image</strong></label>
                    <input type="file" class="form-control" name="feature_image">
                </div>
                <div class="col-sm-6">
                    <label for="exampleInputEmail1">Preview</label><br>
                    <img width="150" src="<?php echo $feature_image;?>">
                </div>
            </div>
        </div>
        <div class="form-group">
            <hr />
            <?php if($tour_type==1){ ?>
            <label><strong>Tag line</strong></label>
            <textarea class="form-control" name="info_below_logo"><?php echo $info_below_logo; ?></textarea>
            <?php }else{?>
            <label><strong>Tag Lines and Name</string></label>

            <div class="row">
                <?php
				if($tag_lines_and_name){
				foreach ($tag_lines_and_name as $key => $value) {?>
                <div class="col-sm-6">
                    <label>Tour Name</label>
                    <input type="text" class="form-control" name="tour_name[]" required
                        value="<?php echo $value['tour_name']; ?>">
                </div>
                <div class="col-sm-6">
                    <label>Tour Tag line</label>
                    <textarea class="form-control" name="tour_tag_line[]"
                        required><?php echo $value['tour_tag_line']; ?></textarea>
                </div>
                <?php } ?>
                <?php } ?>
            </div>
            <?php } ?>
        </div>
        <div class="form-group">
            <hr />
            <label><strong>Tv videos and thumbnails</strong></label>

            <div class="row">
                <?php if($tv_video_url){
				 foreach ($tv_video_url as $key => $value) {
					$getfiletype= explode('.',$value['video']);  
				 ?>
                <div class="col-sm-2 removevideogrp<?php echo $key; ?> position-relative">
                    <input type="hidden" name="tv_video_url[]"
                        value="<?php echo attachment_url_to_postid($value['video']);?>">
                    <label for="exampleInputEmail1">Preview</label><br>
                    <?php if(end($getfiletype)!='mp4'){ ?>
                    <img width="100" height="100" src="<?php echo $value['video'];?>">
                    <?php }else{ ?>
                    <video width="100" height="100" class="src_url" src="<?php echo $value['video'];?>"
                        id="brick<?php echo $key; ?>" crossorigin="anonymous" autoplay muted loop>
                    </video>
                    <?php } ?>
                    <a href="javascript:void(0);" class="removevideojs" data-group="<?php echo $key; ?>"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-trash text-danger" viewBox="0 0 16 16">
                            <path
                                d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z" />
                            <path fill-rule="evenodd"
                                d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z" />
                        </svg>
                    </a>
                </div>

                <?php  }  ?>
                <?php } ?>
                <div class="col-sm-12">

                    <label class="pt-2" for="exampleInputEmail1">Add more</label>
                    <input type="file" class="form-control" name="tv_video_url_new[]" multiple>
                </div>
            </div>
            <hr />
        </div>
        <div class="form-group">
            <div class="row">
                <div class="col-sm-6">
                    <label for="exampleInputEmail1"><strong>Bottom logo</strong></label>
                    <input type="file" class="form-control" name="bottom_logo">
                </div>
                <div class="col-sm-6">
                    <label for="exampleInputEmail1">Preview</label><br>
                    <img width="150" src="<?php echo $bottom_logo;?>">
                </div>
            </div>
        </div>

        <div class="form-group">
            <label><strong>Bottom disclaimer text</strong></label>
            <textarea class="form-control"
                name="bottom_disclaimer_text"><?php echo $bottom_disclaimer_text;?></textarea>
        </div>
        <?php if($user->roles[0]=='administrator'){			
		?>
        <div class="form-group">
            <label><strong>Google Analytics code</strong></label>
            <input type="text" class="form-control" name="google_analytics_code"
                value="<?php echo $google_analytics_code;?>">
        </div>
        <div class="form-group">
            <label><strong>Google Properties ID</strong></label>
            <input type="text" class="form-control" name="google_properties_id"
                value="<?php echo $google_properties_id;?>">
        </div>
        <div class="form-group modal-owner-listnew">
            <label class="form-label font-weight-bold" for="form6Example5"><b>Owner List</b></label>
            <select class="form-control" id="owner_listnew" name="owner_list[]" multiple>
                <?php 
                           foreach ($users_owner_list as $key => $users_value) {							
                            ?>
                <option value="<?php echo $users_value->ID;?>"
                    <?php if(in_array($users_value->ID,$owner_list)){ echo'selected'; } ?>>
                    <?php echo $users_value->display_name;?> (<?php echo $users_value->user_email; ?>)
                </option>
                <?php } ?>
            </select>
        </div>
        <?php } ?>

        <div class="form-group modal-viewer-listnew">
            <label class="form-label font-weight-bold" for="form6Example5"><b>Viewer List</b></label>
            <select class="form-control" id="viewer_listnew" name="viewer_list[]" multiple>
                <?php 
                            foreach ($users_viewer_list as $key => $users_viewer) {
                             ?>
                <option value="<?php echo $users_viewer->ID;?>"
                    <?php if(in_array($users_viewer->ID,$viewer_list)){ echo'selected'; } ?>>
                    <?php echo $users_viewer->display_name;?> (<?php echo $users_viewer->user_email; ?>)
                </option>
                <?php } ?>
            </select>
        </div>
        </script>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary">Save changes</button>
    </div>
</form>

<?php
exit;
}
function cc_mime_types($mimes) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
  }
add_filter('upload_mimes', 'cc_mime_types');

  
add_action("wp_ajax_update_tour_form_byowner", "update_tour_form_byowner_fun");
add_action("wp_ajax_nopriv_update_tour_form_byowner", "update_tour_form_byowner_fun");
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

function update_tour_form_byowner_fun() {
		
	$tourid = $_POST['tourid'];
	$tour_type = $_POST['tour_type'];
	$logo = $_POST['logo'];
	$feature_image = $_POST['feature_image'];
	$info_below_logo = $_POST['info_below_logo'];
	$tour_name = $_POST['tour_name'];
	$tour_tag_line = $_POST['tour_tag_line'];
	$tv_video_url = $_POST['tv_video_url'];
	$tv_video_url_new = $_POST['tv_video_url_new'];
	$bottom_logo = $_POST['bottom_logo'];
	$bottom_disclaimer_text = $_POST['bottom_disclaimer_text'];
	$google_analytics_code = $_POST['google_analytics_code'];
	$google_properties_id = $_POST['google_properties_id'];
	$owner_list = $_POST['owner_list'];
	$viewer_list = $_POST['viewer_list'];
	
	
	
	if($info_below_logo){
		update_field('info_below_logo', $info_below_logo, $tourid);
	}
	if($bottom_disclaimer_text){
		update_field('bottom_disclaimer_text', $bottom_disclaimer_text, $tourid);
	}

	
		update_field('google_analytics_code', $google_analytics_code, $tourid);
	
	
		update_field('google_properties_id', $google_properties_id, $tourid);
		if($owner_list){
			update_field('owner_list', $owner_list, $tourid);
		}
		if($viewer_list){
			update_field('viewer_list', $viewer_list, $tourid);
		}
	

	if($tour_name){
		if(count($tour_name)){
			$name_row=array();
			foreach ($tour_name as $key => $tour_name_value) {
				$single=array();
				$single['tour_name'] = $tour_name_value;
				$single['tour_tag_line'] = $tour_tag_line[$key];
				$name_row[] = $single;
			}
			if($name_row){
				update_field('tag_lines_and_name', $name_row , $tourid);
			}    
		}
	}
	
	if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!=''){
		
	$logo_filename= $_FILES['logo']['name'];
	$logo_file=wp_upload_bits($logo_filename, null, file_get_contents($_FILES['logo']['tmp_name']));      
		if ($logo_file['error'] === false) {            
			$attachment = array(
				'post_mime_type' => $logo_file['type'],
				'post_title' => $logo_filename,
				'post_content' => '',
				'post_status' => 'inherit'
			);        
			$attach_id = wp_insert_attachment($attachment, $logo_file['file']);        
			$attach_data = wp_generate_attachment_metadata($attach_id, $logo_file['file']);
			wp_update_attachment_metadata($attach_id, $attach_data);
			update_field('logo', $attach_id, $tourid);
		}
	}

	if(isset($_FILES['feature_image']['name']) && $_FILES['feature_image']['name']!=''){		
		$feature_image_filename= $_FILES['feature_image']['name'];
		$feature_image_file=wp_upload_bits($feature_image_filename, null, file_get_contents($_FILES['feature_image']['tmp_name']));      
			if ($feature_image_file['error'] === false) {            
				$attachment = array(
					'post_mime_type' => $feature_image_file['type'],
					'post_title' => $feature_image_filename,
					'post_content' => '',
					'post_status' => 'inherit'
				);        
				$attach_id = wp_insert_attachment($attachment, $feature_image_file['file']);        
				$attach_data = wp_generate_attachment_metadata($attach_id, $feature_image_file['file']);
				wp_update_attachment_metadata($attach_id, $attach_data);
				set_post_thumbnail( $tourid, $attach_id );						
			}
	}
	
	if(isset($_FILES['bottom_logo']['name']) && $_FILES['bottom_logo']['name']!=''){
		$bottom_logo_filename= $_FILES['bottom_logo']['name'];
		$bottom_logo_file=wp_upload_bits($bottom_logo_filename, null, file_get_contents($_FILES['bottom_logo']['tmp_name']));              
		if ($bottom_logo_file['error'] === false) {            
			$attachment = array(
				'post_mime_type' => $bottom_logo_file['type'],
				'post_title' => $bottom_logo_filename,
				'post_content' => '',
				'post_status' => 'inherit'
			);        
			$attach_id = wp_insert_attachment($attachment, $bottom_logo_file['file']);        
			$attach_data = wp_generate_attachment_metadata($attach_id, $bottom_logo_file['file']);
			wp_update_attachment_metadata($attach_id, $attach_data);
			update_field('bottom_logo', $attach_id, $tourid);
		}
	}


	
	if(isset($_FILES['tv_video_url_new']['name'][0]) && $_FILES['tv_video_url_new']['name'][0]!=''){
		
		$countfiles = count($_FILES['tv_video_url_new']['name']);
		
		$multi_attac_id = array();
		if($countfiles){    
			for($i=0;$i<$countfiles;$i++){
				$tv_video_url_new_filename= $_FILES['tv_video_url_new']['name'][$i];
				$tv_video_url_new_file=wp_upload_bits($tv_video_url_new_filename, null, file_get_contents($_FILES['tv_video_url_new']['tmp_name'][$i]));              
				if ($tv_video_url_new_file['error'] === false) {            
					$attachment = array(
						'post_mime_type' => $tv_video_url_new_file['type'],
						'post_title' => $tv_video_url_new_filename,
						'post_content' => '',
						'post_status' => 'inherit'
					);        
					$attach_id = wp_insert_attachment($attachment, $tv_video_url_new_file['file']);        
					$attach_data = wp_generate_attachment_metadata($attach_id, $tv_video_url_new_file['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);                
					$multi_attac_id[]['video']=$attach_id;
				}        
			}
		}
		if($tv_video_url){             
			foreach ($tv_video_url as $key => $value) {
				$multi_attac_id[]['video']=$value;
			}         
		}
		update_field('tv_video_url', $multi_attac_id , $tourid);
	}
	echo 1;    
	exit;
}


add_action( 'add_meta_boxes', 'add_custom_box_wpse_94701' );
add_action( "admin_print_scripts-post.php", 'enqueue_ajax_wpse_97845' );
add_action( 'wp_ajax_update_metabox_wpse_97845', 'update_metabox_wpse_97845' );

function add_custom_box_wpse_94701() 
{
	add_meta_box(
		'sectionid_wpse_94701',
		__( 'Tours Duplicate' ), 
		'copy_post_box_wpse_94701',
		'tours',
		'side'
	);
}

function copy_post_box_wpse_94701() 
{
	global $wpdb,$post;    
	echo '<table style="width: 100%;">
	   <tr>
		<td><lable><b>Title</b></lable><br/><input style="width: 100%" type="text" value="" name="dup_post_title"></td>
	   </tr> 
	   <tr>
		<td><lable><b>Slug</b></lable><br/><input style="width: 100%" type="text" value="" name="dup_post_slug"></td>
	   </tr> 
	</table><br/>';
	echo "<a class='button-secondary' href='#' title='Duplicate post' style='padding-top:4px;' id='publish-to-other-blog' name='$post->ID'>Duplicate</a>&nbsp; <span class='spinner sp-show-spinner'></span>";

	// Error and success messages
	echo '<div class="updated below-h2" id="ajax-success" style="display:none">updated</div>';
	echo '<div class="form-invalid" id="ajax-error" style="display:none">form-invalid</div>';
	echo '<p>When you want to duplicate the entire tour with a different name and url then here add new name and slug here. if a slug exists then you will not duplicate it.</p>';


}

function enqueue_ajax_wpse_97845()
{
	// Check post type
	global $typenow;
	if( 'tours' != $typenow )
		return;

	wp_enqueue_script( 'wpse_97845_js', get_stylesheet_directory_uri( '/', __FILE__ ) . '/assets/js/mu-copy-post.js' );

	wp_localize_script( 
			'wpse_97845_js', 
			'wp_ajax', 
			array( 
				'ajaxurl' => admin_url( 'admin-ajax.php' ),
				'ajaxnonce' => wp_create_nonce( 'wpse_97845_validation' )
			) 
	); 
}

function update_metabox_wpse_97845()
{
	check_ajax_referer( 'wpse_97845_validation', 'ajaxnonce' );

	if( empty( $_POST['wpse_97845_post_id'] ) || empty( $_POST['wpse_97845_post_id'] ) ) {
		wp_send_json_error( array(
			'error' => __( 'Tour ID not set' ) 
		));
	}

	// Grac actual post data and current blog ID
	$actual_post = $_POST['wpse_97845_post_id'] ;
	$new_post_title =  $_POST['wpse_97845_tour_title'] ;
	$new_post_slug =  $_POST['wpse_97845_tour_slug'] ;
	global $wpdb;
	$post_if = $wpdb->get_var("SELECT count(post_title) FROM $wpdb->posts WHERE post_name like '".$new_post_slug."'");
	if($post_if>=1){
		wp_send_json_success( "Tour slug already exists" );   
		exit;         
	}
	$thumbnail_id = get_post_thumbnail_id($actual_post);
	$meta = get_post_meta($actual_post);
	

	// Prepare cloned post
	$copy_post = array(
	  'post_title' => $new_post_title,
	  'post_name' => $new_post_slug,
	  'post_content' => '',
	  'post_status' => 'draft',
	  'post_type' => 'tours'
	);
	$post_id = wp_insert_post($copy_post);    
	foreach ($meta as $key => $value) {
		add_post_meta($post_id, $key, $value[0] );
	}
	if($thumbnail_id){
		set_post_thumbnail( $post_id, $thumbnail_id );
	}   
	$foldername = get_post_field( 'post_name', $actual_post );
	$upload_dir = get_stylesheet_directory();                       
	$target_src= $upload_dir .'/tours_source/'.$foldername;
	$destination_src= $upload_dir .'/tours_source/'.$new_post_slug;
	if (!file_exists($upload_dir .'/tours_source/'.$new_post_slug)) {                
		mkdir($upload_dir .'/tours_source/'.$new_post_slug, 0777, true);                
	}
	custom_copy($target_src,$destination_src);
	$blog_name = get_option( 'blogname' );    
	wp_send_json_success( "Tour added to $blog_name with the ID of $post_id" );
	


	exit;
	
}

function custom_copy($src, $dst) {   
	// open the source directory
	$dir = opendir($src);   
	// Make the destination directory if not exist
	@mkdir($dst); 
	// Loop through the files in source directory
	while( $file = readdir($dir) ) { 
		if (( $file != '.' ) && ( $file != '..' )) { 
			if ( is_dir($src . '/' . $file) ) 
			{                 
				custom_copy($src . '/' . $file, $dst . '/' . $file);  
			} 
			else { 
				copy($src . '/' . $file, $dst . '/' . $file); 
			} 
		} 
	}   
	closedir($dir);
} 


add_action("wp_ajax_tour_sent_to_archive_ajax", "tour_sent_to_archive_ajax_fun");
add_action("wp_ajax_nopriv_tour_sent_to_archive_ajax", "tour_sent_to_archive_ajax_fun");
function tour_sent_to_archive_ajax_fun() {
	$tourid = $_POST['tourid'];
	update_field('archive', 1, $tourid);
	exit;
}

add_action("wp_ajax_tour_sent_to_restore_ajax", "tour_sent_to_restore_ajax_fun");
add_action("wp_ajax_nopriv_tour_sent_to_restore_ajax", "tour_sent_to_restore_ajax_fun");
function tour_sent_to_restore_ajax_fun() {
	echo $tourid = $_POST['tourid'];
	update_field('archive', '', $tourid); 
	exit;
}

function rrmdir($dir) {
	if (is_dir($dir)) {
	  $objects = scandir($dir);
	  foreach ($objects as $object) {
		if ($object != "." && $object != "..") {
		  if (filetype($dir."/".$object) == "dir") 
			 rrmdir($dir."/".$object); 
		  else unlink   ($dir."/".$object);
		}
	  }
	  reset($objects);
	  rmdir($dir);
	}
   }

add_action("wp_ajax_tour_sent_to_deletepermanently_ajax", "tour_sent_to_deletepermanently_ajax_fun");
add_action("wp_ajax_nopriv_tour_sent_to_deletepermanently_ajax", "tour_sent_to_deletepermanently_ajax_fun");
function tour_sent_to_deletepermanently_ajax_fun() {
	$tourid = $_POST['tourid'];
	$post_id = 45; //specify post id here
	$tours = get_post($tourid); 
	$slug = $tours->post_name;
	$upload_dir = get_stylesheet_directory(); 
	$upload_dir .'/tours_source/'.$slug; 
	rrmdir($upload_dir .'/tours_source/'.$slug);	
	wp_delete_post($tourid, true); 	
	exit;
}

add_action("wp_ajax_tour_sent_to_live_ajax", "tour_sent_to_live_ajax_fun");
add_action("wp_ajax_nopriv_tour_sent_to_live_ajax", "tour_sent_to_live_ajax_fun");
function tour_sent_to_live_ajax_fun() {
	$tourid = $_POST['tourid'];
	update_field('live', 1, $tourid);
	exit;
}

add_action("wp_ajax_tour_sent_to_deactive_ajax", "tour_sent_to_deactive_ajax_fun");
add_action("wp_ajax_nopriv_tour_sent_to_deactive_ajax", "tour_sent_to_deactive_ajax_fun");
function tour_sent_to_deactive_ajax_fun() {
	echo $tourid = $_POST['tourid'];
	update_field('live', '', $tourid); 
	exit;
}

add_action( 'rest_api_init', 'register_rest_route_garoute');
function register_rest_route_garoute() {
	add_filter( 'rest_authentication_errors', '__return_true' );
	register_rest_route(
		'gareport', 'notify',
		array(
			'methods' => ['GET','POST'],
			'callback' => 'my_callback_function_gar',
			'permission_callback' => '__return_true',
			'rest_authentication_errors' => '__return_true',
		)
	);
}
function my_callback_function_gar(WP_REST_Request $request){    
	
	$access_token= get_field( 'access_token','option' );
	$request = "https://www.googleapis.com/oauth2/v1/tokeninfo?"
			  . "access_token=" . $access_token;

	  $ch = curl_init();
	  curl_setopt($ch, CURLOPT_URL, $request);
	  curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
	  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	  $response = curl_exec($ch);
	  $result = json_decode($response);
			   
	if (isset($result->error) && $result->error) {
	$credentials = json_decode(file_get_contents(get_template_directory() . '-child/client_secrets.json'), true);
	
		  $url = 'https://accounts.google.com/o/oauth2/token';
		  $header = array("content-type: application/json");
		  $clientId = $credentials['web']['client_id'];
		  $clientSecret = $credentials['web']['client_secret'];
		  
		  $data = [
			  "access_type" => 'refresh_token',
			  "redirect_uri" => site_url().'/wp-json/gareport/notify',
			  'grant_type' => 'authorization_code',
			  "client_id" => $clientId,
			  'client_secret' => $clientSecret,
			  'code' => $_REQUEST['code'],
		  ];

		  $postData = json_encode($data);
		  $ch = curl_init();
		  curl_setopt_array($ch, array(
			  CURLOPT_URL => $url, //esc_url($curl_url),
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_TIMEOUT => 0,
			  CURLOPT_HTTPHEADER => $header,
			  CURLOPT_POSTFIELDS => $postData
		  ));
		  $response = curl_exec($ch);
		  $response = json_decode($response);
		  update_field('access_token', $response->access_token, 'option');    
		  //echo '<pre>'; print_r( $response); echo '</pre>';exit();
		  //echo  $response->access_token;
		}  
	
		wp_redirect( home_url().'/dashboard' );
		exit();

}

add_action("wp_ajax_tour_google_analytic", "tour_google_analytic_fun");
add_action("wp_ajax_nopriv_tour_google_analytic", "tour_google_analytic_fun");
function tour_google_analytic_fun() {
	$tourid = $_POST['tourid'];
	$start = isset($_POST['start'])?$_POST['start']:'365daysAgo';
	$end = isset($_POST['end'])?$_POST['end']:'today';	
	'<h2>'.get_the_title($tourid).'</h2><br/>';
	$property_id= get_field( 'google_properties_id',$tourid);
	getPropertyReport($property_id,$start,$end);
	exit;
}

function getPropertyReport($property_id,$startDate,$endDate){
  $final_array=array();  
  $Lastyear = date('Y') - 1; $LastYearstartDate=$Lastyear."-01-01"; $LastYearendDate = $Lastyear."-12-31";
  $CurentYearstartDate=date('Y')."-01-01";	$CurentYearendDate='today';
  if($startDate!='365daysAgo'){ $LastYearstartDate=date('Y-m-d', strtotime($startDate. ' - 1 years')); $CurentYearstartDate=$startDate; }
  if($endDate!='today'){ $LastYearendDate=date('Y-m-d', strtotime($endDate. ' - 1 years'));  $CurentYearendDate=$endDate; }
  $access_token= get_field( 'access_token','option' );
	$header = array("Authorization: Bearer $access_token", "content-type: application/json");     
	$data = [
		"requests" => [
			  [
				 "dateRanges" => [
					[
					   "startDate" => $LastYearstartDate, 
					   "endDate" => $LastYearendDate 
					] 
				 ], 
				 "keepEmptyRows"=> true,
				 "metrics" => [ 
							 [ "name" => "screenPageViews"],                                 
							 [ "name" => "totalUsers"],
							 [ "name" => "newUsers"],
							 [ "name" => "sessions"],
							 [ "name" => "averageSessionDuration"],
																						
						 ]
			  ],
			  [
				"dateRanges" => [
				[
					"startDate" => $CurentYearstartDate, 
					"endDate" => $CurentYearendDate
				] 
				], 
				
				"limit"=>10,                    
				
				"metrics" => [
						[ "name" => "screenPageViews"],                                   
						[ "name" => "totalUsers"],
						[ "name" => "newUsers"], 
						[ "name" => "sessions"],
						[ "name" => "averageSessionDuration"],
				]
				],
				[
					"dateRanges" => [	
						[
							"startDate" => $startDate, 
							"endDate" => $endDate
						] 
						], 
						"limit"=> 12,
						"keepEmptyRows"=>true,     
						"dimensions" => [
							[ "name" => "sessionCampaignName"],                         
						],
						"metrics" => [                                                      
							[ "name" => "totalUsers"],                                      
						]
				],
		   ] 
	 ]; 
  
  
	$ch = curl_init();
	curl_setopt_array($ch, array(
	CURLOPT_URL => 'https://analyticsdata.googleapis.com/v1beta/properties/'.$property_id.':batchRunReports',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_HTTPHEADER => $header,
	CURLOPT_POSTFIELDS =>json_encode($data),   

	));
	$response = curl_exec($ch);
	$ga4_properties = json_decode($response,true);
	
	if(isset($ga4_properties['error'])){
		if(isset($ga4_properties['error']['code']) && $ga4_properties['error']['code']==401){
			$client = new Google_Client();            
			$client->setAuthConfig(get_template_directory() . '-child/client_secrets.json');
			$client->setRedirectUri(site_url().'/wp-json/gareport/notify');
			$client->addScope(Google_Service_Analytics::ANALYTICS_READONLY);
			echo $auth_url = $client->createAuthUrl();exit;            
		}
	}
	//echo '<pre>'; print_r($ga4_properties); echo '</pre>';exit();
	$resultDate= array(); $CampainDefultsSource = []; $CampainSource = []; $CampainMedium = []; $CampainName=[];
	if($ga4_properties){
		foreach ($ga4_properties['reports'] as $key1 => $valuereports) {
			foreach ($valuereports['metricHeaders'] as $key => $value) {
				$resultDate[$value['name']][$key1]   =  $valuereports['rows'][0]['metricValues'][$key]['value'];
			}
		}

		if(isset($ga4_properties['reports'][2]['rows'])){
				
			foreach ($ga4_properties['reports'][2]['rows'] as $key1 => $valuereports) {            
				$CampainName[$valuereports['dimensionValues'][$key1]['value']] = ($valuereports['metricValues'][$key1]['value']);
			}

		}
	}
	$final_array['resultDate']=($resultDate)?$resultDate:0;
	

	// New and Returning user
	$data = [
		"requests" => [
			  [
				"dateRanges" => [
					[
						"startDate" => $startDate, 
						"endDate" => $endDate
					] 
				 ], 
				 "keepEmptyRows"=> true,
				 "dimensions" => [ 
					[ "name" => "newVsReturning"],                        
																			   
				 ],
				 "metrics" => [                              
							 [ "name" => "averageSessionDuration"],
																						
						 ]
				 ],
				 [
					"dateRanges" => [
						[
							"startDate" => $startDate, 
							"endDate" => $endDate
						] 
					 ], 
					 "limit"=> 12,
					 "keepEmptyRows"=> true,
					 "dimensions" => [ 
						[ "name" => "month"],                        
																				   
					 ],
					 "metrics" => [                              
							[ "name" => "screenPageViews"],
							[ "name" => "totalUsers"],                                                                                                
					  ]
				],
					 
				[
				"dateRanges" => [
					[
						"startDate" => $startDate, 
							"endDate" => $endDate
					] 
					], 
					"limit"=> 12,
					"keepEmptyRows"=>true,     
					"dimensions" => [
						[ "name" => "sessionDefaultChannelGroup"],                         
				   ],
					"metrics" => [                                                      
						[ "name" => "totalUsers"],                                      
					]
					],
					[
					"dateRanges" => [	
						[
							"startDate" => $startDate, 
							"endDate" => $endDate
						] 
						], 
						"limit"=> 12,
						"keepEmptyRows"=>true,     
						"dimensions" => [
							[ "name" => "sessionSource"],                         
						],
						"metrics" => [                                                      
							[ "name" => "totalUsers"],                                      
						]
					],

					[
					"dateRanges" => [	
						[
							"startDate" => $startDate, 
							"endDate" => $endDate
						] 
						], 
						"limit"=> 12,
						"keepEmptyRows"=>true,     
						"dimensions" => [
							[ "name" => "sessionMedium"],                         
						],
						"metrics" => [                                                      
							[ "name" => "totalUsers"],                                      
						]
						],
						
					
						
			
		   ] 
	 ]; 
  
	$ch = curl_init();
	curl_setopt_array($ch, array(
	CURLOPT_URL => 'https://analyticsdata.googleapis.com/v1beta/properties/'.$property_id.':batchRunReports',
	CURLOPT_RETURNTRANSFER => true,
	CURLOPT_TIMEOUT => 0,
	CURLOPT_HTTPHEADER => $header,
	CURLOPT_POSTFIELDS =>json_encode($data),   

	));
	$response = curl_exec($ch);
	$ga4_properties_new_return_urs = json_decode($response,true);
 //  echo '<pre>'; print_r($ga4_properties_new_return_urs); echo '</pre>';exit();

	  
  $resultDateUR= array();
	if($ga4_properties_new_return_urs){
		if(isset($ga4_properties_new_return_urs['reports'][0]['rows'])){
			foreach ($ga4_properties_new_return_urs['reports'][0]['rows'] as $key1 => $valuereports) {            
				$resultDateUR[$valuereports['dimensionValues'][0]['value']] = number_format($valuereports['metricValues'][0]['value'],2);
			}
		}
		if(isset($ga4_properties_new_return_urs['reports'][1]['rows'])){
			$screenPageViews = [];
			$totalUsers = [];
			for ($i = 0; $i < 12; $i++) {
				$month = date("m", strtotime( date( 'Y-m-01' )." -$i months"));
				$screenPageViews['m_'.$month] = 0;
				$totalUsers['m_'.$month] = 0;
			}
			foreach ($ga4_properties_new_return_urs['reports'][1]['rows'] as $key1 => $valuereports) {            
				$screenPageViews['m_'.$valuereports['dimensionValues'][0]['value']] = $valuereports['metricValues'][0]['value']  ;
				$totalUsers['m_'.$valuereports['dimensionValues'][0]['value']] = $valuereports['metricValues'][1]['value']  ;
			}
		}
		
		if(isset($ga4_properties_new_return_urs['reports'][2]['rows'])){
				
			foreach ($ga4_properties_new_return_urs['reports'][2]['rows'] as $key1 => $valuereports) {            
				$CampainDefultsSource[$valuereports['dimensionValues'][$key1]['value']] = ($valuereports['metricValues'][$key1]['value']);
			}

		}

		if(isset($ga4_properties_new_return_urs['reports'][3]['rows'])){
				
			foreach ($ga4_properties_new_return_urs['reports'][3]['rows'] as $key1 => $valuereports) {            
				$CampainSource[$valuereports['dimensionValues'][$key1]['value']] = ($valuereports['metricValues'][$key1]['value']);
			}

		}

		if(isset($ga4_properties_new_return_urs['reports'][4]['rows'])){
				
			foreach ($ga4_properties_new_return_urs['reports'][4]['rows'] as $key1 => $valuereports) {            
				$CampainMedium[$valuereports['dimensionValues'][$key1]['value']] = ($valuereports['metricValues'][$key1]['value']);
			}

		}

		

		
	}
	$final_array['screenPageViews']=($screenPageViews)?array_reverse($screenPageViews):0;
	$final_array['totalUsers']=($totalUsers)?array_reverse($totalUsers):0;
	$final_array['resultDateUR']=($resultDateUR)?array_reverse($resultDateUR):'';
	$final_array['CampainDefultsSource']=($CampainDefultsSource)?array_reverse($CampainDefultsSource):'';
	$final_array['CampainSource']=($CampainSource)?array_reverse($CampainSource):'';
	$final_array['CampainMedium']=($CampainMedium)?array_reverse($CampainMedium):'';
	$final_array['CampainName']=($CampainName)?array_reverse($CampainName):'';
	$final_array['startDate']=($startDate=='365daysAgo')?date('m/d/Y'):date('m/d/Y',strtotime($startDate));
	$final_array['endDate']=($endDate=='today')?date('m/d/Y'):date('m/d/Y',strtotime($endDate));
	//echo '<pre>'; print_r($final_array); echo '</pre>';exit();
	echo json_encode($final_array,true);
	
}

add_action("wp_ajax_update_profile_data", "update_profile_data_fun");
add_action("wp_ajax_nopriv_update_profile_data", "update_profile_data_fun");
/*
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);*/

function update_profile_data_fun() {

	$user = wp_get_current_user();
	$user_id = $user->ID;
	$user_email = $user->user_email;
	$user_first_name = $user->first_name;
	$user_last_name = $user->last_name;
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];
	$current_password = $_POST['current_password'];
	$conf_password = $_POST['conf_password'];
	$password = $_POST['password'];


	$pass = wp_check_password($current_password, $user->user_pass, $user_id);	
	$exists = email_exists($email);	
	if(empty($exists) ) {
		wp_update_user( array ('ID' => $user_id, 'user_email' => esc_attr( $email ) ));    
	} 
	elseif($exists !=  $user_id )
	{
		echo  "<div class='alert alert-danger' role='alert'> This email is already registered to the site </div>"; exit;		
	}

	if(!empty($current_password )){
		if(empty($pass)){
			echo  "<div class='alert alert-danger' role='alert'> Your current password is not valid.. </div>"; exit;
		}
	}
	if(!empty($password ) || !empty($conf_password )){
		if($password!= $conf_password ){
			echo  "<div class='alert alert-danger' role='alert'> Password and confirm passwords are not match </div>"; exit;
		}else{
			wp_set_password($password, $user_id);
		}
	}
	   	

	$args = array(
		'ID'         =>   $user_id ,
		'first_name'=> $first_name  ,
		'last_name'=> $last_name,
		'display_name' => $first_name.' '.$last_name,	   
	); 
	wp_update_user( $args );	
	
	echo  "<div class='alert alert-success' role='alert'> User Profile Data Updated Succesfully </div>"; exit;		

	
   die();
}

add_action("wp_ajax_add_new_tour", "add_new_tour_fun");
add_action("wp_ajax_nopriv_add_new_tour", "add_new_tour_fun");


function add_new_tour_fun() {
	
	$tour_name = $_POST['tour_name'];
	$tour_status = $_POST['tour_status'];
	$tour_type = $_POST['tour_type'];
    $info_below_logo = $_POST['info_below_logo'];
	$tour_names = $_POST['tour_names'];
	$tour_tag_line = $_POST['tour_tag_line'];
	$bottom_disclaimer_text= $_POST['bottom_disclaimer_text'];
	$google_analytics_code= $_POST['google_analytics_code'];
	$google_properties_id= $_POST['google_properties_id'];
	$logo = $_POST['logo'];
	$feature_image = $_POST['feature_image'];
	$bottom_logo = $_POST['bottom_logo'];
	$owner_list = $_POST['owner_list'];
	$viewer_list = $_POST['viewer_list'];
	
	
  
	

 $to_combine  = array_combine($tour_names , $tour_tag_line);

 
	$add_new_tour = array(
		'post_title'   => $tour_name,
		'post_type'    => 'tours',
        'post_status' => 'publish',      
	 );
		
	    $post_id = wp_insert_post($add_new_tour);
		$tourid = $post_id ;
		$tour_data_map = array(
			'live'=> $tour_status,	
			'archive'=> '',				
			'tour_type' => $tour_type,
			'bottom_disclaimer_text'=> $bottom_disclaimer_text ,
			'google_analytics_code' => $google_analytics_code ,
			'google_properties_id'=> $google_properties_id ,
			'owner_list'=> $owner_list ,
			'viewer_list'=> $viewer_list ,
		);
		foreach($tour_data_map  as $tourname => $value )
		{
			update_field( $tourname, $value , $post_id );
		}
		if($tour_type=="2") {
		$info_below_logo ;
			$repeater_key = 'tag_lines_and_name';
			$index = 0; // array index
			$values = array();
			foreach( $to_combine  as $tourname => $tour_tags) {
				$values[$index]['tour_name'] = $tourname;
				$values[$index]['tour_tag_line'] = $tour_tags;
				$index++;
			}
			update_field($repeater_key, $values , $post_id);
		} else
		{			
			update_field('info_below_logo', $info_below_logo  , $post_id );
		}

		if(isset($_FILES['logo']['name']) && $_FILES['logo']['name']!=''){
		
			$logo_filename= $_FILES['logo']['name'];
			$logo_file=wp_upload_bits($logo_filename, null, file_get_contents($_FILES['logo']['tmp_name']));      
				if ($logo_file['error'] === false) {            
					$attachment = array(
						'post_mime_type' => $logo_file['type'],
						'post_title' => $logo_filename,
						'post_content' => '',
						'post_status' => 'inherit'
					);        
					$attach_id = wp_insert_attachment($attachment, $logo_file['file']);        
					$attach_data = wp_generate_attachment_metadata($attach_id, $logo_file['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);
					update_field('logo', $attach_id, $tourid);
				}
			}
			if(isset($_FILES['feature_image']['name']) && $_FILES['feature_image']['name']!=''){
				$feature_image_filename= $_FILES['feature_image']['name'];
				$feature_image_file=wp_upload_bits($feature_image_filename, null, file_get_contents($_FILES['feature_image']['tmp_name']));      				
					if ($feature_image_file['error'] === false) {            
						$attachment = array(
							'post_mime_type' => $feature_image_file['type'],
							'post_title' => $feature_image_filename,
							'post_content' => '',
							'post_status' => 'inherit'
						);        
						$attach_id = wp_insert_attachment($attachment, $feature_image_file['file']);        
						$attach_data = wp_generate_attachment_metadata($attach_id, $feature_image_file['file']);
						wp_update_attachment_metadata($attach_id, $attach_data);
						set_post_thumbnail( $tourid, $attach_id );						
					}
			}

			
			if(isset($_FILES['bottom_logo']['name']) && $_FILES['bottom_logo']['name']!=''){
				$bottom_logo_filename= $_FILES['bottom_logo']['name'];
				$bottom_logo_file=wp_upload_bits($bottom_logo_filename, null, file_get_contents($_FILES['bottom_logo']['tmp_name']));              
				if ($bottom_logo_file['error'] === false) {            
					$attachment = array(
						'post_mime_type' => $bottom_logo_file['type'],
						'post_title' => $bottom_logo_filename,
						'post_content' => '',
						'post_status' => 'inherit'
					);        
					$attach_id = wp_insert_attachment($attachment, $bottom_logo_file['file']);        
					$attach_data = wp_generate_attachment_metadata($attach_id, $bottom_logo_file['file']);
					wp_update_attachment_metadata($attach_id, $attach_data);
					update_field('bottom_logo', $attach_id, $tourid);
				}
			}
		
		
			
			if(isset($_FILES['tv_video_url_new']['name'][0]) && $_FILES['tv_video_url_new']['name'][0]!=''){
				
				$countfiles = count($_FILES['tv_video_url_new']['name']);
				
				$multi_attac_id = array();
				if($countfiles){    
					for($i=0;$i<$countfiles;$i++){
						$tv_video_url_new_filename= $_FILES['tv_video_url_new']['name'][$i];
						$tv_video_url_new_file=wp_upload_bits($tv_video_url_new_filename, null, file_get_contents($_FILES['tv_video_url_new']['tmp_name'][$i]));              
						if ($tv_video_url_new_file['error'] === false) {            
							$attachment = array(
								'post_mime_type' => $tv_video_url_new_file['type'],
								'post_title' => $tv_video_url_new_filename,
								'post_content' => '',
								'post_status' => 'inherit'
							);        
							$attach_id = wp_insert_attachment($attachment, $tv_video_url_new_file['file']);        
							$attach_data = wp_generate_attachment_metadata($attach_id, $tv_video_url_new_file['file']);
							wp_update_attachment_metadata($attach_id, $attach_data);                
							$multi_attac_id[]['video']=$attach_id;
						}        
					}
				}
				if($tv_video_url){             
					foreach ($tv_video_url as $key => $value) {
						$multi_attac_id[]['video']=$value;
					}         
				}
				update_field('tv_video_url', $multi_attac_id , $tourid);
			}

			if ( ! empty( $_FILES['wp_tour_zip_upload']['name'] ) ) {
				$supported_types = array( 'application/zip' );
				$arr_file_type = wp_check_filetype( basename( $_FILES['wp_tour_zip_upload']['name'] ) );
				$uploaded_type = $arr_file_type['type'];
	
				if ( in_array( $uploaded_type, $supported_types ) ) {			
					
					$name_file  = get_post_field( 'post_name',$id ).'.zip';                    
					$foldername= get_post_field( 'post_name',$id );
					$upload_dir = get_stylesheet_directory();                       
	
					$filename = wp_unique_filename( $user_dirname, $_FILES['file']['name'] );
					move_uploaded_file($_FILES['wp_tour_zip_upload']['tmp_name'], $upload_dir .'/tours_source/'. $name_file);
					// save into database $upload_dir['baseurl'].'/product-images/'.$filename;
					
					if (!file_exists($upload_dir .'/tours_source/'.$foldername)) {                
						mkdir($upload_dir .'/tours_source/'.$foldername, 0777, true);                
					}
					sleep(5);
					WP_Filesystem();
					$destination = wp_upload_dir();
					$destination_path = $destination['path'];
					$unzipfile = unzip_file( $upload_dir .'/tours_source/'. $name_file, $upload_dir .'/tours_source/'.$foldername);
	
					if ( $unzipfile ) {
						echo 'Successfully unzipped the file!';       
					} else {
						echo 'There was an error unzipping the file.';       
					}			
					
				}
				else {
					//wp_die( "The file type that you've uploaded is not a Zip." );
				}
			}

 die();
}
// Add featured image column to custom post type admin list view
function custom_tours_columns( $columns ) {
    $columns['featured_image'] = __( 'Featured Image', 'twentytwentyone' );
    return $columns;
}
add_filter( 'manage_tours_posts_columns', 'custom_tours_columns' );

// Display featured image in custom post type admin list view
function custom_tours_custom_column( $column, $post_id ) {
    switch ( $column ) {
        case 'featured_image':
            echo get_the_post_thumbnail( $post_id, array( 50, 50 ) );
            break;
    }
}
add_action( 'manage_tours_posts_custom_column', 'custom_tours_custom_column', 10, 2 );
function swd_admin_post_thumbnail_add_label($content, $post_id, $thumbnail_id)
{
    $post = get_post($post_id);
    if ($post->post_type == 'tours') {
        $content .= '<medium><i>This image will display in listing of tours in user dashboard section</i></medium>';
        return $content;
    }

    return $content;
}
add_filter('admin_post_thumbnail_html', 'swd_admin_post_thumbnail_add_label', 10, 3);
add_action('init', 'my_rem_editor_from_post_type');
function my_rem_editor_from_post_type() {
    remove_post_type_support( 'tours', 'editor' );
}

?>