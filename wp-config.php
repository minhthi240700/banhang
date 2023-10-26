<?php
define( 'WP_CACHE', false ); // Added by WP Rocket

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
 * * ABSPATH
 *
 * @link https://wordpress.org/documentation/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'banhang_data' );

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
define( 'AUTH_KEY',         '?A3n8{1Wirn`0*]N@AQxYt4h^|[lWQ_oF7o*+DW2)K/cEZQOM%NK=jb9V2%7GU^,' );
define( 'SECURE_AUTH_KEY',  '*Ch,5dnJTpD#-(G3bu5R)xh,VxAqt9IrH=nz&.T@;h1cc9@&B_]~V{6*+!+#3is2' );
define( 'LOGGED_IN_KEY',    'RB=fWYwQ`Y0oh~*.e}T:]u(Q|S(T8D~{@F]22[=L_p`F:hCy+1A^yA2M1=:(RUi*' );
define( 'NONCE_KEY',        ':&C.deLhLHK]z5{H2RD(>EDD8kd6>(1sUC|H.u!cj-?O[@uN2jq`%36B@ly_xHp*' );
define( 'AUTH_SALT',        'E}q]-sAlT-Cj&4D<gC>N~9f{ndbmb%]2,}wZLR)|S%.yifktiN>1MX4=G:X[J{)Q' );
define( 'SECURE_AUTH_SALT', '?Y+FyIfg=N1,}+HwOSAwb13C-L.T4S*rhzkgeNj(SD}HC{.ZhIW88}w3q:U?/IZ@' );
define( 'LOGGED_IN_SALT',   'Z_m{@D5#!d?[=]P+g=HX6S$2^tHJSA*[JnJCM44Fhdk[W[#6r(G/#igdJde6PE6 ' );
define( 'NONCE_SALT',       ':oZA?~ |D0J 6crU,IIz%zn&?y:m}6Vs+]mmGm}C;Qb<onZLle%,7zd+s0:5(G`=' );

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
 * @link https://wordpress.org/documentation/article/debugging-in-wordpress/
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
