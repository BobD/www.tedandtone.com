<?php
/**
 * Default config settings
 *
 * Enter any WordPress config settings that are default to all environments
 * in this file. These can then be overridden in the environment config files.
 * 
 * Please note if you add constants in this file (i.e. define statements) 
 * these cannot be overridden in environment config files.
 * 
 * @package    Studio 24 WordPress Multi-Environment Config
 * @version    1.0
 * @author     Studio 24 Ltd  <info@studio24.net>
 */
  

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8');

/** The Database Collate type. Don't change this if in doubt. */
define('DB_COLLATE', '');

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
define('AUTH_KEY',         '_y(h%S8 %} DdJWXR+Zo[ZG&S_OKztj+w=U%tjlght4g{-+z+%+iZ2)!9_#g,U/4');
define('SECURE_AUTH_KEY',  '1(j-VngHKmK=:/{zXzFM[oH}<r*%y|&q:aw=L2t|{zT)~:5{Hgn|cV]wY^*n o^d');
define('LOGGED_IN_KEY',    'zYKp2VH 8VBD? @#E+x6=<!ZpXImb?HD$KmH8>w&YCMMk=f4yXN{&S<=X@!6x$$L');
define('NONCE_KEY',        '!uV;rJi LB.kr7>AG:{CL?l5>4>Ti?ZkKlv@p~P(/5*a)n,dn&R$qK|K+<?d|Ot[');
define('AUTH_SALT',        '@VnMKqfAQS+Ycr|AC|j_Nf/MM%;[{]{^5($ql.(OPf25|>UG5+6<;{fs|~RFkCUJ');
define('SECURE_AUTH_SALT', 'D-C<)d8eWaMu.jSQDl<2)+KFbwr#{LZiHs-X;yM]!T o8L!tR1i`+k-]_fFm0yCP');
define('LOGGED_IN_SALT',   ']DHHG=a5hX-6 ^YvTDI*=quG$.%dj$Bi,pTItsa-|dZ&@/LyB)stdVix]%,B67a+');
define('NONCE_SALT',       '4dl-KLbPJx#QCQAAuJO<4IdAv9X=mjDcW%r+uh?7l;,`.4Gzl$tU,u#Zg/^j D- ');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each a unique
 * prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * WordPress Localized Language, defaults to English.
 *
 * Change this to localize WordPress. A corresponding MO file for the chosen
 * language must be installed to wp-content/languages. For example, install
 * de_DE.mo to wp-content/languages and set WPLANG to 'de_DE' to enable German
 * language support.
 */
define('WPLANG', '');

/**
 * Increase memory limit. 
 */
define('WP_MEMORY_LIMIT', '64M');