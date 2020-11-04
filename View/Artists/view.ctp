<div class="artists view">
	<h2><?php echo __('『' . $artist['Artist']['name'] . '』の詳細'); ?></h2>
	<dl>
		<dt><?php echo __('アーティスト名'); ?></dt>
		<dd>
			<?php echo h($artist['Artist']['name']); ?>
		</dd>
		<dt><?php echo __('プロフィール'); ?></dt>
		<dd>
			<?php echo nl2br($this->Text->autoLinkUrls($artist['Artist']['profile'])); ?>
		</dd>
		<dt><?php echo __('Webサイト'); ?></dt>
		<dd>
			<?php echo $this->Html->link($artist['Artist']['web']); ?>
		</dd>
		<dt><?php echo __('YouTube'); ?></dt>
		<dd class="youtube">
			<?php if (h($artist['Artist']['youtube']) !== '未登録') { ?>
				<iframe width="560" height="315" src="//www.youtube.com/embed/<?php echo h($artist['Artist']['youtube']); ?>?rel=0" frameborder="0" allowfullscreen></iframe>
			<?php } else { ?>
				<?php echo h($artist['Artist']['youtube']); ?>
			<?php } ?>
		</dd>
		<dt><?php echo __('今日以降の出演イベント'); ?></dt>
		<dd>
			<ul id="live-list">
				<?php
				$events = $this->requestAction('/events/name/' . $artist['Artist']['name']);
				foreach ($events as $event) : ?>
					$week = array("日", "月", "火", "水", "木", "金", "土");
					$time = strtotime($event['Event']['date']);
					$w = date("w", $time);
					?>
					<li><?php echo h($event['Event']['date'] . '(' . $week[$w] . ')'); ?>
						&nbsp;
						<?php echo $this->Html->link($event['Event']['title'], '/events/view/' . $event['Event']['id']); ?>
					</li>
				<?php endforeach; ?>
			</ul>
		</dd>
		<dt><?php echo __('アーティストのシェア'); ?></dt>
		<dd>
			<div id="tweet_artist">
				<a href="https://twitter.com/share" class="twitter-share-button" data-lang="ja" data-text="<?php echo h($this->Text->truncate($artist['Artist']['profile'], 90, array('ellipsis' => '...', 'exact' => true, 'html' => true))) ?>" data-url="<?php echo ("https://" . $_SERVER["HTTP_HOST"] . $_SERVER["REQUEST_URI"]); ?>">ツイート</a>
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
<div class="actions">
	<h3><?php echo __('アクション'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('アーティストを新規登録'), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('このアーティストを編集'), array('action' => 'edit', $artist['Artist']['name'])); ?> </li>
		<li><?php //echo $this->Form->postLink(__('アーティストの削除'), array('action' => 'delete', $artist['Artist']['id']), null, __('『%s』を削除しますか？', $artist['Artist']['name']));
			echo $this->Html->link(__('アーティストの削除申請'), array('action' => 'delete', $artist['Artist']['id'])); ?> </li>
		<!-- <li><?php //echo $this->Html->link(__('Register Artist Data'), array('action' => 'register', $artist['Artist']['name'])); 
					?> </li> -->

		<li><?php echo $this->Html->link(__('アーティスト一覧を見る'), array('action' => 'index')); ?> </li>
	</ul>
</div>