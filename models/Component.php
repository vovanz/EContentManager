<?php

class Component extends CActiveRecord {

    public $pid; // id проекта к которому принадлежит компонент
    public $cid; // id компонента
    public $cweight; // сортировочный вес компонента
    public $ctype; // id типа компонента
    public $is_main; // если это клавный компонент, то id главного компонента, иначе false

    
    /*
	 * 
	 * 
	 */
    public function getType_config() {
        $type_config=Yii::app()->modules['EContentManager']['component_types'][$this->ctype];
        if(isset($this->pid) && isset(Yii::app()->modules['EContentManager']['project_types'][$this->project->ptype]['type_config'][$this->ctype])) {
            $type_config=Yii::app()->modules['EContentManager']['project_types'][$this->project->ptype]['type_config'][$this->ctype];
        }
        return $type_config;
    }

    public function getContent() {
        $type = $this->ctype;
        $content = $this->$type;
        return $content;
    }

    public function setContent($value) {
        $type = $this->ctype;
        $this->$type = $value;
    }

    public function afterSave() {
        $r = true;
        if (is_array($this->content)) {
            foreach ($this->content as $element) {
                $element->cid = $this->cid;
                $r = $r && $element->save();
            }
        } else {
            $this->content->cid = $this->cid;
            $r = $r && $this->content->save();
        }
        return $r && parent::afterSave();
    }

    public function afterDelete() {
        if (isset($this->content)) {
            if (is_array($this->content)) {
                foreach ($this->content as $a) {
                    $a->delete();
                }
            } else
                $this->content->delete();
        }
        parent::afterDelete();
    }

    public static function maxCWeight() {
        $criteria = new CDbCriteria();
        $criteria->order = 'cweight DESC';
        $c = self::model()->find($criteria);
        if (is_null($c->cweight)) {
            return 0;
        } else {
            return $c->cweight;
        }
    }

    public function attributeLabels() {
        return array(
            'ctype' => 'Тип компонента: '
        );
    }

    public function rules() {
        return array(
            array('ctype', 'required'),
        );
    }

    public function afterConstruct() {
        parent::afterConstruct();
        $this->cweight = $this->maxCWeight() + 1;
    }

    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function tablename() {
        return 'tbl_component';
    }

    public function primaryKey() {
        return 'cid';
    }

    public function relations() {
        $result = array(
            'project' => array(self::BELONGS_TO, 'Project', 'pid'),
        );
        foreach (Yii::app()->modules['EContentManager']['component_types'] as $key => $value) {
            $result[$key] = array(self::HAS_ONE, $key, 'cid');
        }
        return $result;
    }

}
