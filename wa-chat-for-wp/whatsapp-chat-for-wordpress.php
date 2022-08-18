<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
Plugin Name: WhatsApp Chat for WordPress
Plugin URI: https://iamjagdish.com/wordpress-plugins/whatsapp-chat-for-wordpress/
Description: Simplifying WhatsApp Chat for WordPress.
Author: Jagdish Kashyap
Version: 1.0.0
Author URI: https://iamjagdish.com
License: GPL2
*/

if ( ! class_exists( "WACClass" ) ) {

	class WACClass {

		public function __construct() {
			// Set up ACF
			add_filter( 'acf/settings/path', array( $this, 'update_acf_settings_path' ) );
			add_filter( 'acf/settings/dir', array( $this, 'update_acf_settings_dir' ) );

			require_once( sprintf( "%s/vendor/advanced-custom-fields-pro/acf.php", dirname( __FILE__ ) ) );

			// Settings managed via ACF
			require_once( sprintf( "%s/includes/settings.php", dirname( __FILE__ ) ) );
			$settings = new WACClass_Settings( plugin_basename( __FILE__ ) );


			add_filter( 'acf/settings/show_admin', '__return_false' );


		}

		public function update_acf_settings_path() {
			return sprintf( "%s/vendor/advanced-custom-fields-pro/", dirname( __FILE__ ) );
		}

		public function update_acf_settings_dir() {
			return sprintf( "%s/vendor/advanced-custom-fields-pro/", plugin_dir_url( __FILE__ ) );
		}

		/**
		 * Hook into the WordPress activate hook
		 */
		public static function activate() {
			// Do something
		}

		/**
		 * Hook into the WordPress deactivate hook
		 */
		public static function deactivate() {
			// Do something
		}
	}
}

if ( class_exists( 'WACClass' ) ) {

	register_activation_hook( __FILE__, array( 'WACClass', 'activate' ) );
	register_deactivation_hook( __FILE__, array( 'WACClass', 'deactivate' ) );

	$plugin = new WACClass();
}


add_action( 'wp_enqueue_scripts', 'wac_scripts' );
function wac_scripts() {
	wp_enqueue_style( 'wac-style', plugins_url( 'assets/css/style.css', __FILE__ ), '', '1.0', 'all' );
	wp_enqueue_script( 'wac-main', plugins_url( 'assets/js/main.js', __FILE__ ), '', '1.0' );
}

add_action( 'wp_head', 'wac_style' );
function wac_style() {
	?>
    <style>
        .wa__stt_offline {
            pointer-events: none;
        }

        .wa__button_text_only_me .wa__btn_txt {
            padding-top: 16px !important;
            padding-bottom: 15px !important;
        }

        .wa__popup_content_item .wa__cs_img_wrap {
            width: 48px;
            height: 48px;
        }

        .wa__popup_chat_box .wa__popup_heading {
            background: #2db742;
        }

        .wa__btn_popup .wa__btn_popup_icon {
            background: #2db742;
        }

        .wa__popup_chat_box .wa__stt {
            border-left: 2px solid #2db742;
        }

        .wa__popup_chat_box .wa__popup_heading .wa__popup_title {
            color: #fff;
        }

        .wa__popup_chat_box .wa__popup_heading .wa__popup_intro {
            color: #fff;
            opacity: 0.8;
        }

        .wa__popup_chat_box .wa__popup_heading .wa__popup_intro strong {

        }


    </style>
	<?php
}

add_action( 'wp_head', 'wac_button_code' );
function wac_button_code() {
	?>
    <div class="wa__btn_popup">
        <div class="wa__btn_popup_txt">Besoin d'aide? <strong>Parlons-en sur WhatsApp!</strong></div>
        <div class="wa__btn_popup_icon"></div>
    </div>
	<?php
}

