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
define( 'DB_NAME', 'mysite1' );

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
define( 'AUTH_KEY',         'b6n:%8mXn=ND ngubNhrf=#3m5^ujk>I].bKfW5[7V%[.c5tXCu)wooVSSb 4kD}' );
define( 'SECURE_AUTH_KEY',  'bb[Xz=*I:!]KM4gVqQ.r*yY^I&NcN|d/:tmNyA0,V]&5G+i4Mx)~2}3`p?K i#lD' );
define( 'LOGGED_IN_KEY',    '-n#p:m?EWV)C27>U[(4@v]vu?hu!{g*f9$uQ+C;}_ZtS1<b<B{iJIP[LV`9y_CR3' );
define( 'NONCE_KEY',        'q_aAk(vsmfLA:&F+<bOUK &r<XKKuaPc!dP q5b==09|I:{yRDGD~QVqh`1CJL J' );
define( 'AUTH_SALT',        'y0%*}7%Uw?(IB8raq%C+|m-~R|-L9]qmdQ2J;/;~[2Ue-FPyG0HFTdY]8Xi#`JDF' );
define( 'SECURE_AUTH_SALT', 'JDSLBBYlWLQN>U+8>7<XN^^VX&NPXV~wQa^U1JVHOhO*lld*=v-D`F9o).NR1Yh0' );
define( 'LOGGED_IN_SALT',   'VBNk[zAal?bG5D1&`y%5+_<uZ[X:}`Gqj<p$|kCi3XQnQVD)30$vAJAFwtnE:t9o' );
define( 'NONCE_SALT',       'r(/@kl.2,QS^`e;@CDa9mpw{*U@aAdbX-]N4rI_`,n=8cY[[sZ};(1con7kDHD=!' );

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
