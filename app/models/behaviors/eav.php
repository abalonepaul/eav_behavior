<?php
/**
 * EAV behavior class.
 *
 * Enables objects to utilize the Entity-Attribute-Value design pattern and act as an entity, attribute, or attribute_value.
 *
 * PHP versions 4 and 5
 *
 * Paul Marshall (http://www.paulmarshall.us)
 * Copyright 2011, Paul Marshall
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2011, Paul Marshall
 * @link          http://www.paulmarshall.us Paul Marshall
 * @package       eav
 * @subpackage    model.behaviors.eav
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */

/**
 * 
 *
 * @package       eav
 * @subpackage    model.behaviors.eav
 */
class EavBehavior extends ModelBehavior {

    /**
     * 
     * The model that is acting as the Entity
     * @var unknown_type
     */
    var $entityModel = 'User';
    
    /**
     * 
     * Enter description here ...
     * @var unknown_type
     */
    var $attributeModel = 'Attribute';
    
    /**
     * 
     * The name of the field in the $attributeModel that holds the data type
     * @var unknown_type
     */
    var $dataTypeFieldName = 'type';
    /**
     * 
     * Maps data types to the Model
     * @var unknown_type
     */
    var $valueModels = array(
        'key'       => 'AttributesKeyValue', //Store integer primary keys from related tables here. 
        'uuid'      => 'AttributesUuidValue', //Store uuid primary keys from related tables here. 
        'string'    => 'AttributesStringValue',
        'text'      => 'AttributesTextValue',
        'integer'   => 'AttributesIntegerValue',
        'float'     => 'AttributesFloatValue',
        'datetime'  => 'AttributesDatetimeValue',
        'timestamp' => 'AttributesTimestampValue',
        'time'      => 'AttributesTimeValue',
        'date'      => 'AttributesDateValue',
        'binary'    => 'AttributesBinaryValue',
        'boolean'   => 'AttributesBooleanValue'
    );
    
    /**
     * The EAV Behavior can use various forms of virtualFields
     * Options:
     * 1. cake - Use CakePHP's virtualFields
     * 2. eav - Simulates CakePHP's Virtual Fields without the sub queries
     * 3. array - Adds an array of attribute names and values to the find results
     * 4. false - Leave the Attribute Values in their respective arrays
     * 
     * @var unknown_type
     */
    var $virtualFieldType = 'cake';
    
/**
 * Sets up the configuation for the model, and loads the models if they haven't been already
 *
 * @param mixed $config
 * @return void
 * @access public
 */
	function setup(&$model, $config = array()) {
		if (is_string($config)) {
			$config = array('type' => $config);
		}
		$this->settings[$model->name] = array_merge(array('type' => 'entity'), (array)$config);
		$this->settings[$model->name]['type'] = strtolower($this->settings[$model->name]['type']);
        //debug($this->settings);
        $type = $config['type'];
		
		if ($type == 'entity') {
		    $this->entityModel = $model;
		    $hasAndBelongsToMany = array();
		    foreach($this->valueModels as $dataType => $dataModel) {
		        $alias = 'Attributes' . Inflector::camelize($dataType);
		        $table = 'attributes_' . $dataType . '_values';
		        $hasAndBelongsToMany = array(
		        	$alias => array(
		                'className' => 'Attribute',
		                //'joinTable' => $table,
		        	    'with' => 'Attributes'. Inflector::camelize($dataType) . 'Value',
		                'foreignKey' => 'entity_id',
		                'associationKey' => 'attribute_id'
		                ));
		                $alias = Inflector::singularize(Inflector::camelize($table));
		                $hasMany = array(
		        	$alias => array(
		                'className' => 'AppModel',
		                'foreignKey' => 'entity_id',
		        	));
		                if (PHP5) {
        			//ClassRegistry::init(array('class' => 'AppModel', 'table' => $table,'alias' => 'Attributes'. Inflector::camelize($dataType) . 'Value'));
        			$this->entityModel->$alias = ClassRegistry::init(array('class' => 'AppModel', 'table' => $table,'alias' => $alias));
		                } else {
        			$this->entityModel->$alias =& ClassRegistry::init(array('class' => 'Attribute','table' => $table,'alias' => $alias));
        		}
                //$this->entityModel->hasAndBelongsToMany = array_merge($this->entityModel->hasAndBelongsToMany,$hasAndBelongsToMany);
                $this->entityModel->hasMany = array_merge($this->entityModel->hasMany,$hasMany);
		    }
		    if ($this->virtualFieldType == 'cake') {
    		    
    		    //Setup model virtual fields.
    		    $this->entityModel->virtualFields = array_merge($this->entityModel->virtualFields,$this->getVirtualFieldSql($model));
    		}
    		//debug($this->entityModel);
    		
		}
	}
	
