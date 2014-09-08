<?php

class PortfolioPosts extends News
{
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'galleryposts';
    }

    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('anounce, publication_date, user_id', 'required'),
            array('is_top', 'numerical', 'integerOnly'=>true),
            array('user_id', 'length', 'max'=>11),
            array('publication_date', 'date', 'format'=>'yyyy-MM-dd hh:mm:ss'),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('post_id, anounce, publication_date, is_top, user_id, category_id', 'safe', 'on'=>'search'),  
            array('postTitle,publication_date, postAuthor', 'safe', 'on'=>'search'),
        );
    }
    
    public static function model($className=__CLASS__)
    {
        return parent::model($className);
    }

    
}  
?>
