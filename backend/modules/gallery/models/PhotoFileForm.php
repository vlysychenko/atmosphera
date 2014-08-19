<?php
/**
* 
*/
class PhotoFileForm extends FileForm
{
    private $_imageSizes = array(
        //array('name'=>'raw', ),
        array('name'=>'big_photo',     'operation'=>'resize',   'options'=>array('width'=>665, 'height'=>365)),
        array('name'=>'thumb_project', 'operation'=>'fitwidth', 'options'=>array('width'=>123, 'height'=>67)),
        array('name'=>'magazine_title', 'operation'=>'fitwidth', 'options'=>array('width'=>253, 'height'=>360)),           //max
        array('name'=>'article_slider', 'operation'=>'fitwidth', 'options'=>array('width'=>370, 'height'=>252)),           //max
        array('name'=>'thumb_horoscope', 'operation'=>'fitwidth', 'options'=>array('width'=>91, 'height'=>79)),           //max
        array('name'=>'banners_photo', 'operation'=>'bestfit', 'options'=>array('width'=>272, 'height'=>191)),           //max
        array('name'=>'main_page_slider', 'operation'=>'bestfit', 'options'=>array('width'=>680, 'height'=>383)),           //max
        array('name'=>'article_isTop_frontend', 'operation'=>'fitwidth', 'options'=>array('width'=>270, 'height'=>183)),   //artem
        array('name'=>'partner_index_frontend', 'operation'=>'resizewidth', 'options'=>array('width'=>213, 'height'=>66)),   //artem
        array('name'=>'partner_footer_frontend', 'operation'=>'fitwidth', 'options'=>array('width'=>270, 'height'=>183)),   //artem
        array('name'=>'gallery_index_frontend', 'operation'=>'fitwidth', 'options'=>array('width'=>369, 'height'=>376)),   //jurets
    );
    public function getImageSizes() {
        return $this->_imageSizes;
    }
    
    private $_rawDir = 'raw';
    public function getRawDir() {
        return $this->_rawDir;
    }
    
    //new sizes for uploaded photos
    private  $_fullSizeW;     //width for big file
    private  $_fullSizeH;     //height for big file
    private  $_thumbSizeW;    //width for thumb file
    private  $_thumbSizeH;    //height for thumb file
    private  $_imgTranspColor = array(255, 255, 255);
    
    public function rules()
    {
        return array(
            array('file', 'file',
                'allowEmpty' => true,
                'types'      => 'gif, jpg, jpeg, png',
                'mimeTypes'  => 'image/gif, image/jpeg, image/png',
                'maxSize'    => Yii::app()->params['upload']['image']['maxFileSize'], //500000,
                'maxFiles'   => 1,
            ),
        );
    }
    
    /**
    * setting of file sizes (big and thumb)
    * 
    * @param mixed $fullSizeW
    * @param mixed $fullSizeH
    * @param mixed $thumbSizeW
    * @param mixed $thumbSizeH
    */
    public function setImageSize(/*$fullSizeW, $fullSizeH, $thumbSizeW, $thumbSizeH*/) 
    {
         $this->_fullSizeW = Yii::app()->params['sizeW'];
         $this->_fullSizeH = Yii::app()->params['sizeH'];
         $this->_thumbSizeW = Yii::app()->params['thumb_sizeW'];
         $this->_thumbSizeH = Yii::app()->params['thumb_sizeH'];
    }

    //best fit transformation for image
    private function bestfit($srcImg, $width, $height) {
        $dstImg = $srcImg->resize($width, $height, 'inside');
        $white = $srcImg->allocateColor(255, 255, 255);
        $dstImg = $dstImg->resizeCanvas($width, $height, 'center', 'center', $white);
        return $dstImg;
    }

    /**
    * best fit transformation for image
    * 
    * @param mixed $srcImg - source Image
    * @param mixed $width
    * @param mixed $height
    */
    private function fitwidth($srcImg, $width, $height) {
        $srcWidth  = $srcImg->getWidth();
        $srcHeight = $srcImg->getHeight(); 
        $white = $srcImg->allocateColor(255, 255, 255);
        
        $scale = $width / $srcWidth; //calculate scale
        $dstImg = $srcImg->resize($width, ceil($srcHeight * $scale), 'inside');
        if ($dstImg->getHeight() > $height)
            $dstImg = $dstImg->crop('center', 'center', $width, $height, 'inside');
        else {
            $dstImg = $dstImg->resizeCanvas($width, $height, 'center', 'center', $white);
        }
        
        return $dstImg;
    }

