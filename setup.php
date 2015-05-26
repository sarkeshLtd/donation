<?php
namespace addon\plugin\donation;
use \core\cls\core as core;
use \core\cls\db as db;
class setup{

	/*
	 * function for setup plugin
	 */
	public function install(){
        $orm = db\orm::singleton();
        $query = "CREATE TABLE IF NOT EXISTS `donation_history` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `amount` varchar(20) NOT NULL,
  `des` varchar(500) NOT NULL, 
  `transID` varchar(32) NOT NULL, 
  `state` varchar(2) NOT NULL, 
  `date` varchar(12) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;";
        @$orm->exec($query,[],NON_SELECT);
        
        //save registry keys
        $registry =  core\registry::singleton();
        $registry->newKey('donation','acceptInfo','Payment accepter');


    }
}