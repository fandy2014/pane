<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}



   if(isset($_GET["id_usuario"])){
	   $id_usuario=$_GET['id_usuario'];
	   $diretorio = "../../admin/home.php?page=usuario/perfil&id_usuario=".$id_usuario;
	   $SQLUsuario = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
       $SQLUsuario = $conn->prepare($SQLUsuario);
       $SQLUsuario->execute();
	   $usuario = $SQLUsuario->fetch();
       if(($SQLUsuario->rowCount()) <= 0){
				echo '<script type="text/javascript">';
			echo 	'alert("O usuario nao existe!");';
			echo	'window.location="home.php?page=usuario/listar";';
			echo '</script>';
			exit;
			}
	   
	   $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_usuario = '".$id_usuario."' ";
       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
       $SQLUsuarioSSH->execute();
	   $total_ssh = $SQLUsuarioSSH->rowCount();
	   
	   
	   $total_ssh_sub = 0;
	   
	   if($usuario['tipo']=="revenda"){
		   
		   
		   $SQLUsuarioSUB = "select * from usuario WHERE id_mestre = '".$_GET['id_usuario']."' ";
           $SQLUsuarioSUB = $conn->prepare($SQLUsuarioSUB);
           $SQLUsuarioSUB->execute();
	       $total_user = $SQLUsuarioSUB->rowCount();
		   
		   if(($SQLUsuarioSUB->rowCount()) > 0){
			    while($row_sub = $SQLUsuarioSUB->fetch()) {
	
					$SQLUsuarioSSH = "select * from usuario_ssh WHERE id_usuario = '".$row_sub['id_usuario']."' ";
                    $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                    $SQLUsuarioSSH->execute();
	                $total_ssh_sub += $SQLUsuarioSSH->rowCount();
	                
					
				}
				$total = $total_ssh +$total_ssh_sub;
			   
		   }
		   
	   }
	   
	   
	   
	   
			
			
	   if($usuario['id_mestre']!=0 ){
		
		$SQLUsuario = "select * from usuario WHERE id_usuario = '".$usuario['id_mestre']."'  ";
        $SQLUsuario = $conn->prepare($SQLUsuario);
        $SQLUsuario->execute();
	    $usuario_mestre = $SQLUsuario->fetch();
					
	   }
	   
   }else{
	   
	    echo '<script type="text/javascript">';
		echo 	'alert("Preencha todos os campos!");';
		echo	'window.location="home.php?page=usuario/listar";';
		echo '</script>'; 
   }
	

?>



    <!-- Main content -->
    <section class="content">

      <div class="row">
	    <?php if($usuario['ativo'] == 2 ){?>
	    <div class="alert alert-danger alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <center><h4><i class="icon fa fa-ban"></i>  Esta conta se encontra suspensa!! </h4></center>
               
        </div>
	   <?php }?>
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
              <img class="profile-user-img img-responsive img-circle" src="../dist/img/avatar5.png" alt="User profile picture">

              <h3 class="profile-username text-center"><?php echo $usuario['nome'];?></h3>
             <?php if($usuario['tipo']== "vpn"){ ?>
			 <p class="text-muted text-center">Usuário SSH</p>
				
				<?php }else{ ?>
				<p class="text-muted text-center">Revendedor</p>
				
				 
				<?php } ?>
              

              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b>Contas SSH</b> <a class="pull-right"><?php echo $total_ssh;?></a>
                </li>
				<?php if($usuario['tipo']=="revenda"){?>
                <li class="list-group-item">
                  <b>Contas Sistema</b> <a class="pull-right"><?php echo $total_user;?></a>
                </li>
                <li class="list-group-item">
                  <b>Sub contas SSH</b> <a class="pull-right"><?php echo $total_ssh_sub;?></a>
                </li>
				<?php } ?>
				
				
              </ul>
 				    <center><a href="../pages/system/funcoes.usuario.php?&op=deletar&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/revenda&owner=<?php echo $accessKEY;?>" class="btn btn-danger">Deletar TUDO</a></center>
 <br>

              <?php if($usuario['ativo']== 1){?>
			    <center><a href="../pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $accessKEY;?>&op=suspender" class="btn btn-primary btn-warning"><b>SUSPENDER TUDO</b></a></center><br>
			 <?php }else{?>
			    <center><a href="../pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $accessKEY;?>&op=ususpender" class="btn btn-primary btn-success"><b>REATIVAR TUDO</b></a></center><br>
				
			 <?php }?>
              <center><a href="../pages/system/funcoes.usuario.php?&id_usuario=<?php echo $usuario['id_usuario'];?>&diretorio=../../admin/home.php?page=usuario/listar&owner=<?php echo $accessKEY;?>&op=senha" class="btn btn-primary btn-primary"><b>REENVIAR SENHA</b></a></center>
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
			  
               $SQLHistorico = "select * from historico_login WHERE id_usuario = '".$id_usuario."' LIMIT 3 ";
               $SQLHistorico = $conn->prepare($SQLHistorico);
               $SQLHistorico->execute();
	          
	

