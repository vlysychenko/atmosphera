<?php

/**
 * This is the model class for table "tag".
 *
 * The followings are the available columns in table 'tag':
 * @property string $tag_id
 * @property string $title
 *
 * The followings are the available model relations:
 * @property Tagpost[] $tagposts
 */
class Tag extends CActiveRecord
{
    public $post_count;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tag';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title', 'required'),
			array('title', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('tag_id, title', 'safe', 'on'=>'search'),
			array('tag_id, title', 'safe'),
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
			'tagposts' => array(self::HAS_MANY, 'Tagpost', 'tag_id'),
            'postings' => array(self::MANY_MANY, 'Posting', 'Tagpost(tag_id, post_id)'),
        );
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'tag_id' => 'Tag',
			'title' => Yii::t('main','Title'),
		);
	}

    public function scopes()
    {
        return array(
            'notsafe'=>array(
                'select' => 'tag_id,title',
            ),
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
        $criteria->together =true;
        $criteria->with = array('tagposts'=>array('joinType'=>'LEFT JOIN'));
        $criteria->select = 'tag.tag_id,tag.title,(COUNT(tagposts.post_id)) AS post_count';
        $criteria->group = 't.tag_id';

        $criteria->compare('tag_id',$this->tag_id,true);
        $criteria->compare('title',$this->title,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Tag the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

    public static function getTagTitle($tagId){
        $data = Tag::model()->findByPk($tagId);
        return $data->title;
    }

    public static function getListTag(){
        $criteria = new CDbCriteria;
        $criteria->order = 'title';
        $tags = Tag::model()->findAll($criteria);
        $tagslist = array();
        foreach($tags as $tag)
            $tagslist[$tag->tag_id] = $tag->title;
        return $tagslist;
    }
    
    /**
    * get list of all tags (for select2row)
    * 
    */
    public static function allTagsList() {
         $tags = Tag::model()->findAll(array('order' => 'title'));
         $tagslist = array();
         foreach($tags as $tag) 
            $tagslist[] = $tag->title;
         return $tagslist;
        }         
    
}
