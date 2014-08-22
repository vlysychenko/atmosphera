<?php

/**
 * This is the model class for table "horoscope".
 *
 * The followings are the available columns in table 'horoscope':
 * @property string $post_id
 * @property string $content
 * @property string $publication_date
 *
 * The followings are the available model relations:
 * @property Posting $post
 */
class Horoscope extends CActiveRecord
{
    public $title;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'horoscope';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('post_id', 'required'),
			array('post_id', 'length', 'max'=>11),
			array('content, publication_date', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('post_id, content, publication_date', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'post_id' => Yii::t('main', "Zodiac's Signs"),
			'content' => Yii::t('main', 'Content'),
			'publication_date' => Yii::t('main', 'Publication').' '.Yii::t('main', 'Date'),
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


//		$criteria->compare('t.post_id',$this->post_id,true);
		$criteria->compare('t.content',$this->content,true);
		$criteria->compare('t.publication_date',$this->publication_date,true);
//        DebugBreak();
//        if(isset($_GET['Horoscope']['title'])){
//            $criteria->with = array('post');
//            $post = new Posting();
//            $this->post = $post;
//            
//            
////            if(isset($this->post->title))
//                $criteria->compare('post.title', $this->post->title,true);
//        }
		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
            'pagination'=>false,
            'sort'=>false,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Horoscope the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
    
    public function saveHoroscope(&$galleries){
        $isErrorsHoroscope = false;
        $isErrorsPost = false;
        $isErrorsPortfolio = false;        
        $isGalSaved = false;
        $isHorSaved = false;
        $isPostSaved = false;
        
        $isErrorsHoroscope = !$this->validate();
        $isErrorsPost = !$this->post->validate();
        $isErrorsPortfolio = PhotoPortfolioWidget::checkForErrors($galleries);
        
        if(!$isErrorsPortfolio && !$isErrorsHoroscope && !$isErrorsPost){
            $transaction = Yii::app()->db->beginTransaction();
            
            //saving portfolio
            if(is_array($galleries)){
                foreach($galleries as $portfolio){
                    $isGalSaved = $portfolio->savePortfolio();
                    break;
                }
                $this->post->gallery_id = $portfolio->gallery_id;
                $isPostSaved = $this->post->save(false);
                $isHorSaved = $this->save(false);
            }
            
            if($isGalSaved && $isHorSaved && $isPostSaved){
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
}
