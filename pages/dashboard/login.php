<?php 
  require_once("components/components.class.php"); 
  $libs_css = array("dependencias");
  components::header($libs_css, "Dashboard"); 
?>
    <div class="container">
      <div class="row">
        <div class="col-md-4 col-md-offset-4">
          <div class="login-panel panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title"><i class="fa fa-lock"></i> Inicio de sesión</h3>
            </div>
            <div class="panel-body">
              <form id="frm_login" name="frm_login">
                <div class="container-fluid">
                  <div class="form-group">
                    <label>Alias</label>
                    <input type="text" class="form-control" id="alias" name="alias" placeholder="Alias" autofocus>
                  </div>
                  <div class="form-group">
                    <label>Clave</label>
                    <input class="form-control" id="clave" name="clave" placeholder="Clave" type="password">
                  </div>
                  <a onclick="login();" class="btn btn-lg btn-success btn-block">
                    Iniciar sesión <i class="fa fa-sign-in"></i>
                  </a>
                  <br>
                  <div class="form-group text-center">
                    <a href="#mdl_restaurar_1" data-toggle="modal" class="btn btn-default btn-xs">
                      ¿Olvido su clave?
                    </a>
                  </div>
                </div>
              </form>
            </div>
          </div>
          <div class="col-xs-12 text-center">
            <a href="../public/index.php" class="btn btn-primary"><i class="fa fa-delicious"></i> Sitio público</a>
          </div>
        </div>
      </div>
    </div>

  <!-- Modal -->
  <div class="modal fade" data-backdrop="static" data-keyboard="true" id="mdl_restaurar_1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
          <h4 class="modal-title"><i class="fa fa-lock"></i> Restaurar clave</h4>
        </div>
        <div class="modal-body">
          <form id="frm_alias" name="frm_alias">
            <div class="form-group">
              <label>Escriba su alias</label>
              <input type="text" class="form-control" id="r_alias" name="r_alias">
            </div>
            <div class="form-grup">
              <div class="g-recaptcha" data-sitekey="6LdP8WYUAAAAAOe1rptxGjJncC41dJQyViDSseiJ"></div>\
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a onclick="restaurar_enviar_email();" class="btn btn-success">Siguiente <i class="fa fa-chevron-right"></i></a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal -->
  <div class="modal fade" data-backdrop="static" data-keyboard="true" id="mdl_restaurar_2">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
          <h4 class="modal-title"><i class="fa fa-lock"></i> Restaurar clave</h4>
        </div>
        <div class="modal-body">
          <form id="frm_codigo_verificar" name="frm_codigo_verificar">
            <div class="form-group">
              <p>Se le ha enviado a su correo electrónico un código de verificación.</p>
              <label>Codigo</label>
              <input type="text" class="form-control" id="codigo_verificar" name="codigo_verificar">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a onclick="verificar_codigo();" class="btn btn-success">Siguiente <i class="fa fa-chevron-right"></i></a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal -->
  <div class="modal fade" data-backdrop="static" data-keyboard="true" id="mdl_restaurar_3">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
          <h4 class="modal-title"><i class="fa fa-lock"></i> Restaurar clave</h4>
        </div>
        <div class="modal-body">
          <form id="frm_restaurar" name="frm_restaurar">
            <div class="form-group">
              <label>Nueva clave</label>
              <input type="password"  class="form-control" id="r_clave" name="r_clave">
            </div>
            <div class="form-group">
              <label>Confirmar nueva clave</label>
              <input type="password"  class="form-control" id="r_confirmar" name="r_confirmar">
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a onclick="restaurar();" class="btn btn-success"><i class="fa fa-check"></i> Aceptar</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<?php
  $libs_js = array("dependencias", "recaptcha"); 
  components::footer($libs_js); 
  echo('<script src="../../core/controllers/dashboard/login.js"></script>');
?>