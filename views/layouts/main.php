<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml"> 
    <head>
        <title>Управление сайтом</title>   
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" /> 
    </head>
    <body>    
        <div id="header">
            <div id="logo-wrapper">
            </div>
            <a href="<?= Yii::app()->baseUrl . '/EContentManager' ?>"><div id="header-title">
                    система управления сайтом
                </div></a>
            <div class="clear"></div>
        </div>

        <div id="menu">
            <?php
            $items = array();
            foreach (Yii::app()->controller->module->project_types_list as $key => $value) {
                if (isset(Yii::app()->controller->module->project_types[$key]['max_count']) &&
                        Yii::app()->controller->module->project_types[$key]['max_count'] == 1) {
                    if(Yii::app()->controller->module->project_types[$key]['max_count'] > Project::model()->countByAttributes(array('ptype' => $key))) {
                       $items[] = array('label' => $value, 'url' => array(Yii::app()->baseUrl . '/EContentManager/content/project', 'ptype' => $key)); 
                    } else {
                        $items[] = array('label' => $value, 'url' => array(Yii::app()->baseUrl . '/EContentManager/content/project', 'pid' => Project::model()->findByAttributes(array('ptype' => $key))->pid));
                    }
                } else {
                    $items_ = array();
                    if (!isset(Yii::app()->controller->module->project_types[$key]['max_count']) ||
                            Yii::app()->controller->module->project_types[$key]['max_count'] <= Project::model()->countByAttributes(array('ptype' => $key))) {
                        $items_[] = array('label' => 'Добавить', 'url' => array(Yii::app()->baseUrl . '/EContentManager/content/project', 'ptype' => $key));
                    }
                    $items[] = array('label' => $value, 'url' => array(Yii::app()->baseUrl . '/EContentManager/content/projectsList', 'ptype' => $key), 'items' => $items_);
                }
            }
            //$items[] = array('label' => 'Выход', 'url' => array(Yii::app()->baseUrl . '/EContentManager/content/logout'));
            $this->widget('zii.widgets.CMenu', array(
                'items' => $items,
                //'itemCssClass' => 'menu-link',
                'activeCssClass' => 'active-link',
                'activateParents' => true,
                'htmlOptions' => array(
                    'class' => 'mainMenu'
                )
            ));
            ?>
        </div>        



        <div id="content">
            <?php echo $content; ?>
        </div>
        <div class="clear"></div>
    </body>

</html>