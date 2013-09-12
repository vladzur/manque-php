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
class View {

	public $Captcha_lenght = 5;

	/*
	 * Show a view file includding layout file and data
	 */

	function generateText() {
		$pattern = "1234567890ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz";
		$elements = strlen($pattern);
		for ($i = 0; $i < $this->Captcha_lenght; $i++) {
			$key .= $pattern{rand(0, $elements)};
		}
		return $key;
	}

	function generateCaptcha($text) {
		$font = imageloadfont("img/gd_fonts/backlash.gdf");
		$captcha = imagecreatefromgif("img/bgcaptcha.gif");
		$colText = imagecolorallocate($captcha, 255, 255, 255);
		imagestring($captcha, $font, 10, 8, $text, $colText);
		header("Content-type: image/gif");
		imagegif($captcha);
	}

}

?>