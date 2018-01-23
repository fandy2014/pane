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
              <center><h3 class="box-title">Revendedores </h3><center>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                    <th>Status</th>
                  <th>Nome</th>
                  <th>Login</th>
				  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				  <th>Servidores</th>
				  <th>Vencimento</th>
				  <th>Informa&ccedil;&otilde;es</th>
                </tr>
                
				
				
				  <?php

				   
	
	               
                    $SQLUsuario = "SELECT * FROM usuario   where  tipo = 'revenda' ORDER BY ativo ";
                    $SQLUsuario = $conn->prepare($SQLUsuario);
                    $SQLUsuario->execute();
                    
		
					// output data of each row
                   if (($SQLUsuario->rowCount()) > 0) {
                   
                   while($row = $SQLUsuario->fetch()) 
				    
				   
				   {
					   $class = "class='btn btn-danger'";
					  $status="";
					  $color = "";
					   $contas = 0;
					   $servidores = 0;
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
					
					$SQLServidores = "select * from acesso_servidor WHERE id_usuario = '".$row['id_usuario']."'";
                    $SQLServidores = $conn->prepare($SQLServidores);
                    $SQLServidores->execute();
                    $servidores += $SQLServidores->rowCount();
					
					$total_acesso_ssh = 0;
	                $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
                    $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                    $SQLAcessoSSH->execute();
	             	$SQLAcessoSSH = $SQLAcessoSSH->fetch();
                    $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
					
					
					$SQLUserSub = "select * from usuario WHERE id_mestre = '".$row['id_usuario']."'";
                    $SQLUserSub = $conn->prepare($SQLUserSub);
                    $SQLUserSub->execute();
					
                    if (($SQLUserSub->rowCount()) > 0) {
    
                        while($rowS = $SQLUserSub->fetch()) {
                           $SQLContasSSH = "select * from usuario_ssh WHERE id_usuario = '".$rowS['id_usuario']."'";
                           $SQLContasSSH = $conn->prepare($SQLContasSSH);
                           $SQLContasSSH->execute();
                           $contas += $SQLContasSSH->rowCount();
						   
						    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$rowS['id_usuario']."' ";
                            $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                            $SQLAcessoSSH->execute();
	             	        $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                            $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
						  
							
						}
					}
					
					//Calcula os dias restante
	    $data_atual = date("Y-m-d ");
		$data_validade = $row['validade']; 
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
						
					
					
					
					
					
					   ?>
				   
                  <tr  <?php echo $color; ?> >
				   <td><?php echo $status;?></td>
                   <td><?php echo $row['nome'];?></td>
                  
                   <td><?php echo $row['login'];?></td>
                   
				   
					
					<td><?php echo $contas;?></td>
					<td><?php echo $total_acesso_ssh;?></td>
					<td><?php echo $servidores;?></td>
					<td >
					 
					<span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span> 
					 
					  
					</td>
					
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
	
	
	
