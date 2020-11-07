<?php
App::uses('AppController', 'Controller');
/**
 * ArtistsEvents Controller
 *
 * @property ArtistsEvent $ArtistsEvent
 * @property PaginatorComponent $Paginator
 */
class ArtistsEventsController extends AppController
{

	/**
	 * Components
	 *
	 * @var array
	 */
	public $components = array('Paginator');

	/**
	 * index method
	 *
	 * @return void
	 */
	public function index()
	{
		$this->redirect(array('controller' => 'events', 'action' => 'index'));
	}
}
