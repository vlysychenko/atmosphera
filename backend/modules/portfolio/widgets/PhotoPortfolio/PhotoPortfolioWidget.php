<?php

class PhotoPortfolioWidget extends CWidget
{
    public $portfolioType;
    public $fileFormClass = 'FileForm';
    public $allowedExtensions = array();
                         
    //params for views
    private $_viewPath;     //path to views
    private $_viewItem     = 'PhotoItem.php';
    private $_viewTemplate = 'PhotoTemplate.php';
    private $_viewFile     = 'FileItem.php';
    private $_viewFileAny  = 'FileAnyItem.php';
     
    public $portfolio;      //portfolio - main model for widget
    public $portfolioId;
         
    public  $uploadAction;   //action name for file uploading
    private $_uploadDir;     //path for uploading
    private $_uploadUrl;     //URL of uploaded files
    
    public $fileForm;        //instance of model for file uploading
    
    private $uniqueId;       //unique identificator for portfolio widget
    private $uploaderUid;    //..id for uploader component variable
    private $uploaderName;
    
    private $template;
    private $fileTemplate;
    
    private $photoCount = 0;
    public  $photoCountMax = 0;  //max count of uploaded photo (0 - without limit)
    private $maxSortOrder = 0;
    
    public $checkBoxClass = '';
    public $radiobuttonClass = '';
        
    public function getUploadUrl() {
        if (empty($this->_uploadUrl))
            $this->_uploadUrl = UrlHelper::getBaseImageUrl();
        return $this->_uploadUrl;
    }

    public function getUploadDir() {
        if (empty($this->_uploadDir))
            $this->_uploadDir = UrlHelper::getImageDir(); 
        return $this->_uploadDir;
    }

    private function initViews() {
        $this->_viewPath = Yii::getPathOfAlias('application.modules.portfolio.widgets.PhotoPortfolio.views');
        $this->_viewTemplate = $this->_viewPath . DIRECTORY_SEPARATOR . $this->_viewTemplate;
        $this->_viewFile     = $this->_viewPath . DIRECTORY_SEPARATOR . $this->_viewFile;
        $this->_viewItem     = $this->_viewPath . DIRECTORY_SEPARATOR . $this->_viewItem;
        $this->_viewFileAny  = $this->_viewPath . DIRECTORY_SEPARATOR . $this->_viewFileAny;
    }
    
  //initialization of widget  
    public function init() {
        if (empty($this->portfolioType))
            $this->portfolioType = 1;
        if (empty($this->uploadAction)) {
            $path = (isset(Yii::app()->params['uploadAction']) ? Yii::app()->params['uploadAction'] : 'portfolio/default/uploadfile');
            $this->uploadAction = Yii::app()->createUrl($path);
            //throw new CHttpException(404, 'Action for file uploading not set.');
        }
        $this->initViews();           //setting of views params
        $this->uniqueId = uniqid();   //unique id for portfolio (and for widget)
        //set unique id for widget
        $this->uploaderUid = 'FileForm'. $this->uniqueId . '_file';
        $this->uploaderName = 'FileForm[file][' . $this->uniqueId . ']';
        
        //generate templates views 
        $this->fileTemplate = $this->renderFile($this->_viewFile, array(), true);  //file template
        $this->template = $this->renderFile($this->_viewTemplate, array(
            'model'=>$this->portfolio,
            'uniqueId'=>$this->uniqueId,
            'checkBoxClass'=>$this->checkBoxClass,
        ), true);                                                                  //main template
        
        //fill list of photos
        if (isset($this->portfolio->photos)) {
            $idx = 0;
            $this->maxSortOrder = 0;
            foreach($this->portfolio->photos as $key=>$photo) {
                //calculate type of file and view
                $path_parts = pathinfo($photo->filename);
                $ext = $path_parts['extension']; 
                $types = PhotoFileForm::getImageExtensions();
                $isImage = in_array($ext, $types);
                $_view = ($isImage ? $this->_viewItem : $this->_viewFileAny);  //select view
                //generate html for photo item
                $itemHtml = $this->renderFile($_view, array(
                    'uploadUrl'=>$this->uploadUrl,
                    'model'=>$photo,
                    'uniqueId'=>$this->uniqueId,
                    'idx'=>++$idx,
                    'radiobuttonClass' => $this->radiobuttonClass,
                ), true);
                //add generated item to widget template
                $this->template .= $itemHtml;
                if ($photo->sort_order > $this->maxSortOrder)
                    $this->maxSortOrder = $photo->sort_order;
            }
            $this->photoCount = $idx;
        }
    }
 
