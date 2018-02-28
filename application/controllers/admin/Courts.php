<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Courts extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('admin/Courts_model', 'CourtsModel');
        $this->load->model('admin/Slots_model', 'SlotsModel');
		$this->load->view('admin/header');
		
	}

    /**
    * Name : check_time_difference
    * Purpose : Its a validation callback method to check the difference between time intervals.
    * 1) The closing time should not be lesser than Opening time
    * 2) The time difference between the opening and closing time should not be greater than the
    * slot interval given by the user.
    */
    public function check_time_difference()
    {
        if (!empty($this->input->post())) {
            //echo "<pre>";
            $openingTime = $this->input->post('opening_time');
            $closingTime = $this->input->post('closing_time');
            $openingTime = strtotime($openingTime);
            $closingTime = strtotime($closingTime);
            if ($closingTime < $openingTime || $closingTime == $openingTime) {
                $this->form_validation->set_message('check_time_difference', 'Opening Time should be greater than closing time');
                return false;
            } else {
                $differenceInSeconds = $closingTime - $openingTime;
                $differenceInHours = ($differenceInSeconds/60)/60;
                $interval = $this->input->post('slot_interval');
                if ($interval > $differenceInHours) {
                    $this->form_validation->set_message('check_time_difference', 'Time difference is smaller than Slot Interval');
                return false;
                } else {

                    return true;
                }
            }
        }
    }

    /**
    * Name : CreateCourt
    * Purpose : To save the courts and the slots that are created by the admin.
    */
	public function CreateCourt()
	{
		$this->form_validation->set_rules('court_name', 'Court Name', 'trim|required');
        $this->form_validation->set_rules('slot_interval', 'Slot Interval', 'trim|required|integer');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('opening_time', 'Closing Time', 'trim|required');
        $this->form_validation->set_rules('closing_time', 'Closing Time', 'trim|required|callback_check_time_difference');
		if ($this->form_validation->run() === FALSE) {
            // Sending all the available courts to the user.
            $dataProvider['allCourts'] = $this->CourtsModel->getAllCourts();
            $this->load->view('admin/courts/create-court', $dataProvider);
            //redirect('courts/create', $dataProvider);
        } else {
            $startTime = $this->input->post('opening_time');
            $endTime = $this->input->post('closing_time');
            $interval = $this->input->post('slot_interval');
            $price = $this->input->post('price');

            $dataProvider = array(
            	'name' => $this->input->post('court_name'),
            	'slot_interval' => $this->input->post('slot_interval'),
            	'price' => $this->input->post('price'),
            	'description' => $this->input->post('description'),
                'opening_time' => $this->input->post('opening_time'),
                'closing_time' => $this->input->post('closing_time'),
                'status' => "1", // Where 1 is considered as Active. By Default it is made as active.
            );
            $this->db->trans_begin();            
            $insertedRow = $this->CourtsModel->createCourt($dataProvider);
            if (isset($insertedRow)) {
                $this->slotCalculations($startTime, $endTime, $interval, $insertedRow, $price);
                // Performing the rollback options for the entry.
                if ($this->db->trans_status() === false) {
                    $this->db->trans_rollback();
                } else {
                    $this->db->trans_commit();
                    //redirect('courts/create');
                    $this->session->flashdata('success-message', "Record Created Successfully");
                    $dataProvider['allCourts'] = $this->CourtsModel->getAllCourts();
                    $this->load->view('admin/courts/create-court', $dataProvider);
                }
            } else {
            	//print_r($this->db->last_query());
            }
        }
	}

    /**
    * Name : slotCalculations
    * Purpose : To calcuate the timings and divide the time slots of the court.
    */
    public function slotCalculations($startTime, $endTime, $interval, $courtId, $price)
    {
        $openingTime = strtotime($startTime);
        $closingTime = strtotime($endTime);
        $differenceInSeconds = $closingTime - $openingTime;
        $differenceInHours = ($differenceInSeconds/60)/60;
        $fromTime = date('h:i a',$openingTime);
        $toTime = date('H:i', strtotime($startTime."+$interval hour"));
        //$toTime = date('H:i', strtotime($startTime) + ($interval * 3600));
        $displayToTime = date("h:i a", strtotime($toTime));

        // To calculate and save the slot intervals in the Database.
        for ($i=0; $i < $differenceInHours/$interval ; $i++) { 
            
            $slotTiming = $fromTime."-". $displayToTime;

            // Save the slots in the solts table.
            $dataProvider = array(
                'courts_id' => $courtId,
                'slot_timing' => $slotTiming,
                'price' => $price,
                'status' => "1", // where 1 is considered as the default active status.
            );
            $this->SlotsModel->createSlots($dataProvider);
            $fromTime = $toTime;
            $fromTime = date('h:i a', strtotime($fromTime));
            $toTime = date('H:i',strtotime($toTime."+$interval hour"));
            //$toTime = date('H:i',strtotime($toTime)+ ($interval * 3600));
            $displayToTime = date('h:i a', strtotime($toTime));
            if (strtotime($toTime) > $closingTime) {
                $toTime = date('H:i', $closingTime);
                $displayToTime = date('h:i a', strtotime($toTime));
            }
        }
    } // End of SlotCalculation function.

    /**
    * Name : checkBookings
    * Purpose : To load the slots and the courts for the selected date.
    */
    public function checkBookingsForDate()
    {
        //$selectedDate = "22-7-2017";
        $selectedDate = $this->input->post('date');
        // To load the slots from the bookings table based on the date.
        $allCourtsWithBookingSlot = $this->CourtsModel->loadSlotsFromBookingTable($selectedDate);
        // Calling the same function again to pull the data.
        $slot_details = $this->CourtsModel->loadSlotsFromBookingTable($selectedDate);
        //echo"<pre>";print_r($slot_details);exit;
        echo json_encode($slot_details);exit;
    }


    /**
    * Name : EditCourt
    * Purpose : To edit the court details
    */
    public function EditCourt($courtId)
    {
        $this->form_validation->set_rules('court_name', 'Court Name', 'trim|required');
        $this->form_validation->set_rules('slot_interval', 'Slot Interval', 'trim|required|integer');
        $this->form_validation->set_rules('price', 'Price', 'trim|required|numeric');
        $this->form_validation->set_rules('description', 'Description', 'trim');
        $this->form_validation->set_rules('opening_time', 'Closing Time', 'trim|required');
        $this->form_validation->set_rules('closing_time', 'Closing Time', 'trim|required|callback_check_time_difference');
        if ($this->form_validation->run() === FALSE) {
            // Sending all the available courts to the user.
            $dataProvider['allCourts'] = $this->CourtsModel->getCourtDetails($courtId);
            $this->load->view('admin/courts/edit-court', $dataProvider);
            //redirect('courts/create', $dataProvider);
        } else {
            // Save the court details in the table and then a new set of slots can be saved.
            // Convert the previous-slots to Inactive state.
            $this->SlotsModel->changeSlotInactive($courtId);
            // Updating the Courts Table
            // Collecting the data from the post method.
            $dataProvider = array(
                'name' => $this->input->post('court_name'),
                'slot_interval' => $this->input->post('slot_interval'),
                'price' => $this->input->post('price'),
                'description' => $this->input->post('description'),
                'opening_time' => $this->input->post('opening_time'),
                'closing_time' => $this->input->post('closing_time'),
                'status' => "1", // Where 1 is considered as Active. By Default it is made as active.
            );
            $result = $this->CourtsModel->editCourt($courtId, $dataProvider);
            if ($result == 1) {
                $startTime = $this->input->post('opening_time');
                $endTime = $this->input->post('closing_time');
                $interval = $this->input->post('slot_interval');
                $price = $this->input->post('price');
                $this->slotCalculations($startTime, $endTime, $interval, $courtId, $price);
            }
        }
        redirect('courts/create');
    } // End of edit function.


    /**
    * Name : Delete
    * Purpose : To delete the courts from user view.
    * We are not doing the actual deletion. We just changing the status of the court.
    */
    public function Delete($courtId)
    {
        // After changing the status of the court, 
        //the status of the slots should also be changed.
        $result = $this->CourtsModel->courtsAsInactive($courtId);
        // If status of the court is changed.
        if ($result == 1) {
            $this->SlotsModel->changeSlotInactive($courtId);
        }
        redirect('courts/create');

    }

} // End of class function.

?>