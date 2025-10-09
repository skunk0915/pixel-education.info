<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the installation.
 * You don't have to use the website, you can copy this file to "wp-config.php"
 * and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'yellowlizard1_pixel' );

/** Database username */
define( 'DB_USER', 'yellowlizard1_pixel' );

/** Database password */
define( 'DB_PASSWORD', '77kWVaf8nnmmDex6EKPUdYTB-_SpQHMj' );

/** Database hostname */
define( 'DB_HOST', 'mysql80.yellowlizard1.sakura.ne.jp' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The database collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

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
define( 'AUTH_KEY',         '2zb*P#5D[jxxX;1#;M]A>CP K,uYB=4gjKjHdiA[iLI|L&#6TB1pr@/p. wD?=w0' );
define( 'SECURE_AUTH_KEY',  'Yr0jh%nC@ W  Nme`)[{d*oP#4!:<e1MWpnB3N]+KREE;oa05~uQE>=B4uZUjAm?' );
define( 'LOGGED_IN_KEY',    '[})o7&0,X=JB41*rtf9D57+Fg2pJ~#<$1!0BI7<!%OGUT|3h^Rb)<Lt#E,8@B4l8' );
define( 'NONCE_KEY',        '0t%i!P>D$)#!bH@p}Pte.Y uK7w9AfTQ#;(6+It6+Sk} $c>F[LL23`qTEz<jJ[%' );
define( 'AUTH_SALT',        'p6Y w|t(w=u00uA_~LTM6s&4no.#tUlhj272G_%W,HZn!8yDSqWu9Ju58D]sc>G#' );
define( 'SECURE_AUTH_SALT', 'wTZ!sHj)HMBKNA9V-~&bzPhjR[+BM^e-u;[[@lL%A:S0G{39-t^x<vMDzDaKq6$%' );
define( 'LOGGED_IN_SALT',   '~Vv@jUfsl2i;HPWN`#!E3mcAL&xRX+8TU0K!3yvch|^{_K/ x+6Mt0vw?88GFHk6' );
define( 'NONCE_SALT',       '&IwrplV7y/~Ky_[vha8f%LCuv#XSJw 5vu-Am]1]XgOiC#@x?MvL^D,wP?4C5RRK' );

/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 *
 * At the installation time, database tables are created with the specified prefix.
 * Changing this value after WordPress is installed will make your site think
 * it has not been installed.
 *
 * @link https://developer.wordpress.org/advanced-administration/wordpress/wp-config/#table-prefix
 */
$table_prefix = 'pixel_';

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
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
