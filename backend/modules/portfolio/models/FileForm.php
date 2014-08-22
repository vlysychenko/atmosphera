<?php
/**
* 
*/
class FileForm extends CFormModel
{
    private $_rawDir = 'raw';
    private $_filesDir = 'files';

    public function getRawDir() {
        return $this->_rawDir;
    }
    public function getFilesDir() {
        return $this->_filesDir;
    }
    
    //file-object - instance of CUploadedFile class
    public $file;             
    //generated names for files
    private $_secureName;     //big file
    private $_secureTName;    //thumb file
    public  $extension = '';
    
    public function rules()
    {
        return array(
            array('file', 'file',
                'allowEmpty' => true,
                //'types'      => 'gif, jpg, jpeg, png',
                'types'      => null,
                //'mimeTypes'  => 'image/gif, image/jpeg, image/png',
                'mimeTypes'  => null,
                'maxSize'    => Yii::app()->params['upload']['magazine']['maxFileSize'], //10*1024*1024,
                'maxFiles'   => 1,
            ),
        );
    }
    
    //original name of uploaded file 
    public function getOriginalName() {
        $pathinfo = pathinfo($this->file->name);
        return $ext = $pathinfo['basename'];
    }
    
    //getter for generated file name
    public function getSecureName() {
        if (empty($this->_secureName))
            $this->_secureName = $this->createSecureName($this->file->name, $this->extension);
        return $this->_secureName;
    }

    //getter for generated thumb file name
    public function getSecureTName() {
        if (empty($this->_secureTName))
            $this->_secureTName = $this->createSecureName('t_' . $this->file->name, $this->extension);
        return $this->_secureTName;
    }
        
    //hashing of uploaded file name
    protected function createSecureName($filename, $extension) {
        $pathinfo = pathinfo($filename);
        if (!empty($extension))
            $ext = $extension;
        else 
            $ext = $pathinfo['extension'];
        $ext = (!empty($ext) ? '.'.$ext : '');
        $oldname = $pathinfo['filename'];
        $newname = md5(Yii::app()->user->id . microtime() . $oldname); // sha1 - variant?
        return $newname . $ext;
    }

    //make directory if not exists
    protected function makeDir($dir){
        if (!is_dir($dir)) //if not exists subdir (e.g. main_project, thumb_slider, ...)
            mkdir($dir);        //create it (with full permissions 0777 by default)
    }
    
    //make full file path
    protected function makeFileName($uploaddir, $subdir, $filename){
        if (!empty($subdir))
            $subdir .= DIRECTORY_SEPARATOR;
        return $uploaddir . DIRECTORY_SEPARATOR . $subdir . $filename;
    }
    
    //saving of portfolio photo files (2 new files - big and thumb)
    public function saveFile($file, $path)
    {
        $fileName = $this->makeFileName($path, $this->_filesDir, $this->secureName);
        $this->makeDir(dirname($fileName));
        $success = $this->file->saveAs($fileName);
        //unlink($this->file->tempName);
        return $success;
    }

    public function processFile($params = array()) {
        return $this;
    } 
}  
?>
