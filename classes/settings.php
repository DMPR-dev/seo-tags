<?php
namespace SeoTags;

class Settings
{
	protected static $settings = array();

	public static function register()
	{
		self::initSettings();

		add_action( "admin_menu", "SeoTags\Settings::registerMenuItem" );
	}
	public static function registerMenuItem()
	{
		add_menu_page( __( "Seo Tags Manager" ), __( "Seo Tags" ), "manage_options", "seo-tags-settings", "SeoTags\Settings::render" );
	}
	protected static function initSettings()
	{
		Metabox::initBoxes();
		self::$settings = Metabox::$boxes[0]['fields'];
	}
	protected static function save()
	{
		if( isset( $_REQUEST ) )
		{
			if( isset( $_REQUEST["save_nonce"] ) )
			{
				if( wp_verify_nonce( $_REQUEST["save_nonce"], __FILE__ ) )
				{
					foreach( self::$settings as $field )
					{
						if( isset( $field["type"] ) && $field["type"] === 'spoiler' )
						{
							$contents = $field["contents"];

							foreach( $contents as $field_content )
							{
								self::saveMetaData( $field_content );
							}
						}
						else
						{
							self::saveMetaData( $field );
						}
					}
					?>
					<br>
					<div class="notice notice-success is-dismissible">
				        <p> <strong><?php echo __( 'Success' ); ?>!</strong>
		                <?php echo __( 'Settings saved' ); ?>.
		            	</p>
				    </div>
					<?php
				}
			}
		}
	}
	protected static function saveMetaData( $field = array() )
	{
		if( isset( $field["name"] ) && isset( $_REQUEST[$field["name"]] ))
		{
			update_option( $field["name"], sanitize_text_field( $_REQUEST[$field["name"]] ) );
		}
	}
	public static function render()
	{
		self::Save();
		?>
			<div class="wrap">
				<form method="post">
					<input type="hidden" name="save_nonce" value="<?php echo wp_create_nonce( __FILE__ ); ?>" />
					<div class="seo-tags-settings-holder">
						<h3 style="margin-top: 0px;">
							<?php
								echo __( 'Specify default tags values here. ');
							?>
						</h3>
						<?php
						foreach( self::$settings as $setting )
						{
							$field = $setting;
							$post_id = 0;

							switch ( $field["type"] ) {
								case 'text':
									echo Inputs::TextInput( $post_id , $field["name"], $field["label"], 'seoTagsGetOption' );
									break;
								case 'image':
									echo Inputs::IMGInput( $post_id , $field["name"], $field["label"], 'seoTagsGetOption' );
									break;
								case 'spoiler':
									echo Inputs::SpoilerInput( $field["label"], $field["contents"], array( 
										"post_id"  	=> $post_id, 
									), 'seoTagsGetOption' );
									break;
								default:
									# code...
									break;
							}
						}
					?>
					</div>
					<br>
					<button class="button" type="submit"> <?php _e( "Save" );?> </button>
				</form>
			</div>
		<?php
	}
}
