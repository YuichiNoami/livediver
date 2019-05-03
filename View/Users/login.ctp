<h1>ログイン</h1>
<?php print(
  $this->Form->create('User') .
  $this->Form->input('email',array('label' => 'メールアドレス')) .
  $this->Form->input('password', array('type' => 'password','label' => 'パスワード')) .
  $this->Form->end('ログイン')
); ?>
<div class="well">
<?php echo $this->Html->link('パスワードを忘れた', '/users/resetpass/'); ?>
</div>
<div class="well">
<?php echo $this->Html->link('新規登録', '/users/register/'); ?>
</div>

<div id="header" class="well">
	<div class="hero-unit">
	  <p>LiveDiverは誰もが自由にライブの情報を登録・編集できる！もっとライブに行きたくなる情報ポータルサイトです。</p>
	</div>
</div>
<div id="howto" class="well">
<h2>基本的な使い方</h2>
<p>まずは<?php echo $this->Html->link('1分で終わるユーザー登録', '/users/register/'); ?>を行いましょう。これだけであなたは、ライブイベントの登録や編集、アーティストの登録や編集をしたり、イベント詳細ページの「いくよ！」ボタンで参戦表明をしたり、楽しみなイベント、あるいは楽しかったイベントにコメントをしたりなど様々な方法で私達の愛するライブシーンをもっと盛り上げることに貢献することが出来ます。
</div>
