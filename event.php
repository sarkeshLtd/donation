<?php
namespace addon\plugin\donation;
use \core\cls\browser as browser;
use \core\cls\core as core;
use \core\cls\db as db;

class event extends module{
	use \addon\plugin\payment\addons;
	/*
	 * clear php errors
	 * @param array $e, form properties
	 * @return array, form properties
	 */
	public function btnOnclickPayment($e){
		if($e['txtName']['VALUE'] == '' || $e['txtEmail']['VALUE'] == '' || $e['txtAmount']['VALUE'] == '')
            return browser\msg::modalNotComplete($e);
        elseif(! \core\data\type::isEmail($e['txtEmail']['VALUE']))
            return browser\msg::modalEmailFormatError($e);
        elseif(! \core\data\type::isNumber($e['txtAmount']['VALUE']))
            return browser\msg::modalValueNotNumber($e,'txtAmount');
        elseif($e['txtAmount']['VALUE'] < 1000)
            return browser\msg::modal($e,_('Warning'),_('1000 Rials is lowest.please enter more that this amount.'),'warning');
        
        //ALL IS GOOD GOING TO SAVE AND JUMP TO PAYMENT PLUGIN
        $orm = db\orm::singleton();
        $transaction = $orm->dispense('donation_history');
        $transaction->name = $e['txtName']['VALUE'];
        $transaction->email = $e['txtEmail']['VALUE'];
        $transaction->des = $e['txtDes']['VALUE'];
        $transaction->amount = $e['txtAmount']['VALUE'];
        $transaction->transID = $this->newPayment('donation','result',$e['txtAmount']['VALUE'],$e['txtName']['VALUE']);
        $transaction->state = 0;
        $transaction->date = 0;
        $orm->store($transaction);
        $e['RV']['URL'] = core\general::createUrl(['payment','showInfo','donation','result',$transaction->transID]);
        return $e;
	}
}
