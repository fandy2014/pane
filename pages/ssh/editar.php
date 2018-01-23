<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<?php
    $dias_acesso=0;
	
  if(isset($_GET["id_ssh"])){
	  
	$diretorio="../../home.php?page=ssh/editar&id_ssh=".$_GET['id_ssh'];
	
	
	$SQLUsuarioSSH = "select * from usuario_ssh WHERE id_usuario_ssh = '".$_GET['id_ssh']."' ";
    $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
    $SQLUsuarioSSH->execute();
						
	
    $usuario_ssh = $SQLUsuarioSSH->fetch();
	
	if(($SQLUsuarioSSH->rowCount()) > 0){
		
		$SQLServidor = "select * from servidor WHERE id_servidor = '".$usuario_ssh['id_servidor']."'  ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
        $ssh_srv = $SQLServidor->fetch();
	
        //Calcula os dias restante
	    $data_atual = date("Y-m-d ");
		$data_validade = $usuario_ssh['data_validade']; 
		if($data_validade > $data_atual){
		   $data1 = new DateTime( $data_validade );
           $data2 = new DateTime( $data_atual );
           $dias_acesso = 0;
           $diferenca = $data1->diff( $data2 );
           $ano = $diferenca->y * 364 ;
	       $mes = $diferenca->m * 30;
		   $dia = $diferenca->d;
           $dias_acesso = $ano + $mes + $dia;
			
		}else{
			 $dias_acesso = 0;
		}
		
		$SQLUsuario = "select * from usuario WHERE id_usuario = '".$usuario_ssh['id_usuario']."'  ";
        $SQLUsuario = $conn->prepare($SQLUsuario);
        $SQLUsuario->execute();
		
		
        $usuario_sistema = $SQLUsuario->fetch();
		
		$owner;
		
		if(($SQLUsuario->rowCount()) > 0){
			if($usuario_ssh['id_usuario']!=$_SESSION['usuarioID'])  {
				if($usuario_sistema['id_mestre']!=$_SESSION['usuarioID']){
					 echo '<script type="text/javascript">';
			echo 	'alert("Nao permitido!");';
			echo	'window.location="home.php?page=ssh/contas";';
			echo '</script>'; 
				}
			}
		}else{
		    echo '<script type="text/javascript">';
			echo 	'alert("Nao encontrado!");';
			echo	'window.location="home.php?page=ssh/contas";';
			echo '</script>'; 
		
	}
	
	}else{
		    echo '<script type="text/javascript">';
			echo 	'alert("Nao encontrado!");';
			echo	'window.location="home.php?page=ssh/contas";';
			echo '</script>'; 
		
	}
	
  
  }else{
	        echo '<script type="text/javascript">';
			echo 	'alert("Preencha todos os campos!");';
			echo	'window.location="home.php?page=ssh/contas";';
			echo '</script>'; 
	  
  }
