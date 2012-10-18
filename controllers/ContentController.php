<?php

/**
 * Main controller for EContentManager
 * 
 * @author VovanZ 
 */
class ContentController extends CController {

    /**
     * use CController documentation
     * 
     * @return boolean
     */
    protected function beforeAction() {
        Yii::app()->getClientScript()->registerCssFile('/styles/admin.css');
        Yii::app()->getClientScript()->registerCoreScript('jquery');
        Yii::app()->getClientScript()->registerCoreScript('jquery.ui');
        Yii::app()->getClientScript()->registerScriptFile('/js/jquery.form.js');
        Yii::app()->getClientScript()->registerScriptFile('/js/script.js');
        return true;
    }

    /**
     * use CController documentation
     * 
     * @var string
     */
    public $defaultAction = 'projectsList';

    /**
     * Alias for Yii::app()->rusDate->date()
     * 
     * @return string 
     */
    public static function rus_date() {
        if (func_num_args() > 1) {
            $timestamp = func_get_arg(1);
            return Yii::app()->rusDate->date(func_get_arg(0), $timestamp);
        } else {
            return Yii::app()->rusDate->date(func_get_arg(0));
        }
    }

    /**
     * Alias for Yii::app()->imagePresets->img($fpath, $type)
     * 
     * @param type $fpath
     * @param type $type
     * @return type 
     */
    public static function img($fpath, $type) {
        return Yii::app()->imagePresets->img($fpath, $type);
    }

    public function actionProjectsList() {
        $criteria = new CDbCriteria();
        if (isset($_GET['ptype'])) {
            $criteria->condition = 'ptype = "' . $_GET['ptype'] . '"';
        }
        $criteria->order = 'pweight ASC';
        $projects = new CActiveDataProvider('Project', array(
                    'criteria' => $criteria,
                    'pagination' => array(
                        'pageSize' => 20,
                    ),
                ));
        $this->render('projectsList', array('projects' => $projects));
    }

    public function actionProject() {
        if (isset($_POST['order'])) {
            $order = explode(',', $_POST['order']);
            $cweight = 1;
            foreach ($order as $element) {
                $component = Component::model()->findByPk($element);
                $component->cweight = $cweight;
                $component->save();
                $cweight++;
            }
        }
        if (isset($_GET['pid']) && $project = Project::model()->findByPk($_GET['pid'])) {
            $pid = $_GET['pid'];
            if (isset($_POST['Component'])) {
                $model = new Component;
                $model->attributes = $_POST['Component'];
                if ($model->validate()) {
                    $this->redirect(array('EditComponent', 'ctype' => $model->ctype, 'pid' => $pid, 'cid' => 'new'));
                }
            }
            if (isset($_POST['Project'])) {
                $project->pname = $_POST['Project']['pname'];
                $project->save();
            }
        } else {
            if (isset($_GET['ptype'])) {
                $ptype = $_GET['ptype'];
                $project = Project::create_new($ptype);
                $this->redirect(array('project', 'pid' => $project->pid));
            } else {
                $this->redirect(Yii::app()->baseUrl . '/admin');
            }
        }
        $model = new Component;
        $components = $project->components;
        $this->render('project', array(
            'model' => $model,
            'components' => $components,
            'pname' => $project->pname,
            'pid' => $project->pid,
            'project_model' => $project));
    }

    public function actionDeleteProject() {
        if (isset($_GET['pid'])) {
            $pid = $_GET['pid'];
        } else {
            $pid = $this->getPageState('pid');
        }
        $project = Project::model()->findByPk($pid);
        $this->setPageState('pid', $pid);
        $pid = $_GET['pid'];
        $project = Project::model()->findByPk($pid);
        if (isset($_POST['yes']) || (isset($_GET['delete']) && $_GET['delete'] == 'yes')) {
            $project->delete();
            $this->redirect(array('ProjectsList'));
        }
        if (isset($_POST['no'])) {
            $this->redirect(array('Project', 'pid' => $pid));
        }
        $this->render('areYouSure', array('something' => 'проект "' . $project->pname . '" и все его компоненты'));
    }

    public function actionDeleteComponent() {
        if (isset($_GET['cid'])) {
            $cid = $_GET['cid'];
        } else {
            $cid = $this->getPageState('cid');
        }
        $component = Component::model()->findByPk($cid);
        $this->setPageState('cid', $cid);
        $cid = $_GET['cid'];
        $component = Component::model()->findByPk($cid);
        if ($component->is_main) {
            $this->redirect(array('Project', 'pid' => $component->pid));
        }
        if (isset($_POST['yes'])) {
            $component->delete();
            $this->redirect(array('Project', 'pid' => $component->pid));
        }
        if (isset($_POST['no'])) {
            $this->redirect(array('Project', 'pid' => $component->pid));
        }

        $this->render('areYouSure', array('something' => 'компонент'));
    }

