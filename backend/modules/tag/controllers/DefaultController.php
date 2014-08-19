<?php

class DefaultController extends BackendController
{
    public $title = '';
    private $_model;
    public $strMessage;

	public function actionIndex()

	{
        $this->layout = 'application.views.layouts.main';

        $model = new Tag('search');
        if(isset($_GET['Tag'])){
            $model->attributes = $_GET['Tag'];
        }

        $this->render('index',array(
            'model'=>$model,
        ));
	}

    public function actionCreate()
    {
        $this->title = Yii::t('main', 'Create Tag');
        $this->strMessage = Yii::t('main','Tag was created successfully');
        $this->editTag();
    }

    public function actionUpdate() {
        $this->title = Yii::t('main', 'Update Tag');
        $this->strMessage = Yii::t('main','Tag was saved successfully');
        $this->editTag();
    }

    public function editTag(){
        $this->layout = 'application.views.layouts.main';
        $id = Yii::app()->request->getParam('id');  //check input param
        $model = (isset($id) ? Tag::model()->findByPk($id) : New Tag);
        if(isset($_POST['Tag']))
        {
            $model->attributes=$_POST['Tag'];
            if($model->validate()) {
                if ($model->save()) {
                    Yii::app()->user->setFlash('success', $this->strMessage);
                    $this->redirect(array('/tag'));
                }
            }
        }
        $this->render('create',array(
        'model'=>$model,
        ));
    }

    public function actionDelete()
    {
        if(Yii::app()->request->isPostRequest)	{
//			 we only allow deletion via POST request
            $criteria = new CDbCriteria;
            $criteria->condition = 'tag_id=:tag_id';
            $criteria->params = array(':tag_id'=>$_GET['id']);
            $tagposts = Tagpost::model()->findAll($criteria);
            foreach($tagposts as $tagpost ){
                $tagpost->delete();
            }
            $model = $this->deleteLoadModel();
            $model->delete();
            // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
            if(!Yii::app()->request->isAjaxRequest)
                $this->redirect(array('/tag'));
        }
        else
            throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
    }

    public function deleteLoadModel()
    {
        if($this->_model===null)
        {
            if(isset($_GET['id']))
                $this->_model=Tag::model()->notsafe()->with('tagposts')->findbyPk($_GET['id']);
            if($this->_model===null)
                throw new CHttpException(404,'The requested page does not exist.');
        }
        return $this->_model;
    }

    public function actionTagDetail(){

        $tagId = Yii::app()->request->getParam('id');
        $model = new Posting;
        if(isset($_GET['Posting'])){
            $model->attributes = $_GET['Posting'];
        }

        $criteria = new CDbCriteria;
//        $criteria->together = true;
        $criteria->with = array('tagposts','news','galleryposts');
        $criteria->select = 't.post_id, t.title, t.post_type, CASE WHEN news.publication_date IS NULL THEN galleryposts.publication_date ELSE news.publication_date END  AS publication_date';
        $criteria->addCondition('EXISTS (SELECT 2 FROM tagpost WHERE tagpost.post_id = t.post_id AND tagpost.tag_id = :tag)');
        if(isset($_GET['News']['publication_date'])){
            $pbDate = $_GET['News']['publication_date'];
            $criteria->addCondition('(news.publication_date LIKE "'.$pbDate.'%" OR galleryposts.publication_date LIKE "'.$pbDate.'%")');
        }else{
            $pbDate = '';
        }
        $criteria->params = array(':tag'=>$tagId);
        $criteria->compare('t.title',$model->title,true);
        $criteria->compare('t.post_type',$model->post_type,true);
        $criteria->compare('t.post_id',$model->post_id,true);

        $dataprovider =  new CActiveDataProvider($model, array(
            'criteria'=>$criteria,
            'pagination'=>array(
                'pageSize'=>10,
            ),
            'sort'=>array(
                'attributes'=>array(
                    'defaultOrder'=> 'publication_date DESC',
                    'publication_date'=>array(
                        'asc'=>'publication_date asc',
                        'desc'=>'publication_date desc'
                    ),'*'
                ),
            )
        ));
        if(strlen(Yii::app()->request->getParam('ajax'))) {
            $this->renderPartial('tagdetail',array(
                'model'=>$model,
                'dataprovider'=>$dataprovider,
                'tagId'=>$tagId,
                'pbDate'=>$pbDate
            ));
        } else {
        $this->render('tagdetail',array(
            'model'=>$model,
            'dataprovider'=>$dataprovider,
            'tagId'=>$tagId,
            'pbDate'=>$pbDate
        ));
        }
    }
}