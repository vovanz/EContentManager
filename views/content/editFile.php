<?php
echo '<a target="blank" href="'.Yii::app()->controller->module->files_path.$file->fpath.'">Файл</a>('.  round($file->fsize/(1024*1024), 2).' мегабайт)<br/>'; 
echo CHtml::activeHiddenField($content, 'fid', array('value' => $fid));