<?php

class CategoryForDesign extends CWidget
{
    private $category = array();

    public function init()
    {

        $allCategory = Category::model()->findAll();
        if($allCategory !== null){
            foreach($allCategory as $categ){
                $this->category[$categ->id] = $categ->category;
            };
        }

    }

    public function run()
    {
        $this->render('index', array('listCategories' => $this->category));
    }
}