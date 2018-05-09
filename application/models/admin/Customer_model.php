<?php 

class Customer_model extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('user/User_model', 'UserModel');
		
	}

	public function getCustomerById($id)
	{
		$query = $this->db->get_where('user', ['user_id' => $id]);
		return $query->row();
	}

	/**
	* Name : saveCustomer
	* Purpose : To save the details of the customers in the table.
	* param $dataProvider array An array of data about the customer that has to be saved.
	*/
	public function saveCustomer($dataProvider)
	{
        $this->db->insert('user', $dataProvider);
        return $this->db->insert_id();
	}

	public function saveVehicle($dataProvider)
	{
		$this->db->insert('vehicle', $dataProvider);
        return $this->db->insert_id();
	}

	public function getCustomerVehicles($customerId)
	{
		$query = $this->db->get_where('vehicle', ['user_id' => $customerId]);
		return $query->result();
	}


	public function saveLoan($dataProvider) {
		$this->db->insert('loan', $dataProvider);
        return $this->db->insert_id();
	}

	public function saveInstallments($dataProvider) {
		$this->db->insert('loan_installments', $dataProvider);
        return $this->db->insert_id();	
	}


	public function getLoanList()
	{
		$loanQuery = $this->db->get_where('loan');
        return $loanQuery->result_array(); 
	}

	public function getInstallmentList($id)
	{
		$query = $this->db->get_where('loan_installments', ['loan_id' => $id]);
		return $query->result();	
	}

	public function getInstallmentDetails($id)
	{
		$query = $this->db->get_where('loan_installments', ['id' => $id]);
		return $query->row();
	}

	public function getLoanDetails($id)
	{
		$query = $this->db->get_where('loan', ['id' => $id]);
		return $query->row();
	}

	public function updateInstallmentDetails($id, $dataProvider) 
	{
		$this->db->where('id', $id);
		$this->db->update('loan_installments', $dataProvider);
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
	* Name : getBookingSlotDetails
	* Purpose : To get the details of the booking slot.
	* @param int $id The id of the bookings table
	*/
	public function getBookingSlotDetails($id)
	{
		$bookingsQuery = $this->db->get_where('bookings', ['bookings_id'=>$id]);
		$bookingsTable = $bookingsQuery->row_array();
		$bookingsTable['courtDetails'] = $this->CourtsModel->getCourtDetails($bookingsTable['courts_id']);
		$bookingsTable['slotDetails'] = $this->SlotsModel->getSlotDetails($bookingsTable['slots_id']);
		return $bookingsTable;
	}

	/**
	* Name : getBookings()
	* Purpose : To load the bookings of today and following days
	*/
	public function getBookings()
	{
		$result = $this->db->query("SELECT * FROM bookings join courts on court_id = courts_id join slots on slot_id = slots_id WHERE date >= CURDATE() group by date");
		return $result->result();
	}

	/**
	* Name : bookByAdmin
	* Purpose : To book a slot by admin for the customer.
	*/
	public function bookByAdmin($bookingId, $dataProvider)
	{
		$this->db->where('bookings_id', $bookingId);
		$this->db->update('bookings', $dataProvider);
	}

	/**
	* Name : bookByCustomer
	* Purpose : After the payments the slot may be booked by the customer
	* @param int   $bookingId The id of the booking slot
	* @param array $dataprovider An array of booking details
	*/
	public function bookByCustomer($bookingId, $dataProvider)
	{
		$this->db->where('bookings_id', $bookingId);
		$this->db->update('bookings', $dataProvider);
	}

	/**
	* Name : getAdminBookedSlots
	* Purpose : To get the slots that are booked by the admin
	*/
	public function getAdminBookedSlots()
	{
		$adminBookedQuery = $this->db->get_where('bookings', ['booked_by' => "2", 'status' => "1"]); // Where 2 is the admin booked slots.
		$adminBookedTable = $adminBookedQuery->result_array();
		
		foreach ($adminBookedTable as $key => $tempBookedTable) {
			$adminBookedTable[$key]['courtDetails'] = $this->CourtsModel->getCourtDetails($tempBookedTable['courts_id']);
			$adminBookedTable[$key]['slotDetails'] = $this->SlotsModel->getSlotDetails($tempBookedTable['slots_id']);
			$adminBookedTable[$key]['userDetails'] = $this->UserModel->getUserDetailById($tempBookedTable['user_id']);
		}
		return $adminBookedTable;
	}

	/**
	* Name : getAllBookings
	* Purpose : To display all the booking to the admin. Both made by the customer and the admin.
	*/
	public function getAllBookings()
	{
		$allBookingsQuery = $this->db->get_where('bookings', ['booked_by IS NOT NULL', 'status' => "1"]); // where 1 is active status.
		$allBookingsTable = $allBookingsQuery->result_array();

		foreach ($allBookingsTable as $key => $tempBooking) {
			$allBookingsTable[$key]['courtDetails'] = $this->CourtsModel->getCourtDetails($tempBooking['courts_id']);
			$allBookingsTable[$key]['slotDetails'] = $this->SlotsModel->getSlotDetails($tempBooking['slots_id']);
			$allBookingsTable[$key]['userDetails'] = $this->UserModel->getUserDetailById($tempBooking['user_id']);
		}

		// To load the current day data for the admin.
		$todayDate = date('Y-m-d');
		$todayStartingTimeStamp = strtotime($todayDate.'00:00:00');
		$todayEndingTimeStamp = strtotime($todayDate.'23:23:59');
		$this->db->select("*");
		$this->db->from("bookings");
		$this->db->where("booked_on >= $todayStartingTimeStamp");
		$this->db->where("booked_on <= $todayEndingTimeStamp");
		$currentDataQuery = $this->db->get();
		$result = $currentDataQuery->result_array();
		$onlineBookings = 0;
		$onlineCollection = 0;
		$directBookings = 0;
		$directCollection = 0;
		$totalCollection = 0;
		foreach ($result as $key => $tempResult) {
			if ($tempResult['payment_type'] ==  2) { // where 2 is online payment status
				$onlineBookings++;
				$onlineCollection += $tempResult['amount'];
			}
			if ($tempResult['payment_type'] == 1) {
				$directBookings++;
				$directCollection += $tempResult['amount'];
			}
			$totalCollection = $onlineCollection + $directCollection;
		} // End of For loop

		$result['allBookingsTable'] = $allBookingsTable;
		//$result['booking'] = $booking;
		$result['onlineBookings'] = $onlineBookings; 
		$result['onlineCollection'] = $onlineCollection;
		$result['directBookings'] = $directBookings;
		$result['directCollection'] = $directCollection;
		$result['totalCollection'] = $totalCollection;
		return $result;
	}

	/**
	* Name : releaseAdminBooking
	* Purpose : To change the status of the bookings to available.
	*/
	public function releaseAdminBooking($bookingId, $dataProvider)
	{
		$this->db->where('bookings_id', $bookingId);
		$this->db->update('bookings', $dataProvider);
	}


	/**
	* Name : makePayment
	* Purpose : To collect booking fees from the customer by the admin.
	*/
	public function makePayment($bookingId, $dataProvider)
	{

		//$this->paymentGateway();

		$this->db->where('bookings_id', $bookingId);
		$this->db->update('bookings', $dataProvider);

		// Creating the invoice.
		$html=$this->load->view('admin/bookings/bill', $dataProvider, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "spunk_invoice.pdf";
 
        //load mPDF library
        $this->load->library('M_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //Open in browser
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
        redirect('admin/collection');

	}

	

	/**
	* Name : paymentGateway
	* Purpose : To initiate the payment gateway API to get the payment link.
	*/
	public function paymentGateway()
	{
		try {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
		    array("X-Api-Key:ca4b73c060cd7174a091c8dede84302f",
		    "X-Auth-Token:c4e9eae261d46d80a268f374bbfc2b6b")
		);
		$payload = Array(
		    'purpose' => 'Spunk Integration',
		    'amount' => '100',
		    'phone' => '9964154414',
		    'buyer_name' => 'Pravin',
		    'redirect_url' => 'http://localhost/spunk/payment-response',
		    'send_email' => false,
		    //'webhook' => '',
		    'send_sms' => false,
		    'email' => 'pravin@spotsoon.com',
		    'allow_repeated_payments' => false
		);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($payload));
		$response = curl_exec($ch);
		if ($response == false) {
			
			echo "<pre>";
			var_dump(curl_getinfo($ch));
			var_dump(curl_errno($ch));
			var_dump(curl_error($ch));
			exit;
			throw new Exception(curl_errno($ch), curl_errno($ch));
		}

		curl_close($ch); 
		echo "<pre>";
		//print_r(json_decode($response));exit;
		$result = json_decode($response);
		//redirect("$result->payment_request->longurl");
		header('Location: '.$result->payment_request->longurl.'');exit();
		print_r();exit;
		} catch (Exception $e) {
			echo "An execption is catched";
			//trigger_error(sprintf('Curl Failed with error #%d: %s', $e->getCode(), $e->getMessage(), E_USEE_ERROR));
		}
	}

	/**
	* Name : searchByDate
	* Purpose : To load the booking details that is present under the selected dates
	* @param string $startDate The starting date selected by the user.
	* @param string $endDate   The ending date selected by the user
	*/
	public function searchByDate($startDate, $endDate)
	{
		//var_dump($startDate);
		//var_dump($endDate); exit;
		//var_dump();exit;
		//$endDate = "2017-07-28";
		$startDate = strtotime($startDate."00:00:00");
		$endDate = strtotime($endDate."23:23:59");
		$this->db->select("*");
		$this->db->from("bookings");
		//$this->db->where('booked_on',"DATE_FORMAT(FROM_UNIXTIME(booked_on), '%Y-%m-%d')");

		//$this->db->where("booked_on between $startDate and $endDate");
		$this->db->where("booked_on >= $startDate");
		$this->db->where("booked_on <= $endDate");
		$Query = $this->db->get();
		$booking = $Query->result_array();
		$onlineBookings = 0;
		$onlineCollection = 0;
		$directBookings = 0;
		$directCollection = 0;
		$totalCollection = 0;
		foreach ($booking as $key => $tempBooking) {
			$booking[$key]['courtDetails'] = $this->CourtsModel->getCourtDetails($tempBooking['courts_id']);
			$booking[$key]['slotDetails'] = $this->SlotsModel->getSlotDetails($tempBooking['slots_id']);
			$booking[$key]['userDetails'] = $this->UserModel->getUserDetailById($tempBooking['user_id']);
			// Calculating no of online orders
			if ($tempBooking['payment_type'] ==  2) { // where 2 is online payment status
				$onlineBookings++;
				$onlineCollection += $tempBooking['amount'];
			}
			if ($tempBooking['payment_type'] == 1) {
				$directBookings++;
				$directCollection += $tempBooking['amount'];
			}

			$totalCollection = $onlineCollection + $directCollection;

		} // End of foreach
		$result['booking'] = $booking;
		$result['onlineBookings'] = $onlineBookings; 
		$result['onlineCollection'] = $onlineCollection;
		$result['directBookings'] = $directBookings;
		$result['directCollection'] = $directCollection;
		$result['totalCollection'] = $totalCollection;
		return $result;
	}
}
?>