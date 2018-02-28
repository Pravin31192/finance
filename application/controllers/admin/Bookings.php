<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Bookings extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->view('admin/header');
		// Loading the models here.
		$this->load->model('admin/Bookings_model', 'BookingsModel');
		$this->load->model('admin/Courts_model', 'CourtsModel');
		$this->load->model('admin/Slots_model', 'SlotsModel');
		$this->load->model('user/User_model', 'UserModel');
	}

	public function ViewBookings()
	{
		$bookingsTable = $this->BookingsModel->getBookings();
		// Putting the result in an array.
		$dataProvider['bookingsTable'] = $bookingsTable;
		$this->load->view('admin/bookings/view-bookings', $dataProvider);
		$this->load->view('admin/footer');
		//var_dump("Bookings Controller");exit;
	}


	/**
	* Name : CheckBookings()
	* Purpose : To check the bookings for the current date. If there are no
	* booking for the selected date we are creating a set a new records and 
	* displayed to the customer as well as the admin.
	*/
	public function CheckBookings()
	{
		$selectedDate = $this->input->post('selected-date');
		if (!empty($selectedDate)) {
			$allCourtsWithBookingSlot = $this->CourtsModel->loadSlotsFromBookingTable($selectedDate);
        	// Calling the same function again to pull the data.
        	$slot_details = $this->CourtsModel->loadSlotsFromBookingTable($selectedDate);
        	$dataProvider['bookingDetailsForDate'] = $slot_details;
        	$dataProvider['selectedDate'] = $selectedDate;
		} else {
			$dataProvider['bookingDetailsForDate'] = '';
		}
		 
		$this->load->view('admin/bookings/view-bookings', $dataProvider);
		$this->load->view('admin/footer');
	}

	/**
	* Name : BookSlotForCustomer
	* Purpose : To book the slots for the customer from the admin side.
	*/
	public function BookSlotForCustomer()
	{
		$adminSelectedSlots = $this->input->post('slots');
		$adminSelectedSlotsArray = explode(',', $adminSelectedSlots);

		// Before booking the slots, the user is saved in the user table.
		$userRow = $this->UserModel->getUserDetail($this->input->post('email'));
		if (!empty($userRow)) {
			
			// To update the booking slots with a status and user id.
			foreach ($adminSelectedSlotsArray as $key => $tempBookingId) {
				$bookingsDataProvider = array(
				'user_id' => $userRow->user_id,
				'booked_by' => '2', // Where 2 is the admin status
				'amount' => '0',
				'booked_on' => date('Y-m-d'), //time(),
				'status' => '1', // Where 1 is booked
				);
				$this->BookingsModel->bookByAdmin($tempBookingId, $bookingsDataProvider);
			} // End of foreach
			redirect('admin/bookings');
		} else { // If no such user is present then we have to save the user in the user-table
			// without the password and then the details to be saved.
			$userDataProvider = array(
				'firstname' => $this->input->post('firstname'),
				'lastname' => $this->input->post('lastname'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'role' => '3',
			);
			$insertedId = $this->UserModel->signupUserByAdmin($userDataProvider);
			if ($insertedId > 0) {
				// After the insertion of user the booking may be done.

				// To update the booking slots with a status and user id.
				foreach ($adminSelectedSlotsArray as $key => $tempBookingId) {
					$bookingsDataProvider = array(
						'user_id' => $insertedId,
						'booked_by' => '2', // Where 2 is the admin status
						'amount' => '0',
						'booked_on' => date('Y-m-d'), //time(),
						'status' => '1',
					);
					$this->BookingsModel->bookByAdmin($tempBookingId, $bookingsDataProvider);
				} // End of foreach
				redirect('admin/bookings');
			} else {
				// The User is not saved in the user-table.
			} // End of else
		} // End of user-existing-check else loop.
	} // End of function.


	/**
	* Name : BookingCollection
	* Purpose : to show the list of bookings made by the admin and to show the collection record
	*/
	public function BookingCollection()
	{
		$adminBookedSlots = $this->BookingsModel->getAdminBookedSlots();
		$dataProvider['adminBookedSlots'] = $adminBookedSlots;
		$this->load->view('admin/bookings/collection', $dataProvider);
		$this->load->view('admin/footer');
	}


	/**
	* Name : GetAllBookings
	* Purpose : To get all the bookings of the user as well as admin
	*/
	public function GetAllBookings()
	{
		$result = $this->BookingsModel->getAllBookings();

		$dataProvider['allBookings'] = $result['allBookingsTable'];
		$dataProvider['onlineBookings'] = $result['onlineBookings'];
		$dataProvider['onlineCollection'] = $result['onlineCollection'];
		$dataProvider['directBookings'] = $result['directBookings'];
		$dataProvider['directCollection'] = $result['directCollection'];
		$dataProvider['totalCollection'] = $result['totalCollection'];
		
		$this->load->view('admin/bookings/all-bookings', $dataProvider);
		$this->load->view('admin/footer');
	}

	/**
	* Name : BookingReleaseByAdmin
	* Purpose : To release the booking that is done by Admin
	*/
	public function BookingReleaseByAdmin($bookingId)
	{
		$dataProvider = array(
			'status' => '0',
			'booked_by' => NULL,
		);
		$this->BookingsModel->releaseAdminBooking($bookingId, $dataProvider);
		redirect('admin/collection');
	}

	/**
	* Name : PayForBookings
	* Purpose : Providing the admin to pay for the bookings.
	*/
	public function PayForBookings()
	{
		$bookingId = $this->input->post('bookings');
		$amount = $this->input->post('amount-paid');
		$paymentMode = $this->input->post('mode-of-payment');
		$dataProvider = array(
			'amount' => $amount,
			'payment_type' => $paymentMode,
		);
		$this->BookingsModel->makePayment($bookingId, $dataProvider);
		//redirect('admin/collection');
	}

	/**
	* Name : DateSearch
	* Purpose : To search and fetch the records for the given date
	*/
	public function DateSearch()
	{
		$startDate = $this->input->post('start');
		$endDate = $this->input->post('end');
		$dataProvider['startDate'] = $startDate;
		$dataProvider['endDate'] = $endDate;
		$startDate = date('Y-m-d', strtotime($startDate));
		$endDate = date('Y-m-d', strtotime($endDate));
		$result = $this->BookingsModel->searchByDate($startDate, $endDate);
		$dataProvider['allBookings'] = $result['booking'];
		$dataProvider['onlineBookings'] = $result['onlineBookings'];
		$dataProvider['onlineCollection'] = $result['onlineCollection'];
		$dataProvider['directBookings'] = $result['directBookings'];
		$dataProvider['directCollection'] = $result['directCollection'];
		$dataProvider['totalCollection'] = $result['totalCollection'];
		$this->load->view('admin/bookings/all-bookings', $dataProvider);
		$this->load->view('admin/footer');
	}
} //End of class file

?>