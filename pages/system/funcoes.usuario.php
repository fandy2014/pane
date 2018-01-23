<?php 
require_once('seguranca.php');
require_once('config.php');
require_once('funcoes.php');
require_once('classe.ssh.php'); 
$diretorio = "../../index.php";
$date = date("Y-m-d H:i:s");

function geraToken(){
				

					$salt = "123456ABCDER";
					srand((double)microtime()*1000000); 

					$i = 0;
                    $pass = 0;
					while($i <= 7){

						$num = rand() % 10;
						$tmp = substr($salt, $num, 1);
						$pass = $pass . $tmp;
						$i++;

					}
					
					
					

					return $pass;

				}
$token = geraToken();


if(isset($_GET["op"],$_GET["owner"])){
	$operacao = $_GET["op"];
	$owner = $_GET["owner"];
	
	if($owner != $accessKEY){
					protegePagina("user");
					
	    }else if($owner == $accessKEY){
					protegePagina("admin");
	}
	
	
	if($operacao == "new" ){
		if((isset($_GET["diretorio"])) &&
			(isset($_GET["nome"])) &&
			(isset($_GET["login"])) &&
			(isset($_GET["senha"])) &&
			(isset($_GET["celular"]))
			){
				
				$diretorio = $_GET['diretorio'];
				$nome = $_GET['nome'];
				$login = $_GET['login'];
				$celular = $_GET['celular'];
	            $senha = $_GET['senha'];
				
				
				if($owner==$accessKEY){
					$owner = 0;
				}
				
				$SQLUsuario = "select * from usuario WHERE login = '".$_POST['login']."' ";
                $SQLUsuario = $conn->prepare($SQLUsuario);
                $SQLUsuario->execute();
	   
			   if(($SQLUsuario->rowCount()) > 0){
				echo '<script type="text/javascript">';
			    echo 	'alert("O usuario '.$_POST['login'].' ja existe!");';
			    echo	'window.location="'.$diretorio.'";';
			    echo '</script>';
			    }
			
				
				$SQLNew = "INSERT INTO usuario (ativo, id_mestre, nome, login,   celular, senha, data_cadastro, token_user)
                                                VALUES ('1', '".$owner."', '".$nome."', '".$login."',  '".$celular."', '".$senha."', '".$date."' , '".$token."') ";
                                                    	
                $SQLNew = $conn->prepare($SQLNew);
                $SQLNew->execute();
				
				$SQLResID = "SELECT LAST_INSERT_ID() AS last_id";                     	
                $SQLResID = $conn->prepare($SQLResID);
                $SQLResID->execute();
                 $id = $SQLResID->fetch();
				 
				 
				$mensagem = "Seja Bem vindo! @SuperSSH Dados de acesso: IP->".$endereco_web." Login-> ".$login." Senha->".$senha;
				$SQLSMS = "insert into sms (id_remetente, id_destinatario, assunto, mensagem) 
				                    VALUES ('".$owner."', '".$id['last_id']."', 'Seja Bem Vindo', '".$mensagem."')  ";
                $SQLSMS = $conn->prepare($SQLSMS);
                $SQLSMS->execute();
				
				echo '<script type="text/javascript">';
		        echo 	'alert("Conta adicionada!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
				
				
			}else{
				echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
			}
		
		
		
	}else if($operacao == "dados" ){
		if((isset($_GET["id_usuario"])) &&
			(isset($_GET["diretorio"])) &&
			(isset($_GET["nome"])) &&
			(isset($_GET["email"])) &&
			(isset($_GET["celular"]))
			){
				
				$id_usuario = $_GET["id_usuario"];
				$diretorio = $_GET['diretorio'];
				$nome = $_GET['nome'];
				$email = $_GET['email'];
				$celular = $_GET['celular'];
				
				
				$SQLUser = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
                $usuario = $SQLUser->fetch();
				
                if($owner != $accessKEY){		 
				if(!($id_usuario == $owner)){
					
					    
                         $SQLSub = "select * from usuario WHERE  id_mestre ='".$usuario['id_mestre']."' ";
                         $SQLSub = $conn->prepare($SQLSub);
                         $SQLSub->execute();
                         $usuario_owner = $SQLSub->fetch();
						 
						 if($usuario_owner['id_mestre'] != $owner){
						echo '<script type="text/javascript">';
		                echo 	'alert("Voce nao tem permissao!!");';
		            	echo	'window.location="'.$diretorio.'";';
		             	echo '</script>';
		            	exit;
						 }
				}
				}else if($owner==$accessKEY){
					$owner = 0;
				}
				
				
				
				
				$SQLUpdate = "UPDATE usuario SET nome='".$nome."', email='".$email."', celular='".$celular."' WHERE id_usuario='".$usuario['id_usuario']."'  ";
                $SQLUpdate = $conn->prepare($SQLUpdate);
                $SQLUpdate->execute();
				
				
				echo '<script type="text/javascript">';
		        echo 	'alert("Dados alterado!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
				
				
			}else{
				echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
			}
		
		
		
	}else if($operacao == "senha"){
		
			if((isset($_GET["id_usuario"])) &&
			   (isset($_GET["diretorio"]))
			  ){
				$id_usuario = $_GET["id_usuario"];
				$diretorio = $_GET['diretorio'];
				
				$SQLUser = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
                $usuario = $SQLUser->fetch();
				
                if($owner != $accessKEY){
				
					 
				
						 
				if(!($id_usuario == $owner)){
					
					    
                         $SQLSub = "select * from usuario WHERE  id_mestre ='".$usuario['id_mestre']."' ";
                         $SQLSub = $conn->prepare($SQLSub);
                         $SQLSub->execute();
                         $usuario_owner = $SQLSub->fetch();
						 
						 if($usuario_owner['id_mestre'] != $owner){
						echo '<script type="text/javascript">';
		                echo 	'alert("Voce nao tem permissao!!");';
		            	echo	'window.location="'.$diretorio.'";';
		             	echo '</script>';
		            	exit;
						 }
				}
				}else if($owner==$accessKEY){
					$owner = 0;
			    }
				
				
				$mensagem = "Dados de acesso: IP->".$endereco_web." Login-> ".$usuario['login']." Senha->".$usuario['senha'];
				$SQLSMS = "insert into sms (id_remetente, id_destinatario, assunto, mensagem) 
				                    VALUES ('".$owner."', '".$usuario['id_usuario']."', 'Reenviar Senha', '".$mensagem."')  ";
                $SQLSMS = $conn->prepare($SQLSMS);
                $SQLSMS->execute();
				
				
				echo '<script type="text/javascript">';
		        echo 	'alert("Senha reenviada!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
				
				
			}else{
				echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
			}
		
		
    }else if($operacao == "deletar"){
		if((isset($_GET["id_usuario"])) &&
			(isset($_GET["diretorio"]))
			){
				
				$id_usuario = $_GET["id_usuario"];
				$diretorio = $_GET['diretorio'];	
				$SQLUser = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
                $usuario = $SQLUser->fetch();
				
                if($owner != $accessKEY){		 
				if(!($id_usuario == $owner)){
					
					    
                         $SQLSub = "select * from usuario WHERE  id_mestre ='".$usuario['id_mestre']."' ";
                         $SQLSub = $conn->prepare($SQLSub);
                         $SQLSub->execute();
                         $usuario_owner = $SQLSub->fetch();
						 
						 if($usuario_owner['id_mestre'] != $owner){
						echo '<script type="text/javascript">';
		                echo 	'alert("Voce nao tem permissao!!");';
		            	echo	'window.location="'.$diretorio.'";';
		             	echo '</script>';
		            	exit;
						 }
				}
				}else if($owner==$accessKEY){
					$owner = 0;
				}
				
				$SQLSSH = "update usuario_ssh set status='3', id_usuario='0' WHERE id_usuario = '".$id_usuario."'  ";
                $SQLSSH = $conn->prepare($SQLSSH);
                $SQLSSH->execute();
				
				if($usuario['tipo']=="revenda"){
					
                    $SQLExcluiAcesso = "delete  from acesso_servidor WHERE  id_usuario = '".$id_usuario."'";
                    $SQLExcluiAcesso = $conn->prepare($SQLExcluiAcesso);
                    $SQLExcluiAcesso->execute();
					
				   $SQLUsuarioSub= "SELECT * FROM usuario where id_mestre =  '".$id_usuario."' ";
                   $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
                   $SQLUsuarioSub->execute();
				   if (($SQLUsuarioSub->rowCount()) > 0) {
				         while($row = $SQLUsuarioSub->fetch()){
							$SQLSSH = "update usuario_ssh set status='3', apagar='3', id_usuario='0' WHERE id_usuario = '".$row['id_usuario']."'  ";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();
					    }
				    }
					
					$SQLUser = "update usuario set id_mestre='0' WHERE id_mestre = '".$id_usuario."'  ";
                    $SQLUser = $conn->prepare($SQLUser);
                    $SQLUser->execute();
				   
				   
				}
				
				
				
				$SQLExcluiRev = "delete  from usuario WHERE  id_usuario = '".$id_usuario."'";
                $SQLExcluiRev = $conn->prepare($SQLExcluiRev);
                $SQLExcluiRev->execute();
				
				
				echo '<script type="text/javascript">';
		        echo 	'alert("Usuario  deletado!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
				
				
			}else{
				echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
			}
		
    }else if($operacao == "suspender"){
					if((isset($_GET["id_usuario"])) &&
			          (isset($_GET["diretorio"]))
		           	){
				
				$id_usuario = $_GET["id_usuario"];
				$diretorio = $_GET['diretorio'];
				
				$SQLUser = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
                $usuario = $SQLUser->fetch();
				
                if($owner != $accessKEY){
				
						 
				
						 
				if(!($id_usuario == $owner)){
					
					    
                         $SQLSub = "select * from usuario WHERE  id_mestre ='".$usuario['id_mestre']."' ";
                         $SQLSub = $conn->prepare($SQLSub);
                         $SQLSub->execute();
                         $usuario_owner = $SQLSub->fetch();
						 
						 if($usuario_owner['id_mestre'] != $owner){
						echo '<script type="text/javascript">';
		                echo 	'alert("Voce nao tem permissao!!");';
		            	echo	'window.location="'.$diretorio.'";';
		             	echo '</script>';
		            	exit;
						 }
				}
				}else if($owner==$accessKEY){
					$owner = 0;
				}
				
				$SQLSSH = "update usuario_ssh set status='2', apagar='2' WHERE id_usuario = '".$id_usuario."'  ";
                $SQLSSH = $conn->prepare($SQLSSH);
                $SQLSSH->execute();
				
				if($usuario['tipo']=="revenda"){  
				   $SQLUsuarioSub= "SELECT * FROM usuario where id_mestre =  '".$id_usuario."' ";
                   $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
                   $SQLUsuarioSub->execute();
				   if (($SQLUsuarioSub->rowCount()) > 0) {
				         while($row = $SQLUsuarioSub->fetch()){
							$SQLSSH = "update usuario_ssh set status='2', apagar='2' WHERE id_usuario = '".$row['id_usuario']."'  ";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();
							$SQLUser = "update usuario set ativo='2', apagar='2' WHERE id_usuario = '".$row['id_usuario']."'  ";
                             $SQLUser = $conn->prepare($SQLUser);
                            $SQLUser->execute();
					    }
				    }
				   
				   
				}
				
				$SQLUser = "update usuario set ativo='2', apagar='2' WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
				
				
				echo '<script type="text/javascript">';
		        echo 	'alert("Usuarios  suspenso!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
				
				
			}else{
				echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
			}
		
		
    }else if($operacao == "ususpender"){
					if((isset($_GET["id_usuario"])) &&
			           (isset($_GET["diretorio"]))
			           ){
				
				$id_usuario = $_GET["id_usuario"];
				$diretorio = $_GET['diretorio'];
				
				$SQLUser = "select * from usuario WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
                $usuario = $SQLUser->fetch();
				
                if($owner != $accessKEY){
				
						 
				
						 
				if(!($id_usuario == $owner)){
					
					    
                         $SQLSub = "select * from usuario WHERE  id_mestre ='".$usuario['id_mestre']."' ";
                         $SQLSub = $conn->prepare($SQLSub);
                         $SQLSub->execute();
                         $usuario_owner = $SQLSub->fetch();
						 
						 if($usuario_owner['id_mestre'] != $owner){
						echo '<script type="text/javascript">';
		                echo 	'alert("Voce nao tem permissao!!");';
		            	echo	'window.location="'.$diretorio.'";';
		             	echo '</script>';
		            	exit;
						 }
				}
				}else if($owner==$accessKEY){
					$owner = 0;
				}
				
				$SQLSSH = "update usuario_ssh set status='1', apagar='1' WHERE id_usuario = '".$id_usuario."'  ";
                $SQLSSH = $conn->prepare($SQLSSH);
                $SQLSSH->execute();
				
				if($usuario['tipo']=="revenda"){  
				   $SQLUsuarioSub= "SELECT * FROM usuario where id_mestre =  '".$id_usuario."' ";
                   $SQLUsuarioSub = $conn->prepare($SQLUsuarioSub);
                   $SQLUsuarioSub->execute();
				   if (($SQLUsuarioSub->rowCount()) > 0) {
				         while($row = $SQLUsuarioSub->fetch()){
							$SQLSSH = "update usuario_ssh set status='1', apagar='1' WHERE id_usuario = '".$row['id_usuario']."'  ";
                            $SQLSSH = $conn->prepare($SQLSSH);
                            $SQLSSH->execute();
							$SQLUser = "update usuario set ativo='1', apagar='1' WHERE id_usuario = '".$row['id_usuario']."'  ";
                            $SQLUser = $conn->prepare($SQLUser);
                            $SQLUser->execute();
					    }
				    }
					
				   
				   
				}
				
				$SQLUser = "update usuario set ativo='1', apagar='1' WHERE id_usuario = '".$id_usuario."'  ";
                $SQLUser = $conn->prepare($SQLUser);
                $SQLUser->execute();
				
				
				echo '<script type="text/javascript">';
		        echo 	'alert("Usuarios  liberados!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
				
				
			}else{
				echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
			}
		
		
    }else{
		
		
		
	}
	
}else{
	
	echo '<script type="text/javascript">';
		        echo 	'alert("Preencha todos os campos!");';
		        echo	'window.location="'.$diretorio.'";';
		        echo '</script>';
				exit;
}

?>