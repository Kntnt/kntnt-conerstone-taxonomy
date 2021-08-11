<?php


/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Conerstone Taxonomy
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the `conerstone` taxonomy whose terms are used to indicate that a post is related to a cornerstone piece.
 * Version:           1.0.2
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Conerstone;


defined( 'ABSPATH' ) && new Taxonomy;


class Taxonomy {

	public function __construct() {
		add_action( 'init', [ $this, 'run' ] );
	}

	public function run() {

		$slug = apply_filters( 'kntnt-taxonomy-conerstone-slug', 'conerstone' );
		$post_types = apply_filters( 'kntnt-taxonomy-conerstone-objects', [ 'post' ] );

		register_taxonomy( $slug, null, $this->taxonomy( $slug ) );

		foreach ( $post_types as $post_type ) {
			register_taxonomy_for_object_type( $slug, $post_type );
		}

		add_filter( 'term_updated_messages', [ $this, 'term_updated_messages' ] );

	}

	private function taxonomy() {
		return [

			// A short descriptive summary of what the taxonomy is for.
			'description' => _x( 'Cornerstones is a taxonomy used as post metadata. Its terms denote important topics that are the focus of search engine optimization. For these topics there should be cornerstone content pieces linking to posts tagged with corresponding term. These posts should also link back to the cornerstone content pieces, which thereby becomes a topic hub.', 'Description', 'kntnt-taxonomy-conerstone' ),

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
			'show_tagcloud' => true,

			// Whether to show the taxonomy in the quick/bulk edit panel.
			'show_in_quick_edit' => true,

			// Whether to display a column for the taxonomy on its post
			// type listing screens.
			'show_admin_column' => true,

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
				'slug' => 'conerstone',

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
				'name' => _x( 'Conerstones', 'Plural name', 'kntnt-taxonomy-conerstone' ),
				'singular_name' => _x( 'Conerstone', 'Singular name', 'kntnt-taxonomy-conerstone' ),
				'search_items' => _x( 'Search conerstones', 'Search items', 'kntnt-taxonomy-conerstone' ),
				'popular_items' => _x( 'Search conerstones', 'Search items', 'kntnt-taxonomy-conerstone' ),
				'all_items' => _x( 'All conerstones', 'All items', 'kntnt-taxonomy-conerstone' ),
				'parent_item' => _x( 'Parent conerstone', 'Parent item', 'kntnt-taxonomy-conerstone' ),
				'parent_item_colon' => _x( 'Parent conerstone colon', 'Parent item colon', 'kntnt-taxonomy-conerstone' ),
				'edit_item' => _x( 'Edit conerstone', 'Edit item', 'kntnt-taxonomy-conerstone' ),
				'view_item' => _x( 'View conerstone', 'View item', 'kntnt-taxonomy-conerstone' ),
				'update_item' => _x( 'Update conerstone', 'Update item', 'kntnt-taxonomy-conerstone' ),
				'add_new_item' => _x( 'Add new conerstone', 'Add new item', 'kntnt-taxonomy-conerstone' ),
				'new_item_name' => _x( 'New conerstone name', 'New item name', 'kntnt-taxonomy-conerstone' ),
				'separate_items_with_commas' => _x( 'Separate conerstones with commas', 'Separate items with commas', 'kntnt-taxonomy-conerstone' ),
				'add_or_remove_items' => _x( 'Add or remove conerstones', 'Add or remove items', 'kntnt-taxonomy-conerstone' ),
				'choose_from_most_used' => _x( 'Choose from most used', 'Choose from most used', 'kntnt-taxonomy-conerstone' ),
				'not_found' => _x( 'Not found', 'Not found', 'kntnt-taxonomy-conerstone' ),
				'no_terms' => _x( 'No terms', 'No terms', 'kntnt-taxonomy-conerstone' ),
				'items_list_navigation' => _x( 'Conerstones list navigation', 'Items list navigation', 'kntnt-taxonomy-conerstone' ),
				'items_list' => _x( 'Items list', 'Conerstones list', 'kntnt-taxonomy-conerstone' ),
				'most_used' => _x( 'Most used', 'Most used', 'kntnt-taxonomy-conerstone' ),
				'back_to_items' => _x( 'Back to conerstones', 'Back to items', 'kntnt-taxonomy-conerstone' ),
			],

		];
	}

	public function term_updated_messages( $messages ) {
		$messages['conerstone'] = [
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Conerstone added.', 'kntnt-taxonomy-conerstone' ),
			2 => __( 'Conerstone deleted.', 'kntnt-taxonomy-conerstone' ),
			3 => __( 'Conerstone updated.', 'kntnt-taxonomy-conerstone' ),
			4 => __( 'Conerstone not added.', 'kntnt-taxonomy-conerstone' ),
			5 => __( 'Conerstone not updated.', 'kntnt-taxonomy-conerstone' ),
			6 => __( 'Conerstones deleted.', 'kntnt-taxonomy-conerstone' ),
		];
		return $messages;
	}

}
