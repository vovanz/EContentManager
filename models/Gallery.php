<?php

class Gallery extends ComponentType {

    protected $_images;
    public $gallery_type;

    public function beforeSave() {
        return CActiveRecord::beforeSave();
    }

    public function afterSave() {
        if (is_array($this->_images)) {
            foreach ($this->_images as $img) {
                if(!$image=MyImage::model()->findByAttributes(array('fid'=>$img->fid))) $image=new MyImage;
                $image->attributes=$img->attributes;
                $image->cid=$this->cid;
                $image->save();
                $fids[] = $image->fid;
            }
            foreach ($this->images as $image) {
                if (!in_array($image->fid, $fids)) {
                    $image->delete();
                }
            }
        }
        parent::afterSave();
    }

    public function tablename() {
        return 'tbl_gallery';
    }

    public function getAttributes($names = true) {
        $attr = parent::getAttributes($names);
        if (is_array($this->images)) {
            foreach ($this->images as $image) {
                $attr[$image->fid] = $image->attributes;
            }
        }
        return $attr;
    }

    public function rules() {
        return array(
          array('gallery_type', 'safe')  
        );
    }
    
    public function setAttributes($values, $safeOnly = true) {
        if (is_array($this->images)) {
            $i = 1;
            foreach ($values as $key => $value)
                if (is_numeric($key)) {
                    $image = new MyImage;
                    $image->iweight = $i++;
                    $image->fid = $key;
                    $image->attributes = $value;
                    $this->_images[] = $image;
                }
        }
        parent::setAttributes($values, $safeOnly);
    }

    public function relations() {
        return array(
            'images' => array(self::HAS_MANY, 'MyImage', 'cid', 'order' => 'iweight ASC'),
            'component' => array(self::BELONGS_TO, 'Component', 'cid'),
        );
    }

}