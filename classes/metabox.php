<?php
namespace SeoTags;

require_once plugin_dir_path( __FILE__ ) . '/inputs.php'; 

class MetaBox
{
	public static $boxes = array(
		
	);
	public static function register()
	{
		self::InitBoxes();

		add_action( "add_meta_boxes", "SeoTags\MetaBox::registerBoxes", 10, 2);

		add_action( "save_post", "SeoTags\MetaBox::saveBoxValues", 10, 2);
	}
	/*
		Initialize a list of metaboxes
	*/
	public static function initBoxes()
	{
		self::$boxes = array(
			array(
				"post_type" => "any",
				"id"		=> "seotags-fields",
				"label"		=> __( "Seo" ) . " " . __( "Tags" ),
				"location"	=> "advanced",
				"priority"	=> "high",
				"fields" 	=> array(
					array(
						"name" 		=> "seo-tags-title-spoiler",
						"label" 	=> __( "Title" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-title",
								"label" 	=> __( "Title" ) . ":",
								"type"		=> "text", 
							)
						)
					),
					array(
						"name" 		=> "seo-tags-description-spoiler",
						"label" 	=> __( "Description" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-description",
								"label" 	=> __( "Description" ) . ":",
								"type"		=> "text", 
							)
						)
					),
					array(
						"name" 		=> "seo-tags-type-spoiler",
						"label" 	=> __( "Type" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-type",
								"label" 	=> __( "Type" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-url-spoiler",
						"label" 	=> __( "URL" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-url",
								"label" 	=> __( "URL" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-image-spoiler",
						"label" 	=> __( "Image" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-image",
								"label" 	=> __( "Image" ) . ":",
								"type"		=> "image",
							),
							array(
								"name" 		=> "seo-tags-image-alt",
								"label" 	=> __( "Image ALT" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-site_name-spoiler",
						"label" 	=> __( "Site Name" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-site_name",
								"label" 	=> __( "Site Name" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-keywords-spoiler",
						"label" 	=> __( "Keywords" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-keywords",
								"label" 	=> __( "Keywords" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-author-spoiler",
						"label" 	=> __( "Author" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-author",
								"label" 	=> __( "Author" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-copyright-spoiler",
						"label" 	=> __( "Copyright" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-copyright-lang",
								"label" 	=> __( "Language" ) . ":",
								"type"		=> "text",
							),
							array(
								"name" 		=> "seo-tags-copyright",
								"label" 	=> __( "Copyright" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-revisit-spoiler",
						"label" 	=> __( "Revisit" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-revisit",
								"label" 	=> __( "Revisit" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-robots-spoiler",
						"label" 	=> __( "Robots" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-robots",
								"label" 	=> __( "Robots" ) . ":",
								"type"		=> "text",
							)
						)
					),
					array(
						"name" 		=> "seo-tags-twitter-spoiler",
						"label" 	=> __( "Twitter" ),
						"type"		=> "spoiler", 
						"contents" 	=> array(
							array(
								"name" 		=> "seo-tags-twitter-card",
								"label" 	=> __( "Card" ) . ":",
								"type"		=> "text",
							),
							array(
								"name" 		=> "seo-tags-twitter-site",
								"label" 	=> __( "Site" ) . ":",
								"type"		=> "text",
							),
							array(
								"name" 		=> "seo-tags-twitter-creator",
								"label" 	=> __( "Creator" ) . ":",
								"type"		=> "text",
							),
						)
					),
				)
			)
		);
	}
	public static function saveBoxValues( $post_id, $post )
	{
		foreach( self::$boxes as $box )
		{
			if( $box["post_type"] !== "any" )
			{
				if( $post->post_type !== $box["post_type"] ) continue;
			}

			foreach( $box["fields"] as $field )
			{
				if( isset( $field["type"] ) && $field["type"] === 'spoiler' )
				{
					$contents = $field["contents"];

					foreach( $contents as $field_content )
					{
						self::saveMetaData( $post_id, $field_content );
					}
				}
				else
				{
					self::saveMetaData( $post_id, $field );
				}
			}
		}
	}
	protected static function saveMetaData( $post_id, $field = array() )
	{
		if( isset( $_REQUEST[$field["name"]] ))
		{
			if( !update_post_meta( $post_id, $field["name"], sanitize_text_field( $_REQUEST[$field["name"]] ) ) )
			{
				add_post_meta( $post_id, $field["name"], sanitize_text_field( $_REQUEST[$field["name"]] ), true );
			}
		}
	}
	public static function registerBoxes( $post_type, $post )
	{
		foreach( self::$boxes as $box )
		{
			$fields = $box["fields"];
			$post_id = $post->ID;
			$post_type = $box["post_type"];

			$box_cb = function( ) use ( $post_id, $fields ) {
				self::boxCallback( $post_id, $fields );
			};

			if( $box["post_type"] === "any" )
			{
				$types = get_post_types();

				if( is_array( $types ) )
				{
					foreach( $types as $pt )
					{
						add_meta_box( $box["id"], $box["label"], $box_cb, $pt, $box["location"], isset( $box["priority"] ) ? $box["priority"] : "default" );
					}
				}
			}
			else
			{
				add_meta_box( $box["id"], $box["label"], $box_cb, $box["post_type"], $box["location"], isset( $box["priority"] ) ? $box["priority"] : "default" );
			}
		}
	}
	/*
		Default callback for metabox
	*/
	public static function boxCallback( $post_id, $fields, $get_current_value = 'get_post_meta' )
	{
		if(is_array( $fields ) && sizeof( $fields ) > 0)
		{
			foreach( $fields as $field )
			{
				switch ( $field["type"] ) {
					case 'text':
						echo Inputs::TextInput( $post_id , $field["name"], $field["label"], $get_current_value );
						break;
					case 'image':
						echo Inputs::IMGInput( $post_id , $field["name"], $field["label"], $get_current_value );
						break;
					case 'select':
						echo Inputs::SelectInput( $post_id , $field["name"], $field["label"], $field["values"], $get_current_value );
						break;
					case 'spoiler':
						echo Inputs::SpoilerInput( $field["label"], $field["contents"], array( 
							"post_id"  	=> $post_id, 
						), $get_current_value );
						break;
					default:
						# code...
						break;
				}
			}
		}
	}	
}