<h1>パスワード再設定</h1>
<?php
$options = array(
  'label' => 'パスワードを再設定',
  'div' => false,
  'class' => 'btn btn-danger'
);
print($this->Form->create('User') .
  $this->Form->input('User.email', array('label' => 'メールアドレス', 'value' => '')) .
  $this->Form->end($options)); ?>