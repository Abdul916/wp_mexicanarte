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
define( 'DB_NAME', 'wp_mexicanarte' );

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
define( 'AUTH_KEY',         '-K(d4z^AcDO)+a&5c}*D!$+]@&$:HAey+Xq<p(k.B+=>c^zFr9 &~W$G:1:=W4&:' );
define( 'SECURE_AUTH_KEY',  'K~2KK4=Fv8!Wmq5rU;!LP]Z(S|qBJ9~_,Mgrd-H-@H&.FA`>j@(.L{j$.eLM;`mK' );
define( 'LOGGED_IN_KEY',    '>=;|KwXi7,wZ}lnD:P)(t*-mC_o;xGtq9>TC~PN%FIR2T!?zZ ?|bH0VYUUb-K]l' );
define( 'NONCE_KEY',        'IkV1Bdn0<!VRO:$SIRQ}c3q8V<)d`HRZt:e7r3z>Ja(LRK:j?X%lEwY;dBVyF;EP' );
define( 'AUTH_SALT',        'QZ%~yq:`Io+x4($V-6QT[?}ojdsyJAm-nt@UkWnt?-<:6k( 6m5NN L/[6wuZMgG' );
define( 'SECURE_AUTH_SALT', 'ePi_zp9UtdXnF3C1Bly-=Pq$KZ--DY^`-K6D_Q]y8*$3LO!,9]71-=$m+PGpb7%3' );
define( 'LOGGED_IN_SALT',   'Be&TKci4n1+-{OZs@=Hb6*^yq[]@*LetyK=Z1ygSVcal1)t8s:,Imew}UE|_W-hq' );
define( 'NONCE_SALT',       ']g,T7euPc*9^5YKw:^Ew`.w?nWvJ^syuQVE7&<0bnp&[(r8-&vXl!QkimiuLdK1H' );

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



define( 'WP_CACHE', TRUE );
define( 'WP_AUTO_UPDATE_CORE', false );
define( 'PWP_NAME', 'mexicanartestg' );
define( 'FS_METHOD', 'direct' );
define( 'FS_CHMOD_DIR', 0775 );
define( 'FS_CHMOD_FILE', 0664 );
define( 'WPE_APIKEY', '7a795bfe497d5511f42d88c2cb453cd687b667d6' );
define( 'WPE_CLUSTER_ID', '141000' );
define( 'WPE_CLUSTER_TYPE', 'pod' );
define( 'WPE_ISP', true );
define( 'WPE_BPOD', false );
define( 'WPE_RO_FILESYSTEM', false );
define( 'WPE_LARGEFS_BUCKET', 'largefs.wpengine' );
define( 'WPE_SFTP_PORT', 2222 );
define( 'WPE_SFTP_ENDPOINT', '' );
define( 'WPE_LBMASTER_IP', '' );
define( 'WPE_CDN_DISABLE_ALLOWED', true );
define( 'DISALLOW_FILE_MODS', FALSE );
define( 'DISALLOW_FILE_EDIT', FALSE );
define( 'DISABLE_WP_CRON', false );
define( 'WPE_FORCE_SSL_LOGIN', false );
define( 'FORCE_SSL_LOGIN', false );
/*SSLSTART*/ if ( isset($_SERVER['HTTP_X_WPE_SSL']) && $_SERVER['HTTP_X_WPE_SSL'] ) $_SERVER['HTTPS'] = 'on'; /*SSLEND*/
define( 'WPE_EXTERNAL_URL', false );
define( 'WP_POST_REVISIONS', FALSE );
define( 'WPE_WHITELABEL', 'wpengine' );
define( 'WP_TURN_OFF_ADMIN_BAR', false );
define( 'WPE_BETA_TESTER', false );
umask(0002);
$wpe_cdn_uris=array ( );
$wpe_no_cdn_uris=array ( );
$wpe_content_regexs=array ( );
$wpe_all_domains=array ( 0 => 'mexicanartestg.wpengine.com', 1 => 'mexicanartestg.wpenginepowered.com', 2 => 'mexicanarte.com', 3 => 'www.mexicanarte.com', );
$wpe_varnish_servers=array ( 0 => 'pod-141000', );
$wpe_special_ips=array ( 0 => '35.196.224.153', );
$wpe_netdna_domains=array ( );
$wpe_netdna_domains_secure=array ( );
$wpe_netdna_push_domains=array ( );
$wpe_domain_mappings=array ( );
$memcached_servers=array ( );



/* That's all, stop editing! Happy publishing. */

/** Absolute path to the WordPress directory. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Sets up WordPress vars and included files. */
require_once ABSPATH . 'wp-settings.php';