  //run widget
    public function run() {
        //Yii::import('application.modules.portfolio.models.*');
        $this->fileForm = new FileForm;
        //$this->fileForm = new $this->fileFormClass;
        //$this->widget('application.modules.portfolio.widgets.PhotoPortfolio.WhFineUploaderEx', array(
        $this->widget('common.widgets.fineuploader.WhFineUploaderEx', array(
                            'uploadAction' => $this->uploadAction,
                            'model' => $this->fileForm,
                            'uniqueId' => $this->uniqueId,
                            'photoCount'=> $this->photoCount,
                            'photoCountMax'=> $this->photoCountMax,
                            'maxSortOrder'=>$this->maxSortOrder,
                            'portfolioType'=>$this->portfolioType,
                            'htmlOptions'=>array(
                                'id'=>$this->uploaderUid, 
                                //'style'=>"margin-left: 110px; margin-right: 110px;"
                                //'name'=>$this->uploaderName,
                            ),
                            'attribute' => 'file',
                            'pluginOptions' => array(
                                'prependFiles'=>false,
                                'autoUpload'=>true,
                                'multiple'=>($this->photoCountMax == 0),
                                'validation'=>array(
                                    'allowedExtensions' => $this->allowedExtensions,
                                ),
                                'request'=>array(
                                    'params'=>array(
                                        'uniqueId'=>'js:function() { return uniqueId; }',
                                        'arrPhoto'=>'js:function() { 
                                                            arrPhoto = {fileNum: fileNum++, photoCount: photoCount, maxSortOrder: maxSortOrder++};
                                                            //arrPhoto = {fileNum: fileNum++, photoCount: photoCount++, maxSortOrder: maxSortOrder++};
                                                            //arrPhoto = {fileNum: fileNum, photoCount: photoCount, maxSortOrder: maxSortOrder};
                                                            return JSON.stringify(arrPhoto); 
                                                            }',
                                        'portfolioType'=>'js:function() { return portfolioType; }', 
                                    )),
                                'text' => array(
                                    'uploadButton' => '<i class="icon-plus"></i> '.Yii::t('main', 'Select Files'),
                                ),
                                'callbacks'=> array(
                                    'onComplete' => 
                                            "js:function(id, fileName, responseJSON) {
                                                uploader = uploader_" . $this->uniqueId . ";
                                                uploaderUid = '#".$this->uploaderUid."';
                                                if (responseJSON.success) {
                                                    photoCount++; //fileNum++; maxSortOrder++;
                                                    //uploader.clearStoredFiles();
                                                    $(uploaderUid + ' ul li.qq-upload-success').remove();
                                                    $(uploaderUid).append(responseJSON.itemHtml);
                                                    
                                                    if (photoCountMax > 0 && photoCount >= photoCountMax) {
                                                        $(uploaderUid + ' #btnSelectFiles').attr('disabled', 'disabled');
                                                        $(uploaderUid + ' #btnSelectFiles input').attr('disabled', 'disabled');
                                                    }
                                                }
                                            }",
                                      'onUpload' =>  
                                            "js:function(fileid, filename) {
                                                uploader = uploader_" . $this->uniqueId . ";
                                                //var uploads = uploader.getUploads();   //not work (old version!)
                                                if (photoCountMax > 0 && photoCount + uploader.getInProgress() > photoCountMax) {
                                                    if (uploader.doesExist(id))
                                                        uploader.cancel(fileid);
                                                    //uploader.cancelAll();   //not work (old version!)
                                                }
                                            }",
                                    ),
                                'template' => $this->template,
                                'fileTemplate' => $this->fileTemplate,
                                ), 
                            
                )
        );
        
     }
    
  // upload photo into destination path ('www/uploads')
    public function uploadPhoto() {
        $success = false;
        $request = array();
        $model = new FileForm;
        $file = CUploadedFile::getInstance($model, 'file');
        if ($model->validate()) {

          //check extension of uploaded file  
            $types = PhotoFileForm::getImageExtensions();
            $isImage = in_array($file->extensionName, $types);
            if ($isImage)
                $model = new PhotoFileForm;
            unset($photoFileForm);
                
            $model->file = $file;
            $success = $model->saveFile($model->file, $this->uploadDir);
            //$success = $model->file->saveAs($path . DIRECTORY_SEPARATOR . $newname);
            if ($success) {
                $arrPhoto = Yii::app()->request->getParam('arrPhoto');      //get data array for photo
                $arrPhoto = json_decode($arrPhoto);
                $fileNum = $arrPhoto->fileNum;//Yii::app()->request->getParam('photoCount');  //get count of files from page
                $photoCount = $arrPhoto->photoCount;//Yii::app()->request->getParam('photoCount');  //get count of files from page
                $maxSortOrder = $arrPhoto->maxSortOrder;
                $uniqueId = Yii::app()->request->getParam('uniqueId');    //get unique value for portfolio (widget) from page
                $this->portfolioType = Yii::app()->request->getParam('portfolioType');    //get portfolio type
                if (empty($photoCount))
                    $photoCount = 0;
                if (empty($uniqueId))
                    $uniqueId = uniqid();
                
                // create and initialize new Photo model
                //$model->processFile(array('is_top'=>($photoCount == 0), 'sort_order'=>$maxSortOrder + 1));
                $photo = New Photo;
                $photo->title = $model->originalName;         //original name of file
                $photo->filename = $model->secureName;        //new name
                $photo->thumb_filename = $model->secureTName;  //temp: thumb_filename = filename
                $photo->mime_type = $model->file->type;
                $photo->sort_order = $maxSortOrder + 1;          //sort order = current idx of uploaded file
                if ($this->portfolioType == 1)
                    $photo->is_top = ($photoCount == 0);           //first uploaded photo - is_top
                else
                    $photo->is_top = 0;

                $this->initViews();
                $_view = ($isImage ? $this->_viewItem : $this->_viewFileAny);  //select view
                $itemHtml = $this->renderFile($_view, array(
                    'uniqueId'=>$uniqueId, //getting unique value for widget from form post
                    'uploadUrl'=>$this->uploadUrl, //url for uploaded photos
                    'model'=>$photo,               //instance of photo model
                    'idx'=>$fileNum + 1,
                    'portfolioType'=>$this->portfolioType,
                    'radiobuttonClass' => $this->radiobuttonClass,
                ), true);
                $request = array(
                    'filename'=>$model->secureTName, //$newname,
                    'itemHtml'=>$itemHtml,
                );
            } else {
                throw New Exception('File not uploaded!' . $model->file->error);
            }
        }
        $request = CMap::mergeArray(array('success'=>$success), $request);
        echo CJSON::encode($request);
        
    }

    /**
    * After validatePortfolio we use this method to check
    * is there any errors. Return false if has no errors
    * 
    * @param mixed $data - array or single portfolio
    */
    public static function checkForErrors(&$data){
        if(is_array($data)){
            foreach($data as &$portfolio){
                if($portfolio->errors) return true;
                if(empty($portfolio->photos)){ 
                    $portfolio->addError('empty', Yii::t('main', 'Portfolio must have photos'));
                    return true;
                }
                if(!empty($portfolio->photos)){
                    foreach($portfolio->photos as $photo){
                        if($photo->errors) return true;
                    }
                }
            }
            return false;
        }elseif(is_object($data)){
            $portfolio = $data;
            if($portfolio->errors) return true;
            if(empty($portfolio->photos)){ 
                $portfolio->addError('empty', Yii::t('main', 'Portfolio must have photos'));
                return true;
            }
            if(!empty($portfolio->photos)){
                foreach($portfolio->photos as $photo){
                    if($photo->errors) return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }
    
    /**
    * Validate data from form post 
    *  it's must making before saving into database
    * @param mixed $postData
    */
    public function validatePortfolio($postData) 
    {
        $arrayPortfolio = array();
        foreach($_POST['FileForm'] as $gallery_idx=>$postPortfolio) 
        {
            if (empty($postPortfolio['gallery_id'])) {
                $portfolio = New Portfolio;
            }
            else {
                $portfolio_id = $postPortfolio['gallery_id'];
                $portfolio = Portfolio::model()->with('photos')->findByPk($portfolio_id);
                if (!isset($portfolio))
                    $portfolio = New Portfolio;
            }
            $portfolio->attributes = $postPortfolio;  //assign attributes
            $valOK = $portfolio->validate();
            
            $arrayPhotosIds = array();  //additional array for deleted photos search
            $deletedPhotos = array();   //array for deleted photos
            $photos = array();          //array of edited photos of portfolio
            $isTopPresent = false;
            
          //process photos array  
            if (isset($postPortfolio['photos']))
                foreach($postPortfolio['photos'] as $idx => $postPhoto) {   
                    $photo_id = $postPhoto['photo_id'];
                    $isNewPhoto = (empty($photo_id));
                    $photo = ($isNewPhoto ? New Photo : Photo::model()->findByPk($photo_id));
                    if ($isNewPhoto = !isset($photo))
                        $photo = New Photo;
                    $photo->attributes = $postPhoto;
                    $photo->gallery_id = $portfolio->gallery_id;
                    $photo->is_top = (isset($postPortfolio['is_top']) && $idx == $postPortfolio['is_top'] ? Photo::POSITION_IS_TOP : Photo::POSITION_NO_TOP);
                    if($photo->is_top) $isTopPresent = true;         //mark is_top present
                    $valOK = $photo->validate() && $valOK;
                    $arrayPhotosIds[$idx] = $postPhoto['photo_id'];  //add item to search array
                    $photos[$idx] = $photo;
                }
            //validate photos (count)
            if ($postPortfolio['gallery_type'] == 1) {
                if (!count($photos)) 
                    $portfolio->addError('is_top', Yii::t('main', 'Portfolio must have photos'));
                else if (!$isTopPresent)
                    $portfolio->addError('is_top', Yii::t('main', 'In photo portfolio one of photo must be in top'));
            }
          //search for deleted photos
            if (isset($portfolio->photos))
                foreach($portfolio->photos as $photo)
                    if(!in_array($photo->photo_id, $arrayPhotosIds)) {
                        $portfolio->deletedPhotos[] = $photo;
                    }
            $portfolio->photos = $photos;  //add photo items to portfolio model            
            $arrayPortfolio[] = $portfolio;  //add instance of portfolio to returning array
        }
        return $arrayPortfolio; //returning result array of portfolio instances
    }

}
?>
