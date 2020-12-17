<?php
/**
 * Wikimini MediaWiki LocalSettings switch.
 *
 * This wile was imported from wikimini.org.
 *
 * See https://phabricator.wikimedia.org/T268292
 */

// Include common settings to all wikis before this line (eg. database configuration)

//$wgShowExceptionDetails = true;
//$wgShowDBErrorBacktrace = true;

//$wgReadOnly = ( PHP_SAPI === 'cli' ) ? false : 'This wiki is currently under maintenance. Please check back in a couple of minutes.';

// base directory containings local configurations
$WIKIMINI_BASE_DIR = __DIR__ . '/WikiminiSettings/LocalSettings/';

// serve the correct configuration checking the user's requested hostname
switch( $_SERVER['SERVER_NAME'] ) {

	case 'stock.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsStock.php';
		break;

	case 'fr.wikimini.wikimedia.ch':
	case 'fr.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsFr.php';
		break;

	case 'it.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsIt.php';
		break;

	case 'sv.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsSv.php';
		break;

	case 'en.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsEn.php';
		break;

	case 'ar.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsAr.php';
		break;

	case 'es.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsEs.php';
		break;

	case 'lab.wikimini.org':
		require_once $WIKIMINI_BASE_DIR . 'LocalSettingsLab.php';
		break;

	// no known no party
	default:
		http_response_code( 404 );
		echo 'This wiki is not available. Check configuration.';
		exit( 0 );
}
