<?php

Yii::import('bootstrap.widgets.TbButtonColumn');

/**
 * Extended Bootstrap button column widget.
 * added possibility to set button html template plus evaluate button`s css class
 */
class PButtonColumn extends TbButtonColumn
{
	/**
	 * Renders a link button.
	 * @param string $id the ID of the button
	 * @param array $button the button configuration which may contain 'label', 'url', 'imageUrl' and 'options' elements.
	 * @param integer $row the row number (zero-based)
	 * @param mixed $data the data object associated with the row
	 */
	protected function renderButton($id, $button, $row, $data)
	{
		
        if (isset($button['visible']) && !$this->evaluateExpression($button['visible'], array('row'=>$row, 'data'=>$data)))
			return;

		$label = isset($button['label']) ? $button['label'] : $id;
        
        if(isset($button['labelExpression'])) 
          $label = $options['label'] = $this->evaluateExpression($button['labelExpression'], array('data'=>$data, 'row'=>$row)); 
        
		$url = isset($button['url']) ? $this->evaluateExpression($button['url'], array('data'=>$data, 'row'=>$row)) : '#';
		
        $options = isset($button['optionsExpression'])?($this->evaluateExpression($button['optionsExpression'],array('row'=>$row, 'data'=>$data))):(isset($button['options']) ? $button['options'] : array());
        if (isset($button['disabledExpression']))
        {
            $button['disabled'] = $this->evaluateExpression($button['disabledExpression'],array('row'=>$row, 'data'=>$data));
        }
         
        
		if (!isset($options['title']))
			$options['title'] = $label;

		if (!isset($options['rel']))
			$options['rel'] = 'tooltip';
            
        //custom code to evaluate class expression
        if(isset($button['cssClassExpression'])) 
          $options['class'] = $this->evaluateExpression($button['cssClassExpression'], array('data'=>$data, 'row'=>$row));   
        //custom html template  
       
        if (isset($button['disabled'])&&($button['disabled']==true))
        {
            unset($options['ajax']);
            if (isset($button['htmlTemplate'])) 
            {
                echo $button['htmlTemplate'];
            }
            else if (isset($button['icon']))
            {
                if (strpos($button['icon'], 'icon') === false)
                    $button['icon'] = 'icon-'.implode(' icon-', explode(' ', $button['icon']));

                echo '<i class="'.$button['icon'].'"></i>';
            }
            else if (isset($button['imageUrl']) && is_string($button['imageUrl']))
                echo CHtml::image($button['imageUrl'], $label);
            else
                echo CHtml::tag('span',$options,$label,true);   
        }
        else 
        {
          
          if (isset($button['htmlTemplate'])) {
            echo CHtml::link($button['htmlTemplate'], $url, $options);    
          }
          else if (isset($button['icon']))
          {
              if (strpos($button['icon'], 'icon') === false)
                  $button['icon'] = 'icon-'.implode(' icon-', explode(' ', $button['icon']));

              echo CHtml::link('<i class="'.$button['icon'].'"></i>', $url, $options);
          }
          else if (isset($button['imageUrl']) && is_string($button['imageUrl']))
              echo CHtml::link(CHtml::image($button['imageUrl'], $label), $url, $options);
          else
              echo CHtml::link($label, $url, $options);
          
              
       }
      
  }
}