<?php 

require_once "../modelos/Reporte1.php";

$reporte1 = new Report1();

switch ($_GET["op"]){
    case 'listar':
      // $curso=$_REQUEST["curso"];
      //  $scorm=$_REQUEST["scorm"];


        $rspta=$reporte1->traer();
         
       
        $data= Array();
          foreach ($rspta as $key => $valor) {  
              $data[]=array(
                "0"=>$valor->correlativo,
                "1"=>$valor->curso,
                "2"=>$valor->scorm,
                "3"=>$valor->codigo,
                "4"=>$valor->nombre,
                "5"=>$valor->email,
                "6"=>$valor->intento,
                "7"=>$valor->ingreso,
                "8"=>$valor->ultimo,
                "9"=>$valor->punteo,
                "10"=>$valor->estado,
                "11"=>$valor->finalizacion
                            );
              }
        
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);
 
    break;

    case 'cursos':

      $rspta=$reporte1->cursos();

        echo '<option value='.$valor->id='2'.'>Elige una opcion</option>'; 
        foreach ($rspta as $key => $valor)
                {
                   
                    echo '<option value="'.$valor->id.'">' . $valor->fullname . '</option>';
                }
                
    echo '<option value='.$valor->id=''.'>Todos</option>'; 
    
    break; 

    case 'scorm':
    
     $curso=$_REQUEST["curso"];
     
        $rspta = $reporte1->scorm($curso);

 echo '<option value='.$valor->id='2'.'>Elige una opcion</option>'; 
        foreach ($rspta as $key => $valor)
                {
                   
                    echo '<option value="'.$valor->id.'">' . $valor->name . '</option>';
                }
                
    echo '<option value='.$valor->id=''.'>Todas</option>'; 
    break;

  }
 
   

exit;