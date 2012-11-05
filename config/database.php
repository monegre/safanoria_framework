<?php
/**
 * Defines the base configuration of Safanòria installation.
 *
 * - Database settings
 * - Table prefix (if any)
 * - Root URI (BASE_URL)
 *
 */

/** Database settings */
define ('DB_NAME', '[database]'); // Database name
define ('DB_USER', '[user]'); // Database user
define ('DB_PASS', '[pass]'); // Database pass
define ('DB_HOST', 'localhost'); // Database host
define ('DB_CHARSET', 'utf8'); // Character encoding
define ('DB_DSN', 'mysql:host=localhost;dbname=[database]'); // If you're ever using a rough PDO connection
define ('DB_TABLE_PREFIX', '[db_table_prefix]'); // Tables prefix