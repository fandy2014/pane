<?php
require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");
require_once("../../../pages/system/classe.ssh.php");

	protegePagina("admin");
	
		if((isset($_POST["nomesrv"])) and (isset($_POST["ip"]))  and (isset($_POST["login"]))  and (isset($_POST["senha"])) and (isset($_POST["tipo"]))){   
			
			 $SQLServidor = "select * from servidor WHERE ip_servidor = '".$_POST['ip']."'  ";
             $SQLServidor = $conn->prepare($SQLServidor);
             $SQLServidor->execute();
			if(($SQLServidor->rowCount()) > 0){
				echo '<script type="text/javascript">';
			    echo 	'alert("Ja existe servidor com o ip '.$_POST['ip'].'");';
			    echo	'window.location="../../home.php?page=servidor/adicionar";';
			    echo '</script>';
			 }else{
				//Realiza a comunicacao com o servidor
			$ip_servidor= $_POST['ip'];
		    $loginSSH= $_POST['login'];
			$senhaSSH=  $_POST['senha'];
			$ssh = new SSH2($ip_servidor); 
			
			 $servidor_online = $ssh->online($_POST['ip']);
           if ($servidor_online) {
			  
				$servidor_autenticado = $ssh->auth($_POST["login"],$_POST["senha"]);
			   if($servidor_autenticado){
				   $SQLInsert = "INSERT INTO servidor (ip_servidor, nome, login_server, senha)
                                         VALUES ('".$_POST['ip']."', '".$_POST['nomesrv']."', '".$_POST['login']."',  '".$_POST['senha']."')";
             $SQLInsert = $conn->prepare($SQLInsert);
             $SQLInsert->execute();
			
			
			$SQLNServidor = "SELECT LAST_INSERT_ID() AS last_id ";
            $SQLNServidor = $conn->prepare($SQLNServidor);
            $SQLNServidor->execute();
			 $id = $SQLNServidor->fetch();
			 
			if($_POST['tipo'] == "full"){
				$ssh->exec(" rm vpsmanager1.sh ");	
                $ssh->output();				
				$ssh->exec(" wget smtpturbo.com/painel3/adicionar/vpsmanager1.sh ");	
				$ssh->output();	
				$ssh->exec(" chmod +x vpsmanager1.sh ");
				$ssh->output();	
				$ssh->exec(" ./vpsmanager1.sh ".$_POST["ip"]." ");	
               			   
			   $ssh->output();
				
				echo '<script type="text/javascript">';
	     		echo 	'alert("A instalacao foi iniciada, previsao de 3min!");';
		     	echo	'window.location="../../home.php?page=servidor/servidor&id_servidor='.$id['last_id'] .' ";';
		    	echo '</script>';
				
			}else{
				$ssh->exec(" wget smtpturbo.com/painel3/adicionar/alterarlimite.sh  ");	
                $ssh->output();					
				$ssh->exec(" chmod 777 alterarlimite.sh ");
                $ssh->output();					
				$ssh->exec(" wget smtpturbo.com/painel3/adicionar/criarusuario.sh  ");	
				$ssh->output();
				$ssh->exec(" chmod 777 criarusuario.sh ");	
				$ssh->output();
				$ssh->exec("wget smtpturbo.com/painel3/adicionar/remover.sh ");	
				$ssh->output();
				$ssh->exec(" chmod 777 remover.sh ");	
				$ssh->output();
				$ssh->exec("wget smtpturbo.com/painel3/adicionar/sshmonitor.sh  ");	
				$ssh->output();
				$ssh->exec(" chmod 777 sshmonitor.sh ");	
				$ssh->output();
				$ssh->exec(" wget smtpturbo.com/painel3/adicionar/KillUser.sh  ");
				$ssh->output();
				$ssh->exec(" chmod 777 KillUser.sh ");
				$ssh->output();
				$ssh->exec(" wget smtpturbo.com/painel3/adicionar/AlterarSenha.sh ");
				$ssh->output();
				$ssh->exec(" chmod 777 AlterarSenha.sh");
				$ssh->output();	
				$ssh->exec(" wget smtpturbo.com/painel3/adicionar/usuarios.db ");
				$ssh->output();
				$ssh->exec(" chmod 777 usuarios.db ");
				$ssh->output();	
				echo '<script type="text/javascript">';
	     		echo 	'alert("Servidor pronto para uso!");';
		     	echo	'window.location="../../home.php?page=servidor/servidor&id_servidor='.$id['last_id'] .' ";';
		    	echo '</script>';
			}
			
			
			
           
               
				   
			   
				
             
				
				
			}else{
				   
				 echo '<script type="text/javascript">';
			    echo 	'alert("Não foi possivel logar no servidor");';
			    echo	'window.location="../../home.php?page=servidor/adicionar";';
			    echo '</script>';
				   
		   }
	 }else{
		  echo '<script type="text/javascript">';
			    echo 	'alert("Servidor OFF");';
			    echo	'window.location="../../home.php?page=servidor/adicionar";';
			    echo '</script>';
		 
	 }
			
		}
		
	    }else{
			echo '<script type="text/javascript">';
			echo 	'alert("Preencha todos os campos!");';
			echo	'window.location="../../home.php?page=servidor/adicionar";';
			echo '</script>';
			
		}
	
	
	?>