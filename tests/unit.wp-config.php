<?php
/** The name of the database for WordPress */
define('DB_NAME', 'wordpress_unit_test');

/** MySQL database username */
define('DB_USER', 'wordpressuser');

/** MySQL database password */
define('DB_PASSWORD', 'password');

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
define('AUTH_KEY',         'T9uaQ.L?whu&bwr_tqr!iU`;7dLe}6X)M7QfFl={p%D W04Uq?B<{LE@`*zqsi-5');
define('SECURE_AUTH_KEY',  'pL=O8vXF``oYRF%)@Gj}cL1I]kg;I-.wd$BKsCz7|2W=@G+pZ-]Vn.#+ip@XFu{w');
define('LOGGED_IN_KEY',    'A*kX2KVr;0MrXM= WO4{={iFX[)dTS*xNp&Srf=fQ@K[i;eRfbhM2QZ]}HVNTF4j');
define('NONCE_KEY',        'U[KdjthPf:Osl^=)6^46>4@A(4 ZG3:GHagEReyY|~z[M^-`@q]880tA+Nvtwj.=');
define('AUTH_SALT',        'pdB|QC5Nu~@@:2;1kiDvv*5BO5{?TI`X--HhLE2Rq~>^TQMg0k}rMi5N&lcWKh}`');
define('SECURE_AUTH_SALT', '2zKC][ZeMzv<+grwZLN9{4|Q{$(8nZ-I11W@o15c1NkCt)+#J*RThvaufwA?xuq|');
define('LOGGED_IN_SALT',   't`b6>$gr/Y:1#>En aHoyS;0RuL6CsMoA/6;*cN7>7N32xCPy6(A0--yrr,)d,f&');
define('NONCE_SALT',       's2]l~.ST35wP;~9=bG9$AN)t%*%cc-%v&(` 1W1aa{Li83r+IFav+IB4!1&w9hl.');

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
define('WP_DEBUG', TRUE);

/* That's all, stop editing! Happy blogging. */

/** Absolute path to the WordPress directory. */
if ( !defined('ABSPATH') )
	define('ABSPATH', dirname(__FILE__) . '/');

/** Sets up WordPress vars and included files. */
require_once(ABSPATH . 'wp-settings.php');
define('FS_METHOD', 'direct');