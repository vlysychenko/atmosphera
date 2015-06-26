<?php
class ImageHelper{

    public static function imageUrl($path,$file)
    {
        $uploadDir = rtrim(preg_replace("#[\\/]#", DIRECTORY_SEPARATOR, Yii::app()->params['uploadDir']), DIRECTORY_SEPARATOR);
        $realpath = strlen($path) ? $uploadDir. DIRECTORY_SEPARATOR. $path . DIRECTORY_SEPARATOR. $file
                                  : $uploadDir. DIRECTORY_SEPARATOR. $file ;
        if(is_file($realpath)){
            return Yii::app()->params['uploadUrl'].$path.'/'.$file;
        }else{
            return Yii::app()->createAbsoluteUrl('/img/default.jpg');
        }
    }
}