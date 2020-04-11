<?php
App::uses('AppController', 'Controller');

class LicensesController extends AppController
{

	//ログイン後にリダイレクトされるアクション
	public function index()
	{
		$this->set('title_for_layout', '利用規約｜LiveDiver｜もっとライブに行きたくなる情報ポータル');
	}
}
