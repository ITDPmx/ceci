<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

	public function __construct() {
		parent ::__construct();
		$this->load->library('session');
		$this->load->library('form_validation');
		$this->load->library('email');
		
		$this->load->helper('form');
		$this->load->helper('url');
		$this->load->helper('html');
		$this->load->helper('mysql_to_excel_helper');

		$this->load->database();
		$this->load->model('Curso_model');
	}

	public function index() {
		$this->isUser();

		if($this->session->userdata('role')== "1") {
			$this->admin();
		} else {
			$this->user();
		}
	}
	
	public function outputDashboardAdmin($view, $data = false) {
		$this->load->view('dashboard/header');
		$this->load->view('dashboard/' . $view, $data);
		$this->load->view('dashboard/footer');	
	}
	
	public function outputDashboardUser($view, $data = false) {
		$this->load->view('dashboard_user/header');
		$this->load->view('dashboard_user/' . $view, $data);
		$this->load->view('dashboard_user/footer');	
	}
	
	public function avanceUsuario($idUsuario= NULL){
		if ($idUsuario != NULL) {
			$data ['avanceUsuarios'][1]= $this->Curso_model->avanceUsuarios(1, $idUsuario);
			$data ['avanceUsuarios'][2]= $this->Curso_model->avanceUsuarios(2, $idUsuario);
			$data ['avanceUsuarios'][3]= $this->Curso_model->avanceUsuarios(3, $idUsuario);
			$data ['avanceUsuarios'][4]= $this->Curso_model->avanceUsuarios(4, $idUsuario);
			$data ['avanceUsuarios'][5]= $this->Curso_model->avanceUsuarios(5, $idUsuario);

		}else{
			$data = false;
		}

		header('Content-Type: application/json; charset=UTF-8');
		echo json_encode($data);
	}
	
	
	public function admin() {
		$this->isUser();

		if($this->session->userdata('role')== "1") {			
			$data['conteoUsuarios'] = $this->Curso_model->contadorUsuarios();
			$data['conteoReproducciones'] = $this->Curso_model->contadorVisitasVideos();
			$data['contadorGuias'] = $this->Curso_model->contadorGuias();
			
			$data['usuariosLista'] = $this->Curso_model->listaUsuarios();
			
			$data['usuariosPorEstado'] = $this->Curso_model->usuariosPorEstado();
			$data['usuariosPorSector'] = $this->Curso_model->usuariosPorSector();
		
			$data['selectUsuarios'] = $this->Curso_model->obtenerUsuarios();

			$this->outputDashboardAdmin('home', $data);
		} else {
			redirect('capacitacion','refresh');
		}
	}
	
	public function users() {
		$this->isUser();

		if($this->session->userdata('role')== "1") {
			$data['conteoUsuarios'] = $this->Curso_model->contadorUsuarios();
			$data['conteoReproducciones'] = $this->Curso_model->contadorVisitasVideos();
			$data['contadorGuias'] = $this->Curso_model->contadorGuias();
			
			$data['usuariosLista'] = $this->Curso_model->listaUsuarios();
			$data['usuariosPorEstado'] = $this->Curso_model->usuariosPorEstado();
			$data['usuariosPorSector'] = $this->Curso_model->usuariosPorSector();
			
			$data['selectUsuarios'] = $this->Curso_model->obtenerUsuarios();
			
			$this->outputDashboardAdmin('usuarios', $data);
		} else {
			redirect('capacitacion','refresh');
		}
	}
	
	public function guias() {
		$this->isUser();

		if($this->session->userdata('role')== "1") {
			$data['conteoUsuarios'] = $this->Curso_model->contadorUsuarios();
			$data['conteoReproducciones'] = $this->Curso_model->contadorVisitasVideos();
			$data['contadorGuias'] = $this->Curso_model->contadorGuias();
			
			$data['descargas'] = $this->Curso_model->totalDescargas();
			$data['descargasUsuarios'] = $this->Curso_model->descargasUsuarios();
			
			$this->outputDashboardAdmin('guias', $data);
		} else {
			redirect('capacitacion','refresh');
		}
	}
	
	public function videos() {
		$this->isUser();

		if($this->session->userdata('role')== "1") {
			$data['conteoUsuarios'] = $this->Curso_model->contadorUsuarios();
			$data['conteoReproducciones'] = $this->Curso_model->contadorVisitasVideos();
			$data['contadorGuias'] = $this->Curso_model->contadorGuias();
			
			$data['videos'] = $this->Curso_model->obtenerVisitasVideos();
			$data['videosUsuarios'] = $this->Curso_model->vistasUsuarios();
			
			$this->outputDashboardAdmin('videos', $data);
		} else {
			redirect('capacitacion','refresh');
		}
	}
	
	public function user() {
		$this->isUser();

		if($this->session->userdata('role')== "0") {
			$data['descargas'] = $this->Curso_model->totalDescargas();
			$data['descargasUsuarios'] = $this->Curso_model->descargasUsuarios();
			$data['conteoReproducciones'] = $this->Curso_model->contadorVisitasVideos($this->session->userdata('id_usuario'));
			$data['contadorGuias'] = $this->Curso_model->contadorGuias($this->session->userdata('id_usuario'));
			
			$this->outputDashboardUser('home', $data);
		} else {
			redirect('dashboard','refresh');
		}
	}

	public function cambiarPassword(){
		if($this->session->userdata('role')== "0") {
			$password = strip_tags($this->input->post('password'));
			$password2 = strip_tags($this->input->post('password2'));
			$idUsuario = $this->session->userdata('id_usuario');

			if($password == $password2) {
				$updatePassword = $this->Curso_model->changePassword(md5($password), $idUsuario);
				if($updatePassword == true) {
					$data = array("success" => true, "code" => 200);
					header('Content-Type: application/json; charset=UTF-z8');
					echo json_encode($data);
					exit;
				} else {
					$data = array("error" => false, "code" => 400);
					header('HTTP/1.1 400 Bad Request');
					header('Content-Type: application/json; charset=UTF-8');
					echo json_encode($data);
					exit;
				}
			} else {
				$data = array("error" => false, "code" => 400);
				header('HTTP/1.1 400 Bad Request');
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
				exit;
			}
		}
	}
	
	public function isUser(){
		if($this->session->userdata('id_usuario') != NULL)
			return true;
		else
			redirect('login', 'refresh'); 
	}


}
