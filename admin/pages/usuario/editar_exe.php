<?php

require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");

protegePagina("admin");

	    if((isset($_POST["nome"])) and (isset($_POST["login"]))
                                and (isset($_POST["email"]))
							
                                and (isset($_POST["celular"]))
                                        
									){
										
		
			$SQLUsuario = "select * from usuario where login = '".$_POST['login']."' ";
            $SQLUsuario = $conn->prepare($SQLUsuario);
            $SQLUsuario->execute();
       
		    if(($SQLUsuario->rowCount())>0){
				
				$conta_ssh = $SQLUsuario->fetch();
				
				if(isset($_POST["validade"])){
					$validade =$_POST["validade"];
				}
				
																
				    $SQLUPUser = "update usuario set    login='".$_POST['login']."',
							                                    nome='".$_POST['nome']."',
																email='".$_POST['email']."',
																validade='$validade',
                                                                celular='".$_POST['celular']."'
                                                               																
																WHERE login = '".$_POST['login']."' ";
                    $SQLUPUser = $conn->prepare($SQLUPUser);
                    $SQLUPUser->execute();									
	                         echo '<script type="text/javascript">';
			                 echo 	'alert("Alterado!");';
			                 echo	'window.location="../../home.php?page=usuario/perfil&id_usuario='.$conta_ssh['id_usuario'] .' ";';
			                 echo '</script>';
						
				
			}else{
				    echo '<script type="text/javascript">';
			        echo 	'alert("Conta  Nao encontrada!");';
			        echo	'window.location="../../home.php?page=usuario/listar";';
			        echo '</script>';
			}
			
			
		}else{
			   
		        echo '<script type="text/javascript">';
			    echo 	'alert("Preencha!");';
			    echo	'window.location="../../home.php?page=usuario/listar";';
			    echo '</script>';
		}
	
	
	

?>