	function setupAttributes() {
	    $entityId = '4e656b03-8b70-4c3b-a8d0-057c43c9e587';
	    $this->addAttributeValue('address','123 Main St.',$entityId);
	    $this->addAttributeValue('city','San Rafael',$entityId);
	    $this->addAttributeValue('zip','94901',$entityId);
	    $this->addAttributeValue('birth_date',date('Y-m-d'),$entityId);
	    $this->addAttributeValue('notes','This is a note',$entityId);
	    $this->addAttributeValue('admin',1,$entityId);
	    $entityId = '4e656b23-cef8-4f46-ad8e-057d43c9e587';
	    $this->addAttributeValue('address','456 Main St.',$entityId);
	    $this->addAttributeValue('city','San Mateo',$entityId);
	    $this->addAttributeValue('zip','94951',$entityId);
	    $this->addAttributeValue('birth_date',date('Y-m-d'),$entityId);
	    $this->addAttributeValue('notes','This is another note',$entityId);
	    $this->addAttributeValue('admin',0,$entityId);
        $entityId = '4e659ab2-1a3c-43a3-96fb-076043c9e587';
	    $this->addAttributeValue('address','123 Main St.',$entityId);
	    $this->addAttributeValue('city','San Rafael',$entityId);
	    $this->addAttributeValue('zip','94901',$entityId);
	    $this->addAttributeValue('birth_date',date('Y-m-d'),$entityId);
	    $this->addAttributeValue('notes','This is a company note',$entityId);
	    $this->addAttributeValue('opens_at',date('H:i:s'),$entityId);
	    $this->addAttributeValue('closes_at',date('H:i:s'),$entityId);
	    $entityId = '4e659af9-c210-43ed-824b-076843c9e587';
	    $this->addAttributeValue('address','789 Main St.',$entityId);
	    $this->addAttributeValue('city','San Francisco',$entityId);
	    $this->addAttributeValue('zip','94942',$entityId);
	    $this->addAttributeValue('rate',75.00,$entityId);
	    $this->addAttributeValue('notes','This is contact note',$entityId);
	    $this->addAttributeValue('company_id','4e659ab2-1a3c-43a3-96fb-076043c9e587',$entityId);	    
	}
	function addAttributeValue($attribute,$value,$entityId = null) {
	    $attribute = ClassRegistry::init($this->attributeModel)->findByName($attribute);
	    $alias = $this->valueModels[$attribute['Attribute']['data_type']];
	    $table = Inflector::pluralize(Inflector::underscore($alias));
	    $valueModel = ClassRegistry::init(array('class' => 'AppModel', 'table' => $table,'alias' => $alias));
	    $valueModel->create();
	    $valueModel->save(
	        array($alias => array(
	            'entity_id' => $entityId,
	            'attribute_id' => $attribute['Attribute']['id'],
	            'value' => $value)));
	    
	}
	/**
	 * Gets the Virtual Fields for a given model and returns the array of fields
	 * @param $model
	 */
	function getVirtualFieldsByModel($model = null) {
	    $this->Attribute = ClassRegistry::init($this->attributeModel);
		if (!empty($model)) {
			$fields = $this->Attribute->find('all',array(
			'fields' => array('id','name','data_type'),
			)
		);
		
		return $fields;
		} else {
			return false;
		}
	}

	/**
	 * get the SQL used as a subquery to generate Virtual Fields
	 * @param $model
	 */
	function getVirtualFieldSql($model = null,$entityId = null) {
		//debug($model);
		if ($model != null) {
			$fields = $this->getVirtualFieldsByModel($model);
		//debug($fields);
		
			

			if (!empty($fields)) {
			    foreach($fields as $field){
			        $valueModel = $this->valueModels[$field['Attribute']['data_type']];
        			$this->$valueModel = ClassRegistry::init($valueModel);
        			$dbo = $this->$valueModel->getDataSource();
        			$table = 'attributes_' . $field['Attribute']['data_type'] . '_values';
        			$table = $dbo->fullTableName($this->$valueModel);
			    if ($entityId) {
			        $conditionsSubQuery['`' . $valueModel . '`.`entity_id`'] =  $entityId;
			    } else {
			        $conditionsSubQuery[] ='`' . $valueModel . '`.`entity_id` = `'.$model->alias.'`.`id`';
			    }
				
        			
			        $conditionsSubQuery['`' . $valueModel . '`.`attribute_id`'] = $field['Attribute']['id'];
				$subQuery = $dbo->buildStatement(
				    array(
				        'fields' => array($valueModel . '.value'),
				        'table' => $table,
				        'alias' => $valueModel,
				        'limit' => null,
				        'offset' => null,
				        'joins' => array(),
				        'conditions' => $conditionsSubQuery,
				        'order' => null,
				        'group' => null
				    ),
				    $this->$valueModel
				);
				$subQueryExpression = $dbo->expression($subQuery);
				$query[] = $subQueryExpression;

				$fieldData[$field['Attribute']['name']] = $subQuery;
                unset($conditionsSubQuery);
			    }
			return $fieldData;
			}
		}
		return false;

	}
	
