<?php

/**
 * This is the model class for table "banners".
 *
 * The followings are the available columns in table 'banners':
 * @property string $banner_id
 * @property string $title
 * @property string $link
 * @property string $gallery_id
 * @property integer $is_active
 *
 * The followings are the available model relations:
 * @property Portfolio $portfolio
 */
class Banners extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Banners the static model class
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
		return 'banners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
            array('title, link', 'required'),
			array('link', 'url'),
			array('is_active', 'numerical', 'integerOnly'=>true),
			array('title', 'length', 'max'=>255),
			array('gallery_id', 'length', 'max'=>11),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('banner_id, title, link, gallery_id, is_active', 'safe', 'on'=>'search'),
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
			'banner_id' => Yii::t('main', 'Banner'),
			'title' => Yii::t('main', 'Title'),
			'link' => Yii::t('main', 'Link'),
			'gallery_id' => Yii::t('main', 'Portfolio'),
			'is_active' => Yii::t('main', 'Is Active'),
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

		$criteria->compare('banner_id',$this->banner_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('link',$this->link,true);
		$criteria->compare('gallery_id',$this->gallery_id,true);
//		$criteria->compare('is_active',$this->is_active);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    public function saveBanners(&$galleries){
        $isErrorsBanners = false;
        $isErrorsPortfolio = false;        
        $isGalSaved = false;
        $isBanSaved = false;
        
        $isErrorsBanners = !$this->validate();
        $isErrorsPortfolio = PhotoPortfolioWidget::checkForErrors($galleries);
        
        if(!$isErrorsPortfolio && !$isErrorsBanners){
            $transaction = Yii::app()->db->beginTransaction();
            
            //saving portfolio
            if(is_array($galleries)){
                foreach($galleries as $portfolio){
                    $isGalSaved = $portfolio->savePortfolio();
                    break;
                }
                $this->gallery_id = $portfolio->gallery_id;
                $isBanSaved = $this->save(false);
            }
            
            if($isGalSaved && $isBanSaved){
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
    
    //activate / deactivate 
    public static function activation($id, $onoff){
        $model = self::model()->findByPk($id);
        $model->is_active = $onoff ? 1 : 0;
        $model->save(false);
    }
    
    public function deleteBanners(){
        $this->delete();
        return true;
    }
}