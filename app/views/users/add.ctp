<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('username');
		echo $this->Form->input('password');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Users', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List App Models', true), array('controller' => 'app_models', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Attributes Key Values', true), array('controller' => 'app_models', 'action' => 'add')); ?> </li>
	</ul>
</div>