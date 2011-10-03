<div class="contacts index">
	<h2><?php __('Contacts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
    <?php 
            foreach ( $contacts[0]['Contact'] as $field => $value) : 
            if (!is_array($value)) :
            ?>
			<th><?php echo $this->Paginator->sort($field);?></th>
     <?php endif; 
           endforeach;
     ?>
     
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($contacts as $contact):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
    <tr<?php echo $class;?>>
    <?php
            //debug($contact);
            foreach ( $contact['Contact'] as $field => $value) : 
            //debug($value);
            if (!is_array($value)) :
                $idField = false;
            if (substr($field,-3) == '_id') {
                $idField = true;
                $fieldName = Inflector::camelize(substr($field,0,strpos($field,'_id')));
            } else {
                $fieldName = Inflector::camelize($field);
            }
            ?>
            <td><?php if ($idField == true) {
                        //debug($contact['Contact'][$fieldName]['name']);
                        echo $this->Html->link($contact['Contact'][$fieldName]['name'],array(
                            'controller' =>Inflector::underscore(Inflector::pluralize($fieldName)),
                            'action' => 'view',
                            $contact['Contact'][$field]));
                  } else {
                        echo $contact['Contact'][$field]; 
                  } ?></td>
     <?php endif;
            endforeach; 
?>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $contact['Contact']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $contact['Contact']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $contact['Contact']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $contact['Contact']['id'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Contact', true), array('action' => 'add')); ?></li>
	</ul>
</div>