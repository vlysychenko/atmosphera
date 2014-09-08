<?php

/**
 * This is the model class for table "gallery".
 *
 * The followings are the available columns in table 'gallery':
 * @property string $gallery_id
 * @property string $title
 * @property string $description
 * @property integer $is_active
 *
 * The followings are the available model relations:
 * @property Photo[] $photos
 */
class Portfolio extends CActiveRecord
{
    public $gallery_type;
    public $deletedPhotos = array(); //array of photos to be deleted
    public $title = 'System Default';
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'gallery';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			//array('title', 'required'),
			array('is_active', 'numerical', 'integerOnly'=>true),
            //array('title', 'required', 'message'=>'Необходимо заполнить поле Заголовок Галереи'),            
            array('title', 'length', 'max'=>Yii::app()->params['lengthGalleryTitle']),
			array('description', 'length', 'max'=>Yii::app()->params['lengthGalleryDescription']),
			array('title, description, gallery_type, is_active', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('gallery_id, title, description, is_active', 'safe', 'on'=>'search'),
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
			'photos' => array(self::HAS_MANY, 'Photo', 'gallery_id'),
            'photoCount' => array(self::STAT, 'Photo', 'gallery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'gallery_id' => Yii::t('main', 'Portfolio'),
			'title' => Yii::t('main', 'Title'),
			'description' => Yii::t('main', 'Description'),
			'is_active' => Yii::t('main', 'Show under article'),
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

		$criteria->compare('gallery_id',$this->gallery_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Gallery the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    //behaviors
    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
             'deletable' => array(
                 'class' => 'common.extensions.behaviors.DeletableBehavior',
                 'relations' => array(
                     'photos' => DeletableBehavior::CASCADE,
                 )
             )
        ));
    }    
    
    public function savePortfolio()
    {
        //save gallery object (with photos) 
        if ($isOK = $this->save() && isset($this->photos))   //save gallery
        { 
            //if exists deleted questions - process its
            foreach($this->deletedPhotos as $photo)
                //if(!$isOK = $photo->delete())                  //delete record from table
                if(!$isOK = $photo->batchDelete(array($photo->photo_id)))                  //delete record from table
                    break;
            //save photos in gallery
            foreach ($this->photos as $idx=>$photo) {
                $photo->gallery_id = $this->gallery_id;
                $isOK = $photo->save();                     //save photo
                if (!$isOK) break;
            }
        }
        return $isOK;
    }

    //get main (is_top) photo of gallery
    public function getMainPhoto(){
        $criteria = New CDbCriteria;
        $criteria->addCondition('is_top = 1')->addCondition('gallery_id = :gallery_id')->params = array(':gallery_id'=>$this->gallery_id);
        return Photo::model()->find($criteria);
    }    
    
    public static function getGallery($id){
        return (!empty($id) ? Gallery::model()->with('photos')->findByPk($id) : New Gallery) ;
    }
    
}
