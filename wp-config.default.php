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
define('AUTH_KEY',         '37dfa95eb089c78eacdee4d23fd73105d8c59aca');
define('SECURE_AUTH_KEY',  '82b1074d1011d7d35616c96cc6dbddbaf1d3da09');
define('LOGGED_IN_KEY',    '807dd7a339ba0a5fea008bac56eb6c45c4080f08');
define('NONCE_KEY',        'd98198f1890b9b11038ca1c77e54454187933d1c');
define('AUTH_SALT',        '877bcd4b3b719a4fbd98182d66c3852718cedb67');
define('SECURE_AUTH_SALT', '92403fdc38f46f7bab417330bfd46f41078c12fc');
define('LOGGED_IN_SALT',   '95388204886253cbe019a52f82dc5ab5f9801578');
define('NONCE_SALT',       '398d9e2917b7fbb696e0e565660360ed09aa3d76');

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