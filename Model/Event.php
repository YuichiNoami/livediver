<?php
App::uses('AppModel', 'Model');
/**
 * Event Model
 *
 * @property ActData $EventAct
 */
class Event extends AppModel {

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
	public $displayField = 'title';

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
		'title' => array(
			'notEmpty' => array(
				'rule' => array('notEmpty'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'date' => array(
			'date' => array(
				'rule' => array('date'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'open' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'start' => array(
			'time' => array(
				'rule' => array('time'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'adv_price' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'door_price' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'place' => array(
			'notEmpty' => array(
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
	public $hasMany = array(
		'Comment' =>
			array(
				'className' => 'Comment',
				'foreignKey' => 'event_id',
				),
		);

	public $hasAndBelongsToMany = array(
        'Artist' =>
            array(
                'className'              => 'Artist',
                'joinTable'              => 'artists_events',
                'foreignKey'             => 'event_id',
                'associationForeignKey'  => 'artist_id',
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
            ),
         'User' =>
            array(
                'className'              => 'User',
                'joinTable'              => 'events_users',
                'foreignKey'             => 'event_id',
                'associationForeignKey'  => 'user_id',
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

	public function findCountByNames($names = array(), $criteria = null) {
        if(count($names) <= 0){
            return 0;
    }
        if(!empty($criteria)) {
            $criteria = 'AND'.$criteria;
        }
 
 		//$names = implode("', '", $names);
        $prefix = $this->tablePrefix;
        $sql = "SELECT COUNT('Event.id') AS count FROM
            	(SELECT Event.id, COUNT(DISTINCT artists.name) AS uniques
            	FROM {$prefix}events Event, {$prefix}artists_events artists_events, {$prefix}artists artists
            	WHERE Event.id = artists_events.Event_id
                AND artists.id = artists_events.artist_id
                AND artists.name IN (?) $criteria
            	GROUP BY artists_events.Event_id
            	HAVING uniques = ".count($names).") x";
        $count = $this->query($sql, $names, false);
 		
 		//return 1;
        return $count[0][0]['count'];
    }
 
    public function findAllByNames($names = array(), $limit = 50, $page = 1, $criteria = null){
        if(count($names) <= 0){
            return 0;
        }
        if(!empty($criteria)) {
            $criteria = 'AND'.$criteria;
        }
 
 		//$names = implode("', '", $names);
        $prefix = $this->tablePrefix;
        $offset = $limit * ($page-1);
        $sql = "SELECT
            Event.id,
            Event.title,
            Event.date,
            COUNT(DISTINCT artists.name) AS uniques
                    FROM
                    {$prefix}events Event,
                    {$prefix}artists_events artists_events,
                    {$prefix}artists artists
                    WHERE Event.id = artists_events.Event_id
                    AND artists.id = artists_events.artist_id
                    AND artists.name IN (?) $criteria
                    GROUP BY artists_events.Event_id
                    HAVING uniques = '".count($names)."'
                    ORDER BY Event.date ASC
                    LIMIT $offset, $limit";
        $events = $this->query($sql, $names, false);
 
 		//return $sql;
        return $events;
    }
}
