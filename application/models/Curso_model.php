<?php 
class Curso_model extends CI_Model{
	public function __construct(){
		parent::__construct();
	}

	public function insert($nombre,$estado,$ciudad,$sector,$dependencia,$email,$password,$status) {
		$this->db->db_debug = FALSE;
		
		$data = array(
			'nombre' => $nombre,
			'estado' => $estado,
			'ciudad' => $ciudad,
			'sector' => $sector,
			'dependencia' => $dependencia,
			'email' => $email,
			'password' => $password,
			'status' => $status,
		);

		$this->db->insert('usuarios',$data);
		
		$insert_id = $this->db->insert_id();

		return  $insert_id;
	}

	public function generateRandomString($length = 10) {
		return substr(str_shuffle("0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
	}

	public function loginUsuarios($usuario, $password) {
		$data =  array(
			'usuario' => $usuario,
			'password' => $password,
		);
		
		$this->db->get('usuarios', $data);
	}

	public function getUser($email, $password) {
		$sql = "select id_usuario, sector, ciudad, estado, email,nombre, timestamp, password, role from usuarios where email = '" . $email . "' and password = '" . md5($password) . "' and status = 'activo'";
		$query = $this->db->query($sql);
		
		return $query->row();
	}
	
	public function userExists($email) {
		$sql = "select id_usuario, email, password from usuarios where email = '" . $email . "'";
		$query = $this->db->query($sql);
		
		return $query->row();
	}

	public function insertVideos($video, $id_usuario) {
		$ip = $this->getIP();
		
		$data = array(
			'id_video' => $video,
			'ip' => $ip,
			'id_usuario' => $id_usuario,
		);

		$this->db->insert('visitas_videos',$data);
	}

	public function insertExamen2Usuario($calificacion, $modalidad, $idUsuario) {
		$this->db->delete('examen2usuario', array('id_usuario' => (int)$idUsuario, 'id_modalidad' => $modalidad)); 
		
		$this->db->set('id_usuario', (int)$idUsuario);	
		$this->db->set('id_modalidad', $modalidad);
		$this->db->set('calificacion', $calificacion);
		$this->db->insert('examen2usuario');
	}

	public function insertGuias($guia, $id_usuario) {
		$ip = $this->getIP();

		$data = array(
			'id_guia' => $guia,
			'ip' => $ip,
			'id_usuario' => $id_usuario,
		);
		$this->db->insert('descargas_guias',$data);
	}

	public function getUsuarios() {
		$fields = $this->db->field_data('usuarios');
		$query = $this->db->select('*')->get('usuarios');
		return array("fields" => $fields, "query" => $query);
	}
	
	public function getIP() {
		if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
			$ip = $_SERVER['HTTP_CLIENT_IP'];
		} elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
			$ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
		} else {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		
		return $ip;
	}
	
	function getRespuestas($modulo, $acierto = false) {
		if($acierto ==true) {
			$where = " AND respuestas.acierto=1";
		} else {
			$where = "";
		}
		
		$query = "SELECT respuestas.respuesta, respuestas.id_pregunta, respuestas.id_respuesta FROM ";
		$query .= "respuestas WHERE respuestas.id_pregunta IN ";
		$query .= "(SELECT preguntas.id_pregunta FROM preguntas WHERE preguntas.id_modalidad = " . $modulo . ")" . $where;
		
		return $this->db->query($query)->result_array();
	}

	function getPreguntas($modulo) {
		$this->db->select('preguntas.pregunta, preguntas.id_pregunta');
		$this->db->from('preguntas');
		$this->db->where('preguntas.id_modalidad',$modulo);
		$preguntas = $this->db->get();	
		
		return $preguntas->result_array();
	}

	function obtenerVisitasVideos() {
		$query = $this->db->select('id_video, count(*) as total')->from('visitas_videos');
        $query->group_by('id_video');
        $query->order_by('id_video', 'ASC');
        $resultado = $query->get();
        
		return $resultado->result();
	}

	function totalDescargas() {
		$query = $this->db->select('id_guia, count(*) as total')->from('descargas_guias');
        $query->group_by('id_guia');
        $query->order_by('id_guia', 'ASC');
        $resultado = $query->get(); 
		return $resultado->result();
	}

	function vistasUsuarios() {
		$query = $this->db->select('id_video, visitas_videos.id_usuario, email, sum(id_video=1) as mod1, sum(id_video=2) as mod2, sum(id_video=3) as mod3, sum(id_video=4) as mod4, sum(id_video=5) as mod5')->from('visitas_videos');
		$query->join('usuarios', 'usuarios.id_usuario=visitas_videos.id_usuario');
        $query->group_by('id_usuario');
        $query->order_by('id_usuario', 'ASC');
        $resultado = $query->get(); 
		return $resultado->result();
	}

	function descargasUsuarios() {
		$query = $this->db->select('id_guia, descargas_guias.id_usuario, email, sum(id_guia=1) as mod1, sum(id_guia=2) as mod2, sum(id_guia=3) as mod3, sum(id_guia=4) as mod4, sum(id_guia=5) as mod5')->from('descargas_guias');
        $query->join('usuarios', 'usuarios.id_usuario=descargas_guias.id_usuario');
        $query->group_by('usuarios.id_usuario'); 
        $query->order_by('descargas_guias.id_usuario', 'ASC');
        $resultado = $query->get(); 
		return $resultado->result();
	}

	function contadorUsuarios() {
		$query = $this->db->select('count(*) as total')->from('usuarios');
        $resultado = $query->get(); 
		return $resultado->row();
	}

	function contadorVisitasVideos($idUsuario = null) {
		$query = $this->db->select('count(*) as total')->from('visitas_videos');
		
		if($idUsuario != null) {
			$query->where('id_usuario', $idUsuario);
		}
		
        $resultado = $query->get();
		return $resultado->row();
	}

	function contadorGuias($idUsuario = null) {
		$query = $this->db->select('count(*) as total')->from('descargas_guias');
		
		if($idUsuario != null) {
			$query->where('id_usuario', $idUsuario);
		}
		
        $resultado = $query->get(); 
		return $resultado->row();
	}

	function listaUsuarios(){
		$query = $this->db->select('id_usuario, nombre, estado, ciudad, sector, dependencia, email,status')->from('usuarios');
        $query->order_by('id_usuario', 'ASC');
        $resultado = $query->get(); 
		return $resultado->result();
	}

	function usuariosPorEstado() {
		$query = $this->db->select('ciudad, count(*) as total')->from('usuarios');
        $query->group_by('ciudad');
        $query->order_by('ciudad', 'ASC');
        $resultado = $query->get(); 
		return $resultado->result();
	}

	function avanceUsuarios($idModalidad, $idUsuario) {
		$query = $this->db->select('usuarios.id_usuario, descargas_guias.id_guia as guia,examen2usuario.calificacion as calificacion, examen2usuario.id_modalidad as examen, visitas_videos.id_video as video')->from('usuarios');
        
        $query->join('descargas_guias', 'descargas_guias.id_usuario = usuarios.id_usuario and descargas_guias.id_guia='.$idModalidad, 'left');
        $query->join('examen2usuario', 'examen2usuario.id_usuario = usuarios.id_usuario and examen2usuario.id_modalidad='.$idModalidad, 'left');
        $query->join('visitas_videos', 'visitas_videos.id_usuario = usuarios.id_usuario and visitas_videos.id_video='.$idModalidad, 'left');
        $query->where('usuarios.id_usuario', $idUsuario);

        $query->group_by('usuarios.id_usuario');

        $resultado = $query->get(); 
		return $resultado->result();
	}
	

	function obtenerUsuarios() {
		$query = $this->db->select('id_usuario, email')->from('usuarios');
        $query-> order_by('email', 'ASC');
		$resultado = $query->get();
		return $resultado-> result();
		
	}

	function usuariosPorSector() {
		$query = $this->db->select('sector, count(*) as total')->from('usuarios');
        $query->group_by('sector');
        $query->order_by('sector', 'ASC');
        $resultado = $query->get(); 
		return $resultado->result();
	}

	function testExist($idUsuario, $idModalidad){
		$query = $this->db->select('*')->from('examen2usuario');
		$query->where('id_usuario', $idUsuario);
		$query->where('id_modalidad', $idModalidad);
		$resultado = $query->get();
		$row = $resultado->row();
		
		if (isset($row)) {
			return $row;
		} else {
			return false;
		}
	}

	function changePassword($password, $idUsuario) {
		if (!empty($password) && !empty($idUsuario)) {
			$query = $this->db->set('password', $password);
			$query = $this->db->where('id_usuario', $idUsuario);
			$query = $this->db->update('usuarios');
			return true;
		}else{
			return false;
		}

	}

	
}

