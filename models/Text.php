<?php

class Text extends ComponentType {

    public $text;

    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function tablename() {
        return 'tbl_text';
    }

    public function primaryKey() {
        return 'cid';
    }

    public function attributeLabels() {
        $r = parent::attributeLabels();
        $r['text'] = 'Текст';
        return $r;
    }

    public function rules() {
        $rules = parent::rules();
        $rules[] = array('text', 'required');
        $rules[] = array('cid', 'unsafe');     
        return $rules;
    }

    public function relations() {
        return array(
                ) + parent::relations();
    }

}
