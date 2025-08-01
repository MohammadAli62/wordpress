<?php

namespace RT\ThePostGrid\Controllers\Api;

use RT\ThePostGrid\Helpers\Fns;

class GetTermObject {
	public function __construct() {
		add_action( 'rest_api_init', [ $this, 'register_post_route' ] );
	}

	public function register_post_route() {
		register_rest_route(
			'rttpg/v1',
			'terms',
			[
				'methods'             => 'GET',
				'callback'            => [ $this, 'get_all_terms' ],
				'permission_callback' => function () {
					return current_user_can( 'edit_posts' );
				},
			]
		);
	}


	public static function get_all_terms( $request ) {
		// Optional: Support a `post_type` filter
		$post_type = $request->get_param( 'post_type' );

		$all_taxonomies = Fns::get_all_taxonomy_guten();

		if ( $post_type ) {
			// Filter by post type
			foreach ( $all_taxonomies as $taxonomy => $terms ) {
				$taxonomy_object = get_taxonomy( $taxonomy );

				if (
					! $taxonomy_object ||
					! in_array( $post_type, (array) $taxonomy_object->object_type, true )
				) {
					unset( $all_taxonomies[ $taxonomy ] );
				}
			}
		}

		return rest_ensure_response( $all_taxonomies );
	}
}
