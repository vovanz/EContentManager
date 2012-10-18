<?php

class MyImage extends CActiveRecord {
    
   public function beforeDelete() {
       if('fid' != 0) $this->file->delete();
       return parent::beforeDelete();
  }
    
    
    public $cid;
    public $fid;
    public $iweight;
    public $alt;
    public $title;
    public $annotation;
    
    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function tablename() {
        return 'tbl_image';
    }

    public function primaryKey() {
        return 'fid';
    }
    
    public function attributeLabels() {
        $r = parent::attributeLabels();
        $r['annotation'] = 'Аннотация';
        $r['title'] = 'Название';
        
        return $r;
    }
    
    public function rules() {
        return array(
            array('alt', 'safe'),
            array('title', 'safe'),
            array('annotation', 'safe'),
            array('fid', 'safe'),
            array('iweight', 'safe')
        );
    }
    
    public function relations() {
        return array(
            'gallery' => array(self::BELONGS_TO, 'Gallery', 'cid'),
            'file' => array(self::HAS_ONE, 'File', 'fid')
        );
    }

}
