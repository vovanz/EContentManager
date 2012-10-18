<?php echo CHtml::linkButton('Вернуться к проекту "' . $pname . '"', array('submit' => array('project', 'pid' => $pid))); ?>
<?php

echo CHtml::beginForm('', 'post', array('id' => 'text_and_image'));
echo '<br/>';
echo CHtml::activeLabel($model->content, 'text');
echo '<br/>';
$cke_config=$type_config['ckeditor'];
$this->widget('application.extensions.eckeditor.ECKEditor', array(
    'model' => $model->content,
    'attribute' => 'text',
    'config' => $cke_config
));
echo '<br/>';
echo CHtml::error($model->content, 'text');
//echo CHtml::activeLabel($model, 'allowed');
//echo CHtml::activeTextField($model, 'allowed', array('style' => 'width: 600px;'));
echo CHtml::activeDropDownList($model->content, 'image_pos', array('left' => 'Картинка слева', 'right' => 'Картинка справа'));
echo '<ul id="image">';
if (isset($model->content->image))
    echo $this->renderPartial('editImage', array('image' => $model->content->image, 'fid' => $model->content->image->fid), $return = true);
echo '</ul>';
echo CHtml::endForm();
$this->widget('ext.EAjaxUpload.EAjaxUpload', array(
    'id' => 'uploadFile',
    'config' => array(
        'action' => Yii::app()->createUrl('EContentManager/content/upload', array('class' => 'TextAndImage')),
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



echo CHtml::submitButton($label = 'Сохранить', array('form' => 'text_and_image'));