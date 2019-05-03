<div class="artistsEvents form">
<?php echo $this->Form->create('ArtistsEvent'); ?>
	<fieldset>
		<legend><?php echo __('Edit Artists Event'); ?></legend>
	<?php
		echo $this->Form->input('id');
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

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ArtistsEvent.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ArtistsEvent.id'))); ?></li>
		<li><?php echo $this->Html->link(__('List Artists Events'), array('action' => 'index')); ?></li>
	</ul>
</div>
