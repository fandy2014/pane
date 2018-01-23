<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}



   if(isset($_GET["id_usuario"])){
	  
       $id_usuario = $_GET["id_usuario"];
	   $owner= $_SESSION['usuarioID'];
	  
	   
	   $SQLUsuario= "SELECT * FROM usuario where id_usuario='".$id_usuario."' and id_mestre =  '".$_SESSION['usuarioID']."' ";
       $SQLUsuario = $conn->prepare($SQLUsuario);
       $SQLUsuario->execute();
	   
	    $SQLUsuarioSSH= "SELECT * FROM usuario_ssh where id_usuario='".$id_usuario."'   ";
       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
       $SQLUsuarioSSH->execute();
	   
	   $total_ssh = $SQLUsuarioSSH->rowCount();
	   
	    $total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$id_usuario."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
	   
	   
	  
	   if(($SQLUsuario->rowCount()) <= 0){
				echo '<script type="text/javascript">';
			echo 	'alert("O usuario nao existe!");';
			echo	'window.location="home.php?page=usuario/listar";';
			echo '</script>';
			exit;
		}else{
				$usuarioGET = $SQLUsuario->fetch();
		}
	   
	 
		
	   
	   
   }else{
	   
	    echo '<script type="text/javascript">';
		echo 	'alert("Preencha todos os campos!");';
		echo	'window.location="home.php?page=usuario/listar";';
		echo '</script>'; 
   }
	
	
	
	
	
	
	 $diretorio = " ";

?>



    <!-- Main content -->
    <section class="content">
      <!-- Alerta de usuario suspenso -->
      <div class="row">
	   <?php if($usuarioGET['ativo'] == 2 ){?>
	    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <center><h4><i class="icon fa fa-ban"></i>  Esta conta se encontra suspensa desde <?php echo $usuarioGET['suspenso']; ?> </h4></center>
               
        </div>
	   <?php }?>
			  
			  
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="dist/img/avatar5.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $usuarioGET['nome'];?></h3>
             <?php if($usuarioGET['tipo']== "vpn"){ ?>
			 <p class="text-muted text-center">Usuário SSH</p>
				
				<?php }else{ ?>
				<p class="text-muted text-center">Revendedor</p>
				
				 
				<?php } ?>
              

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Contas SSH</b> <a class="pull-right"><?php echo $total_ssh;?></a><br>
				  <b>Acessos SSH</b> <a class="pull-right"><?php echo $total_acesso_ssh;?></a>
                </li>
				
				
              </ul>
 <center><a href="pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=deletar"  class="btn btn-primary btn-danger"><b>DELETAR TUDO</b></a></center>
 <br>    
             <?php if($usuarioGET['ativo']== 1){?>
			    <center><a href="pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=suspender" class="btn btn-primary btn-warning"><b>SUSPENDER TUDO</b></a></center><br>
			 <?php }else{?>
			    <center><a href="pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=ususpender" class="btn btn-primary btn-success"><b>REATIVAR TUDO</b></a></center><br>
				
			 <?php }?>
              <center><a href="pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuarioGET['id_usuario'];?>&diretorio=../../home.php?page=usuario/listar&owner=<?php echo $owner;?>&op=senha" class="btn btn-primary btn-primary"><b>REENVIAR SENHA</b></a></center>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

          <!-- About Me Box -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title">Acesso</h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
          
                 <?php
                 $SQLHist= "SELECT * FROM historico_login where id_usuario='".$id_usuario."' LIMIT 4 ";
                 $SQLHist = $conn->prepare($SQLHist);
                 $SQLHist->execute();
			   
         
	

if (($SQLHist->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLHist->fetch()) {
		
		?>
        
	
	   
	    <strong><i class="fa fa-map-marker margin-r-5"></i> <?php echo $row['ip_login'];?></strong>

              <p class="text-muted"> <?php echo $row['data_login'];?></p>

              <hr>
			  
   <?php }
}


?>

             

             
             
             

             
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Informações do Usuário</a></li>
			  
			  <li><a href="#ssh" data-toggle="tab">Contas SSH</a></li>
			  
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                 <form class="form-horizontal"  role="perfil" name="perfil" id="perfil" action="pages/system/funcoes.usuario.php" method="get" >
				 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Login</label>

                    <div class="col-sm-10">
					<input type="hidden" class="form-control" id="op" name="op" value="dados">
                      <input type="text" class="form-control" disabled value="<?php echo $usuarioGET['login'];?>">
					  <input type="hidden" class="form-control" id="login" name="login" value="<?php echo $usuarioGET['login'];?>">
					   <input type="hidden" class="form-control" id="id_usuario" name="id_usuario" value="<?php echo $usuarioGET['id_usuario'];?>">
					      <input type="hidden" class="form-control" id="owner" name="owner" value="<?php echo $_SESSION['usuarioID'];?>">
					    <input type="hidden" class="form-control" id="diretorio" name="diretorio" value="../../home.php?page=usuario/perfil&id_usuario=<?php echo $usuarioGET['id_usuario'];?>">
                    </div>
                  </div>
				 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $usuarioGET['nome'];?>">
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuarioGET['email'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Celular</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $usuarioGET['celular'];?>">
                    </div>
                  </div>
                  
				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Data de cadastro</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" disabled value="<?php echo $usuarioGET['data_cadastro'];?>">
                    </div>
                  </div>
				  
				  
                  
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Alterar Dados</button>
                    </div>
                  </div>
                </form>

              </div>
             
			  <div class=" tab-pane" id="ssh">
			  	<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Contas SSH</h3>
               
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Login</th>
                  <th>Servidor</th>
                  <th>Validade</th>
				  <th></th>
                  
                </tr>
			
                		 <?php

	$SQLUsuario= "SELECT * FROM usuario_ssh where id_usuario =  '".$usuarioGET['id_usuario']."' and status <= '2' ";
    $SQLUsuario = $conn->prepare($SQLUsuario);
    $SQLUsuario->execute();
					
	
  
		
if (($SQLUsuario->rowCount()) > 0) {
	
    // output data of each row
    while($row_user = $SQLUsuario->fetch()   ){
		
		$SQLServidor= "SELECT * FROM servidor where id_servidor =  '".$row_user['id_servidor']."' ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
		$servidor = $SQLServidor->fetch();
		$color = "";
		
		
				    if($row_user['status']== 2){
						
						$color = "bgcolor='#FF6347'";
					}  
					
		
			
		 
		 ?>
	
	
	          <tr <?php echo $color; ?>  >
                  <td><?php echo $row_user['login'];?></td>
                  <td><?php echo $servidor['nome'];?></td>
                  <td><?php echo date('d/m/Y', strtotime($row_user['data_validade']));?></td>
				  <td>
				    
                    <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row_user['id_usuario_ssh'];?>" class="btn btn-primary">Detalhes</a></center>
                   
				 </td>
                 
                </tr>
		
		
	<?php 
		
			  
	}
}



	

?>
                
              
                
               
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
			  
           
		   
              </div>
              <!-- /.tab-pane -->
			  
            </div>
            <!-- /.tab-content -->
          </div>
          <!-- /.nav-tabs-custom -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->

    </section>
    <!-- /.content -->
  