    public function actionEditComponent() {
        $pid = $_GET['pid'];
        $project = Project::model()->findByPk($pid);
        if (isset($_GET['cid']) && $_GET['cid'] != 'new') {
            $cid = $_GET['cid'];
            $model = Component::model()->findByPk($cid);
            $ctype = $model->ctype;
        } else {
            $ctype = $_GET['ctype'];
            $model = new Component;
            $model->pid = $pid;
            $model->ctype = $ctype;
            $model->content = new $ctype;
        }
        if (isset($_POST[$ctype])) {
            $model->content->attributes = $_POST[$ctype];
            if ($model->save()) {
                $this->redirect(array('Project', 'pid' => $pid));
            }
        }
        $this->render('edit' . $ctype, array('model' => $model, 'pid' => $project->pid, 'pname' => $project->pname, 'type_config' => $model->type_config));
    }

    public function actionGarbage() {
        $i = 0;
        $mb = 0;
        $files = File::model()->findAll('', array());
        foreach ($files as $file) {
            if (FileComponent::model()->findByPk($file->fid) == null && MyImage::model()->findByPk($file->fid) == null) {
                $mb+=$file->fsize / (1024 * 1024);
                $file->delete();
                $i++;
            }
        }
        $this->redirect(array('ProjectsList', 'garbage' => $i . ' file(s) (' . round($mb, 2) . 'MB) deleted'));
    }

    public function actionGarbage2() {
        $i = 0;
        $mb = 0;
        $files = scandir(Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path);
        foreach ($files as $file)
            if ($file != '.' && $file != '..') {
                if (is_dir(Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path . $file)) {
                    $files_ = CFileHelper::findFiles(Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path . $file, array('level' => -1));
                    foreach ($files_ as $file_) {
                        $path_parts = pathinfo($file_);
                        $mb+=filesize($file_) / (1024 * 1024);
                        unlink($file_);
                        $i++;
                    }
                } else if (File::model()->findAllByAttributes(array('fpath' => $file)) == null) {
                    $mb+=filesize(Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path . $file) / (1024 * 1024);
                    unlink(Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path . $file);
                    $i++;
                }
            }
        $this->redirect(array('ProjectsList', 'garbage2' => $i . ' file(s) (' . round($mb, 2) . 'MB) deleted'));
    }

    public function actionUpload() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");

        $folder = Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path; // folder for uploaded files
        $allowedExtensions = array("jpg", "jpeg", "gif", "png"); //array("jpg","jpeg","gif","exe","mov" and etc...
        $sizeLimit = 100 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $file = new File;
        $file->fpath = $result['filename'];
        $file->save();
        $image = new MyImage;
        $image->fid = $file->fid;
        $image->file = $file;
        $result['debug'] = $result['filename'];
        $result['html_append'] = $this->renderPartial('editImage', array('image' => $image, 'fid' => $file->fid, 'class' => $_GET['class']), $return = true);
        $result['filename'] = htmlspecialchars($result['filename'], ENT_NOQUOTES);
        $result = json_encode($result);
        echo $result; // it's array
    }

    public function actionUploadFile() {
        Yii::import("ext.EAjaxUpload.qqFileUploader");
        $allowedExtensions = array("jpg", "jpeg", "gif", "png", "doc", "docx", "xls", "xlsx", "mp3");
        $folder = Yii::app()->basePath . '/..' . Yii::app()->controller->module->files_path; // folder for uploaded files
        $sizeLimit = 100 * 1024 * 1024; // maximum file size in bytes
        $uploader = new qqFileUploader($allowedExtensions, $sizeLimit);
        $result = $uploader->handleUpload($folder);
        $file = new File;
        $file->fpath = $result['filename'];
        $file->save();
        $result['debug'] = $result['filename'];
        $content = new FileComponent;
        $result['html_append'] = $this->renderPartial('editFile', array('content' => $content, 'file' => $file, 'fid' => $file->fid, 'class' => $_GET['class']), $return = true);
        $result['filename'] = htmlspecialchars($result['filename'], ENT_NOQUOTES);
        $result = json_encode($result);
        echo $result; // it's array
    }

    public function actionSort() {
        if (isset($_POST['items']) && is_array($_POST['items'])) {
            $i = 0;
            foreach ($_POST['items'] as $item) {
                $project = Project::model()->findByPk($item);
                $project->pweight = $i;
                $project->save();
                $i++;
            }
        }
    }

}

