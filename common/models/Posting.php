<?php

/**
 * This is the model class for table "posting".
 *
 * The followings are the available columns in table 'posting':
 * @property string $post_id
 * @property string $title
 * @property string $description
 * @property integer $post_type
 * @property string $created_date
 * @property integer $is_active
 * @property string $gallery_id
 *
 * The followings are the available model relations:
 * @property News $news
 * @property Gallery $gallery
 */
class Posting extends CActiveRecord
{
    const SWITCH_ON  = 1;
    const SWITCH_OFF = 0;
    const POST_TYPE_UNKNOWN   = 0;
    const POST_TYPE_NEWS      = 1;
    const POST_TYPE_GALLERY   = 2;
    const POST_TYPE_HOROSCOPE = 3;

    private $batchGalleryIds = array();
    private $savedGalleryId;
     
    public $postedTags = array();
    public $deletedTags = array();
    public $publication_date;
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'posting';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
    public static function typePosts() {
        return array(
            array('id' => self::POST_TYPE_NEWS, 'post_type' => Yii::t('main','News')),
            array('id' => self::POST_TYPE_GALLERY, 'post_type' => Yii::t('main','Gallery')),
        );
    }

	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('created_date', 'default', 'value'=>CTimestamp::formatDate('Y-m-d H:i:s')), 
            array('post_type', 'default', 'value'=>self::POST_TYPE_UNKNOWN), 
            array('gallery_id', 'default', 'value'=>4), 
            array('title, post_type, created_date, gallery_id', 'required'),
			array('post_type, is_active', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('gallery_id', 'length', 'max'=>11),
			array('post_id,title, description, tagList', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('post_id, title, description, post_type, created_date, is_active, gallery_id', 'safe', 'on'=>'search'),
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
			'news' => array(self::HAS_ONE, 'News', 'post_id'),
			'gallery' => array(self::BELONGS_TO, 'Gallery', 'gallery_id'),
			'galleryposts' => array(self::HAS_ONE, 'GalleryPosts', 'post_id'),
            //'relgallery' => array(self::HAS_ONE, 'Gallery', 'gallery_id'),
            'tags' => array(self::MANY_MANY, 'Tag', 'tagpost(post_id, tag_id)'),
            'tagposts'=>array(self::HAS_MANY, 'Tagpost', 'post_id'),
		);
	}

    //behaviors
    /*public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
             'deletable' => array(
                 'class' => 'common.extensions.behaviors.DeletableBehavior',
                 'relations' => array(
                     'tagposts' => DeletableBehavior::CASCADE,
                     //'gallery' => DeletableBehavior::CASCADE,
                     //'news' => DeletableBehavior::CASCADE,
                 )
             )
        )); 
    }  */
    
    //function before delete posting record
    public function beforeDelete() {//DebugBreak();
        $tagposts = Tagpost::model()->findAll('post_id = :post_id', array(':post_id'=>$this->post_id));
        if (!empty($tagposts))
            foreach($tagposts as $tagpost)   //delete all tags relations
                $tagpost->delete();
        return parent::beforeDelete(); //run parent event handler... IT MUST BE!!!
    }

    //function after delete posting record
    public function afterDelete() {//DebugBreak();
        Gallery::model()->batchDelete(array($this->gallery_id));   //deleting via DeletableBehavior
        return parent::afterDelete();  //run parent event handler
    }
      
	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => Yii::t('main', 'ID'),
			'title' => Yii::t('main', 'Title'),
			'description' => Yii::t('main', 'Description'),
			'post_type' => Yii::t('main', 'Post Type'),
			'created_date' => Yii::t('main', 'Created Date'),
			'is_active' => Yii::t('main', 'Is Active'),
			'gallery_id' => Yii::t('main', 'Gallery'),
            'tagList' => Yii::t('main', 'Tag List'),
            'gallery' => Yii::t('main', 'Gallery'),
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

		$criteria->compare('post_id',$this->post_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('post_type',$this->post_type);
		$criteria->compare('created_date',$this->created_date,true);
		$criteria->compare('is_active',$this->is_active);
		$criteria->compare('gallery_id',$this->gallery_id,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Posting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
  //action for activate / deactivate
    public static function setPostParam($id, $paramName, $paramValue){//DebugBreak();
        $transaction = Yii::app()->db->beginTransaction();
        try {       
           $posts = Posting::model()->findByPk($id);
           $posts->$paramName = $paramValue ? self::SWITCH_ON : self::SWITCH_OFF;
           $posts->save(true, array($paramName));
           $transaction->commit();           
        }
        catch(Exception $e){
            $transaction->rollback();
        }
    }
    
    //functions for tags
    public function prepareTagList($separator) {
        $tagsList = array();

        foreach($this->tags as $tag) {
            if(!is_object($tag))
                $tag = Tag::model()->findByPk($tag);
           $tagsList[] =  trim($tag->title);
        }
        natcasesort($tagsList);
        return join("$separator", $tagsList);
    }

    public function getTagList() {

        $arr = $this->prepareTagList(', ');
        return $arr;
    }

    public function getListKeywords() {

        $tagsList = $this->prepareTagList(' ');
        return $tagsList;
    }

    public function setTagList($tags) {
        $tagsIdToAssign = array();
        $aTags = explode(',', $tags);
        foreach($aTags as $tagName) { //search input tagsin DB
            $tagName = trim($tagName);
            if(!strlen($tagName))
                continue;
            $tag = Tag::model()->find('title = :title', array(':title'=>$tagName));
            if(!is_object($tag) && strlen($tagName)) {
                $tag = new Tag;            //add it 
                $tag->title = $tagName;    //if not exists
                $tag->save();
            }
           if($tag->tag_id) $tagsIdToAssign[] = $tag->tag_id;
        }
        $this->postedTags = $tagsIdToAssign;   //id's of tags in DB
        $this->tagList = $tags;                //comma separated text
    }
    
}
