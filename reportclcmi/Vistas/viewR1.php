
<?php 
require_once('../../../config.php');

require_once "../modelos/Reporte1.php";
require_once('../Forms/reportcl_form1.php');


// 
global $DB,$OUTPUT,$PAGE;
//$PAGE->requires->js_call_amd('tool_datatables/init', 'init',
                            // array('.datatable', array()));
// Comprobar variables requeridas
$courseid = required_param('courseid', PARAM_INT);
$blockid = required_param('blockid', PARAM_INT);
 
// Buscar las variables opcionales.
$id = optional_param('id', 0, PARAM_INT);
 
 
if (!$course = $DB->get_record('course', array('id' => $courseid))) {
    print_error('invalidcourse', 'block_reportcl', $courseid);
}
 
require_login($course);

$PAGE->set_url('/blocks/reportcl/Vistas/viewR1.php', array('id' => $courseid));
$PAGE->set_pagelayout('standard');
$PAGE->set_heading(get_string('edithtml1', 'block_reportcl'));

 //
$settingsnode = $PAGE->settingsnav->add(get_string('reportclsettings', 'reportcl'));
$editurl = new moodle_url('/blocks/reportcl/Vistas/viewR1.php', array('id' => $id, 'courseid' => $courseid, 'blockid' => $blockid));

$editnode = $settingsnode->add(get_string('editpage1', 'block_reportcl'), $editurl);
$editnode->make_active();
//
$bi = new reportcl_form1();
 echo $OUTPUT->header();
$bi->display();

?>
  
  <link rel="stylesheet" type="text/css" href="../public/datatables/jquery.dataTables.min.css">
                          <link rel="stylesheet" type="text/css" href="../public/datatables/buttons.dataTables.min.css">
                          <link rel="stylesheet" type="text/css" href="../public/datatables/responsive.dataTables.min.css">
                       
                       
               
                   <div class="panel-body container-fluid" id="listadoregistros">
                                     

                                   
                                        <table id="tbllistado" class="display nowrap" style="width:100%">
                                          <thead class="container-fluid" style="width: 100%">
                                            <th >No.</th>
                                            <th class="select-filter">Curso</th>
                                            <th class="select-filter">Nombre de scorm</th>
                                            <th class="select-filter">Código</th>
                                            <th class="select-filter">Nombre</th>
                                            <th class="select-filter">Dirección de correo</th>
                                            <th class="select-filter">Intento</th>
                                            <th class="select-filter">Comenzado en</th>
                                            <th class="select-filter">Último acceso en</th>
                                            <th class="select-filter">Puntuación</th>
                                            <th class="select-filter">Estado</th>
                                            <th class="select-filter">Finalización</th>
                                  
                                          </thead>
                                          <tbody style="width: 100%">

                                          </tbody>
                                         
                                        </table>
                                    </div>
        
                    <!--Fin centro -->
             
 
   
  <!--Fin-Contenido-->


 <script src="http://54.161.158.96/lib/javascript.php/1534788080/lib/jquery/jquery-3.5.1.min.js"></script>
<script src="../public/datatables/jquery.dataTables.min.js"></script>
   <script src="../public/datatables/dataTables.buttons.min.js"></script>
  <script src="../public/datatables/buttons.html5.min.js"></script>
   <script src="../public/datatables/buttons.colVis.min.js"></script>
     <script src="../public/datatables/jszip.min.js"></script>
       <script src="../public/datatables/pdfmake.min.js"></script>
         <script src="../public/datatables/vfs_fonts.js"></script>
      <script src="../public/js/bootbox.min.js"></script>
   

<script src="../public/js/reporte1.js"></script>
<?php
echo $OUTPUT->footer();

 ?>