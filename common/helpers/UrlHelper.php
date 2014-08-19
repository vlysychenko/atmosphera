<?php
   class UrlHelper {
    
    public static function getImageUrl($fileName, $subdir = '', $secondfile = '') {
        $dir = Yii::app()->params['uploadDir'];
        $url = Yii::app()->params['uploadUrl'];
        /*Yii::log('uploadDir: ' . $dir, 'info', 'system.web');
        Yii::log('subdir: ' . $subdir, 'info', 'system.web');
        Yii::log('fileName: ' . $fileName, 'info', 'system.web');
        Yii::log('DIRECTORY_SEPARATOR: ' . DIRECTORY_SEPARATOR, 'info', 'system.web');*/
        if (is_file($dir . $subdir . DIRECTORY_SEPARATOR . $fileName))
            return $url . $subdir . '/' . basename($fileName);
        else if (is_file($dir . DIRECTORY_SEPARATOR . $secondfile))
            return $url . basename($secondfile);
        else if (is_file($dir . DIRECTORY_SEPARATOR . $fileName))
            return $url . basename($fileName);  
        else
            return Yii::app()->params['defaultPhoto'];
        //if (!is_file($fileName) && !is_file($dir . DIRECTORY_SEPARATOR . $fileName))
    }
    
    public static function getImageDir(){
        return Yii::app()->params['uploadDir'];
    }
    
    public static function getBaseImageUrl() {
        return Yii::app()->params['uploadUrl'];
    }    
    
      public static function getDefaultImageUrl() {
        return Yii::app()->params['defaultPhoto'];
    }
       
   }
?>
