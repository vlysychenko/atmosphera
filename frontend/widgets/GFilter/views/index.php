    <script>
      $(document).ready(function() {
              $('[name^=categories]').change(function() {
                  $('div[name^=item]').hide();
              });
              $('[name^=categories]').click(function() {
                  if ($(this).attr('check') != '1') {
                      $(this).attr('check', '1');
                      $('div[name=item' + $(this).val() + ']').show().attr('name', 'iitem' + $(this).val());
                  } else {
                      $(this).removeAttr('check');
                      $('div[name^=iitem' + $(this).val() + ']').hide().attr('name', 'item' + $(this).val());

                  }
              });
          });

    </script>
    
    <?php  echo CHtml::checkBoxList('categories', [], CHtml::listData($data, 'category_id', 'name')).'<br>';?>
    
