<?php

$str_js = "
        var fixHelper = function(e, ui) {
            ui.children().each(function() {
                $(this).width($(this).width());
            });
            return ui;
        };
 
        $('#project-grid table.items tbody').sortable({
            forcePlaceholderSize: true,
            forceHelperSize: true,
            items: 'tr',
            update : function () {
                serial = $('#project-grid table.items tbody').sortable('serialize', {key: 'items[]', attribute: 'class'});
                $.ajax({
                    'url': '" . $this->createUrl("/EContentManager/content/sort/") . "',
                    'type': 'post',
                    'data': serial,
                    'success': function(data){
                    },
                    'error': function(request, status, error){
                        alert('We are unable to set the sort order at this time.  Please try again in a few minutes.');
                    }
                });
            },
            helper: fixHelper
        }).disableSelection();
    ";

Yii::app()->clientScript->registerScript('sortable-project', $str_js);
?>
<?php

$this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'project-grid',
    'rowCssClassExpression'=>'"items[]_{$data->pid}"',
    'enableSorting' => false,
    'dataProvider' => $projects,
    'columns' => array(
        'pname',
        
        'human_ptype',
        array(
            'header' => 'Дата создания',
            'value' => 'ContentController::rus_date("d F Y",$data->ptime)'
        ),
        array(
            'value' => '$data->pweight',
            'visible' => false,
        ),
        array(
            'value' => '$data->pid',
            'visible' => false,
        ),
        array(// display a column with "view", "update" and "delete" buttons
            'class' => 'CButtonColumn',
            'buttons' => array(
                'view' => array(
                    'visible' => 'false'
                ),
                'update' => array(
                    'url' => 'Yii::app()->createUrl(Yii::app()->baseUrl . "/EContentManager/content/project/", array("pid" => $data->pid))'
                ),
                'delete' => array(
                    'url' => 'Yii::app()->createUrl(Yii::app()->baseUrl . "/EContentManager/content/deleteProject/", array("pid" => $data->pid, "delete" => "yes"))'
                )
            )
        ),
    )
));
