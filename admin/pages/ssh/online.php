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
             <center> <h3 class="box-title">Contas SSH Online</h3></center>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr align="center">
                 
                  <th>Servidor</th>
				  <th>IP SSH e Proxy</th>
                  
				  <th>Login</th>
                  <th>Validade</th>
				   <th>Owner</th>
				   <th>Tempo</th>
				  <th>Online</th>
				  <th>Permitido</th>
				  
				  <th>Informações</th>
                </tr>
               
				  <?php
				  
                       
				    
					
					$SQLSub = "SELECT * FROM usuario";
                    $SQLSub = $conn->prepare($SQLSub);
                    $SQLSub->execute();
						
					
                    if(($SQLSub->rowCount()) > 0){
						 while($rowSub = $SQLSub->fetch()) {
						    $SQLSSH = "SELECT * FROM usuario_ssh , servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.id_usuario = '".$rowSub['id_usuario']."' ORDER BY usuario_ssh.id_usuario";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();
					
						    
						    if(($SQLSSH->rowCount()) > 0){
								while($row = $SQLSSH->fetch()){
									//Calcula os dias restante
		$dias_acesso = 0 ;
		
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
			
		}
		
		
								    $status="";
				                    if($row['status']== 1){
						                $status="Ativo";
										$class = "class='btn btn-primary'";
					                }else{
					           	        $status="Desativado";
				             	    }  
													
									if($row['online'] != 0){
									
								?>
								<tr>
				   
                   <td><?php echo $row['nome'];?></td>
				    <td><?php echo $row['ip_servidor'];?></td>
                  
                   <td><?php echo $row['login'];?></td>
                   <td>
				   
				       <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span> 
					   
					   
			
			      </td>
				  <td><?php echo $rowSub['login'];?></td>
				  <td><?php echo tempo_corrido($row['online_start']);?> </td>
				   <td><?php echo $row['online'];?></td>
				    <td><center><?php echo $row['acesso'];?></center></td>
                   
				   
				   <td> 
				   <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" <?php echo $class;?>>	Visualizar</a>
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
	
	
	
