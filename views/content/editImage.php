<?php
$prefix=$class."[$fid]";
if($class == 'MyImage') {
    $prefix='MyImage';
}
if($class == 'TextAndImage') {
    $prefix='TextAndImage[image]';
}

echo '<li>';
echo CHtml::activeLabel($image, "title");
echo CHtml::textField($prefix."[title]", $image->title);
echo CHtml::activeLabel($image, "[$fid]alt");
echo CHtml::textField($prefix."[alt]", $image->alt);
echo CHtml::activeLabel($image, "[$fid]annotation");
echo CHtml::textField($prefix."[annotation]", $image->annotation);
echo CHtml::hiddenField($prefix."[fid]", $fid);
echo '<br/>';
echo '<a target="_blank" href="'.Yii::app()->controller->module->files_path .$image->file->fpath.'">';
echo CHtml::image(ContentController::img($image->file->fpath, 'preview'), $image->alt, array('height' => '250px'));
echo '</a>';
echo CHtml::button('Удалить', array('class' => 'delete-img'));
echo '</li>';