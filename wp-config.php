<?php

// Load DB from DSN URL
if ( ! getenv( 'DATABASE_URL' ) ) {
	die('No DATABASE_URL DSN');
}

// SSL detection
function p75_isSSL(): bool {
	return ! empty( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] !== 'off';
}

// SSL Support
if ( $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https' ) {
	$_SERVER['HTTPS']       = 'on';
	$_SERVER['SERVER_PORT'] = 443;
}

$DSN = parse_url( getenv( 'DATABASE_URL' ) );
// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define( 'DB_NAME', substr( $DSN['path'], 1 ) );
/** MySQL database username */
define( 'DB_USER', $DSN['user'] );
/** MySQL database password */
define( 'DB_PASSWORD', $DSN['pass'] );
/** MySQL hostname */
define( 'DB_HOST', $DSN['host'] );

// Salts
define('AUTH_KEY',         '6wv+RCRjvVShJ0;t]Z@-;2`o3)/koJZSU o/EiG6]t|1-Ud$y{`k.#&/7j7inC),');
define('SECURE_AUTH_KEY',  '#A.%+%*4(Y-47DKl8+QI!/,j@yL+<%)1XN$sZ%fGnbo]9|-%&:<Ox!]kUcj/T{VK');
define('LOGGED_IN_KEY',    'PbLAY9V[=p|W*l$f=&ek2nw_Tvr0]|J,yYF%YmTgAET|Rx|yCyCi+-Sf7Xckrk{V');
define('NONCE_KEY',        '7&%Q]?DQbx-yXBQCFE/;J=S?/xG-`0;/S%OOi;~!]_2[UV|YfXkS3N_^vjRVB cu');
define('AUTH_SALT',        'rv_%;3*C%1KmC|p-X:`Ms+QS0k5!x0eUJGJ+=BL8kb]VY_8CSq]Z>KE+TE0r}=85');
define('SECURE_AUTH_SALT', '4[y)MRGm1_/R~vFfi;GWs9|>s:5Mt2Q/j$]:x8DqwV}#hO/h2a${r@f>yS{HT|`-');
define('LOGGED_IN_SALT',   'bn y!7dl`s`avA:O$PfX4|5:GQeLncg+nE}0]N&-&H`TE__{uR]vm-1Zh?{{8bo`');
define('NONCE_SALT',       'v?Diw~pU_F1gG2NoLNd++mYjK7W-1(.8QX>R+WW{hk$fhF]]lYEStq31MfqI>-&n');

// DB Prefix
$table_prefix = 'wp_';

// Config
define( 'WP_CONTENT_DIR', __DIR__ . '/wp-content' );
define( 'WP_CONTENT_URL', ( p75_isSSL() ? 'https' : 'http' ) . '://' . $_SERVER['HTTP_HOST'] . '/wp-content' );
define( 'ABSPATH', __DIR__ . '/wp/' );

// S3 Compatible Bucket
define( 'AS3CF_SETTINGS', serialize( array(
	'provider' => 'do',
	'access-key-id' => getenv( 'S3_UPLOADS_KEY' ),
	'secret-access-key' => getenv( 'S3_UPLOADS_SECRET' ),
) ) );

// Debug
define( 'WP_DEBUG', false );
define( 'WP_DEBUG_LOG', false );
define( 'WP_DEBUG_DISPLAY', false );
define( 'SAVEQUERIES', false );
define( 'SCRIPT_DEBUG', false );

// Security
define( 'DISALLOW_FILE_EDIT', true );
define( 'DISALLOW_FILE_MODS', true );
define( 'FORCE_SSL_LOGIN', true );
define( 'FORCE_SSL_ADMIN', true );

// Easy URL override for duplicating environments
if( getenv( 'WP_URL' ) ) {
	define( 'WP_HOME', getenv( 'WP_URL' ) );
	define( 'WP_SITEURL', getenv( 'WP_URL' ) );
}

/* Load WP */
// Bootstrap WordPress
require_once ABSPATH . 'wp-settings.php';
