<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Capacity_micron_model extends CI_Model {

/* Developer  	  -  Priyanka
   Tasks     	  -  Capacitor Micron 
   Start Date 	  -  06-02-2017  1:00 PM
   Modified Date  -  
*/

   # Get Capacity Unit Data
   public function get_capacity_unit_data()
   {
   	$this->db->select('c.capacity_id,c.name as capacity_name,u.name as unit_name');
		$this->db->from('capacity c');
		$this->db->join('unit u','u.unit_id = c.unit_id','left');
      $this->db->where('c.type',1);
      $this->db->where('c.status',1);
		$res = $this->db->get();		
		return $res->result_array();
   }

    public function get_capacity_micron_results()
   {
      $this->db->select('*');
      $this->db->from('capacity_micron');
      $res = $this->db->get();      
      return $res->result_array();
   }
}