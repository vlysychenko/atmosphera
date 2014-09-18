<?php
/**
* Controller for News model
*/
class PostController extends BackendController
{
    protected $_modelclass;
    protected $_postType = 0;
    protected $_maxTopCount = 0;
    
    //base function for post_type definition
    protected function setPostType($model = null) {
        if (isset($model))
            $model->post_type = Posting::POST_TYPE_UNKNOWN;
    }
    
    //function for load (or create new) model
    public function loadModel($class, $id = null, $criteria = array(), $exceptionOnNull = true)
    {
        $model = isset($id) ? CActiveRecord::model($this->_modelclass)->findByPk($id) : New $this->_modelclass;
        if($model === null)
            throw new CHttpException(404, 'Запрашиваемая страница не существует! '.'Не найден объект с идентификатором: '.$id);
        return $model;
    }
    
    public function actionIndex()
    {
        $model = new $this->_modelclass('search');
        if(isset($_GET[$this->_modelclass])){
            $model->attributes = $_GET[$this->_modelclass];
        }
        $className = strtolower($this->_modelclass);

        if($className === 'portfolioposts'){
            $className = 'news';
        }
        $this->render('application.modules.'.$className.'.views.default.index', array('model' => $model));
    }
    
  //action for is_top
    public function actionSetstatus(){//DebugBreak();
        $id = Yii::app()->request->getParam('id');
        $is_active = Yii::app()->request->getParam('is_active');
        $is_top = Yii::app()->request->getParam('is_top');
        $is_slider = Yii::app()->request->getParam('is_slider');
        if (strlen($is_active))
            Posting::setPostParam($id, 'is_active', $is_active);
        else if (strlen($is_top))
            //News::setNewsParam($id, 'is_top', $is_top, 4);
            $this->setParam($id, 'is_top', $is_top, $this->_maxTopCount);
        else if (strlen($is_slider))
            //News::setNewsParam($id, 'is_slider', $is_slider, 4);
            $this->setParam($id, 'is_slider', $is_slider, 4);
        Yii::app()->end();
    }

    
    public function setParam($id, $paramName, $paramValue, $maxCount = 0) {//DebugBreak();
        $tablename = CActiveRecord::model($this->_modelclass)->tableName();
        $transaction = Yii::app()->db->beginTransaction();
        try {       
           if ($maxCount > 0 && $paramValue <> 0) { //if switch on
               Yii::app()->db->createCommand("UPDATE $tablename SET $paramName = $paramName + 1 WHERE $paramName > 0")->execute();
               Yii::app()->db->createCommand("UPDATE $tablename SET $paramName = 1 WHERE post_id = :post_id")->execute(array(':post_id'=>$id));
               Yii::app()->db->createCommand("UPDATE $tablename SET $paramName = 0 WHERE $paramName > $maxCount")->execute();
           } else {
               //get slider num for switched off item
               $slider_nr = Yii::app()->db->createCommand("SELECT $paramName FROM $tablename WHERE post_id = :post_id")->queryScalar(array(':post_id'=>$id));
               //switch off this item
               Yii::app()->db->createCommand("UPDATE $tablename SET $paramName = 0 WHERE post_id = :post_id")->execute(array(':post_id'=>$id));
               //decrease nr for less items
               if (isset($slider_nr))
                    Yii::app()->db->createCommand("UPDATE $tablename SET $paramName = $paramName - 1 WHERE $paramName > $slider_nr")->execute();
           }
           $transaction->commit();           
        }
        catch(Exception $e){
            $transaction->rollback();
        }
    }
    
    
    /**
    * action for delete
    * 
    */
    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest) {//DebugBreak();
            // we only allow deletion via POST request
            $id = Yii::app()->request->getParam('id');
            if ($model = CActiveRecord::model($this->_modelclass)->findByPk($id)) {
                //$success = $model->batchDelete(array($id));
                $success = $model->delete();
                if (!$success)
                    throw new CHttpException(400, 'Deleting of project is not success.');
            }
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!Yii::app()->request->isAjaxRequest)
                $this->redirect(array('index'));
        }
        else
            throw new CHttpException(400, 'Invalid request. Please do not repeat this request again.');
    }
    
    /**
    * action for create
    * 
    */
    public function actionCreate()
    {
        $this->actionUpdate();
    }    
    
    /**
    * action for update
    * 
    * @param mixed $id
    */
    public function actionUpdate($id = null)
    {
        Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
        
        $news = $this->loadModel($this->_modelclass, $id);
        $post = isset($news->post) ? $news->post : New Posting();
        if ($post->scenario == 'insert') {
            $this->setPostType($post);
            if (empty($news->publication_date)) {
                $news->publication_date = CTimestamp::formatDate('Y-m-d H:i:s');
            }
        }
        $portfolio = isset($news->post->portfolio) ? $news->post->portfolio : New Portfolio;
        $portfolio->gallery_type = 1;
        if(!empty($_POST[$this->_modelclass])){
            $post->attributes = $_POST['Posting'];  //set attributes
            $news->attributes = $_POST[$this->_modelclass];
            $posttitle = $post->title;  //save name of posting to buffer

            $portfolioWidget = New PhotoPortfolioWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            if (!empty($galleries))
                $portfolio = $galleries[0];
            
            $post->validate();
            $news->validate();
            $success = !$post->hasErrors() && !$news->hasErrors() && is_object($portfolio) && !$portfolio->hasErrors();
            if ($success && isset($post->tags)) { //search for deleted tags
                foreach($post->tags as $tag)
                    if(!in_array($tag->tag_id, $post->postedTags)) {
                        $post->deletedTags[] = $tag;
                    }
            }

            $strMessage = ($post->isNewRecord ? Yii::t('main','New article was created successfully') : Yii::t('main', 'Article was saved successfully')) . ' ('.Yii::t('main','Title').': '.$posttitle.')';
            
            if ($success) {
                $transaction = Yii::app()->db->beginTransaction();
                if ($success = $portfolio->saveGallery()) {
                    $post->gallery_id = $portfolio->gallery_id;
                    if ($success = $post->save()) {
                        $news->post_id = $post->post_id;
                        if ($success = $news->save()){ 
                            //if exists deleted tags - process its
                            foreach($post->deletedTags as $tag) {
                                $countDeleted = Tagpost::model()->deleteAll('tag_id = :tag_id AND post_id = :post_id', array(':tag_id'=> $tag->tag_id,':post_id'=>$post->post_id));
                                if (!($success = $countDeleted > 0))
                                    break;
                            }
                            foreach($post->postedTags as $tag) {
                                $exists = Tagpost::model()->exists('tag_id = :tag_id AND post_id = :post_id', array(':tag_id'=> $tag,':post_id'=>$post->post_id));
                                if (!$exists) {
                                    $tagpost = New Tagpost;
                                    $tagpost->tag_id = $tag;
                                    $tagpost->post_id = $post->post_id;
                                    $tagpost->save();
                                }
                            }
                        }
                    }
                }
                if ($success) {
                    $transaction->commit();

                    $resultMode = ($success ? 'success' : 'error');
                    Yii::app()->user->setFlash($resultMode, $strMessage);    //show flash message
                    
                    $this->redirect($this->createUrl('index'));
                } else
                    $transaction->rollback();
                
            }
        }
        $className = strtolower($this->_modelclass);
        $category = Category::model()->findAll();

        if($className === 'portfolioposts'){
            $className = 'news';
        }
        $this->render('application.modules.'.$className.'.views.default.form', array($className => $news, 'post' => $post, 'portfolio' => $portfolio, 'category'=>$category));
    }
    
}
