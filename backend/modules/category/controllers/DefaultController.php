<?php

class DefaultController extends Controller
{

    protected $_modelclass = 'Category';
    

    //function for post_type definition
    
    

	public function actionIndex()
	{
		$model=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$model,
		));
	}
      public function actionView($id)
	{
	$model=new CActiveDataProvider('Category');
		$this->render('index',array(
			'dataProvider'=>$model,
		));
        }
        public function actionCreate()
	{
		$model=new Category;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->category_id));
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}
       public function actionUpdate($id)
	{
		$model=Category::model()->findByPk($id);

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['Category']))
		{
			$model->attributes=$_POST['Category'];
			if($model->save())
				$this->redirect(array('view','id'=>$model->category_id));
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
    {
        $model = Category::model()->findByPk($id);
        $model->deleteCategory();

        // if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
        if(!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
    } 
        

     
        
}
