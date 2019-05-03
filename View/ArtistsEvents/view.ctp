<div class="artistsEvents view">
<h2><?php echo __('Artists Event'); ?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($artistsEvent['ArtistsEvent']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Event Id'); ?></dt>
		<dd>
			<?php echo h($artistsEvent['ArtistsEvent']['event_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Artist Id'); ?></dt>
		<dd>
			<?php echo h($artistsEvent['ArtistsEvent']['artist_id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Act'); ?></dt>
		<dd>
			<?php echo h($artistsEvent['ArtistsEvent']['act']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Artists Event'), array('action' => 'edit', $artistsEvent['ArtistsEvent']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Artists Event'), array('action' => 'delete', $artistsEvent['ArtistsEvent']['id']), null, __('Are you sure you want to delete # %s?', $artistsEvent['ArtistsEvent']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Artists Events'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Artists Event'), array('action' => 'add')); ?> </li>
	</ul>
</div>
