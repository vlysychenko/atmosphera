<?php

/**
 * This is the model class for table "photo".
 *
 * The followings are the available columns in table 'photo':
 * @property string $photo_id
 * @property string $gallery_id
 * @property string $title
 * @property string $filename
 * @property string $thumb_filename
 * @property string $description
 * @property string $mime_type
 * @property integer $sort_order
 * @property integer $is_top
 *
 * The followings are the available model relations:
 * @property Portfolio $portfolio
 */
class Photo extends CActiveRecord
{
    const STATUS_ACTIVE   = 1;
    const STATUS_NOACTIVE = 0;
    const POSITION_IS_TOP = 1;
    const POSITION_NO_TOP = 0;
    
    public $file; //field for uploaded file
    
    private $_deletedFiles = array();
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'photo';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, filename, thumb_filename, description, mime_type', 'required'),
			array('sort_order, is_top', 'numerical', 'integerOnly'=>true),
			//array('gallery_id', 'length', 'max'=>11),
			array('title, filename, thumb_filename, description', 'length', 'max'=>Yii::app()->params['lengthPhotoTitle']),
            array('description', 'length', 'max'=>Yii::app()->params['lengthPhotoDescription']),
			array('mime_type', 'length', 'max'=>32),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('photo_id, gallery_id, title, filename, thumb_filename, description, mime_type, sort_order, is_top', 'safe', 'on'=>'search'),
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
			'portfolio' => array(self::BELONGS_TO, 'Portfolio', 'gallery_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'photo_id' => Yii::t('main', 'Photo'),
			'gallery_id' => Yii::t('main', 'Gallery'),
			'title' => Yii::t('main', 'Title'),
			'filename' => Yii::t('main', 'Filename'),
			'thumb_filename' => Yii::t('main', 'Thumb') . ' ' . Yii::t('main', 'Filename'),
			'description' => Yii::t('main', 'Description'),
			'mime_type' => Yii::t('main', 'Mime Type'),
			'sort_order' => Yii::t('main', 'Sort Order'),
			'is_top' => Yii::t('main', 'Is') . ' ' . Yii::t('main', 'top'),
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

		$criteria->compare('photo_id',$this->photo_id,true);
		$criteria->compare('gallery_id',$this->gallery_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('filename',$this->filename,true);
		$criteria->compare('thumb_filename',$this->thumb_filename,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('mime_type',$this->mime_type,true);
		$criteria->compare('sort_order',$this->sort_order);
		$criteria->compare('is_top',$this->is_top);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Photo the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function scopes()
    {
        return array(
            'sorting'=>array(
                'order'=>'sort_order ASC',
            ),
        );
    }    
    
    public function defaultScope() {
        $scopes = $this->scopes();
        return is_array($scopes) && isset($scopes['sorting']) ? $scopes['sorting'] : array();
    }

    //behaviors
    public function behaviors()
    {
        return CMap::mergeArray(parent::behaviors(), array(
             'deletable' => array(
                 //'class' => 'ext.deletable-behavior.DeletableBehavior',
                 'class' => 'common.extensions.behaviors.DeletableBehavior',
             )
        ));
    }    

    //function for uploaded file deleting: before delete
    public function beforeBatchDelete($event) {
        $this->_deletedFiles = array();
        $batchIds = $event->sender->getBatchIds();
        foreach($batchIds as $id) {
            $photo = Photo::model()->findByPk($id);
            $this->_deletedFiles[] = $photo->filename;
            $this->_deletedFiles[] = $photo->thumb_filename;
            $fileform = New PhotoFileForm;
            $this->_deletedFiles[] = $fileform->rawDir . DIRECTORY_SEPARATOR . $photo->filename;
            foreach($fileform->imageSizes as $imageSize) {
                $this->_deletedFiles[] = $imageSize['name'] . DIRECTORY_SEPARATOR . $photo->filename;
            }
        }
    }
    
    //function for uploaded file deleting: after delete
    public function afterBatchDelete($event) {
        $path = UrlHelper::getImageDir();
        foreach ($this->_deletedFiles as $filename) {
            if (file_exists($path . $filename))
                unlink($path . $filename);
        }
    }
    
}
