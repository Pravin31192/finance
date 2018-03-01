<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->view('admin/header');
		// Loading the models here.
		$this->load->model('admin/Customer_model', 'CustomerModel');
        $this->load->model('admin/User_model', 'UserModel');
	}

	function numeric_wcomma($str)
	{
		$validation = preg_match('/^[0-9, ]+$/', $str);
		if ($validation == 0) {
			$this->form_validation->set_message('numeric_wcomma', 'Only number and comma are allowed');
            return false;
		} else {
			return true;
		}
    	
	}


	public function CreateCustomer()
	{
		$this->form_validation->set_rules('first_name', 'First Name', 'trim|required');
        $this->form_validation->set_rules('last_name', 'Last Name', 'trim|required');
        $this->form_validation->set_rules('father_name', 'Father Name', 'trim|required');
        $this->form_validation->set_rules('address', 'Description', 'trim');
        $this->form_validation->set_rules('gender', 'Gender', 'trim|required');
        $this->form_validation->set_rules('mobile', 'Mobile', 'trim|required|callback_numeric_wcomma');
        /*$this->form_validation->set_rules('closing_time', 'Closing Time', 'trim|required|callback_check_time_difference');*/
		if ($this->form_validation->run() === FALSE) { 
 			$this->load->view('admin/customer/create-customer');
		} else {
			// To save the user values in the user table.
			$dataProvider = [
				'first_name' => $this->input->post('first_name'),
            	'last_name' => $this->input->post('last_name'),
            	'father_name' => $this->input->post('address'),
            	'address' => $this->input->post('father_name'),
                'gender' => $this->input->post('gender'),
                'mobile' => $this->input->post('mobile'),
                'role' => 2,
                'created_at' => time(),
                'updated_at' => time(),
			];
			$insert = $this->CustomerModel->saveCustomer($dataProvider);
			$this->session->flashdata('success-message', "Customer Created Successfully");
			redirect('admin/customer/create');
		}
	}


	public function SaveVehicle()
	{
        $this->form_validation->set_rules('user_id', 'Customer', 'trim|required');
        $this->form_validation->set_rules('vehicle_name', 'Vehicle Name', 'trim|required');
        $this->form_validation->set_rules('vehicle_model', 'Vehicle Model', 'trim|required');
        $this->form_validation->set_rules('vehicle_company', 'Vechicle Company', 'trim|required');
        $this->form_validation->set_rules('reg_number', 'Registration Number', 'trim|required');
        if ($this->form_validation->run() === FALSE) { 
            $userList = $this->UserModel->getCustomerList();
            $dataProvider['userList'] = $userList;
            $this->load->view('admin/vehicle/create-vehicle', $dataProvider);
            $this->load->view('admin/footer.php');
        } else {

            $dataProvider = [
                'user_id' => $this->input->post('user_id'),
                'vehicle_name' => $this->input->post('vehicle_name'),
                'vehicle_model' => $this->input->post('vehicle_model'),
                'vehicle_company' => $this->input->post('vehicle_company'),
                'reg_number' => $this->input->post('reg_number'),
                'created_at' => time(),
                'updated_at' => time()
            ];
            $insert = $this->CustomerModel->saveVehicle($dataProvider);
            $this->session->flashdata('success-message', "Customer Created Successfully");
            redirect('admin/customer/saveVehicle');
        }
	}

    public function loadCustomerVehicles()
    {
        echo "hello";exit;
        $customerId = $this->input->post('customerId');
        $customerVehicles = $this->CustomerModel->getCustomerVehicles($customerId);
    }

} //End of class file

?>