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
define( 'DB_NAME', 'wordpress' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'kartik@123' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

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
define( 'AUTH_KEY',         'Q#T8?hh3&AEkH30<$Z,7}cIF*O9,jb]cw<4c9hCQ`I]#Gh[59CkhIJwOf*^b9zKV' );
define( 'SECURE_AUTH_KEY',  '6:!d.D6O#t&)e*k*n6?N=gZQvI*`hyey.]78^R<CRtGwbV.9loU~;{mPJQp8-JVH' );
define( 'LOGGED_IN_KEY',    '/@b!y}#G`-+WVw^Y|>T6~=0MO@f|Q76k,N->Ly:XC_fIrkpc1Hu!H-AGI%ah:6d ' );
define( 'NONCE_KEY',        '9Q(_K3>cYFvr{}vbI?4J)dj0]{.D}A&09`av[^z-Pp_`hMP|HpF]@L!|jhin.Mst' );
define( 'AUTH_SALT',        '<c`yj<)};[j8_Af{O>.h?@pH9WfgePH^zt^MZF/<hz#mM!-=!hcV&^wykSj#q6T/' );
define( 'SECURE_AUTH_SALT', 'G {U@/regx!3@a{{{.u?;`u%)[nx`Dy;tb1AkiKS3;kDpA/:RkYebv cXJA;i `m' );
define( 'LOGGED_IN_SALT',   '=hq]mc10o~hc!<,MgQ^]v= Ib$}xK.8]v@K|Kl>6jdW/Q!XJKo~zfn?_g78+}3=,' );
define( 'NONCE_SALT',       '_ (0asz<q:#Z{*z7Gq;O8&}^WW[@cWpv>]`~cDQA(lEQeG/J|tl8-X]^2cF=hh]m' );

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
 * @link https://developer.wordpress.org/advanced-administration/debug/debug-wordpress/
 */
define( 'WP_DEBUG', true );
define( 'WP_DEBUG_LOG', true );
define( 'WP_DEBUG_DISPLAY', false );

/* Add any custom values between this line and the "stop editing" line. */



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
