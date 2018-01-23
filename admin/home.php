<?php
require_once("../pages/system/funcoes.php");
require_once("../pages/system/seguranca.php");
require_once("../pages/system/config.php");
require_once("../pages/system/classe.ssh.php");

protegePagina("admin");
if( $_SESSION['tipo'] == "user"){
	expulsaVisitante();			
}

  
		$data_atual = date("Y-m-d");
		
		$SQLAdministrador = "SELECT * FROM admin WHERE id_administrador = '".$_SESSION['usuarioID']."'";
        $SQLAdministrador = $conn->prepare($SQLAdministrador);
        $SQLAdministrador->execute();
        $administrador = $SQLAdministrador->fetch();
		
		 //Carrega qtd contas ssh do sistema 
		
		$SQLUsuario_sshSUSP = "select * from usuario_ssh WHERE status='2' ";
        $SQLUsuario_sshSUSP = $conn->prepare($SQLUsuario_sshSUSP);
        $SQLUsuario_sshSUSP->execute();
        $ssh_susp_qtd += $SQLUsuario_sshSUSP->rowCount();
		
		$SQLContasSSH = "SELECT * FROM usuario_ssh ";
        $SQLContasSSH = $conn->prepare($SQLContasSSH);
        $SQLContasSSH->execute();
        $contas_ssh = $SQLContasSSH->rowCount();
		
		
		$total_acesso_ssh = 0;
	    $SQLAcessoSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh  ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh += $SQLAcessoSSH['quantidade'];
		
		$total_acesso_ssh_online = 0;
	    $SQLAcessoSSH = "SELECT sum(online) AS quantidade  FROM usuario_ssh  ";
        $SQLAcessoSSH = $conn->prepare($SQLAcessoSSH);
        $SQLAcessoSSH->execute();
		$SQLAcessoSSH = $SQLAcessoSSH->fetch();
        $total_acesso_ssh_online += $SQLAcessoSSH['quantidade'];
		
		
		//carrega qtd de todos os usuarios do sistema
		$SQLUsuarios = "SELECT * FROM usuario ";
        $SQLUsuarios = $conn->prepare($SQLUsuarios);
        $SQLUsuarios->execute();
        $all_usuarios_qtd = $SQLUsuarios->rowCount();
		
		//carrega qtd de todos os usuarios do sistema SSH
		$SQLVPN = "SELECT * FROM usuario  where tipo='vpn' ";
        $SQLVPN = $conn->prepare($SQLVPN);
        $SQLVPN->execute();
        $all_usuarios_vpn_qtd = $SQLVPN->rowCount();
		
		$SQLVPN = "SELECT * FROM usuario  where tipo='vpn' and ativo='2' ";
        $SQLVPN = $conn->prepare($SQLVPN);
        $SQLVPN->execute();
        $all_usuarios_vpn_qtd_susp = $SQLVPN->rowCount();
		
		//carrega qtd de todos os usuarios do sistema SSH
		$SQLRevenda = "SELECT * FROM usuario  where tipo='revenda' ";
        $SQLRevenda = $conn->prepare($SQLRevenda);
        $SQLRevenda->execute();
        $all_usuarios_revenda_qtd = $SQLRevenda->rowCount();
		//carrega qtd de todos os usuarios do sistema SSH
		$SQLRevenda = "SELECT * FROM usuario  where tipo='revenda' and ativo='2'";
        $SQLRevenda = $conn->prepare($SQLRevenda);
        $SQLRevenda->execute();
        $revenda_qtd_susp = $SQLRevenda->rowCount();
		
		//carrega qtd de servidores
		$SQLServidor = "SELECT * FROM servidor ";
        $SQLServidor = $conn->prepare($SQLServidor);
        $SQLServidor->execute();
        $servidor_qtd = $SQLServidor->rowCount();
		
		
	
	
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
  <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/ionicons/2.0.1/css/ionicons.min.css">
 <!-- DataTables -->
  <link rel="stylesheet" href="../plugins/datatables/dataTables.bootstrap.css">
