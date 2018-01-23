<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
  


<section class="content">
<script>
function ValidateIPaddress(inputText)  
 {  
 var ipformat = /^(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.(25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/;  
 if(inputText.value.match(ipformat))  
 {  
 document.form1.ip.focus();  
 return true;  
 }  
 else  
 {  
 alert("Endereço IP Invalido!");  
 document.form1.ip.focus();<br>return false;  
 }  
 }  
</script>
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <center><h3 class="box-title">Adicionar Servidor</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/servidor/adicionar_exe.php" method="post">
              <div class="box-body">
			    
				<div class="form-group">
                  <label id="form1" name="form1" for="exampleInputEmail1">Nome do servidor</label>
                  <input required="required" type="text" class="form-control" id="nomesrv" name="nomesrv" placeholder="Digite o nome do servidor">
                </div>
               
				<div class="form-group">
                  <label for="exampleInputEmail1">Endereço IP</label>
                  <input required="required" type="text" class="form-control" id="ip" name="ip" placeholder="Digite o endereço ip">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">login</label>
                  <input required="required" type="text" class="form-control" id="login" name="login" placeholder="root">
                </div>
				 <div class="form-group">
                  <label for="exampleInputPassword1">senha</label>
                  <input required="required" type="password" class="form-control" id="senha" name="senha" placeholder="senha">
                </div>
				
			   <div class="form-group">
                <label>
                  <input type="radio" name="tipo" id="tipo" class="minimal"   value="full">
				  Squid + Scripts SHELL *Somente Ubuntu 14 64
                </label>
				<br>
                <label>
                  <input type="radio" name="tipo" id="tipo" class="minimal" value="script" checked>
				 Somente Scripts SHELL  
                </label>
                
        </div>
			

                
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary"  onclick="ValidateIPaddress(document.form1.ip)" >Cadastrar</button>
              </div>
            </form>
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>