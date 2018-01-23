<?php
require_once("../../../pages/system/seguranca.php");
require_once("../../../pages/system/config.php");
	protegePagina("admin");
		if((isset($_POST["nome"])) and (isset($_POST["email"]))){
			
		    $SQLUser = "select * from admin where id_administrador = '".$_SESSION['usuarioID']."'   ";
            $SQLUser = $conn->prepare($SQLUser);
            $SQLUser->execute();
			if(($SQLUser->rowCount()) > 0){

				
				   	        $SQLUPUser = "update admin set nome='".$_POST['nome']."', email='".$_POST['email']."' WHERE id_administrador = '".$_SESSION['usuarioID']."' ";
                            $SQLUPUser = $conn->prepare($SQLUPUser);
                            $SQLUPUser->execute();
							 echo '<script type="text/javascript">';
			                 echo 	'alert("Alterado com sucesso!");';
			                 echo	'window.location="../../home.php?page=admin/dados";';
			                 echo '</script>';
			}else{
			    echo '<script type="text/javascript">';
			    echo 	'alert("Nao permitido!");';
			    echo	'window.location="../../home.php?page=admin/dados";';
			    echo '</script>';
			}
			
		}else{
			    echo '<script type="text/javascript">';
			    echo 	'alert("Preencha!");';
			    echo	'window.location="../../home.php?page=admin/dados";';
			    echo '</script>';
		}
	