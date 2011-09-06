<div class="users view">
<h2><?php  __('User');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit User', true), array('action' => 'edit', $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete User', true), array('action' => 'delete', $user['User']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $user['User']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List App Models', true), array('controller' => 'app_models', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attributes Key Values', true), array('controller' => 'app_models', 'action' => 'add')); ?> </li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesKeyValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesKeyValues'] as $attributesKeyValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesKeyValues['id'];?></td>
			<td><?php echo $attributesKeyValues['entity_id'];?></td>
			<td><?php echo $attributesKeyValues['attribute_id'];?></td>
			<td><?php echo $attributesKeyValues['value'];?></td>
			<td><?php echo $attributesKeyValues['created'];?></td>
			<td><?php echo $attributesKeyValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesKeyValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesKeyValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesKeyValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesKeyValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Key Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesUuidValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesUuidValues'] as $attributesUuidValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesUuidValues['id'];?></td>
			<td><?php echo $attributesUuidValues['entity_id'];?></td>
			<td><?php echo $attributesUuidValues['attribute_id'];?></td>
			<td><?php echo $attributesUuidValues['value'];?></td>
			<td><?php echo $attributesUuidValues['created'];?></td>
			<td><?php echo $attributesUuidValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesUuidValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesUuidValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesUuidValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesUuidValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Uuid Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesStringValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesStringValues'] as $attributesStringValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesStringValues['id'];?></td>
			<td><?php echo $attributesStringValues['entity_id'];?></td>
			<td><?php echo $attributesStringValues['attribute_id'];?></td>
			<td><?php echo $attributesStringValues['value'];?></td>
			<td><?php echo $attributesStringValues['created'];?></td>
			<td><?php echo $attributesStringValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesStringValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesStringValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesStringValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesStringValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes String Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesTextValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesTextValues'] as $attributesTextValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesTextValues['id'];?></td>
			<td><?php echo $attributesTextValues['entity_id'];?></td>
			<td><?php echo $attributesTextValues['attribute_id'];?></td>
			<td><?php echo $attributesTextValues['value'];?></td>
			<td><?php echo $attributesTextValues['created'];?></td>
			<td><?php echo $attributesTextValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesTextValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesTextValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesTextValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesTextValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Text Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesIntegerValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesIntegerValues'] as $attributesIntegerValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesIntegerValues['id'];?></td>
			<td><?php echo $attributesIntegerValues['entity_id'];?></td>
			<td><?php echo $attributesIntegerValues['attribute_id'];?></td>
			<td><?php echo $attributesIntegerValues['value'];?></td>
			<td><?php echo $attributesIntegerValues['created'];?></td>
			<td><?php echo $attributesIntegerValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesIntegerValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesIntegerValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesIntegerValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesIntegerValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Integer Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesFloatValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesFloatValues'] as $attributesFloatValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesFloatValues['id'];?></td>
			<td><?php echo $attributesFloatValues['entity_id'];?></td>
			<td><?php echo $attributesFloatValues['attribute_id'];?></td>
			<td><?php echo $attributesFloatValues['value'];?></td>
			<td><?php echo $attributesFloatValues['created'];?></td>
			<td><?php echo $attributesFloatValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesFloatValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesFloatValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesFloatValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesFloatValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Float Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesDatetimeValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesDatetimeValues'] as $attributesDatetimeValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesDatetimeValues['id'];?></td>
			<td><?php echo $attributesDatetimeValues['entity_id'];?></td>
			<td><?php echo $attributesDatetimeValues['attribute_id'];?></td>
			<td><?php echo $attributesDatetimeValues['value'];?></td>
			<td><?php echo $attributesDatetimeValues['created'];?></td>
			<td><?php echo $attributesDatetimeValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesDatetimeValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesDatetimeValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesDatetimeValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesDatetimeValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Datetime Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesTimestampValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesTimestampValues'] as $attributesTimestampValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesTimestampValues['id'];?></td>
			<td><?php echo $attributesTimestampValues['entity_id'];?></td>
			<td><?php echo $attributesTimestampValues['attribute_id'];?></td>
			<td><?php echo $attributesTimestampValues['value'];?></td>
			<td><?php echo $attributesTimestampValues['created'];?></td>
			<td><?php echo $attributesTimestampValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesTimestampValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesTimestampValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesTimestampValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesTimestampValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Timestamp Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesTimeValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesTimeValues'] as $attributesTimeValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesTimeValues['id'];?></td>
			<td><?php echo $attributesTimeValues['entity_id'];?></td>
			<td><?php echo $attributesTimeValues['attribute_id'];?></td>
			<td><?php echo $attributesTimeValues['value'];?></td>
			<td><?php echo $attributesTimeValues['created'];?></td>
			<td><?php echo $attributesTimeValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesTimeValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesTimeValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesTimeValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesTimeValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Time Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesDateValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesDateValues'] as $attributesDateValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesDateValues['id'];?></td>
			<td><?php echo $attributesDateValues['entity_id'];?></td>
			<td><?php echo $attributesDateValues['attribute_id'];?></td>
			<td><?php echo $attributesDateValues['value'];?></td>
			<td><?php echo $attributesDateValues['created'];?></td>
			<td><?php echo $attributesDateValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesDateValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesDateValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesDateValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesDateValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Date Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesBinaryValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesBinaryValues'] as $attributesBinaryValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesBinaryValues['id'];?></td>
			<td><?php echo $attributesBinaryValues['entity_id'];?></td>
			<td><?php echo $attributesBinaryValues['attribute_id'];?></td>
			<td><?php echo $attributesBinaryValues['value'];?></td>
			<td><?php echo $attributesBinaryValues['created'];?></td>
			<td><?php echo $attributesBinaryValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesBinaryValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesBinaryValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesBinaryValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesBinaryValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Binary Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
<div class="related">
	<h3><?php __('Related App Models');?></h3>
	<?php if (!empty($user['AttributesBooleanValues'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Id'); ?></th>
		<th><?php __('Entity Id'); ?></th>
		<th><?php __('Attribute Id'); ?></th>
		<th><?php __('Value'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Modified'); ?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($user['AttributesBooleanValues'] as $attributesBooleanValues):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $attributesBooleanValues['id'];?></td>
			<td><?php echo $attributesBooleanValues['entity_id'];?></td>
			<td><?php echo $attributesBooleanValues['attribute_id'];?></td>
			<td><?php echo $attributesBooleanValues['value'];?></td>
			<td><?php echo $attributesBooleanValues['created'];?></td>
			<td><?php echo $attributesBooleanValues['modified'];?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'app_models', 'action' => 'view', $attributesBooleanValues['id'])); ?>
				<?php echo $this->Html->link(__('Edit', true), array('controller' => 'app_models', 'action' => 'edit', $attributesBooleanValues['id'])); ?>
				<?php echo $this->Html->link(__('Delete', true), array('controller' => 'app_models', 'action' => 'delete', $attributesBooleanValues['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $attributesBooleanValues['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		<ul>
			<li><?php echo $this->Html->link(__('New Attributes Boolean Values', true), array('controller' => 'app_models', 'action' => 'add'));?> </li>
		</ul>
	</div>
</div>
