<?php

	
/**
 * 
 * 
 * 
 * This class will be used to chop long text into smaller text. 
 * [ manipulates strings and text ] 
 * @author Pascal Maniraho
 * @version 1.2.0
 * @link http://www.reconn.us/count_words.html
 * @todo 1. link local variables to class variables 
 * 		 2. improve cleanString so that special chars are took into consideration
 * 			special chars include &amp; &eacute; .... using html_entity_decode()
 * 		 3. improve the constructor, so that at cutText() variables are passed in to the constructor and 
 * 			access directely to processed text. 
 * 		  
 * 
 * 
 * 
 * 
 */
class Core_Util_String{
	
	
	//preg_replace
	private $num_words; 
	private $text; 
	
	
	
	/**
	 * This array will help to initialize class variables
	 * @param optional array $data  
	 */
	function __construct($data = array () ){
		$this->num_words = 0; 
		$this->text = '';
	}

	
	
    function countWords($str){	   	
    	
    	$words = 0;
    	//this line replaces consecutive space characters with a single space character	    
	    $array = explode(" ", $this->cleanString($str) ); //$str = eregi_replace(" +", " ", $str);
	    
	    for($i=0;$i < count($array);$i++){
	        //words are strings that contain at least a 'letter character'
		    //if (eregi("[0-9A-Za-zÀ-ÖØ-öø-ÿ]", $array[$i]))
		    if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/i", $array[$i]))
		    $words++;
	    }
	      return $words;
    	}


		/**
		 * This function cuts the text according to given parameters.
		 * It does on text strings what snippet() does on simple strings
		 * @param string $text
		 * @param array $options 
		 */
       function cutText($text, $options = array ( 'words' => 120, 'tail' => '...', 'force_tail' => false )) {
        
       	
       	
       	
       	/**
       	 * word counter 
       	 * @var integer $words
       	 */
       	$words = 0;
       	/***
       	 * the number of words to return 
       	 */
       	/**
       	 * this variable will hold the new text 
       	 * @var string $ntext 
       	 */
       	$ntext = "";
        $nwords = ( isset($options['words']) && $options['words']  > 0 )? $options['words'] : 100; //initialization of the number of words before appending the tail
       	$tail =  ( isset($options['tail']) &&  strlen($options['tail']) > 0 )? $options['tail'] : '...';// the tail to append to the final text if needed
       	$forceTail =  ( isset($options['force_tail']) && $options['force_tail'] == true )? true : false;// the tail to append to the final text if needed

       	
		if( !($this->countWords($text) > $nwords ) ) 
			return ( ($forceTail) ? $text.$tail : $text); 
       	
			
	      $array = explode(" ", $this->cleanString($text) );
            for($i=0;$i < count($array);$i++){
              if (preg_match("/[0-9A-Za-zÀ-ÖØ-öø-ÿ]/", $array[$i]))  $words++;
        	      if($words < $nwords)
                     $ntext .=  $array[$i]." ";
                else
                    return $ntext.$tail;
             }           

     }


		/**
		 * 
		 * 
		 * This function has not been used either internally or from outside the class
		 * cutText() function is doing the its tasks.  
		 * 
		 * 
		 * @param $text
		 * @param $length
		 * @param $tail
		 * @return string $text
		 */
       function snippet( $text, $length=64, $tail="...") {
           $text = trim($text);
           $txtl = strlen($text);
           if($txtl > $length) {
               for($i=1;$text[$length-$i]!=" ";$i++) {
                   if($i == $length) {
                       return substr($text,0,$length) . $tail;
                   }
               }
               $text = substr($text,0,$length-$i+1) . $tail;
           }
           return $text;
       }
       
       
       
       
       /**
        * This function removes empty spaces, and removes some wierd characters 
        * from the string the string.
        * 
        * @param string $string
        * @return string $text
        * @todo add handle for ascii code characters, say in a case we have [ &eacute; ...]  in text 
        * @todo add a parameter and handle to encode/decode cleaned string( utf8,... ) 
        */
       function cleanString( $string ){
       		//preg_replace replace eregi_replace as the latter is being deprecated
       		//$string = eregi_replace(" +", " ", $string);
       		$string = preg_replace("/\s+/i", " ", strip_tags( trim($string) ) );
       		/*check and replace ascii characters &acute; ..., 
       		 * or #bbbbfd or html tags */
       		return $string;	  
       }
       
       
       /**This function should clean a string a return a sanitized string*/
       function sanitize( $string ){ return $string; }





        public function slug( $str, $replace=array(), $delimiter='-' ) {
        setlocale(LC_ALL, 'en_US.UTF8');
            if( !empty($replace) ) {$str = str_replace((array)$replace, ' ', $str);}
            $clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
            $clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
            $clean = strtolower( trim($clean, '-') );
            $clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
            return $clean;
        }



       
	
}


?>