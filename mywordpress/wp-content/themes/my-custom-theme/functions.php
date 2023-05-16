
<?php
//menu code start
register_nav_menus(
    array('primary-menu'=>'top menu')
)
?>
<?php
register_nav_menus(
    array('secondory-menu'=>'second menu')
)
//menu code end
?>
<?php
// css and js start
function wp_my_custom_theme() {
	wp_enqueue_style( 'aoscss', get_template_directory_uri() .'/assets/vendor/aos/aos.css' );
    wp_enqueue_style('bootstrapmin', get_template_directory_uri() . '/assets/vendor/bootstrap/css/bootstrap.min.css');
    wp_enqueue_style('bootstrapicon', get_template_directory_uri() . '/assets/vendor/bootstrap-icons/bootstrap-icons.css');
    wp_enqueue_style('boxiconsmin', get_template_directory_uri() . '/assets/vendor/boxicons/css/boxicons.min.css');
    wp_enqueue_style('glightboxmin', get_template_directory_uri() . '/assets/vendor/glightbox/css/glightbox.min.css');
    wp_enqueue_style('remixicon', get_template_directory_uri() . '/assets/vendor/remixicon/remixicon.css');
    wp_enqueue_style('swiperbundle', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.css');
    wp_enqueue_style('mainstyle', get_template_directory_uri() . '/assets/css/style.css');
    wp_enqueue_script( 'aosjs', get_template_directory_uri() . '/assets/vendor/aos/aos.js', array(), '1.0.0', true );
    wp_enqueue_script( 'bundleminjs', get_template_directory_uri() . '/assets/vendor/bootstrap/js/bootstrap.bundle.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'glightboxjs', get_template_directory_uri() . '/assets/vendor/glightbox/js/glightbox.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'isotopejs', get_template_directory_uri() . '/assets/vendor/isotope-layout/isotope.pkgd.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'swiperbundlejs', get_template_directory_uri() . '/assets/vendor/swiper/swiper-bundle.min.js', array(), '1.0.0', true );
    wp_enqueue_script( 'noframeworkjs', get_template_directory_uri() . '/assets/vendor/waypoints/noframework.waypoints.js', array(), '1.0.0', true );
    wp_enqueue_script( 'validatejs', get_template_directory_uri() . '/assets/vendor/php-email-form/validate.js', array(), '1.0.0', true );
    wp_enqueue_script( 'mainjs', get_template_directory_uri() . '/assets/js/main.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'wp_my_custom_theme' );
// css and js end
?>
<?php
//podcast custom post type code start

function post_type_podcasts(){
	
	$singular = 'podcast';
	$plural = 'podcasts';


$labels = array(
	'name' 					=> $plural,
	'singular_name' 		=> $singular,
	'add_name' 				=> 'Add New'. $singular,
	'add_new_item'			=> 'Add New' . $singular,
	'edit' 					=> 'Edit'. $singular,
	'edit_item'				=> 'Edit' . $singular,
    'view' 					=> 'view'. $singular,
	'view_item' 			=> 'View' . $singular,	
	'search_term' 			=> 'Search' . $plural,
	'parent' 				=> 'Parent' . $singular,
	'not_found' 			=> 'No' . $plural .'found',
	'not_found_in_trash'	=> 'No' . $plural .'found in trash',

);
$args = array(
		'labels'             => $labels,
        'description'        => __( 'Description.', 'your-plugin-textdomain' ),
		'public'             => true,
		'publicly_queryable' => true,
		'show_ui'            => true,
		'show_in_menu'       => true,
		'query_var'          => true,
		'rewrite'            => array( 'slug' => 'podcasts' ),
		'menu_icon'          => 'dashicons-calendar-alt',
		'capability_type'    => 'post',
		'has_archive'        => true,
		'hierarchical'       => false,
		'menu_position'      => null,
		'supports'           => array( 'title',  'thumbnail' , 'editor', 'excerpt' )
	);

register_post_type('podcasts', $args);


}

add_action('init','post_type_podcasts');


//Category

function register_taxonomy_podcasts_category(){

	$singular = ' podcast Category';
	$plural = ' podcasts Category ';


$labels = array(
		'name'                       => $plural,
		'singular_name'              => $singular,
		'search_items'               => 'Search' .$plural ,
		'popular_items'              => 'Popular' .$plural ,
		'all_items'                  => 'All' .$plural ,
		'parent_item'                =>  null,
		'parent_item_colon'          =>  null,
		'edit_item'                  => 'Edit' .$singular ,
		'update_item'                => 'Update' .$singular ,
		'add_new_item'               => 'Add' .$singular ,
		'new_item_name'              => 'New' .$singular. 'Name',
		'separate_items_with_commas' => 'separate' .$singular. 'With commas',
		'add_or_remove_items'        => 'Add or Remove' .$plural ,
		'choose_from_most_used'      => 'choose from most used' .$plural ,
		'not_found'                  => 'No' . $plural .'found',
		'menu_name'                  => $plural,
	);


 $args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'podcasts-category' ),
	);

register_taxonomy( 'podcasts-category', 'podcasts', $args );
}

add_action('init','register_taxonomy_podcasts_category');


//Tag

function register_taxonomy_podcasts_tag(){

	$singular = 'podcast Tag';
	$plural = 'podcasts Tag';


$labels = array(
		'name'                       => $plural,
		'singular_name'              => $singular,
		'search_items'               => 'Search' .$plural ,
		'popular_items'              => 'Popular' .$plural ,
		'all_items'                  => 'All' .$plural ,
		'parent_item'                =>  null,
		'parent_item_colon'          =>  null,
		'edit_item'                  => 'Edit' .$singular ,
		'update_item'                => 'Update' .$singular ,
		'add_new_item'               => 'Add' .$singular ,
		'new_item_name'              => 'New' .$singular. 'Name',
		'separate_items_with_commas' => 'separate' .$singular. 'With commas',
		'add_or_remove_items'        => 'Add or Remaove' .$plural ,
		'choose_from_most_used'      => 'choose from most used' .$plural ,
		'not_found'                  => 'No' . $plural .'found',
		'menu_name'                  => $plural,
	);


 $args = array(
		'hierarchical'      => true,
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'           => array( 'slug' => 'podcasts-tag' ),
	);

register_taxonomy( 'podcasts-tag', 'private-bookings', $args );
}

add_action('init','register_taxonomy_podcasts_tag');

?>