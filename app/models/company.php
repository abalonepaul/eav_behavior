<?php
class Company extends AppModel {
	var $name = 'Company';
	var $displayField = 'name';
	var $actsAs = array('Containable','Eav' => array('type' => 'entity'));
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/*var $hasMany = array(
		'Contact' => array(
			'className' => 'Contact',
			'foreignKey' => 'company_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);*/

}
