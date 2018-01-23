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
             <center> <h3 class="box-title">Contas SSH</h3></center>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr align="center">
                 
                  <th>Servidor</th>
				  <th>IP SSH e Proxy</th>
                  <th>Porta SSH e Proxy</th>
				  <th>Login</th>
                  <th>Validade</th>
				  <th>Acessos</th>
				   <th>Owner</th>
				  <th>Informações</th>
                </tr>
               
				  <?php
				  
				     $SQLSub = "SELECT * FROM usuario where id_usuario= '".$_SESSION['usuarioID']."' ";
                        $SQLSub = $conn->prepare($SQLSub);
                        $SQLSub->execute();
						
						
					
                    if(($SQLSub->rowCount()) > 0){
						 while($rowSub = $SQLSub->fetch()) {
						    $SQLSubSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$_SESSION['usuarioID']."' ORDER BY status";
                            $SQLSubSSH = $conn->prepare($SQLSubSSH);
                            $SQLSubSSH->execute();
						
						   
						    if(($SQLSubSSH->rowCount()) > 0){
								while($row = $SQLSubSSH->fetch()){
								    $status="";
				                    if($row['status']== 1){
						                $status="Ativo";
					                }else{
					           	        $status="Desativado";
				             	    }  
									
									$color = "";
				                    if($row['status']== 2){
						
						              $color = "bgcolor='#FF6347'";
				                  	}  
									//Calcula os dias restante
	    $data_atual = date("Y-m-d ");
		$data_validade = $row['data_validade']; 
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
								<tr <?php echo $color; ?>>
				   
                   <td><?php echo $row['nome'];?></td>
				    <td><?php echo $row['ip_servidor'];?></td>
                   <td> 80,8080|443,22</td>
				  
                   <td><?php echo $row['login'];?></td>
				   
                   <td>
				   
				    <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span> 
					   
					   <?php echo date('d/m/Y', strtotime($row['data_validade']));?>
				   
				   </td>
                    <td><center><?php echo $row['acesso'];?></center></td>
				    <td>Sistema</td>
				   <td> 
				   <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn btn-primary">	Visualizar</a>
				   </td>
                  </tr>
								<?php 
								}
								
							}
						
					    }
					}
					
						

				    if($usuario['tipo']=="revenda"){
                       
				    
					
					$SQLSub = "SELECT * FROM usuario where id_mestre= '".$_SESSION['usuarioID']."'";
                    $SQLSub = $conn->prepare($SQLSub);
                    $SQLSub->execute();
						
					
                    if(($SQLSub->rowCount()) > 0){
						 while($rowSub = $SQLSub->fetch()) {
						    $SQLSSH = "SELECT * FROM usuario_ssh, servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$rowSub['id_usuario']."'";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();
					
						    
						    if(($SQLSSH->rowCount()) > 0){
								while($row = $SQLSSH->fetch()){
								    $status="";
				                    if($row['status']== 1){
						                $status="Ativo";
					                }else{
					           	        $status="Desativado";
				             	    }  
									$color = "";
				                    if($row['status']== 2){
						
						              $color = "bgcolor='#FF6347'";
				                  	}  
									
									
									
								?>
								<tr <?php echo $color; ?>>
				   
                   <td><?php echo $row['nome'];?></td>
				    <td><?php echo $row['ip_servidor'];?></td>
                   <td> 80,8080|443,22</td>
                   <td><?php echo $row['login'];?></td>
                   <td><?php echo date('d/m/Y', strtotime($row['data_validade']));?></td>
				    <td><center><?php echo $row['acesso'];?></center></td>
                   <td><?php echo $rowSub['login'];?></td>
				   
				   <td> 
				   <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" class="btn btn-primary">	Visualizar</a>
				   </td>
                  </tr>
								<?php 
								}
								
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
	  
	
    </section>
	
	
	
