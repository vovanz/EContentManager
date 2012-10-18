<?php 
echo CHtml::linkButton('Вернуться к проекту "'.$pname.'"', array('submit' => array('project', 'pid' => $pid)));
echo CHtml::beginForm('', 'post', array('id' => 'file_component'));
echo '<div id="files">';
if($model->FileComponent->file != null) echo $this->renderPartial('editFile', array('content' => $model->content,'file' => $model->FileComponent->file, 'fid' => $model->FileComponent->fid, 'class' => 'FileComponent'), $return=true);
echo '</div>';
echo CHtml::endForm();
$this->widget('ext.EAjaxUpload.EAjaxUpload', array(
    'id' => 'uploadFile',
    'config' => array(
        'action' => Yii::app()->createUrl('EContentManager/content/uploadFile', array('class' => 'FileComponent')),
        'allowedExtensions' => $allowedExtensions = array("jpg", "jpeg", "gif", "png", "doc", "docx", "xls", "xlsx", "mp3"),
        'sizeLimit' => 100 * 1024 * 1024, // maximum file size in bytes
        'minSizeLimit' => 0 * 1024 * 1024, // minimum file size in bytes
        'onComplete' => "js:function(id, fileName, responseJSON){ $('#files').html(
            responseJSON['html_append']);}",
        'messages' => array(
            'typeError' => "{file} has invalid extension. Only {extensions} are allowed.",
            'sizeError' => "{file} is too large, maximum file size is {sizeLimit}.",
            'minSizeError' => "{file} is too small, minimum file size is {minSizeLimit}.",
            'emptyError' => "{file} is empty, please select files again without it.",
            'onLeave' => "The files are being uploaded, if you leave now the upload will be cancelled."
        ),
        'showMessage' => "js:function(message){ alert(message); }"
    )
));



echo CHtml::submitButton($label='Сохранить', array('form' => 'file_component'));
echo CHtml::resetButton($label='Сбросить', array('form' => 'file_component'));