<?php

	
/**
 * 
 * 
 * 
 * @author Pascal Maniraho
 * @version 1.0.0
 * @uses Zend_Date
 * 
 */
class Core_Util_Date extends Zend_Date{
	
	
	
	/**Local variables to help us dealing with */
	private $starts, $stops, $elapsed; 
	function __construct($data = array () ){
		
			parent::__construct();
		
			if ( $data['starts'] ) $this->starts = $data['starts'];
			if ( $data['stops'] ) $this->stops = $data['stops'];
			if ( $data['elapsed'] ) $this->elapsed = $data['elapsed'];
	
			if ( $this->stops == 0 ) $this->stops = time();
			
	}

	
	
    public function elapsed($starts = '', $stops = '' ){	   	

    	if ( $starts  ) $this->starts = $starts;
    	if ( $stops  ) $this->stops = $stops;
    	
    	
    	if (!( $this->starts && $this->stops )) return 0;
    	
    	
    	
    	if ( is_string($this->starts) ) $this->starts = strtotime($this->starts);
    	if ( is_string($this->stops) ) $this->stops = strtotime($this->stops);
    	
    	
    	$this->elapsed  =  round( $this->stops - $this->starts );
    	return  ($this->elapsed > 0 )? $this->elapsed : 'not finished';
    	
    }
    
    /**
     * From starting date, after n weeks get a corresponding date  
     * @param Date $starts
     * @param int $weeks
     */
    public static function dateAfterWeeks( $starts , $weeks , $isTime = false ){
    	$weeksAfter = ( (int)$weeks * 7 * 24 * 60 * 60 ); 
    	if( is_string($starts) ) { 
    		$starts = strtotime($starts);
    	}
    	$nextTime = ( $weeksAfter + $starts );
    	if( $isTime ) return $nextTime;
    	return date("Y-m-d h:i:s", $nextTime);
    }
	
    

    
    
    
	       
	
}


?>