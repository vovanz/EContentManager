<?php

echo '<div class="component image">';
if ($component->is_main && $component->is_main != 1) {
    echo '<h3>' . $component->is_main . '</h3>';
} else {
    echo '<h3>' . Yii::app()->modules['EContentManager']['project_types'][$component->project->ptype]['component_types'][$component->ctype] . '</h3>';
}
echo '<div class="image-container">';
echo '<p>' . $content->title . '</p>';
echo '<a target="_blank" href="' . Yii::app()->controller->module->files_path . $content->file->fpath . '">';
echo CHtml::image(ContentController::img($content->file->fpath, 'preview'), $content->alt, array('height' => '250px'));
echo '</a>';
echo '<p>Аннотация: ' . $content->annotation . '</p>';
echo '</div>';
echo CHtml::link('редактировать', array('EditComponent', 'pid' => $component->pid, 'cid' => $component->cid, 'ctype' => 'MyImage'));
echo '<br/>';
if (!$component->is_main)
    echo CHtml::link('удалить', array('DeleteComponent', 'cid' => $component->cid));
echo '</div>';