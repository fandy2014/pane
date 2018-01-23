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
          <div class="box box-default">
            <div class="box-header with-border">
              <h3 class="box-title">Dados do usuário </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" id="form" name="form" action="pages/admin/alterar.php" method="post">
              <div class="box-body">
               
				<div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
                  <input type="text" class="form-control" id="login" name="login" placeholder="Digite Login" disabled value="<?php echo $administrador['login'];?>">
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" placeholder="Digite Nome" value="<?php echo $administrador['nome'];?>">
                </div>
				
                <div class="form-group">
                  <label for="exampleInputPassword1">E-mail</label>
                  <input type="email" class="form-control" id="email" name="email" placeholder="Digite E-mail" value="<?php echo $administrador['email'];?>">
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
                  <input type="password" class="form-control" id="senha" name="senha" placeholder="Digite Senha">
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