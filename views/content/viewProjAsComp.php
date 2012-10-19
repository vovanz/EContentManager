<?php

echo '<div class="component projascomp  ">';
if ($component->is_main && $component->is_main != 1) {
    echo '<h3>' . $component->is_main . '</h3>';
} else {
    echo '<h3>'.Yii::app()->modules['VisualEdit']['project_types'][$component->project->ptype]['component_types'][$component->ctype].'</h3>';
}
echo '<div class="content">';
if(isset($content->proj_id) && $content->proj_id!=null) {
	$proj=Project::model()->findByPk($content->proj_id);
    echo CHtml::link($proj->pname, array('content/project', 'pid' => $proj->pid));
}
echo "</div>";
echo '<div class="clear"></div>';
echo CHtml::link('редактировать', array('EditComponent', 'pid' => $content->pid, 'cid' => $content->cid));
echo '<br/>';
if (!$component->is_main)
    echo CHtml::link('удалить', array('DeleteComponent', 'cid' => $content->cid));
echo '</div>';
