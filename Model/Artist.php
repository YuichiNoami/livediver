<?php
App::uses('AppModel', 'Model');
/**
 * Artist Model
 *
 */
class Artist extends AppModel {

    public $actsAs = array('Search.Searchable');
    public $filterArgs = array('name'=> array('type' => 'like'),);

/**
 * Use database config
 *
 * @var string
 */
	public $useDbConfig = 'default';

/**
 * Primary key field
 *
 * @var string
 */
	public $primaryKey = 'id';

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'name';

/**
 * Validation rules
 *
 * @var array
 */
	public $validate = array(
		'id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
			'notBlank' => array(
				'rule' => array('notBlank'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * hasAndBelongsToMany associations
 *
 * @var array
 */
	public $hasAndBelongsToMany = array(
        'Event' =>
            array(
                'className'              => 'Event',
                'joinTable'              => 'artists_events',
                'foreignKey'             => 'artist_id',
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
                'with'                   => 'ArtistsEvent'
            )
    );


	public function parseNames($eventId, $nameString) {

        $this->ArtistsEvent->deleteAll(array('event_id' => $eventId), false);

        $ids = array();
 
        $names = explode("\n",$nameString);
 
        foreach ($names as $name):
            if(!empty($name)){
                //DBからタグに対応する列を取得
                $name = trim($name, "\n\r"); //改行のみをtrimする
                $this->unbindModel(array('hasAndBelongsToMany' => array('Event')));
                $nameRow = $this->findByName($name);
                if(!empty($nameRow)){
                    //タグが登録済の処理
                    $actRow = $this->ArtistsEvent->findByEventIdAndArtistId($eventId, $nameRow['Artist']['id']);
                    if(in_array($nameRow['Artist']['id'], $ids) || !empty($actRow)){
                        continue;
                    }
                    $ids[] = $nameRow['Artist']['id'];
                }else {
                    $newName['Artist']['name'] = $name;
                    //$newName['Artist']['id'] = "";
                    $this->saveAll($newName);
                    $ids[] = $this->getLastInsertID();
                }
            }
 
        endforeach;
 
        return $ids;
    }
}
