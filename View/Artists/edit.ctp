<div class="artistDatas form">
<?php echo $this->Form->create('Artist'); ?>
	<fieldset>
		<legend><?php echo __('アーティストの編集'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name', array('label'=>'アーティスト名'));
		echo $this->Form->input('profile', array('label'=>'プロフィール','rows'=>'3','maxlength'=>'1200'));
		echo $this->Form->input('web', array('label'=>'Webサイト'));
		echo $this->Form->input('youtube', array('label'=>'YouTube（URLまたはビデオID）'));
	?>
	</fieldset>
	<?php echo $this->Form->end(array('label'=>__('送信'), 'div'=>false, 'class'=>'btn btn-primary')); ?>
</div>
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>

		<li><?php //echo $this->Form->postLink(__('アーティストの削除'), array('action' => 'delete', $this->Form->value('Artist.id')), null, __('『%s』を削除しますか？', $this->Form->value('Artist.name'))); 
				  echo $this->Html->link(__('アーティストの削除申請'), array('action' => 'delete', $this->Form->value('Artist.id'))); ?></li>
		<li><?php echo $this->Html->link(__('アーティスト一覧を見る'), array('action' => 'index')); ?></li>
	</ul>
</div>
