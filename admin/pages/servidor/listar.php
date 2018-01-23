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
              <center><h3 class="box-title">Servidores SSH</h3></center>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  <th>Nome</th>
                  <th>Endereço IP</th>
                  <th>Login</th>
                  <th>Contas Criadas</th>
				  <th>Acessos Liberados</th>
				  <th>Informações</th>
                </tr>
                
				  <?php

				   
	
	            
					
                    $SQLServidor = "select * from servidor";
                    $SQLServidor = $conn->prepare($SQLServidor);
                    $SQLServidor->execute();
					   
					// output data of each row
                   if (($SQLServidor->rowCount()) > 0) {
                   
                   while($row = $SQLServidor->fetch()) 
				    
				   
				   { 
				       $acessos = 0 ;
					   $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor='".$row['id_servidor']."' ";
                       $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                       $SQLAcessoSSH->execute();
	                   $SQLAcessoSSH = $SQLAcessoSSH->fetch();
                       $acessos += $SQLAcessoSSH['quantidade'];
					   
					   $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$row['id_servidor']."' ";
                       $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
                       $SQLUsuarioSSH->execute();
					   
	                   $qtd_ssh = $SQLUsuarioSSH->rowCount();
					   
					   ?>
				   
                  <tr>
				  
                   <td><?php echo $row['nome'];?></td>
                   <td><?php echo $row['ip_servidor'];?></td>
                   <td><?php echo $row['login_server'];?></td>
				    <td><?php echo $qtd_ssh;?></td>
					 <td><?php echo $acessos;?></td>
					
                  
				   <td>
				     
					
				    <a href="home.php?page=servidor/servidor&id_servidor=<?php echo $row['id_servidor'];?>" class="btn btn-primary">	Visualizar</a>
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
	  
	
    </section>
	
	
	