<!-- iCheck -->
  <link rel="stylesheet" href="plugins/iCheck/square/blue.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../dist/css/skins/_all-skins.min.css">

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
            <a href="sair.php"><i class="fa fa-power-off"></i> </a>
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
          <img src="../dist/img/user2-160x160.jpg" class="img-circle" alt="User Image">
        </div>
        <div class="pull-left info">
          <p><?php echo $administrador['nome']; ?></p>
          <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
        </div>
      </div>

      <!-- sidebar menu: : style can be found in sidebar.less -->
      <ul class="sidebar-menu">
        <li class="header">Navegação Principal</li>
		
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
              <span class="label label-primary pull-right"> <?php echo $contas_ssh; ?></span>  
            </span>
          </a>
          <ul class="treeview-menu">
		   
            <li><a href="?page=ssh/adicionar"><i class="fa fa-circle-o"></i> Nova conta SSH</a></li>
			
            <li ><a href="?page=ssh/contas"><i class="fa fa-circle-o"></i>Listar contas </a></li>
			<li ><a href="?page=ssh/online"><i class="fa fa-circle-o"></i>Contas  Online</a></li>
			<li ><a href="?page=ssh/erro"><i class="fa fa-circle-o"></i>Contas com erro</a></li>
          </ul>
        </li>
      
 
      
	    <li class="treeview ">
          <a href="#">
            <i class="fa fa-users"></i>
            <span>Usuários</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $all_usuarios_qtd; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=usuario/1-etapa"><i class="fa fa-circle-o"></i> Novo usuário</a></li>
			<li><a href="?page=usuario/revenda"><i class="fa fa-circle-o"></i>Revendedores SSH <span class="label label-primary pull-right"><?php echo $all_usuarios_revenda_qtd; ?></span></a></li>
            <li><a href="?page=usuario/usuario_ssh"><i class="fa fa-circle-o"></i>Usuários SSH <span class="label label-primary pull-right"><?php echo $all_usuarios_vpn_qtd; ?></span></a></li>
           
          </ul>
        </li>
		
		 <li class="treeview ">
          <a href="#">
            <i class="fa fa-cloud"></i>
            <span>Servidores</span>
            <span class="pull-right-container">
              <span class="label label-primary pull-right"><?php echo $servidor_qtd; ?></span>
            </span>
          </a>
          <ul class="treeview-menu">
            <li><a href="?page=servidor/adicionar"><i class="fa fa-circle-o"></i> Novo servidor</a></li>
            <li><a href="?page=servidor/listar"><i class="fa fa-circle-o"></i>Listar servidores</a></li>
           
          </ul>
        </li>
      
	      <li>
          <a href="?page=admin/dados">
            <i class="fa fa-gear"></i> <span>Configurações</span>
            
          </a>
        </li>
		 <li>
          <a href="?page=demo/configurar">
            <i class="fa fa-gear"></i> <span>Link Demo</span>
            
          </a>
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
			
				
			?>
			
			
			
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Create the tabs -->
    <ul class="nav nav-tabs nav-justified control-sidebar-tabs">
      <li><a href="#control-sidebar-home-tab" data-toggle="tab"><i class="fa fa-home"></i></a></li>
      <li><a href="#control-sidebar-settings-tab" data-toggle="tab"><i class="fa fa-gears"></i></a></li>
    </ul>
    <!-- Tab panes -->
    <div class="tab-content">
      <!-- Home tab content -->
      <div class="tab-pane" id="control-sidebar-home-tab">
        <h3 class="control-sidebar-heading">Recent Activity</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-birthday-cake bg-red"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Langdon's Birthday</h4>

                <p>Will be 23 on April 24th</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-user bg-yellow"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Frodo Updated His Profile</h4>

                <p>New phone +1(800)555-1234</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-envelope-o bg-light-blue"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Nora Joined Mailing List</h4>

                <p>nora@example.com</p>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <i class="menu-icon fa fa-file-code-o bg-green"></i>

              <div class="menu-info">
                <h4 class="control-sidebar-subheading">Cron Job 254 Executed</h4>

                <p>Execution time 5 seconds</p>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

        <h3 class="control-sidebar-heading">Tasks Progress</h3>
        <ul class="control-sidebar-menu">
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Custom Template Design
                <span class="label label-danger pull-right">70%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-danger" style="width: 70%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Update Resume
                <span class="label label-success pull-right">95%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-success" style="width: 95%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Laravel Integration
                <span class="label label-warning pull-right">50%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-warning" style="width: 50%"></div>
              </div>
            </a>
          </li>
          <li>
            <a href="javascript:void(0)">
              <h4 class="control-sidebar-subheading">
                Back End Framework
                <span class="label label-primary pull-right">68%</span>
              </h4>

              <div class="progress progress-xxs">
                <div class="progress-bar progress-bar-primary" style="width: 68%"></div>
              </div>
            </a>
          </li>
        </ul>
        <!-- /.control-sidebar-menu -->

      </div>
      <!-- /.tab-pane -->
      <!-- Stats tab content -->
      <div class="tab-pane" id="control-sidebar-stats-tab">Stats Tab Content</div>
      <!-- /.tab-pane -->
      <!-- Settings tab content -->
      <div class="tab-pane" id="control-sidebar-settings-tab">
        <form method="post">
          <h3 class="control-sidebar-heading">General Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Report panel usage
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Some information about this general settings option
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Allow mail redirect
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Other sets of options are available
            </p>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Expose author name in posts
              <input type="checkbox" class="pull-right" checked>
            </label>

            <p>
              Allow the user to show his name in blog posts
            </p>
          </div>
          <!-- /.form-group -->

          <h3 class="control-sidebar-heading">Chat Settings</h3>

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Show me as online
              <input type="checkbox" class="pull-right" checked>
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Turn off notifications
              <input type="checkbox" class="pull-right">
            </label>
          </div>
          <!-- /.form-group -->

          <div class="form-group">
            <label class="control-sidebar-subheading">
              Delete chat history
              <a href="javascript:void(0)" class="text-red pull-right"><i class="fa fa-trash-o"></i></a>
            </label>
          </div>
          <!-- /.form-group -->
        </form>
      </div>
      <!-- /.tab-pane -->
    </div>
  </aside>
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
  <div class="control-sidebar-bg"></div>
</div>
<!-- ./wrapper -->

<!-- jQuery 2.2.3 -->
<script src="../plugins/jQuery/jquery-2.2.3.min.js"></script>
<!-- Bootstrap 3.3.6 -->
<script src="../bootstrap/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../plugins/slimScroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../plugins/fastclick/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../dist/js/app.min.js"></script>


<!-- DataTables -->
<script src="../plugins/datatables/jquery.dataTables.min.js"></script>
<script src="../plugins/datatables/dataTables.bootstrap.min.js"></script>

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

<script>
  $(function () {
    $('input').iCheck({
      checkboxClass: 'icheckbox_square-blue',
      radioClass: 'iradio_square-blue',
      increaseArea: '20%' // optional
    });
  });
</script>
</body>
</html>
