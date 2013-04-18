<?php
// Site Settings.
$settings['site'] = array
(
	"title" => "Loggerhead",
	"url" => "http://"
);

// Database settings.
$settings['database'] = array
(
	"databaseHost" => "localhost",
	"databaseUsername" => "loggerhead",
	"databasePassword" => "barnacle",
	"databaseName" => "loggerhead",
	"tablePrefix" => "loggerhead."
);

$settings['postsPerPage'] = 5;

// Database settings.
$settings['shorthand'] = array
(
	"nick" => "Nick",
	"name" => "Name",
	"p" => "Corr",
	"m" => "Inco",
	"i" => "Inte",
	"n" => "Negs",
	"biol" => "B",
	"chem" => "Ch",
	"curr" => "Cu",
	"geog" => "Gg",
	"geol" => "Gl",
	"mpol" => "M",
	"phys" => "P",
	"ssci" => "S",
	"tech" => "T",
);

// Define settings.
define("SITE_TITLE", $settings['site']['title']);
define("SITE_URL", $settings['site']['url']);
define("TABLE_PREFIX", $settings['database']['tablePrefix']);

?>