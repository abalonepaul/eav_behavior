<?php
class User extends AppModel {
	var $name = 'User';
	var $displayField = 'username';
	var $actsAs = array('Containable','Eav' => array('type' => 'entity'));
	//var $hasOne = array('Company');
}
