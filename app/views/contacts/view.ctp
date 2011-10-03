<div class="contacts view">
<h2><?php  __('Contact');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
    <?php  
                        //debug($contact);
            foreach ( $contact['Contact'] as $field => $value) :
            if (!is_array($value)) {
                $idField = false;
            if (substr($field,-3) == '_id') {
                $idField = true;
                $fieldName = Inflector::camelize(substr($field,0,strpos($field,'_id')));
            } else {
                $fieldName = Inflector::camelize($field);
            }
            ?>
        <dt<?php if ($i % 2 == 0) echo $class;?>><?php __($fieldName); ?></dt>
        <dd<?php if ($i++ % 2 == 0) echo $class;?>>
            <?php if ($idField == true) {
                        //debug($contact['Contact'][$fieldName]['name']);
                        echo $this->Html->link($contact['Contact'][$fieldName]['name'],array(
                            'controller' =>Inflector::underscore(Inflector::pluralize($fieldName)),
                            'action' => 'view',
                            $contact['Contact'][$field]));
                  } else {
                        echo $contact['Contact'][$field]; 
                  }
            ?>
            &nbsp;
        </dd>
     <?php  
            }
           endforeach;
     ?>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Contact', true), array('action' => 'edit', $contact['Contact']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Contact', true), array('action' => 'delete', $contact['Contact']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contact['Contact']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Contacts', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Contact', true), array('action' => 'add')); ?> </li>
	</ul>
</div>
