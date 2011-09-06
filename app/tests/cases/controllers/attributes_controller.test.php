<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'America/Los_Angeles' for 'PDT/-7.0/DST' instead in /Users/Paul/www/eav_behavior/cake/console/templates/default/classes/test.ctp on line 22
/* Attributes Test cases generated on: 2011-09-05 17:45:01 : 1315269901*/
App::import('Controller', 'Attributes');

class TestAttributesController extends AttributesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class AttributesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute');

	function startTest() {
		$this->Attributes =& new TestAttributesController();
		$this->Attributes->constructClasses();
	}

	function endTest() {
		unset($this->Attributes);
		ClassRegistry::flush();
	}

}
