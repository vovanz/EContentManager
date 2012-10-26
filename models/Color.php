<?php

class Color extends ComponentType {

	public $code; //Код цвета (строка).

    public function tablename() {
        return 'tbl_color';
    }

    public function rules() {
        return array(
            array('code', 'safe')
        );
    }

}