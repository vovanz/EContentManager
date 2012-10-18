<?php echo CHtml::link('Вернуться к проекту "' . $pname . '"', array('project', 'pid' => $pid)); ?>
<div class="form">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'id' => 'text-editText-form',
        'enableAjaxValidation' => false,
            ));
    ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>

    <?php echo $form->errorSummary($model); ?>


    <div class="row">
        <?php echo $form->labelEx($model->Text, 'text'); ?>
        <?php
        $cke_config=$type_config['ckeditor'];
        $this->widget('application.extensions.eckeditor.ECKEditor', array(
            'model' => $model->Text,
            'attribute' => 'text',
            'config' => $cke_config
        ));
        ?>
        <?php //echo $form->error($model->Text, 'text'); ?>
    </div>

    <!--	<div class="row">
    <?php //echo $form->labelEx($model->Text,'allowed');  ?>
    <?php //echo $form->textField($model->Text,'allowed', array('style' => 'width: 600px;'));  ?>
            </div>-->



    <div class="row buttons">
        <?php echo CHtml::submitButton('Сохранить'); ?>
    </div>

    <?php $this->endWidget(); ?>

</div><!-- form -->