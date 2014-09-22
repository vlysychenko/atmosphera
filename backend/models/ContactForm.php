<?php
class ContactForm extends CFormModel
{

    public $twitter;
    public $vk;
    public $odnokl;
    public $facebook;

    public function rules()
    {
        return array(
//            array('facebook, odnokl,vk, twitter', 'url'),
            array('facebook, twitter, vk, odnokl','safe'),
        );
    }

    public function attributeLabels()
    {
        return array(
            'twitter' => Yii::t('main','Link for Twitter'),
            'vk' => Yii::t('main','Link for VK'),
            'facebook' => Yii::t('main','Link for Facebook'),
            'odnokl' => Yii::t('main','Link for Odnoklassniki'),
        );
    }
}
?>