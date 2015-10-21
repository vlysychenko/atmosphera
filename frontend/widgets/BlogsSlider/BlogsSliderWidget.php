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
        $this->getImagesFilename();  // 
        // этот метод будет вызван внутри CBaseController::beginWidget()
        parent::init();
    }
 
    public function run()
    {
        $this->render('index', array('data' => $this->sliderData));
    }
    
    // выборка имени файла 
    private function getImagesFilename() {
        foreach($this->sliderData as &$row){
            $flg = isset($row['gallery_id']) && !empty($row['gallery_id']);
            // если не произвелась в главном запросе экшна, то производится здесь (и это не оптимально!!!)
            if (!$flg) {
                $row['filename'] = Yii::app()->db
                    ->createCommand('SELECT filename FROM photo WHERE gallery_id = :id AND is_top = 1')
                    ->queryScalar(array(':id' => $row['gallery_id']));
            }
        }
    }
}
?>
