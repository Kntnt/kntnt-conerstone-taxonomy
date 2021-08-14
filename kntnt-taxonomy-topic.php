<?php


/**
 * @wordpress-plugin
 * Plugin Name:       Kntnt Topic Taxonomy
 * Plugin URI:        https://www.kntnt.com/
 * Description:       Provides the `topic` taxonomy whose terms are used to form a topic cluster.
 * Version:           1.0.6
 * Author:            Thomas Barregren
 * Author URI:        https://www.kntnt.com/
 * License:           GPL-3.0+
 * License URI:       http://www.gnu.org/licenses/gpl-3.0.txt
 */


namespace Kntnt\Topic;

defined( 'ABSPATH' ) && new Taxonomy();


class Taxonomy {

	public function __construct() {
		add_action( 'init', array( $this, 'run' ) );
	}

	public function run() {

		$slug       = apply_filters( 'kntnt_taxonomy_topic_slug', 'topic' );
		$post_types = apply_filters( 'kntnt_taxonomy_topic_objects', array( 'post' ) );

		register_taxonomy( $slug, null, $this->taxonomy( $slug ) );

		foreach ( $post_types as $post_type ) {
			register_taxonomy_for_object_type( $slug, $post_type );
		}

		add_filter( 'term_updated_messages', array( $this, 'term_updated_messages' ) );

	}

	private function taxonomy() {
		return array(

			// A short descriptive summary of what the taxonomy is for.
			'description'        => _x( 'Topics is a taxonomy used as post metadata. Its terms denotes carefully selected topics for which there are a single pages with highly search engine optimized in-depth content on the topic. A such page is known as content hub, pillar content or cornerstone content. All posts that address a topic should link to the cornerstone content of the topic. All posts that also substantially broaden or deepen a topic should be tagged with the topic for cross-referencing. Thus, the cornerstone content and its referenced posts is referred to as a topic cluster.', 'Description', 'kntnt-taxonomy-topic' ),

			// Whether the taxonomy is hierarchical.
			'hierarchical'       => false,

			// Whether a taxonomy is intended for use publicly either via
			// the admin interface or by front-end users.
			'public'             => true,

			// Whether the taxonomy is publicly queryable.
			'publicly_queryable' => true,

			// Whether to generate and allow a UI for managing terms in this
			// taxonomy in the admin.
			'show_ui'            => true,

			// Whether to show the taxonomy in the admin menu.
			'show_in_menu'       => true,

			// Makes this taxonomy available for selection in navigation menus.
			'show_in_nav_menus'  => true,

			// Whether to list the taxonomy in the Tag Cloud Widget controls.
			'show_tagcloud'      => false,

			// Whether to show the taxonomy in the quick/bulk edit panel.
			'show_in_quick_edit' => true,

			// Whether to display a column for the taxonomy on its post
			// type listing screens.
			'show_admin_column'  => false,

			// Metabox to show on edit. If a callable, it is called to render
			// the metabox. If `null` the default metabox is used. If `false`,
			// no metabox is shown.
			'meta_box_cb'        => false,

			// Array of capabilities for this taxonomy.
			'capabilities'       => array(
				'manage_terms' => 'edit_posts',
				'edit_terms'   => 'edit_posts',
				'delete_terms' => 'edit_posts',
				'assign_terms' => 'edit_posts',
			),

			// Sets the query var key for this taxonomy. Default $taxonomy key.
			// If false, a taxonomy cannot be loaded
			// at ?{query_var}={term_slug}. If a string,
			// the query ?{query_var}={term_slug} will be valid.
			'query_var'          => true,

			// Triggers the handling of rewrites for this taxonomy.
			// Replace the array with false to prevent handling of rewrites.
			'rewrite'            => array(

				// Customize the permastruct slug.
				'slug'         => 'topic',

				// Whether the permastruct should be prepended
				// with WP_Rewrite::$front.
				'with_front'   => true,

				// Either hierarchical rewrite tag or not.
				'hierarchical' => false,

				// Endpoint mask to assign. If null and permalink_epmask
				// is set inherits from $permalink_epmask. If null and
				// permalink_epmask is not set, defaults to EP_PERMALINK.
				'ep_mask'      => null,

			),

			// Default term to be used for the taxonomy.
			'default_term'       => null,

			// An array of labels for this taxonomy.
			'labels'             => array(
				'name'                       => _x( 'Topics', 'Plural name', 'kntnt-taxonomy-topic' ),
				'singular_name'              => _x( 'Topic', 'Singular name', 'kntnt-taxonomy-topic' ),
				'search_items'               => _x( 'Search topics', 'Search items', 'kntnt-taxonomy-topic' ),
				'popular_items'              => _x( 'Search topics', 'Search items', 'kntnt-taxonomy-topic' ),
				'all_items'                  => _x( 'All topics', 'All items', 'kntnt-taxonomy-topic' ),
				'parent_item'                => _x( 'Parent topic', 'Parent item', 'kntnt-taxonomy-topic' ),
				'parent_item_colon'          => _x( 'Parent topic colon', 'Parent item colon', 'kntnt-taxonomy-topic' ),
				'edit_item'                  => _x( 'Edit topic', 'Edit item', 'kntnt-taxonomy-topic' ),
				'view_item'                  => _x( 'View topic', 'View item', 'kntnt-taxonomy-topic' ),
				'update_item'                => _x( 'Update topic', 'Update item', 'kntnt-taxonomy-topic' ),
				'add_new_item'               => _x( 'Add new topic', 'Add new item', 'kntnt-taxonomy-topic' ),
				'new_item_name'              => _x( 'New topic name', 'New item name', 'kntnt-taxonomy-topic' ),
				'separate_items_with_commas' => _x( 'Separate topics with commas', 'Separate items with commas', 'kntnt-taxonomy-topic' ),
				'add_or_remove_items'        => _x( 'Add or remove topics', 'Add or remove items', 'kntnt-taxonomy-topic' ),
				'choose_from_most_used'      => _x( 'Choose from most used', 'Choose from most used', 'kntnt-taxonomy-topic' ),
				'not_found'                  => _x( 'Not found', 'Not found', 'kntnt-taxonomy-topic' ),
				'no_terms'                   => _x( 'No terms', 'No terms', 'kntnt-taxonomy-topic' ),
				'items_list_navigation'      => _x( 'Topics list navigation', 'Items list navigation', 'kntnt-taxonomy-topic' ),
				'items_list'                 => _x( 'Items list', 'Topics list', 'kntnt-taxonomy-topic' ),
				'most_used'                  => _x( 'Most used', 'Most used', 'kntnt-taxonomy-topic' ),
				'back_to_items'              => _x( 'Back to topics', 'Back to items', 'kntnt-taxonomy-topic' ),
			),

		);
	}

	public function term_updated_messages( $messages ) {
		$messages['topic'] = array(
			0 => '', // Unused. Messages start at index 1.
			1 => __( 'Topic added.', 'kntnt-taxonomy-topic' ),
			2 => __( 'Topic deleted.', 'kntnt-taxonomy-topic' ),
			3 => __( 'Topic updated.', 'kntnt-taxonomy-topic' ),
			4 => __( 'Topic not added.', 'kntnt-taxonomy-topic' ),
			5 => __( 'Topic not updated.', 'kntnt-taxonomy-topic' ),
			6 => __( 'Topics deleted.', 'kntnt-taxonomy-topic' ),
		);
		return $messages;
	}

}
