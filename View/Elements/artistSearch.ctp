<?php echo $this->Form->create('Artist', array('url' => '/artists/index')) ?>

<fieldset>
  <legend>アーティストを検索</legend>
  <dl>
    <dt><label>アーティスト名</label></dt>
    <dd><?php echo $this->Form->input('name', array('type' => 'text', 'div' => false, 'label' => false)) ?></dd>
  </dl>
  <?php echo $this->Form->submit('検索', array('div' => true, 'escape' => false, 'class' => 'btn btn-info')) ?>

</fieldset>

<?php echo $this->Form->end() ?>