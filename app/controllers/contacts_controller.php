<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $scaffold;
	function index() {
	    $this->Contact->recursive = 2;
	   /* $this->Contact->bindModel(array(
	    	'belongsTo' =>array(
	    		'Company' => array(
	    			'className' => 'Company',
	                //'foreignKey' => 'AttributesUuidValue.value'
	                ))));*/
	    debug($this->Contact->find('all'));
	    $entity = $this->Contact->find('first',array('fields' => 'id','contain' => false));
	    //debug($entity['Contact']['id']);
	    //debug($this->Contact->getAttributeValues($this->Contact,$entity['Contact']['id']));
	    $this->set('contacts',$this->paginate());
	}
	
}
