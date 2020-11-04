<<<<<<< HEAD
<?php //debug($user);	debug($willgoes)
?>
=======
>>>>>>> d7e00827551fbe22ec92c388e74eab4bbff3933a
<div class="users view">
	<h2><?php print(h($user['username'])); ?>さんのマイページ</h2>
	<p>※マイページの内容（いくよ！とコメント）は全体に公開されますのでご注意ください。</p>
	<br />
	&nbsp;
	<p>
		<?php echo __('いくよ！'); ?>
		<ul>
			<?php foreach ($willgoes as $willgo) : ?>
				<li><?php echo $this->Html->link($willgo['Event']['title'], '/events/view/' . $willgo['Event']['id']); ?></li>
			<?php endforeach; ?>
		</ul>
		&nbsp;
		<p>
			<?php echo __('コメント'); ?>
			<ul>
<<<<<<< HEAD
				<?php //debug($comments); 
				?>
=======
>>>>>>> d7e00827551fbe22ec92c388e74eab4bbff3933a
				<?php foreach ($comments as $comment) : ?>
					<li><?php echo $this->Html->link($comment['Comment']['comment'], '/events/view/' . $comment['Comment']['event_id']); ?></li>
				<?php endforeach; ?>
			</ul>
			&nbsp;
			<p>
				<?php print($this->Html->link('ユーザー情報の変更', 'changeuser')); ?>
				<p>
					<?php print($this->Html->link('パスワードの変更', 'changepass')); ?>
					<p>
						<?php print($this->Html->link('退会手続き', 'unsubscribe')); ?>