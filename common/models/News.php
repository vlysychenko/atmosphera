<?php

/**
 * This is the model class for table "news".
 *
 * The followings are the available columns in table 'news':
 * @property string $post_id
 * @property string $anounce
 * @property string $content
 * @property string $publication_date
 * @property integer $is_top
 * @property integer $is_slider
 * @property string $user_id
 *
 * The followings are the available model relations:
 * @property Posting $post
 * @property Users $user
 */
Yii::import('backend.modules.user.models.User');
 
class News extends CActiveRecord
{
    const SWITCH_ON  = 1;
    const SWITCH_OFF = 0;
  //local vars
	private $_postTitle = '';                //related field 'posting.title'
    private $_postAuthor = '';               //related field 'posting.author' (via user_id)
    private $_transaction;                   //for local transaction

  //getters /  setters
    public function getPostTitle() {
       return $this->_postTitle;
    }
    public function setPostTitle($value) {
      $this->_postTitle = (string) $value;
    }
    public function getPostAuthor() {
       return $this->_postAuthor;
    }
    public function setPostAuthor($value) {
      $this->_postAuthor = (string) $value;
    }
    
    /**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'news';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('anounce, publication_date, user_id', 'required'),
			array('is_top, is_slider', 'numerical', 'integerOnly'=>true),
			array('user_id', 'length', 'max'=>11),
            array('publication_date', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
			array('content', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('post_id, anounce, publication_date, is_top, is_slider, user_id', 'safe', 'on'=>'search'),  
            //array('content', 'safe', 'on'=>'search'),  
            array('postTitle, postAuthor', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'post' => array(self::BELONGS_TO, 'Posting', 'post_id'),
			'author' => array(self::BELONGS_TO, 'User', 'user_id'),
		);
	}

    
    //function before delete news record
    public function beforeDelete() {//DebugBreak();
        $db = $this->getDbConnection();
        if ($db->getCurrentTransaction() === null) {         //if do not exists current...
            $this->_transaction = $db->beginTransaction();   // ... start new transaction
        }
        return parent::beforeDelete(); //run parent event handler... IT MUST BE!!!
    }
    
    //function after delete news record
    public function afterDelete() {
        parent::afterDelete();  //run parent event handler... 
        if ($post = Posting::model()->findByPk($this->post_id)) {
            $success = $post->delete(); //delete posting record
        }
        if (is_object($this->_transaction))
            $this->_transaction->commit();
    }
    
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => Yii::t('main', 'ID'),
			'anounce' => Yii::t('main', 'Announce'),
			'content' => Yii::t('main', 'Content'),
			'publication_date' => Yii::t('main', 'Publication date'),
			'is_top' => Yii::t('main', 'Is top'),
			'is_slider' => Yii::t('main', 'Is slider'),
			'user_id' => Yii::t('main', 'User'),
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;
        
		$criteria->compare('t.post_id',$this->post_id,true);
		$criteria->compare('t.anounce',$this->anounce,true);
		//if (get_class($this) == 'News')
        //    $criteria->compare('t.content',$this->content,true);
		$criteria->compare('t.publication_date',$this->publication_date,true);
		$criteria->compare('t.user_id',$this->user_id,true);

        $criteria->with = array('post', 'author');
        if (isset($this->postTitle)) {
            $criteria->compare('post.title', $this->postTitle, true);
        }
        if (isset($this->postAuthor)) {
            $criteria->compare('author.email', $this->postAuthor, true);
        }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return News the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    /**
    * defaultScope for News selecting
    * 
    */
    public function defaultScope() {
        return array(
            'order'=>'publication_date DESC',
        );
    }

}
