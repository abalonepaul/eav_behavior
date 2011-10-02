<?php
/* AttributesIntegerValue Fixture generated on: 
Warning: date(): It is not safe to rely on the system's timezone settings. You are *required* to use the date.timezone setting or the date_default_timezone_set() function. In case you used any of those methods and you are still getting this warning, you most likely misspelled the timezone identifier. We selected 'America/Los_Angeles' for 'PDT/-7.0/DST' instead in /Users/Paul/www/eav_behavior/cake/console/templates/default/classes/fixture.ctp on line 24
2011-09-12 22:36:00 : 1315892160 */
class AttributesIntegerValueFixture extends CakeTestFixture {
	var $name = 'AttributesIntegerValue';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'entity_id' => array('type' => 'string', 'null' => false, 'default' => NULL, 'length' => 36, 'key' => 'index', 'collate' => 'utf8_bin', 'charset' => 'utf8'),
		'attribute_id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'index'),
		'value' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'modified' => array('type' => 'datetime', 'null' => false, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1), 'entity_id' => array('column' => 'entity_id', 'unique' => 0), 'attribute_id' => array('column' => 'attribute_id', 'unique' => 0)),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'entity_id' => 'Lorem ipsum dolor sit amet',
			'attribute_id' => 1,
			'value' => 1,
			'created' => '2011-09-12 22:36:00',
			'modified' => '2011-09-12 22:36:00'
		),
	);
}
