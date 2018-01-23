<?php

	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
 <section class="content">
     <div class="row">
        <div class="col-xs-12">
          <div class="box box-primary">
            <div class="box-header">
             <center> <h3 class="box-title">Usuários SSH</h3></center>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                    <th>Status</th>
                  <th>Nome</th>
                  <th>Login</th>
				  <th>Tipo</th>
				  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				  <th>Owner</th>
				  <th>Informações</th>
                </tr>
                
				
				
				  <?php

				    $SQLUsuario = "SELECT * FROM usuario  where tipo='vpn' ORDER BY ativo ";
                    $SQLUsuario = $conn->prepare($SQLUsuario);
                    $SQLUsuario->execute();
					
	                // output data of each row
                   if (($SQLUsuario->rowCount()) > 0) {
                   
                   while($row = $SQLUsuario->fetch()) 
					     
				   
				   {
					   $class = "class='btn btn-danger'";
					  $status="";
					  $tipo="";
					  $owner = "";
					   $contas = 0;
					    $color = "";
				    if($row['ativo']== 1){
						 $status="Ativo";
						 $class = "class='btn btn-primary'";
					}else{
						$status="Desativado";
						$color = "bgcolor='#FF6347'";
					}  
					 
					$SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'";
                    $SQLContasSSH = $conn->prepare($SQLContasSSH);
                    $SQLContasSSH->execute();
                    $contas += $SQLContasSSH->rowCount();
					
					$total_acesso_ssh = 0;
	                $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
                    $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                    $SQLAcessoSSH->execute();
	             	$SQLAcessoSSH = $SQLAcessoSSH->fetch();
                    $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
					
					
						
					if($row['tipo']=="vpn"){
						$tipo="Usuário SSH";
						
					}else{
						$tipo="Revendedor";
						
						
					}
					
					if($row['id_mestre'] == 0){
						$owner = "Sistema";
					}else{
						
						
						$SQLContasSSH = "select * from usuario WHERE id_usuario = '".$row['id_mestre']."'";
                        $SQLContasSSH = $conn->prepare($SQLContasSSH);
                        $SQLContasSSH->execute();
                        $revendedor = $SQLContasSSH->fetch();
						$owner = $revendedor['login'];
						
					}
					
					
					
					   ?>
				   
                  <tr <?php echo $color; ?> >
				   <td><?php echo $status;?></td>
                   <td><?php echo $row['nome'];?></td>
                  
                   <td><?php echo $row['login'];?></td>
                   
				   
					<td><?php echo $tipo;?></td>
					<td><?php echo $contas;?></td>
					<td><?php echo $total_acesso_ssh;?></td>
					<td><?php echo $owner;?></td>
                  
				   <td>
				     
					 
					   <a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" <?php echo $class;?>>Visualizar</a>
					
				   
				   </td>
                  </tr>
				
				
	
	
   <?php }
}


?>
				
				
               
                
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
	  
	  
    
      <!-- /.row -->
    </section>
	
	
	
