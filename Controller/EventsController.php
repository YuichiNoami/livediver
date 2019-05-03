<?php
App::uses('AppController', 'Controller');
/**
 * Events Controller
 *
 * @property Event $Event
 * @property PaginatorComponent $Paginator
 */
class EventsController extends AppController {

/**
 * Components
 *
 * @var array
 */
	public $components = array('Paginator');

	//どのアクションが呼ばれてもはじめに実行される関数
	public function beforeFilter()
	{
	  parent::beforeFilter();

	  //未ログインではアクセスできないアクションを指定
	  //これ以外のアクションへのアクセスはloginにリダイレクトされる規約になっている
	  $this->Auth->deny('add', 'edit', 'delete', 'willgo');
	}

/**
 * past method
 *
 * @return void
 */
	public function past($min=null) {
		if (!isset($min)) {
			$min = date('Y-m-d');
		}
		//連想配列の最後のkey取得
		function endKey($array){
    		end($array);
    		return key($array);
		}

		//debug($this->Event->find('all',array()));
		$this->Event->recursive = 1;
		$this->Paginator->settings = array(
        'conditions' => array('Event.date <' => $min),
        'order' => array(
            'Event.date' => 'desc'
         )
    	);
    	$events = $this->Paginator->paginate();
    	//var_dump($events);
    	if(!empty($events))
    	{
    		$endkey = endKey($events);
  			$min = $this->Event->find(
  			'first',
  			 array(
  			 	"conditions" => array('Event.date' => $events[$endkey]['Event']['date']),
  				"fields" => "MIN(Event.date) as min_date"
  				)
  			 );

  			$past_exist = $this->Event->find(
    			'first',
    			array(
    				'conditions' => array('Event.date <' => $min[0]['min_date'])
    			)
    		);
    	}

		// var_dump($past_exist);
		$past_exist = !empty($past_exist);
		$this->set('past_exist', $past_exist);
		$this->set('events', $events);
		$this->set('once', $min);
		$this->set('title_for_layout', '過去のイベント｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}

/**
 * future method
 *
 * @return void
 */
	public function future($once) {
		//連想配列の最後のkey取得
		function resetKey($array){
    		reset($array);
    		return key($array);
		}

		//debug($this->Event->find('all',array()));
		$this->Event->recursive = 1;
		$this->Paginator->settings = array(
        'conditions' => array('Event.date <' => $once),
        'order' => array(
            'Event.date' => 'desc'
         )
    	);
    	$events = $this->Paginator->paginate();
    	//var_dump($events);
    	if(!empty($events))
    	{
    		$resetkey = resetKey($events);
  			$min = $this->Event->find(
  			'first',
  			 array(
  			 	"conditions" => array('Event.date' => $events[$resetkey]['Event']['date']),
  				"fields" => "MIN(Event.date) as min_date"
  				)
  			 );
    	}

    	$past_exist = $this->Event->find(
    		'first',
    		array(
    			'conditions' => array('Event.date <' => $min[0]['min_date'])
    			)
    		);
    	//var_dump($past_exist);
    	$past_exist = !empty($past_exist);
    	$this->set('past_exist', $past_exist);

    	$future_exist = $this->Event->find(
    		'first',
    		array(
    			'conditions' => array('Event.date >' => $min[0]['max_date'])
    			)
    		);
    	//var_dump($future_exist);
    	$future_exist = !empty($future_exist);
    	$this->set('future_exist', $future_exist);


		$this->set('events', $events);
		$this->set('once', $min);
		//$this->set('events', $this->Event->find('all'));
		$this->set('title_for_layout', '未来のイベント｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}


/**
 * index method
 *
 * @return void
 */
	public function index() {
				//連想配列の最後のkey取得
		function resetKey($array){
    		reset($array);
    		return key($array);
		}

		//debug($this->Event->find('all',array()));
		$today = date('Y-m-d');
		$this->Event->recursive = 1;
		$this->Paginator->settings = array(
        'conditions' => array('Event.date >=' => $today),
        'order' => array(
			'Event.date' => 'asc'
         )
    	);
    	$events = $this->Paginator->paginate();
      	//var_dump($events);
    	if(!empty($events))
    	{
    		$resetkey = resetKey($events);
  			$max = $this->Event->find(
  			'first',
  			 array(
  			 	"conditions" => array('Event.date' => $events[$resetkey]['Event']['date']),
  				"fields" => "MAX(Event.date) as max_date"
  				)
  			 );
    	}
    	else
    	{
    		$max[0]['max_date'] = $today;
    	}

    	$past_exist = $this->Event->find(
    		'first',
    		array(
    			'conditions' => array('Event.date <' => $today)
    			)
    		);
    	//var_dump($past_exist);
    	$past_exist = !empty($past_exist);
    	$this->set('past_exist', $past_exist);

    	$future_exist = $this->Event->find(
    		'first',
    		array(
    			'conditions' => array('Event.date >' => $max[0]['max_date'])
    			)
    		);
    	//var_dump($future_exist);
    	$future_exist = !empty($future_exist);
    	$this->set('future_exist', $future_exist);

		$this->set('events', $events);
		//$this->set('once', $once);
		$this->set('today', $today);
		//$this->set('events', $this->Event->find('all'));
		$this->set('title_for_layout', 'イベント一覧｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}

/**
 * view method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function view($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('登録されていないイベント'));
		}

		if ($this->request->is(array('post', 'put'))) {
			//debug($this->request->data);
            if(!empty($this->request->data['Comment']['comment'])){
            	$comment_id = $this->Event->Comment->find('first', array("fields" => "MAX(Comment.id) as max_id"));
            	//debug($comment_id);
            	$comment_id = $comment_id[0]['max_id']+1;
            	$this->request->data['Comment']['id'] = $comment_id;
                $this->request->data['Comment']['event_id'] = $id;
                $this->request->data['Comment']['inserted'] = date('Y-m-d H:i:s');
            }
			if ($this->Event->Comment->save($this->request->data)) {
				$this->Session->setFlash(__('コメントの投稿に成功しました。'));
				//return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('コメントの投稿に失敗しました。もう一度お試しください。'));
			}
		}
		//$this->Event->recursive = 3;
		$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
		//debug($this->Event->find('first', $options));
		$event = $this->Event->find('first', $options);
		$this->set('event', $event);
		$user_id_names = array();
		$users = $this->Event->User->find('all');
		foreach ($users as $user) {
			$user_id_names[$user['User']['id']] = $user['User']['username'];
		}
		//debug($user_id_names);
		$this->set('comment_user',$user_id_names);

		$user = $this->Auth->user();
		$willgo = $this->Event->EventsUser->find('first', array(
	    	'conditions' => array('user_id' => $user['id'],'event_id' => $id)
	    	));
		$willgo = !empty($willgo);
		if($willgo)
		{
			$this->set('willgo', 'いくよ！を取り消す');
			$this->set('willgo_message', 'このイベントの「いくよ！」を取り消しますか？');
		}
		else
		{
			$this->set('willgo', 'いくよ！');
			$this->set('willgo_message', 'このイベントを「いくよ！」に登録しますか？');
		}
		$willgo_count = $this->Event->EventsUser->find('all', array(
	    	'conditions' => array('event_id' => $id)
	    	));
		$willgo_count = count($willgo_count);
		$this->set('willgo_count', $willgo_count);
		$this->set('title_for_layout', $event['Event']['title'].'の詳細｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}

/**
 * add method
 *
 * @return void
 */
	public function add() {
		//debug($this->Event->find('first'));
		if ($this->request->is('post')) {
			$this->Event->create();

			//出演アーティストのパース
            if(!empty($this->request->data['Artist']['name'])){
                $this->request->data['Artist']['Artist'] = $this->Event->Artist->parseNames(null, $this->data['Artist']['name']);
            }

			/*$name = $this->request->data['Artist']['name'];
			$this->request->data['Artist'] = $this->Event->Artist->findByName($name);*/
			if(!empty($this->request->data['Comment']['comment'])){
                $this->request->data['Comment']['comment'] = $this->request->data['Comment']['comment'];
            }
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('イベントの登録に成功しました。'));
				return $this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('イベントの登録に失敗しました。もう一度お試しください。'));
			}
		}
		else{
			$this->set('title_for_layout', 'イベントを新規登録｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		}
	}

/**
 * edit method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function edit($id = null) {
		if (!$this->Event->exists($id)) {
			throw new NotFoundException(__('登録されていないイベント'));
		}
		if ($this->request->is(array('post', 'put'))) {
			//出演アーティストのパース
            if(!empty($this->request->data['Artist']['name'])){
                $this->request->data['Artist']['Artist'] = $this->Event->Artist->parseNames($id, $this->data['Artist']['name']);
            }
			if ($this->Event->save($this->request->data)) {
				$this->Session->setFlash(__('イベントの編集に成功しました。'));
				return $this->redirect(array('action' => 'view', $this->request->data['Event']['id']));
			} else {
				$this->Session->setFlash(__('イベントの編集に失敗しました。もう一度お試しください。'));
			}
		} else {
			$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$event = $this->Event->find('first', $options);

			$this->set('event', $event);
			$this->request->data = $event;

			//debug($event);

			$this->set('title_for_layout', $event['Event']['title'].'を編集｜LiveDiver｜もっとライブに行きたくなる情報ポータル');

            //ネームの取得
			if(count($this->request->data['Artist'])){
                $artists = '';
                foreach ($this->request->data['Artist'] as $name) {//一行ずつ取り出す
                    $artists .= $name['name']."\n";
                }
                $this->request->data['Artist']['name'] = substr($artists, 0 ,-1);//最後のカンマを取り除いてViewにデータを投げる
            }
		}
	}

/**
 * delete method
 *
 * @throws NotFoundException
 * @param string $id
 * @return void
 */
	public function delete($id = null) {
		$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('登録されていないイベント'));
		}
		if ($this->request->is(array('post', 'put'))) {
			/*$this->request->onlyAllow('post', 'delete');
			if ($this->Event->delete()) {
				$this->Session->setFlash(__('イベントの削除に成功しました。'));
			} else {
				$this->Session->setFlash(__('イベントの削除に失敗しました。もう一度お試しください。'));
			}*/
			$body = <<<EOF
イベント削除申請

ID:{$this->request->data['EventDelete']['id']}
タイトル:{$this->request->data['EventDelete']['title']}
申請理由:{$this->request->data['EventDelete']['reason']}
EOF;
			/*if (parent::_sendNewAdminMail($body)) {
				$this->Session->setFlash(__('イベントの削除申請に成功しました。'));
			} else {
				$this->Session->setFlash(__('イベントの削除申請に失敗しました。もう一度お試しください。'));
				var_dump(parent::_sendNewAdminMail($body));
			}*/
			parent::_sendNewAdminMail($body);
			$this->Session->setFlash(__('イベントの削除申請に成功しました。'));
			$this->redirect(array('action' => 'index'));
		}
		else
		{	$options = array('conditions' => array('Event.' . $this->Event->primaryKey => $id));
			$event = $this->Event->find('first', $options);
			$this->set('event', $event);
			$this->set('title_for_layout', $event['Event']['title'].'の削除申請｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
		}
	}

	public function name($name = null) {
        $names = array();
        App::uses('Sanitize', 'Utility');
        $this->Sanitize = new Sanitize;

        if(isset($this->params['pass'])){

            foreach($this->params['pass'] as $name):
                $this->Sanitize->paranoid($name, array(' '));
                $names[] = $name;
            endforeach;

        }
        $today = date('Y-m-d');
        $paging['url'] = '/events/name'. implode('/', $names);
        $paging['total'] = $this->Event->findCountByNames($names, " Event.date >= '$today'");
        if($paging['total'] > 0){
            $events = $this->Event->findAllByNames($names, 50, 1, " Event.date >= '$today'");

            /*$this->set('events',$this->Event->findAllByNames($names));
            $this->render('index');*/

            return $events;
        }
        else {
            //出演イベントが見つからない場合の処理
            $events = array();
            return $events;
        }
    }

    public function willgo($id = null, $user_id = null) {
    	$this->Event->id = $id;
		if (!$this->Event->exists()) {
			throw new NotFoundException(__('登録されていないイベント'));
		}
		$this->request->onlyAllow('post');

		$willgo = $this->Event->EventsUser->find('first', array(
			'conditions' => array('user_id' => $user_id, 'event_id' => $id)
		));
		if(!empty($willgo))
		{
			//debug($willgo);
			$this->Event->EventsUser->delete($willgo['EventsUser']['id']);
			$this->Session->setFlash(__('このイベントの「いくよ！」を取り消しました。'));
		}
		else
		{
			$this->request->data['user_id'] = $user_id;
			$this->request->data['event_id'] = $id;

			if ($this->Event->EventsUser->save($this->request->data)) {
				$this->Session->setFlash(__('このイベントを「いくよ！」に登録しました。'));
			} else {
				$this->Session->setFlash(__('このイベントを「いくよ！」に登録し出来ませんでした。もう一度お試しください。'));
			}
		}
		return $this->redirect(array('action' => 'view',$id));
    }

}
