<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Gerenciamento de Turmas</title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="/assets/css/bootstrap.min.css">
	<!-- Navibar -->
	<link rel="stylesheet" href="/assets/css/side.css">
	<!-- jQuery library -->
	<script src="/assets/js/jquery.min.js"></script>
	<!-- Latest compiled JavaScript -->
	<script src="/assets/js/bootstrap.min.js"></script>
</head>

<body>
	<!-- Sidebar -->
	<div id="wrapper">
		<div class="overlay"></div>

	  <!--Sidebar-->
		<?php $this->load->view('layout/sidebar'); ?>
	  <!--Sidebar-->
		<!-- /#sidebar-wrapper -->

		<!-- Page Content -->
		<div id="page-content-wrapper" style="margin-bottom: 150px;">
			<button type="button" class="hamburger is-closed" data-toggle="offcanvas">
                <span class="hamb-top"></span>
    			<span class="hamb-middle"></span>
				<span class="hamb-bottom"></span>
            </button>
			<div class="container">
				<div class="row">
					<!--mensagem-->
		            <?php if (isset($sucesso)){  ?>
		            <div class="col-lg-8 col-lg-offset-2 alert alert-success text-center">
		                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                <strong>SUCESSO!</strong>
		                <p>
		                    <?php echo $msg; ?>
		                </p>
		            </div>
		            <?php } ?>
		            <?php if (isset($falha)){ ?>
		            <div class="col-lg-8 col-lg-offset-2 alert alert-danger text-center">
		                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		                <strong>FALHA!</strong>
		                <p>
		                    <?php echo $msg; ?>
		                </p>
		            </div>
		            <?php } ?>
		            <!--mensagem-->
					<div class="col-lg-8 col-lg-offset-2">
						<h1>Cadastro de Turmas</h1>
						<form action="<?php echo base_url('turma/cadastrarTurma') ?>" method="post">
							<div class="form-group">
								<label for="id">Nome da Turma:</label>
								<input required type="text" class="form-control" id="id" name="id">
							</div>
							<div class="form-group">
								<label for="idDisciplina">Disciplina:</label>
								<select required class="form-control" id="idDisciplina" name="idDisciplina">
       								<option  disabled="disabled" selected='selected'>Selecione</option>
									<?php foreach ($disciplinas as $row) { ?>
        								<option value="<?php echo $row['id'] ?>"><?php echo $row['id'] ?></option>
        						<?php } ?>
      					</select>
							</div>
							<div class="form-group">
								<label for="loginProfessor">Professor:</label>
								<select required class="form-control" id="loginProfessor" name="loginProfessor">
       					<option disabled="disabled" selected='selected'>Selecione</option>
									<?php foreach ($professores as $row) { ?>
        								<option value="<?php echo $row['login'] ?>"><?php echo $row['nome'] ?></option>
        						<?php } ?>
      					</select>
							</div>
							<div class="form-group">
								<label for="loginAluno">Alunos:</label>
								<select required multiple class="form-control" id="loginAluno" name="loginAluno[]">
       					<option disabled="disabled" selected='selected'>Selecione</option>
									<?php foreach ($alunos as $row) { ?>
        								<option value="<?php echo $row['login'] ?>"><?php echo $row['nome'] ?></option>
        						<?php } ?>
      					</select>
							</div>
							<button type="submit" class="btn btn-default">Cadastrar</button>
						</form>
					</div>

					<div class="col-lg-8 col-lg-offset-2">
						<div class="accordion">
							<table class="table table-striped table-condensed">
								<thead>
									<tr>
										<th>TURMA</th>
										<th>DISCIPLINA</th>
										<th>PROFESSOR</th>
										<th>AÇÕES</th>
									</tr>
								</thead>
							</table>
							<?php $i = 0; foreach ($turmas as $row) { $i ++;?>
							<div class="accordion-group">
								<div class="accordion-heading">
										<table class="table table-striped table-condensed">
											<thead>
												<tr>
													<td>
														<a class="accordion-toggle" style="decoration:none;" data-toggle="collapse" href="#tab<?php echo $i?>"><?php echo $row['id']?></a>
													</td>
													<td>
														<?php echo $row['idDisciplina']?>
													</td>
													<td>
														<?php echo $row['loginProfessor']?>
													</td>
													<td>
														<a href="<?php echo base_url('turma/editarTurma?id=').$row['id'].'&disciplina='.$row['idDisciplina'].'&professor='.$row['loginProfessor'] ?>">Editar</a>, <a href="<?php echo base_url('turma/excluirTurma?id=').$row['id'].'&disciplina='.$row['idDisciplina'].'&professor='.$row['loginProfessor'] ?>">Excluir</a>
													</td>
												</tr>
											</thead>
										</table>
								</div>
								<div id="tab<?php echo $i?>" class="accordion-body collapse">
									<div class="accordion-inner">
										<table class="table table-striped">
											<thead>
												<tr>
													<th>ALUNO</th>
												</tr>
											</thead>
											<tbody>
												<?php foreach ($row['alunos'] as $a) { ?>
												<tr>
													<td>
														<?php echo $a['loginAluno']?>
													</td>
												</tr>
												<?php } ?>
											</tbody>
										</table>
									</div>
								</div>
							</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /#page-content-wrapper -->

	</div>
	<!-- /#sidebar-wrapper -->
  <!--Footer-->
	<?php $this->load->view('layout/footer'); ?>
	<!--Footer-->
</body>

</html>