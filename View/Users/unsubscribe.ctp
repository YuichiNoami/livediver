<h1>退会手続き</h1>
<?php
print($this->Form->create('User') .
  $this->Form->input('password', array('type' => 'password', 'label' => '現在のパスワード', 'value' => '')) .
  $this->Form->end('退会する')); ?>