<?php
namespace addon\plugin\donation;
use \core\cls\core as core;
use \core\cls\browser as browser;


class action extends module{
	use view;
	/*
	 * construct
	 */
	function __construct(){
		parent::__construct();
	}
	
	/*
	 * show page for enter donation information
	 * @return 2D array [title,content]
	 */
    public function donation(){
        return $this->moduleDonation();
    }

    /*
	 * show list of people that has donate
	 * @return 2D array [title,content]
	 */
    public function listDonate(){
        return $this->moduleListDonate();
    }
}
