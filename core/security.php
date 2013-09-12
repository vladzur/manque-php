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
class Security {

	// Security key-phrase, use your own.
	public $key = _PASS_PHRASE_;

	function encrypt($string = null) {
		$string = $this->XOREncrypt($string, $this->key);
		$string = base64_encode($string);
		return $string;
	}

	function decrypt($string = null) {
		$string = base64_decode($string);
		$string = $this->XOREncrypt($string, $this->key);
		return $string;
	}

	private function XOREncrypt($string = null) {
		$keyLength = strlen($this->key);
		for ($i = 0; $i < strlen($string); $i++) {
			$pos = $i % $keyLength;
			$x = ord($string[$i]) ^ ord($this->key[$pos]);
			$string[$i] = chr($x);
		}
		return $string;
	}

}

?>