<?php

abstract class ComponentType extends CActiveRecord {
    
    public function primaryKey() {
        return 'cid';
    }

    public $cid;
    
    public function getCname() {
        return $this->component->cname;
    }

    public function getPid() {
        return $this->component->pid;
    }
    
    public function getCweight() {
        return $this->component->cweight = $value;
    }

    public function getCtype() {
        return $this->component->ctype = $value;
    }

    public function setPid($value) {
        $this->component->pid = $value;
    }

    public function setCweight($value) {
        $this->component->cweight = $value;
    }

    public function setCtype($value) {
        $this->component->ctype = $value;
    }
    
    public function relations() {
        return array(
            'component' => array(self::BELONGS_TO, 'Component', 'cid')
        );
    }

}
