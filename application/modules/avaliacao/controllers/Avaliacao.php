<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Avaliacao extends CI_Controller {

	# ------------ Visualizar ----------
	
	#Lista todas as avaliações
	public function index($result='',$idTurma=''){
		//Restrição de acesso
		if(!isset($_SESSION['tipoUsuario']) or (($_SESSION['tipoUsuario']!='admin') and ($_SESSION['tipoUsuario']!='professor'))) redirect(base_url().'home', 'refresh');
		
		$data['idTurma']=$idTurma;
		
		//Mensagem de resultado de alguma operação
		if(isset($result)){
			switch ($result){
				case 'cad_sucesso': 
					$data['sucesso']=true;
					$data['msg'] = 'Avaliação cadastrada com sucesso!';
					break;
				case 'cad_falha': 
					$data['falha']=true;
					$data['msg'] = 'Falha ao cadastrar a avaliação!';
					break;
				case 'alt_sucesso':
					$data['sucesso']=true;
					$data['msg'] = 'Avaliação atualizada com sucesso!';
					break;
				case 'alt_falha': 
					$data['falha']=true;
					$data['msg'] = 'Falha ao atualizar a avaliação!';
					break;
				case 'exc_sucesso':
					$data['sucesso']=true;
					$data['msg'] = 'Avaliação excluida com sucesso!';
					break;
				case 'exc_falha':
					$data['falha']=true;
					$data['msg'] = 'Falha ao remover a avaliação!';
					break;
			}
		}
		
		//Carrega as models
		$this->load->model('turma/turma_model');
		$this->load->model('avaliacao/avaliacao_model');
		
		//Consulta as turmas do professor
		$consulta = new Turma_model();
		$filtro['loginProfessor']=$_SESSION['login'];
		$turmas=$consulta->select($filtro)->result();
		
		//Consulta as avaliações de cada turma
		$data['avaliacoes'] = [];
		foreach($turmas as $turma){
			$consulta = new Avaliacao_model();
			$filtro['idTurma'] = $turma->id;
			$filtro['idDisciplina'] = $turma->idDisciplina;
			$filtro['loginProfessor'] = $turma->loginProfessor;
			//Adiciona as avaliaçõse e a turman no vetor
			$avaliacoes['turma'] = $turma;
			$avaliacoes['avaliacoes'] = $consulta->select($filtro)->result();
			$data['avaliacoes'][] = $avaliacoes;
		}
		
		//Carrega a view 
		$this->load->view('avaliacao/listarAvaliacao',$data);
		
	}
	
	#Lista todas as questões por disciplina
	public function questao($result='',$idDisciplina='') {
		//Restrição de acesso
		if(!isset($_SESSION['tipoUsuario']) or (($_SESSION['tipoUsuario']!='admin') and ($_SESSION['tipoUsuario']!='professor'))) redirect(base_url().'home', 'refresh');
		
		//Mensagem de resultado de alguma operação
		if(isset($result)){
			switch ($result){
				case 'cad_sucesso': 
					$data['sucesso']=true;
					$data['msg'] = 'Questão cadastrada com sucesso!';
					break;
				case 'cad_falha': 
					$data['falha']=true;
					$data['msg'] = 'Falha ao cadastrar a questão!';
					break;
				case 'alt_sucesso':
					$data['sucesso']=true;
					$data['msg'] = 'Questão atualizada com sucesso!';
					break;
				case 'alt_falha': 
					$data['falha']=true;
					$data['msg'] = 'Falha ao atualizar a questão!';
					break;
				case 'exc_sucesso':
					$data['sucesso']=true;
					$data['msg'] = 'Questão excluida com sucesso!';
					break;
				case 'exc_falha':
					$data['falha']=true;
					$data['msg'] = 'Falha ao remover a questão!';
					break;
			}
		}
		
		//Recupera o ID da disciplina, se houver
		$data['idDisciplina']=$idDisciplina;
		
		//Carrega as models
		$this->load->model('turma/disciplina_model');
		$this->load->model('avaliacao/questao_model');
		
		//Consulta as disciplinas
		$consulta = new Disciplina_model();
		$consulta_disciplina = $consulta->select($filtro = '')->result();
		
		$data['disciplinas']=[];
		//consulta as questões
		foreach($consulta_disciplina as $disciplina){
				//Filtra por disciplina
				$filtro['idDisciplina'] = $disciplina->id;
				
			  //Consulta as questões da disciplina de acordo com o id
			  $consulta = new Questao_model();
			  $questao = $consulta->select($filtro)->result();
			  
				//Armazena a discplina no vetor
			  $result= [];
			  $result['disciplina']=$disciplina;
			  $result['questoes']=$questao;
			  $data['disciplinas'][]=$result;
		}
		
	  //Carrega a view
		$this->load->view('avaliacao/listarQuestao', $data);
	 }
	
	# ------------ Cadastrar ----------
	
	#Cadastra uma questão no banco de dados
	public function cadastrarQuestao($idDisciplina=''){
	  
		//Cadastra a questão
		if(!empty($_POST)){
			
			$idDisciplina = (empty($_POST['idDisciplina'])) ? '' : $_POST['idDisciplina']; 
			$enunciado = (empty($_POST['enunciado'])) ? '' : $_POST['enunciado']; 
			$r1 = (empty($_POST['r1'])) ? '' : $_POST['r1']; 
			$r2 = (empty($_POST['r2'])) ? '' : $_POST['r2']; 
			$r3 = (empty($_POST['r3'])) ? '' : $_POST['r3']; 
			$r4 = (empty($_POST['r4'])) ? '' : $_POST['r4']; 
			$respostaCerta = (empty($_POST['respostaCerta'])) ? '' : $_POST['respostaCerta']; 
			
			//Carrega a model
			$this->load->model('avaliacao/questao_model');
			$questao = new Questao_model(null,$idDisciplina,$enunciado,$r1,$r2,$r3,$r4,$respostaCerta);
			
			//Insere o resgistro no banco
			if($questao->insert())
				redirect(base_url('avaliacao/questao/cad_sucesso/'.$idDisciplina));
			else
				redirect(base_url('avaliacao/questao/cad_falha/'.$idDisciplina));	
		}
		
		//Recupera o ID da disciplina
		$data['idDisciplina']=$idDisciplina;
		
		//Carrega a view
		$this->load->view('avaliacao/cadastrarQuestao',$data);
	}
	
	#Cadastra uma questão no banco de dados
	public function cadastrarAvaliacao(){
		
		//Recebe os dados do formulario de cadastro
		if(!empty($_POST)){
			$idTurma = (empty($_POST['idTurma'])) ? '' : $_POST['idTurma']; 
			$loginProfessor = (empty($_POST['loginProfessor'])) ? '' : $_POST['loginProfessor']; 
			$idDisciplina = (empty($_POST['idDisciplina'])) ? '' : $_POST['idDisciplina']; 
			$nome = (empty($_POST['nome'])) ? '' : $_POST['nome']; 
			$questoes = (empty($_POST['questoes'])) ? '' : $_POST['questoes']; 
	
			//Cadastra a avaliação
			//Carrega a model
			$this->load->model('avaliacao/avaliacao_model');
			$avaliacao = new Avaliacao_model(null,$idTurma,$idDisciplina,$loginProfessor,$nome);
			
			//Se cadastrar a valiação, realiza o cadastro das questões na avaliação
			if($avaliacao->insert()){
				//Recupera o id da avaliação cadastrada
				$filtro['idTurma'] = $idTurma;
				$filtro['idDisciplina'] = $idDisciplina;
				$filtro['loginProfessor'] = $loginProfessor;
				$filtro['nome'] = $nome;
				
				//Recupera o id
				$consulta = new Avaliacao_model();
				$idAvaliacao = $consulta->select($filtro)->result();
				$idAvaliacao=$idAvaliacao[0]->id;
				
				//Cadastra as questões
				//Carrega a model
				$this->load->model('avaliacao/avaliacao_questao_model');
				
				//Percorre o vetor do POST
				foreach($questoes as $idQuestao){
					$questao = new Avaliacao_questao_model($idAvaliacao,$idQuestao);
					//Insere as questões
					$questao->insert();
				}
				//Redireciona pra pagina de listagem
				redirect(base_url('avaliacao/index/cad_sucesso/'.$idTurma));	
			}else
				redirect(base_url('avaliacao/index/cad_falha/'.$idTurma));	
		}	
  
		if(!empty($_GET)){
		  //Recebe os parâmetros
		  $dados['idTurma']=$_GET['idTurma'];
		  $dados['loginProfessor']=$_GET['loginProfessor'];
		  $dados['idDisciplina']=$_GET['idDisciplina'];
		  $data['dados']=$dados;

		  //Lista as questões da prova pela disciplina
		  //Carrega a model
		  $this->load->model('avaliacao/questao_model');
		  $consulta = new Questao_model();
		  
		  //Filtra por id da displina
		  $filtro['idDisciplina'] = $dados['idDisciplina'];
		  $data['questoes'] = $consulta->select($filtro)->result();

		  //Carrega a view
		  $this->load->view('avaliacao/cadastrarAvaliacao',$data);
		}else
			redirect(base_url('avaliacao/index/cad_falha/'.$idTurma));	
	}
	
	# ------------ Excluir ----------
	
	#Exclui uma questão no banco de dados
	public function excluirQuestao($idQuestao=''){

		if(!empty($idQuestao)){
			//Carrega a model
			$this->load->model('avaliacao/questao_model');
			$questao = new Questao_model($idQuestao);

			//Remove o resgistro no banco
			if($questao->remove())
				redirect(base_url('avaliacao/questao/exc_sucesso'));
			else
				redirect(base_url('avaliacao/questao/exc_falha'));	
		}else
			redirect(base_url('avaliacao/questao/exc_falha'));	
	}	
	
	#Exclui uma avaliação do banco de dados
	public function excluirAvaliacao($idAvaliacao=''){

		if(!empty($idAvaliacao)){
			//Carrega a model
			$this->load->model('avaliacao/avaliacao_model');
			$avaliacao = new Avaliacao_model($idAvaliacao);

			//Remove o resgistro no banco
			if($avaliacao->remove())
				redirect(base_url('avaliacao/index/exc_sucesso'));
			else
				redirect(base_url('avaliacao/index/exc_falha'));	
		}else
			redirect(base_url('avaliacao/index/exc_falha'));	
	}	
	
	#Exclui uma questão que foi adicionada na avaliação
	public function removerQuestaoAvaliacao($idQuestao='',$idAvaliacao=''){
		
		//Carrega a model
		$this->load->model('avaliacao/avaliacao_questao_model');
		$questao = new Avaliacao_questao_model($idAvaliacao,$idQuestao);
		
		//Remove a questão
		if($questao->remove()){
			//Redireciona pra pagina de listagem
			redirect(base_url('avaliacao/editarAvaliacao/'.$idAvaliacao));	
		}else
			redirect(base_url('avaliacao/index/alt_falha/'.$idTurma));	
	}
	
	# ------------ Editar ----------
	
	#Edita uma questão no banco de dados
	public function editarQuestao($idQuestao=''){
	
		//Edita a questão
		if(!empty($_POST)){
			
			$idQuestao = (empty($_POST['idQuestao'])) ? '' : $_POST['idQuestao']; 
			$idDisciplina = (empty($_POST['idDisciplina'])) ? '' : $_POST['idDisciplina']; 
			$enunciado = (empty($_POST['enunciado'])) ? '' : $_POST['enunciado']; 
			$r1 = (empty($_POST['r1'])) ? '' : $_POST['r1']; 
			$r2 = (empty($_POST['r2'])) ? '' : $_POST['r2']; 
			$r3 = (empty($_POST['r3'])) ? '' : $_POST['r3']; 
			$r4 = (empty($_POST['r4'])) ? '' : $_POST['r4']; 
			$respostaCerta = (empty($_POST['respostaCerta'])) ? '' : $_POST['respostaCerta']; 
			
			//Carrega a model
			$this->load->model('avaliacao/questao_model');
			$questao = new Questao_model(null,$idDisciplina,$enunciado,$r1,$r2,$r3,$r4,$respostaCerta);
		
			//Atualiza o resgistro no banco
			if($questao->update($idQuestao))
				redirect(base_url('avaliacao/questao/alt_sucesso/'.$idDisciplina));
			else
				redirect(base_url('avaliacao/questao/alt_falha/'.$idDisciplina));	
		}
		
		//Recupera os dados para preencher o formulario de edição
		if(!empty($idQuestao)){
			//Carrega a model
			$this->load->model('avaliacao/questao_model');
			
			//Consulta os dados da questão para edição
			$questao = new Questao_model();
			$filtro['idQuestao']=$idQuestao;
			
			//Adiciona os resultados
			$data['idQuestao']=$idQuestao;
			$data['questao']=$questao->select($filtro)->result();
			
			//Remove o resgistro no banco
			if($data['questao'])
				$this->load->view('avaliacao/editarQuestao',$data);
			else
				redirect(base_url('avaliacao/questao/alt_falha'));	
		}else
			redirect(base_url('avaliacao/questao/alt_falha'));	
	}	
	
	#Edita uma avaliação no banco de dados
	public function editarAvaliacao($idAvaliacao=''){
		
		//Recebe os dados do formulario de cadastro
		if(!empty($_POST)){
		
			$idAvaliacao = (empty($_POST['idAvaliacao'])) ? '' : $_POST['idAvaliacao']; 
			$idTurma = (empty($_POST['idTurma'])) ? '' : $_POST['idTurma']; 
			$loginProfessor = (empty($_POST['loginProfessor'])) ? '' : $_POST['loginProfessor']; 
			$idDisciplina = (empty($_POST['idDisciplina'])) ? '' : $_POST['idDisciplina']; 
			$nome = (empty($_POST['nome'])) ? '' : $_POST['nome']; 
			$questoes = (empty($_POST['questoes'])) ? '' : $_POST['questoes']; 
	
			//Cadastra a avaliação
			//Carrega a model
			$this->load->model('avaliacao/avaliacao_model');
			$avaliacao = new Avaliacao_model(null,$idTurma,$idDisciplina,$loginProfessor,$nome);
			
			//Se atualizar a avaliação, realiza o cadastro das questões na avaliação
			if($avaliacao->update($idAvaliacao)){
			
				//Cadastra as questões
				//Carrega a model
				$this->load->model('avaliacao/avaliacao_questao_model');
				
				//Percorre o vetor do POST
				foreach($questoes as $idQuestao){
					$questao = new Avaliacao_questao_model($idAvaliacao,$idQuestao);
					//Insere as questões
					$questao->insert();
				}
				//Redireciona pra pagina de listagem
				redirect(base_url('avaliacao/index/alt_sucesso/'.$dados['idTurma']));	
			}else
				redirect(base_url('avaliacao/index/alt_falha/'.$idTurma));	
		}	
  
		//Recupera os dados para preencher o formulario de avaliação
		if(!empty($idAvaliacao)){
			//Carrega a model
			$this->load->model('avaliacao/avaliacao_model');
			
			//Consulta os dados da questão para edição
			$avaliacao = new Avaliacao_model();
			$filtro['id']=$idAvaliacao;
			
			//Adiciona os resultados
			$data['avaliacao']=$avaliacao->select($filtro)->result_array();
			$data['avaliacao']=$data['avaliacao'][0];
			$data['questoes']=$avaliacao->listar_questoes($filtro)->result();
			
			//Recupera as questões da disciplina que estão fora da avaliação
			$filtro['idDisciplina']=$data['avaliacao']['idDisciplina'];
			$data['questoes_fora'] = $avaliacao->questoes_fora($filtro)->result();
			
			//Carrega a view
			if($data['avaliacao'])
				$this->load->view('avaliacao/editarAvaliacao',$data);
			else
				redirect(base_url('avaliacao/index/alt_falha'));	
		}else
			redirect(base_url('avaliacao/index/alt_falha'));	
	}
	
	# ------------ Aluno ----------
	
	#Lista as avaliações disponíveis para o aluno
	public function listarAvaliacoes($idTurma=''){
		//Restrição de acesso
		if(!isset($_SESSION['tipoUsuario'])) redirect(base_url().'home', 'refresh');
		
		//Recupera o id da turma para abrir o accordion
		$data['idTurma']=$idTurma;
		
		//Carrega as models
		$this->load->model('turma/aluno_model');
		
		//Consulta as turmas do aluno
		$consulta = new Aluno_model();
		$filtro['loginAluno']=$_SESSION['login'];
		$turmas=$consulta->listar_turmas($filtro)->result();
	
		//Consulta as avaliações de cada turma
		$data['avaliacoes'] = [];
		foreach($turmas as $turma){
			$filtro['loginAluno'] = $turma->loginAluno;
			$filtro['idTurma'] = $turma->idTurma;
			$filtro['idDisciplina'] = $turma->idDisciplina;
			$filtro['loginProfessor'] = $turma->loginProfessor;
			$consulta = new Aluno_model();
	
			//Adiciona as avaliaçõse e a turman no vetor
			$avaliacoes['turma'] = $turma;
			$avaliacoes['avaliacoes'] = $consulta->listar_provas($filtro)->result();
			
			$data['avaliacoes'][] = $avaliacoes;
		}
		
		//Carrega a view 
		$this->load->view('avaliacao/alunoAvaliacao',$data);
	}
	
}
