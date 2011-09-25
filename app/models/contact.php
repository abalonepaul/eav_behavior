<?php
class Contact extends AppModel {
	var $name = 'Contact';
	
	//var $displayField = 'company_id';
	var $actsAs = array(
	    'Containable' => array(),
		'Eav' => array(
			'type' => 'entity',
	        'virtualKeys' => array(
	        	'uuid' => array(
	        		'Company'
	            )
	        )
	    )
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	/*var $hasAndBelongsToMany = array(
		'Company' => array(
			'className' => 'Company',
			'foreignKey' => 'entity_id',
			'associationForeignKey' => 'value',
	        'with' => 'AttributesUuidValue',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);*/
	
	
}
