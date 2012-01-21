<?php
/**
 * THis interface will make it possible to add an extra data model. this level is designed to make less code, and improve implementation on service side
 * @author Pascal Maniraho
 */

interface Core_Dao_Dao{
	public function save();
	public function getAll();
	public function get();
	public function delete();
	public function getPersistance();
}