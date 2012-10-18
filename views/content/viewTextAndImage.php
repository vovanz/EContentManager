<?php

$p = new CHtmlPurifier();
$p->options = array(
    'HTML.Allowed' => $type_config['allowed_html']
);
echo '<div class="component textandimage">';
if ($component->is_main && $component->is_main != 1) {
    echo '<h3>' . $component->is_main . '</h3>';
} else {
    echo '<h3>'.Yii::app()->modules['EContentManager']['project_types'][$component->project->ptype]['component_types'][$component->ctype].'</h3>';
}
echo '<div class="content">';
if ($content->image_pos == 'left') {
    echo '<div class="image-container">';
    echo '<p>' . $content->image->title . '</p>';
    echo CHtml::image(Yii::app()->controller->module->files_path . $content->image->file->fpath, $content->image->alt, array('width' => '250px', 'class' => 'image'));
    echo '<p>Аннотация: ' . $content->image->annotation . '</p>';
    echo '</div>';
    echo '<div class="text">' . post_typo(typo($p->purify($content->text))) . '</div>';
} else {
    echo '<div class="text">' . post_typo(typo($p->purify($content->text))) . '</div>';
    echo '<div class="image-container">';
    echo '<p>' . $content->image->title . '</p>';
    echo CHtml::image(Yii::app()->controller->module->files_path . $content->image->file->fpath, $content->image->alt, array('width' => '250px', 'class' => 'image'));
    echo '<p>Аннотация: ' . $content->image->annotation . '</p>';
    echo '</div>';
}
echo '<div class="clear"></div>';
echo "</div>";
echo '<div class="clear"></div>';
echo CHtml::link('редактировать', array('EditComponent', 'pid' => $content->pid, 'cid' => $content->cid));
echo '<br/>';
if (!$component->is_main)
    echo CHtml::link('удалить', array('DeleteComponent', 'cid' => $content->cid));
echo '</div>';
