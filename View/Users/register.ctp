<h1>新規登録</h1>
<?php print($this->Form->create('User') .
  $this->Form->input('username', array('label' => 'ユーザー名（半角英数字）', 'pattern' => '^[a-zA-Z\d]*$', 'title' => '半角英数字のみ使用できます。')) .
  $this->Form->input('email', array('label' => 'メールアドレス')) .
  $this->Form->input('password', array('type' => 'password', 'label' => 'パスワード')) .
  $this->Form->input('agree', array('type' => 'checkbox', 'label' => '<a href="/license.html">利用規約</a>に同意します')) .
  $this->Form->end('新規登録')); ?>