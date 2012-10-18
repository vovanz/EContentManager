<?php

class File extends CActiveRecord {

    public $fid;
    public $fpath;
    public $file;

    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function getFsize() {
        return filesize(Yii::app()->basePath . '/..' . Yii::app()->modules['EContentManager']['files_path'] . $this->fpath);
    }

    public function beforeSave() {
        if (isset($this->file)) {
            $fpath = $this->file->getName();
            $path_parts = pathinfo($fpath);
            $i = 1;
            $path_parts['filename'] = ContentController::translitIt($path_parts['filename']);
            $filename = $path_parts['filename'];
            while (file_exists(Yii::app()->basePath . '/..' . Yii::app()->modules['EContentManager']['files_path'] . $filename . '.' . $path_parts['extension'])) {
                $filename = $path_parts['filename'] . '_' . $i;
                $i++;
            }
            $fpath = $filename . '.' . $path_parts['extension'];
            $this->fpath = $fpath;
            $this->file->saveAs(Yii::app()->basePath . '/..' . Yii::app()->modules['EContentManager']['files_path'] . $fpath);
        }
        return parent::beforeSave();
    }

    public function afterSave() {
        parent::afterSave();
    }

    public function rules() {
        return array(
        );
    }

    public function afterDelete() {
        parent::afterDelete();
        if ($this->fpath != '')
            unlink(Yii::app()->basePath . '/..' . Yii::app()->modules['EContentManager']['files_path'] . $this->fpath);
    }

    public function tablename() {
        return 'tbl_file';
    }

    public function primaryKey() {
        return 'fid';
    }

    public function relations() {
        return array(
        );
    }

}
