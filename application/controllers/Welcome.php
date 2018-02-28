<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	public function __construct() {
		parent::__construct();

		$this->load->model('user/User_model', 'UserModel');
		$this->load->model('admin/Courts_model', 'CourtsModel');
		$this->load->model('admin/Slots_model', 'SlotsModel');
		$this->load->model('admin/Bookings_model', 'BookingsModel');
		//$this->load->view('admin/header');
		//$this->load->view('admin/header');
	}

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		//$this->load->view('admin/courts/create-court');
		//$this->load->view('admin/footer');
		$this->load->view('frontend/index');
	}

	/**
	* Name : aboutus
	* Purpose :  To load the aboutus page to the visitor
	*/
	public function aboutUs()
	{
		$this->load->view('frontend/about-us');	
	}

	/**
	* Name : courtCheckOut
	* Purpose :  To load the courtCheckOut page to the visitor
	*/
	public function courtCheckOut()
	{

		$selectedSlots = $this->session->userdata('userSelectedSlots');
		$slotsArray = explode(",", $selectedSlots);
		$resultArray = array();

		foreach ($slotsArray as $key => $value) {

			$slotIdArray = explode("-", $value); 
		    $bookingsId = $slotIdArray[0];
			$bookedSlotsDetailsQuery = $this->db->get_where('bookings', ['bookings_id'=>$bookingsId]);
			$bookedSlotsDetailsTable = $bookedSlotsDetailsQuery->row_array();
			$bookedSlotsDetailsTable['courtDetail'] = $this->CourtsModel->getCourtDetails($bookedSlotsDetailsTable['courts_id']);
			$bookedSlotsDetailsTable['slotDetail'] = $this->SlotsModel->getSlotDetails($bookedSlotsDetailsTable['slots_id']);
			$resultArray[$key] = $bookedSlotsDetailsTable;
		}
		$dataProvider['selectedSlots'] = $selectedSlots;
		$dataProvider['bookingDetails'] = $resultArray;
		$this->load->view('frontend/court-checkout', $dataProvider);
	}

	/**
	* Name : courtBooking
	* Purpose : To load the courtbooking page to the visitor
	*/
	public function courtBooking()
	{
		// To populate the courts in the home page.
		//$courtsDetail = $this->CourtsModel->getAllCourtsWithSlots();
		// Pulling inside an array.

		// For the first we are clearing the Slots session from the page.
		$this->session->unset_userdata('userSelectedSlots');
		// Loading all the courts and slots
		//$dataProvider = ['courtDetail' => $courtsDetail];
		$this->load->view('frontend/court-booking');	
	}

	/**
	* Name : gallery
	* Purpose : To load the gallery page to the visitor
	*/
	public function gallery()
	{
		$this->load->view('frontend/gallery');	
	}

	/**
	* Name : contactUs
	* Purpose : To load the contactus page to the visitor
	*/
	public function contactUs()
	{
		$this->load->view('frontend/contact-us');	
	}

	/**
	* Name : signUp
	* Purpose : To load the Signup page to the visitor and if the visitor submits the
	* signup-form, the form is validated and he will be registered to the System.
	*/	
	public function signup()
	{
		$this->form_validation->set_rules('firstname', 'Firstname', 'trim|required');
		$this->form_validation->set_rules('lastname', 'Lastname' , 'trim|required');
		$this->form_validation->set_rules('email', 'E-Mail' , 'trim|required|valid_email');
		$this->form_validation->set_rules('mobile', 'Mobile' , 'trim|required|numeric');
		$this->form_validation->set_rules('password', 'Password' , 'trim|required');
		$this->form_validation->set_rules('confirm_password', 'Confirm Password' , 'trim|required|matches[password]');
		$this->form_validation->set_rules('address', 'Address' , 'trim|required');
		$this->form_validation->set_rules('gender', 'Gender' , 'trim|required');
		if ($this->form_validation->run() === false ) { // If the validation has error show the form again
			$this->load->view('frontend/signup');
		} else { // If "No Validation error" then save the data

			$this->load->library('bcrypt');
			// if the emailId already saved by the admin during manul booking,
			// email may not be saved and other data can be saved.
			$userDetail = $this->UserModel->getUserDetail($this->input->post('email'));
			if (!empty($userDetail)) {
				
				// If the email is already present (because the user might
				// be already saved by the admin without password), then
				// we have to update all other details other than the email.
				$dataProvider = array(
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'mobile' => $this->input->post('mobile'),
					'gender' => $this->input->post('gender'),
					'address' => $this->input->post('address'),
					'enc_password' => $this->bcrypt->hash_password($this->input->post('password')),
					'password' => $this->input->post('password'),
					'role' => "2", // Self registered user
				);
				$updatedResult = $this->UserModel->updateUser($userDetail->email, $dataProvider);
				if ($updatedResult == true) {
					redirect('home');
				}
			} else {
				// If it is a new user
				$password = $this->input->post('password');
				$encPassword = $this->bcrypt->hash_password($password);
				$dataProvider = array(
					'firstname' => $this->input->post('firstname'),
					'lastname' => $this->input->post('lastname'),
					'mobile' => $this->input->post('mobile'),
					'email' => $this->input->post('email'),
					'gender' => $this->input->post('gender'),
					'address' => $this->input->post('address'),
					'enc_password' => $encPassword,
					'password' => $password,
					'role' => "2", // Self registered user

				);
				$this->UserModel->signupUser($dataProvider);
				redirect('home');
			} // End of Registration check (Else part)
			
		} // end of Validation-check else loop.
		
	}

	/**
	* Name : login
	* Purpose : Logging in the user.
	*/
	public function login()
	{

		$this->load->library('bcrypt');

		$email = $this->input->post('username');
		$userRow = $this->UserModel->getUserDetail($email);
		$role = $userRow->role;
		// Only the Users who registered themselves are allowed to login.
		if (!empty($userRow) && $role == 2) {
			$password = $this->input->post('password');
			$encPassword = $userRow->enc_password;
			if ($this->bcrypt->check_password($password, $encPassword)) {
				$sessionVariables = array(
				'username' => $userRow->email,
				'firstname' => $userRow->firstname,
				'lastname' => $userRow->lastname,
				'mobile' => $userRow->mobile,
				);
				$this->session->set_userdata($sessionVariables);
				
				echo "2"; exit;
			} else {
				// Password does not match stored password.
				echo "1";exit;
			}	
		} else {
			echo "0"; exit;
		}
	}

	/**
	* Name : logout
	* Purpose : To logout the user from the system.
	*/
	public function logout()
	{
		$this->session->unset_userdata(['username', 'firstname', 'lastname', 'mobile']);
		redirect('home');
	}


	/**
	* Name : saveSession
	* Purpose : To save the user selected slots in the session. This 
	* function is called through Ajax
	*/
	public function saveSession()
	{
		$post = $this->input->post('selectedSlots');
		$this->session->set_userdata('userSelectedSlots', $post);
		$sessionVariables = $this->session->userdata(); // Not used
	}

	/**
	* Name : adminLogin
	* Purpose : To validate the username and password of admin and login
	*/
	public function adminLogin()
	{
		$this->form_validation->set_rules('username', "Username", 'trim|required');
		$this->form_validation->set_rules('password', "Password", 'trim|required');
		if ($this->form_validation->run() === false) {
			$this->load->view('admin/admin-login');
		} else {
			$this->load->library('bcrypt');
			$email = $this->input->post('username');
			$userRow = $this->UserModel->getUserDetail($email);
			if (!empty($userRow) && $userRow->role == 1) {
				$password = $this->input->post('password');
				$encPassword = $userRow->enc_password;
				if ($this->bcrypt->check_password($password, $encPassword)) {
					$sessionVariables = array(
					'username' => $userRow->email,
					'firstname' => $userRow->firstname,
					'lastname' => $userRow->lastname,
					'mobile' => $userRow->mobile,
					);
					$this->session->set_userdata($sessionVariables);
					
					redirect('courts/create');
				} else {
					// Password does not match stored password.
					$this->session->set_flashdata('password', 'Password did not match');
					redirect('admin/login');
				}	
			} else {
				// No such Email Exists
				$this->session->set_flashdata('nomail', 'No Such Mail Exists');
				redirect('admin/login'); 
			}
		}
	}

	/**
	* Name : makeCustomerPayment
	* Purpose : To redirect the customer to a payment gateway.
	*/
	public function makeCustomerPayment()
	{
		$userRow = $this->UserModel->getUserDetail($this->input->post('email'));
		if (!empty($userRow)) {
			
			// Calling the paymentGateway initiater
			$this->callPaymentGateway(
				$userRow->firstname, 
				$userRow->email,
				$userRow->mobile,
				$this->input->post('price')
			);
		} else { // If no such user is present then we have to save the user in the user-table
			// without the password and then the details to be saved.
			$userDataProvider = array(
				'firstname' => $this->input->post('name'),
				'email' => $this->input->post('email'),
				'mobile' => $this->input->post('mobile'),
				'role' => '3', // 3 is Guest user
			);
			$insertedId = $this->UserModel->signupUserByAdmin($userDataProvider);
			if ($insertedId > 0) {
				// Calling the paymentGateway initiater
				$this->callPaymentGateway(
					$this->input->post('name'),
					$this->input->post('email'), 
					$this->input->post('mobile'),
					$this->input->post('price')
				);
			} else {
				// The User is not saved in the user-table.
			} // End of else
		} // End of user-existing-check else loop.
	}

	/**
	* Name : callPaymentGateway
	* Purpose : Once the user is saved in the DB system, we need to
	* re-direct to the Payment gateway page.
	*/
	public function callPaymentGateway($firstname, $email, $mobile, $price)
	{
		try {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, 'https://www.instamojo.com/api/1.1/payment-requests/');
			curl_setopt($ch, CURLOPT_HEADER, FALSE);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_HTTPHEADER,
			    array(
			    	"X-Api-Key:ca4b73c060cd7174a091c8dede84302f",
			    	"X-Auth-Token:c4e9eae261d46d80a268f374bbfc2b6b"
			    )
			);
			$payload = Array(
			    'purpose' => 'SPUNK',
			    'amount' => $price,
			    'phone' => $mobile,
			    'buyer_name' => $firstname,
			    'redirect_url' => 'http://localhost/spunk/payment-response',
			    'send_email' => false,
			    //'webhook' => '',
			    'send_sms' => false,
			    'email' => $email,
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
			print_r("Payment Gateway not reached");exit;
			} else {
				curl_close($ch); 
				$result = json_decode($response);
				//Redirecting to payment gateway page.
				header('Location: '.$result->payment_request->longurl.'');exit();	
			}
		} catch (Exception $e) {
			echo "An execption is catched";
		}
	}

	/**
	* Name : PaymentResponse
	* Purpose : An auto call back funtion from the payment gateway.
	*/
	public function PaymentResponse()
	{
		$instaMojoID = $_GET['payment_id'];
		$paymentRequestId = $_GET['payment_request_id'];
		// Now to request the payment details of the payment Id
		$url = "https://www.instamojo.com/api/1.1/payment-requests/$paymentRequestId";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_HTTPHEADER,
		    array(
		    	"X-Api-Key:ca4b73c060cd7174a091c8dede84302f",
		        "X-Auth-Token:c4e9eae261d46d80a268f374bbfc2b6b"
		    )
		);
		$response = curl_exec($ch);
		if ($response == false) {
			echo "<pre>";
			var_dump(curl_getinfo($ch));
			var_dump(curl_errno($ch));
			var_dump(curl_error($ch));
			exit;
		} else {
				
		}
		curl_close($ch);
		$result = json_decode($response);
		$paymentStatus = $result->payment_request->payments[0]->status;
		$buyerEmail = $result->payment_request->payments[0]->buyer_email;

		if ($paymentStatus == 'Credit') {
			$this->saveBookingSlots($paymentRequestId, $buyerEmail);
		} else {
			// Error page has to be displayed.
		}
	}


	/**
	* Name : saveBookingSlots
	* Purpose : To update the "bookings-table" with the booking details 
	*/
	public function saveBookingSlots($paymentRequestId, $buyerEmail)
	{
		$bookedSlots = $this->session->userdata('userSelectedSlots');
		$bookedSlotsArray = explode(',', $bookedSlots);
		$userRow = $this->UserModel->getUserDetail($buyerEmail);
		if (!empty($userRow)) {
			foreach ($bookedSlotsArray as $key => $tempSlots) {
				$bookingId = explode('-', $tempSlots);
				$bookingDataProvider = array(
					'user_id' => $userRow->user_id,
					'booked_by' => '1', // where 1 is the status for customer.
					'booked_on' => time(),
					'payment_type' => '2', // Where 2 is online payment.
					'transaction_id' => $paymentRequestId,
					'payment_status' => '1', // Where 1 is success.
					'amount' => $bookingId[1],
					'status'=> '1', // Where 1 is Booked(Not Available)
				);
				$this->BookingsModel->bookByCustomer($bookingId[0], $bookingDataProvider);
			} // end of Foreach.	
		} // user validity checked.
		$this->session->unset_userdata('userSelectedSlots');
		redirect('home');
	}


	/**
	* Name : referFriend
	* Purpose : To send reference email to the friend of the visitor.
	*/
	public function referFriend()
	{
		var_dump($_POST);exit;
		$html = 'First Name: '. $_POST['name'] .'
		Email: '.$_POST['email'].'
		Phone: '.$_POST['contactnumber'].'
		Message: '.$_POST['message'];
		$message = $html;
		$subject = 'Friend reference SPUNK Website'; 
		$headers = 'From:support@bigappcompany.com' . "\r\n" . 'Reply-To:support@bigappcompany.com' . "\r\n" . 'X-Mailer: PHP/' . phpversion(); 
		$to ='pravin@spotsoon.com';
		if(mail($to, $subject, $message, $headers)) {
		     echo "<script>alert('Thanks For Contacting. We will contact you shortly.');location.href='http://localhost/spunk'</script>";
		}
		else 
		{
		    echo "<script>alert('Unable to send mail. Please try after some time.');location.href='http://localhost/spunk/'</script>"; 
		}
	}

	
	public function newsletter()
	{
		redirect('home');
	}
}