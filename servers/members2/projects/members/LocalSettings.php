<?php
# This file was automatically generated by the MediaWiki 1.30.0
# installer. If you make manual changes, please keep track in case you
# need to recreate them later.
#
# See includes/DefaultSettings.php for all configurable settings
# and their default values, but don't forget to make changes in _this_
# file, not there.
#
# Further documentation for configuration settings may be found at:
# https://www.mediawiki.org/wiki/Manual:Configuration_settings

# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

## Uncomment this to disable output compression
# $wgDisableOutputCompression = true;

$wgSitename = "WMCH Members";

## The URL base path to the directory containing the wiki;
## defaults for all runtime URL paths are based off of this.
## For more information on customizing the URLs
## (like /w/index.php/Page_title to /wiki/Page_title) please see:
## https://www.mediawiki.org/wiki/Manual:Short_URL
$wgScriptPath = "";

## The protocol and server name to use in fully-qualified URLs
$wgServer = "https://members.wikimedia.ch";
$wgArticlePath = "/wiki/$1";

## The URL path to static resources (images, scripts, etc.)
$wgResourceBasePath = $wgScriptPath;

## The URL path to the logo.  Make sure you change this from the default,
## or else you'll overwrite your logo when you upgrade!
$wgLogo = "$wgResourceBasePath/resources/assets/wiki.png";

// name of the Project namespace
$wgMetaNamespace = 'Wikimedia CH';

## UPO means: this is also a user preference option

$wgEnableEmail = true;
$wgEnableUserEmail = true; # UPO

$wgEnotifUserTalk = false; # UPO
$wgEnotifWatchlist = false; # UPO
$wgEmailAuthentication = true;

## Database settings
$wgDBtype = "mysql";
$wgDBserver = "localhost";
$wgDBname = "dbwiki_members";
$wgDBuser = "dbwiki_members";

// see LocalSettings-secret.php
//$wgDBpassword = '';

# MySQL specific settings
$wgDBprefix = 'members_';

# MySQL table options to use during installation or update
$wgDBTableOptions = "ENGINE=InnoDB, DEFAULT CHARSET=binary";

# Experimental charset support for MySQL 5.0.
$wgDBmysql5 = false;

## Shared memory settings
$wgMainCacheType = CACHE_NONE;
$wgMemCachedServers = [];

## To enable image uploads, make sure the 'images' directory
## is writable, then set this to true:
$wgEnableUploads = true;
$wgUseImageMagick = true;
$wgImageMagickConvertCommand = "/usr/bin/convert";

# InstantCommons allows wiki to use images from https://commons.wikimedia.org
$wgUseInstantCommons = false;

# Periodically send a pingback to https://www.mediawiki.org/ with basic data
# about this MediaWiki instance. The Wikimedia Foundation shares this data
# with MediaWiki developers to help guide future development efforts.
$wgPingback = true;

## If you use ImageMagick (or any other shell command) on a
## Linux server, this will need to be set to the name of an
## available UTF-8 locale
$wgShellLocale = "C.UTF-8";

## Set $wgCacheDirectory to a writable directory on the web server
## to make your wiki go slightly faster. The directory should not
## be publically accessible from the web.
$wgCacheDirectory = "/var/www/wikimedia.ch/members/cache";

# temp directory
$wgTmpDirectory = '/var/www/wikimedia.ch/members/tmp';

# Site language code, should be one of the list in ./languages/data/Names.php
$wgLanguageCode = 'en';

# Changing this will log out all existing sessions.
$wgAuthenticationTokenVersion = "1";

## For attaching licensing metadata to pages, and displaying an
## appropriate copyright notice / icon. GNU Free Documentation
## License and Creative Commons licenses are supported so far.
$wgRightsPage = ""; # Set to the title of a wiki page that describes your license/copyright
$wgRightsUrl  = "";
$wgRightsText = "";
$wgRightsIcon = "";

# Path to the GNU diff3 utility. Used for conflict resolution.
$wgDiff3 = "/bin/diff3";

## Default skin: you can change the default skin. Use the internal symbolic
## names, ie 'vector', 'monobook':
$wgDefaultSkin = "vector";

# Enabled skins.
# The following skins were automatically enabled:
//wfLoadSkin( 'CologneBlue' );
//wfLoadSkin( 'Modern' );
wfLoadSkin( 'MonoBook' );
wfLoadSkin( 'Vector' );

# End of automatically generated settings.
# Add more configuration options below.

#Set Default Timezone
$wgLocaltimezone = "Europe/Rome";
date_default_timezone_set( $wgLocaltimezone );

$wgLogo = $wgScriptPath . '/images/wiki.png';

// disable reading by anonymous users
$wgGroupPermissions['*']['read'] = false;

// preevent new user registrations except by sysops
$wgGroupPermissions['*']['createaccount'] = false;

// disable editing by everyone but "Member"s and above
foreach( [ '*', 'user', 'autoconfirmed' ] as $role ) {

	// Disable anonymous editing
	$wgGroupPermissions[ $role ]['edit'] = false;
}

// custom privileges
$wgGroupPermissions['Member'] = $wgGroupPermissions['user'];
$wgGroupPermissions['Board']  = $wgGroupPermissions['sysop'];
$wgGroupPermissions['Staff']  = $wgGroupPermissions['sysop'];

// allow Members to edit pages
$wgGroupPermissions['Member']['edit'] = true;

// allow other files
$wgFileExtensions[] = 'svg';
$wgFileExtensions[] = 'pdf';

// very useful
$wgUseInstantCommons = true;

// save errors and debugging information to a log
$wgDebugLogFile = '/var/log/wmch/members.log';

// decomment when enabled service
$wgJobRunRate = 0;

// extensions
wfLoadExtension( 'ParserFunctions' );
wfLoadExtension( 'Renameuser' );
wfLoadExtension( 'Cite' );
wfLoadExtension( 'WikiEditor' );
wfLoadExtension( 'InputBox' );

wfLoadExtension( 'Babel' );
wfLoadExtension( 'UniversalLanguageSelector' );
wfLoadExtension( 'cldr' );

wfLoadExtension( 'Echo' );
wfLoadExtension( 'Thanks' );

// require some secret configurations:
//  $wgDBpassword
//  $wgSMTP
//  $wgSecretKey
//  $wgUpgradeKey
require 'LocalSettings-secret.php';
