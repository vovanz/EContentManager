<?php

/**
 * Module for content management.
 *  
 * @author VovanZ
 */
class EContentManagerModule extends CWebModule {

    /**
     * Path where uploaded files are saved (for FileComponent).
     * 
     * @var string 
     */
    public $files_path;

    /**
     * List of component types.
     * Structure:
     * "<component type id>" => array(
     *  <params>
     * )
     * 
     * Example:
     * 'Text' => array(
     *      'allowed_html' => 'p, span, br, a[href], strong, b, i, em, u, strike, ul, ol, li, h2, h3, h4, h5, h6, table[cellpadding|cellspacing], tr, td, dfn, dl, dt, dt',
     *      'ckeditor' => array(
     *           'format_tags' => 'p;h2;h3;h4;h5;h6',
     *           'toolbar' => array(
     *               array('Source', '-', 'Bold', 'Italic', 'Underline', 'Strike', 'Format'),
     *               array('NumberedList', 'BulletedList',),
     *               array('Link', 'Unlink'),
     *               array('Table'),
     *            ),
     *           'width' => '1000px',
     *           'height' => '400px',
     *      ),
     * ),
     * 
     * @var array 
     */
    public $component_types;

    /**
     * List of project types.
     * Structure:
     * "<project type id>" => array(
     * <params>
     * )
     * 
     * Params:
     * name string - project type name.
     * component_types array - array('<component type id>' => '<component type name>') - list of availeble components (for this project type). 
     * @var array 
     */
    public $project_types;
    
    /**
     * use CWebModule documentation
     * @var string 
     */
    public $defaultController = 'content';

    /**
     * use CWebModule documentation
     * @var string 
     */
    public $layout = 'main';

    /**
     * use CWebModule documentation
     * @return void 
     */
    protected function init() {
        Yii::import('ext.' . $this->id . '.models.*');
    }

    /**
     * Returns array('<project type id>' => '<project type name>')
     * @return array 
     */
    public function getProject_types_list() {
        $list = array();
        foreach ($this->project_types as $key => $value) {
            $list[$key] = $value['name'];
        }
        return $list;
    }

}