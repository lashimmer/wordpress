<?php

require_once('Tax-meta-class.php');

if ( is_admin() ) {

	$prefix = 'cb_';

	$config = array(
		'id' => 'cb_cat_meta',          // meta box id, unique per meta box
		'title' => 'Category Extra Meta',          // meta box title
		'pages' => array('category'),        // taxonomy name, accept categories, post_tag and custom taxonomies
		'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
		'fields' => array(),            // list of meta fields (can be added by field arrays)
		'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$cb_cat_meta =  new Tax_Meta_Class($config);
	$cb_cat_meta->addSelect( $prefix . 'cat_style_field_id',array( '1' => 'One post per line', '2' => 'Two posts per line','3'=>'Three posts per line' ),array('name'=> __('Post Layout ','tax-meta'), 'std'=> array('2')));
	$cb_cat_meta->addSelect( $prefix . 'cat_infinite',array('off'=>'Number Pagination','infinite-scroll'=>'Infinite Scroll','infinite-load'=>'Infinite Scroll With Load More Button'),array('name'=> __('Pagination Style','tax-meta'), 'std'=> array('Number Pagination')));
	$cb_cat_meta->addImage( $prefix . 'bg_image_field_id',array('name'=> __('Category Cover Image ','tax-meta')));
	$cb_cat_meta->addWysiwyg( $prefix . 'cat_ad',array('name'=> __('Category Ad','tax-meta')));
	$cb_cat_meta->Finish();

	$config = array(
		'id' => 'cb_tag_meta',          // meta box id, unique per meta box
		'title' => 'Tags Extra Meta',          // meta box title
		'pages' => array('post_tag'),        // taxonomy name, accept categories, post_tag and custom taxonomies
		'context' => 'normal',            // where the meta box appear: normal (default), advanced, side; optional
		'fields' => array(),            // list of meta fields (can be added by field arrays)
		'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);

	$cb_tag_meta =  new Tax_Meta_Class($config);
	$cb_tag_meta->addSelect( $prefix . 'cat_infinite',array('off'=>'Number Pagination','infinite-scroll'=>'Infinite Scroll','infinite-load'=>'Infinite Scroll With Load More Button'),array('name'=> __('Pagination Style','tax-meta'), 'std'=> array('Number Pagination')));
	$cb_tag_meta->addImage( $prefix . 'bg_image_field_id',array('name'=> __('Tag Cover Image ','tax-meta')));
	$cb_tag_meta->addWysiwyg( $prefix . 'cat_ad',array('name'=> __('Advertisement','tax-meta')));
	$cb_tag_meta->Finish();

}