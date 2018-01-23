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
             <center> <h3 class="box-title">Contas SSH com erro</h3></center>

              
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  
                  <th>Servidor</th>
				  <th>IP SSH e Proxy</th>
                  <th>Problema</th>
                  <th>Login</th>
                  <th>Validade</th>
				  <th>Owner</th>
				  <th>Informações</th>
                </tr>
               
                
								  <?php
					$SQLSSH = "SELECT * FROM usuario_ssh , servidor  where usuario_ssh.id_servidor = servidor.id_servidor and usuario_ssh.status > '2'";
                    $SQLSSH = $conn->prepare($SQLSSH);
                    $SQLSSH->execute();
                    

					// output data of each row
                   if (($SQLSSH->rowCount()) > 0) {
                   
                   while($row = $SQLSSH->fetch()) 
				    
				   
				   {
					 $class = "class='btn btn-danger'";
					 $status="";
					 $erro="";
					 $owner="";
					 $color = "";
					 
						
				     if($row['status']== 1){
						 $status="Ativo";
						 $class = "class='btn btn-primary'";
					    }else if($row['status']== 2){
						$status="Suspenso";
						$color = "bgcolor='#FF6347'";
					} if($row['apagar']== 5){
						 $erro="Erro ao deletar";
						 
					    }
                    if($row['id_usuario'] == 0){
						 $owner="Sistema";
					    }else{
							
						$SQLRevendedor = "select * from usuario WHERE id_usuario = '".$row['id_usuario']."'";
                        $SQLRevendedor = $conn->prepare($SQLRevendedor);
                        $SQLRevendedor->execute();
                        $revendedor = $SQLRevendedor->fetch();
	   
						$owner = $revendedor['login'];
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
				   
                  <tr <?php echo $color; ?> >
				  
                   <td><?php echo $row['nome'];?></td>
				   <td><?php echo $row['ip_servidor'];?></td>
                   <td> <?php echo $erro; ?></td>
                   <td><?php echo $row['login'];?></td>
				   
                   <td>
				   <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span> 
					   
					   <?php echo date('d/m/Y', strtotime($row['data_validade']));?>
				  
				   
				   </td>
				   <td><?php echo $owner;?></td>
                  
				   <td>
				     
					
					  <a href="home.php?page=ssh/editar&id_ssh=<?php echo $row['id_usuario_ssh'];?>" <?php echo $class;?>>Visualizar</a>
					    
					 
				   
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
	
	
	