	/**
	 * Get all of the attributes
	 */
    function getAttributes() {
        return $this->$attributeModel->find('all');
    }
    
    /**
     * 
     * Returns and array of Attribute Ids with the given name
     * @param unknown_type $name
     */
    function getAttributeIdByName($name) {
        return $this->$attributeModel->find('all',array(
        	'fields' => array('id'),
        	'conditions' => array(
        		'name' => $name
            )
        ));
    }
    
    /**
     * 
     * Get all of the Attribute Values for the current or given Entity
     * @param unknown_type $entityId
     */
    function getAttributeValues($entityId = null) {
        if ($entityId == null) {
            $entityId = $this->entityModel->id;
        }
        
    }
    
    /**
     *
     * Bind the entity to a Model using a foreign key stored in the key data model
     * @param unknown_type $model
     */
    function bindThroughAttribute($model) {
       $key = Inflector::underscore($model) . '_id';
       $attributeId = $this->$attributeModel->field('id',array('name' => $key));
       $belongsTo = array($model => array(
           'className' => $model,
           'foreignKey' => 'value'
       ));
       $this->$entityModel->belongsTo = array_merge($this->$entityModel->belongsTo,$belongsTo);
        
    }
    
    /**
     * 
     * Bind the Entity Model to all of the Models with values in the key Model
     */
    function bindThroughAttributes() {
            $attributes = $this->$attributeModel->findAllByType('key');
	        foreach ($attributes as $attribute) {
	            $model = Inflector::camelCase(substr($attribute[$attributeModel],-2));
               $this->bindThroughAttribute($model);
	        }
            $attributes = $this->$attributeModel->findAllByType('uuid');
	        foreach ($attributes as $attribute) {
	            $model = Inflector::camelCase(substr($attribute[$attributeModel],-2));
               $this->bindThroughAttribute($model);
	        }
	        
    }
    
    /**
     * 
     * Do a find and replace throughout the Attributes.
     * @todo Update this
     * @param unknown_type $searchText
     * @param unknown_type $replaceText
     * @param unknown_type $formatType
     * @param unknown_type $formatChar
     * @param unknown_type $regexpChar
     * @param unknown_type $attributeValuesUpdateList
     */
    function findReplace($searchText, $replaceText, $formatType, $formatChar, $regexpChar, $attributeValuesUpdateList) {
        if (! empty($searchText)) {
            $this->updateAll(array(
                    '`AttributeValue`.`text`' => 'REPLACE(`AttributeValue`.`text`,"' . addslashes(htmlentities($searchText, ENT_NOQUOTES, 'UTF-8')) . '","' . addslashes(htmlentities($replaceText, ENT_NOQUOTES, 'UTF-8')) . '")'
            ), array(
                    'AttributeValue.id IN("' . $attributeValuesUpdateList . '")'
            ));
        } elseif ($formatType == 'currency') {
            //Do the Currency Format update
            

            $this->updateAll(array(
                    '`AttributeValue`.`text`' => 'IF( `AttributeValue`.`text` REGEXP BINARY "^[^0-9a-zA-Z][0-9]+\.[0-9]+$", CONCAT( "' . $formatChar . '", FORMAT( RIGHT( `AttributeValue`.`text` , (CHAR_LENGTH( `AttributeValue`.`text` ) -1 ) ) , 2 ) ) , IF( `AttributeValue`.`text` REGEXP BINARY "^[0-9]+\.*[0-9]*$", CONCAT( "' . $formatChar . '", FORMAT( `AttributeValue`.`text` , 2 ) ),`AttributeValue`.`text`))'
            ), array(
                    '`AttributeValue`.`text` NOT REGEXP BINARY "^[' . $regexpChar . '][0-9]*[\.][0-9]{2}$"', 
                    'AttributeValue.id IN("' . $attributeValuesUpdateList . '")'
            ));
        
     //echo "Affected Rows:" . $this->AttributeValue->getAffectedRows();
        

        } elseif ($formatType == 'pricecode') {
            //Do the PriceCode Format update
            

            $this->updateAll(array(
                    '`AttributeValue`.`text`' => 'if( ASCII( left( `AttributeValue`.`text`, 1 ) ) >64, if( ASCII( right( `AttributeValue`.`text`, 1 ) ) >64, concat( "' . $formatChar . '", left( right(`AttributeValue`.`text`, char_length( `AttributeValue`.`text` ) -1 ) , char_length( right( `AttributeValue`.`text`, char_length( `AttributeValue`.`text` ) -1 ) ) -1 ) , "' . $formatChar . '") , concat( "' . $formatChar . '", right( `AttributeValue`.`text`, char_length( `AttributeValue`.`text` ) -1 ), "' . $formatChar . '")  ) , if( ASCII( right( `AttributeValue`.`text`, 1 ) ) >64, concat( "' . $formatChar . '",left( `AttributeValue`.`text`, char_length( `AttributeValue`.`text` ) -1 ) , "' . $formatChar . '"), concat( "' . $formatChar . '", `AttributeValue`.`text`, "' . $formatChar . '") )  )'
            ), array(
                    '`AttributeValue`.`text` NOT REGEXP "^([A-Za-z])[0-9]*\1$"', 
                    'AttributeValue.id IN("' . $attributeValuesUpdateList . '")'
            ));
        }
        return $this->getAffectedRows();
    
    }
	/**
	 * Finds an AttributeValue record by a given AttributeValueId and returns the value of the text field.
	 *
	 * @param string $attributeValueId The id of a AttributeValue record.
	 * @return string $content The value of the text field to return.
	 */
	function getValuesByAttributeId($attributeValueId, $dataType = null) {
	    if ($dataType != null) {
	        //Query each Attribute Value Model for the given id. If found return the value.
	        foreach ($this->valueModels as $dataType => $dataModel) {
	            $value = $this->$dataModel->field('value',array('id' => $attributeValueId));
	            if (isset($value)) {
	                return $value;
	            }
	        }
	        return false;
	    } else {
	        //Find the value from the given $dataType
	        $dataModel = $this->valueModels[$dataType];
    		$value = $this->$dataModel->field('value',array('id' => $attributeValueId));
    		return $value;
	        
	    }
	    return false;
	}

