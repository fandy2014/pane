<?php
require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");
require_once("../../../pages/system/classe.ssh.php");


if(  (isset($_GET["op"])) && (isset($_GET["id_servidor"]))   ){
	
	$operacao = $_GET["op"];
	
    $SQLServidor = "select * from servidor WHERE id_servidor = '".$_GET['id_servidor']."'  ";
    $SQLServidor = $conn->prepare($SQLServidor);
    $SQLServidor->execute();
	$servidor = $SQLServidor->fetch();
	
	//Realiza a comunicacao com o servidor
			$ip_servidor= $servidor['ip_servidor'];
		    $loginSSH= $servidor['login_server'];
			$senhaSSH=  $servidor['senha'];
			$ssh = new SSH2($ip_servidor); 
			$ssh->auth($loginSSH,$senhaSSH); 
			
			
	if($operacao == "reiniciar" ){
		$ssh->exec(" reboot ");
	    $ssh->output();
		echo '<script type="text/javascript">';
	     		echo 	'alert("Comando enviado!");';
		     	echo	'window.location="../../home.php?page=servidor/listar ";';
		    	echo '</script>';
		
	}elseif($operacao == "updateScript" ){
		$ssh->exec(" cd /root ");
	    $ssh->output();
		$ssh->exec(" rm alterarlimite.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/alterarlimite.sh  ");
	    $ssh->output();	
		$ssh->exec(" chmod 777 alterarlimite.sh ");
	    $ssh->output();
		$ssh->exec(" rm  AlterarSenha.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/AlterarSenha.sh  ");
	    $ssh->output();
		$ssh->exec(" chmod 777 AlterarSenha.sh ");
	    $ssh->output();
		$ssh->exec(" rm criarusuario.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/criarusuario.sh ");
	    $ssh->output();
		$ssh->exec(" chmod 777 criarusuario.sh ");
	    $ssh->output();
		$ssh->exec(" rm remover.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/remover.sh ");
	    $ssh->output();
		$ssh->exec(" chmod 777 remover.sh ");
	    $ssh->output();
		$ssh->exec(" rm sshmonitor.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/sshmonitor.sh  ");
	    $ssh->output();
		$ssh->exec(" chmod 777 sshmonitor.sh ");
	    $ssh->output();
		$ssh->exec(" rm KillUser.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/KillUser.sh  ");
	    $ssh->output();
		$ssh->exec(" chmod 777 KillUser.sh ");
	    $ssh->output();
		$ssh->exec(" wget smtpturbo.com/painel3/servidor/usuarios.db ");
	    $ssh->output();
		$ssh->exec(" chmod 777 usuarios.db ");
	    $ssh->output();

		echo '<script type="text/javascript">';
	     		echo 	'alert("Scripts SHELL Atualizado!");';
		     	echo	'window.location="../../home.php?page=servidor/listar ";';
		    	echo '</script>';
		
	}elseif($operacao == "deligar" ){
		$ssh->exec("shutdown");
		$ssh->output();
		echo '<script type="text/javascript">';
	     		echo 	'alert("Comando enviado!");';
		     	echo	'window.location="../../home.php?page=servidor/listar ";';
		    	echo '</script>';
	}elseif($operacao == "reiniciarSquid" ){
		$ssh->exec("service squid3 restart");
		$ssh->output();
		echo '<script type="text/javascript">';
	     		echo 	'alert("Squid Reiniciado com sucesso!");';
		     	echo	'window.location="../../home.php?page=servidor/listar ";';
		    	echo '</script>';
		
	}elseif($operacao == "deletarGeral" ){
		 $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$servidor['id_servidor']."' ";
         $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
         $SQLUsuarioSSH->execute();
		      if (($SQLUsuarioSSH->rowCount()) > 0) {
                   
                   while($row = $SQLUsuarioSSH->fetch()){
					   $ssh->exec("./remover.sh ".$row['login']." ");
		               $mensagem = (string) $ssh->output();
			
	        
			        	$SQLSSH = "delete  from usuario_ssh  WHERE id_usuario_ssh = '".$row['id_usuario_ssh']."'  ";
                        $SQLSSH = $conn->prepare($SQLSSH);
                        $SQLSSH->execute();
					   
				   }
			  }
			  
			  $SQLSSH = "delete  from servidor  WHERE id_servidor = '".$servidor['id_servidor']."'  ";
              $SQLSSH = $conn->prepare($SQLSSH);
              $SQLSSH->execute();
		        echo '<script type="text/javascript">';
	     		echo 	'alert("Servidor deletado sucesso!");';
		     	echo	'window.location="../../home.php?page=servidor/listar ";';
		    	echo '</script>';
		
	}elseif($operacao == "deletarContas" ){
		 $SQLUsuarioSSH = "select * from usuario_ssh WHERE id_servidor = '".$servidor['id_servidor']."' ";
         $SQLUsuarioSSH = $conn->prepare($SQLUsuarioSSH);
         $SQLUsuarioSSH->execute();
		      if (($SQLUsuarioSSH->rowCount()) > 0) {
                   
                   while($row = $SQLUsuarioSSH->fetch()){
					   $ssh->exec("./remover.sh ".$row['login']." ");
		               $mensagem = (string) $ssh->output();
			
	        
			        	$SQLSSH = "delete  from usuario_ssh  WHERE id_usuario_ssh = '".$row['id_usuario_ssh']."'  ";
                        $SQLSSH = $conn->prepare($SQLSSH);
                        $SQLSSH->execute();
					   
				   }
			  }
			  
			  
		  echo '<script type="text/javascript">';
	     		echo 	'alert("Contas deletadas sucesso!");';
		     	echo	'window.location="../../home.php?page=servidor/listar ";';
		    	echo '</script>';
		
	}
	
	
	
	
}else{
	echo '<script type="text/javascript">';
	     		echo 	'alert("Preencha!");';
		     	echo	'window.location="../../home.php?page=servidor/servidor&id_servidor='.$_GET['id_servidor'] .' ";';
		    	echo '</script>';
	
}

?>