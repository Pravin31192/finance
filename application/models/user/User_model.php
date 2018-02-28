<?php 
class User_model extends CI_Model {

	public function __construct()
	{
		parent::__construct();
	}

	/**
	* Name : signUpUser
	* Purpose : to save the user basic detail in the user table during the signup action
	*/
	public function signupUser($dataProvider)
	{

		if ($this->db->insert('user', $dataProvider) == 1) {
			// If the user is registered, store the session variables
			$sessionVariables = array(
				'username' => $dataProvider['email'],
				'firstname' => $dataProvider['firstname'],
				'lastname' => $dataProvider['lastname'],
			);
			$this->session->set_userdata($sessionVariables);
		} else {
			// An error page has to be displayed.
		}
	}

	/**
	* Name : getUserDetail
	* Purpose : To get the userdetails of the user with the incoming email
	* param string $email The email id of the user whose user-table-row has
	* to be pulled out.
	*/
	public function getUserDetail($email)
	{
		$userTable = $this->db->get_where('user', ['email'=>$email]);
		$userRow = $userTable->row();
		return $userRow;
	}

	/**
	* Name : getUserDetailById
	* Purpose : To get the userdetails of the user with the incoming $id
	* @param string $id The id of the user whose user-table-row has
	* to be pulled out.
	*/
	public function getUserDetailById($id)
	{
		$userTable = $this->db->get_where('user', ['user_id'=>$id]);
		$userRow = $userTable->row();
		return $userRow;
	}

	/**
	* Name : updateUser
	* Purpose : To update the user table
	* @param string $email        The email id of the user who is registering
	* @param array  $dataProvider The array containing the user value.
	*/
	public function updateUser($email, $dataProvider)
	{
		$this->db->where('email', $email);
		$result =  $this->db->update('user', $dataProvider);
		if ($result == 1) {
			$sessionVariables = array(
				'username' => $dataProvider['email'],
				'firstname' => $dataProvider['firstname'],
				'lastname' => $dataProvider['lastname'],
			);
			$this->session->set_userdata($sessionVariables);
			return true;
		}
		
	}

	/**
	* Name : signUpUserByAdmin
	* Purpose : to save the user basic detail in the user table during admin
	* blocking the court for some of the user.
	*/
	public function signupUserByAdmin($dataProvider)
	{

		if ($this->db->insert('user', $dataProvider) == 1) {
			return $this->db->insert_id();
		} else {
			// An error page has to be displayed.
		}
	}
}
?>