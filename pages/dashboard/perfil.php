<?php 
  require_once("components/components.class.php"); 
  $libs_css = array("dependencias");
  components::header($libs_css, "Dashboard"); 
  components::menu(); 
?>
  <div class="container-fluid">
    <div class="row">
      <h1 class="page-header"><i class="fa fa-user"></i> Mi perfil</h1>
      <div class="col-xs-12 col-md-6 col-md-offset-3 col-lg-6 col-lg-offset-3">

        <div class="panel panel-default">
          <div class="panel-body">
            <div class="container-fluid">

              <!-- Nav tabs -->
              <ul class="nav nav-tabs">
                <li class="col-xs-12 col-md-6 active"><a class="text-center" href="#info" data-toggle="tab"><i class="fa fa-list"></i> Información</a></li>
                <li class="col-xs-12 col-md-6"><a class="text-center" href="#clave" data-toggle="tab"><i class="fa fa-lock"></i> Cambiar clave</a></li>
              </ul>

              <!-- Tab panes -->
              <div class="tab-content">
                <div class="tab-pane fade in active" id="info">
                  <div class="row abajo-10px">
                    <form id="frm_perfil" name="frm_perfil">
                      <input type="text" class="form-control hidden" id="id_usuario" name="id_usuario">
                      <div class="form-group">
                        <label>Nombres</label>
                        <input type="text" class="form-control" id="e_nombres" name="e_nombres">
                      </div>
                      <div class="form-group">
                        <label>Apellidos</label>
                        <input type="text" class="form-control" id="e_apellidos" name="e_apellidos">
                      </div>
                      <div class="form-group">
                        <label>Correo electrónico</label>
                        <input type="text" class="form-control" id="e_correo" name="e_correo">
                      </div>
                      <div class="form-group">
                        <label>Alias</label>
                        <input type="text" class="form-control" id="e_alias" name="e_alias">
                      </div>
                    </form>
                  </div>
                  <div class="row">
                    <div class="pull-right">
                      <div class="divider"></div>
                      <a class="btn btn-success izquierda-10px" onclick="editar_perfil();"> <i class="fa fa-check"></i> Guardar cambios</a>
                    </div>
                  </div>
                </div>
                <div class="tab-pane fade" id="clave">
                  <div class="row abajo-10px">
                    <form id="frm_editar_clave" name="frm_editar_clave">
                      <div class="form-group">
                        <label>Clave actual</label>
                        <input type="password" class="form-control" id="clave" name="clave">
                      </div>
                      <div class="form-group">
                        <label>Nueva clave</label>
                        <input type="password" class="form-control" id="nueva" name="nueva">
                      </div>
                      <div class="form-group">
                        <label>Confirmar nueva clave</label>
                        <input type="password" class="form-control" id="confirmar" name="confirmar">
                      </div>
                    </form>
                  </div>
                  <div class="row">
                    <div class="pull-right">
                      <div class="divider"></div>
                      <a class="btn btn-success izquierda-10px" onclick="editar_clave();"> <i class="fa fa-check"></i> Guardar cambios</a>
                    </div>
                  </div>
                </div>
              </div>

            </div>
          </div>
        </div>

      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->
<?php
  $libs_js = array("dependencias"); 
  components::footer($libs_js); 
  echo('<script src="../../core/controllers/dashboard/perfil.js"></script>');
?>