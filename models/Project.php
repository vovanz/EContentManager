<?php

class Project extends CActiveRecord {

    /**
     * Project id
     * 
     * @var unsigned integer 
     */
    public $pid;
    
    /**
     * Project name
     * 
     * @var string 
     */
    public $pname;
    
    /**
     * Project sorting weight
     * 
     * @var integer 
     */
    public $pweight;
    
    /**
     * unixtime of creating project
     * 
     * @var integer 
     */
    public $ptime;
    
    /**
     * Project type id
     * 
     * @var string 
     */
    public $ptype;

    /**
     * Creates new project and its main components.
     * 
     * @param type $ptype
     * @return \self 
     */
    public static function create_new($ptype) {
        $project = new self;
        $project->ptype = $ptype;
        $project->ptime=time();
        $project->save();
        foreach (Yii::app()->modules['EContentManager']['project_types'][$ptype]['main_components'] as $comp) {
            $component = new Component;
            if($comp['name']) {
                $component->is_main = $comp['name'];
            } else {
                $component->is_main = 1;
            }
            $component->pid = $project->pid;
            $component->ctype = $comp['ctype'];
            $component->content = new $comp['ctype'];
            $component->content->attributes = $comp['attributes'];
            $component->cweight = $cweight++;
            $component->save();
        }
        $project->save();
        return $project;
    }

    public function getHuman_ptype() {
        return Yii::app()->modules['EContentManager']['project_types'][$this->ptype]['name'];
    }
    
    public function getMain_components() {
        $ptype = $this->ptype;
        $main_components = array();
        foreach ($this->components as $component) {
            if ($component->is_main) {
                $main_components[] = $component->content;
            }
        }
        $result = array();
        $i = 0;
        foreach (Yii::app()->modules['EContentManager']['project_types'][$ptype]['main_components'] as $name => $comp) {
            $result[$name] = $main_components[$i++];
        }
        return $result;
    }

    public function rules() {
        return array(
            array('ptype', 'required'),
            array('pweight', 'numerical', 'integerOnly'=>true),
        );
    }

    public function afterSave() {
        parent::afterSave();
    }

    public function afterDelete() {
        foreach ($this->components as $component) {
            $component->delete();
        }
        parent::afterDelete();
    }

    public static function maxPWeight() {
        $criteria = new CDbCriteria();
        $criteria->order = 'pweight DESC';
        $c = self::model()->find($criteria);
        if (is_null($c->pweight)) {
            return 0;
        } else {
            return $c->pweight;
        }
    }

    public function attributeLabels() {
        return array('pname' => 'Название проекта: ', 'ptype' => 'Тип проекта: ', 'human_ptype' => 'Тип проекта: ', );
    }

    public static function model($classname = __CLASS__) {
        return parent::model($classname);
    }

    public function tablename() {
        return 'tbl_project';
    }

    public function primaryKey() {
        return 'pid';
    }

    public function relations() {
        return array(
            'components' => array(self::HAS_MANY, 'Component', 'pid', 'order' => 'components.cweight ASC'),
        );
    }

}

