<?php

Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'America/Los_Angeles' for 'PDT/-7.0/DST' instead in /Users/Paul/www/eav_behavior/cake/console/templates/default/classes/test.ctp on line 22
/* Attribute Test cases generated on: 2011-09-05 12:04:41 : 1315249481*/
App::import('Model', 'Attribute');

class AttributeTestCase extends CakeTestCase {
	var $fixtures = array('app.attribute');

	function startTest() {
		$this->Attribute =& ClassRegistry::init('Attribute');
	}

	function endTest() {
		unset($this->Attribute);
		ClassRegistry::flush();
	}

}
