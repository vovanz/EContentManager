<?php

class FileComponent extends ComponentType { 
    
    public function beforeSave() {
        return parent::beforeSave();
    }


    public function attributeNames() {
        $names=parent::attributeNames();
        $names[]='file';
        return $names;
    } 
    public function afterDelete() {
        parent::afterDelete();
       if($this->file != null) {
        $this->file->delete();
       }
    }
    public $fid;
    
    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function tablename() {
        return 'tbl_filecomp';
    }

    public function primaryKey() {
        return 'fid';
    }
    
    public function rules() {
        $rules=parent::rules();
        $rules[]=array('fid', 'required');
        return $rules;
    }
    public function relations() {
        return array(
            'file' => array(self::HAS_ONE, 'File', 'fid')
        )+parent::relations();
    }

}