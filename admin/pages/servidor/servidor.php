<?php


	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

   if(isset($_GET["id_servidor"])){
	    $SQLServidor = "select * from servidor WHERE id_servidor = '".$_GET['id_servidor']."' ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
		$servidor = $SQLServidor->fetch();
	   if(($SQLServidor->rowCount()) == 0 ){
		    echo '<script type="text/javascript">';
		echo 	'alert("Nao encontrado!");';
		echo	'window.location="home.php?page=servidor/listar";';
		echo '</script>'; 
		exit;
		
	   }
   }else{
	    echo '<script type="text/javascript">';
		echo 	'alert("Preencha todos os campos!");';
		echo	'window.location="home.php?page=servidor/listar";';
		echo '</script>';
        exit;		
   }
            
   
           //Realiza a comunicacao com o servidor
			$ip_servidor= $servidor['ip_servidor'];
		    $loginSSH= $servidor['login_server'];
			$senhaSSH=  $servidor['senha'];
			$ssh = new SSH2($ip_servidor); 
			 
			
			
		   //Verifica se o servidor esta online
		   $servidor_online = $ssh->online($ip_servidor);
           if ($servidor_online) {
			   $servidor_autenticado = $ssh->auth($loginSSH,$senhaSSH);
			   if($servidor_autenticado){
				$status= "<div class='alert alert-success alert-dismissible'>
               
                <h4><center>Autenticado</center></h4>
                 
              </div>";
				//Verifica memoria 
			 $ssh->exec("free");	     	
			 $mensagem = (string) $ssh->output();
             $words = preg_split("/[\s,]*\\\"([^\\\"]+)\\\"[\s,]*|" . "[\s,]*'([^']+)'[\s,]*|" . "[\s,]+/", 
			                         $mensagem, 0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
			//Memoria total $words[7]
			//Memoria usada $words[8]
			//Memoria livre $words[9]
			
			//Quantidade de CPU fisico
			$ssh->exec("cat /proc/cpuinfo | grep 'physical id' | sort | uniq | wc -l ");	     	
			$mensagem_f = (string) $ssh->output();
			$cpu_fisico = $mensagem_f;
			
			//Quantidade de CPU Virtual
			$ssh->exec("cat /proc/cpuinfo | egrep 'core id|physical id' | tr -d '\n' | sed s/physical/\\nphysical/g | grep -v ^$ | sort | uniq | wc -l");	     	
			$mensagem_v = (string) $ssh->output();
		    $cpu_virtual = $mensagem_v;
			
			//Nome do Processador
			$ssh->exec("cat /proc/cpuinfo | egrep ' model name|model name'");	     	
			$mensagem_p = (string) $ssh->output();
		    $partes = explode(":", $mensagem_p);
			$nome_processador= $partes[1];
			
			//UPTIME
			$ssh->exec("uptime");	     	
			$mensagem_u = (string) $ssh->output();
			$uptime = $mensagem_u;
			
			//Usuarios SSH online neste servidor
			$SQLContasSSH = "SELECT sum(online) AS soma  FROM usuario_ssh where id_servidor = '".$_GET['id_servidor']."'   ";
            $SQLContasSSH = $conn->prepare($SQLContasSSH);
            $SQLContasSSH->execute();
		    $SQLContasSSH = $SQLContasSSH->fetch();
            $usuarios_online = $SQLContasSSH['soma'];
			}else{
				$status= "<div class='alert alert-warning alert-dismissible'>
               
                <h4><center>Não Autenticado </center></h4>
                 
              </div>";
			}
			
		   
			
                  
            }else{
				$status= "<div class='alert alert-danger alert-dismissible'>
               
                <h4><center>OFFLINE </center></h4>
                 
              </div>";
			}


			
			 
			
    
   
	

?>
 <!-- Main content -->
    <section class="content">

      <div class="row">
        <div class="col-md-3">

          <!-- Profile Image -->
          <div class="box box-primary">
            <div class="box-body box-profile">
             
            
			  <?php echo $status; ?>
             <?php if($servidor_autenticado){?>
              <ul class="list-group list-group-unbordered">
                <li class="list-group-item">
                  <b><?php echo $nome_processador;?></b> 
                </li>
                <li class="list-group-item">
                  <b>CPU física</b> <a class="pull-right"><?php echo $cpu_fisico; ?></a>
                </li>
                <li class="list-group-item">
                  <b>CPU Virtual</b> <a class="pull-right"><?php echo $cpu_virtual; ?></a>
                </li>
				<li class="list-group-item">
                  <b>Memoria total</b> <a class="pull-right"><?php echo $words[7]; ?> Kb</a>
                </li>
				<li class="list-group-item">
                  <b>Memoria usada</b> <a class="pull-right"><?php echo $words[8]; ?> Kb</a>
                </li>
				<li class="list-group-item">
                  <b>Memoria livre</b> <a class="pull-right"><?php echo $words[9]; ?> Kb</a>
                </li>
				<li class="list-group-item">
                  <b>Usuários Online</b> <a class="pull-right"><?php echo $usuarios_online; ?> </a>
                </li>
              </ul>

            <center>  <a href="../admin/pages/servidor/servidor_exe.php?id_servidor=<?php echo $servidor['id_servidor'];?>&op=reiniciar" class="btn btn-warning">	Reiniciar Servidor</a><br><br>
			  <a href="../admin/pages/servidor/servidor_exe.php?id_servidor=<?php echo $servidor['id_servidor'];?>&op=desligar" class="btn btn-danger">	Desligar Servidor</a><br><br>
			  <a href="../admin/pages/servidor/servidor_exe.php?id_servidor=<?php echo $servidor['id_servidor'];?>&op=reiniciarSquid" class="btn btn-primary">	Reiniciar Squid</a><br><br>
			  <a href="../admin/pages/servidor/servidor_exe.php?id_servidor=<?php echo $servidor['id_servidor'];?>&op=updateScript" class="btn btn-success">	Update Scripts</a><br><br>
			  </center>
			 <?php }?>
            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->

        </div>
        <!-- /.col -->
        <div class="col-md-9">
          <div class="nav-tabs-custom">
            <ul class="nav nav-tabs">
              <li class="active"><a href="#activity" data-toggle="tab">Informações</a></li>
              <li><a href="#timeline" data-toggle="tab">Contas SSH</a></li>
			  <li><a href="#ehi" data-toggle="tab">EHI Download</a></li>
             
            </ul>
            <div class="tab-content">
              <div class="active tab-pane" id="activity">
			  
                   <form role="form" action="pages/servidor/editar_exe.php" method="post" enctype="multipart/form-data" >
              <div class="box-body">
			     <input type="hidden" class="form-control" id="id_servidor" name="id_servidor" value="<?php echo $servidor['id_servidor'];?>">
				<div class="form-group">
                  <label for="exampleInputEmail1">Nome do servidor</label>
                  <input required="required" type="text" class="form-control" id="nomesrv" name="nomesrv" value="<?php echo $servidor['nome'];?>">
                </div>
               
				<div class="form-group">
                  <label for="exampleInputEmail1">Endereço IP</label>
                  <input required="required" type="text" class="form-control" id="ip" name="ip" value="<?php echo $servidor['ip_servidor'];?>">
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">login</label>
                  <input required="required" type="text" class="form-control" id="login" name="login" value="<?php echo $servidor['login_server'];?>">
                </div>
				 <div class="form-group">
                  <label for="exampleInputPassword1">senha</label>
                  <input required="required" type="password" class="form-control" id="login" name="senha" value="<?php echo $servidor['senha'];?>">
                </div>
				
			
			
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Alterar Servidor</button>
				
				 <a href="../admin/pages/servidor/servidor_exe.php?id_servidor=<?php echo $servidor['id_servidor'];?>&op=deletarContas" class="btn btn-warning">	Deletar Contas</a><br><br>
                 <a href="../admin/pages/servidor/servidor_exe.php?id_servidor=<?php echo $servidor['id_servidor'];?>&op=deletarGeral" class="btn btn-danger">	Deletar TUDO</a><br><br>
             
			 </div>
            </form>
            
			</div>
              <!-- /.tab-pane -->
              <div class="tab-pane" id="timeline">
                
				  <table class="table table-hover">
                <tr>
                  <th>Login SSH</th>
                  <th>Vencimento</th>
				  <th>Online</th>
                  <th>Acesso</th>
				  
				  
                  
                </tr>
				 <?php

	
    $SQLUsuarioSSH = "select * from usuario_ssh where id_servidor='".$servidor['id_servidor']."'  ";
    $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
    $SQLUsuarioSSH->execute();

		
if (($SQLUsuarioSSH->rowCount()) > 0) {
   
	   
    while($row2 = $SQLUsuarioSSH->fetch()   ){
		 
		   $SQLTotalUser = "select * from usuario_ssh WHERE id_servidor='".$servidor['id_servidor']."' ";
           $SQLTotalUser = $conn->prepare($SQLTotalUser);
           $SQLTotalUser->execute();
	       $total_user = $SQLTotalUser->rowCount();
          

		 $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row2['id_servidor']."'  and id_usuario='".$_GET['id_usuario']."' ";
         $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
         $SQLAcessoSSH->execute();
	     $SQLAcessoSSH = $SQLAcessoSSH->fetch();
         $acessos += $SQLAcessoSSH['quantidade'];
		  $data_atual = date("Y-m-d ");
		$data_validade = $row2['data_validade']; 
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

		 
		 ?>
	
	
	          <tr>
                  <td><?php echo $row2['login'];?></td>
                  <td>  <span class="pull-left-container" style="margin-right: 5px;">
                            <span class="label label-primary pull-left">
					            <?php echo $dias_acesso."  dias   "; ?>
				            </span>
                       </span> </td>
                  <td><?php echo $row2['online'];?></td>
				<td><?php echo $row2['acesso'];?></td>
				 
                 
                </tr>
		
		
	<?php 
			  
		 
	}
}
?>
                
                
               
                
              </table>
            
				
			  </div>
              <!-- /.tab-pane -->
			  <div class="tab-pane" id="ehi">
                
				  <form role="form" action="#" method="post">
              <div class="box-body">
			  
			     <input type="hidden" class="form-control" id="id_servidor" name="id_servidor" value="<?php echo $servidor['id_servidor'];?>">
				
				<div class="form-group">
                  <label>Arquivo</label>
                  <input required="required" type="file" class="form-control" id="arquivo" name="arquivo" >
                </div>
               
			
			
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Enviar Configuração</button>
				
				
			 </div>
            </form>
            
				
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