<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function index(){
		$this->load->model('turma/aluno_model');
		
		$aluno_model = new Aluno_model();
		
		$filtro['loginAluno']='aluno@email.com';
		$filtro['idTurma']='Turma A';
		$filtro['idDisciplina']='com220';
		$filtro['loginProfessor']='admin@email.com';
		var_dump($aluno_model->listar_provas($filtro)->result());
		
		var_dump($this->db->last_query()); 
		
		//$this->load->view('layout/header');
		//$this->load->view('home/welcome_message');
		//$this->load->view('layout/footer');	
	}
}