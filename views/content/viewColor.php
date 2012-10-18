<?php

echo '<div class="component color">';
if ($component->is_main && $component->is_main != 1) {
    echo '<h3>' . $component->is_main . '</h3>';
} else {
    echo '<h3>' . Yii::app()->modules['EContentManager']['project_types'][$component->project->ptype]['component_types'][$component->ctype] . '</h3>';
}
echo '<div style="height: 50px; width: 150px; background-color: #' . $content->code . ';">';
echo '</div>';
echo CHtml::link('редактировать', array('EditComponent', 'pid' => $content->pid, 'cid' => $content->cid, 'ctype' => 'Color'));
echo '</br>';
if (!$component->is_main)
    echo CHtml::link('удалить', array('DeleteComponent', 'cid' => $content->cid));
echo '</div>';