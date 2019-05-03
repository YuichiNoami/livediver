<?php
// Controller/TwitterController.php
class TwitterController extends AppController {
    
    var $components = array(
        'OAuth.OAuthConsumer',
        'Session'
    );
    
    public function index() {
        
        $requestToken = $this->OAuthConsumer->getRequestToken('Twitter', 'https://api.twitter.com/oauth/request_token', 'http://' . $_SERVER['HTTP_HOST'] . '/tweets/callback/');//callback url

        if ($requestToken) {
            $this->Session->write('twitter_request_token', $requestToken);
            $this->redirect('https://api.twitter.com/oauth/authorize?oauth_token=' . $requestToken->key);
        }
        
        $this->autoRender = false;
    }

    public function callback() {
        
        $requestToken = $this->Session->read('twitter_request_token');
        
        $accessToken = $this->OAuthConsumer->getAccessToken('Twitter', 'https://api.twitter.com/oauth/access_token', $requestToken);

        if ($accessToken) {
            $this->OAuthConsumer->post('Twitter', $accessToken->key, $accessToken->secret, 'https://api.twitter.com/1.1/statuses/update.json', array('status' => 'あけましておめでとうございます'));
            pr($this->OAuthConsumer);//バグってたらここの文字を読んでみる。
        }
        
        $this->autoRender = false;
        
    }

  

}