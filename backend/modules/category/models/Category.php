<?php

/**
 * This is the model class for table "category".
 *
 * The followings are the available columns in table 'category':
 * @property integer $category_id
 * @property string $name
 *
 * The followings are the available model relations:
 * @property News[] $news
 */
class Category extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Category the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'category';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name', 'required'),
			array('name', 'length', 'max'=>50),
                        array('name', 'unique', 'message' =>Yii::t('main', 'This category already exists')),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('category_id, name', 'safe', 'on'=>'search'),
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
			'news' => array(self::HAS_MANY, 'News', 'category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'category_id' => 'Category',
			'name' => 'Name',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('category_id',$this->category_id);
		$criteria->compare('name',$this->name,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
         public function deleteCategory(){
        $this->delete();
        return true;
    }
}
