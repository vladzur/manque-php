<?php

/**
 *      Copyright 2010 vladzur
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
/*
 * Get the language code.
 */
function _getLang() {
	foreach (explode(',', $_SERVER['HTTP_ACCEPT_LANGUAGE']) as $lang) {
		$pattern = '/^(?P<primarytag>[a-zA-Z]{2,8})' .
			'(?:-(?P<subtag>[a-zA-Z]{2,8}))?(?:(?:;q=)' .
			'(?P<quantifier>\d\.\d))?$/';

		$splits = array();
		if (preg_match($pattern, $lang, $splits)) {
			$lang_arr[] = $splits;
		}
	}

	return $lang_arr[0]['primarytag'];
}

/*
 * Alias to translate text
 * @my_text: string to translate
 */

function __($my_text) {
	$lang = _getLang();
	if (file_exists(WWW_ROOT . "/view/locale/" . $lang . "/default.mo")) {
		$gettext_cache = new gettext_reader(new CachedFileReader(WWW_ROOT . "/view/locale/" . $lang . "/default.mo"));
	}
	if (is_null($gettext_cache)) {
		return $my_text;
	} else {
		return $gettext_cache->translate($my_text);
	}
}

/*
 * Prints a formated print_r
 * @var : mixed var.
 */

function pr($var) {
	echo "<pre>";
	print_r($var);
	echo "</pre>\n";
}

/*
 * Sets configuration constants
 * @item :Type of configuration
 * @value :value to set
 */

function configure($Item, $value) {
	switch ($Item) {
		case 'Debug':
			error_reporting($value);
			ini_set("display_errors", 1);
			break;
		case 'DB':
			define(_HOST_, $value['host']);
			define(_USER_, $value['user']);
			define(_PWD_, $value['pass']);
			define(_DB_, $value['dbase']);
			break;
		case 'SessionName':
			define(_SESSION_NAME_, $value);
			break;
		case 'PassPhrase':
			define(_PASS_PHRASE_, $value);
			break;
	}
}
?>