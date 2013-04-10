<?php

/*
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

class _Router {

	/**
	 * Loads a class and method from url parsing
	 * @param strung $url Url containing class name and method to load
	 */
	function _loader($url = null) {
		foreach (explode("/", $url) as $p)
			if ($p != '')
				$params[] = $p;
		$_max_params = count($params);
		$_controller_name = $params[0];
		$_action = $params[1];
		if ($_action == "")
			$_action = "index";
		if ($_controller_name == "")
			$_controller_name = "home";
		$_controller_dir = WWW_ROOT . "/controllers/";
		$_controller = $_controller_dir . $_controller_name . ".php";
		if (is_file($_controller)) {
			include($_controller);
			$_controller_name = $this->className($_controller_name);
			if (class_exists($_controller_name)) {
				$_CONTROLLER = new $_controller_name();
				if (method_exists($_CONTROLLER, $_action)) {
					for ($i = 2; $i < $_max_params; $i++) {
						if ($i == $_max_params - 1) {
							$options .="'" . $params[$i] . "'";
						} else {
							$options .="'" . $params[$i] . "', ";
						}
					}
					$vars = $options;
					$_CONTROLLER->$_action($vars);
				} else {
					Controller::error(404);
				}
			}
		} else {
			Controller::error(404);
		}
	}

	function className($file_name) {
		$file_name = str_ireplace('_', ' ', $file_name);
		$className = ucwords($file_name);
		$className = str_ireplace(' ', '', $className);
		return $className;
	}

}

?>