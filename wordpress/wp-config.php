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
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'wordpress_baza' );

/** MySQL database username */
define( 'DB_USER', 'Stefan' );

/** MySQL database password */
define( 'DB_PASSWORD', 'triClana' );

/** MySQL hostname */
define( 'DB_HOST', 'localhost' );

/** Database Charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Don't change this if in doubt. */
define( 'DB_COLLATE', '' );

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'Ja4Mt9Rqz7%q=+:U`*XIs1jn,I779ebH(+teB}S59tY[)`4t=E]#)BKUO~e-l<dj' );
define( 'SECURE_AUTH_KEY',  'aWSNkP?}lsX;vrZ?YPqX:9#MT- To-Qoo.eJYz{y/(P.nB*.g{c?Phi~<zp^u/Xk' );
define( 'LOGGED_IN_KEY',    'sAPiq<oy+!Sh#|,+Ib{o~xWE@!j:~:3(3BL@XIgd[`ercj{<FYujV3!j ZU-m<jx' );
define( 'NONCE_KEY',        'LuckYy)ahoRTH}8:Cm@IP74;?MBztyramlcOZv~+w`i;l)?i_5.VV6J^X/ZVF.Vf' );
define( 'AUTH_SALT',        '-X>exa1F/9hXC]<goR!a6c@JsIoH8CSj>TcUgo|7n~.leDYk],Qj.,d)u h@y0Am' );
define( 'SECURE_AUTH_SALT', 'QjcCY76D{sgijOd;f=rD5kR?BEyg8^&HGmz60}=d`JhfOBt$6Kn]x1@p5Mla0XIC' );
define( 'LOGGED_IN_SALT',   'G#%QAq !(:,BgTL d|HTw>^A3e]~Rn3A^_&TY{or)PyHAmqI)0$@bA[8|_]2$lUA' );
define( 'NONCE_SALT',       '`Qbg[p1#Z0nc>KpTEKRS;(A84(k1=-ovK57 ]d9iPFe -AGUL6Wj-.N#;t)OTgDk' );

/**#@-*/

/**
 * WordPress Database Table prefix.
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

/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
