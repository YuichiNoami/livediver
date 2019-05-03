<?php if(isset($user)) { ?>
<div class="events form">
<?php echo $this->Form->create('EventDelete'); ?>
	<fieldset>
		<legend><?php echo __('『'.$event['Event']['title'].'』の削除申請'); ?></legend>
	<?php
		echo $this->Form->input('reason', array('label'=>'申請理由','rows' => '3','value'=>'','required'=>true));
		echo $this->Form->hidden('id', array('value' => $event['Event']['id']));
		echo $this->Form->hidden('title', array('value' => $event['Event']['title']));
		//echo $this->Form->hidden('Comment.inserted', array('value'=> date('Y-m-d')));
	?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('送信'), 'div'=>false, 'class'=>'btn btn-danger')); ?>
</div>
<?php } ?>
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('イベント一覧を見る'), array('action' => 'index')); ?> </li>
	</ul>
</div>
