<?php
/*
  Plugin Name: Automotive
  Description:Plugin for move info custom database table to custom post type and showing it on front 
  Version: 1.0
  Author:Olga
  Author URI: 
*/

/** There is a db table Garage with fields Brand,Model,Color,Km
 * - create CPT for inserting new posts
 * - create 5 metaboxes for accepting info
 * - add column/field id which will be picked for seleccting data
 * - filter the table to compare with saved meta id
 
*/
// CPT
function create_auto_cpt() {

    $labels = array(
        'name' => _x( 'Auto', 'Post Type General Name', 'Auto' ),
        'singular_name' => _x( 'Auto', 'Post Type Singular Name', 'Auto' ),
        'menu_name' => _x( 'Auto', 'Admin Menu text', 'Auto' ),
        'name_admin_bar' => _x( 'Auto', 'Add New on Toolbar', 'Auto' ),
        'archives' => __( 'Archivi Auto', 'Auto' ),
        'attributes' => __( 'Attributi delle Auto', 'Auto' ),
        'parent_item_colon' => __( 'Genitori Auto:', 'Auto' ),
        'all_items' => __( 'All Autos', 'Auto' ),
        'add_new_item' => __( 'Add new Auto', 'Auto' ),
        'add_new' => __( 'New', 'Auto' ),
        'new_item' => __( 'Auto redigere', 'Auto' ),
        'edit_item' => __( 'Edit Auto', 'Auto' ),
        'update_item' => __( 'Update Auto', 'Auto' ),
        'view_item' => __( 'View Auto', 'Auto' ),
        'view_items' => __( 'View all', 'Auto' )
    );
    $args = array(
        'label' => __( 'Auto', 'Auto' ),
        'description' => __( 'Auto', 'Auto' ),
        'labels' => $labels,
        'menu_icon' => 'dashicons-admin-tools',
        'supports' => array(),
        'taxonomies' => array(),
        'public' => true,
        'show_ui' => true,
        'show_in_menu' => true,
        'menu_position' => 5,
        'show_in_admin_bar' => true,
        'show_in_nav_menus' => true,
        'can_export' => true,
        'has_archive' => true,
        'hierarchical' => false,
        'exclude_from_search' => false,
        'show_in_rest' => true,
        'publicly_queryable' => true,
        'capability_type' => 'post',
    );
    register_post_type( 'auto', $args );

}
add_action( 'init', 'create_auto_cpt', 0 );

//add metaboxes
add_action( 'admin_init', 'my_admin' );

function my_admin() {
    add_meta_box( 
        'car_review_meta_box',
        'Informazioni Auto',
        'display_car_review_meta_box',
        'auto',
        'normal',
        'high'
    );
}

function display_car_review_meta_box() {
    ?>
    <table>
        <tr>
            <td style="width: 50%">ID</td>
            <td><input type="text" size="40" name="garage" value="<?php echo get_post_meta( get_the_ID(), 'id', true ); ?>" readonly /></td>
        </tr>
        <tr>
            <td style="width: 50%">Brand</td>
            <td><input type="text" size="40" name="garage" value="<?php echo get_post_meta( get_the_ID(), 'brand', true ); ?>" readonly /></td>
        </tr>
        <tr>
            <td style="width: 50%">Model</td>
            <td><input type="text" size="40" name="garage" value="<?php echo get_post_meta( get_the_ID(), 'model', true ); ?>" readonly /></td>       
        </tr>
        <tr>
            <td style="width: 50%">Color</td>
            <td><input type="text" size="40" name="garage" value="<?php echo get_post_meta( get_the_ID(), 'color', true ); ?>" readonly /></td>
        </tr>
        <tr>
            <td style="width: 50%">KM</td>
            <td><input type="text" size="40" name="garage" value="<?php echo get_post_meta( get_the_ID(), 'km', true ); ?>" readonly /></td>       
        </tr>
    </table>
    <?php
}

//query post CPT cars to chack is their similar id in database
function am_check_for_similar_meta_id(){

    $id_array_in_cpt = [];

    $args = [
        'posts_per_page' => -1,
        'post_type'      => 'auto'
    ];

    $query = new Query($args);

    while($query->have_posts()){
        $query->the_post();
        $id_array_in_cpt[] = get_post_meta(get_the_ID(),'id',true);
    }


return $id_array_in_cpt;

}