<?php
//

class DefaultController extends BackendController
{
    public function actionTestupload() {
        $gallery = New Gallery;
        $this->render('test', array('gallery' => $gallery));
    }
    
    public function actionUploadfile() {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget');
            $galleryWidget = New PhotoGalleryWidget;
            $galleryWidget->uploadPhoto();
        }
    }
    public function actionUploadimage() {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget');
            $galleryWidget = New PhotoGalleryWidget;
            $galleryWidget->uploadPhoto();
        }
    }
    public function actionUploadMagazine() {
        if (Yii::app()->request->isAjaxRequest) {
            Yii::import('application.modules.gallery.widgets.PhotoGallery.PhotoGalleryWidget');
            $galleryWidget = New PhotoGalleryWidget;
            $galleryWidget->checkBoxClass = 'hide';
            $galleryWidget->radiobuttonClass = 'hide';
            $galleryWidget->uploadPhoto();
        }
    }
        
}  
?>
