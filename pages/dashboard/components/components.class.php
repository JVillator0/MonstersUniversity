<?php
class components 
{

  public static function header($libs_css, $title){
    print("
      <!DOCTYPE html>
      <html lang='es'>
      <head>
      <meta charset='utf-8'>
      <meta http-equiv='X-UA-Compatible' content='IE=edge'>
      <meta name='viewport' content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0'>

      <title> $title </title>
      <link rel='icon' href='../../resource/img/logo2.png' type='image/ico'>
    ");
    self::libs_css($libs_css);
    print("
      <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
      <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
      <!--[if lt IE 9]>
          <script src='https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js'></script>
          <script src='https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js'></script>
      <![endif]-->
      </head>
      <body>
      <div id='wrapper'>
    ");
  }    

  public static function menu(){
    print("
        <header>
            <div>
                <!-- Navigation -->
                <nav class='navbar navbar-default navbar-fixed-top' style='margin-bottom: 0'>
                    <div class='navbar-header'>
                        <button type='button' class='btn btn-default pull-right abajo-5px izquierda-5px visible-xs' data-toggle='collapse' data-target='.navbar-collapse'>
                            <span class='fa fa-bars'></span>
                        </button>
                        <a class='navbar-brand center-align' href='index.php'>Monsters University</a>
                    </div>
                    <!-- /.navbar-header -->

                    <ul class='nav navbar-top-links navbar-right'>
                        <li class='dropdown pull-right'>
                            <a class='dropdown-toggle toggle-item' data-toggle='dropdown' href='index.php' id='info_usuario'>
                                
                            </a>
                            <ul class='dropdown-menu dropdown-user'>
                                <li><a href='perfil.php'><i class='fa fa-user fa-fw'></i> Mi perfil</a></li>
                                <li><a href='../public/index.php'><i class='fa fa-delicious fa-fw'></i> Sitio público</a></li>
                                <li class='divider'></li>
                                <li onclick='destroy();'><a href='#'><i class='fa fa-sign-out fa-fw'></i> Cerrar sesión</a></li>
                            </ul>
                            <!-- /.dropdown-user -->
                        </li>
                        <!-- /.dropdown -->
                    </ul>
                    <!-- /.navbar-top-links -->

                    <div class='navbar-default sidebar hide' id='header_dashboard' role='navigation'>
                        <div class='sidebar-nav navbar-collapse'>
                            <ul class='nav' id='side-menu'>
                                <li>
                                    <div id='info_usuario_sidenav'>  

                                    </div>
                                </li>
                                <li>
                                    <a href='index.php'><i class='fa fa-home fa-fw'></i> Inicio</a>
                                </li>
                                <li>
                                    <a href='postulantes.php'><i class='fa fa-rocket fa-fw'></i> Postulantes</a>
                                </li>
                                <li>
                                    <a href='carreras.php'><i class='fa fa-gavel fa-fw'></i> Carreras</a>
                                </li>
                                <li>
                                    <a href='instituciones.php'><i class='fa fa-bank fa-fw'></i> Instituciones</a>
                                </li>
                                <li>
                                    <a href='especialidades.php'><i class='fa fa-cog fa-fw'></i> Especialidades</a>
                                </li>
                                <li>
                                    <a href='usuarios.php'><i class='fa fa-users fa-fw'></i> Usuarios</a>
                                </li>
                            </ul>
                        </div>
                        <!-- /.sidebar-collapse -->
                    </div>
                    <!-- /.navbar-static-side -->
                </nav>
            </div>
        </header>
        <br>
        <br class='visible-xs'>
        <br class='visible-xs'>
        <br class='visible-xs'>
        <!-- Page Content -->
        <div id='page-wrapper'>
    ");
  } 

  public static function footer($libs_js){
    print(" 
        </div>
        <!-- /#page-wrapper -->
      </div>
      <!-- /#wrapper -->
    ");
    self::libs_js($libs_js); 
    print(" 
     </body>
      </html>
    ");
  }

  private function libs_css($libs){
    foreach ($libs as $key => $lib) {
      switch ($lib) {
        case 'dependencias':
          print("
            <!-- Bootstrap Core CSS -->
            <link href='../../libs/bootstrap/css/bootstrap.min.css' rel='stylesheet'>
            <!-- MetisMenu CSS -->
            <link href='../../libs/metisMenu/metisMenu.min.css' rel='stylesheet'>
            <!-- Custom Fonts -->
            <link href='../../libs/font-awesome/css/font-awesome.min.css' rel='stylesheet' type='text/css'>
            <!-- Custom CSS -->
            <link href='../../resource/css/navbar_custom.css' rel='stylesheet'>
            <link href='../../resource/css/helpers.css' rel='stylesheet'>
            <link href='../../resource/css/sb-admin-2.css' rel='stylesheet'>
          ");
          break;

        case 'datatables':
          print("
            <!-- DataTables CSS -->
            <link href='../../libs/datatables-plugins/dataTables.bootstrap.css' rel='stylesheet'>
            <!-- DataTables Responsive CSS -->
            <link href='../../libs/datatables-responsive/dataTables.responsive.css' rel='stylesheet'>
          ");
          break;
        
        default:
        
          break;
      }
    }
  }

  private function libs_js($libs){
    foreach ($libs as $key => $lib) {
      switch ($lib) {
        case 'dependencias':
          print("
            <!-- jQuery -->
            <script src='../../libs/jquery/jquery.min.js'></script>
            
            <!-- Bootstrap Core JavaScript -->
            <script src='../../libs/bootstrap/js/bootstrap.min.js'></script>
            
            <!-- Metis Menu Plugin JavaScript -->
            <script src='../../libs/metisMenu/metisMenu.min.js'></script>
            
            <!-- Custom Theme JavaScript -->
            <script src='../../resource/js/sb-admin-2.js'></script>

            <!-- Sweet Alert notifys -->
            <script src='../../libs/sweetalert/js/sweetalert.min.js'></script>

            <!-- Main core JS -->
            <script src='../../core/controllers/dashboard/main.js'></script>
          ");
          break;

        case 'echarts':
          print("
            <!-- Echarts Charts JavaScript -->
            <script src='../../libs/echarts/echarts.js'></script>
          ");
          break;

        case 'datatables':
          print("
            <!-- DataTables JavaScript -->
            <script src='../../libs/datatables/js/jquery.dataTables.min.js'></script>
            <script src='../../libs/datatables-plugins/dataTables.bootstrap.min.js'></script>
            <script src='../../libs/datatables-responsive/dataTables.responsive.js'></script>
            <script src='../../resource/js/init_datatable.js'></script>
          ");
          break;
        
        default:
        
          break;
      }
    }
  } 
}
?>