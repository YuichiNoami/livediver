<h1>パスワード変更</h1>
<?php print(
  $this->Form->create('User') .
  $this->Form->input('password', array('type' => 'password','label' => '現在のパスワード','value' => '')) .
  $this->Form->input('new_password_1', array('type' => 'password','label' => '新しいパスワード','value' => '')) .
  $this->Form->input('new_password_2', array('type' => 'password','label' => '新しいパスワード（確認）','value' => '')) .
  $this->Form->end('パスワードを変更')
); ?>