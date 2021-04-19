<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

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
		$this->output('home', false);
	}
	
	public function login() {
        if($this->session->userdata('id_usuario') != NULL)
			redirect('capacitacion','refresh');
		else
			$this->output('login', false);
	}

	public function recuperarPassword() {
		$this->output('recovery', false);
	}
	
	public function recovery() {
		$email = strip_tags($this->input->post('email'));	
		$password =  $this->Curso_model->generateRandomString();
		$user = $this->Curso_model->userExists($email);
		
		if($user !== NULL) {
			$this->Curso_model->changePassword(md5($password), $user->id_usuario);
			
			$this->email->from('no-reply@ceci.itdp.mx', 'CECI');
			$this->email->to($email);
			
			$html = "<h3 style='color: #2f6b91;'>Recuperación de Accesos:</h3><br/>";
			$html .= '<img src="' . base_url() . 'assets/images/email.png" title="CECI" width="700"><br/><br/>';
			
			$html .= "Tus datos para acceder a la plataforma son los siguientes:<br/>";
			$html .= "<strong>Usuario</strong>: " . $email . "<br/>";
			$html .= "<strong>Contraseña (nueva)</strong>: " . $password . "<br/><br/>";
			
			$html .= "Ingresa a <strong>http://ceci.itdp.mx/login</strong><br/><br/>";
			
			$html .= "<h3 style='color: #2f6b91;'><strong >¡Gracias por transformar tu ciudad!</strong></h3>";
			
			$this->email->subject('Accesos a CECI');
			$this->email->message($html);
			$this->email->set_mailtype('html');
			$this->email->send();
			
			$data = array("success" => true, "code" => 200);
			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($data);
			exit;
		} else {
			$data = array("error" => "email", "code" => 400);
			header('HTTP/1.1 400 Bad Request');
			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($data);
		}
	}
	
	public function menuCurso() {
		$this->isUser();
		$this->output('menuCurso', false);
	}

	public function output($view, $data = false) {
		$this->load->view('header');
		$this->load->view($view, $data);
		$this->load->view('footer');
	}
	
	public function capacitacion() {
		$this->isUser();
		$this->output('capacitacion', false);
	}	
	
	public function biblioteca() {
		$this->isUser();
		$this->output('biblioteca', false);
	}
	
	public function financiamiento() {
		$this->isUser();
		$this->output('financiamiento', false);
	}
	
	public function calculadora() {
		$this->isUser();
		$this->output('calculadora', false);
	}

	public function resumen() {
		$this->isUser();
		$this->output('resumen', false);
	}
	
	public function testExist($idModalidad){
		$this->isUser();
		$idUsuario = $this->session->userdata('id_usuario');
		$validarExamen = $this->Curso_model->testExist($idUsuario, $idModalidad);
		
		if ($validarExamen !== false) {
			$data = array("success" => true, "code" => 200, "data" => $validarExamen);
			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($data);
		} else {
			$data = array("error" => false, "code" => 400);
			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($data);
			exit;
		}
	}

	public function add() {
		$nombre = strip_tags($this->input->post('nombre'));	
		$estado = strip_tags($this->input->post('estado'));		
		$ciudad = strip_tags($this->input->post('ciudad'));							
		$sector = strip_tags($this->input->post('sector'));
		$dependencia = strip_tags($this->input->post('dependencia'));
		$email = strip_tags($this->input->post('email'));
		$password =  $this->Curso_model->generateRandomString();
		$status = strip_tags($this->input->post('status'));						
		
		if($this->Curso_model->userExists($email) !== NULL) {
			$data = array("error" => "email", "code" => 400);
			header('HTTP/1.1 400 Bad Request');
			header('Content-Type: application/json; charset=UTF-8');
			echo json_encode($data);
			exit;
		} else { 
			$nuevoInsert = $this->Curso_model->insert($nombre,$estado,$ciudad,$sector,$dependencia,$email,md5($password),$status);
			
			if($nuevoInsert !== 0) {
				$this->email->from('no-reply@ceci.itdp.mx', 'CECI');
				$this->email->to($email);
				$html = "<h3 style='color: #2f6b91;font-family:Verdana;'>Te damos la bienvenida a CECI</h3><br/>";
				$html .= '<img src="' . base_url() . 'assets/images/email.png" title="CECI" width="700"><br/><br/>';
				$html .= "Te damos la bienvenida a CECI: Ciudad Equitativa, Ciudad Inclusiva donde podrás capacitarte en la implementación de proyectos de las cinco modalidades de la Estrategia de Movilidad Urbana Sustentable (EMUS):<br/><br/>";
				
				$html .= "Tus datos para acceder a la plataforma son los siguientes:<br/>";
				
				$html .= "<strong>Usuario</strong>: " . $email ."<br/><br/>";
				$html .= "<strong>Contraseña</strong>: " . $password ."<br/>";
				
				$html .= "Ingresa a <strong>http://ceci.itdp.mx/login</strong><br/><br/>";
				
				$html .= "<h3 style='color: #2f6b91;'><strong >¡Gracias por transformar tu ciudad!</strong></h3>";

				$this->email->subject('Tu cuenta para CECI ha sido creada correctamente');
				$this->email->message($html);
				$this->email->set_mailtype('html');
				$this->email->send();
				
				$data = array("success" => true, "code" => 200);
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
				exit;
			} else {
				$data = array("error" => false, "code" => 400);
				header('HTTP/1.1 400 Bad Request');
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
				exit;
			}
		}
	}

	public function loginUsuarios(){
		$email = strip_tags($this->input->post("email"));
		$password = strip_tags($this->input->post("password"));

		$this->form_validation->set_rules("email", "email", "trim|required");
		$this->form_validation->set_rules("password", "password", "trim|required");

		if($this->form_validation->run() == FALSE) {
			$this->load->view('login');
		} else {
			$usr_result = $this->Curso_model->getUser($email, $password);

			if(isset($usr_result)) {                       
				$sessiondata = array(
					'email' => $email,
					'nombre' => $usr_result->nombre,
					'id_usuario'=> $usr_result->id_usuario,
					'timestamp'=> $usr_result->timestamp,
					'sector'=> $usr_result->sector,
					'ciudad' => $usr_result->ciudad,
					'estado' => $usr_result->estado,
					'role' => $usr_result->role,
					'loginuser' => TRUE
				);

				$this->session->set_userdata($sessiondata);
				if ( $usr_result->role == 0) {
					$user=  "user";
				}else {
					$user = "admin";
				}
				$data = array("role" => $user, "code" => 200);
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
			} else {
				$data = array("error" => false, "code" => 400);
				header('HTTP/1.1 400 Bad Request');
				header('Content-Type: application/json; charset=UTF-8');
				echo json_encode($data);
			}
		}
	}

	public function logout() {
		$this->session->sess_destroy();
		redirect('login','refresh');
	}

	public function isUser() {
		if($this->session->userdata('id_usuario') != NULL)
			return true;
		else
			redirect('login', 'refresh'); 
	}

	public function contadorVideos() {
		$this->isUser();
		$id_usuario = $this->session->userdata('id_usuario');
		$video = $this->input->post('id_video');
		$contadorVideos = $this->Curso_model->insertVideos($video, $id_usuario);
	}

	public function contadorGuias() {
		$this->isUser();
		$id_usuario = $this->session->userdata('id_usuario');
		$guia = $this->input->post('id_guia');
		$contadorGuias = $this->Curso_model->insertGuias($guia, $id_usuario);
	}

	public function exportar() {
		$this->isUser();
		
		if($this->session->userdata('role')== "1") {
			to_excel($this->Curso_model->getUsuarios(), "usuarios-ceci");
		} else {
			redirect('capacitacion','refresh');
		}
	}

	public function calificar() {
		$modalidad = $this->input->post('modalidad');
		
		if($modalidad !== NULL) {
			$preguntas = $this->input->post('preguntas');
			$respuestas = $this->Curso_model->getRespuestas($modalidad, true);
			$modPreguntas = $this->Curso_model->getPreguntas($modalidad);
			
			$calificacion = 0;
			//$preguntasOk = array();
			
			$idUsuario = $this->session->userdata('id_usuario');
			//die($idUsuario);
			foreach($preguntas as $idPregunta => $idRespuesta) {
				foreach($respuestas as $respuesta) {
					if($respuesta['id_pregunta'] == $idPregunta and $idRespuesta == $respuesta['id_respuesta']) {
						$calificacion++;
						//array_push($preguntasOk,$idPregunta);
					}
				}
			}
			
			$calificacion = round($calificacion*100/count($modPreguntas), 2);
			
			$data = array(
				'calificacion' => $calificacion,
				'modalidad' => $modalidad,
				'usuario' => $idUsuario
			);
			
			$this->Curso_model->insertExamen2Usuario($calificacion,	$modalidad, $idUsuario);
			
			header('Content-type: application/json;');
			echo json_encode($data, JSON_NUMERIC_CHECK);
		} else {
			redirect('capacitacion','refresh');
		}
	}

	public function cuestionario($idModalidad = false) {
		if($idModalidad != false) {
			$this->isUser();
			$modPreguntas = $this->Curso_model->getPreguntas($idModalidad);
			$modRespuestas = $this->Curso_model->getRespuestas($idModalidad);
			
			$data = array(
				'preguntas' => $modPreguntas,
				'respuestas' => $modRespuestas,
				'idModalidad' => $idModalidad,
				'modalidad' => $this->getModalidad($idModalidad)
			);
			
			$this->output('cuestionario', $data);
		} else {
			redirect('capacitacion','refresh');
		}
	}
	
	public function getModalidad($idModalidad) {
		switch ($idModalidad) {
			case 1:
				return "Calles Completas";
			break;
			case 2:
				return "Sistemas Integrados de Transporte";
			break;
			case 3:
				return "Desarrollo Orientado al Transporte";
			break;
			case 4:
				return "Gestión de la Movilidad";
			break;
			case 5:
				return "Distribución Urbana de Mercancias";
			break;
		}
	}

}
