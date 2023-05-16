<?php
/** Enable W3 Total Cache */
define( 'WP_CACHE', true ); // Added by W3 Total Cache



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

define( 'DB_NAME', "bvapp" );


/** Database username */

define( 'DB_USER', "root" );


/** Database password */

define( 'DB_PASSWORD', "" );


/** Database hostname */

define( 'DB_HOST', "localhost" );


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

define( 'AUTH_KEY',         ';:H4=fG[7s?W}COZO _>[<OyNd-EjrdFdOHH),:8<r|}Lb0#f$!oedEE,7`Rdw>z' );

define( 'SECURE_AUTH_KEY',  '?ymYCQ,WEzv<aK_6Pe6hB8wPXQV;]{sL-ve~3=kw>2m&H3k)=HfEu&k/iz0)#v-V' );

define( 'LOGGED_IN_KEY',    'c+#L|%}FGNB$e}D-(f{AtCYb/l::S[9G/M)8EW[r0DQ8W-OJvS@$&X&q:KN12B2{' );

define( 'NONCE_KEY',        'QM4#~egxNCs.H8)Ae[/N@`}s;0!ol3ZN?6GR,Qp)OxAHD>-8`VH/(H(wu=&Xt3Z9' );

define( 'AUTH_SALT',        '/hL)DT /zpbZQiHT&6 7jO#D&6%![1&D5eO|<.aap]X yTEA)A+1`RB14i!rh7VN' );

define( 'SECURE_AUTH_SALT', 'LJS0u]<7,svLWybH%|u iui1`XUX@0EsGmsD`IZze1P/bk=X;qwW*z34wZV]D,eg' );

define( 'LOGGED_IN_SALT',   'MyyU0xC]}==e_0v,%WP7S:=p~Sp. oKmeq0LW6Irt2?T5]vkyDuj-v=}JD%se6K' );

define( 'NONCE_SALT',       'bc8N{0Jzky^u71S;`$r79ahp)@ho*S`75r,kUWJV(%q7|L!m3gjeBF`9ygRNj~VS' );


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




define( 'FS_METHOD', 'direct' );
/**
 * The WP_SITEURL and WP_HOME options are configured to access from any hostname or IP address.
 * If you want to access only from an specific domain, you can modify them. For example:
 *  define('WP_HOME','http://example.com');
 *  define('WP_SITEURL','http://example.com');
 *
 */
if ( defined( 'WP_CLI' ) ) {
	$_SERVER['HTTP_HOST'] = '127.0.0.1';
}

define( 'WP_HOME', 'http://localhost/bvapp' );
define( 'WP_SITEURL', 'http://localhost/bvapp/' );
define( 'WP_AUTO_UPDATE_CORE', 'minor' );
/* That's all, stop editing! Happy publishing. */


/** Absolute path to the WordPress directory. */

if ( ! defined( 'ABSPATH' ) ) {

	define( 'ABSPATH', dirname(__FILE__) . '/' );

}


/** Sets up WordPress vars and included files. */

require_once ABSPATH . 'wp-settings.php';

/**
 * Disable pingback.ping xmlrpc method to prevent WordPress from participating in DDoS attacks
 * More info at: https://docs.bitnami.com/general/apps/wordpress/troubleshooting/xmlrpc-and-pingback/
 */
if ( !defined( 'WP_CLI' ) ) {
	// remove x-pingback HTTP header
	add_filter("wp_headers", function($headers) {
		unset($headers["X-Pingback"]);
		return $headers;
	});
	// disable pingbacks
	add_filter( "xmlrpc_methods", function( $methods ) {
		unset( $methods["pingback.ping"] );
		return $methods;
	});
}