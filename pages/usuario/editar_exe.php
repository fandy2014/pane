<?php
include "../system/mysqli.php";
include "../system/config.php";

// A sessão precisa ser iniciada em cada página diferente
	if (!isset($_SESSION)) session_start();
	
	// Verifica se não há a variável da sessão que identifica o usuário
	if (!isset($_SESSION['id'])) {
		// Destrói a sessão por segurança
		
		session_destroy();
		// Redireciona o visitante de volta pro login
		header("Location: ../../login.php"); exit;
	}else{ 
	    if( (isset($_POST["nome"]))
                                        and (isset($_POST["email"]))
                                        and (isset($_POST["id_usuario"]))
										and (isset($_POST["login"]))
                                        )
		{
			
			$res_user = $mysqli->query("select * from usuario where login = '".$_POST['login']."' and id_mestre='".$_SESSION['id']."' ") or die($mysqli->error);
		    if($res_user->num_rows>0){
				
				$conta_ssh = $res_user->fetch_assoc();
				$update = $mysqli->query("update usuario set    
							                                    nome='".$_POST['nome']."',
																email='".$_POST['email']."',
                                                               	celular='".$_POST['celular']."'												
																WHERE login = '".$_POST['login']."' ") or die($mysqli->error);
	                         echo '<script type="text/javascript">';
			                 echo 	'alert("Alterado!");';
			                 echo	'window.location="../../home.php?page=usuario/perfil&id_usuario='.$_POST['id_usuario'].'";';
			                 echo '</script>';
						
				
			}else{
				    echo '<script type="text/javascript">';
			        echo 	'alert("Conta  Nao encontrada!");';
			        echo	'window.location="../../home.php?page=usuario/perfil&id_usuario='.$_POST['id_usuario'].'";';
			        echo '</script>';
			}
			
			
		}else{
			   
		        echo '<script type="text/javascript">';
			    echo 	'alert("Preencha!");';
			    echo	'window.location="../../home.php?page=usuario/perfil&id_usuario='.$_POST['id_usuario'].'";';
			    echo '</script>';
		}
	
	}
	

?>