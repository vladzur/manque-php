<?php

/*
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

class Controller {

	public $models = array();
	public $helpers = array('Html', 'Form');
	public $data;
	public $vendors = array();

	function __construct() {
		$this->View = new View();
		$this->Session = new Session();
		$this->Security = new Security();
		$this->data = $_POST['data'];
		$this->_loadModels($this->models);
		$this->_loadVendors($this->vendors);
	}

	/**
	 * Render the selected view and parse the variables setted in $data using
	 * the corresponding layout.
	 *
	 * ie:
	 * show('index', array('name'=$name, 'date'=>$date), 'my_layout')
	 *
	 * @param string $view view file
	 * @param array $data variables putted in an array
	 * @param string $layout the layout to use
	 */
	function show($view = null, $data = array(), $layout = "default") {
		if ($this->isMobile()) {
			$layout = "mobile";
		}
		$view_dir = strtolower(get_class($this));
		$data = (array) $data;
		$file_layout = WWW_ROOT . "/app/views/layout/" . $layout . ".tpl";
		$file_view = WWW_ROOT . "/app/views/$view_dir/$view.tpl";
		ob_start();
		extract($data, EXTR_SKIP);
		foreach ($this->helpers as $helper) {
			$helper_lower = strtolower($helper);
			$$helper_lower = new $helper();
		}
		$element = new Element();
		include $file_view;
		$content_here = ob_get_clean();
		include $file_layout;
	}

	/**
	 * Simplify use of header
	 *
	 * @param string $url the url to go on
	 */
	function redirect($url = null) {
		header("Location: $url");
	}

	/**
	 * Detects if the browser is in a mobile device
	 *
	 * @return boolean
	 */
	function isMobile() {
		$useragent = $_SERVER['HTTP_USER_AGENT'];
		if (preg_match('/android|avantgo|blackberry|blazer|compal|elaine|fennec|hiptop|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile|o2|opera mini|palm( os)?|plucker|pocket|pre\/|psp|smartphone|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce; (iemobile|ppc)|xiino/i', $useragent) ||
				preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|e\-|e\/|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(di|rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|xda(\-|2|g)|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))
		)
			return true;
		return false;
	}

	/**
	 * Show an error page using error as the page name and the selected layout
	 *
	 * @param string $error default 404
	 * @param string $layout default system default layout
	 */
	function error($error = 404, $layout = "default") {
		$file_layout = WWW_ROOT . "/app/views/layout/" . $layout . ".tpl";
		$file_view = WWW_ROOT . "/app/views/error/$error.tpl";
		ob_start();
		$html = new Html();
		$element = new Element();
		include $file_view;
		$content_here = ob_get_clean();
		include $file_layout;
	}

	/**
	 * Loads models designed by $models array.
	 *
	 * @param array $models
	 * @return boolean
	 */
	function _loadModels($models = array()) {
		if (!empty($models)) {
			foreach ($models as $model) {
				$model_file = WWW_ROOT . "/app/models/" . strtolower($model) . ".php";
				if (file_exists($model_file)) {
					require_once $model_file;
					$this->$model = new $model();
				}
			}
			return true;
		} else {
			return false;
		}
	}
	
	/**
	 * Loads models designed by $models array.
	 *
	 * @param array $models
	 * @return boolean
	 */
	function _loadVendors($vendors = array()) {
		if (!empty($vendors)) {
			foreach ($vendors as $class => $file) {
				$vendor_file = WWW_ROOT . "/app/vendors/$file";
				if (file_exists($vendor_file)) {
					include_once($vendor_file);
					$this->$class = new $class();
				}
			}
			return true;
		} else {
			return false;
		}
	}

}

?>