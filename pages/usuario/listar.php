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
              <center><h3 class="box-title">Contas de usuário do sistema</h3></center>

             
            </div>
            <!-- /.box-header -->
            <div class="box-body table-responsive no-padding">
              <table class="table table-hover">
                <tr >
                  <th>Status</th>
                  <th>Nome</th>
                  <th>Login</th>
                  <th>Tipo</th>
				  <th>Contas SSH</th>
				  <th>Acessos SSH</th>
				   <th>Informações</th>
                </tr>
               
				  <?php

				   
	
	               
					$SQLUPUser= "SELECT * FROM usuario where id_mestre =  '".$usuario['id_usuario']."' ORDER BY ativo ";
                    $SQLUPUser = $conn->prepare($SQLUPUser);
                    $SQLUPUser->execute(); 

					// output data of each row
                   if (($SQLUPUser->rowCount()) > 0) {
                   
                   while($row = $SQLUPUser->fetch()) 
				    
				   
				   {
					  $SQLSubUser= "SELECT * FROM usuario_ssh where id_usuario =  '".$row['id_usuario']."' ";
                      $SQLSubUser = $conn->prepare($SQLSubUser);
                      $SQLSubUser->execute(); 	  
					  $contas = $SQLSubUser->rowCount();
					  $color = "";
					  $status="";
					  $tipo="";
				    if($row['ativo']== 1){
						 $status="Ativo";
					}else if($row['ativo']!= 1){
						$status="Suspenso";
						$color = "bgcolor='#FF6347'";
					}else{
						
					}  
					if($row['tipo']=="vpn"){
						 $tipo="Usuário SSH";
					}else{
						 $tipo="Revendedor";
					}
					
					$total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
		
		
					   
					   ?>
				   
                  <tr  <?php echo $color; ?> >
				   <td ><?php echo $status;?></td>
                   <td><?php echo $row['nome'];?></td>
                  
                   <td><?php echo $row['login'];?></td>
                   <td><?php echo $tipo;?></td>
				    <td><?php echo $contas;?></td>
					 <td><?php echo $total_acesso_ssh;?></td>
					
                  
				   <td>
				      
					   <a href="home.php?page=usuario/perfil&id_usuario=<?php echo $row['id_usuario'];?>" class="btn btn-primary">	Visualizar</a>
					   
					
				   
				   </td>
                  </tr>
				
				
	
	
   <?php } } ?>
				
				
				
                
                
              </table>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
      </div>
	  
	  
 
    </section>
	
	
	
