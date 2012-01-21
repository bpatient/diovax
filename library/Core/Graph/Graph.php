<?php
	
/**
 * 
 * 
 * 
 * This library will use pChart library to customize this app charts 
 * This will be implemented in the second version. The version used in this example, is github version
 * that supports PHP 5.x functionalities  
 * 
 * @author Pascal Maniraho 
 * @version 1.0.0 
 * @uses pChart
 * @uses pCache
 * @uses pData 
 * 
 * 
 * @todo change the path to the above cache 
 * @todo design components to be used in view helpers 
 * @todo design adapters to data we are using in this site. 
 * @link https://github.com/aweiland
 * @link http://devzone.zend.com/article/1260
 * @link http://pchart.sourceforge.net/documentation.php
 * 
 * 
 * @todo change the cache dir in and retrieve it either from the config file or state create it 
 * @todo implement adapters to our datamodel, and design put together commmon drawing tasks 
 * @todo implement veiew helpers to that uses this object per graph to be drawn.
 * @todo design graphs such as sales/monthly sales/product appreciation, ... 
 * 
 */


	/**This has no problem since library is in include path */

	require_once( 'pchart/pCache.php');
	require_once( 'pchart/pChart.php');
	require_once( 'pchart/pData.php');
	
	class Core_Graph_Graph extends pChart{
		
		
		
		
		/***/
		public function __construct( ){

			
			
		}
		
	
	
	
	}


	

?>