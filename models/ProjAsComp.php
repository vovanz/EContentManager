<?php

class ProjAsComp extends ComponentType {

	public function tablename() {
		return 'tbl_projascomp';
	}

	public public function rules() {
		$rules = parent::rules();
		$rules[] = array('proj_id', 'required');
		$rules[] = array('cid', 'unsafe');
		return $rules;
	}

}
