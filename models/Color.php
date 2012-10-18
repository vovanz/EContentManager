<?php

class Color extends ComponentType {

    public function tablename() {
        return 'tbl_color';
    }

    public function rules() {
        return array(
            array('code', 'safe')
        );
    }

}