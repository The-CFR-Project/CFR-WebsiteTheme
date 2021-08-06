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
define( 'DB_NAME', 'CFRWebsite' );

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
define( 'AUTH_KEY',         'hJZLkjfkmb5nAHM5FEIxbVDj365VkClzkj1Hc9fJdJzkA6oJkiUqJgYVgPPl8Ook' );
define( 'SECURE_AUTH_KEY',  'lpZgXbXBid2iGKqCxSAbOolNNfNkqrlrkNgTlYJPjOUfhJVpoPsgcHsFcxnlDHuO' );
define( 'LOGGED_IN_KEY',    'x0QD5SVs6xP4kThlP7N2NilMImszMjYwYEvE0nOOgNxsnfL38fJ4SLkuFJnJFVOc' );
define( 'NONCE_KEY',        '09dEBhRkQn0ukSHdyBvP1C9usSiOwkUPLgSAsVeua1fPzfWn3wGPeV7AtIB7DpMF' );
define( 'AUTH_SALT',        'cbrpX3DpFppctUVRbNfYzclNcV6D7GQ680AfDzaZ2LBUfsmy6vX3byujRVGfgTNP' );
define( 'SECURE_AUTH_SALT', 'riz7d6qddnaCwhublrJ1oWL2CxvYqfu6o1y2vYDX5ypZ7d78LXDwWA6Pqo8IWZRX' );
define( 'LOGGED_IN_SALT',   'p4tEqIAAHswNXGUPisDngKykdFRaFXRZnzIb73HyeZRtS33h18Y8RxxQtDDDmPaE' );
define( 'NONCE_SALT',       '7SfPMf0OqCUG78HPBQggwESkEVbGljzzRjzeOIdWsDi7es9cOPfEJQQZbPoJAjnN' );

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

 /*
 Change to false after theme creation complete
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', true );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
