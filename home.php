<?php


require_once("pages/system/seguranca.php");
require_once("pages/system/config.php");
require_once("pages/system/classe.ssh.php");

protegePagina("user");

		
		
		
		
		
		$quantidade_ssh = 0;
		$quantidade_ssh_user =0;
		$quantidade_ssh_sub =0;
		$quantidade_sub = 0;
		$all_ssh_susp_qtd = 0;
		
		$SQLUsuario = "SELECT * FROM usuario WHERE id_usuario = '".$_SESSION['usuarioID']."'";
        $SQLUsuario = $conn->prepare($SQLUsuario);
        $SQLUsuario->execute();
        $usuario = $SQLUsuario->fetch();
		
		


	   
		$SQLUsuario_ssh = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
        $SQLUsuario_ssh = $conn->prepare($SQLUsuario_ssh);
        $SQLUsuario_ssh->execute();
        $quantidade_ssh += $SQLUsuario_ssh->rowCount();
		
		$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE id_usuario = '".$_SESSION['usuarioID']."' and  status='2' and apagar='0' ";
        $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
        $SQLUsuario_sshSUSP->execute();
        $all_ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();
		
		$total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$_SESSION['usuarioID']."' ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
		
		
		$SQLAcesso= "select * from acesso_servidor WHERE id_usuario = '".$_SESSION['usuarioID']."' ";
        $SQLAcesso = $conn->prepare($SQLAcesso);
        $SQLAcesso->execute();
        $acesso_servidor = $SQLAcesso->rowCount();
		
		
		
		
		if($usuario['tipo']=="revenda"){
			$SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' ";
            $SQLSub = $conn->prepare($SQLSub);
            $SQLSub->execute();
         
			
			if (($SQLSub->rowCount()) > 0) {
    
                while($row = $SQLSub->fetch()) {
					
					$SQLSubSSH= "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."'  ";
                    $SQLSubSSH = $conn->prepare($SQLSubSSH);
                    $SQLSubSSH->execute();
                    $quantidade_ssh += $SQLSubSSH->rowCount();
					
					$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and status='2' and apagar='0' ";
                    $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
                    $SQLUsuario_sshSUSP->execute();
                    $all_ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();
					
					$SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_usuario='".$row['id_usuario']."' ";
                    $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
                    $SQLAcessoSSH->execute();
	             	$SQLAcessoSSH = $SQLAcessoSSH->fetch();
                    $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
			
					
			 
		        }
				
				
		    }
		 $quantidade_sub += $SQLSub->rowCount();
		
			
			//Calcula os dias restante
		$data_atual = date("Y-m-d ");
		$data_validade = $usuario['validade']; 
		
		$data1 = new DateTime( $data_validade );
        $data2 = new DateTime( $data_atual );

        $diferenca = $data1->diff( $data2 );
        $ano = $diferenca->y * 364 ;
		$mes = $diferenca->m * 30;
		$dia = $diferenca->d;
        $dias_acesso = $ano + $mes + $dia;
			
		$quantidade_ssh += 	 $quantidade_ssh_sub+$quantidade_ssh_user;
		
		if($usuario['ativo']==2){
				echo '<script type="text/javascript">';
			                 echo 	'alert("Sua conta  esta suspensa!");';
			                 echo	'window.location="pages/suspenso.php";';
			                 echo '</script>';
							 exit;
				
			}
			
		}
		
		
		
		
		
	
	
	?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>WebService SSH | Painel </title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <!-- DataTables -->
  <link rel="stylesheet" href="plugins/datatables/dataTables.bootstrap.css">
  
  <link rel="stylesheet" href="plugins/iCheck/all.css">

  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->
