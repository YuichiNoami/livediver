<?php
App::uses('AppController', 'Controller');

class UsersController extends AppController
{

	//読み込むコンポーネントの指定
	public $components = array(
		'Session',
		'Auth' => array(
			'loginRedirect' => array('controller' => 'events', 'action' => 'index'),
			'logoutRedirect' => array('controller' => 'users', 'action' => 'login'),
			'loginAction' => array('controller' => 'users', 'action' => 'login'),
			'authenticate' => array('Form' => array('fields' => array('username' => 'email')))
		)
	);

	//どのアクションが呼ばれてもはじめに実行される関数
	public function beforeFilter()
	{
		parent::beforeFilter();

		//未ログインではアクセスできないアクションを指定
		//これ以外のアクションへのアクセスはloginにリダイレクトされる規約になっている
		$this->Auth->deny('index', 'logout', 'view', 'changepass', 'changeuser', 'unsubscribe');
	}

	//ログイン後にリダイレクトされるアクション
	public function index()
	{
		$user = $this->Auth->user();
		$this->set('user', $user);

		$willgoes = $this->User->EventsUser->find('all', array(
			'conditions' => array('user_id' => $user['id'])
		));
		$this->set('willgoes', $willgoes);

		$comments = $this->User->Comment->find('all', array(
			'conditions' => array('user_id' => $user['id'])
		));
		$this->set('comments', $comments);
		$this->set('title_for_layout', 'マイページ｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}

	public function register()
	{
		//$this->requestにPOSTされたデータが入っている
		//POSTメソッドかつユーザ追加が成功したら
		if ($this->request->is('post') && $this->User->save($this->request->data)) {
			//ログイン
			//$this->request->dataの値を使用してログインする規約になっている
			$this->Auth->login();
			$this->redirect('index');
		} else {
			$this->set('title_for_layout', '新規ユーザー登録｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		}
	}

	function generatePwd()
	{
		$len = mt_rand(16, 24);
		$seed = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890";
		$end = strlen($seed) - 1;
		$pass = "";
		while ($len--) {
			$pos = mt_rand(0, $end);
			$pass .= $seed[$pos];
		}
		return $pass;
	}

	public function unsubscribe()
	{

		$user = $this->Auth->user();
		$this->User->id = $user['id'];

		if ($this->request->is('post') || $this->request->is('put')) {
			$user = $this->User->read();
			if ($user['User']['password'] === $this->Auth->password($this->request->data['User']['password'])) {
				$this->User->delete();
				$this->Auth->logout();
				$this->Session->setFlash(__('退会手続きが完了しました。'));
				$this->redirect('/users/login/');
			} else {
				$this->Session->setFlash(__('現在のパスワードが違います。'));
			}
		}
		$this->set('title_for_layout', '退会手続き｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		$this->render('unsubscribe');
	}

	public function resetpass()
	{
		$this->set('title_for_layout', 'パスワード再設定｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		$this->set('error', false);
		if (!empty($this->request->data)) {
			$someone = $this->User->findByEmail($this->request->data['User']['email']);
			if ($someone) {
				// set new pwd
				$new_pwd = $this->generatePwd();
				$this->User->id = $someone['User']['id'];
				$this->request->data['User']['password'] = $new_pwd;
				$this->request->data['User']['id'] = $this->User->id;
				$this->request->data['User']['email'] = $someone['User']['email'];
				$this->request->data['User']['username'] = $someone['User']['username'];
				$this->request->data['User']['agree'] = true;
				if ($this->User->save($this->request->data)) {
					// send mail
					$msg = "LiveDiverをご利用いただきありがとうございます。\n新しいパスワードは以下になります。\n\n$new_pwd\n\nLiveDiver:https://livediver.net/";
					$toName = $someone['User']['email'];
					$subject = "【LiveDiver】新しいパスワードをお知らせします。";
					$from = "info@livediver.net";
					$header = "From: {$from}\nReply-To: {$from}\nContent-Type: text/plain;";
					mb_send_mail($toName, $subject, $msg, $header);
					// write msg, jump
					$this->Session->setFlash(__('新しいパスワードを送信しました。'));
					$this->redirect('/users/login/');
				} else {
					$this->Session->setFlash(__('新しいパスワードの保存に失敗しました。もう一度お試しください。'));
				}
			} else {
				// write msg, jump
				$this->Session->setFlash(__('新しいパスワードを送信しました。'));
				$this->redirect('/users/login/');
			}
		}
	}

	public function changeuser()
	{

		$user = $this->Auth->user();
		$this->User->id = $user['id'];

		if ($this->request->is('post') || $this->request->is('put')) {
			$user = $this->User->read();
			if ($user['User']['password'] === $this->Auth->password($this->request->data['User']['password'])) {

				$this->request->data['User']['password'] = $this->request->data['User']['password'];
				$this->request->data['User']['id'] = $this->User->id;
				$this->request->data['User']['email'] = $this->request->data['User']['email'];
				$this->request->data['User']['username'] = $this->request->data['User']['username'];
				$this->request->data['User']['agree'] = true;
				if ($this->User->save($this->request->data)) {
					$user = $this->User->find('first', array('conditions' => array('id' => $this->Auth->user['id']), 'recursive' => -1));
					$this->Session->write('Auth', $user);
					$this->Auth->login();
					$this->Session->setFlash(__('ユーザー情報の変更に成功しました。'));
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('ユーザー情報の変更に失敗しました。もう一度お試しください。'));
				}
			} else {
				$this->Session->setFlash(__('現在のパスワードが違います。'));
			}
		}
		$this->set('title_for_layout', 'ユーザー情報変更｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}

	public function changepass()
	{

		$user = $this->Auth->user();
		$this->User->id = $user['id'];

		if ($this->request->is('post') || $this->request->is('put')) {
			$user = $this->User->read();
			if ($user['User']['password'] === $this->Auth->password($this->request->data['User']['password'])) {

				if ($this->request->data['User']['new_password_1'] === $this->request->data['User']['new_password_2']) {
					$this->request->data['User']['password'] = $this->request->data['User']['new_password_1'];
					$this->request->data['User']['id'] = $this->User->id;
					$this->request->data['User']['email'] = $user['User']['email'];
					$this->request->data['User']['username'] = $user['User']['username'];
					$this->request->data['User']['agree'] = true;
					if ($this->User->save($this->request->data)) {
						$this->Session->setFlash(__('パスワードの変更に成功しました。'));
						$this->redirect(array('action' => 'index'));
					} else {
						$this->Session->setFlash(__('パスワードの変更に失敗しました。もう一度お試しください。'));
					}
				} else {
					$this->Session->setFlash(__('新しいパスワードの確認が一致していません。'));
				}
			} else {
				$this->Session->setFlash(__('現在のパスワードが違います。'));
			}
		}
		$this->set('title_for_layout', 'パスワード変更｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		$this->render('changepass');
	}

	public function login()
	{
		if ($this->request->is('post')) {
			if ($this->Auth->login())
				return $this->redirect($this->Auth->redirect());
			else {
				$this->Session->setFlash('ログイン失敗');
			}
		} else {
			$this->set('title_for_layout', 'ホーム｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
			$user = $this->Auth->user();
			if (isset($user))
				$this->redirect(array('controller' => 'events', 'action' => 'index'));
		}
	}

	public function logout()
	{
		$this->Auth->logout();
		$this->redirect('login');
	}

	public function view($id = null)
	{
		if (!$this->User->exists($id)) {
			throw new NotFoundException(__('登録されていないユーザー'));
		}

		$options = array('conditions' => array('User.' . $this->User->primaryKey => $id));
		$user = $this->User->find('first', $options);
		$user = $user['User'];
		$this->set('selected_user', $user);

		$willgoes = $this->User->EventsUser->find('all', array(
			'conditions' => array('user_id' => $user['id'])
		));
		$this->set('willgoes', $willgoes);

		$comments = $this->User->Comment->find('all', array(
			'conditions' => array('user_id' => $user['id'])
		));
		$this->set('comments', $comments);
		$this->set('title_for_layout', $user['username'] . 'さんのユーザーページ｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}
}
