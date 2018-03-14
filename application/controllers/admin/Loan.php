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

        $this->form_validation->set_rules('user_id', 'Customer', 'trim|required');
        $this->form_validation->set_rules('vehicle_id', 'Vehicle Number', 'trim|required');
        $this->form_validation->set_rules('loan_value', 'Loan Amount', 'trim|required');
        $this->form_validation->set_rules('no_of_installments', 'No of Installments', 'trim|integer|required');
        if ($this->form_validation->run() === FALSE) { 
            $userList = $this->UserModel->getCustomerList();
            $dataProvider['userList'] = $userList;
            $this->load->view('admin/loan/create-loan', $dataProvider);
            $this->load->view('admin/footer.php');
        } else {

            $dataProvider = [
                'user_id' => $this->input->post('user_id'),
                'vehicle_id' => $this->input->post('vehicle_id'),
                'loan_value' => $this->input->post('loan_value'),
                'interest_percentage' => $this->input->post('interest_percentage'),
                'no_of_installments' => $this->input->post('no_of_installments'),
                'monthly_principle' => $this->input->post('monthly_principle'),
                'monthly_interest' => $this->input->post('monthly_interest'),
                'installment_amount' => $this->input->post('monthly_principle') + $this->input->post('monthly_interest'),
                'total_paid' => 0,
                'installments_paid' => 0,
                'created_at' => time(),
                'updated_at' => time()
            ];

            // To save the installments
            $saveLoan = $this->CustomerModel->saveLoan($dataProvider);
            for ($i = 0 ; $i < $this->input->post('no_of_installments'); $i++) {
                $dataProvider = [
                    'loan_id' => $saveLoan,
                    'monthly_principle' => $this->input->post('monthly_principle'),
                    'monthly_interest' => $this->input->post('monthly_interest'),
                    'fine' => 0,
                    'status' => 0, 
                    'created_at' => time(),
                    'updated_at' => time()
                ];
                $saveInstallments = $this->CustomerModel->saveInstallments($dataProvider);
            }
            redirect('admin/loan/createLoan');
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
} //End of class file

?>