<?php
/**
 * Wikimini MediaWiki LocalSettings switch.
 *
 * This file was imported and adapted from wikimini.org
 *
 * See https://phabricator.wikimedia.org/T268292
 */

/**
 * Debug or mainteinance stuff
 */
if( !defined( 'WIKIMINI_DEBUG' ) ) {
	define( 'WIKIMINI_DEBUG', false );
}

/**
 * Eventually show more info
 */
if( WIKIMINI_DEBUG ) {
	$wgShowExceptionDetails = true;
	$wgShowDBErrorBacktrace = true;
}

/**
 * Whitelist of accepted domains
 */
define( 'WIKIMINI_MAIN_DOMAINS_KNOWN', [

	// official frontend website in migration status
	'wikimini.org',

	// mirror website handled by Wikimedia CH
	'wikimini.wikimedia.ch',

	// testing domain (not actually existing)
	'test.wikimini.org',
] );

/**
 * Whitelist of accepted subdomains
 *
 * This is the list of all the wikis.
 */
define( 'WIKIMINI_PROJECTS_KNOWN', [
	'ar',
	'it',
	'en',
	'es',
	'fr',
	'lab',
	'stock',
	'sv',
] );

/**
 * define WIKIMINI_PROJECT_UID e.g. 'stock'
 * define WIKIMINI_MAIN_DOMAIN e.g. 'wikimini.org'
 */
( function() {

	// host declared by the client
	$host = $_SERVER['HTTP_HOST'] ?? null;

	// split the host in subdomain and rest of the domain
	$parts = explode( '.', $host, 2 );

	// avoid errors when in 'localhost' or wrong domains declared client-side
	if( count( $parts ) === 2 ) {

		// split the host in subdomain and rest of the domain
		list( $uid, $main ) = $parts;

		/**
		 * No known domain no party
		 */
		if( !in_array( $main, WIKIMINI_MAIN_DOMAINS_KNOWN, true ) ) {
			http_response_code( 400 );
			die( 'The requested domain was not recognized.' );
		}

		/**
		 * No known project no party
		 */
		if( !in_array( $uid, WIKIMINI_PROJECTS_KNOWN, true ) ) {
			http_response_code( 404 );
			die( 'The requested wiki does not exist.' );
		}

		// gotcha!
		define( 'WIKIMINI_PROJECT_UID', $uid  );
		define( 'WIKIMINI_MAIN_DOMAIN', $main );

	}
} )();

/**
 * No valid domain no party
 */
if( !defined( 'WIKIMINI_MAIN_DOMAIN' ) || !defined( 'WIKIMINI_PROJECT_UID' ) ) {
	http_response_code( 400 );
	die( 'Unexpected request' );
}

/**
 * Declare the URL of a generic Wikimini subdomain
 */
define( 'WIKIMINI_SUBDOMAIN_URL_GENERIC', 'https://%s.' . WIKIMINI_MAIN_DOMAIN );

/**
 * Check if we are in the testing environment
 *
 * To trigger this mode, Apache passes an environment variable.
 */
define( 'WIKIMINI_TESTING', getenv( 'WikiminiEnv' ) === 'testing' );

/**
 * Base directory of Wikimini
 */
define( 'WIKIMINI_BASE', WIKIMINI_TESTING
	? '/var/www/wikimini.org/www.testing'
	: '/var/www/wikimini.org/www'
);

/**
 * Define generic cache
 *
 * This may be a good candidate for a $wgCacheDirectory.
 */
define( 'WIKIMINI_CACHE_DIRECTORY', sprintf(
	'/var/www/wikimini.org/cache/%s',
	WIKIMINI_PROJECT_UID,
) );

/**
 * URL of the current subdomain
 *
 * This may be a good candidate for a $wgServer.
 */
define( 'WIKIMINI_SUBDOMAIN_URL', sprintf(
	WIKIMINI_SUBDOMAIN_URL_GENERIC,
	WIKIMINI_PROJECT_UID,
) );

/**
 * Wikimini Parsoid port
 */
define( 'WIKIMINI_PARSOID_PORT', 8000 );

/**
 * Propose an useful cache directory separated for each project
 */
$wgCacheDirectory = WIKIMINI_CACHE_DIRECTORY;

/**
 * Use OPCache as default
 */
$wgMainCacheType = CACHE_NONE;

/**
 * Fix login
 */
$wgSessionCacheType = CACHE_DB;

/**
 * Propose an useful default server
 */
$wgServer = WIKIMINI_SUBDOMAIN_URL;

// database name
if( WIKIMINI_TESTING ) {
	$wgDBname = "wikimini_beta_" . WIKIMINI_PROJECT_UID . "wiki";
} else{
	$wgDBname = "wikimini_"      . WIKIMINI_PROJECT_UID . "wiki";
}

// load password and stuff
// Note: here is the expected location:
//   /etc/wmch-infrastructure/servers/demo/projects/wikimini/LocalSettings-secret.php
require_once 'LocalSettings-secret.php';

// require the LocalSettings-en.php
// require the LocalSettings-es.php
// require the LocalSettings-it.php
// ecc.
require __DIR__
	. '/WikiminiSettings/LocalSettings/'
	. sprintf( 'LocalSettings-%s.php', WIKIMINI_PROJECT_UID );
