<?php
echo '<h1>Редактирование проекта "' . $pname . '"</h1>';
echo CHtml::beginForm(array('Project', 'pid' => $pid));
echo CHtml::activeLabel($project_model, 'pname');
echo CHtml::activeTextField($project_model, 'pname', '');
echo '<br />';
echo CHtml::submitButton('Сохранить');
echo CHtml::endForm();
echo '<h2>Главные компоненты</h2>';
echo '<ul id="main_components">';
if (is_array($components))
    foreach ($components as $component) if($component->is_main) {
        echo '<li id=' . $component->cid . '>';
        $type = $component->ctype;
        echo $this->renderPartial('view' . $type, array('content' => $component->content, 'component' => $component, 'type_config' => $component->type_config), $return = true);
        echo '</li>';
    }
echo '</ul>';
if(is_array(Yii::app()->controller->module->project_types[$project_model->ptype]['component_types'])) {
echo '<h2>Компоненты</h2>';
echo CHtml::beginForm();
echo '<p class="order-msg" id="order-msg1">Порядок не изменен</p>';
echo CHtml::submitButton($label = 'Сохранить порядок', array('class' => 'sort', 'id' => 'sort1', 'disabled' => 'disabled'));
echo '<ul id="components">';
if (is_array($components))
    foreach ($components as $component) if(!$component->is_main) {
        echo '<li id=' . $component->cid . '>';
        $type = $component->ctype;
        echo $this->renderPartial('view' . $type, array('content' => $component->content, 'component' => $component, 'type_config' => $component->type_config), $return = true);
        echo '</li>';
    }
echo '</ul>';
echo CHtml::hiddenField('order');
?><div class="row"><?php
echo CHtml::submitButton($label = 'Сохранить порядок', array('class' => 'sort', 'id' => 'sort2', 'disabled' => 'disabled'));
echo '<p class="order-msg" id="order-msg2">Порядок не изменен</p>';
echo CHtml::endForm();
?></div><?php
echo CHtml::beginForm();
echo CHtml::activeLabel($model, 'ctype');
echo CHtml::activeDropDownList($model, 'ctype', Yii::app()->controller->module->project_types[$project_model->ptype][component_types]);
echo CHtml::submitButton($label = 'Добавить');
echo CHtml::endForm();
}
echo CHtml::beginForm(array('DeleteProject', 'pid' => $pid));
echo CHtml::submitButton('Удалить проект');
echo CHtml::endForm();