<?php 

class Courts_model extends CI_Model {
	
	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Name : createCourt
	* Purpose : To save the details of the courts in the table.
	* param $dataProvider array An array of data about the court that has to be saved.
	*/
	public function createCourt($dataProvider)
	{
        $this->db->insert('courts', $dataProvider);
        return $this->db->insert_id();
	}


	/**
	* Name : editCourt
	* Purpose : To edit the selected court
	* @param int   $courtId The id the "courts - table" that needs to be edited.
	* @param array $dataProvider An array consisting of the POST value from the Form
	*/
	public function editCourt($courtId, $dataProvider)
	{
		$this->db->where('court_id', $courtId);
		return $this->db->update('courts', $dataProvider);
	}

	/**
	* Name : getAllCourts
	* Purpose : To get the court detail that is selected
	* @param $id int The row id of the court
	*/	
	public function getCourtDetails($id) 
	{
		$courtQuery = $this->db->get_where('courts', ['court_id' => $id, 'status' => '1']);
		return $courtQuery->row_array();
	}

	/**
	* Name : getSlotsOfCourt
	* Purpose : To get all the court detail along with the slots
	* @param $id integer To load all the slots of the selected Court
	*/
	public function getSlotsOfCourt($id)
	{
		$slotsOfCourtsQuery = $this->db->get_where('slots', ['courts_id'=>$id, 'status'=>1]);
		return $slotsOfCourtsQuery->result_array();
	}

	/**
	* Name : getAllCourts
	* Purpose : To get all the courts in the system
	*/
	public function getAllCourts()
	{
		$courtsQuery = $this->db->get_where('courts', ['status'=>'1']);
		return $courtsQuery->result_array(); 
	}

	/**
	* Name : getAllCourtsAsObject
	* Purpose : To fetch all the courts and their details
	*/
	public function getAllCourtsAsObject()
	{
		$courtsQuery = $this->db->get_where('courts', ['status' => '1']);
		$courtsTable = $courtsQuery->result();
		return $courtsTable;
	}

	/**
	* Name : getAllCourtsWithSlots
	* Purpose : To get all the court detail along with the slots
	*/
	public function getAllCourtsWithSlots()
	{
		$this->db->select("*");
		$this->db->from('courts');
		$this->db->where('status', '1');
		$courtsQuery = $this->db->get();
		$courtsTable = $courtsQuery->result_array();
		$courtsQuery->free_result(); 

		foreach ($courtsTable as $key => $tempCourts) {
			$slotsQuery = $this->db->get_where('slots', ['courts_id' => $tempCourts['court_id'], 'status'=>1]);
			$slots = $slotsQuery->result_array();
			$courtsTable[$key]['slot'] = $slots;
		}
		return $courtsTable;
	}


	/**
	* Name : loadSlotsBookingTable
	* Purpose : To load the slots from the booking table along with the court and slot detail
	*/
	public function loadSlotsFromBookingTable($selectedDate)
	{
		$selectedDate = date('Y-m-d', strtotime($selectedDate));
		$bookingQuery = $this->db->get_where('bookings', ['date' => $selectedDate] );
		$bookingsTable = $bookingQuery->result_array();
		//print_r("1) Checking for records on the table <br>");
		// Making Associative array by adding the courts and slots table
		if (!empty($bookingsTable)) {
			//print_r("4 Checked. Now the data is available <br>");
			$allCourtsWithBookingSlots = $this->getAllCourts();
			foreach ($allCourtsWithBookingSlots as $key => $tempCourts) {
				$allCourtsWithBookingSlots[$key]['bookingSlots']  
					= $this->getbookingSlotsOfCourt($tempCourts['court_id'], $selectedDate);

				foreach($allCourtsWithBookingSlots[$key]['bookingSlots'] as $bookingKey => $tempBookingSlots) {
					$slotId = $allCourtsWithBookingSlots[$key]['bookingSlots'][$bookingKey]['slots_id'];
					$allCourtsWithBookingSlots[$key]['bookingSlots'][$bookingKey]['slotDetails'] 
						= $this->SlotsModel->getSlotDetails($slotId);
				} // End of second foreach.
			} // End of foreach
			return $allCourtsWithBookingSlots;	
		} else { 
			// if there are no records for the selected date, then we create
			// the records for the selected date in the bookings table and return
			// the newly created data.
			$this->saveEmptyBookingForSelectedDate($selectedDate);
			// Calling the same function to check the data now.
			//$this->loadSlotsFromBookingTable($selectedDate);

		}
	}

	/**
	* Name : saveEmptyBookingForSelectedDate
	* Purpose : To populate the bookings table with the default data.
	* @param $selectedDate String the date that is been selected by the user.
	*/
	public function saveEmptyBookingForSelectedDate($selectedDate)
	{
		//print_r("3) Creating Records <br>");
		// loading the courts
		$courtsQuery = $this->db->get('courts');
		//$courtsTable = $courtsQuery->result();
		$courtsTable = $this->getAllCourtsWithSlots();
		foreach ($courtsTable as $key => $tempCourts) {
			foreach ($tempCourts['slot'] as $key => $tempSlots) {
				$bookingsDataProvider = array(
					'courts_id' => $tempCourts['court_id'],
					'slots_id' => $tempSlots['slot_id'],
					'date' => $selectedDate,
					'status' => "0",
				);
				$this->db->insert('bookings', $bookingsDataProvider);
			}
		}
	}

	/**
	* Name : getbookingSlotsOfCourt
	* Purpose : To load the slots that are in the booking table.
	* @param $courtId int the date that is been selected by the user.
	*/
	public function getbookingSlotsOfCourt($courtId, $selectedDate)
	{
		$courtSlotsInBookingQuery 
			= $this->db->get_where('bookings', ['courts_id' => $courtId, 'date'=>$selectedDate]);
		return $courtSlotsInBookingQuery->result_array();
	}


	/**
	* Name : courtAsInactive
	* Purpose : To change the active status of the court to Inactive
	* @param int $courtId The id of the court that need to be changed to inactive.
	*/
	public function courtsAsInactive($courtId)
	{
		$this->db->where('court_id', $courtId);
		return $this->db->update('courts', ['status' => '0']); // where 0 is inactive.
	}

} // End of Class function
?>
