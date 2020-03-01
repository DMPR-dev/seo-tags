<?php
namespace SeoTags;

class Inputs
{
	/*
	 *
	 *
	 *	Text Input
	 *
	 *
	 */
	public static function TextInput( $post_id, $name, $label, $get_current_value = 'get_post_meta' )
	{
		$current_value = $get_current_value( $post_id, $name, true );
		ob_start();
		?>
			<label for="<?php echo esc_attr( $name ); ?>"> <?php echo esc_html( $label ); ?> </label>
			<input type="text" style="width: 100%;" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $current_value ); ?>" placeholder="<?php echo str_replace( ':', '', $label ); ?>"/>
		<?php
		return ob_get_clean();
	}
	/*
	 *
	 *
	 *	Spoiler
	 *
	 *
	 */
	public static function SpoilerInput( $label, $contents = array(), $content_args = array(), $get_current_value = 'get_post_meta' )
	{
		ob_start();
		?>
			<details class="seo-tags-details">
				<summary><?php echo str_replace( ':', '', $label ); ?></summary>
				<div class="seo-tags-details-content">
					<?php
						$post_id = isset( $content_args["post_id"] ) ? intval( $content_args["post_id"] ) : -1;
						MetaBox::boxCallback( $post_id, $contents, $get_current_value );
					?>
				</div>
			</details>
		<?php
		return ob_get_clean();
	}
	/*
	 *
	 *
	 *	Image
	 *
	 *
	 */
	public static function IMGInput( $post_id, $name, $label, $get_current_value = 'get_post_meta' )
	{
		$current_value = $get_current_value( $post_id, $name, true );
		$current_id = -1;
		if( is_null( $current_value ) || $current_value === false )
		{
			$current_value = "";
		}
		if( strlen( $current_value ) > 0 )
		{
			$current_id = $current_value;
			$current_value = wp_get_attachment_url( $current_value );
		}
		ob_start();
		?>
		<div>
			<img src="<?php echo esc_attr( $current_value ); ?>" style="width: 50%; display: flex; margin:auto; margin-bottom: 15px;"/>
			<input type="hidden" id="<?php echo esc_attr( $name ); ?>" name="<?php echo esc_attr( $name ); ?>" value="<?php echo esc_attr( $current_id ); ?>"> 
			<button type="button" class="seo-tags-upload-img-button components-button is-button is-default is-large" style="display: flex;margin-left: auto;"> <?php echo __( "Upload Image" ); ?> </button>
			<br>
			<button type="button" class="seo-tags-delete-img-button components-button is-button is-default is-large" style="display: flex;margin-left: auto;"> <?php echo __( "Remove Image" ); ?> </button> 
		</div>
		<?php
		return ob_get_clean();
	}
}