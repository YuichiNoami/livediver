<div class="users view">
	<h2><?php print(h($selected_user['username'])); ?>さんのユーザーページ</h2>
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
				<?php foreach ($comments as $comment) : ?>
					<li><?php echo $this->Html->link($comment['Comment']['comment'], '/events/view/' . $comment['Comment']['event_id']); ?></li>
				<?php endforeach; ?>
			</ul>