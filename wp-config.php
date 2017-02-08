<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'jeeraa_bb8');

/** MySQL database username */
define('DB_USER', 'homestead');

/** MySQL database password */
define('DB_PASSWORD', 'secret');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         'l).fj !j?AV3NHl.yJ^G$~]_Un)>(VGDaz>y4+0Teli&CIaM5/{K2gt_Dh_X9/Yi');
define('SECURE_AUTH_KEY',  'Bmn@qvylF_p_g[| O8wNc5TD!X<UF]K*_E33^]oi98KSYXVYg]gWx4^7JUX.|u[R');
define('LOGGED_IN_KEY',    's`$[rHKO$zj*46az#83Y~xNW,E@PU!l{Pr@x]>g14T}fGF#LHZZOp&+s@&l&y&w^');
define('NONCE_KEY',        'rUpj}6G))W^;|{VR(~Us=w|2i4!L81XWIPhU;%(J_xhEdCT3n.@.)3HBc&UYqN-X');
define('AUTH_SALT',        'm@bT8`Lx%K/nPQz(2n${<6g~rd?RkipNIOtOG^7KQGNex|W %g&:WS S:x[>ox%3');
define('SECURE_AUTH_SALT', 'Diq&~q3<I5-GZngI0O]|OYysz?I^;H{s3QhwV>PRN9#{qy}E~|nvD 0`oI%mjD;@');
define('LOGGED_IN_SALT',   '{23EK~2Ek7Vv]RGilG-K@K?%{tG4(M0t?Tm>~pxgP5?%NOtG)pKn&58Y6wU>G*QR');
define('NONCE_SALT',       'Rl/Z=qfTI{#jcd)|Qy$;H!R%{6$krA,T?<L>c{>m)f EeA{8i:s]%c!yh_{Ko3 v');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
