<?php 

class Slots_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Name : createSlots
	* Purpose : To save the slots in the "Slots" table.
	*/
	public function createSlots($dataProvider)
	{
		$this->db->insert('slots', $dataProvider);
	}

	/**
	* Name : getSlotDetails
	* Purpose : To retrieve the data of the selected slot.
	*/
	public function getSlotDetails($slotId)
	{
		$slotQuery = $this->db->get_where('slots', ['slot_id'=>$slotId]);
		return $slotQuery->row_array();
	}

	/**
	* Name : updateSlot
	* Purpose : To update the slot that is been passed
	*/
	public function updateSlot($slotId, $dataProvider)
	{
		$this->db->where('slot_id', $slotId);
		$this->db->update('slots', $dataProvider);
	}

	/**
	* Name : changeSlotInactive
	* Purpose : To change the status of the slot from active to Inactive.
	*/
	public function changeSlotInactive($courtId)
	{
		// Find all the slots related with the CourtId
		$slotQuery = $this->db->get_where('slots', ['courts_id' => $courtId]);
		$slotsTable = $slotQuery->result();
		foreach ($slotsTable as $key => $temp) {
			$this->db->where('slot_id', $temp->slot_id);
			$data = array('status'=> "0");
			$this->db->update('slots', $data);
		}
	}


	/**
	* Name : changeToInactive
	* Purpose : To change the status of the slot to inactive.
	*/
	public function changeToInactive($slotId)
	{
		$this->db->where('slot_id', $slotId);
		return $this->db->update('slots', ['status' => 0]); // Where 0 is inactive.
	}
}

?>