<?php 

defined('BASEPATH') OR exit('No direct script access allowed');
class Loan extends CI_Controller {
	function __construct()
	{
		parent::__construct();
		$this->load->view('admin/header');
		// Loading the models here.
		$this->load->model('admin/Customer_model', 'CustomerModel');
        $this->load->model('admin/User_model', 'UserModel');
	}

    public function CreateLoan()
    {
        $userList = $this->UserModel->getCustomerList();
        $dataProvider['userList'] = $userList;
        $this->load->view('admin/loan/create-loan', $dataProvider);
        $this->load->view('admin/footer.php');
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
} //End of class file

?>