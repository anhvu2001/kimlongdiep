<?php
/**
 * Plugin Name: Performance Lab - SQLite module (Drop-in)
 * Description: Performance plugin from the WordPress Performance Team, which is a collection of standalone performance modules.
 * Version: 1.8.0
 * Author: WordPress Performance Team
 * Author URI: https://make.wordpress.org/performance/
 *
 * This file is auto-generated and copied from the performance-lab plugin.
 * Please don't edit this file directly.
 *
 * @package performance-lab
 */

define( 'PERFLAB_SQLITE_DB_DROPIN_VERSION', '1.8.0' );

// Bail early if the SQLite implementation was not located in the performance-lab plugin.
if ( ! file_exists( '/home/test.kimlongdiep.com/public_html/wp-content/plugins/performance-lab/modules/database/sqlite/wp-includes/sqlite/db.php' ) ) {
	return;
}

// Define SQLite constant.
if ( ! defined( 'DATABASE_TYPE' ) ) {
	define( 'DATABASE_TYPE', 'sqlite' );
}

// Require the implementation from the performance-lab plugin.
require_once '/home/test.kimlongdiep.com/public_html/wp-content/plugins/performance-lab/modules/database/sqlite/wp-includes/sqlite/db.php';
