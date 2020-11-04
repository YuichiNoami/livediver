<div class="artists index">
	<h2><?php echo __('アーティスト一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
		<tr>
			<th><?php echo $this->Paginator->sort('id'); ?></th>
			<th><?php echo $this->Paginator->sort('name'); ?></th>
		</tr>
		<?php foreach ($artists as $artist) : ?>
			<tr>
				<td><?php echo h($artist['Artist']['id']); ?></td>
				<td><?php echo $this->Html->link(__($artist['Artist']['name']), array('action' => 'view', $artist['Artist']['name'])); ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
	<div class="paging">
		<ul class="pager">
			<li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>
		</ul>
	</div>
</div>
<?php echo $this->element('artistSearch'); ?>

<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('アーティストを新規登録'), array('action' => 'add')); ?></li>
	</ul>
</div>