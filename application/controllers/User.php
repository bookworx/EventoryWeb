<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	function __construct(){
		parent::__construct();
		$this->load->model('users_model');
		// load form and url helpers
        $this->load->helper(array('form', 'url'));
        // load form_validation library
        $this->load->library('form_validation');
	}
	
	public function index(){
		//load session library
		$this->load->library('session');
		$this->load->view('login');		
	}

	public function login(){
		//load session library
		$this->load->library('session');

		$email = $_POST['email'];
		$password = $_POST['password'];

		$data = $this->users_model->login($email, $password);

		if($data){
			$this->session->set_userdata('user', $data);
			$data['users'] = $this->users_model->getAllUsers();
			$this->load->view('supplier',$data);	
		}
		else{
			header('location:'.base_url().$this->index());
			$this->session->set_flashdata('error','Invalid login. User not found');
		} 
	}

	public function home(){
		//load session library
		$this->load->library('session');

		//restrict users to go to home if not logged in
		if($this->session->userdata('user')){
			$this->load->view('home');
		}
		else{
			redirect('/');
		}
		
	}

	// public function delete(){

	// 	$id = $_GET['del'];
	// 	$sql = "DELETE FROM tblstudent WHERE id='$id'";

	// }

	public function logout(){
		//load session library
		$this->load->library('session');
		$this->session->unset_userdata('user');
		redirect('/');
	}

}
