<div class="companies form">
<?php echo $this->Form->create('Company');?>
	<fieldset>
		<legend><?php __('Add Company'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Companies', true), array('action' => 'index'));?></li>
	</ul>
</div>