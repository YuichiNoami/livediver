<div class="artistsEvents form">
<?php echo $this->Form->create('ArtistsEvent'); ?>
	<fieldset>
		<legend><?php echo __('Add Artists Event'); ?></legend>
	<?php
		echo $this->Form->input('event_id');
		echo $this->Form->input('artist_id');
		echo $this->Form->input('act');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Artists Events'), array('action' => 'index')); ?></li>
	</ul>
</div>
