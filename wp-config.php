<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL settings - You can get this info from your web host ** //
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress');

/** MySQL database username */
define('DB_USER', 'root');

/** MySQL database password */
define('DB_PASSWORD', 'root');

/** MySQL hostname */
define('DB_HOST', 'localhost');

/** Database Charset to use in creating database tables. */
define('DB_CHARSET', 'utf8mb4');

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
define('AUTH_KEY',         '1HPM20;;uwE0PN-nJ>]^]Hx(sVb!vb&2W {Nr$w#ufG|C_20o}6=X9.Zu.!`FHw*');
define('SECURE_AUTH_KEY',  'Bu2OPwq9W<j-Yj:AV-Cu&bJvG11f@oF_I6;qm@Yp8dpx,}R6;@8.r$|FsqTW6_mp');
define('LOGGED_IN_KEY',    ';&9Pq9,B-78E#|wu$*9ltiCoo?+J=K.0fu(.8#^^DUKw=#HT>u_!ZwKI3fGR?Cq`');
define('NONCE_KEY',        '.> U&&~v>g,g2C|GVEz,Dbdmsda|zX!kG{[ mM5-jA%}MMc!N]E|o;OW7XDzv@Sx');
define('AUTH_SALT',        '-T@E.tAC1RNuHYmqX<ord-oK$R!tZ_Nx5m20%&7i7&(`w`fQqF>Uz#!Lib*>x+_H');
define('SECURE_AUTH_SALT', 'Y;s.uK~;aQoc*{Lmp7=E4qez8jWgIbeFo^d-y,v[q2y{9:$fP^pi73sJ/uHm=66E');
define('LOGGED_IN_SALT',   'p<:hS[5~zOLx==e$-vl.G=XN@BiZh!w`U_0Ztju;LkmJKs`uApt4/]2QgF<Oqoe^');
define('NONCE_SALT',       'S4tT>(&w?XI,58+0hC<wnFmFf/5>N(Bmg`Wj.*~K)&Bk<WG;1)n=#%,<FAolI1{)');

/**#@-*/

/**
 * WordPress Database Table prefix.
 *
 * You can have multiple installations in one database if you give each
 * a unique prefix. Only numbers, letters, and underscores please!
 */
$table_prefix  = 'wp_';

/**
 * For developers: WordPress debugging mode.
 *
 * Change this to true to enable the display of notices during development.
 * It is strongly recommended that plugin and theme developers use WP_DEBUG
 * in their development environments.
 *
 * For information on other constants that can be used for debugging,
 * visit the Codex.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define('WP_DEBUG', false);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
