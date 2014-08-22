<?php
/**
* @param array $sliderData must consist: 
* id
* publication_date
* p_title
* filename
* firstname
* lastname
*                                           
*/
class BlogsSliderWidget extends CWidget
{
    public $sliderData;
    public function init()
    {
        $this->getImagesFilename();
        // этот метод будет вызван внутри CBaseController::beginWidget()
        parent::init();
    }
 
    public function run()
    {
        $this->render('index', array('data' => $this->sliderData));
    }
    
    private function getImagesFilename(){
        foreach($this->sliderData as &$row){
            $galleryId = $row['gallery_id'];
            $row['filename'] = Yii::app()->db->createCommand('SELECT filename FROM photo WHERE gallery_id = :id AND is_top = 1')->queryScalar(array(':id' => $galleryId));            
        }
    }
}
?>
