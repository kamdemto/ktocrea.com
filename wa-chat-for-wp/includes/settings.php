<?php
if(!class_exists('WACClass_Settings'))
{
	class WACClass_Settings
	{
		const SLUG = "whatsapp-chat-for-wordpress";

		/**
		 * Construct the plugin object
		 */
		public function __construct($plugin)
		{
			// register actions
			acf_add_options_page(array(
				'page_title' => __('WhatsApp Chat for WordPress', 'custom'),
				'menu_title' => __('WhatsApp', 'custom'),
				'menu_slug' => self::SLUG,
				'capability' => 'manage_options',
				'icon_url' => 'dashicons-format-chat',
				'redirect' => false
			));

			add_action('init', array(&$this, "init"));
			add_action('admin_menu', array(&$this, 'admin_menu'), 20);
			add_filter("plugin_action_links_$plugin", array(&$this, 'plugin_settings_link'));
		}

		/**
		 * Add options page
		 */
		public function admin_menu()
		{
			// Duplicate link into properties mgmt
			add_submenu_page(
				self::SLUG,
				__('Settings', 'custom'),
				__('Settings', 'custom'),
				'manage_options',
				self::SLUG,
				1
			);
		}

		/**
		 * Add settings fields via ACF
		 */
		function init()
		{
			if(function_exists('register_field_group'))
			{
				if( function_exists('acf_add_local_field_group') ):

					acf_add_local_field_group(array(
						'key' => 'group_5d21095adbd96',
						'title' => 'WhatsApp Chat Box',
						'fields' => array(
							array(
								'key' => 'field_5d21096794cfc',
								'label' => 'Team Members',
								'name' => 'team_members',
								'type' => 'repeater',
								'instructions' => '',
								'required' => 0,
								'conditional_logic' => 0,
								'wrapper' => array(
									'width' => '',
									'class' => '',
									'id' => '',
								),
								'collapsed' => '',
								'min' => 0,
								'max' => 0,
								'layout' => 'table',
								'button_label' => 'Add New Member',
								'sub_fields' => array(
									array(
										'key' => 'field_5d21097594cfd',
										'label' => 'Name',
										'name' => 'name',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'field_5d21097a94cfe',
										'label' => 'Profile Pic',
										'name' => 'profile_pic',
										'type' => 'image',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'return_format' => 'url',
										'preview_size' => 'thumbnail',
										'library' => 'all',
										'min_width' => '',
										'min_height' => '',
										'min_size' => '',
										'max_width' => '',
										'max_height' => '',
										'max_size' => '',
										'mime_types' => '',
									),
									array(
										'key' => 'field_5d21098a94cff',
										'label' => 'Number',
										'name' => 'number',
										'type' => 'number',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'min' => '',
										'max' => '',
										'step' => '',
									),
									array(
										'key' => 'field_5d2109aa94d00',
										'label' => 'Department',
										'name' => 'department',
										'type' => 'text',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'default_value' => '',
										'placeholder' => '',
										'prepend' => '',
										'append' => '',
										'maxlength' => '',
									),
									array(
										'key' => 'field_5d2109b394d01',
										'label' => 'Online or Offline?',
										'name' => 'online_or_offline',
										'type' => 'select',
										'instructions' => '',
										'required' => 0,
										'conditional_logic' => 0,
										'wrapper' => array(
											'width' => '',
											'class' => '',
											'id' => '',
										),
										'choices' => array(
											'wa__stt_online' => 'Online',
											'wa__stt_offline' => 'Offline',
										),
										'default_value' => array(
										),
										'allow_null' => 0,
										'multiple' => 0,
										'ui' => 0,
										'return_format' => 'value',
										'ajax' => 0,
										'placeholder' => '',
									),
								),
							),
						),
						'location' => array(
							array(
								array(
									'param' => 'options_page',
									'operator' => '==',
									'value' => self::SLUG,
								),
							),
						),
						'menu_order' => 0,
						'position' => 'normal',
						'style' => 'default',
						'label_placement' => 'top',
						'instruction_placement' => 'label',
						'hide_on_screen' => '',
						'active' => true,
						'description' => '',
					));

				endif;
			}
		}

		/**
		 * Add the settings link to the plugins page
		 */
		public function plugin_settings_link($links)
		{
			$settings_link = sprintf('<a href="admin.php?page=%s">Settings</a>', self::SLUG);
			array_unshift($links, $settings_link);
			return $links;
		}
	}
}