<?php
require_once(__DIR__.'/php_init.php');
require_once(__DIR__.'/config.php');
require_once(__DIR__.'/normalizer.php');
require_once(__DIR__.'/sql.php');
require_once(__DIR__.'/emblem.php');
require_once(__DIR__.'/cache.php');
require_once(__DIR__.'/functions.php');
require_once(__DIR__.'/variables.php');
require_once(__DIR__.'/itemdb.php');

// Independent Classes
$NRM = new OBORO_NORMALIZER;

// Will init Forum SQL Categories only if needed
$GV = new GVAR(strstr($NRM->getParcedModule(), "admin"));

$CONFIG = new CONFIG;
$DB = new DATABASE;
$EMB = new EMBLEM;

$FNC = new FNC($DB);

$CACHE = new Cache;
$ITEM = new ITEMDB($DB);

if ($CONFIG->getConfig('UseGeoLocalization') == 'yes')
	require_once(__DIR__.'/GeoLocalization.php');

$FNC->getDefinedConsts(rtrim(dirname(__FILE__),"\/libs\/"));

// Necesary Array for SQL Bind Params
$param = array();

if (!strcmp($NRM->getParcedModule(), "forum.cat"))
    $FNC->updateUserForum();
?>