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


    public function collectionList()
    {
        $loanList = $this->CustomerModel->getLoanList();
        $dataProvider['loanList'] = $loanList;
        $this->load->view('admin/loan/loan-list', $dataProvider);
        $this->load->view('admin/footer.php');
    }


    public function viewLoan($id){
        $loanDetails = $this->CustomerModel->getInstallmentList($id);
        $dataProvider['installmentList'] = $loanDetails;
        $this->load->view('admin/loan/loan-installment-list', $dataProvider);
        $this->load->view('admin/footer.php');
    }

    public function initiateInstallment($id) {
        $installmentDetails = $this->CustomerModel->getInstallmentDetails($id);
        $dataProvider['installmentDetails'] = $installmentDetails;
        $this->load->view('admin/loan/pay-installment', $dataProvider);
        $this->load->view('admin/footer.php');
    }

    public function payInsallmentSubmit()
    {
        $id = $this->input->post('id');
        if (isset($id) && $id != null) {
            $installmentDetails = $this->CustomerModel->getInstallmentDetails($id);
            $loanDetails = $this->CustomerModel->getLoanDetails($installmentDetails->loan_id);
            
            $updateInstallmentDetails['status'] = 1;
            $updateInstallmentDetails['fine'] = $this->input->post('fine');
            $this->CustomerModel->updateInstallmentDetails(
                $id,
                $updateInstallmentDetails
            );
            exit;
        } else {
            redirect('admin/loan/collectionList');
        }

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
            $userDetail = $this->CustomerModel->getCustomerById($this->input->post('user_id'));
            
            $userName = $userDetail->first_name.' '.$userDetail->last_name;
            $noOfInstallments = $this->input->post('no_of_installments');
            $monthlyPay = $this->input->post('monthly_principle') + $this->input->post('monthly_interest');
            $dataProvider = [
                'user_id' => $this->input->post('user_id'),
                'customer_name' => $userName,
                'vehicle_id' => $this->input->post('vehicle_id'),
                'loan_value' => $this->input->post('loan_value'),
                'interest_percentage' => $this->input->post('interest_percentage'),
                'no_of_installments' => $noOfInstallments,
                'monthly_principle' => $this->input->post('monthly_principle'),
                'monthly_interest' => $this->input->post('monthly_interest'),
                'installment_amount' => $monthlyPay,
                'total_paid' => 0,
                'total_to_pay' => $monthlyPay * $noOfInstallments,
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