<?php if ( ! defined( 'ABSPATH' ) ) exit;

return apply_filters( 'ninja_forms_plugin_settings_defaults', array(

    'date_format' => 'm/d/Y',
    'currency' => 'USD',

    'recaptcha_site_key' => '',
    'recaptcha_secret_key' => '',
    'recaptcha_site_key_3' => '',
    'recaptcha_secret_key_3' => '',
    'recaptcha_lang' => '',

    'delete_on_uninstall' => 0,
    'disable_admin_notices' => 0,

    'builder_dev_mode' => 1, // Enable "Dev Mode" for existing installs.
));
