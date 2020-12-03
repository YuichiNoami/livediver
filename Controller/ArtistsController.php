<?php
App::uses('AppController', 'Controller');
/**
 * Artists Controller
 *
 * @property Artist $Artist
 * @property PaginatorComponent $Paginator
 */
class ArtistsController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator', 'Search.Prg');

	//どのアクションが呼ばれてもはじめに実行される関数
	public function beforeFilter()
	{
		parent::beforeFilter();

		//未ログインではアクセスできないアクションを指定
		//これ以外のアクションへのアクセスはloginにリダイレクトされる規約になっている
		$this->Auth->deny('add', 'edit', 'delete');
	}

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->Prg->commonProcess();
		$this->paginate = array(
			'Artist' =>
			array(
				'conditions' => array(
					$this->Artist->parseCriteria($this->passedArgs)
				)
			)
		);

		$this->Artist->recursive = 0;
		$this->set('artists', $this->Paginator->paginate());
		$this->set('title_for_layout', 'アーティスト一覧｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}

	/**
	 * view method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function view($name = null)
	{
		$options = array('conditions' => array('name' => $name));
		$artist = $this->Artist->find('first', $options);
		if (!$artist) {
			throw new NotFoundException(__('登録されていないアーティスト'));
		}
		$this->set('artist', $artist);
		$this->set('title_for_layout', $artist['Artist']['name'] . 'の詳細｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		$data_for_layout = [
			"url" => 'https://livediver.net/events/view/' . $artist['Artist']['name'],
			"description" => $artist['Artist']['name'] . 'の詳細情報',
		];
		$this->set('data_for_layout', $data_for_layout);
	}

	/**
	 * add method
	 *
	 * @return void
	 */
	public function add()
	{
		if ($this->request->is('post')) {
			$this->Artist->create();
			$youtube = $this->request->data['Artist']['youtube'];
			$startkey = 'watch?v=';
			$startpos = strpos($youtube, $startkey);
			if ($startpos !== false) {
				$startpos = $startpos + 8;
				$youtube = substr($youtube, $startpos, 11);
			}
			$this->request->data['Artist']['youtube'] = $youtube;
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('アーティストの登録に成功しました。'));
				return $this->redirect(array('action' => 'view', $this->request->data['Artist']['name']));
			} else {
				$this->Session->setFlash(__('アーティストの登録に失敗しました。もう一度お試しください。'));
			}
		} else {
			$this->set('title_for_layout', 'アーティストを新規登録｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		}
	}

	/**
	 * edit method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function edit($name = null)
	{
		$options = array('conditions' => array('name' => $name));
		$artist = $this->Artist->find('first', $options);
		if (!$artist) {
			throw new NotFoundException(__('登録されていないアーティスト'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$youtube = $this->request->data['Artist']['youtube'];
			$startkey = 'watch?v=';
			$startpos = strpos($youtube, $startkey);
			if ($startpos !== false) {
				$startpos = $startpos + 8;
				$youtube = substr($youtube, $startpos, 11);
			}
			$this->request->data['Artist']['youtube'] = $youtube;
			if ($this->Artist->save($this->request->data)) {
				$this->Session->setFlash(__('アーティストの編集に成功しました。'));
				return $this->redirect(array('action' => 'view', $this->request->data['Artist']['name']));
			} else {
				$this->Session->setFlash(__('アーティストの編集に失敗しました。もう一度お試しください。'));
			}
		} else {
			$this->request->data = $artist;
			$this->set('title_for_layout', $artist['Artist']['name'] . 'を編集｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		}
	}

	/**
	 * delete method
	 *
	 * @throws NotFoundException
	 * @param string $id
	 * @return void
	 */
	public function delete($id = null)
	{
		$this->Artist->id = $id;
		if (!$this->Artist->exists()) {
			throw new NotFoundException(__('登録されていないアーティスト'));
		}
		if ($this->request->is(array('post', 'put'))) {
			$body = <<<EOF
アーティスト削除申請

ID:{$this->request->data['ArtistDelete']['id']}
アーティスト名:{$this->request->data['ArtistDelete']['name']}
申請理由:{$this->request->data['ArtistDelete']['reason']}
EOF;
			parent::_sendNewAdminMail($body);
			$this->Session->setFlash(__('アーティストの削除申請に成功しました。'));
			$this->redirect(array('action' => 'index'));
		} else {
			$options = array('conditions' => array('Artist.' . $this->Artist->primaryKey => $id));
			$artist = $this->Artist->find('first', $options);
			$this->set('artist', $artist);
			$this->set('title_for_layout', $artist['Artist']['name'] . 'の削除申請｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		}
	}
}
