<?php
/**
 * Ma_Service_Database
 * This class will give access to local database, and will serve as data provider to the application
 * controllers will be interracting directly with data from this  class. instead of initilizing the each and every time
 * a new database instance
 */
class Core_Service_Database{


	const UN_SUPPORTED_PARAMETER_EXCEPTION = "Parameter not Supported Exception  ";

	/**
	 * This variable wrapps database object
	 * @var string $db
	 */
	public $db;
	private $_message = '';

	/**
	 * @var array $_options may also be feched from database configuration file
	 */
	public $config = array(
		"host" => '',
		"email" => '',
		"password" => '',
		"dbname" => ''
	);






        public function __construct(){
        	$this->db = Zend_Registry::get("db");
            Zend_Db_Table_Abstract::setDefaultAdapter($this->db);
        }





	/**
	 * This function will be used by other function to update one single field in the database
	 * @param string $field
	 * @param string $value
	 * @param array $options [ table | id_field | id_value ]
	 *
	 */
	protected function setField($field, $value, $options = array ('table' => 'user', 'id_field' => 'id' , 'id_value' => 0 )  ){
		$table = ( $options['table'] ) ? $options['table'] : 'user';//is the current table by default
		$id_field = ( $options['id_field'] ) ? $options['id_field'] : 'id';//is the current table by default
		$id_value = ( $options['id_value'] ) ? $options['id_value'] : 0 ;//is the current table by default
		$sql = "UPDATE $table SET $field = ? WHERE ( $id_field = ? )";
	

		$stmt = $this->db->prepare( $sql);
		$stmt->execute(array($value, $id_value ) );


	}

	protected function getField($field, $options = array ('table' => 'user', 'id_field' => 'id' , 'id_value' => 0 )  ){

		$table = ( $options['table'] ) ? $options['table'] : 'user';//is the current table by default
		$id_field = ( $options['id_field'] ) ? $options['id_field'] : 'id';//is the current table by default
		$id_value = ( $options['id_value'] ) ? $options['id_value'] : 0 ;//is the current table by default
		$sql = "SELECT $field FROM $table WHERE ( $id_field = ? ) LIMIT 0, 1 ";
		$stmt = $this->db->query( $sql, array($id_value ) )->fetch();
		//echo $sql . ' -> '.$stmt["$field"];
		return $stmt["$field"];
	}






	protected function edit( $obj , $options = array( 'id_field' => 'id' ) ){
		$continue = ($obj instanceof Core_Model_Entity);
		$id = 'id';
		$id = $obj->getPrimaryKey();
		$isUpdate = false;

		if($options && $options['id_field']){ $id = $options['id_field']; }

		if ( !$continue )  throw new Exception ( self::UN_SUPPORTED_PARAMETER_EXCEPTION .'  '.__CLASS__.' EDIT ');

		try{
                        $obj->insert($obj->toArray());                        
                        $id = $obj->getAdapter()->lastInsertId($id);

		}catch(Exception $e){
			$update_data = $obj->toArray();
			if( is_array($options['id_field']) ){
				foreach( $options['id_field'] as $k){
					  $where[" `$k` = ? "] = $obj->{$k};
					  unset($update_data[$k]);
				}
			}else{
				$where =  $obj->getAdapter()->quoteInto( " `$id` = ? ", $obj->{$id} );
				unset($update_data[$id]);
			}
			
			$obj->update( $update_data , $where );
			$id = $obj->{$id};
			$this->setMessage( $e->getMessage() );
		}

	
		return $id;

	}



	protected function get( $obj, $options = array() ){


			$continue = ($obj instanceof Core_Model_Entity);
			if ( !$continue )  throw new Exception ( self::UN_SUPPORTED_PARAMETER_EXCEPTION .'  '.__CLASS__.' GET ');
			$sql = "";$counter = 0;
			$sort = array ( 'field', 'sort', 'limit', 'orderby', 'pg','pp', 'per_page', 'get_all');
			$table = $obj->getTableName();
			$obj_adapter = $obj->getAdapter();
			if ( isset($options['sort']) && ( true === $options['sort']  ) ){
				$field = $options['field']? $options['field'] : 'id';
				$limit = $options['limit']? $options['limit'] : 0;
				$order = $options['orderby']? $options['orderby']: 'ASC';
				$sql = $obj->select()->order($field.' '.$order);
	    		if( $options['get_all'] ) $sql = $sql->limit( 20 , $limit);

			}elseif( is_array($options) ) {
				foreach($options as $k => $v ){
					if( is_string($k)  && in_array($k, $sort )  ) continue;
					if( is_string($v) ) $v = trim($v);
					if($counter > 0 && $counter < count($options)):
						$sql .=  $obj_adapter->quoteInto(" AND `$k` = ? ", $v);
					elseif($counter == 0):
						$sql =  $obj_adapter->quoteInto(" `$k` = ? ", $v);
					endif;
					$counter++;
				}
			}

			$resultset = ($sql == '') ? $obj->fetchAll() : $obj->fetchAll($sql);
			return $resultset;
	}






	 public function delete( $obj, $options = array( 'id_field' => 'id' )  ){

	 	$id = 'id';
		$id = $obj->getPrimaryKey();
		$deleted = false;
	 	if($options && $options['id_field']){ $id = $options['id_field']; }

		$continue = ($obj instanceof Core_Model_Entity);
		if ( !$continue )  throw new Exception ( self::UN_SUPPORTED_PARAMETER_EXCEPTION .'  '.__CLASS__.' DELETE ');
		if( $obj->{$id} != null ||   $obj->{$id} > 0 ){
			$where =  $obj->getAdapter()->quoteInto( " `$id` = ? ", $obj->{$id} );
			$obj->delete( $where );
			$deleted = true;
		}
		return $deleted;
	}


	public function setMessage( $message ){ $this->_message = $message; }
	public function getMessage() { return $this->_message; }



}

?>