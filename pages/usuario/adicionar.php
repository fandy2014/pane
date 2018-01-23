<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Adicionar Usuário ao sistema</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/system/funcoes.usuario.php" method="get">
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome</label>
                  <input required="required" type="text" class="form-control" id="nome" name="nome" placeholder="Digite o nome">
                </div>
				<div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
                  <input required="required" type="text" class="form-control" id="login" name="login" placeholder="Digite Login">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha</label>
                  <input required="required" type="password" class="form-control" id="senha" name="senha" placeholder="Digite Senha">
                </div>
               
			   <div class="form-group">
                  <label for="exampleInputEmail1">Celular</label>
                  <input required="required" type="text" class="form-control" id="celular" name="celular" placeholder="Ex: 16887766557">
				   <input type="hidden" class="form-control" id="owner" name="owner" value="<?php echo $_SESSION['usuarioID']; ?>">
				    <input type="hidden" class="form-control" id="diretorio" name="diretorio"  value="../../home.php?page=usuario/listar">
					<input type="hidden" class="form-control" id="op" name="op"  value="new">
                </div>
                
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>