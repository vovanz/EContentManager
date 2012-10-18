<?php echo CHtml::linkButton('Вернуться к проекту "'.$pname.'"', array('submit' => array('project', 'pid' => $pid))); ?>
<?php
echo CHtml::beginForm('', 'post', array('id' => 'my_image'));
echo '<ul id="image">';
if(isset($model->MyImage)) echo $this->renderPartial('editImage', array('image' => $model->MyImage, 'fid' => $model->MyImage->fid, 'class' => 'MyImage'), $return=true);
echo '</ul>';
echo CHtml::endForm();
$this->widget('ext.EAjaxUpload.EAjaxUpload', array(
    'id' => 'uploadFile',
    'config' => array(
        'action' => Yii::app()->createUrl('EContentManager/content/upload', array('class' => 'MyImage')),
        'allowedExtensions' => $allowedExtensions = array("jpg", "jpeg", "gif", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
        'sizeLimit' => 100 * 1024 * 1024, // maximum file size in bytes
        'minSizeLimit' => 0 * 1024 * 1024, // minimum file size in bytes
        'onComplete' => "js:function(id, fileName, responseJSON){ $('#image').html(
            responseJSON['html_append']);
            $('.delete-img').click(function() {
                $(this).parent().remove();
            })}",
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



echo CHtml::submitButton($label='Сохранить', array('form' => 'my_image'));
echo CHtml::resetButton($label='Сбросить', array('form' => 'my_image'));