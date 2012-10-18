<?php echo CHtml::linkButton('Вернуться к проекту "'.$pname.'"', array('submit' => array('project', 'pid' => $pid))); ?>
<?php
echo CHtml::beginForm('', 'post', array('id' => 'gallery'));
echo CHtml::activeDropDownList($model->Gallery, 'gallery_type', $type_config['types']);
echo '<ul id="images">';
if(is_array($model->Gallery->images)) {
    foreach($model->Gallery->images as $image) {
        echo $this->renderPartial('editImage', array('image' => $image, 'fid' => $image->fid, 'class' => 'Gallery'), $return=true);
    }
}
echo '</ul>';
echo CHtml::endForm();
$this->widget('ext.EAjaxUpload.EAjaxUpload', array(
    'id' => 'uploadFile',
    'config' => array(
        'action' => Yii::app()->createUrl('EContentManager/content/upload', array('class' => 'Gallery')),
        'allowedExtensions' => $allowedExtensions = array("jpg", "jpeg", "gif", "png"), //array("jpg","jpeg","gif","exe","mov" and etc...
        'sizeLimit' => 100 * 1024 * 1024, // maximum file size in bytes
        'minSizeLimit' => 0 * 1024 * 1024, // minimum file size in bytes
        'onComplete' => "js:function(id, fileName, responseJSON){ $('#images').append(
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



echo CHtml::submitButton($label='Сохранить', array('form' => 'gallery'));
echo CHtml::resetButton($label='Сбросить', array('form' => 'gallery'));