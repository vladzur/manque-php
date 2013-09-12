<?php

class Element {

	function show($element = null) {
		include(WWW_ROOT . "/app/view/element/$element.tpl");
	}

}

?>