if (($SQLHistorico->rowCount()) > 0) {
    // output data of each row
    while($row = $SQLHistorico->fetch()) {
		
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
			  <?php if($usuario['tipo']=="revenda"){?>
              <li><a href="#timeline" data-toggle="tab">Servidores</a></li>
              <li><a href="#users" data-toggle="tab">Usuários</a></li>
			  <?php }?>
			  <li><a href="#ssh" data-toggle="tab">Contas SSH</a></li>
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
                 <form class="form-horizontal"  role="perfil" name="perfil" id="perfil" action="pages/usuario/editar_exe.php" method="post" >
				 <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Login</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" disabled value="<?php echo $usuario['login'];?>">
					  <input type="hidden" class="form-control" id="login" name="login" value="<?php echo $usuario['login'];?>">
                    </div>
                  </div>
				 
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Nome</label>

                    <div class="col-sm-10">
                      <input type="text" class="form-control" id="nome" name="nome" value="<?php echo $usuario['nome'];?>">
                    </div>
                  </div>
				  
                  <div class="form-group">
                    <label for="inputEmail" class="col-sm-2 control-label">Email</label>

                    <div class="col-sm-10">
                      <input type="email" class="form-control" id="email" name="email" value="<?php echo $usuario['email'];?>">
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Celular</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="celular" name="celular" value="<?php echo $usuario['celular'];?>">
                    </div>
                  </div>
                  
				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Data de cadastro</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" disabled value="<?php echo $usuario['data_cadastro'];?>">
                    </div>
                  </div>
				  <?php if($usuario['tipo']=="revenda"){?>
				  <div class="form-group">
                    <label for="inputName" class="col-sm-2 control-label">Data de Vencimento</label>

                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="validade" name="validade"  value="<?php echo $usuario['validade']; ?>">
                    </div>
                  </div>
				  <?php } ?>
				  
                  
                  
                  <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                      <button type="submit" class="btn btn-primary">Alterar Dados</button>
                    </div>
                  </div>
                </form>

              </div>
              <!-- /.tab-pane -->
			  <?php if($usuario['tipo']=="revenda"){?>
              <div class=" tab-pane" id="timeline">
                  <form  role="servidor" name="servidor" id="servidor" action="pages/usuario/adiciona_acesso.php" method="post">
		  
             <div class="form-group">
                <label>Selecione um servidor</label>
                <select class="form-control select2" style="width: 100%;"  name="servidor" id="servidor">
                  <option selected="selected" value="0">Selecione um servidor</option>
                 
                  <?php

	
    $SQLServidor = "select * from servidor   ";
    $SQLServidor = $conn->prepare($SQLServidor);
    $SQLServidor->execute();
	
if (($SQLServidor->rowCount()) > 0) {
    // output data of each row
    while($row2 = $SQLServidor->fetch()   ) {
	   
		$SQLAcessoServidor = "select * from acesso_servidor where id_servidor='".$row2['id_servidor']."'  and id_usuario = '".$_GET['id_usuario']."'";
        $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
        $SQLAcessoServidor->execute();
	    				
		
		if(($SQLAcessoServidor->rowCount()) == 0 ){
		?>
        
	<option value="<?php echo $row2['id_servidor'];?>" > <?php echo $row2['nome'];?> - <?php echo $row2['ip_servidor'];?>   </option>
	
		<?php 
		}
   }
}


?>
				  
				  
                </select>
              </div>
              <!-- /.form group -->

               
			  
			  <div class="form-group"id="qtd_ssh" >
                  <label  >Limite de Acessos SSH</label>
                  <input required="required" type="number" class="form-control" id="qtd" name="qtd" placeholder="Digite a quantidade">
              </div>
			  <div class="form-group"id="qtd_ssh" >
                  
                  <input  type="hidden" class="form-control" id="usuario" name="usuario" value="<?php echo $_GET['id_usuario'];?>">
              </div>

			  
			  <div class="box-footer">
                <button type="submit" class="btn btn-primary">Adicionar</button>
              </div>
            </form>
       </br>
     
            <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Servidores com acesso</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Servidor</th>
                  <th>Limite Acessos</th>
                  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				  <th></th>
                  
                </tr>
				 <?php

	
    $SQLAcessoServidor = "select * from acesso_servidor where id_usuario='".$_GET['id_usuario']."'  ";
    $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
    $SQLAcessoServidor->execute();

		
if (($SQLAcessoServidor->rowCount()) > 0) {
   
	   
    while($row2 = $SQLAcessoServidor->fetch()   ){
		 
		   $SQLTotalUser = "select * from usuario WHERE id_usuario = '".$_GET['id_usuario']."' ";
           $SQLTotalUser = $conn->prepare($SQLTotalUser);
           $SQLTotalUser->execute();
	       $total_user = $SQLTotalUser->rowCount();
          
		   
		
		 $SQLServidor = "select * from servidor where id_servidor = '".$row2['id_servidor']."'";
         $SQLServidor = $conn->prepare($SQLServidor);
         $SQLServidor->execute();
	     			
		 
		
		 $contas=0;
		 $acessos=0;
		 
		 
		 $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$row2['id_servidor']."' 
		                                               and id_usuario='".$_GET['id_usuario']."'  ";
         $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
         $SQLUsuarioSSH->execute(); 
		 $contas += $SQLUsuarioSSH->rowCount();
		 
		 $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row2['id_servidor']."'  and id_usuario='".$_GET['id_usuario']."' ";
         $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
         $SQLAcessoSSH->execute();
	     $SQLAcessoSSH = $SQLAcessoSSH->fetch();
         $acessos += $SQLAcessoSSH['quantidade'];
							
		 
		 
		    $SQLUsuarioSub = "select * from usuario WHERE id_mestre = '".$_GET['id_usuario']."'  ";
            $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
            $SQLUsuarioSub->execute();
	       
			 if (($SQLUsuarioSub->rowCount()) > 0) {
			  while($row3 = $SQLUsuarioSub->fetch()   ){
				  
				  $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$row2['id_servidor']."' 
		                                               and id_usuario='".$row3['id_usuario']."'  ";
                  $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                  $SQLUsuarioSSH->execute(); 
		          $contas += $SQLUsuarioSSH->rowCount();
				  
				   $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row2['id_servidor']."'  and id_usuario='".$row3['id_usuario']."' ";
                   $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                   $SQLAcessoSSH->execute();
	               $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                   $acessos += $SQLAcessoSSH['quantidade'];
				  
				  
				  
			    }
			 }
		 
		            
		
		
		 
		 if (($SQLServidor->rowCount()) > 0) {
			  while($row3 = $SQLServidor->fetch()   ){
				  
				$qtd_srv =0;
		 
		 ?>
	
	
	          <tr>
                  <td><?php echo $row3['nome'];?></td>
                  <td><?php echo $row2['qtd'];?></td>
                  <td><?php echo $contas;?></td>
				   <td><?php echo $acessos;?></td>
				  <td>
				    <center>
					<a href="#" class="btn btn-warning">Editar Acesso</a>
					<a href="pages/usuario/remover_servidor.php?&id_acesso=<?php echo $row2['id_acesso_servidor'];?>" class="btn btn-danger">Apagar Tudo</a>
					
					</center>
				  </td>
                 
                </tr>
		
		
	<?php 
			  }
		 }
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
      
              <div class="tab-pane" id="users">
			  
                
				<div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
              <h3 class="box-title">Usuários de sistema</h3>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Login</th>
                  <th>Nome</th>
                  <th>Contas</th>
				 
                  
                </tr>
				 <?php

    $SQLUsuarioSUB = "select * from usuario where id_mestre='".$usuario['id_usuario']."'  ";
    $SQLUsuarioSUB = $conn->prepare($SQLUsuarioSUB);
    $SQLUsuarioSUB->execute();
   						
		
if (($SQLUsuarioSUB->rowCount()) > 0) {
    // output data of each row
    while($row_user = $SQLUsuarioSUB->fetch()   ){
		
		$total_ssh = 0;
		 
	    $SQLUsuarioSSH = "select * from usuario_ssh where id_usuario = '".$row_user['id_usuario']."' ";
        $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
        $SQLUsuarioSSH->execute();
	    $total_ssh += $SQLUsuarioSSH->rowCount();
        $color = "";
		
		
				    if($row_user['ativo']== 2){
						
						$color = "bgcolor='#FF6347'";
					}       				
		 
		 ?>
	
	
	          <tr <?php echo $color; ?>>
                  <td><?php echo $row_user['login'];?></td>
                  <td><?php echo $row_user['nome'];?></td>
                  <td><?php echo $total_ssh;?></td>
				 
                 
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
              <?php }?>
			  <!-- /.tab-pane -->
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
				  <th>Acessos</th>
                  <th>Owner</th>
				  
                  
                </tr>
				 <?php

	
    
	$SQLUsuarioSSH = "select * from usuario_ssh where id_usuario='".$usuario['id_usuario']."'";
    $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
    $SQLUsuarioSSH->execute();
				
		
if (($SQLUsuarioSSH->rowCount()) > 0) {
	
    // output data of each row
    while($row_user = $SQLUsuarioSSH->fetch()   ){

		$SQLServidor = "select * from servidor where id_servidor='".$row_user['id_servidor']."'  ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
	    $servidor = $SQLServidor->fetch();
       $color = "";
	   
	    $acessos = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario_ssh='".$row_user['id_usuario_ssh']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $acessos += $SQLAcessoSSH['quantidade'];
		
		
				    if($row_user['status']== 2){
						
						$color = "bgcolor='#FF6347'";
					}  
					
			
		 
		 ?>
	
	
	          <tr <?php echo $color; ?>>
                  <td><?php echo $row_user['login'];?></td>
                  <td><?php echo $servidor['nome'];?></td>
				  <td><?php echo $acessos;?></td>
                  <td>Owner</td>
				  
                 
                </tr>
		
		
	<?php 
		
			  
	}
}



if($usuario['tipo'] == "revenda"){
		  
			$SQLUserSub = "select * from usuario where id_mestre = '".$usuario['id_usuario']."'  ";
            $SQLUserSub = $conn->prepare($SQLUserSub);
            $SQLUserSub->execute();
	       
           				
           
		    
			if (($SQLUserSub->rowCount()) > 0) {
				
				while($row_user_sub = $SQLUserSub->fetch()   ){
					
					
					$SQLSubSSH = "select * from usuario_ssh where id_usuario='".$row_user_sub['id_usuario']."'  ";
                    $SQLSubSSH = $conn->prepare($SQLSubSSH);
                    $SQLSubSSH->execute();
	             		
					if (($SQLSubSSH->rowCount()) > 0) {
						while($row_ssh_sub = $SQLSubSSH->fetch()   ){ 
						
		                $SQLServidor = "select * from servidor where id_servidor='".$row_ssh_sub['id_servidor']."'  ";
                        $SQLServidor = $conn->prepare($SQLServidor);
                        $SQLServidor->execute();
	             	    $servidor = $SQLServidor->fetch();
                         $color = "";
		                  $acessos  = 0;
		
				    if($row_ssh_sub['status']== 2){
						
						$color = "bgcolor='#FF6347'";
					}  
					
					 $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario_ssh='".$row_ssh_sub['id_usuario_ssh']."'  ";
                     $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                     $SQLAcessoSSH->execute();
		             $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                     $acessos += $SQLAcessoSSH['quantidade'];
					
		
						?>
						
							<tr <?php echo $color; ?>>
                  <td><?php echo $row_ssh_sub['login'];?></td>
                  <td><?php echo $servidor['nome'];?></td>
				  <td><?php echo $acessos;?></td>
                  <td><?php echo $row_user_sub['login'];?></td>
				  
                 
                </tr>
							
					<?php	}
						
					}
				}
				
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
  