<?php echo CHtml::linkButton('Вернуться к проекту "' . $pname . '"', array('submit' => array('project', 'pid' => $pid)));
echo CHtml::beginForm('', 'post', array('id' => 'color'));
$this->widget('application.extensions.colorpicker.EColorPicker', 
              array(
                    'name'=>'Color[code]',
                    'mode'=>'textfield',
                    'fade' => false,
                    'slide' => false,
                    'curtain' => true,
                    'value' => $model->content->code
                   )
             );
echo CHtml::endForm();
echo CHtml::submitButton($label = 'Сохранить', array('form' => 'color'));