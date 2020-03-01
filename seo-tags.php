<?php
/*
Plugin Name: Seo Tags
Description: Manage custom seo tags for your posts!
Version:     1.0.0
Author:      Dmytro Proskurin
 *
 */
namespace SeoTags;

require_once plugin_dir_path( __FILE__ ) . 'classes/metabox.php';

require_once plugin_dir_path( __FILE__ ) . 'classes/scripts.php';

require_once plugin_dir_path( __FILE__ ) . 'classes/styles.php';

require_once plugin_dir_path( __FILE__ ) . 'classes/actions.php';

require_once plugin_dir_path( __FILE__ ) . 'classes/settings.php';

require_once plugin_dir_path( __FILE__ ) . 'functions.php';

class InitClass
{
	public function __construct()
	{
		$this->init();
	}
	protected function init()
	{
		Metabox::register();

		Scripts::register();

		Styles::register();

		Actions::register();

		Settings::register();
	}
}

new InitClass();