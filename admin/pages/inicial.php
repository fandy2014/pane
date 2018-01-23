
		
 <!-- Main content -->
    <section class="content">

      <div class="row">
	      <div class="col-md-3 col-sm-6 col-xs-12">
		  <a href="home.php?page=ssh/online">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-rocket"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Online </span>
              <span class="info-box-number"><?php echo $total_acesso_ssh_online; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          </a>
        </div>
		
	  
	     <div class="col-md-3 col-sm-6 col-xs-12">
		  <a href="home.php?page=servidor/listar">
          <div class="info-box">
            <span class="info-box-icon bg-blue"><i class="fa fa-server"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Servidores </span>
              <span class="info-box-number"><?php echo $servidor_qtd; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
           </a>
        </div>
		
        
		
		  <div class="col-md-3 col-sm-6 col-xs-12">
          <a href="home.php?page=ssh/contas">
		 <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-send-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Acessos SSH</span>
              <span class="info-box-number"><?php echo $total_acesso_ssh;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          </a>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
          <a href="home.php?page=ssh/contas">
		  <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-globe"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Contas SSH</span>
              <span class="info-box-number"><?php echo $contas_ssh;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
         </a>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
         <a href="home.php?page=ssh/contas">
		 <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-globe"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Contas SSH Susp.</span>
              <span class="info-box-number"><?php echo $ssh_susp_qtd;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          </a>
        </div>
		
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
         <a href="home.php?page=usuario/revenda">
		 <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Revendedores</span>
              <span class="info-box-number"><?php echo $all_usuarios_revenda_qtd;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          </a>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
		<a href="home.php?page=usuario/revenda">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-users"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Revendedores Susp.</span>
              <span class="info-box-number"><?php echo $revenda_qtd_susp;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
            </a>
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
         <a href="home.php?page=usuario/usuario_ssh">
		 <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Usu&aacute;rios SSH</span>
              <span class="info-box-number"><?php echo $all_usuarios_vpn_qtd;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
            </a>
        </div>
		
			<div class="col-md-3 col-sm-6 col-xs-12">
			<a href="home.php?page=usuario/usuario_ssh">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-user"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Usu&aacute;rios SSH Susp.</span>
              <span class="info-box-number"><?php echo $all_usuarios_vpn_qtd_susp;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
         </a>
        </div>
      
      </div>
      <!-- /.row -->

       <!-- /.row -->

     
      <!-- /.row -->



    
    

    </section>
    <!-- /.content -->
  </div>