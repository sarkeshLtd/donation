<?php
namespace addon\plugin\donation;
use \core\control as control;
use \core\cls\core as core;

trait view {
	
    /*
	 * show page for enter donation information
	 * @return 2D array [title,content]
	 */
	protected function viewDonation(){
	   $form = new control\form('frmDoantionDonation');
       $lblName = new control\label(_('Thanks for your help.We can accept payment cards that work in shetab network.'));
       $form->add($lblName);
	   $txtName = new control\textbox('txtName');
       $txtName->label = _('name and family');
       $txtName->place_holder = _('name and family');
       $txtName->size = 6;
       $form->add($txtName);
       
       $txtEmail = new control\textbox('txtEmail');
       $txtEmail->label = _('Email');
       $txtEmail->place_holder = _('Your email address');
       $txtEmail->size = 6;
       $form->add($txtEmail);
       
       $txtDes = new control\textarea('txtDes');
       $txtDes->label = _('Description');
       $txtDes->editor = false;
       $form->add($txtDes);
       
       $txtAmout = new control\textbox('txtAmount');
       $txtAmout->label = _('Amount');
       $txtAmout->place_holder = _('Amount of donation');
       $txtAmout->size = 6;
       $txtAmout->addon = _('Rials');
       $form->add($txtAmout);
       
       $btnPayment = new control\button('btnPayment');
       $btnPayment->configure('LABEL',_('Payment'));
       $btnPayment->configure('TYPE','primary');
       $btnPayment->p_onclick_plugin = 'donation';
       $btnPayment->p_onclick_function = 'btnOnclickPayment';
        
       $btn_cancel = new control\button('btn_cancel');
       $btn_cancel->configure('LABEL',_('Cancel'));
       $btn_cancel->configure('HREF',SiteDomain);
	   $row = new control\row;
       $row->configure('IN_TABLE',false);
       $row->add($btnPayment,2);
       $row->add($btn_cancel,10);
       $form->add($row);
       
       return [_('Donation'),$form->draw()];
	}

    /*
	 * show list of people that has donate
     * @param array $donates, all donate information that state =1
	 * @return 2D array [title,content]
	 */
    protected function viewListDonate($donates){
        $form = new control\form('frmlistdonates');
        $table = new control\table('tblPeople');
        $calendar = \core\cls\calendar\calendar::singleton();
        $counter = 1;
        if(!is_null($donates))
            foreach($donates as $donate){
                $row = new control\row;
                $row->in_table = false;

                $lblID = new control\label($counter);
                $row->add($lblID,7);
                $counter += 1;

                $lblName = new control\label($donate->name . '  (' . $donate->email . ')');
                $row->add($lblName,7);

                $lblAmount = new control\label($donate->amount);
                $row->add($lblAmount,3);

                $lblDate = new control\label($calendar->cdate('Y/m/d', $donate->date));
                $row->add($lblDate,2);
                $table->add_row($row);
            }
        $table->configure('HEADERS',[_('ID'),_('Name and email'),sprintf(_('Amount( %s )'),_('Rials')),_('Date')]);
        $table->configure('HEADERS_WIDTH',[1,6,3,2]);
        $table->configure('ALIGN_CENTER',[true,true,true,true]);
        $table->configure('BORDER',false);
        $table->configure('SIZE',12);
        $form->add($table);
        return [_('Donators'),$form->draw()];
    }
}
