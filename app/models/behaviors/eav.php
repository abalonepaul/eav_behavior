<?php
/**
 * EAV Behavior
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
 * Eav Behavior Class
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
    var $entityModel = array();
    
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
    var $dataTypeFieldName = 'data_type';
    /**
     * 
     * Maps data types to the Model
     * @var unknown_type
     */
    var $valueModels = array(
            'key' => 'AttributesKeyValue',  //Store integer primary keys from related tables here. 
            'uuid' => 'AttributesUuidValue',  //Store uuid primary keys from related tables here. 
            'string' => 'AttributesStringValue', 
            'text' => 'AttributesTextValue', 
            'integer' => 'AttributesIntegerValue', 
            'float' => 'AttributesFloatValue', 
            'datetime' => 'AttributesDatetimeValue', 
            'timestamp' => 'AttributesTimestampValue', 
            'time' => 'AttributesTimeValue', 
            'date' => 'AttributesDateValue', 
            'binary' => 'AttributesBinaryValue', 
            'boolean' => 'AttributesBooleanValue'
    );
    
    /**
     * 
     * Virtual Keys use a HABTM relationship to build a relationship between the entity and another model
     * using an attribute table as a join table. Attribute names must meet naming conventions. This is still EXPERIMENTAL.
     * Array Format:
     * array(
     * 'uuid' = array(
     * 'Company',
     * 'OtherModelWithUuidPrimaryKey'),
     * 'key' = array(
     * 'State', 
     * 'OtherModelWithIntPrimaryKey')
     * )
     * @var unknown_type
     */
    var $virtualKeys = array();
    
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
    var $virtualFieldType = 'eav';
    
    /**
     * Sets up the configuation for the model, and loads the models if they haven't been already
     *
     * @param mixed $config
     * @return void
     * @access public
     */
    function setup(&$model, $config = array()) {
        //If the $config is a string, set it to the type. Otherwise set the config vars.
        if (is_string($config)) {
            $config = array(
                    'type' => $config
            );
        } else {
            foreach ($config as $key => $value) {
                $this->$key = $value;
            
            }
        }
        
        $this->settings[$model->name] = array_merge(array(
                'type' => 'entity'
        ), (array) $config);
        $this->settings[$model->name]['type'] = strtolower($this->settings[$model->name]['type']);
        $type = $config['type'];
        
        if ($type == 'entity') {
            $this->entityModel = $model;
            $hasAndBelongsToMany = array();
            foreach ($this->valueModels as $dataType => $dataModel) {
                //$alias = 'Attributes' . Inflector::camelize($dataType);
                $table = 'attributes_' . $dataType . '_values';
                $alias = Inflector::singularize(Inflector::camelize($table));
                $hasMany = array(
                        $alias => array(
                                'className' => 'AppModel', 
                                'foreignKey' => 'entity_id'
                        )
                );
                
                if (PHP5) {
                    $this->entityModel->$alias = ClassRegistry::init(array(
                            'class' => 'AppModel', 
                            'table' => $table, 
                            'alias' => $alias
                    ));
                } else {
                    $this->entityModel->$alias = & ClassRegistry::init(array(
                            'class' => 'Attribute', 
                            'table' => $table, 
                            'alias' => $alias
                    ));
                }
                $this->entityModel->$alias->Attribute = ClassRegistry::init('Attribute');
                
                if ($this->virtualFieldType != 'cake') {
                    $this->entityModel->$alias->belongsTo = array(
                            'Attribute' => array(
                                    'className' => 'Attribute', 
                                    'foreignKey' => 'attribute_id'
                            )
                    );
                    $this->entityModel->hasMany = array_merge($this->entityModel->hasMany, $hasMany);
                }
            }
            
            //Determine how to bind Associated Models with uuid foreign key for virtualKeys
            if (isset($this->settings[$this->entityModel->name]['virtualKeys']['uuid'])) {
                foreach ($this->settings[$this->entityModel->name]['virtualKeys']['uuid'] as $virtualModel) {
                    if ($this->virtualFieldType == 'cake') {
                        //Binds the Parent Model to Associated Models with a UUID foreignKey using a HABTM relationship
                        $model->$virtualModel = ClassRegistry::init($virtualModel);
                        $hasAndBelongsToMany[$virtualModel] = array(
                                'className' => $virtualModel, 
                                'foreignKey' => 'entity_id', 
                                'associationForeignKey' => 'value', 
                                'with' => 'AttributesUuidValue', 
                                'joinTable' => 'attributes_uuid_values'
                        );
                        $model->hasAndBelongsToMany = Set::merge($model->hasAndBelongsToMany, $hasAndBelongsToMany);
                    } else {
                        //Binds the Parent Model to Associated Models using a hasMany and belongsTo relationship. This adds just the Associated Model record
                        //to the AttributesUuidValue model. 
                        $belongsTo = array(
                                $virtualModel => array(
                                        'className' => $virtualModel, 
                                        'foreignKey' => 'value'
                                )
                        );
                        $model->AttributesUuidValue->$virtualModel = ClassRegistry::init($virtualModel);
                        $model->AttributesUuidValue->bindModel(array(
                                'belongsTo' => Set::merge($model->AttributesUuidValue->belongsTo, $belongsTo)
                        ));
                    }
                }
            }
            if (isset($this->settings[$this->entityModel->name]['virtualKeys']['key'])) {
                foreach ($this->settings[$this->entityModel->name]['virtualKeys']['key'] as $virtualModel) {
                    if ($this->virtualFieldType == 'cake') {
                        //Binds the Parent Model to Associated Models with a UUID foreignKey using a HABTM relationship
                        $model->$virtualModel = ClassRegistry::init($virtualModel);
                        $hasAndBelongsToMany[$virtualModel] = array(
                                'className' => $virtualModel, 
                                'foreignKey' => 'entity_id', 
                                'associationForeignKey' => 'value', 
                                'with' => 'AttributesKeyValue', 
                                'joinTable' => 'attributes_key_values'
                        );
                        $model->hasAndBelongsToMany = Set::merge($model->hasAndBelongsToMany, $hasAndBelongsToMany);
                    
                    } else {
                        $belongsTo = array(
                                $virtualModel => array(
                                        'className' => $virtualModel, 
                                        'foreignKey' => 'value'
                                )
                        );
                        //Binds the Parent Model to Associated Models using a hasMany and belongsTo relationship. This adds just the Associated Model record
                        //to the AttributesUuidValue model. 
                        $model->AttributesKeyValue->$virtualModel = ClassRegistry::init($virtualModel);
                        $model->AttributesKeyValue->bindModel(array(
                                'belongsTo' => Set::merge($model->AttributesKeyValue->belongsTo, $belongsTo)
                        ));
                    }
                }
            }
            if ($this->virtualFieldType == 'cake') {
                //Set model virtual fields.
                $model->virtualFields = array_merge($model->virtualFields, $this->_getVirtualFieldSql($model));
            }
        }
    }
    
    /**
     * Test method to setup test data.
     * 
     */
    function setupAttributes() {
        $entityId = '4e656b03-8b70-4c3b-a8d0-057c43c9e587';
        $this->addAttributeValue('address', '123 Main St.', $entityId);
        $this->addAttributeValue('city', 'San Rafael', $entityId);
        $this->addAttributeValue('zip', '94901', $entityId);
        $this->addAttributeValue('birth_date', date('Y-m-d'), $entityId);
        $this->addAttributeValue('notes', 'This is a note', $entityId);
        $this->addAttributeValue('admin', 1, $entityId);
        $entityId = '4e656b23-cef8-4f46-ad8e-057d43c9e587';
        $this->addAttributeValue('address', '456 Main St.', $entityId);
        $this->addAttributeValue('city', 'San Mateo', $entityId);
        $this->addAttributeValue('zip', '94951', $entityId);
        $this->addAttributeValue('birth_date', date('Y-m-d'), $entityId);
        $this->addAttributeValue('notes', 'This is another note', $entityId);
        $this->addAttributeValue('admin', 0, $entityId);
        $entityId = '4e659ab2-1a3c-43a3-96fb-076043c9e587';
        $this->addAttributeValue('address', '123 Main St.', $entityId);
        $this->addAttributeValue('city', 'San Rafael', $entityId);
        $this->addAttributeValue('zip', '94901', $entityId);
        $this->addAttributeValue('birth_date', date('Y-m-d'), $entityId);
        $this->addAttributeValue('notes', 'This is a company note', $entityId);
        $this->addAttributeValue('opens_at', date('H:i:s'), $entityId);
        $this->addAttributeValue('closes_at', date('H:i:s'), $entityId);
        $entityId = '4e659af9-c210-43ed-824b-076843c9e587';
        $this->addAttributeValue('address', '789 Main St.', $entityId);
        $this->addAttributeValue('city', 'San Francisco', $entityId);
        $this->addAttributeValue('zip', '94942', $entityId);
        $this->addAttributeValue('rate', 75.00, $entityId);
        $this->addAttributeValue('notes', 'This is contact note', $entityId);
        $this->addAttributeValue('company_id', '4e659ab2-1a3c-43a3-96fb-076043c9e587', $entityId);
    }
    
    /**
     * Adds an attribute value to an entity.
     * 
     * @param unknown_type $attribute The name of the attribute to add
     * @param unknown_type $value The value of the attribute
     * @param unknown_type $entityId The id of the entity the attribute should be added to.
     */
    function addAttributeValue($attribute, $value, $entityId = null) {
        $attribute = ClassRegistry::init($this->attributeModel)->findByName($attribute);
        $alias = $this->valueModels[$attribute['Attribute']['data_type']];
        $table = Inflector::pluralize(Inflector::underscore($alias));
        $valueModel = ClassRegistry::init(array(
                'class' => 'AppModel', 
                'table' => $table, 
                'alias' => $alias
        ));
        $valueModel->create();
        $valueModel->save(array(
                $alias => array(
                        'entity_id' => $entityId, 
                        'attribute_id' => $attribute['Attribute']['id'], 
                        'value' => $value
                )
        ));
    
    }
    
    /**
     * Gets the Virtual Fields for a given model and returns the array of fields
     * @param $model
     */
    private function _getVirtualFieldsByModel($model = null) {
        $this->Attribute = ClassRegistry::init($this->attributeModel);
        if (! empty($model)) {
            $fields = $this->Attribute->find('all', array(
                    'fields' => array(
                            'id', 
                            'name', 
                            'data_type'
                    )
            ));
            
            return $fields;
        } else {
            return false;
        }
    }
    
    /**
     * Get the SQL used as a subquery to generate Virtual Fields
     * @param $model
     */
    private function _getVirtualFieldSql($model = null, $entityId = null) {
        if ($model != null) {
            $fields = $this->_getVirtualFieldsByModel($model);
            
            if (! empty($fields)) {
                foreach ($fields as $field) {
                    $valueModel = $this->valueModels[$field['Attribute']['data_type']];
                    $this->$valueModel = ClassRegistry::init($valueModel);
                    $dbo = $this->$valueModel->getDataSource();
                    $table = 'attributes_' . $field['Attribute']['data_type'] . '_values';
                    $table = $dbo->fullTableName($this->$valueModel);
                    if ($entityId) {
                        $conditionsSubQuery['`' . $valueModel . '`.`entity_id`'] = $entityId;
                    } else {
                        $conditionsSubQuery[] = '`' . $valueModel . '`.`entity_id` = `' . $model->alias . '`.`id`';
                    }
                    
                    $conditionsSubQuery['`' . $valueModel . '`.`attribute_id`'] = $field['Attribute']['id'];
                    $subQuery = $dbo->buildStatement(array(
                            'fields' => array(
                                    $valueModel . '.value'
                            ), 
                            'table' => $table, 
                            'alias' => $valueModel, 
                            'limit' => null, 
                            'offset' => null, 
                            'joins' => array(), 
                            'conditions' => $conditionsSubQuery, 
                            'order' => null, 
                            'group' => null
                    ), $this->$valueModel);
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
    private function _getVirtualFieldConditionSql($model = null, $attributeName,$condition) {
        
                    $attribute = ClassRegistry::init($this->attributeModel)->find('first',array('conditions' => array('name' => $attributeName)));
                    $valueModel = $this->valueModels[$attribute['Attribute']['data_type']];
                    $this->$valueModel = ClassRegistry::init($valueModel);
                    $dbo = $this->$valueModel->getDataSource();
                    $table = 'attributes_' . $attribute['Attribute']['data_type'] . '_values';
                    $table = $dbo->fullTableName($this->$valueModel);
                    $conditionsSubQuery[] = '`' . $valueModel . '`.`entity_id` = `' . $model->alias . '`.`id`';
                    
                    $conditionsSubQuery['`' . $valueModel . '`.`attribute_id`'] = $attribute['Attribute']['id'];
                    foreach($condition as $key => $value)  {
                        //$newKey = str_replace($attributeName,'value',$key);
                        //$newKey = str_replace($model->name,$valueModel,$newKey);
                        $condition['value'] = $value;
                        $condition = Set::remove($condition,$key);
                        //$conditionsSubQuery[$newKey] = $value;
                        $conditionsSubQuery = Set::merge($conditionsSubQuery,$condition);
                    //debug($conditionsSubQuery);
                    }    
                    
                    $subQuery = $dbo->buildStatement(array(
                            'fields' => array(
                                    $valueModel . '.entity_id'
                            ), 
                            'table' => $table, 
                            'alias' => $valueModel, 
                            'limit' => null, 
                            'offset' => null, 
                            'joins' => array(), 
                            'conditions' => $conditionsSubQuery, 
                            'order' => null, 
                            'group' => null
                    ), $this->$valueModel);
                    $subQueryExpression = $dbo->expression($subQuery);
                    $query[] = $subQueryExpression;
                    
                    $fieldData[$attribute['Attribute']['name']] = $subQuery;
                    unset($conditionsSubQuery);
                    //debug($subQuery);
                    //debug($fieldData);
                    return $subQuery;
                    
    
    }
    
    /**
     * Get all of the attributes
     */
    function getAttributes() {
        $attributeModel = $this->attributeModel;
        return ClassRegistry::init($attributeModel)->find('all');
    }
    
    /**
     * 
     * Returns and array of Attribute Ids with the given name
     * @param unknown_type $name
     */
    function getAttributeIdByName($name) {
        return ClassRegistry::init($this->attributeModel)->find('all', array(
                'fields' => array(
                        'id'
                ), 
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
    function getAttributeValues(&$Model, $entity) {
        foreach ($this->valueModels as $dataType => $dataModel) {
            foreach ($entity[$dataModel] as $attributeData) {
                $attributes[$attributeData['Attribute']['name']] = $attributeData['value'];
            }
        }
        return $attributes;
    }
    
    /**
     *
     * Bind the entity to a Model using a foreign key stored in the key data model
     * @param unknown_type $model
     */
    function bindThroughAttribute($model) {
        $key = Inflector::underscore($model) . '_id';
        $attributeId = $this->$attributeModel->field('id', array(
                'name' => $key
        ));
        $belongsTo = array(
                $model => array(
                        'className' => $model, 
                        'foreignKey' => 'value'
                )
        );
        $this->$entityModel->belongsTo = array_merge($this->$entityModel->belongsTo, $belongsTo);
    
    }
    
    /**
     * 
     * Bind the Entity Model to all of the Models with values in the key Model
     */
    function bindThroughAttributes() {
        $attributes = $this->$attributeModel->findAllByType('key');
        foreach ($attributes as $attribute) {
            $model = Inflector::camelCase(substr($attribute[$attributeModel], - 2));
            $this->bindThroughAttribute($model);
        }
        $attributes = $this->$attributeModel->findAllByType('uuid');
        foreach ($attributes as $attribute) {
            $model = Inflector::camelCase(substr($attribute[$attributeModel], - 2));
            $this->bindThroughAttribute($model);
        }
    }
    
    /**
     * 
     * Do a global find and replace on the Text and String Attribute Tables.
     * @todo Test and update this
     * @param unknown_type $searchText The string or partial string to search for.
     * @param unknown_type $replaceText The string that should replace $searchText
     * @param unknown_type $attributeValuesUpdateList An array of Attribute Value Id's that the call should be 
     * limited to. The array should be generated by a query that includes $searchText. Essentially, you should find
     * the AttributesXValue.id where the value contains $searchText. You may want to additionally filter by entity_id.
     */
    function findReplace(&$Model,$searchText, $replaceText, $attributeValuesUpdateList = null) {
        $rows = 0;
        if (! empty($searchText)) {
            $AttributesTextValue = ClassRegistry::init('AttributesTextValue');
            $AttributesStringValue = ClassRegistry::init('AttributesStringValue');
            $conditionsText = array('1 = 1');
            $conditionsString = array('1 = 1');
            if (isset($attributeValuesUpdateList)) {
                $conditionsText = array('AttributesTextValue.id' => $attributeValuesUpdateList);
                $conditionsText = array('AttributesStringValue.id' => $attributeValuesUpdateList);
            }
            $replace = 'REPLACE(`AttributesTextValue`.`value`,"' . $searchText .'","' . $replaceText . '")';
            $AttributesTextValue->updateAll(array('AttributesTextValue.value' => $replace),$conditionsText);
            $rows += $AttributesTextValue->getAffectedRows();
            $replace = 'REPLACE(`AttributesStringValue`.`value`,"' . $searchText .'","' . $replaceText . '")';
            $AttributesStringValue->updateAll(array('AttributesStringValue.value' => $replace),$conditionsString);
        }
        return $rows;
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
                $value = $this->$dataModel->field('value', array(
                        'id' => $attributeValueId
                ));
                if (isset($value)) {
                    return $value;
                }
            }
            return false;
        } else {
            //Find the value from the given $dataType
            $dataModel = $this->valueModels[$dataType];
            $value = $this->$dataModel->field('value', array(
                    'id' => $attributeValueId
            ));
            return $value;
        
        }
        return false;
    }
    
    /**
     * Finds the Attribute Values for a given Entity Id. Returns an array of Attributes in a key => value pair array
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
                $values = $this->$dataModel->find('all', array(
                        $entityModel . '.id' => $entityId
                ));
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

    private function _extractField(&$Model,$key, $value) {
		$db =& ConnectionManager::getDataSource($Model->useDbConfig);
        $operatorMatch = '/^((' . implode(')|(', $db->__sqlOps);
    		$operatorMatch .= '\\x20)|<[>=]?(?![^>]+>)\\x20?|[>=!]{1,3}(?!<)\\x20?)/is';
    		$bound = (strpos($key, '?') !== false || (is_array($value) && strpos($key, ':') !== false));
    
    		if (!strpos($key, ' ')) {
    			$operator = '=';
    		} else {
    			list($key, $operator) = explode(' ', trim($key), 2);
    
    			if (!preg_match($operatorMatch, trim($operator)) && strpos($operator, ' ') !== false) {
    				$key = $key . ' ' . $operator;
    				$split = strrpos($key, ' ');
    				$operator = substr($key, $split);
    				$key = substr($key, 0, $split);
    			}
    		}
    
    		$type = (is_object($Model) ? $Model->getColumnType($key) : null);
    
    		$null = ($value === null || (is_array($value) && empty($value)));
    
    		if (strtolower($operator) === 'not') {
    			$data = $db->conditionKeysToString(
    				array($operator => array($key => $value)), true, $Model
    			);
    			return $data[0];
    		}
    
    		$value = $db->value($value, $type);
    		if ($bound) {
    		$keyArray = explode('.',str_replace('`', '', $key));
        		if (isset($keyArray[1])) {
        		    return $keyArray[1];
        		} else {
        		    return $keyArray[0];
        		}
            }
    		
    		if ($key !== '?') {
    			$isKey = (strpos($key, '(') !== false || strpos($key, ')') !== false);
    			$key = $isKey ? $db->__quoteFields($key) : $db->name($key);
    		}
        
    		if (!preg_match($operatorMatch, trim($operator))) {
    			$operator .= ' =';
    		}
    		$operator = trim($operator);
    
    		if (is_array($value)) {
    			$value = implode(', ', $value);
    
    			switch ($operator) {
    				case '=':
    					$operator = 'IN';
    				break;
    				case '!=':
    				case '<>':
    					$operator = 'NOT IN';
    				break;
    			}
    			$value = "({$value})";
    		} elseif ($null) {
    			switch ($operator) {
    				case '=':
    					$operator = 'IS';
    				break;
    				case '!=':
    				case '<>':
    					$operator = 'IS NOT';
    				break;
    			}
    		}
    		$keyArray = explode('.',str_replace('`', '', $key));
    		if (isset($keyArray[1])) {
    		    return $keyArray[1];
    		} else {
    		    return $keyArray[0];
    		}
        }
    /**
     * beforeFind Callback
     * This can be used to intercept finds by attribute fields and handle them appropriately
     *
     * @param object $Model    Model using the behavior
     * @param array $query Query parameters as set by cake
     * @return array
     * @access public
     */
    function beforeFind(&$Model, $query) {
        //Depending on the the virtualFieldType
        if ($Model->recursive < 2) {
            $Model->recursive = 2;
        };
        //debug($query);
        if ($this->settings[$Model->name]['type'] == 'entity') {
            if ( $this->virtualFieldType == 'eav') {
                foreach($query['conditions'] as $key => $value) {
                    $field = $this->_extractField(&$Model, $key, $value); 
                    $attribute = ClassRegistry::init($this->attributeModel)->find('first',array('conditions' => array('name' => $field)));
            		if (!empty($attribute)) {
            		    $valueModel = $this->valueModels[$attribute['Attribute']['data_type']];
                        $virtualSql = $this->_getVirtualFieldSql($Model);
                        $query['conditions'] = Set::merge($query['conditions'],$Model->name . '.id IN (' . $this->_getVirtualFieldConditionSql($Model,$attribute['Attribute']['name'], array($key => $value)) . ')');
            		    $query = Set::remove($query,'conditions.' . $key);
            		}
                }
                
            }
        }
                //Add logic to trap conditions on virtualFields
        return $query;
        
    }
    
    /**
     * afterFind Callback 
     * Manipulates the results returned from a find. This handles the Array and EAV options of the $virtualFieldType option. For the Array type, 
     * the Attribute Values are returned in a in a Attributes array. For the EAV type, the attributes are merged with the model array. In both cases,
     * the Attbribute Arrays are removed.
     *
     * @param object $Model    Model using the behavior
     * @param array $results The results of the find to manipulate.
     * @return array Returns the modified results
     * @access publics
     */
    function afterFind(&$Model, $results) {
        //debug($this->type);
        if ($this->virtualFieldType == 'array' && (key_exists('AttributesKeyValue', $results[0])) && ($this->type == 'entity')) {
            foreach ($results as $key => $value) {
                foreach ($this->valueModels as $dataType => $dataModel) {
                    foreach ($value[$dataModel] as $attributeData) {
                        $results[$key]['Attributes'][$attributeData['Attribute']['name']] = $attributeData['value'];
                            $field = $attributeData['Attribute']['name'];
                        if (substr($field,-3) == '_id') {
                            $modelName = Inflector::camelize(substr($field,0,strpos($field,'_id')));
                            $relatedModel = ClassRegistry::init($modelName)->findById($attributeData['value']);
                            $relatedModel[] = $relatedModel[$modelName];
                            unset($relatedModel[$modelName]);
                            $results[$key]['Attributes'][$modelName] = $relatedModel;
                            
                        }
                    }
                       unset($results[$key][$dataModel]);
                }
            }
        }
        if ($this->virtualFieldType == 'eav' && (isset($results[0])) && (key_exists('AttributesKeyValue', $results[0])) && ($this->type == 'entity')) {
            foreach ($results as $key => $value) {
                foreach ($this->valueModels as $dataType => $dataModel) {
                    foreach ($value[$dataModel] as $attributeData) {
                        $results[$key]['Attributes'][$attributeData['Attribute']['name']] = $attributeData['value'];
                            $field = $attributeData['Attribute']['name'];
                            $modelName = Inflector::camelize(substr($field,0,strpos($field,'_id')));
                            if (substr($field,-3) == '_id') {
                            $relatedModel[] = ClassRegistry::init($modelName)->findById($attributeData['value']);
                            $results[$key][$Model->name][$modelName] = $relatedModel[0][$modelName];
                            
                        }
                    }
                        unset($results[$key][$dataModel]);
                }
                if ( isset($results[$key]['Attributes'])) {
                $model = $results[$key][$Model->name];
                $attributes = $results[$key]['Attributes'];
                $results[$key][$Model->name] = Set::merge($model, $attributes);
                unset($results[$key]['Attributes']);
                }
                
            }

        }
        return $results;
    }
    
    /**
     * beforeSave Callback
     * 
     * @todo Use this to intercept saves on virtual fields
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
        $data = $model->data;
        $entity_id = $data['Contact']['id'];
        foreach ($data[$model->name] as $field => $value) {
            //debug($field);
            if ($model->isVirtualField($field) || $this->getAttributeIdByName($field)) {
                $attribute = ClassRegistry::init($this->attributeModel)->findByName($field);
                $dataModel = $this->valueModels[$attribute['Attribute']['data_type']];
                $model->$dataModel->create();
                $data = array(
                    'entity_id' => $entity_id,
                    'attribute_id' => $attribute['Attribute']['id'],
                    'value' => $value);
                $model->$dataModel->save($data);
            }
        }
    }
    
/**
 * Sets the cascade parameter when deleting an entity so that attribute values are also deleted
 *
 * @return void
 * @access public
 */
    function beforeDelete(&$model,$cascade = true) {
    }
    
/**
 * 
 *
 * @return void
 * @access public
 */
    function afterDelete(&$model) {
    }
}
