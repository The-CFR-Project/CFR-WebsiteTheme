<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the web site, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'CFRProject' );

/** MySQL database username */
define( 'DB_USER', 'root' );

/** MySQL database password */
define( 'DB_PASSWORD', '' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

if ( !defined('WP_CLI') ) {
    define( 'WP_SITEURL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
    define( 'WP_HOME',    $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['HTTP_HOST'] );
}



/**#@+
 * Authentication unique keys and salts.
 *
 * Change these to different unique phrases! You can generate these using
 * the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}.
 *
 * You can change these at any point in time to invalidate all existing cookies.
 * This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'KqpF6IGy0aUrpZCLBLYlNL6xABanNKv5qsQTYXqdapQkMFPd9EZpgqBK8SQv7EYe' );
define( 'SECURE_AUTH_KEY',  'TBroUxVtgb49OHXbPdu7RQzAQaewgbw8FoIDiBtGgyKYJBYg1JtEtXaxNTgSGHfA' );
define( 'LOGGED_IN_KEY',    '55SVni2RHQ2mkC4f64RooQO7Vv6IFlPG8hhnm8xoiDwTKPYAOtRbqfnmRusLZlxt' );
define( 'NONCE_KEY',        'WeULRzH9BW4C0mP6QPHZs8a4lu07xstZqkNYufGUi858BpdIeJKXfVHDuLtJqLX5' );
define( 'AUTH_SALT',        'ystRbFBIYSrT5MphIvmupR8Z6O0PB4lflRweVsVQ07VLUYIzqZzlh6i8SmsTurTg' );
define( 'SECURE_AUTH_SALT', 'iQ5FP5STnmtQsEIA6FGrzAXUbB5raRGReuKg8TtJeB5ZqXt472CqCUTjmKO1079s' );
define( 'LOGGED_IN_SALT',   'fjzooLbNwM1uLPmz1jKgZtZKWXDAtQJe17eqY5w5t7Fb8vzVqw5KN7Ii3oxqQmqC' );
define( 'NONCE_SALT',       'hTFkzg3McCEr8UxZE1FRdoI6pSQt3LtPBJyZo2vmZP8W72TSTpHsbrQKcSylSOVd' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the documentation.
 *
 * @link https://wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
