<?php
class GenImageCommand extends CConsoleCommand
{
    public function actionIndex() {
        echo "================================================================================\n\r";
        echo "GRANAT console command: Batch resizing of uploaded photos\n\r";
        echo "================================================================================\n\r";
        
        $fileform = New PhotoFileForm;             //get instance of model
        $fileform->setImageSize();            //set sizes from params-local
        $path = UrlHelper::getImageDir();     //get dir for upload
        $criteia = new CDbCriteria;
        $countTotal = Photo::model()->count($criteia);
        echo "total count of photo: ".$countTotal."\n\r";
        echo "start process... please wait\n\r";
        $offset = 0;//DebugBreak();
        $step = floor($countTotal / 10);
        $criteia->limit = $step;
        $criteia->offset = $offset;
        $countTotal = 0;
        while(($count = count($aPhotos = Photo::model()->findAll($criteia))) > 0) {
            foreach($aPhotos as $oPhoto) {
                $fileform->createImages($path, $oPhoto->filename, $oPhoto->thumb_filename);
            }
            $offset += $step;
            $criteia = new CDbCriteria;
            $criteia->limit = $step;
            $criteia->offset = $offset;
            $countTotal += $count;
            echo ".";
        }
        echo "\n\r";
        echo "total count of processed files: ".$countTotal."\n\r";
    }
}  
?>
