<p> Вы действительно хотите удалить <?=$something?>?</p>
<?php
echo CHtml::statefulForm();
echo CHtml::beginForm();
echo CHtml::submitButton('Да', array('name'=>'yes'));
echo CHtml::submitButton('Отмена', array('name'=>'no'));
echo CHtml::endForm();