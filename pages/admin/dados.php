<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
  <?php if($usuario['atualiza_dados']==0){?>
    <div class="callout callout-warning">
                <center><h4>Primeiro acesso</h4>

                <p>Para continuar, preencha todos os campos e salve!</p>
				</center>
    </div>
  <?php }?>	  
			  
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Dados do usuário </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="form" name="form" action="pages/admin/alterar.php" method="post">
              <div class="box-body">
               
				<div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
                  <input required="required" type="text" class="form-control" id="login" name="login" placeholder="Digite Login" disabled value="<?php echo $usuario['login'];?>">
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Data de Cadastro</label>
                  <input type="text" class="form-control"  disabled value="<?php echo date('d/m/Y', strtotime($usuario['data_cadastro']));?>">
                </div>
				<?php if($usuario['tipo']=="revenda"){?>
				<div class="form-group">
                  <label for="exampleInputPassword1">Data de Validade</label>
                  <input type="text" class="form-control"  disabled value="<?php echo date('d/m/Y', strtotime($usuario['validade']));?>">
                </div>

                <?php }?>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Nome</label>
                  <input required="required" type="text" class="form-control" id="nome" name="nome" placeholder="Digite Nome" value="<?php echo $usuario['nome'];?>">
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">E-mail</label>
                  <input required="required" type="email" class="form-control" id="email" name="email" placeholder="Digite E-mail" value="<?php echo $usuario['email'];?>">
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Celular</label>
                  <input required="required" type="text" class="form-control" id="celular" name="celular" placeholder="Digite o celular" value="<?php echo $usuario['celular'];?>">
                </div>
				
				
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Alterar Dados</button>
              </div>
            </form>
			
			<form role="form" id="form2" name="form2" action="pages/admin/senha.php" method="post">
              <div class="box-body">
               <div class="form-group">
                  <label for="exampleInputPassword1">Senha</label>
                  <input required="required" type="password" class="form-control" id="senha" name="senha" placeholder="Digite Senha">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Alterar Senha</button>
              </div>
            </form>
			
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>