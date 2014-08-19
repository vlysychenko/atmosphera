<?php
class AboutForm extends CFormModel
{
    public $content;
    
    public function rules()
    {
        return array(
            array('content','safe'),
        );
    }
    
    public function attributeLabels()
    {
        return array(
            'content' => Yii::t('main', 'Content'),
        );
    }
}
?>
