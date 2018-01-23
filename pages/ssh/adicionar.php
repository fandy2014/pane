<?php
 
	if (basename($_SERVER["REQUEST_URI"]) === basename(__FILE__))
{
	exit('<h1>ERROR 404</h1>Entre em contato conosco e envie detalhes.');
}

?>
<section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
            <center>  <h3 class="box-title">Adicionar usuário SSH</h3></center>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form role="form" action="pages/system/conta.ssh.php" method="post">
              <div class="box-body">
			   
			   <div class="form-group">
                <label>Selecione um servidor </label>
                <select class="form-control select2" style="width: 100%;"  name="acesso_servidor" id="acesso_servidor">
                  
                  <?php
                    
					
	
	                $SQLAcesso= "select * from acesso_servidor WHERE id_usuario = '".$usuario['id_usuario']."' ";
                    $SQLAcesso = $conn->prepare($SQLAcesso);
                    $SQLAcesso->execute();
                    

if (($SQLAcesso->rowCount()) > 0) {
    // output data of each row
    while($row_srv = $SQLAcesso->fetch()) {
		$contas_ssh_criadas = 0;
		
       $SQLServidor = "select * from servidor WHERE id_servidor = '".$row_srv['id_servidor']."' ";
       $SQLServidor = $conn->prepare($SQLServidor);
       $SQLServidor->execute();
       $servidor = $SQLServidor->fetch();
		
		
		$SQLContasSSH = "SELECT sum(acesso) AS quantidade  FROM usuario_ssh where id_servidor = '".$row_srv['id_servidor']."' and id_usuario='".$_SESSION['usuarioID']."' ";
        $SQLContasSSH = $conn->prepare($SQLContasSSH);
        $SQLContasSSH->execute();
		$SQLContasSSH = $SQLContasSSH->fetch();
        $contas_ssh_criadas += $SQLContasSSH['quantidade'];
		
		    $SQLSub= "select * from usuario WHERE id_mestre = '".$_SESSION['usuarioID']."' ";
            $SQLSub = $conn->prepare($SQLSub);
            $SQLSub->execute();
			
			
			if (($SQLSub->rowCount()) > 0) {
				  while($row = $SQLSub->fetch()) {
					   $SQLSubSSH= "select sum(acesso) AS quantidade  from usuario_ssh WHERE id_usuario = '".$row['id_usuario']."' and id_servidor='".$servidor['id_servidor']."' ";
                       $SQLSubSSH = $conn->prepare($SQLSubSSH);
                       $SQLSubSSH->execute();
					   $SQLSubSSH = $SQLSubSSH->fetch();
					   $contas_ssh_criadas += $SQLSubSSH['quantidade'];
				  }
				
			}
        
		
		
		?>
        
	<option value="<?php echo $row_srv['id_acesso_servidor'];?>" > <?php echo $servidor['nome'];?> - <?php echo $servidor['ip_servidor'];?> -  <?php echo $contas_ssh_criadas;?> de <?php echo $row_srv['qtd'];?>  Conexões </option>
	
   <?php }
}

?>
				  
				  
                </select>
              </div>
			  
                <div class="form-group">
                <label>Usuário gerenciador da Conta SSH</label>
                <select class="form-control select2" style="width: 100%;"  name="usuario" id="usuario">
                  <option selected="selected" value="<?php echo $_SESSION['usuarioID']; ?>">Usuário atual do Sistema</option>
                 
                  <?php

	
	
	   $SQL = "SELECT * FROM usuario where id_mestre = '".$_SESSION['usuarioID']."'";
       $SQL = $conn->prepare($SQL);
       $SQL->execute();
       
		

if (($SQL->rowCount()) > 0) {
    // output data of each row
    while($row = $SQL->fetch()) {?>
        
	<option value="<?php echo $row['id_usuario'];?>" ><?php echo $row['login'];?></option>
	
   <?php }
}

?>
				  
				  
                </select>
              </div>
			  
                <div class="form-group">
                  <label for="exampleInputPassword1">Login SSH</label>
                  <input required="required" min="4" max="32" type="senha" class="form-control" id="login_ssh" name="login_ssh" placeholder="Digite o login sem espaço!">
				  <p>Mínimo 4 caracter e no máximo 32!</p>
                </div>
				
				 <div class="form-group">
                  <label for="exampleInputPassword1">Senha SSH</label>
                  <input required="required" min="1" max="5" type="senha" class="form-control" id="senha_ssh" name="senha_ssh" placeholder="Digite Senha">
				  <p>Mínimo 6 caracter e no máximo 32! Misture letras e números!</p>
                </div>
				
				<div class="form-group">
                  <label for="exampleInputPassword1">Quantidade de dias </label>
                  <input required="required" type="number" class="form-control" id="dias" name="dias" placeholder="Digite a quantidade de dias " value="1" >
                </div>
				<div class="form-group">
                  <label for="exampleInputPassword1">Quantidade de acessos </label>
                  <input required="required" type="number" class="form-control" id="acessos" name="acessos" placeholder="Digite a quantidade de acessos " value="1">
                </div>
				<div class="form-group">
                 
                  <input  type="hidden" class="form-control" id="diretorio" name="diretorio"  value="../../home.php?page=ssh/adicionar">
				  <input  type="hidden" class="form-control" id="owner" name="owner"  value="<?php echo $_SESSION['usuarioID'];?>">
                </div>
				
			
               
				
			  <tr>
       
        <td >

				
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Cadastrar</button>
				<br/>
				
              </div>
			  
            </form>
          </div>
          <!-- /.box -->

         
         

          

        </div>
        
      </div>
      <!-- /.row -->
    </section>