    private function resizewidth($srcImg,$width,$height){
        $dstImg = $srcImg->resizeDown($width, $height, 'outside');
        $white = $srcImg->allocateColor(255, 255, 255);
        $dstImg = $dstImg->resizeCanvas($width, $height, 'center', 'center', $white);
        return $dstImg;
    }
//
//    private function resizehieght(){
//
//    }
    
    //saving of gallery photo files (2 new files - big and thumb)
    public function saveFile($file, $path)
    {
        //set metrics for uploaded files
        $this->setImageSize();

        list($width, $height, $type) = getimagesize($file->tempName);
        switch ($type)
        {
          case 1: $src = imagecreatefromgif($file->tempName); break;
          case 2: $src = imagecreatefromjpeg($file->tempName);  break;
          case 3: $src = imagecreatefrompng($file->tempName); break;
          default: $src = null;  break;
        }
        if ($src) {
            $fileName = $path . DIRECTORY_SEPARATOR . $this->secureName;         //define main file name
            $thumbFileName = $path . DIRECTORY_SEPARATOR . $this->secureTName;   //define thumb file name
            //create raw image
            $fileName = $this->makeFileName($path, $this->_rawDir, $this->secureName);
            $this->makeDir(dirname($fileName));
            $rawsuccess = $this->file->saveAs($fileName); 
            
            //create other sizes
            if ($rawsuccess) {
                $this->createImages($path, $this->secureName, $this->secureTName);
            }
            return true;
        } else {
            unlink($file->tempName);
            return false; 
        }
    }
 
    public function createImages($path, $bigfilename, $thumbfilename) {
        Yii::import('common.extensions.EWideImage.EWideImage');                      //include library for image manipulation
        $srcfile = $this->makeFileName($path, 'raw', $bigfilename);
        if (file_exists($srcfile)) {
            $srcImg = EWideImage::load($srcfile); //load image from raw
            //create main image
            $fileName = $this->makeFileName($path, '', $bigfilename);
            $dstImg = $this->fitwidth($srcImg, $this->_fullSizeW, $this->_fullSizeH);
            $dstImg->saveToFile($fileName);
            //create thumb image
            $fileName = $this->makeFileName($path, '', $thumbfilename);
            $dstImg = $this->fitwidth($srcImg, $this->_thumbSizeW, $this->_thumbSizeH);
            $dstImg->saveToFile($fileName);

            foreach($this->_imageSizes as $size) {
                switch ($size['operation']) {
                  case 'crop':    $dstImg = $srcImg->crop('center', 'center', $size['options']['width'], $size['options']['height']); 
                                  break;
                  case 'resize':  $dstImg = $srcImg->resize($size['options']['width'], $size['options']['height'], 'fill'); 
                                  break;
                  case 'bestfit': $dstImg = $this->bestfit($srcImg, $size['options']['width'], $size['options']['height']); 
                                  break;
                  case 'fitwidth':$dstImg = $this->fitwidth($srcImg, $size['options']['width'], $size['options']['height']); 
                                  break;
                  case 'resizewidth':$dstImg = $this->resizewidth($srcImg, $size['options']['width'], $size['options']['height']);
                                  break;
                  default: break;
                }
                $fileName = $this->makeFileName($path, $size['name'], $bigfilename);
                $this->makeDir(dirname($fileName));
                $dstImg->saveToFile($fileName);
            }
        }
    }

    //
    public function processFile($params = array()) {
        $photo = New Photo;  
        $photo->title = $this->originalName;         //original name of file
        $photo->filename = $this->secureName;        //new name
        $photo->thumb_filename = $this->secureTName;  //temp: thumb_filename = filename
        $photo->mime_type = $this->file->type;
        $photo->sort_order = $params['sort_order'];          //sort order = current idx of uploaded file
        if ($this->galleryType == 1)
            $photo->is_top = $params['is_top'];           //first uploaded photo - is_top
        else
            $photo->is_top = 0;
        return $photo;
    }
    
    public static function getImageExtensions() {
        $photoFileForm = new PhotoFileForm;
        $rules = $photoFileForm->rules();
        $types = isset($rules[0]['types']) ? explode(',', str_replace(' ', '', $rules[0]['types'])) : array();
        return $types;
    }
}  
?>
