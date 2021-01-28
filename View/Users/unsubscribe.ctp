<h1>退会手続き</h1>
<?php
$options = array(
  'label' => '退会する',
  'div' => false,
  'class' => 'btn btn-danger'
);
print($this->Form->create('User') .
  $this->Form->input('password', array('type' => 'password', 'label' => '現在のパスワード', 'value' => '')) .
  $this->Form->end($options)); ?>