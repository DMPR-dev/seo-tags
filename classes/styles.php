<?php

namespace SeoTags;

class Styles
{
	protected static $plugin_url;

	public static function register()
	{
		self::$plugin_url = plugins_url() . '/' . basename( plugin_dir_path(  dirname( __FILE__ , 1 ) ) );

		add_action( "admin_enqueue_scripts", "SeoTags\Styles::registerAdminStyles" );

		add_action( "enqueue_block_editor_assets", "SeoTags\Styles::registerEditorStyles" );
	}

	public static function registerAdminStyles()
	{
		if( strpos( get_current_screen()->base, 'seo-tags-settings' ) !== FALSE )
		{
			self::settingsStyle();
		}
	}

	public static function registerEditorStyles()
	{
		self::editorMetaboxesStyle();
	}

	protected static function editorMetaboxesStyle()
	{
		wp_enqueue_style( 'seo-tags-editor-metaboxes-style', self::$plugin_url  . '/assets/admin/css/editor.css' );
	}

	protected static function settingsStyle()
	{
		wp_enqueue_style( 'seo-tags-settings-style', self::$plugin_url  . '/assets/admin/css/settings.css' );
	}
}