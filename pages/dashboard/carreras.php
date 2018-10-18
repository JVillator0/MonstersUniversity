<?php 
  require_once("components/components.class.php"); 
  $libs_css = array("dependencias", "datatables");
  components::header($libs_css, "Dashboard"); 
  components::menu(); 
?>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-12">
        <h1 class="page-header"><i class='fa fa-gavel fa-fw'></i> Carreras</h1>
        <div class="row">
          <a href="#mdl_agregar" data-toggle="modal" class="btn btn-success"><i class="fa fa-plus"></i> Agregar registro </a>
        </div>
        <div class="row abajo-10px">
          <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-registros">
            <thead>
              <tr>
                <th class="text-center">Carrera</th>
                <th class="text-center">Descripción</th>
                <th class="text-center">Acciones</th>
              </tr>
            </thead>
            <tbody id="tbody_registros">
              
            </tbody>
          </table>
        <!-- /.col-lg-12 -->
        </div>
      </div>
      <!-- /.col-lg-12 -->
    </div>
    <!-- /.row -->
  </div>
  <!-- /.container-fluid -->

  <!-- Modal -->
  <div class="modal fade" data-backdrop="static" data-keyboard="true" id="mdl_agregar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
          <h4 class="modal-title"><i class="fa fa-plus"></i> Agregar registro</h4>
        </div>
        <div class="modal-body">
          <form id="frm_agregar" name="frm_agregar">
            <div class="form-group">
              <label>Carrera</label>
              <input type="text" class="form-control" id="carrera" name="carrera">
            </div>
            <div class="form-group">
              <label>Descripción</label>
              <textarea class="form-control" rows="3" id="descripcion" name="descripcion"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a class="btn btn-success" onclick="insertar();"><i class="fa fa-check"></i> Aceptar</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

  <!-- Modal -->
  <div class="modal fade" data-backdrop="static" data-keyboard="true" id="mdl_editar">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <a class="close" data-dismiss="modal">&times;</a>
          <h4 class="modal-title"><i class="fa fa-pencil"></i> Editar registro</h4>
        </div>
        <div class="modal-body">
          <form id="frm_editar" name="frm_editar">
            <input type="text" class="form-control hidden" id="id_carrera" name="id_carrera">
            <div class="form-group">
              <label>Carrera</label>
              <input type="text" class="form-control" id="e_carrera" name="e_carrera">
            </div>
            <div class="form-group">
              <label>Descripción</label>
              <textarea class="form-control" rows="3" id="e_descripcion" name="e_descripcion"></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a class="btn btn-warning" onclick="editar();"><i class="fa fa-pencil"></i> Editar</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
  </div>
  <!-- /.modal -->

<?php
  $libs_js = array("dependencias", "datatables"); 
  components::footer($libs_js); 
  echo('<script src="../../core/controllers/dashboard/carreras.js"></script>');
?>