<?php
ini_set('display_errors', 1);
/**
 *      Copyright 2013 vladzur
 *
 *      This program is free software; you can redistribute it and/or modify
 *      it under the terms of the GNU General Public License as published by
 *      the Free Software Foundation; either version 3 of the License, or
 *      (at your option) any later version.
 *
 *      This program is distributed in the hope that it will be useful,
 *      but WITHOUT ANY WARRANTY; without even the implied warranty of
 *      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *      GNU General Public License for more details.
 *
 *      You should have received a copy of the GNU General Public License
 *      along with this program; if not, write to the Free Software
 *      Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston,
 *      MA 02110-1301, USA.
 */
if (!defined('WWW_ROOT')) {
	define('WWW_ROOT', '../..');
}
if (!defined('ROOT')) {
	define('ROOT', dirname(dirname(dirname(__FILE__))));
}

if (!defined('WWW')) {
	define('WWW', dirname($_SERVER["SCRIPT_NAME"]));
}

if (!isset($_global)) {
	$_global = array();
	$_global['System']['name'] = 'Manque-PHP';
	$_global['System']['version'] = '1.01';
}

include(WWW_ROOT . "/core/i18n/streams.php");
include(WWW_ROOT . "/core/i18n/gettext.php");
include(WWW_ROOT . "/core/functions.php");
include(WWW_ROOT . "/app/configure/config.php");
function __autoinclude($className = null) {
	require_once(WWW_ROOT . "/core/$className");
}

$files = scandir(WWW_ROOT . "/core/");

foreach ($files as $file) {
	if (stristr($file, ".php")) {
		__autoinclude($file);
	}
}
require_once(WWW_ROOT . "/app/controllers/app_controller.php");
$url = $_GET['url'];
if (empty($url))
	$url = "home";
if (class_exists("_Router")) {
	$_ROUTER = new _Router();
	if (method_exists($_ROUTER, "_loader")) {
		$_ROUTER->_loader($url);
	} else {
		echo "<h1>Método no existe</h1>";
	}
} else {
	echo "<h1>Clase no encontrada</h1>";
}
?>