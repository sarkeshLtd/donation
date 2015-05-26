<?php
namespace addon\plugin\donation;
use core\cls\browser as browser;
use core\cls\network as network;
use core\cls\core as core;
use core\cls\db as db;

class module{
	use view;
	use addons;
	
	/*
	 * construct
	 */
	function __construct(){}
	
	//this function return back menus for use in admin area
	public static function coreMenu(){
		$menu = array();
		$url = core\general::createUrl(['service','administrator','load','donation','listAll']);
		array_push($menu,[$url, _('History')]);
		$url = core\general::createUrl(['service','administrator','load','donation','settings']);
		array_push($menu,[$url, _('Settings')]);
		$ret = [];
		array_push($ret, ['<span class="glyphicon glyphicon-heart-empty" aria-hidden="true"></span>' , _('donation')]);
		array_push($ret,$menu);
		return $ret;
	}
	
	/*
	 * show page for enter donation information
	 * @return 2D array [title,content]
	 */
	protected function moduleDonation(){
		return $this->viewDonation();
	}

    /**
     * run transaction result
     * @return void
     */
    public function result($sid){
        $orm = db\orm::singleton();
        if($orm->count('donation_history','transID=?',[$sid]) != 0){
            $donation = $orm->findOne('donation_history','transID=?',[$sid]);
            $donation->date = time();
            $donation->state = 1;
            $orm->store($donation);
        }
    }

    /*
	 * show list of people that has donate
	 * @return 2D array [title,content]
	 */
    protected function moduleListDonate(){
        $orm = db\orm::singleton();
        return $this->viewListDonate($orm->find('donation_history','state=?',[1]));
    }
	
}
