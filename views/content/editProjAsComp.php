<?php echo CHtml::linkButton('Вернуться к проекту "' . $pname . '"', array('submit' => array('project', 'pid' => $pid))); ?>
<?php

echo CHtml::beginForm('', 'post', array('id' => 'proj_as_comp'));
$projs=array();
foreach(Project::model()->findAll() as $proj) {
	$projs[$proj->pid]=$proj->pname;
}
echo CHtml::activeDropDownList($model->content, 'proj_id', $projs);
echo CHtml::submitButton($label = 'Сохранить', array('form' => 'proj_as_comp'));