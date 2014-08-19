<?php
/**
 * BxSlider
 *
 * @author savely
 * @link http://www.yiiframework.com/
 * 
 * Ver. 0.1
 *     - Upgrade BxSlider 4.1
 * 
 */

class BxSlider extends CWidget
{

    const DEFAULT_CSS_CLASS = 'bxslider';
    const DEFAULT_ITEM_CSS_CLASS = 'item';
    /**
     * @var string slider container tag.
     */
    public $containerTag = 'div';

    
    /**
     * @var string slider tag.
     */
    public $sliderTag = 'ul';
    
    /**
     * @var string slide tag.
     */
    public $slideTag = 'li';
    
	/**
	 * @var array additional HTML options to be rendered in the container tag.
	 */
	public $htmlOptions = array();
    
    /**
     * @var array additional HTML options to be rendered for the slider tag.
     */
    public $sliderHtmlOptions = array();    

	public $slides=array();

	/**
	 * @var array flexsliderOptions for customizing slider's behavior.
	 */
	public $sliderOptions=array();
	
	
	private $_baseAssetsUrl;
    
    
    protected function getSliderId() {
      if(isset($this->sliderHtmlOptions['id']))  {
        return $this->sliderHtmlOptions['id'] ;
      }
      return 'slider_'. $this->getId();
    }
    
	
	/**
	 * Runs the widget.
	 */
	public function run()	{
        if(!count($this->slides)) return;
        
        $this->htmlOptions['id']=$this->getId();
        if(!isset($this->sliderHtmlOptions['class']))
          $this->sliderHtmlOptions['class']=self::DEFAULT_CSS_CLASS;        
        if(!isset($this->sliderHtmlOptions['id']))
          $this->sliderHtmlOptions['id']= $this->getSliderId();        
          
        
		$this->registerClientScript();
		
       echo CHtml::openTag($this->containerTag, $this->htmlOptions)."\n";
		$this->renderSlides();
		echo CHtml::closeTag($this->containerTag);
    }


	/**
	 * Registers the needed CSS and JavaScript.
	 */
	public function registerClientScript()
	{
		$assets_path = dirname(__FILE__) . '/assets';
		$this->_baseAssetsUrl = Yii::app()->assetManager->publish($assets_path);
	
		$cs=Yii::app()->getClientScript();
		$cs->registerCoreScript('jquery');
		
		//script, css for flexslider
		$this->registerAsset('jquery.bxslider.css');
        //$this->registerAsset('jquery.bxslider.js');        
		$this->registerAsset('jquery.bxslider.min.js');
        
        $param = CJavaScript::encode($this->sliderOptions);        
        
		//trigger the slider
		$cs->registerScript(
		  'bxslider_trigger_' . $this->sliderHtmlOptions['id'],
		  '
			jQuery(function () {
            if(typeof SLIDER_INSTANCES == "undefined") {
            SLIDER_INSTANCES = [];
            }
			 var slider = jQuery(\'#' . $this->sliderHtmlOptions['id'] . '\').bxSlider(' . $param  . ');
             SLIDER_INSTANCES.push(slider);
			});
		  ',
		  CClientScript::POS_END
		);		
	}

	/**
	 * Renders slides.
	 */
	protected function renderSlides()
	{
         // open slider tag
        echo CHtml::openTag($this->sliderTag, $this->sliderHtmlOptions)."\n";         
        
		foreach($this->slides as $id=>$slide) {
         if(!isset($slide['htmlOptions'])) {
          $slide['htmlOptions'] = array();   
         }   
         if(!isset($slide['htmlOptions']['class'])) {
           $slide['htmlOptions']['class'] = self::DEFAULT_ITEM_CSS_CLASS;  
         }
         echo CHtml::openTag($this->slideTag,  $slide['htmlOptions'])."\n";                     
			if(isset($slide['content'])) {
				echo $slide['content'];
			} elseif(isset($slide['url']) && isset($slide['link'])) {
				echo sprintf('<a href=\'%s\'><img src=\'%s\'></img></a>' , $slide['link'], $slide['url']);
			}elseif(isset($slide['url'])) {
                echo sprintf('<img src=\'%s\'></img>' ,$slide['url']);
            }
         echo CHtml::closeTag($this->slideTag,  $slide['htmlOptions'])."\n";                                 
		}
        echo CHtml::closeTag($this->sliderTag);
	}


	/**
	 * generic function to register css or js
	 */
	protected function registerAsset($file)
	{
		$asset_path = $this->_baseAssetsUrl . '/' . $file;
		if(strpos($file, '.js') !== false)
			return Yii::app()->clientScript->registerScriptFile($asset_path);
		else if(strpos($file, '.css') !== false)
			return Yii::app()->clientScript->registerCssFile($asset_path);

		return $asset_path;
	}	
}
