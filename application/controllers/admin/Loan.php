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
            
            
            $updateInstallmentDetails['status'] = 1;
            $updateInstallmentDetails['fine'] = $this->input->post('fine');
            $updateInstallmentDetails['updated_at'] = time();
           /* $this->CustomerModel->updateInstallmentDetails(
                $id,
                $updateInstallmentDetails
            );*/

            $loanDetails = $this->CustomerModel->getLoanDetails($installmentDetails->loan_id);
            $updateLoanDetails['installments_paid'] = $loanDetails->installments_paid + 1;
            $totalPaid = $installmentDetails->monthly_principle + $installmentDetails->monthly_interest + $this->input->post('fine');
            $updateLoanDetails['total_paid'] += $totalPaid;
            $updateLoanDetails['updated_at'] = time();
            $this->CustomerModel->updateLoanDetails(
                $loanDetails->id,
                $updateLoanDetails
            );
            redirect('admin/loan/view/'.$loanDetails->id);
        } else {
            redirect('admin/loan/collectionList');
        }

    }

    public function printInstallment($id)
    {
        $installmentDetails = $this->CustomerModel->getInstallmentDetails($id);
        $loanDetails = $this->CustomerModel->getLoanDetails($installmentDetails->loan_id);
        $dataProvider['installmentDetails'] = $installmentDetails;
        $dataProvider['loanDetails'] = $loanDetails;

        $html=$this->load->view('admin/loan/installment-bill', $dataProvider, true);
 
        //this the the PDF filename that user will get to download
        $pdfFilePath = "loan_invoice.pdf";
 
        //load mPDF library
        $this->load->library('M_pdf');
 
       //generate the PDF from the given html
        $this->m_pdf->pdf->WriteHTML($html);
 
        //Open in browser
        $this->m_pdf->pdf->Output($pdfFilePath, "I");
        //redirect('admin/collection');

    }

    public function CreateLoan()
    {

        $this->form_validation->set_rules('user_id', 'Customer', 'trim|required');
        $this->form_validation->set_rules('vehicle_id', 'Vehicle Number', 'trim|required');
        $this->form_validation->set_rules('loan_no', 'Loan Number', 'trim|required');
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
                'loan_no' => $this->input->post('loan_no'),
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
            redirect('admin/loan/collectionList');
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
            $userDetail = $this->CustomerModel->getCustomerById($this->input->post('user_id'));
            $userName = $userDetail->first_name.' '.$userDetail->last_name;
            $dataProvider = [
                'user_id' => $this->input->post('user_id'),
                'user_name' => $userName,
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