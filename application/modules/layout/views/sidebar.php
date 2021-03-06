<!-- Sidebar -->
		<nav class="navbar navbar-inverse navbar-fixed-top" id="sidebar-wrapper" role="navigation">
			<ul class="nav sidebar-nav">
			
				<?php if(($_SESSION['tipoUsuario']=='admin') or ($_SESSION['tipoUsuario']=='professor')){ ?>
					<li class="sidebar-brand">
						<a href="<?php echo base_url() ?>">Home</a>
					</li>
					<li>
						<a href="<?php echo base_url('nota') ?>">Gerenciamento de Notas</a>
					</li>
					<hr>
					<li class="dropdown">
					 <a href="#" class="dropdown-toggle" data-toggle="dropdown">Gerenciamento de Avaliações<span class="caret"></span></a>
					  <ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Opções</li>
							<li><a href="<?php echo base_url('avaliacao/questao') ?>">Banco de questões</a></li>
							<li><a href="<?php echo base_url('avaliacao') ?>">Avaliações</a></li>
						</ul>
					</li>
					<hr>
				<?php } ?>
				<?php if($_SESSION['tipoUsuario']=='admin'){ ?>
					<li class="dropdown">
						<a href="#" class="dropdown-toggle" data-toggle="dropdown">Gerenciamento de Turmas <span class="caret"></span></a>
						<ul class="dropdown-menu" role="menu">
							<li class="dropdown-header">Opções</li>
							<li><a href="<?php echo base_url('turma/aluno') ?>">Alunos</a></li>
							<li><a href="<?php echo base_url('turma/disciplina') ?>">Disciplinas</a></li>
							<li><a href="<?php echo base_url('turma/professor') ?>">Professores</a></li>
							<li><a href="<?php echo base_url('turma') ?>">Turmas</a></li>
						</ul>
					</li>
					<hr>
				<?php } ?>
				<?php if($_SESSION['tipoUsuario']=='aluno'){ ?>
					<li class="sidebar-brand">
						<a href="<?php echo base_url() ?>">Aluno</a>
					</li>
					<li>
						<a href="<?php echo base_url('avaliacao/listarAvaliacoes') ?>">Consultar avaliações</a>
					</li>
					<li>
						<a href="<?php echo base_url('nota/historico') ?>">Consultar histórico</a>
					</li>
				<?php } ?>
        		<li class="divider"></li>
				<li>
					<a href="<?php echo base_url('home/logoff') ?>">Sair</a>
				</li>
			</ul>
		</nav>
<!-- /#sidebar-wrapper -->