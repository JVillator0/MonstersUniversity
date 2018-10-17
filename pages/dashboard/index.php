<?php 
  require_once("components/components.class.php"); 
  $libs_css = array("dependencias");
  components::header($libs_css, "Dashboard"); 
  components::menu(); 
?>
<!-- div class="container-fluid hide" id="content_dashboard" -->
<div class="container-fluid">
  <div class="row">
    <div class="col-lg-12">
      <h1 class="page-header"><i class="fa fa-home"></i> Inicio</h1>
    </div>
      <!-- /.col-lg-12 -->
  </div>
  <!-- /.row -->
  <div class="row">
    <div class="col-xs-12 col-md-5">
      <div class="panel panel-default">
        <div class="panel-body">
          <div id="grafico_1" style="height: 500px">
            
          </div>
        </div>
      </div>
    </div>
    <div class="col-xs-12 col-md-7">
      <div class="panel panel-default">
        <div class="panel-body">
          <div id="grafico_2" style="height: 500px">
            
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- /.row -->
</div>
<?php
  $libs_js = array("dependencias", "echarts"); 
  components::footer($libs_js); 
  echo('<script src="../../core/controllers/dashboard/index.js"></script>');
?>