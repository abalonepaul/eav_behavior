<?php
class ContactsController extends AppController {

	var $name = 'Contacts';
	var $scaffold;
	function index() {
	    $this->Contact->recursive = 2;
	    //debug($this->Contact->find('all'));
	    $this->set('contacts',$this->paginate());
	}
	function view($id = null) {
	    $this->Contact->recursive = 2;
	    $contact = $this->Contact->findById($id,array('contain' => false));
	    //debug($contact);
	    $this->set('contact',$contact);
	}
	function edit($id = null) {
	    $this->Contact->recursive = 2;
	    if (!empty($this->data)) {
	        if($this->Contact->save($this->data))
	            $this->Session->setFlash(__('The Contact has been saved',true));
	    }
	    $companies = ClassRegistry::init('Company')->find('list');
	    $contact = $this->Contact->findById($id,array('contain' => false));
	    //debug($contact);
	    $this->set('contact',$contact);
	    $this->set('companies',$companies);
	}

		function add() {
	    $this->Contact->recursive = 2;
	    if (!empty($this->data)) {
	        $this->Contact->create();
	        $this->data['Contact']['id'] = String::uuid();
	        debug($this->data);
	        if($this->Contact->save($this->data))
	            $this->Session->setFlash(__('The Contact has been saved',true));
	    }
	    $companies = ClassRegistry::init('Company')->find('list');
	    //$contact = $this->Contact->find('first',array('contain' => false));
	    //debug();
	    $attributeList = Set::extract('/Attribute/name',$this->Contact->getAttributes());
	    $contact = array('Contact' => array());
	    foreach($attributeList as $key=> $value) {
	        //debug($value[]);
	        $contact['Contact'][$value] = null; 
	    }
	    //debug(array('Contact'=>)));
	    $this->set('contact',$contact);
	    $this->set('companies',$companies);
	}
	
}