add_action( 'wp_footer', 'wac_chatbox_code' );
function wac_chatbox_code() {

	?>
    <!-- Chat Box Code -->
    <div class="wa__popup_chat_box">
        <div class="wa__popup_heading">
            <div class="wa__popup_title">Démarrer la conversation</div>
            <div class="wa__popup_intro">Bonjour ! Contactez directement sur <strong>WhatsApp </strong> l'un des opérateurs ci-dessous pour toute question
                <div id="\&quot;eJOY__extension_root\&quot;"></div>
            </div>
        </div>
        <div class="wa__popup_content wa__popup_content_left">
            <div class="wa__popup_notice">Service disponible entre 8h-18h</div>


            <div class="wa__popup_content_list">

				<?php if ( have_rows( 'team_members', 'option' ) ): ?>

					<?php while ( have_rows( 'team_members', 'option' ) ): the_row();

						$wac_name        = get_sub_field( 'name' );
						$wac_avatar      = get_sub_field( 'profile_pic' );
						$wac_phoneNumber = get_sub_field( 'number' );
						$wac_department  = get_sub_field( 'department' );
						$wac_avalibity   = get_sub_field( 'online_or_offline' );


						?>
                        <div class="wa__popup_content_item ">
                            <a target="_blank"
                               href="https://web.whatsapp.com/send?phone=<?php echo $wac_phoneNumber; ?>&amp;text=Bonjour M. <?php echo $wac_name." "; ?>| Je vous contact depuis votre site web"
                               class="wa__stt <?php echo $wac_avalibity; ?>">
                                <div class="wa__popup_avatar">
                                    <div class="wa__cs_img_wrap"
                                         style="background: url(<?php echo $wac_avatar; ?>) center center no-repeat; background-size: cover;"></div>
                                </div>

                                <div class="wa__popup_txt">
                                    <div class="wa__member_name"><?php echo $wac_name; ?></div>
                                    <div class="wa__member_duty"><?php echo $wac_department; ?></div>
                                </div>
                            </a>
                        </div>

					<?php endwhile; ?>
				<?php endif; ?>

            </div>
        </div>
    </div>
    <!-- Scripts -->
    <script type="text/javascript">
        function isMobile() {
            return (/Android|webOS|iPhone|iPad|iPod|Windows Phone|IEMobile|Mobile|BlackBerry/i.test(navigator.userAgent));
        }

        var elm = jQuery('a[href*="whatsapp.com"]');
        jQuery.each(elm, function (index, value) {
            var item = jQuery(value).attr('href');
            if (item.indexOf('chat') != -1) {
                //nothing
            } else if (item.indexOf('web') != -1 && isMobile()) {
                var itemLink = item;
                var newLink = itemLink.replace('web', 'api');
                jQuery(value).attr("href", newLink);
            } else if (item.indexOf('api') != -1 && !isMobile()) {
                var itemLink = item;
                var newLink = itemLink.replace('api', 'web');
                jQuery(value).attr("href", newLink);
            }
        });
    </script>
	<?php
}

add_shortcode( 'wac_shortcode', 'wac_shortcode_code' );
function wac_shortcode_code() {

	?>

	<?php if ( have_rows( 'team_members', 'option' ) ): ?>

		<?php while ( have_rows( 'team_members', 'option' ) ): the_row();

			$wac_name        = get_sub_field( 'name' );
			$wac_avatar      = get_sub_field( 'profile_pic' );
			$wac_phoneNumber = get_sub_field( 'number' );
			$wac_avalibity   = get_sub_field( 'online_or_offline' );


			?>
            <div class="nta-woo-products-button">
                <div id="nta-wabutton-9653" style="margin: 10px 0px;"><a
                            href="https://api.whatsapp.com/send?phone=<?php echo $wac_phoneNumber; ?>&amp;text=Bonjour M. <?php echo $wac_name." "; ?>  | Je vous contact depuis votre site web"
                            class="wa__button wa__sq_button <?php echo $wac_avalibity; ?> wa__btn_w_img ">
                        <div class="wa__cs_img">
                            <div class="wa__cs_img_wrap"
                                 style="background: url(<?php echo $wac_avatar; ?>) center center no-repeat; background-size: cover;"></div>
                        </div>
                        <div class="wa__btn_txt">
                            <div class="wa__cs_info">
                                <div class="wa__cs_name"><?php echo $wac_name; ?></div>
                                <div class="wa__cs_status">En Ligne</div>
                            </div>
                            <div class="wa__btn_title">Besoin d'aide? Parlons-en sur WhatsApp!</div>
                        </div>
                    </a></div>
            </div>
		<?php endwhile; ?>
	<?php endif; ?>
<?php }