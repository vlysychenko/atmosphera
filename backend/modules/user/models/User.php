<?php

class User extends CActiveRecord
{
	const STATUS_NOACTIVE = 0;
	const STATUS_ACTIVE = 1;
	const STATUS_BANED = 2;
    
    const SUPERUSER_OFF = 0;
    const SUPERUSER_ON = 1;
	
	/**
	 * The followings are the available columns in table 'users':
	 * @property integer $user_id
	 * @var string $password
	 * @property string $email
	 * @var string $activkey
	 * @var integer $createtime
	 * @property varchar $lastvisit
	 * @property varchar $superuser
	 * @var integer $status
	 */

    public $newPassword;
    public $verifyPassword;
     
	/**
	 * Returns the static model of the specified AR class.
	 * @return CActiveRecord the static model class
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
		//return Yii::app()->getModule('user')->tableUsers;
        return 'users';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		
		return ((UserModule::isAdmin()) ? array(
            array('createtime', 'default', 'value'=>time()),//CTimestamp::formatDate('Y-m-d H:i:s')), 
            array('lastvisit', 'default', 'value'=>time()),//CTimestamp::formatDate('Y-m-d H:i:s')), 
            array('superuser', 'default', 'value'=>self::SUPERUSER_OFF),
			array('password', 'length', 'max'=>128, 'min' => 4,'message' => UserModule::t("Incorrect password (minimal length 4 symbols).")),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('email', 'email'),
			array('status', 'in', 'range'=>array(self::STATUS_NOACTIVE, self::STATUS_ACTIVE)),
			array('superuser', 'in', 'range'=>array(0, 1)),
			//array('email, createtime, lastvisit, superuser, status', 'required'),
            array('email, superuser, status', 'required'),
			//array('createtime, lastvisit, superuser, status', 'numerical', 'integerOnly'=>true),
            array('newPassword, verifyPassword, lastname, firstname', 'required'),
            array('verifyPassword', 'compare', 'compareAttribute'=>'newPassword', 'message' => UserModule::t("Retype Password is incorrect.")),
            array('user_id, email, firstname, lastname','safe', 'on'=>'search'),
            array('user_id, email, firstname, lastname','safe')
		):((Yii::app()->user->id==$this->user_id)?array(
			array('email, password', 'required'),
            array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
			array('email', 'email'),
			array('email', 'unique', 'message' => UserModule::t("This user's email address already exists.")),
            array('user_id, email, firstname, lastname','safe', 'on'=>'search'),
            array('user_id, email, firstname, lastname','safe')
		):array()));
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		$relations = array(
			'profile'=>array(self::HAS_ONE, 'Profile', 'user_id'),
		);
		if (isset(Yii::app()->getModule('user')->relations)) $relations = array_merge($relations,Yii::app()->getModule('user')->relations);
		return $relations;
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			//'username'=>UserModule::t("username"),
			'password'=>Yii::t('main',"password"),
			'verifyPassword'=>Yii::t('main',"Retype Password"),
			'email'=>Yii::t('main',"E-mail"),
			'verifyCode'=>Yii::t('main',"Verification Code"),
			'user_id' => Yii::t('main',"Id"),
			'activkey' => Yii::t('main',"activation key"),
			'createtime' => Yii::t('main',"Registration date"),
			'lastvisit' => Yii::t('main',"Last visit"),
			'superuser' => Yii::t('main',"Superuser"),
			'status' => Yii::t('main',"Status"),
            'lastname'=>Yii::t('main','Lastname'),
            'firstname'=>Yii::t('main','Firstname'),
            'newPassword'=>Yii::t('main','New Password'),
		);
	}
	
	public function scopes()
    {
        return array(
            'active'=>array(
                'condition'=>'status='.self::STATUS_ACTIVE,
            ),
            'notactvie'=>array(
                'condition'=>'status='.self::STATUS_NOACTIVE,
            ),
            'banned'=>array(
                'condition'=>'status='.self::STATUS_BANED,
            ),
            'superuser'=>array(
                'condition'=>'superuser=1',
            ),
            'notsafe'=>array(
            	'select' => 'user_id, firstname, lastname, password, email, activkey, createtime, lastvisit, superuser, status',
            ),
        );
    }
	
	public function defaultScope()
    {
        return array(
            'select' => 'user_id, firstname, lastname, email, createtime, lastvisit, superuser, status',
        );
    }
	
	public static function itemAlias($type,$code=NULL) {
		$_items = array(
			'UserStatus' => array(
				self::STATUS_NOACTIVE => Yii::t('main','Not active'),
				self::STATUS_ACTIVE => Yii::t('main','Active'),
				self::STATUS_BANED => Yii::t('main','Banned'),
			),
			'AdminStatus' => array(
				'0' => Yii::t('main','No'),
				'1' => Yii::t('main','Yes'),
			),
		);
		if (isset($code))
			return isset($_items[$type][$code]) ? $_items[$type][$code] : false;
		else
			return isset($_items[$type]) ? $_items[$type] : false;
	}

    public function search()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria=new CDbCriteria;

        $criteria->compare('user_id',$this->user_id,true);
        $criteria->compare('email',$this->email,true);
        $criteria->compare('lastname',$this->lastname,true);
        $criteria->compare('firstname',$this->firstname,true);

        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}