<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $scaffold;
	
	function index() {
	    $this->User->recursive = 2;
	    debug($this->User->find('all'));
	    $this->set('users',$this->paginate());
	}
	
	function setup() {
	    $this->User->setupAttributes();
	    //exit;
	}

}
