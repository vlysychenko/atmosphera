<?php

/**
 * This is the model class for table "partners".
 *
 * The followings are the available columns in table 'partners':
 * @property string $partner_id
 * @property string $title
 * @property string $description
 * @property string $contacts
 * @property integer $is_active
 */
class Partners extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return Partners the static model class
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
		return 'partners';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, is_active', 'required'),
			array('is_active, order_nr', 'numerical', 'integerOnly'=>true),
//            array('order_nr', 'unique'),
//            array('order_nr', 'numerical', 'min'=>1),
			array('title', 'length', 'max'=>255),
			array('description, contacts', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('partner_id, title, description, contacts, is_active, order_nr', 'safe', 'on'=>'search'),
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
			'partner_id' => Yii::t('main', 'Partner'),
			'title' => Yii::t('main', 'Title'),
			'description' => Yii::t('main', 'Description'),
			'contacts' => Yii::t('main', 'Contacts'),
			'is_active' => Yii::t('main', 'Is Active'),
            'order_nr' => Yii::t('main', 'Show Order'),
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

		$criteria->compare('partner_id',$this->partner_id,true);
		$criteria->compare('title',$this->title,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('contacts',$this->contacts,true);
//		$criteria->compare('is_active',$this->is_active);

        $criteria->addCondition(sprintf('partner_id<>%d',  Yii::app()->params['partner_id']));

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    //activate / deactivate project
    public static function activation($id, $onoff){
        $model = self::model()->findByPk($id);
        $model->is_active = $onoff ? 1 : 0;
        $model->save(false);
    }
    
    public function savePartners(&$galleries){
        $isErrorsPartners = false;
        $isErrorsPortfolio = false;     
        $isGalSaved = false;
        $isParSaved = false;
        
        $isErrorsPartners = !$this->validate();
        $isErrorsPortfolio = PhotoPortfolioWidget::checkForErrors($galleries);
        
        if(!$isErrorsPortfolio && !$isErrorsPartners){
            $transaction = Yii::app()->db->beginTransaction();
            
            //saving portfolio
            if(is_array($galleries)){
                foreach($galleries as &$portfolio){
                    if(count($portfolio->photos) != 2){
                        $portfolio->addError('count_photos', Yii::t('main', 'Minimum number of photos is 2'));
                        $transaction->rollback();
                        return false;
                    }
                    $isGalSaved = $portfolio->savePortfolio();
                    break;
                }
                $this->gallery_id = $portfolio->gallery_id;
                $isParSaved = $this->save(false);
            }
            
            if($isGalSaved && $isParSaved){
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
    
    public function deletePartners(){
        $this->delete();
        return true;
    }
}