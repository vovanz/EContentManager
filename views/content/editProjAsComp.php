<?php echo CHtml::linkButton('Вернуться к проекту "' . $pname . '"', array('submit' => array('project', 'pid' => $pid))); ?>
<?php

echo CHtml::beginForm('', 'post', array('id' => 'text_and_image'));

echo CHtml::submitButton($label = 'Сохранить', array('form' => 'text_and_image'));