<?php

class DefaultController extends PostController
{
    protected $_modelclass = 'Design';
    public $_maxTopCount = 4;

    //function for post_type definition
    protected function setPostType($model = null) {
        if (isset($model))
            $model->post_type = Posting::POST_TYPE_DESIGN;
    }

}