<?php

class Element {

	function show($element = null) {
		include(WWW_ROOT . "/view/element/$element.tpl");
	}

}
?>