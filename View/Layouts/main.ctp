<!DOCTYPE html>
<html>

<head>
  <?php echo $this->Html->charset(); ?>
  <title><?php echo $title_for_layout; ?></title>
  <?php echo $this->Html->css('cake.generic'); ?>
</head>

<body>
  <div id="container">
    <?php debug($user) ?>
    <?php echo $this->Session->flash(); ?>
    <div id="header">
      <div id="header_menu">
        <?php
        if (isset($user)) :
          echo $this->Html->link('マイページ', '/users/');
          echo "&nbsp;";
          echo $this->Html->link('ログアウト', '/users/logout');
        else :
          echo $this->Html->link('ログイン', '/users/login');
          echo "&nbsp;";
          echo $this->Html->link('新規登録', '/users/register');
        endif;
        ?>
      </div>
      <div id="header_logo">
        <h1><?php echo $this->Html->link('LiveDiver', '/'); ?></h1>
      </div>
      <div id="content">
        <?php echo $this->fetch('content'); ?>
      </div>
    </div>