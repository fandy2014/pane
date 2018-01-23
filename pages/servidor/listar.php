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
           
              <center><h3 class="box-title">Servidores disponível para criar contas SSH</h3></center>

             
           
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr>
                  
                  <th>Nome</th>
                  <th>Endereço IP</th>
                  <th>Limite de conexões SSH</th>
				  <th>Utilizado</th>
				   
                </tr>
               
				  <?php

				    $SQLAcessoServidor = "SELECT * FROM acesso_servidor where id_usuario = '".$_SESSION['usuarioID']."' ";
                    $SQLAcessoServidor = $conn->prepare($SQLAcessoServidor);
                    $SQLAcessoServidor->execute();
        
	                

					// output data of each row
                   if (($SQLAcessoServidor->rowCount()) > 0) {
                   
                   while($row = $SQLAcessoServidor->fetch()) 
				    
				   
				   {
					    $contas =0;  
					   $SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario = '".$_SESSION['usuarioID']."' and id_servidor='".$row['id_servidor']."' ";
                       $SQLContasSSH = $conn->prepare($SQLContasSSH);
                       $SQLContasSSH->execute();
		               $SQLContasSSH = $SQLContasSSH->fetch();
                       $contas += $SQLContasSSH['quantidade'];
					   
					   $SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' ";
                       $SQLSub = $conn->prepare($SQLSub);
                       $SQLSub->execute();
					   if (($SQLSub->rowCount()) > 0) {
				        while($row2 = $SQLSub->fetch()) {
				            $SQLSubSSH= "select sum(acesso) AS quantidade  from usuario_ssh WHERE id_usuario = '".$row2['id_usuario']."' and id_servidor='".$row['id_servidor']."' ";
                            $SQLSubSSH = $conn->prepare($SQLSubSSH);
                            $SQLSubSSH->execute();
					        $SQLSubSSH = $SQLSubSSH->fetch();
					        $contas += $SQLSubSSH['quantidade'];
				        }
				
			        }
					   
					   $SQLServidor= "select * from servidor WHERE id_servidor = '".$row['id_servidor']."' ";
                       $SQLServidor = $conn->prepare($SQLServidor);
                       $SQLServidor->execute();
					   $servidor =  $SQLServidor->fetch();
					  
					  
					   ?>
				   
                  <tr>
				   
                   <td><?php echo $servidor['nome'];?></td>
                  
                   <td><?php echo $servidor['ip_servidor'];?></td>
                   <td><?php echo $row['qtd'];?></td>
				    <td><?php echo $contas;?></td>
                  
				  
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
	
	
	
