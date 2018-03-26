<?php 
    require_once(APPPATH."data_structures/Usuario.php");
    $usuario = unserialize($_SESSION['usuario']); ?>
    <body>

      <section id="container" >

        <header class="header black-bg">
          
            <div class="sidebar-toggle-box">
                <i class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation" id="esconder"></i>
            </div>

            <!--logo start-->
            <a href="<?php echo base_url('Admin'); ?>" class="logo"><b>PERFORMANCE JR.</b></a>
            <!--logo end-->
           
            <div class="top-menu">
             <ul class="nav pull-right top-menu">
              <li><a class="logout" href="<?= base_url('Admin/logout') ?>">Sair <span class="glyphicon glyphicon-log-out"></span></a></li>
            </ul>
          </div>
        </header>
    <!--header end-->

        <!-- **********************************************************************************************************************************************************
        MAIN SIDEBAR MENU
        *********************************************************************************************************************************************************** -->
        <!--sidebar start-->

        <aside>
          <div id="sidebar"  class="nav-collapse ">
            <!-- sidebar menu start-->
            <ul class="sidebar-menu" id="nav-accordion">

               <p class="centered"><img src="<?= base_url($usuario->getImagem())?>" class="img-circle" width="60"></p>
               <h5 class="centered"><?= $usuario->getNome() ?></h5>


               <li class="sub-menu">
                <a href="<?= base_url('Noticia/visualizar') ?>" >
                  <i class="fas fa-newspaper" style="margin-right: 5px;"></i>
                  <span>Noticia</span>
                </a>
              </li>
         

              <li class="sub-menu">
                <a href="<?= base_url('Projeto/visualizar') ?>" >
                  <i class="fas fa-briefcase" style="margin-right: 5px;"></i>
                  <span>Projeto</span>
                </a>
              </li>

              <li class="sub-menu">
                <a href="<?= base_url('Diretoria/visualizar') ?>" >
                  <i class="fa fa-users" style="margin-right: 5px;"></i>
                  <span>Diretoria</span>
                </a>
              </li>

              <li class="sub-menu">
                <a href="<?= base_url('Servico/visualizar') ?>" >
                  <i class="fa fa-bolt" style="margin-right: 5px;"></i>
                  <span>Serviço</span>
                </a>
              </li>

              <li class="sub-menu">
                <a href="<?= base_url('Membro/visualizar') ?>" >
                  <i class="fas fa-user" style="margin-right: 5px;"></i>
                  <span>Membro</span>
                </a>
              </li>

              <li class="sub-menu">
                <a href="<?= base_url('Sobre_controller') ?>" >
                  <i class="fas fa-book" style="margin-right: 5px;"></i>
                  <span>Sobre</span>
                </a>
              </li>
              <?php if(hasUserLevel(1)){ ?>
              <li class="sub-menu">
                <a href="<?= base_url('Usuario/visualizar') ?>" >
                  <i class="far fa-user" style="margin-right: 5px;"></i>
                  <span>Usuário</span>
                </a>
              </li>

              <li class="sub-menu">
                <a href="<?= base_url('Parceiro/visualizar') ?>" >
                  <i class="fas fa-briefcase" style="margin-right: 5px;"></i>
                  <span>Parceiro</span>
                </a>
              </li>

              <li class="sub-menu">
                <a href="<?= base_url('Configuracao_controller') ?>" >
                  <i class="fas fa-cogs" style="margin-right: 5px;"></i>
                  <span>Configuração</span>
                </a>
              </li>      
              <?php } ?>
          </ul>
          <!-- sidebar menu end-->
        </div>
      </aside>
      <!--sidebar end-->

      