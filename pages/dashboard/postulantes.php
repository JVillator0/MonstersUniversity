<?php 
  require_once("components/components.class.php"); 
  $libs_css = array("dependencias", "datatables");
  components::header($libs_css, "Dashboard"); 
  components::menu(); 
?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">

        <h1 class="page-header">
          <i class='fa fa-rocket fa-fw'></i> Postulantes 
          <div class="btn-group pull-right">
            <a class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <i class="fa fa-file"></i> Reportes <span class="caret"></span>
            </a>
            <ul class="dropdown-menu">
              <li>
                <a href="../../core/reports/dashboard/postulantes_carreras.php" target="_blank">
                  Postulantes por carrera
                </a>
              </li>
              <li>
                <a href="../../core/reports/dashboard/postulantes_instituciones.php" target="_blank">
                  Postulantes por institución de procedencia
                </a>
              </li>
            </ul>
          </div>
        </h1>
        <div class="row">

        <!-- Nav tabs -->
        <ul class="nav nav-tabs">
          <li class="col-xs-12 col-md-6 active"><a class="text-center" href="#finalizadas" data-toggle="tab"><i class="fa fa-check"></i> Solicitudes finalizadas</a></li>
          <li class="col-xs-12 col-md-6"><a class="text-center" href="#guardadas" data-toggle="tab"><i class="fa fa-save"></i> Solicitudes guardadas</a></li>
        </ul>

        <!-- Tab panes -->
        <div class="tab-content">
          <div class="tab-pane fade in active" id="finalizadas">
            <div class="abajo-20px"></div>
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-registros-f">
              <thead>
                <tr>
                  <th class="text-center">Nombre completo</th>
                  <th class="text-center">Institución de procedencia</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">Correo eletrónico</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="tbody_registros_f">
              
              </tbody>
            </table>
          </div>
          <div class="tab-pane fade" id="guardadas">
            <div class="abajo-20px"></div>
            <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-registros-g">
              <thead>
                <tr>
                  <th class="text-center">Nombre completo</th>
                  <th class="text-center">Institución de procedencia</th>
                  <th class="text-center">Teléfono</th>
                  <th class="text-center">Correo eletrónico</th>
                  <th class="text-center">Acciones</th>
                </tr>
              </thead>
              <tbody id="tbody_registros_g">
              
              </tbody>
            </table>
          </div>
        </div>

        <!-- /.col-lg-12 -->
        </div>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

<?php
  $libs_js = array("dependencias", "datatables"); 
  components::footer($libs_js); 
  echo('<script src="../../core/controllers/dashboard/postulantes.js"></script>');
?>