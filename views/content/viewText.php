<?php

$p = new CHtmlPurifier();
$p->options = array(
    'HTML.Allowed' => $type_config['allowed_html']
);
echo '<div class="component text">';
if ($component->is_main && $component->is_main != 1) {
    echo '<h3>' . $component->is_main . '</h3>';
} else {
    echo '<h3>' . Yii::app()->modules['EContentManager']['project_types'][$component->project->ptype]['component_types'][$component->ctype] . '</h3>';
}
echo '<div class="text">' . post_typo(typo($p->purify($content->text))) . '</div>';
echo CHtml::link('редактировать', array('EditComponent', 'pid' => $component->pid, 'cid' => $component->cid, 'ctype' => 'Text'));
echo '</br>';
if (!$component->is_main)
    echo CHtml::link('удалить', array('DeleteComponent', 'cid' => $component->cid));
echo '</div>';