</head>
<!-- ADD THE CLASS layout-boxed TO GET A BOXED LAYOUT -->
<body class="hold-transition skin-blue layout-boxed sidebar-mini">
<!-- Site wrapper -->
<div class="wrapper">

  <header class="main-header">
    <!-- Logo -->
    <a href="home.php" class="logo">
      <!-- mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>SSH</b></span>
				<span class="logo-lg"><b>WebService</b>SSH</span>
    </a>
    <!-- Header Navbar: style can be found in header.less -->
    <nav class="navbar navbar-static-top">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Navegação</span>
      </a>

      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          
          
         
          <!-- User Account: style can be found in dropdown.less -->
          
          <!-- Control Sidebar Toggle Button -->
          
        </ul>
      </div>
	  <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
          <li>
            <a href="sair.php" ><i class="fa fa-power-off"></i> </a>
          </li>
        </ul>
      </div>
    </nav>
  </header>

  <!-- =============================================== -->

  <!-- Left side column. contains the sidebar -->
  <aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
      <!-- Sidebar user panel -->
      <div class="user-panel">
        <div class="pull-left image">
          <img src="dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $usuario['nome']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
	  <?php if($usuario['tipo']=="revenda") {?>
        <li class="header"><center><strong><?php echo $dias_acesso;?> dias de acesso </strong></center></li>
	  <?php }else{ ?>
	 <li class="header"> <center>Sem limite de acesso ao sistema</center> </li>
	  <?php } ?>
		   <li>
          <a href="home.php">
            <i class="fa fa-dashboard"></i> <span>Home</span>
            <span class="pull-right-container">
              <small class="label pull-right bg-green">Novo</small>
            </span>
          </a>
        </li>
		
    
        <li class="treeview ">
          <a href="#">
            <i class="fa fa-globe"></i>
            <span>Contas SSH</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"> <?php echo $quantidade_ssh; ?></span>  
            </span>
          </a>
          <ul class="treeview-menu">
		   <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
            <li><a href="?page=ssh/adicionar"><i class="fa fa-circle-o"></i> Nova conta SSH</a></li>
			<?php }?>
            <li ><a href="?page=ssh/contas"><i class="fa fa-circle-o"></i>Listar contas SSH</a></li>
			<li ><a href="?page=ssh/online"><i class="fa fa-circle-o"></i>Contas SSH Online</a></li>
			
			
          </ul>
        </li>
      
 
       <?php if($usuario['tipo']=="revenda") {?>
	    <li class="treeview ">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Usuários</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $quantidade_sub; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
		  
            <li><a href="?page=usuario/adicionar"><i class="fa fa-circle-o"></i> Novo usuário</a></li>
			
            <li><a href="?page=usuario/listar"><i class="fa fa-circle-o"></i>Listar usuários</a></li>
           
          </ul>
        </li>
		 <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
            
			
		
		 <li class="treeview ">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>Servidores</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $acesso_servidor; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            
            <li><a href="?page=servidor/listar"><i class="fa fa-circle-o"></i>Listar servidores</a></li>
           
          </ul>
        </li>
		<?php }?>
		 
	   <?php }?>
	     
		
		<li class="treeview ">
          <a href="#">
            <i class="fa fa-gear"></i>
            <span>Configurações</span>
            <span class="pull-right-container">
              
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=admin/dados"><i class="fa fa-circle-o"></i>Minhas Informações</a></li>
			
          </ul>
        </li>
		
      </ul>
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- =============================================== -->

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    

    <!-- Main content -->
     <?php 
				
				if($usuario['atualiza_dados']==1){
					if(isset($_GET["page"])){
					$page = $_GET["page"];
					if($page and file_exists("pages/".$page.".php")) {
					include("pages/".$page.".php");
					} else {
					include("./pages/inicial.php");
				  }
				}else{
					include("./pages/inicial.php");
				}
			}else{
				include("./pages/admin/dados.php");
			}
				
				
			?>
			
			
			
    <!-- /.content -->
  </div>

  


</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="dist/js/app.min.js"></script>

<!-- DataTables -->
<script src="plugins/datatables/jquery.dataTables.min.js"></script>
<script src="plugins/datatables/dataTables.bootstrap.min.js"></script>

<!-- page script -->
<script>
  $(function () {
    $("#example1").DataTable();
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false
    });
  });
</script>

</body>
</html>
