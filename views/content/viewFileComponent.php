<?php

echo '<div class="component file">';
if ($component->is_main && $component->is_main != 1) {
    echo '<h3>' . $component->is_main . '</h3>';
} else {
    echo '<h3>' . Yii::app()->modules['EContentManager']['project_types'][$component->project->ptype]['component_types'][$component->ctype] . '</h3>';
}
echo '<a target="blank" href="' . Yii::app()->controller->module->files_path . $content->file->fpath . '">Файл</a>(' . round($content->file->fsize / (1024 * 1024), 2) . ' мегабайт)<br/>';
echo CHtml::link('редактировать', array('EditComponent', 'pid' => $content->pid, 'cid' => $content->cid, 'ctype' => 'FileComponent'));
echo '</br>';
if (!$component->is_main)
    echo CHtml::link('удалить', array('DeleteComponent', 'cid' => $content->cid));
echo '</div>';
