<?php
/* 
    Extended class for WhFineUploader (with one overrided method)))
*/
//Yii::import('yiiwheels.widgets.fineuploader.WhFineUploader');

class WhFineUploaderEx extends WhFineUploader
{
    //special params for widget
    public $uniqueId;
    public $photoCount = 0;  //count of exists photo (or 0 if new gallery)
    public $photoCountMax = 0;  //max count of uploaded photo (0 - without limit)
    public $maxSortOrder = 0;
    public $galleryType;
  
    //--- Overrided method: Registers required client script for fineuploader
    public function registerClientScript()
    {//DebugBreak();
        //publish assets dir 
        $path      = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'assets';
        $assetsUrl = $this->getAssetsUrl($path);

        //@var $cs CClientScript 
        $cs = Yii::app()->getClientScript();

        $script = YII_DEBUG ? 'jquery.fineuploader-3.2.js' : 'jquery.fineuploader-3.2.min.js';

        $cs->registerCssFile($assetsUrl . '/css/fineuploader.css');
        $cs->registerScriptFile($assetsUrl . '/js/' . $script);
        
        // initialize plugin 
        //$selector = '#' . TbHtml::getOption('id', $this->htmlOptions, $this->getId());  //old version
        $selector = '#' . TbArray::getValue('id', $this->htmlOptions, $this->getId());  //new version
      //<!-- different method for widget registration
        $options = CMap::mergeArray($this->defaultOptions, $this->pluginOptions);
        $options = CMap::mergeArray(array('element'=>'js:$("'.$selector.'")[0]'), $options);
        $options = !empty($options) ? CJavaScript::encode($options) : '';
        $script = "
            $(document).ready(function() {
                 var uniqueId = '" . $this->uniqueId . "';
                 var fileNum =  " . $this->photoCount . ";
                 var photoCount =  " . $this->photoCount . ";
                 var photoCountMax =  " . $this->photoCountMax . ";
                 var maxSortOrder =  " . $this->maxSortOrder . ";
                 var galleryType =  " . $this->galleryType . ";
                 var uploader_" . $this->uniqueId . " = new qq.FineUploader(" . $options .");
                 
                 $('$selector .triggerUpload').click(function() {
                    uploader_" . $this->uniqueId . ".uploadStoredFiles();
                 });

                 if (photoCountMax > 0) { 
                    if (photoCount >= photoCountMax) {
                        $('$selector #btnSelectFiles').attr('disabled', 'disabled');
                        $('$selector #btnSelectFiles input').attr('disabled', 'disabled');
                    } 
                    //else {
                    //    uploader_" . $this->uniqueId . ".itemLimit = photoCountMax - photoCount;
                    //}
                 }
                 
                 $('$selector .delete-uploaded').live('click', function() {
                    $(this).parent().parent().remove();
                    --photoCount;
                    if (photoCountMax > 0 && photoCount < photoCountMax) {
                        $('$selector #btnSelectFiles').removeAttr('disabled');
                        $('$selector #btnSelectFiles input').removeAttr('disabled');
                    }
                 });
            });";
        // -->
        Yii::app()->clientScript->registerScript(uniqid(__CLASS__ . '#', true), $script, CClientScript::POS_END);
        $this->getApi()->registerEvents($selector, $this->events);
    }

    /**
     * @return array
     */
    protected function getValidator()
    {
        $ret = array();
        if ($this->hasModel()) {
            if ($this->scenario !== null) {
                $originalScenario = $this->model->getScenario();
                $this->model->setScenario($this->scenario);
                $validators = $this->model->getValidators($this->attribute);
                $this->model->setScenario($originalScenario);

            } else {
                $validators = $this->model->getValidators($this->attribute);
            }

            // we are just looking for the first founded CFileValidator
            foreach ($validators as $validator) {
                if (is_a($validator, 'CFileValidator')) {
                    $ret = array(
                        'allowedExtensions' => isset($validator->types) ? explode(',', str_replace(' ', '', $validator->types)) : array(),
                        'sizeLimit'         => $validator->maxSize,
                        'minSizeLimit'      => $validator->minSize,
                    );
                    break;
                }
            }
        }
        return $ret;
    }    
}