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
class Form {

	/**
	 * Creates a form label
	 * @param array $params array with html labels for the form
	 * @return string
	 */
	function create($params = array()) {
		if (!isset($params['method'])) {
			$params['method'] = 'post';
		}
		if (!isset($params['action'])) {
			$params['action'] = $_global['action'];
		}
		$output = "<form";
		foreach ($params as $label => $value) {
			$output .= " $label=\"$value\"";
		}
		$output .= ">\n";
		return $output;
	}

	/**
	 * Creates a Select of items
	 * @param string $name name of the select
	 * @param array $values array key->value
	 * @return string
	 */
	function select($name = null, $values = array()) {
		$output = "<select name=\"$name\">\n";
		foreach ($values as $k => $v) {
			$output .= "<option value=\"$k\">$v</option>\n";
		}
		$output .= "</select>\n";
		return $output;
	}

	/**
	 * Creates an input tag
	 * @param string $name name of input
	 * @param array $params params for the input
	 * @return string
	 */
	function input($name = null, $params = array()) {
		//TODO improve input type render
		if (!isset($params['type'])) {
			$params['type'] = 'text';
		}
		$output = "<input ";
		foreach ($params as $label => $value) {
			$output .= "$label=\"$value\" ";
		}
		$output .= "name=\"$name\" >\n";
		return $output;
	}

	/**
	 * Creates an ending tag for the form, it can add a submit button if
	 * a text is set.
	 * @param string $text texto to the button
	 * @return string
	 */
	function end($text = null) {
		$output = '';
		if (isset($text)) {
			$output .= "<button type=\"submit\">$text</button>\n";
		}
		$output .= "</form>\n";
		return $output;
	}
}
?>