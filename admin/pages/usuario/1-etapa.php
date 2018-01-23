<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<script language="JavaScript">
<!--
function desabilitar(){
with(document.form){
qtd_ssh.disabled=true;
}
}
function habilitar(){
with(document.form){

qtd_ssh.disabled=false;

}
}
// -->
</script> 

<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"> Adicionar Usuário ao sistema</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" name="form" id="form" action="pages/usuario/adicionar_exe.php" method="post">
              <div class="box-body">
			    <div class="form-group">
                  <label for="exampleInputEmail1">Nome</label>
                  <input required="required" type="text" class="form-control" id="nome" name="nome" placeholder="Digite nome">
                </div> 
               
				<div class="form-group">
                  <label for="exampleInputEmail1">Login</label>
                  <input required="required" type="text" class="form-control" id="login" name="login" placeholder="Digite Login">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha</label>
                  <input  class="form-control" id="senha" name="senha" placeholder="A sera será enviada por SMS">
                </div>
				
			  <div class="form-group">
                  <label for="exampleInputEmail1">Celular</label>
                  <input required="required" type="text" class="form-control" id="celular" name="celular" placeholder="Ex: 18997766543">
                </div>
			
			  <div class="form-group">
                <label>
                  <input type="radio" name="tipo" id="tipo" class="minimal" checked  value="revenda">
				  Revendedor
                </label>
				<br>
                <label>
                  <input type="radio" name="tipo" id="tipo" class="minimal" value="vpn">
				  Usuário SSH  
                </label>
                
              </div>
			  
			 
			  
            
			 
                
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Adicionar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>