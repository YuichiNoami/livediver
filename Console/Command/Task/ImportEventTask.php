<?php
class ImportEventTask extends Shell {
    // 使用するモデルを読み込む
    public $uses = array('Event', 'Artist', 'ArtistsEvent');

    /**
     * インポートの実行
     */
    public function execute() {
        $data = array(
            'Event' => array(
                'title' => 'インポートサンプル2',
                'date' => '2019-05-10',
                'open' => '16:00',
                'start' => '17:00',
                'adv_price' => 2500,
                'door_price' => 3000,
                'place' => 'テストホール',
            ),
            'Artist' => array(
                'name' => 'スーパーサンプルズ,ポルカドットスティングレイ',
            ),
        );

        $this->Event->create();

        //出演アーティストのパース
        if(!empty($data['Artist']['name'])){
            $data['Artist']['Artist'] = $this->parseNames($data['Artist']['name']);
        }

        if ($this->Event->save($data)) {
            echo "success to import event.\n";
        } else {
            echo "failure to import event, check again.\n";
        }
    }

    /**
     * 出演アーティストをパースする
     * 
     * @return array
     */
    private function parseNames($nameString) {
        $ids = array();
 
        $names = explode(",",$nameString);
 
        foreach ($names as $name) {
            if(!empty($name)){
                //DBからタグに対応する列を取得
                $name = trim($name, "\n\r"); //改行のみをtrimする
                $this->Artist->unbindModel(array('hasAndBelongsToMany' => array('Event')));
                $nameRow = $this->Artist->findByName($name);
                if(!empty($nameRow)){
                    //タグが登録済の処理
                    $actRow = $this->ArtistsEvent->findByEventIdAndArtistId(null, $nameRow['Artist']['id']);
                    if(in_array($nameRow['Artist']['id'], $ids) || !empty($actRow)){
                        continue;
                    }
                    $ids[] = $nameRow['Artist']['id'];
                }else {
                    $newName['Artist']['name'] = $name;
                    //$newName['Artist']['id'] = "";
                    $this->Artist->saveAll($newName);
                    $ids[] = $this->Artist->getLastInsertID();
                }
            }
        }
 
        return $ids;
    }
}