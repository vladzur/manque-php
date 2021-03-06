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
class Session {

	public $session_name = _SESSION_NAME_;

	function __construct() {
		session_name($this->session_name);
		session_start();
	}

	function write($name = null, $value = null) {
		$_SESSION[$name] = $value;
	}

	function read($name = null) {
		$out = $_SESSION[$name];
		return $out;
	}

	function start() {
		session_start();
	}

}

?>