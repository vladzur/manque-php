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

class Html {

	function css($sheet){
		$output = "<link rel=\"stylesheet\" href=\"".WWW."/css/$sheet.css\" type=\"text/css\">\n";
		return $output;
	}

	function link($name = null,$atributes = array()){

		if(isset($atributes['url']['controller'])){
			$url .= "/".$atributes['url']['controller'];
		}
		if(isset($atributes['url']['action'])){
			$url .= "/".$atributes['url']['action'];
		}
		if(isset($atributes['val'])){
			$url .= "/".implode("/", $atributes['val']);
		}

		return "<a href=\"$url\">$name</a>";
	}

	function image($file = null, $atributes = array()){
		if(!isset($atributes['title'])){
			$atributes['title'] = 'image';
		}
		if(!isset($atributes['alt'])){
			$atributes['alt'] = $file;
		}
		$tags = null;
		foreach($atributes as $label=>$value){
			$tags .= " $label=\"$value\"";
		}
		return "<img src=\"$file\"$tags>";
	}

	function javascript($file){
		$output = "<script type=\"text/javascript\" src=\"".WWW."/js/$file\"></script>\n";
		return $output;
	}
}
?>
