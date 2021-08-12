<?php


/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Cornerstone Taxonomy
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the `cornerstone` taxonomy whose terms are used to indicate that a post is related to a cornerstone piece.
 * Version:           1.0.4
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Cornerstone;


defined( 'ABSPATH' ) && new Taxonomy;


class Taxonomy {

	public function __construct() {
		add_action( 'init', [ $this, 'run' ] );
	}

	public function run() {

		$slug = apply_filters( 'kntnt-taxonomy-cornerstone-slug', 'cornerstone' );
		$post_types = apply_filters( 'kntnt-taxonomy-cornerstone-objects', [ 'post' ] );

		register_taxonomy( $slug, null, $this->taxonomy( $slug ) );

		foreach ( $post_types as $post_type ) {
			register_taxonomy_for_object_type( $slug, $post_type );
		}

		add_filter( 'term_updated_messages', [ $this, 'term_updated_messages' ] );

	}

	private function taxonomy() {
		return [

			// A short descriptive summary of what the taxonomy is for.
			'description' => _x( 'Cornerstones is a taxonomy used as post metadata. Its terms denote important topics that are the focus of search engine optimization. For these topics there should be cornerstone content pieces linking to posts tagged with corresponding term. These posts should also link back to the cornerstone content pieces, which thereby becomes a topic hub.', 'Description', 'kntnt-taxonomy-cornerstone' ),

			// Whether the taxonomy is hierarchical.
			'hierarchical' => false,

			// Whether a taxonomy is intended for use publicly either via
			// the admin interface or by front-end users.
			'public' => true,

			// Whether the taxonomy is publicly queryable.
			'publicly_queryable' => true,

			// Whether to generate and allow a UI for managing terms in this
			// taxonomy in the admin.
			'show_ui' => true,

			// Whether to show the taxonomy in the admin menu.
			'show_in_menu' => true,

			// Makes this taxonomy available for selection in navigation menus.
			'show_in_nav_menus' => true,

			// Whether to list the taxonomy in the Tag Cloud Widget controls.
			'show_tagcloud' => false,

			// Whether to show the taxonomy in the quick/bulk edit panel.
			'show_in_quick_edit' => true,

			// Whether to display a column for the taxonomy on its post
			// type listing screens.
			'show_admin_column' => true,

			// Metabox to show on edit. If a callable, it is called to render
			// the metabox. If `null` the default metabox is used. If `false`,
			// no metabox is shown.
			'meta_box_cb' => false,

			// Array of capabilities for this taxonomy.
			'capabilities' => [
				'manage_terms' => 'edit_posts',
				'edit_terms' => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			],

			// Sets the query var key for this taxonomy. Default $taxonomy key.
			// If false, a taxonomy cannot be loaded
			// at ?{query_var}={term_slug}. If a string,
			// the query ?{query_var}={term_slug} will be valid.
			'query_var' => true,

			// Triggers the handling of rewrites for this taxonomy.
			// Replace the array with false to prevent handling of rewrites.
			'rewrite' => [

				// Customize the permastruct slug.
				'slug' => 'cornerstone',

				// Whether the permastruct should be prepended
				// with WP_Rewrite::$front.
				'with_front' => true,

				// Either hierarchical rewrite tag or not.
				'hierarchical' => false,

				// Endpoint mask to assign. If null and permalink_epmask
				// is set inherits from $permalink_epmask. If null and
				// permalink_epmask is not set, defaults to EP_PERMALINK.
				'ep_mask' => null,

			],

			// Default term to be used for the taxonomy.
			'default_term' => null,

			// An array of labels for this taxonomy.
			'labels' => [
				'name' => _x( 'Cornerstones', 'Plural name', 'kntnt-taxonomy-cornerstone' ),
				'singular_name' => _x( 'Cornerstone', 'Singular name', 'kntnt-taxonomy-cornerstone' ),
				'search_items' => _x( 'Search cornerstones', 'Search items', 'kntnt-taxonomy-cornerstone' ),
				'popular_items' => _x( 'Search cornerstones', 'Search items', 'kntnt-taxonomy-cornerstone' ),
				'all_items' => _x( 'All cornerstones', 'All items', 'kntnt-taxonomy-cornerstone' ),
				'parent_item' => _x( 'Parent cornerstone', 'Parent item', 'kntnt-taxonomy-cornerstone' ),
				'parent_item_colon' => _x( 'Parent cornerstone colon', 'Parent item colon', 'kntnt-taxonomy-cornerstone' ),
				'edit_item' => _x( 'Edit cornerstone', 'Edit item', 'kntnt-taxonomy-cornerstone' ),
				'view_item' => _x( 'View cornerstone', 'View item', 'kntnt-taxonomy-cornerstone' ),
				'update_item' => _x( 'Update cornerstone', 'Update item', 'kntnt-taxonomy-cornerstone' ),
				'add_new_item' => _x( 'Add new cornerstone', 'Add new item', 'kntnt-taxonomy-cornerstone' ),
				'new_item_name' => _x( 'New cornerstone name', 'New item name', 'kntnt-taxonomy-cornerstone' ),
				'separate_items_with_commas' => _x( 'Separate cornerstones with commas', 'Separate items with commas', 'kntnt-taxonomy-cornerstone' ),
				'add_or_remove_items' => _x( 'Add or remove cornerstones', 'Add or remove items', 'kntnt-taxonomy-cornerstone' ),
				'choose_from_most_used' => _x( 'Choose from most used', 'Choose from most used', 'kntnt-taxonomy-cornerstone' ),
				'not_found' => _x( 'Not found', 'Not found', 'kntnt-taxonomy-cornerstone' ),
				'no_terms' => _x( 'No terms', 'No terms', 'kntnt-taxonomy-cornerstone' ),
				'items_list_navigation' => _x( 'Cornerstones list navigation', 'Items list navigation', 'kntnt-taxonomy-cornerstone' ),
				'items_list' => _x( 'Items list', 'Cornerstones list', 'kntnt-taxonomy-cornerstone' ),
				'most_used' => _x( 'Most used', 'Most used', 'kntnt-taxonomy-cornerstone' ),
				'back_to_items' => _x( 'Back to cornerstones', 'Back to items', 'kntnt-taxonomy-cornerstone' ),
			],

		];
	}

	public function term_updated_messages( $messages ) {
		$messages['cornerstone'] = [
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Cornerstone added.', 'kntnt-taxonomy-cornerstone' ),
			2 => __( 'Cornerstone deleted.', 'kntnt-taxonomy-cornerstone' ),
			3 => __( 'Cornerstone updated.', 'kntnt-taxonomy-cornerstone' ),
			4 => __( 'Cornerstone not added.', 'kntnt-taxonomy-cornerstone' ),
			5 => __( 'Cornerstone not updated.', 'kntnt-taxonomy-cornerstone' ),
			6 => __( 'Cornerstones deleted.', 'kntnt-taxonomy-cornerstone' ),
		];
		return $messages;
	}

}