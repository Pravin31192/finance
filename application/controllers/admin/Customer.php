<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Customer extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->view('admin/header');
		// Loading the models here.
		$this->load->model('admin/Customer_model', 'CustomerModel');
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
		$this->load->view('admin/vehicle/create-vehicle');
		$this->load->view('admin/footer.php');
	}


} //End of class file

?>