?>
<section class="content">
      <div class="row">
	   <?php if($usuario_ssh['status'] == 2 ){?>
	    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <center><h4><i class="icon fa fa-ban"></i>  Esta conta se encontra suspensa! </h4></center>
               
        </div>
	   <?php }?>
	   
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
             <center> <h3 class="box-title">Detalhes da conta SSH</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
          
              <div class="box-body">
			    
                <div class="form-group">
                  
				  <p> IP Servidor: <?php echo $ssh_srv['ip_servidor']; ?> </p>
				  <p> Login SSH: <?php echo $usuario_ssh['login']; ?> </p>
				  <p> Proxy: <?php echo $ssh_srv['ip_servidor']; ?>:8080 </p>
				  <p> Porta SSH: 22 | 443 </p>
				 
				   <p>Dias restante: <strong><?php echo $dias_acesso; ?></strong></p>
				  
					
                  <input type="hidden" class="form-control" id="login_ssh" name="login_ssh" placeholder="Digite Senha" value="<?php echo $usuario_ssh['login']; ?>">
                </div>
				
				 
				
				
				
			
                
				
			  <tr>
       
        <td >

				
              </div>
			   <form role="form2" action="pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
              <!-- /.box-body -->
			   <div class="box-footer">
                 
					<input type="hidden"  id="diretorio" name="diretorio" value="../../home.php?page=ssh/contas"  >
					<input type="hidden"  id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>"  >
                    <input type="hidden"  id="owner" name="owner" value="<?php echo $_SESSION['usuarioID']; ?>"  >
					 <center><button type="submit" class="btn btn-danger" id="op" name="op" value="deletar" >Deletar conta SSH</button>
					<?php if($usuario_ssh['status']==2){?>
					<button type="submit" class="btn btn-success" id="op" name="op" value="ususpender" >Reativar conta</button>
					<?php }else{ ?>
						  <button type="submit" class="btn btn-warning" id="op" name="op" value="suspender" >Suspender conta</button>
					<?php } ?>
					 </center>
               </div>           
		   
          </div>
		  </form>
          <!-- /.box -->

		   <?php if($usuario['tipo']=="revenda"){?>
		    <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Owner da conta SSH </h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
			
            <form role="form2" action="pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
              <div class="box-body">
              
                <div class="form-group">
              
                <select class="form-control select2" style="width: 70%;margin-left: 100px; "  name="n_owner" id="n_owner">
				
				  <?php if($usuario_sistema['id_usuario'] == $_SESSION['usuarioID']){
					  $owner = $_SESSION['usuarioID'];
					  ?>
				  <option selected="selected" value="<?php echo $_SESSION['usuarioID']; ?>">Usuário do Sistema</option>
				  <?php 
				  } else{ 
                     $owner = $usuario_sistema['id_usuario'];
				  ?>
				     <option selected="selected" value="<?php echo $usuario_sistema['id_usuario']; ?>"><?php echo $usuario_sistema['login']; ?></option>
					  <option  value="<?php echo $_SESSION['usuarioID']; ?>">Usuário do Sistema</option>
				  <?php 
				  } 
				  ?>
				  
				 <?php

	

	 $SQLUsuario = "SELECT * FROM usuario where id_mestre = '".$_SESSION['usuarioID']."'";
     $SQLUsuario = $conn->prepare($SQLUsuario);
     $SQLUsuario->execute();
    
if (($SQLUsuario->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLUsuario->fetch()) {
		if($row['id_usuario'] != $usuario_sistema['id_usuario']){

  
		?>
        
	<option value="<?php echo $row['id_usuario'];?>" ><?php echo $row['login'];?></option>
	
   <?php }
	}
}

?>
                </select>
              </div>
			 
                
               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                    <input type="hidden"  id="op" name="op" value="owner"  >
                    
					<input type="hidden"  id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>"  >
					
					<input type="hidden"  id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>"  >
					
                    <input type="hidden"  id="owner" name="owner" value="<?php echo $owner; ?>"  >
					
                <center><button type="submit" class="btn btn-primary">Alterar Owner da conta SSH</button> </center>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
          <?php }else{
			$owner = $_SESSION['usuarioID'];
		  }?>

          
		  
          <!-- Horizontal Form  -->
          <div class="box box-primary">
            <div class="box-header with-border">
               <center><h3 class="box-title">Alterar Senha</h3> </center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
			
            <form role="senha" id="senha" name="senha" action="pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                   <label for="inputEmail3" class="col-sm-2 control-label">Senha</label> 

                  <div class="col-sm-10">
                    <input required="required" type="text" class="form-control" id="senha_ssh" name="senha_ssh" placeholder="Digite a nova senha">
                  </div>
				  
				    <input type="hidden"  id="op" name="op" value="senha"  >
                    <input type="hidden"  id="id_ssh" name="id_ssh" value="<?php echo $_GET["id_ssh"]; ?>"  >
					<input type="hidden"  id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>"  >
					<input type="hidden"  id="id_servidor" name="id_servidor" value="<?php echo $ssh_srv['id_servidor']; ?>"  >
					<input type="hidden"  id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>"  >
                    <input type="hidden"  id="owner" name="owner" value="<?php echo $_SESSION['usuarioID']; ?>"  >
                </div>
               
               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <center> <button type="submit" class="btn btn-primary">Alterar Senha</button> </center>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
		  <?php if($usuario['tipo']=="revenda"){?>
		   <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Acesso simultâneo </h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
			
            <form role="form2" action="pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Quantidade</label>

                  <div class="col-sm-10">
                    <input required="required" type="number" class="form-control" id="acesso" name="acesso" placeholder="Digite a quantidade de acesso" value="<?php echo $usuario_ssh['acesso']; ?>">
                  </div>
				  
				  
                   
                    <input type="hidden"  id="op" name="op" value="acesso"  >               
					<input type="hidden"  id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>"  >					
					<input type="hidden"  id="id_usuario_ssh" name="id_usuario_ssh" value="<?php echo $usuario_ssh['id_usuario_ssh']; ?>"  >
                    <input type="hidden"  id="owner" name="owner" value="<?php echo $owner; ?>"  >
				    <input type="hidden"  id="sistema" name="sistema" value="<?php echo $_SESSION['usuarioID']; ?>"  >
                </div>
               
               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <center><button type="submit" class="btn btn-primary">Alterar conexão simultânea</button> </center>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
		  
		    <!-- Horizontal Form -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Dias de acessos </h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
           
			
            <form role="form2" action="pages/system/funcoes.conta.ssh.php" method="post" class="form-horizontal">
              <div class="box-body">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">Quantidade</label>

                  <div class="col-sm-10">
                    <input required="required" type="number" class="form-control" id="dias" name="dias" placeholder="Digite a quantidade dias de acesso" value="<?php echo $dias_acesso; ?>" >
                  </div>
				  
				  
                 
                    <input type="hidden"  id="op" name="op" value="dias"  >
                    <input type="hidden"  id="id_usuarioSSH" name="id_usuarioSSH" value="<?php echo $_GET["id_ssh"]; ?>"  >
					<input type="hidden"  id="diretorio" name="diretorio" value="<?php echo $diretorio; ?>"  >
					
                    <input type="hidden"  id="owner" name="owner" value="<?php echo $_SESSION['usuarioID']; ?>"  >
				  
                </div>
               
               
              </div>
              <!-- /.box-body -->
              <div class="box-footer">
                
                <center><button type="submit" class="btn btn-primary">Alterar dias de acesso</button> </center>
              </div>
              <!-- /.box-footer -->
            </form>
          </div>
          <!-- /.box -->
		  <?php }?>
		  
		  

        </div>
        
      </div>
      <!-- /.row -->
    </section>