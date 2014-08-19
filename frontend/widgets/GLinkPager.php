<?php
class GLinkPager extends CLinkPager{

    public $firstPageCssClass='last';
    public $lastPageCssClass='last';
    public $previousPageCssClass='invisible'; // 'direction ml-30 mr-30';
    public $nextPageCssClass='invisible'; // 'direction ml-30 mr-30';
    public $internalPageCssClass='';
    public $hiddenPageCssClass='';
    public $selectedPageCssClass='active-page';

    public $maxButtonCount=3;

    public $cssFile = false;

    public $header = '';
//    public $page;

    public function init()
    {
        if($this->nextPageLabel===null)
            $this->nextPageLabel='...';
        if($this->prevPageLabel===null)
            $this->prevPageLabel='...';
        if($this->firstPageLabel===null)
            $this->firstPageLabel=Yii::t('main','First');
        if($this->lastPageLabel===null)
            $this->lastPageLabel=Yii::t('main','Last');
        if($this->header===null)
            $this->header=Yii::t('yii','Go to page: ');

        if(!isset($this->htmlOptions['id']))
            $this->htmlOptions['id']=$this->getId();
        if(!isset($this->htmlOptions['class']))
            $this->htmlOptions['class']='pages';
    }

    public function run()
    {
        $this->registerClientScript();
        $buttons=$this->createPageButtons();
        if(empty($buttons))
            return;
        echo $this->header;
        echo CHtml::tag('ul',$this->htmlOptions,implode("\n",$buttons));
        echo $this->footer;
    }

    protected function createPageButtons()
    {
        unset($_GET['_']);
        if(($pageCount=$this->getPageCount())<=1)
            return array();
        list($beginPage,$endPage)=$this->getPageRange();
        $currentPage=$this->getCurrentPage(false); // currentPage is calculated in getPageRange()
        $buttons=array();
        // first page
        if($this->currentPage>=2){
            $buttons[]=$this->createPageButton($this->firstPageLabel,0,$this->firstPageCssClass,$currentPage<=0,false);
        }
//         prev page
        if($this->currentPage>=3){
            $page=$this->currentPage-3;
        $buttons[]=$this->createPageButton($this->prevPageLabel,$page,'last',$currentPage<=0,false);
        }
        // internal pages
        for($i=$beginPage;$i<=$endPage;++$i){
//                    debugBreak();
            if($i == $beginPage){
                $buttons[]=$this->createPageButton($i+1,$i,'last',false,$i==$currentPage);
            }else{
                $buttons[]=$this->createPageButton($i+1,$i,$this->internalPageCssClass,false,$i==$currentPage);
            }
        }
//         next page
        if($pageCount-$currentPage>=4){
            $page=$this->currentPage+3;
        $buttons[]=$this->createPageButton($this->nextPageLabel,$page,'last',$currentPage>=$pageCount-1,false);
        }
        // last page
        if($pageCount-$currentPage>=3){
            $buttons[]=$this->createPageButton($this->lastPageLabel,$pageCount-1,$this->lastPageCssClass,$currentPage>=$pageCount-1,false);
        }
        return $buttons;
    }
    protected function createPageButton($label,$page,$class,$hidden,$selected)
    {
        if($hidden || $selected)
            $class.=' '.($hidden ? $this->hiddenPageCssClass : $this->selectedPageCssClass);
        return '<li class="'.$class.'">'.CHtml::link($label,$this->createPageUrl($page)).'</li>';
    }
}
?>
