<div class="artistDatas form">
<?php echo $this->Form->create('Register'); ?>
	<fieldset>
		<legend><?php echo __('Register Artist'); ?></legend>
	<?php
		echo $this->Form->input('mail');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('ArtistData.name')), null, __('Are you sure you want to delete # %s?', $this->Form->value('ArtistData.name'))); ?></li>
		<li><?php echo $this->Html->link(__('List Artist Datas'), array('action' => 'index')); ?></li>
	</ul>
</div>