		/**
	 * Finds an AttributeValue record by a given AttributeValueId and returns the value of the text field.
	 *
	 * @param string $attributeValueId The id of a AttributeValue record.
	 * @return string $content The value of the text field to return.
	 */
	function getValuesByEntityId($entityId = null) {
	    if ($entityId == null) {
	        $entityId = $this->$entityModel->id;
	    }
	    
	    if ($entityId == null) {
	        return false;
	    } else {
	        //Query each Attribute Value Model for the given id. If found return the value.
	        foreach ($this->valueModels as $dataType => $dataModel) {
	            $values = $this->$dataModel->find('all',array($entityModel . '.id' => $entityId));
	            foreach ($values as $key => $value) {
	                $result['AttributeValue'][$value[$attributeModel]['name']] = $value[$dataModel]['value'];
	            }
	        }
	        return result;
	    }
	}
	
	/**
	 * Finds all of the AttributeValue records with the given AttributeTypeId.
	 *
	 * @param string $attributeTypeId The uuid of an AttributeType
	 * @return array The model array of AttributeValue records for the given AttributeType
	 */
	function getAllByType($type) {
	    $dataModel = $this->valueModels[$type];
		return $this->$dataModel->find('all');
	}
	
/**
 * beforeFind Callback
 * This can be used to intercept finds by attribute fields and handle them appropriately
 *
 * @param object $Model	Model using the behavior
 * @param array $query Query parameters as set by cake
 * @return array
 * @access public
 */
	function beforeFind(&$Model, $query) {
    }

/**
 * afterFind Callback 
 * This can be used to add the attributes and values to the entity array
 *
 * @param object $Model	Model using the behavior
 * @param array $query Query parameters as set by cake
 * @return array Returns the modified results
 * @access public
 */
	function afterFind(&$Model, $results) {
    }
    
/**
 * beforeSave Callback
 *
 * @param boolean $created True if this is a new record
 * @return void
 * @access public
 */
	function beforeSave(&$model, $options) {
	}
/**
 * afterSave Callback
 *
 * @param boolean $created True if this is a new record
 * @return void
 * @access public
 */
	function afterSave(&$model, $created) {
	}
	
/**
 * Sets the cascade parameter when deleting an entity so that attribute values are also deleted
 *
 * @return void
 * @access public
 */
	function beforeDelete(&$model) {
		$type = $this->__typeMaps[$this->settings[$model->name]['type']];
		$node = Set::extract($this->node($model), "0.{$type}.id");
		if (!empty($node)) {
			$model->{$type}->delete($node);
		}
	}
/**
 * Deletes Attribute Values when the entity is deleted
 *
 * @return void
 * @access public
 */
	function afterDelete(&$model) {
		$type = $this->__typeMaps[$this->settings[$model->name]['type']];
		$node = Set::extract($this->node($model), "0.{$type}.id");
		if (!empty($node)) {
			$model->{$type}->delete($node);
		}
	}
}
