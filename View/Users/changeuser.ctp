<h1>ユーザー情報変更</h1>
<?php
$options = array(
  'label' => 'ユーザー情報を変更',
  'div' => false,
  'class' => 'btn btn-primary'
);
print($this->Form->create('User') .
  $this->Form->input('password', array('type' => 'password', 'label' => '現在のパスワード', 'value' => '')) .
  $this->Form->input('User.username', array('label' => 'ユーザー名', 'value' => $user['username'])) .
  $this->Form->input('User.email', array('label' => 'メールアドレス', 'value' => $user['email'])) .
  $this->Form->end($options)); ?>