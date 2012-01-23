<?php


/**
 * 
 * 
 * This controller shows health status of the application
 * it is used to give useful information about performance of the software and the store in general 
 * it will spot also some failures on system performance, and stats 
 * It will also give an insight on tax tables, shipping rates and so on. 
 * 
 * 
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0
 *
 * 
 * @tutorial http://en.wikipedia.org/wiki/Internet_taxes Wikipedia entry of how Internet tax works 
 * @tutorial http://www.endless.com/help/200107190/ For Internet Tax 
 * @tutorial http://www.endless.com/help/200104820?ie=UTF8&pf_rd_r=1363X68DBFMHB3CR6T0Q&pf_rd_m=AF16NM0QF9TKW&pf_rd_t=801&pf_rd_i=200103510&pf_rd_p=253246201&pf_rd_s=center-2 helps for shipping services
 * 
 * @tutorial https://cms.paypal.com/us/cgi-bin/?cmd=_render-content&content_ID=developer/e_howto_html_ProfileAndTools PayPal sales tax calculation + shipping fees 
 * @tutorial http://checkout.google.com/support/sell/bin/answer.py?hl=en&answer=71391 google check out tax query service 
 * @tutorial http://checkout.google.com/support/sell/bin/answer.py?hl=en&answer=73973  google check out tax query service 
 * @tutorial http://code.google.com/apis/checkout/developer/Google_Checkout_XML_API_Merchant_Calculations_API.html
 * @tutorial http://www.strikeiron.com/Catalog/ProductDetail.aspx?pv=5.0.0&pn=Sales+and+Use+Tax+Basic tax calc. and data provider
 * @tutorial http://www.strikeiron.com/Catalog/SampleCode/
 * 
 * @tutorial http://www.tipsandtricks-hq.com/ecommerce/wp-estore-tax-calculation-916 a wordpress cart about tax calculation
 * @tutorial http://www.newrules.org/retail/rules/internet-sales-tax-fairness tax on sales   
 * 
 * 
 * @link http://tax-tables.com/zip2tax.php 
 * @link http://www.scriptlance.com/projects/1238123322.shtml similar online quote spec. 
 * @link http://stackoverflow.com/questions/302759/computing-california-sales-tax for a question about taxes and a way to solve it
 * 
 * @uses 
 * @see merchant calculations api
 * @see tax table 
 * @see shipping fees
 * @see AvaTax tax engine 
 * @see Avalara tax engine software  
 * 
 * 
 * 
 * @todo Sales overview 
 * @todo Calc Total Income/Cost of Sale/deduce the profit 
 * @todo Tax report overview/Sale period[ ability to choose dates ]
 * @todo Handling report [ overview of shipping [ price | carrier | ...] 
 * 
 * 
 * 
 * @abstract Merchant Calculations API taxe calculatation uses the default U.S. rounding rules for financial calculations. 
 * 			 So make sure that you confirm to this before using this application.  
 * 			U.S. rounding rules for financial calculations stipulates that taxes are calculated by assessing the tax rate to the total cost of all of the items and then using the HALF_EVEN rounding mode, or banker's rounding, to determine the tax for the order. 
 * 			U.K. the default behavior is to calculate tax separately for each item in the order and then apply the HALF_UP rounding mode to each calculation 
 * 			for rounding methods, use http://www.javabeat.net/tips/35-precise-rounding-of-decimals-using-rounding-m.html
 * 			and http://www.diycalculator.com/sp-round.shtml for algorithms followed to work on rounding. 
 * 			
 * 			Its better to enable those two modes, to make clients from both UK and US rounding systems happy
 * 
 */
class Admin_AnalyticsController extends Core_Controller_Base
{
	
	
	
   	
   public function init()
    {
    	parent::init();
        $this->options = array();
        $this->options['data'] = array();
    }
    

    
    public function preDispatch(){
        parent::preDispatch();
    }
    
    
    public function indexAction(){   	
        parent::index();
        echo "Dashboard";
    }
    
    public function customerAction(){
    	parent::index();
    	echo "customer analytics";
    }
    
    
    public function propertyAction(){
    	parent::index();
    	echo "property analytics";
    }
    
    
    public function profitabilityAction(){
    	parent::index();
    	echo "Dashboard";
    }
    
    
     public function postDispatch(){
        parent::postDispatch();
         $this->view->subMenu = $this->view->adminMenu($this->user  ,array("display" => Core_Util_Settings::MENU_ADMIN_CONTROLLER_ANALYTICS) );
    }



}//end of the controller 


?>