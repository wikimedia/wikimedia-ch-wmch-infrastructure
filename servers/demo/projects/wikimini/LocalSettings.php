<?php
/**
 * Wikimini MediaWiki LocalSettings switch.
 *
 * This file was imported and adapted from wikimini.org.
 *
 * See https://phabricator.wikimedia.org/T268292
 */

/**
 * Debug or mainteinance stuff
 */
//if( $_SERVER['REMOTE_ADDR'] !== '1.2.3.4' && PHP_SAPI !== 'cli' ) {
//	$wgShowExceptionDetails = true;
//	$wgShowDBErrorBacktrace = true;
//	$wgReadOnly = 'This wiki is currently under maintenance. Please check back in a couple of minutes.';
//}


/**
 * Whitelist of accepted domains
 */
define( 'WIKIMINI_MAIN_DOMAINS_KNOWN', [

	// official frontend website in migration status
	'wikimini.org',

	// mirror website handled by Wikimedia CH
	'wikimini.wikimedia.ch',
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
 * No known project no party
 */
if( !in_array( WIKIMINI_PROJECT_UID, WIKIMINI_PROJECTS_KNOWN, true ) ) {
	http_response_code( 404 );
	die( 'The requested wiki does not exist.' );
}

/**
 * No known domain no party
 */
if( !in_array( WIKIMINI_MAIN_DOMAIN, WIKIMINI_MAIN_DOMAINS_KNOWN, true ) ) {
	http_response_code( 400 );
	die( 'The requested domain was not recognized.' );
}

/**
 * Declare the URL of a generic Wikimini subdomain
 */
define( 'WIKIMINI_SUBDOMAIN_URL_GENERIC', 'https://%s.' . WIKIMINI_MAIN_DOMAIN );

// require the LocalSettings-en.php
// require the LocalSettings-es.php
// require the LocalSettings-it.php
// ecc.
require __DIR__
	. '/WikiminiSettings/LocalSettings/'
	. sprintf( 'LocalSettings-%s.php', WIKIMINI_PROJECT_UID );

/**
 * Additional configurations
 */

// block editing in this demo
$wgHooks['EditFilter'][] = function ( $editor, $text, $section, &$error, $summary ) {

	$error = sprintf(
		'<div class="errorbox">%s</div>',
		"Apologies, it's just a demo! Please use https://wikimini.org/ instead."
	);

	return true;
};
