<?php
#
# This is an example secret file for MediaWiki
#
# See https://phabricator.wikimedia.org/T268292
#


# Protect against web entry
if ( !defined( 'MEDIAWIKI' ) ) {
	exit;
}

$wgDBpassword = "";

$wgSecretKey = "";

# Site upgrade key. Must be set to a string (default provided) to turn on the
# web installer while LocalSettings.php is in place
$wgUpgradeKey = "";

// Secret email credentials
//
// https://www.mediawiki.org/wiki/Manual:$wgSMTP
$wgSMTP = [];
	'host'     => '',
	'IDHost'   => '',
	'port'     => '587',
	'auth'     => true,
	'username' => '',
	'password' => '',
];

// the sender is just the username
$wgPasswordSender = '';

// feel free to contact this guy for any trouble
$wgEmergencyContact = '';
