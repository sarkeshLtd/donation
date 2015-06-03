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
        return $this->viewListDonate($orm->exec('SELECT * FROM donation_history WHERE state=? ORDER BY date DESC',[1],SELECT));
    }
	
}
