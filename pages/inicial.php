
 <!-- Main content -->
    <section class="content">

      <div class="row">
	   <?php if(($usuario['tipo']=="revenda") and ($acesso_servidor > 0) ){?>
            
			
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-server"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Servidores </span>
              <span class="info-box-number"><?php echo $acesso_servidor; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
	
		<?php }?>
		
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa  fa-send-o"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Acessos SSH</span>
              <span class="info-box-number"><?php echo $total_acesso_ssh; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		   <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-aqua"><i class="fa fa-globe"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Contas SSH</span>
              <span class="info-box-number"><?php echo $quantidade_ssh; ?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		<div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-red"><i class="fa fa-globe"></i></span>

            <div class="info-box-content">
              <span class="info-box-text">Contas SSH Susp.</span>
              <span class="info-box-number"><?php echo $all_ssh_susp_qtd;?></span>
            </div>
            <!-- /.info-box-content -->
          </div>
		  </div>
        <!-- /.col -->
		<?php if($usuario['tipo']=="revenda"){?>
        <div class="col-md-3 col-sm-6 col-xs-12">
          <div class="info-box">
            <span class="info-box-icon bg-green"><i class="fa fa-users"></i></span>
           
            <div class="info-box-content">
              <span class="info-box-text">Usuarios VPN</span>
              <span class="info-box-number"><?php echo $quantidade_sub; ?></span>
            </div>
			
            <!-- /.info-box-content -->
          </div>
          <!-- /.info-box -->
        </div>
		
		
		
		<?php }?>
      
      </div>
      <!-- /.row -->

     



    
    

    </section>
    <!-- /.content -->
  </div>