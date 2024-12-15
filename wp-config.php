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
 * * Database settings
 * * Secret keys
 * * Database table prefix
 * * Localized language
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'local' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', 'root' );

/** Database hostname */
define( 'DB_HOST', 'localhost' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );

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
define( 'AUTH_KEY',          'AB@[s0$JY-3E@FUu;#q]Hx`nw@!m&cNu@*fUgi(^;ZSh1NhdP&VOq_&Tu-w,N.{9' );
define( 'SECURE_AUTH_KEY',   'Mt%EYf[>vp3n|^tM]QyYj2Iobb|AhLg3*Ww5ebeVJJu~GyEW/BrA:js%@8506jP#' );
define( 'LOGGED_IN_KEY',     'hoJv5*3z=XG(~H6I;!.eppZXAgU2R}18MNA8P?H3Bq_ bVXiP7v`j&gX13FZ(BNw' );
define( 'NONCE_KEY',         'J02HKNX<8SJr5jl%A$$b?r$QeS5u; :-G@#,Np-uC|9@U8FzVdC.7*~/Xw+:n#[m' );
define( 'AUTH_SALT',         '/hN0]B`u0:QY6s?tbb99H)b{j`Mbs$/89/I+:x4(jX;qvQh#P3nO1=gtBOe$|lOu' );
define( 'SECURE_AUTH_SALT',  'l#BJ8d3T|?$!]YJ_T~`u!fDSwZCK23diGcfW>e^;j}`*&>&qH4<!#{Y$p~o]UJ]6' );
define( 'LOGGED_IN_SALT',    'QLM(I,[UOHE:`>XjnwML.t=`kJRqdy8.D-%-8Rq9QUzW?m}!qArV[j$f0Oqa9kfP' );
define( 'NONCE_SALT',        '5u`|H8)-fet;znWc>DE{[O^^7!}*M<oz1?#Jcu-tWaMJ39]p6;_!c75zU&Kv@UP(' );
define( 'WP_CACHE_KEY_SALT', '+f[Z^>;LP0tgahJ+MpEUNpJ[zaA`q^K*t:=WV3scg,@guy`4W{uelG)4jt0cg`EZ' );


/**#@-*/

/**
 * WordPress database table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix = 'wp_dexvukxw1q_';


/* Add any custom values between this line and the "stop editing" line. */



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
if ( ! defined( 'WP_DEBUG' ) ) {
	define( 'WP_DEBUG', false );
}

define( 'WP_ENVIRONMENT_TYPE', 'local' );
/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
