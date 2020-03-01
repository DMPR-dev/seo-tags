<?php

namespace SeoTags;

class Actions
{
	public static function register()
	{
		add_action( "wp_head", "SeoTags\Actions::printSeoTags", 0, 1 );
	}

	public static function printSeoTags()
	{
		global $post;

		if( is_null( $post ) ) return; 

		$tags = array(
			array(
				"name" 		=> "seo-tags-title",
				"property"	=> "og:title"
			),
			array(
				"name" 		=> "seo-tags-description",
				"property"	=> "og:description"
			),
			array(
				"name" 		=> "seo-tags-type",
				"property"	=> "og:type"
			),
			array(
				"name" 		=> "seo-tags-image",
				"property"	=> "og:image"
			),
			array(
				"name" 		=> "seo-tags-image-alt",
				"property"	=> "og:image:alt"
			),
			array(
				"name" 		=> "seo-tags-url",
				"property"	=> "og:url"
			),
			array(
				"name" 		=> "seo-tags-site_name",
				"property"	=> "og:site_name"
			),
			array(
				"name" 		=> "seo-tags-keywords",
				"property"	=> "keywords"
			),
			array(
				"name" 		=> "seo-tags-author",
				"property"	=> "author"
			),
			array(
				"name" 		=> "seo-tags-copyright",
				"property"	=> "copyright"
			),
			array(
				"name" 		=> "seo-tags-revisit",
				"property"	=> "revisit"
			),
			array(
				"name" 		=> "seo-tags-robots",
				"property"	=> "robots"
			),
			array(
				"name" 		=> "seo-tags-twitter-card",
				"property"	=> "twitter:card"
			),
			array(
				"name" 		=> "seo-tags-twitter-site",
				"property"	=> "twitter:site"
			),
			array(
				"name" 		=> "seo-tags-twitter-creator",
				"property"	=> "twitter:creator"
			),
		);

		foreach( $tags as $tag )
		{
			self::processTag( $post, $tag );
		}
	}

	protected static function processTag( $post, $tag )
	{
		$content = sanitize_text_field( get_post_meta( $post->ID, $tag['name'], true ) );

		if( strlen( $content ) === 0 )
		{
			// fallback, use default option if it's set

			$content = sanitize_text_field( get_option( $tag['name'] ) );
		}

		if( strlen( $content ) > 0 && ( $tag["property"] === 'og:image' && filter_var( $content, FILTER_VALIDATE_URL ) !== FALSE || $tag["property"] !== 'og:image' ) )
		{
			?>
				<meta property="<?php echo $tag['property']; ?>" <?php echo $tag['property'] == 'copyright' ? 'lang="' .sanitize_text_field( get_post_meta( $post->ID, 'seo-tags-copyright-lang', true ) ) . '"' : '' ?> content="<?php echo $content; ?>" />
			<?php
		}
	}
}