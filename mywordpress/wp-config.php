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
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Database settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', 'mywordpress' );

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
define( 'AUTH_KEY',         '%wdkn.6w)c#.IGv9;;Tgcwd6XkzD]COo!gs(Rn.~GvS?%o7X0w]o5m.3j5yvElsG' );
define( 'SECURE_AUTH_KEY',  '[Iq19F_m3`IuxArj07VNA-)vfBe8:oR53Y*SnO4L~V?_Yi>*%{(S:>?tdcIjxxc^' );
define( 'LOGGED_IN_KEY',    'MtACtReqiPB`p-*i[.n@[K+z{2?26 dX5cXkoHNR-6_}~i7gXZg4.dIm7[I&w(.F' );
define( 'NONCE_KEY',        'smI%Ms%%]api6}Au:]P/,}(cIQ[%>&uWx%WzIkBb7QDLe6jh6~8gsg^}0*mmO+-)' );
define( 'AUTH_SALT',        '[:F{a?0J`LSJf$2[+3t`)+Qay^=y  6HU*A(TTdb^LIH4~wrkO7EjU^*j * +Ap6' );
define( 'SECURE_AUTH_SALT', '&;Az|z(KfLL4E*h.e5Tf}$p:*}*`[?=1VA4h`&$ff^9BU 2?O8B=Gf]{J mg0Zew' );
define( 'LOGGED_IN_SALT',   '`WZ :Lk;8+EoS~^6~W~/K0>.9>G1LquC5IG3bqr=n8D3{%{V,/?y[4=d~A2@1<Of' );
define( 'NONCE_SALT',       ' `wak84e$&lKG+@iEggCOJK8& S]^{UFzdvk)a;!za>*F(?ML2lY#|uL(/`<e8Qs' );

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
