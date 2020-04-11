<h1>パスワード再設定</h1>
<?php print($this->Form->create('User') .
  $this->Form->input('User.email', array('label' => 'メールアドレス', 'value' => $user['email'])) .
  $this->Form->end('パスワードを再設定')); ?>