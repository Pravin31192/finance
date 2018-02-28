<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Slots extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->view('admin/header');
		// Slots Model
		$this->load->model('admin/Slots_model', 'SlotsModel');
		$this->load->model('admin/Courts_model', 'CourtsModel');
	}

	/**
	* Name : CreateSlot
	* Purpose : To save the slots in the slots table from trom the 
	*/
	public function CreateSlot()
	{
		
		$dataProvider['courtsTable'] = $this->CourtsModel->getAllCourtsAsObject();
		$this->load->view('admin/slots/create-slot', $dataProvider);
		$this->load->view('admin/footer');
	}

	/**
    * Name : getSlots
    * Purpose : To get the time slots that are available for the selected court.
    */
    public function getSlots($courtId = null)
    {
        $courtId = $this->input->post('courtId');
        $slotsQuery = $this->db->get_where('slots', ['courts_id'=>$courtId, 'status'=>1]); // where 1 is active
        $slotsTable = $slotsQuery->result();
        //header('Content-Type: application/json');
        echo json_encode($slotsTable);exit;
        //return json_encode($slotsTable);
    }

	/**
	* Name : EditSlot
	* Purpose : To edit the slots that are in a court.
	*/
	public function EditSlot()
	{
		$postData = $this->input->post();
		$slotsArray = array_keys($postData);

		foreach ($slotsArray as $key => $tempSlots) {
			$slotDetails = explode('-', $tempSlots);
			$slotId = $slotDetails[1];
			
			$dataProvider = array(
				'price' => $postData[$tempSlots],
			);
			$this->SlotsModel->updateSlot($slotId, $dataProvider);
		}
		redirect('slots');
	}

	/**
	* Name : delete
	* Purpose : To delete the slot from table. Actual delete is not 
	* done here. Only the status is changed from active to inactive.
	*/
	public function delete()
	{
		$slotId = $this->input->post('id');
		$result = $this->SlotsModel->changeToInactive($slotId);
		echo json_encode($result);exit;
	}
}
?>