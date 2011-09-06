<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $scaffold;
	function index() {
	    $this->Contact->recursive = 1;
	   /* $this->Contact->bindModel(array(
	    	'belongsTo' =>array(
	    		'Company' => array(
	    			'className' => 'Company',
	                //'foreignKey' => 'AttributesUuidValue.value'
	                ))));*/
	    debug($this->Contact->find('all'));
	    $this->set('contacts',$this->paginate());
	}
	
}
