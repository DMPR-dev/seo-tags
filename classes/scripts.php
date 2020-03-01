<?php

namespace SeoTags;

class Scripts
{
	protected static $plugin_url;

	public static function register()
	{
		self::$plugin_url = plugins_url() . '/' . basename( plugin_dir_path(  dirname( __FILE__ , 1 ) ) );

		add_action( "admin_enqueue_scripts", "SeoTags\Scripts::registerAdminScripts" );

		add_action( "enqueue_block_editor_assets", "SeoTags\Scripts::registerEditorScripts" );

		add_action( "wp_enqueue_scripts", "SeoTags\Scripts::registerFrontEndScripts" );
	}

	public static function registerAdminScripts()
	{
		if( strpos( get_current_screen()->base, 'seo-tags-settings' ) !== FALSE )
		{
			self::IMGUpload();
		}
	}

	public static function registerFrontEndScripts()
	{
		
	}

	public static function registerEditorScripts()
	{
		self::IMGUpload();
	}

	public static function IMGUpload()
	{
		wp_register_script( 'seo-tag-img-upload-script', self::$plugin_url  . '/assets/admin/js/image-upload.js', array( 'jquery' ) );
		wp_localize_script( 'seo-tag-img-upload-script', 'seo_tags_image_input', array(
			'title'		=> __( 'Select Image' ),
			'btn_text'	=> __( 'Use this image' ) 
		 ) );
		wp_enqueue_script( 'seo-tag-img-upload-script' );
	}
}