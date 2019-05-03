<?php
App::uses('AppModel', 'Model');

class User extends AppModel {
  //入力チェック機能
  public $validate = array(
    'username' => array(
      array(
        'rule' => 'isUnique', //重複禁止
        'message' => '既に使用されているユーザー名です。'
      ),
      array(
        'rule' => 'alphaNumeric', //半角英数字のみ
        'message' => 'ユーザー名に使用できるのは半角英数字のみです。'
      ),
    ),
    'email' => array(
      array(
        'rule' => 'isUnique', //重複禁止
        'message' => '既に使用されているメールアドレスです。'
      ),
      array(
        'rule' => 'email', //メールアドレスのみ
        'message' => 'メールアドレスとして正しくありません。'
      ),
    ),
    'password' => array(
      array(
        'rule' => 'alphaNumeric',
        'message' => 'パスワードは半角英数字にしてください。'
      ),
      array(
        'rule' => array('between', 8, 32),
        'message' => 'パスワードは8文字以上32文字以内にしてください。'
      )
    ),
    'agree' => array(
      'rule'     => array('multiple', array('min' => 1)),
      'required' => true,
      'message'  => '利用規約に同意しない場合は登録できません。',
    ),
  );

  public function beforeSave($options = array()) {
    $this->data['User']['password'] = AuthComponent::password($this->data['User']['password']);
    return true;
  }


    //The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */

    public $hasMany = array(
        'Comment' =>
            array(
                'className' => 'Comment',
                'foreignKey' => 'user_id',
                ),
        );

    public $hasAndBelongsToMany = array(
        'Event' =>
            array(
                'className'              => 'Event',
                'joinTable'              => 'events_users',
                'foreignKey'             => 'user_id',
                'associationForeignKey'  => 'event_id',
                'unique'                 => false,
                'conditions'             => '',
                'fields'                 => '',
                'order'                  => '',
                'limit'                  => '',
                'offset'                 => '',
                'finderQuery'            => '',
                'deleteQuery'            => '',
                'insertQuery'            => '',
                'with'                   => 'EventsUser'
            ),
    );

}