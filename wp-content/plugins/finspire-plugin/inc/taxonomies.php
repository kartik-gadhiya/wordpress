<?php

namespace FINSPIREPLUGIN\Inc;


use FINSPIREPLUGIN\Inc\Abstracts\Taxonomy;


class Taxonomies extends Taxonomy {


	public static function init() {

		$labels = array(
			'name'              => _x( 'Project Category', 'wpfinspire' ),
			'singular_name'     => _x( 'Project Category', 'wpfinspire' ),
			'search_items'      => __( 'Search Category', 'wpfinspire' ),
			'all_items'         => __( 'All Categories', 'wpfinspire' ),
			'parent_item'       => __( 'Parent Category', 'wpfinspire' ),
			'parent_item_colon' => __( 'Parent Category:', 'wpfinspire' ),
			'edit_item'         => __( 'Edit Category', 'wpfinspire' ),
			'update_item'       => __( 'Update Category', 'wpfinspire' ),
			'add_new_item'      => __( 'Add New Category', 'wpfinspire' ),
			'new_item_name'     => __( 'New Category Name', 'wpfinspire' ),
			'menu_name'         => __( 'Project Category', 'wpfinspire' ),
		);
		$args   = array(
			'hierarchical'       => true,
			'labels'             => $labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'            => array( 'slug' => 'project_cat' ),
		);

		register_taxonomy( 'project_cat', 'project', $args );
		
		//Services Taxonomy Start
		$labels = array(
			'name'              => _x( 'Service Category', 'wpfinspire' ),
			'singular_name'     => _x( 'Service Category', 'wpfinspire' ),
			'search_items'      => __( 'Search Category', 'wpfinspire' ),
			'all_items'         => __( 'All Categories', 'wpfinspire' ),
			'parent_item'       => __( 'Parent Category', 'wpfinspire' ),
			'parent_item_colon' => __( 'Parent Category:', 'wpfinspire' ),
			'edit_item'         => __( 'Edit Category', 'wpfinspire' ),
			'update_item'       => __( 'Update Category', 'wpfinspire' ),
			'add_new_item'      => __( 'Add New Category', 'wpfinspire' ),
			'new_item_name'     => __( 'New Category Name', 'wpfinspire' ),
			'menu_name'         => __( 'Service Category', 'wpfinspire' ),
		);
		$args   = array(
			'hierarchical'       => true,
			'labels'             => $labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'            => array( 'slug' => 'service_cat' ),
		);


		register_taxonomy( 'service_cat', 'service', $args );
		
		//Team Taxonomy Start
		$labels = array(
			'name'              => _x( 'Team Category', 'wpfinspire' ),
			'singular_name'     => _x( 'Team Category', 'wpfinspire' ),
			'search_items'      => __( 'Search Category', 'wpfinspire' ),
			'all_items'         => __( 'All Categories', 'wpfinspire' ),
			'parent_item'       => __( 'Parent Category', 'wpfinspire' ),
			'parent_item_colon' => __( 'Parent Category:', 'wpfinspire' ),
			'edit_item'         => __( 'Edit Category', 'wpfinspire' ),
			'update_item'       => __( 'Update Category', 'wpfinspire' ),
			'add_new_item'      => __( 'Add New Category', 'wpfinspire' ),
			'new_item_name'     => __( 'New Category Name', 'wpfinspire' ),
			'menu_name'         => __( 'Team Category', 'wpfinspire' ),
		);
		$args   = array(
			'hierarchical'       => true,
			'labels'             => $labels,
			'show_ui'            => true,
			'show_admin_column'  => true,
			'query_var'          => true,
			'public'             => true,
			'publicly_queryable' => true,
			'rewrite'            => array( 'slug' => 'team_cat' ),
		);


		register_taxonomy( 'team_cat', 'team', $args );
		
	}
	
}
