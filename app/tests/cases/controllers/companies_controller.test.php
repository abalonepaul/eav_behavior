<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'America/Los_Angeles' for 'PDT/-7.0/DST' instead in /Users/Paul/www/eav_behavior/cake/console/templates/default/classes/test.ctp on line 22
/* Companies Test cases generated on: 2011-09-05 12:29:27 : 1315250967*/
App::import('Controller', 'Companies');

class TestCompaniesController extends CompaniesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class CompaniesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.company', 'app.contact');

	function startTest() {
		$this->Companies =& new TestCompaniesController();
		$this->Companies->constructClasses();
	}

	function endTest() {
		unset($this->Companies);
		ClassRegistry::flush();
	}

}
