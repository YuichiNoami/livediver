<div class="artistDatas form">
	<?php echo $this->Form->create('Artist'); ?>
	<fieldset>
		<legend><?php echo __('アーティストを新規登録'); ?></legend>
		<?php
		echo $this->Form->input('name', array('label' => 'アーティスト名'));
		echo $this->Form->input('profile', array('label' => 'プロフィール', 'rows' => '3', 'maxlength' => '1200'));
		echo $this->Form->input('web', array('label' => 'Webサイト'));
		echo $this->Form->input('youtube', array('label' => 'YouTube（URLまたはビデオID）'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('送信'), 'div' => false, 'class' => 'btn btn-primary')); ?>
</div>
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('アーティスト一覧を見る'), array('action' => 'index')); ?></li>
	</ul>
</div>