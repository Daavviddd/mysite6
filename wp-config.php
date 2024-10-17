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
define( 'DB_NAME', 'mysite6' );

/** Database username */
define( 'DB_USER', 'root' );

/** Database password */
define( 'DB_PASSWORD', '' );

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
define( 'AUTH_KEY',         '4ic:Jz8x|NSu.5#W=cX+AY-vz!ZutCu^-dUi?sHOq(yVBe5-6!Lsti{g}P@$9SmG' );
define( 'SECURE_AUTH_KEY',  'jdSx=jYSi(84pGV(%(Gv8tQ=#|Ih6|O>p!_OYnxeE0<kgR_JXDbS>L|P7R2k3K91' );
define( 'LOGGED_IN_KEY',    'OW<?792a7h22@2=9YnC;{z[2mc!$]tln2&x3FoE3U`517bdp8yl-)/-n^SY.ovn(' );
define( 'NONCE_KEY',        'u=2`atC~usZ#[n~o)(71NqBB9)>xQotwyB%oy~OsJ~)5{GUZZ!Ss{w+F_R&nA!^2' );
define( 'AUTH_SALT',        '@4xE!{PllPY]5]@pcq7cwSc(AFJi]vFB28x;GLWt.VF$5cx;=J_|-clTw`(vm[W$' );
define( 'SECURE_AUTH_SALT', '|V~dm*rYD?Z$|,6&4jLX#xPddW8[ePsd#c8h[qlr;]4HtoCOp};es=^e7Y5oy@<@' );
define( 'LOGGED_IN_SALT',   'siw_2;o6P~G!7_<DdLWjX|3c(_NtCkQX^$$nr8kbKyx^&z>1##XQH.7bs,54P%:f' );
define( 'NONCE_SALT',       'jW,M5_2MZ~.W~!:B.>Ft@U@;.;Ao(R+x.[{P<YuHtrp.J;JR 8f?*csbB@s?U?}4' );

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
