<div class="events view">
	<h2><?php echo __('『' . $event['Event']['title'] . '』の詳細'); ?></h2>
	<?php echo $this->Form->postLink(__($willgo), array('action' => 'willgo', $event['Event']['id'], $user['id']), array('class' => 'btn btn-info'), __($willgo_message)); ?>
	<?php echo '(' . $willgo_count . 'いくよ！)'; ?>

	<dl>
		<dt><?php echo __('イベント名'); ?></dt>
		<dd>
			<?php echo h($event['Event']['title']); ?>
		</dd>
		<dt><?php echo __('出演者'); ?></dt>
		<dd>
			<ul>
				<?php
					$event['Actor'] = [];
					foreach ($event['Artist'] as $act) : ?>
					<li><?php 
							$event['Actor'][] = $act['name'];
							echo $this->Html->link($act['name'], '/artists/view/' . $act['name']); 
						?>
					</li>
				<?php
					endforeach;
				?>
			</ul>
		</dd>
		<dt><?php echo __('日付'); ?></dt>
		<dd>
			<?php
			$week = array("日", "月", "火", "水", "木", "金", "土");
			$time = strtotime($event['Event']['date']);
			$w = date("w", $time);
			?>
			<?php echo h($event['Event']['date'] . '(' . $week[$w] . ')'); ?>
		</dd>
		<dt><?php echo __('オープン時間'); ?></dt>
		<dd>
			<?php echo date('H時i分', strtotime(h($event['Event']['open']))); ?>
		</dd>
		<dt><?php echo __('スタート時間'); ?></dt>
		<dd>
			<?php echo date('H時i分', strtotime(h($event['Event']['start']))); ?>
		</dd>
		<dt><?php echo __('前売価格'); ?></dt>
		<dd>
			<?php echo h($event['Event']['adv_price'] . '円'); ?>
		</dd>
		<dt><?php echo __('当日価格'); ?></dt>
		<dd>
			<?php echo h($event['Event']['door_price'] . '円'); ?>
		</dd>
		<dt><?php echo __('会場'); ?></dt>
		<dd>
			<?php echo $this->Html->link(h($event['Event']['place']), 'https://www.google.co.jp/search?q=' . h($event['Event']['place'])); ?>
		</dd>
		<dt><?php echo __('コメント'); ?></dt>
		<dd>
			<ul>
				<?php foreach ($event['Comment'] as $comment) : ?>
					<li class="comments">
						<?php echo h($comment['inserted']); ?>
						<br>
						<?php echo nl2br($this->Text->autoLinkUrls(h($comment['comment']))) ?>
						by
						<?php echo $this->Html->link($comment_user[$comment['user_id']], '/users/view/' . $comment['user_id']); ?>
						&nbsp;
					</li>
				<?php endforeach; ?>
			</ul>
		</dd>
		<dt><?php echo __('イベントのシェア'); ?></dt>
		<dd>
			<div id="tweet_event">
				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-text="<?php echo h($this->Text->truncate("【".$event['Event']['title']."】\n\n".implode(", ", $event['Actor']), 90, array('ellipsis' => '...', 'exact' => true, 'html' => true)) . "の出演するイベント"); ?>" data-url="<?php echo ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>">ツイート</a>
				<script>
					! function(d, s, id) {
						var js, fjs = d.getElementsByTagName(s)[0],
							p = /^http:/.test(d.location) ? 'http' : 'https';
						if (!d.getElementById(id)) {
							js = d.createElement(s);
							js.id = id;
							js.src = p + '://platform.twitter.com/widgets.js';
							fjs.parentNode.insertBefore(js, fjs);
						}
					}(document, 'script', 'twitter-wjs');
				</script>
			</div>
		</dd>
	</dl>
</div>
<?php if (isset($user)) { ?>
	<div class="events form">
		<?php echo $this->Form->create('Event'); ?>
		<fieldset>
			<legend><?php echo __('コメントを投稿'); ?></legend>
			<?php
			echo $this->Form->hidden('Comment.user_id', array('value' => $user['id']));
			echo $this->Form->input('Comment.id');
			echo $this->Form->input('Comment.comment', array('label' => 'コメント', 'rows' => '3', 'value' => ''));
			?>
		</fieldset>
		<?php echo $this->Form->end(array('label' => __('送信'), 'div' => false, 'class' => 'btn btn-success')); ?>
	</div>
<?php } ?>
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('イベントを新規登録'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('このイベントを編集'), array('action' => 'edit', $event['Event']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('イベントの削除申請'), array('action' => 'delete', $event['Event']['id'])); ?> </li>

		<li><?php echo $this->Html->link(__('イベント一覧を見る'), array('action' => 'index')); ?> </li>
	</ul>
</div>