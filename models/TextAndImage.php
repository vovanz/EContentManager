<?php

class TextAndImage extends ComponentType {

    public $image_pos; //положение картинки (поле в БД)
    public $text; //текст (поле в БД)
    public $_image; //вспомогательное свойство

    public function afterConstruct() {
        parent::afterConstruct();
        $this->component->ctype = 'textandimage';
    }

    public function afterSave() {
        if ($this->_image != null) {
            if (!$image = MyImage::model()->findByAttributes(array('fid' => $this->_image->fid))) {
                if($this->image != null) $this->image->delete();
                $image = new MyImage;
            }
            $image->attributes = $this->_image->attributes;
            $image->cid = $this->cid;
            $image->save();
        }
    }

    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function tablename() {
        return 'tbl_textandimage';
    }

    public function primaryKey() {
        return 'cid';
    }

    public function getAttributes($names = true) {
        $attr = parent::getAttributes($names);
        $attr['image'] = $this->image->attributes;
        return $attr;
    }

    public function setAttributes($values, $safeOnly = true) {
        $this->_image = new MyImage;
        if (isset($values['image'])) {
            $this->_image->attributes = $values['image'];
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function rules() {
        $rules = parent::rules();
        $rules[] = array('text', 'required');
        $rules[] = array('image_pos', 'safe');
        return $rules;
    }

    public function relations() {
        return array(
            'image' => array(self::HAS_ONE, 'MyImage', 'cid')
                ) + parent::relations();
    }

}