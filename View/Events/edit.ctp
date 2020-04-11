<div class="events form">
	<?php echo $this->Form->create('Event'); ?>
	<fieldset>
		<legend><?php echo __('イベントの編集'); ?></legend>
		<?php
		$monthNames = array();
		for ($m = 1; $m <= 12; $m++) {
			$monthNames[sprintf("%02s", $m)] = $m;
		}

		echo $this->Form->input('Event.id');
		echo $this->Form->input('Event.title', array('label' => 'イベント名'));
		echo '<div class="input date required"><label for="EventDateYear">日付</label>';
		echo $this->Form->text('Event.date', array('type' => 'date'));
		echo '</div>';
		echo '<div class="input time required"><label for="EventOpenHour">オープン時間</label>';
		echo $this->Form->hour('Event.open', true);
		echo '時';
		echo $this->Form->minute('Event.open');
		echo '分';
		echo '</div>';
		echo '<div class="input time required"><label for="EventStartHour">スタート時間</label>';
		echo $this->Form->hour('Event.start', true);
		echo '時';
		echo $this->Form->minute('Event.start');
		echo '分';
		echo '</div>';
		echo $this->Form->input('Event.adv_price', array('label' => '前売価格'));
		echo $this->Form->input('Event.door_price', array('label' => '当日価格'));
		echo $this->Form->input('Event.place', array('label' => '会場', 'maxlength' => '200'));
		echo $this->Form->input('Artist.name', array('label' => '出演者（改行区切り）', 'rows' => '3', 'maxlength' => '400'));
		?>
	</fieldset>
	<?php echo $this->Form->end(array('label' => __('送信'), 'div' => false, 'class' => 'btn btn-primary')); ?>
</div>
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('イベントの削除申請'), array('action' => 'delete', $this->Form->value('Event.id'))); ?></li>
		<li><?php echo $this->Html->link(__('イベントの一覧を見る'), array('action' => 'index')); ?></li>
	</ul>
</div>