<?php

/**
 * This is the model class for table "magazine".
 *
 * The followings are the available columns in table 'magazine':
 * @property string $magazine_id
 * @property string $gallery_id
 * @property string $filename
 * @property integer $is_shown
 *
 * The followings are the available model relations:
 * @property Portfolio $portfolio
 */
class Magazine extends CActiveRecord
{   
    public static function getMonthName($numberOfMonth){
        if($numberOfMonth >= 1 && $numberOfMonth <= 12){
            $arrMonthNames = Yii::app()->locale->getMonthNames("wide", true);
            return $arrMonthNames[$numberOfMonth];
        }else{
            return false;
        }
    }
    
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'magazine';
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
            array('filename', 'required', 'message'=>Yii::t('main', 'Add file that contains magazine')),
			array('is_shown', 'numerical', 'integerOnly'=>true),
			array('gallery_id, publication_year, publication_month', 'length', 'max'=>11),
            array('filename, title', 'length', 'max'=>255),
			array('publication_year', 'ext.UniqueAttributesValidator', 'message'=>Yii::t('main', 'Magazine for month that you have specified is already taken'),  'with'=>'publication_month'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('magazine_id, gallery_id, filename, is_shown, title, publication_year, publication_month', 'safe', 'on'=>'search'),
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
            'magazine_id' => Yii::t('main', 'ID'),
            'title' => Yii::t('main', 'Title'),
            'publication_year' => Yii::t('main', 'Year'),
            'publication_month' => Yii::t('main', 'Month'),
			'gallery_id' => Yii::t('main', 'Portfolio'),
			'filename' => Yii::t('main', 'Filename'),
			'is_shown' => Yii::t('main', 'Shown'),
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

		$criteria->compare('magazine_id',$this->magazine_id,true);
		$criteria->compare('gallery_id',$this->gallery_id,true);
        $criteria->compare('filename',$this->filename,true);
        $criteria->compare('title',$this->title,true);
        $criteria->compare('publication_year',$this->publication_year);
		$criteria->compare('publication_month',$this->publication_month);
//		$criteria->compare('is_shown',$this->is_shown);
//        $criteria->order = 'publication_year DESC, publication_month DESC';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'sort'=>array(
                'defaultOrder'=>'publication_year DESC, publication_month DESC',
            )
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Magazine the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    //activate / deactivate project
    public static function activation($id, $onoff){
        $model = self::model()->findByPk($id);
        $model->is_shown = $onoff ? 1 : 0;
        $model->save(false);
    }
    
    /**
    * put your comment there...
    * 
    * @param mixed $galleries
    */
    public function saveMagazine(&$galleries){
        $isErrorsMagazine = false;
        $isErrorsPortfolio = false;        
        $isGalSaved = false;
        $isMagSaved = false;
        
        $isErrorsMagazine = !$this->validate();
        $isErrorsPortfolio = PhotoPortfolioWidget::checkForErrors($galleries);
        
        if(!$isErrorsPortfolio && !$isErrorsMagazine){
            $transaction = Yii::app()->db->beginTransaction();
            
            //saving portfolio
            if(is_array($galleries)){
                foreach($galleries as $portfolio){
                    $isGalSaved = $portfolio->savePortfolio();
                    break;
                }
                $this->gallery_id = $portfolio->gallery_id;
                $isMagSaved = $this->save(false);
            }
            
            if($isGalSaved && $isMagSaved){
                $transaction->commit();
                return true;
            }else{
                $transaction->rollback();
                return false;
            }
        }else{
            return false;
        }
    }
    
    public function deleteMagazine(){
        $this->delete();
        return true;
    }
}
