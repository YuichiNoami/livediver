<?php $this->set('title_for_layout', 'LiveDiver｜もっとライブに行きたくなる情報ポータル'); ?>
<div class="events index">
	<h2><?php echo __('イベント一覧'); ?></h2>
	<table cellpadding="0" cellspacing="0">
	<?php 
	//debug($past_exist);
	//debug($once);
	//debug($events); ?>
	<tr>
			<th><?php echo __('日付'); ?></th>
			<th><?php echo __('イベント名'); ?><br><?php echo __('会場'); ?></th>
	</tr>
	<?php foreach ($events as $event): ?>
	<tr>
		<?php 
		$week = array("日", "月", "火", "水", "木", "金", "土");
		$time = strtotime($event['Event']['date']);
		$w = date("w", $time);
		?>
		<td><?php echo h($event['Event']['date'].'('.$week[$w].')'); ?></td>
		<td><?php echo $this->Html->link($event['Event']['title'], '/events/view/'.$event['Event']['id']); ?><?php echo h($event['Event']['place']); ?></td>
	</tr>
<?php endforeach; ?>
	</table>
	<div class="paging">
	<ul class="pager">
		<!--<li><?php echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled')); ?></li>-->
		<li><?php echo $this->Paginator->numbers(array('separator' => '')); ?></li>
		<!--<li><?php echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled')); ?></li>-->
	</ul>
	</div>
</div>
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('イベントを新規登録'), array('action' => 'add')); ?></li>
	</ul>
</div>
