<?php

class Born_Flatshipping_Model_Carrier_Flatshipping 
extends Mage_Shipping_Model_Carrier_Abstract
implements Mage_Shipping_Model_Carrier_Interface {
	protected $_code = 'flatshipping';
	
	public function collectRates(Mage_Shipping_Model_Rate_Request $request){
        if (!$this->getConfigFlag('active')) {
			return false;
		}
		
		$allowed['Ground'] = '+'.$this->getConfigData('rate_ground');
		$allowed['3-Day'] = '+'.$this->getConfigData('rate_third_day');
		$allowed['2-Day'] = '+'.$this->getConfigData('rate_second_day');
		$allowed['Next Day'] = '+'.$this->getConfigData('rate_next_day');
			
        $result = Mage::getModel('shipping/rate_result');        
		
		foreach ($allowed as $title => $rate) {
			$title_internal = str_replace(" ", "_", strtolower($title));
			$method = Mage::getModel('shipping/rate_result_method');
			$method->setCarrier("flatshipping");
			$method->setCarrierTitle($title);
			$method->setMethod($title_internal);
			$method->setMethodTitle($title);
			$method->setPrice($rate);
			$result->append($method);
		}
		
		$this->_updateFreeMethodQuote($request);

		return $result;
		
	}
	
	public function getAllowedMethods()
    {
		return array('flatshipping'=>'Flat ShippingRates');
    }		

}