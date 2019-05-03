<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
 *
 * @link          https://cakephp.org CakePHP(tm) Project
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		https://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {
	public $components = array('Auth','Session','Email');

	public function beforeFilter(){
		$this->Auth->allow();
		$this->set('user', $this->Auth->user());
		$this->layout = 'bootstrap';
	}

	function _sendNewAdminMail($body) {
	    $this->Email->from    = 'LiveDiver <info@livediver.net>';
		$this->Email->to      = 'CATCH THE BEAT <info@catch-the-beat.com>';
		$this->Email->subject = '削除申請';
		$this->Email->send($body);
	}
}
