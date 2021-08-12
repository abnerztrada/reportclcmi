<?php 

//Incluímos inicialmente la conexión a la base de datos
require_once('../../../config.php');

Class Report1
{

    protected $global;

    //Implementamos nuestro constructor
    public function __construct()
    {
       global $DB;
        $this->global = $DB;
    }
 
    //Trae informacion del detalle de encuestas
    public function traer()
    {

          global $DB;
          
          $user = $DB->get_records_sql 
          
         ("SELECT(@rownum:=@rownum+1) correlativo, Concat(u.firstname,' ', u.lastname)as nombre, username as codigo,c.fullname as curso,u.email,s.name	as scorm,  Case when IFNULL(scorm.intento,0)=0 then 0
		 ELSE scorm.intento
		end intento,Case when ingreso.fecha <> '' then DATE_FORMAT(DATE_ADD(DATE_FORMAT(from_unixtime(ingreso.fecha), '%Y-%m-%d %H:%i:%s'),INTERVAL -6 HOUR), '%d/%m/%Y %H:%i:%s') ELSE '' end ingreso,Case when final.fecha <> '' then DATE_FORMAT(DATE_ADD(DATE_FORMAT(from_unixtime(final.fecha), '%Y-%m-%d %H:%i:%s'),INTERVAL -6 HOUR), '%d/%m/%Y %H:%i:%s')  ELSE '' end ultimo, Case when IFNULL(punteo.punteo,0)=0 then 0 ELSE punteo.punteo end punteo,Case when IFNULL(scorm.intento,0)=0 then 'No se ha intentado' 
		when  estado.value ='passed' or estado.value='completed' then 'Completado' 
		when  estado.value ='failed' then 'Intento fallido' 
		when IFNULL(estado.value,1)=1 then 'Incompleto' end estado,Case when fin.fecha <> '' then DATE_FORMAT(DATE_ADD(DATE_FORMAT(from_unixtime(fin.fecha), '%Y-%m-%d %H:%i:%s'),INTERVAL -6 HOUR), '%d/%m/%Y %H:%i:%s') ELSE '' end finalizacion
		FROM  (SELECT @rownum:=0) r,mdl_course AS c 
					 Join mdl_enrol as e  on e.courseid=c.id 
					 JOIN mdl_context AS ctx ON c.id = ctx.instanceid 
					 JOIN mdl_role_assignments AS ra ON ra.contextid = ctx.id 
					 JOIN mdl_user AS u ON u.id = ra.userid 
					 Join mdl_user_enrolments as ue on ue.enrolid=e.id and ue.userid=u.id
					 Join mdl_scorm as s on s.course=c.id
					 left join (Select userid,scormid,scorm.name,max(attempt)as intento,course from mdl_scorm_scoes_track sst
					 inner join (Select min(s.id) as idscorm,course,name
					 from mdl_scorm s GROUP BY s.course,name )as scorm
					 on scorm.idscorm=sst.scormid
					 and element='cmi.core.lesson_status' or element = 'cmi.completion_status'
					 GROUP BY userid,scormid,course,scorm.name) as scorm
					 on s.course=scorm.course and u.id=scorm.userid and s.id=scormid
					 left join (select userid,scormid,Min(attempt)as attempt,Min(value)as fecha from mdl_scorm_scoes_track
					 where  element='x.start.time' GROUP BY userid,scormid) ingreso
					 on u.id=ingreso.userid and scorm.scormid=ingreso.scormid
					 left join (select userid,scormid,max(attempt)as attempt,max(timemodified) as fecha from mdl_scorm_scoes_track
					 where  element='cmi.core.total_time'  or element = 'cmi.total_time'  GROUP BY userid,scormid) final
					 on u.id=final.userid and scorm.scormid=final.scormid and scorm.intento=final.attempt
					 left join (select userid,scormid,Min(attempt)as attempt,value,min(timemodified)as fecha from mdl_scorm_scoes_track
					 where  ( element='cmi.core.lesson_status' or element = 'cmi.completion_status') and (value='passed' or value='completed')GROUP BY userid,scormid,value) fin
					 on u.id=fin.userid and scorm.scormid=fin.scormid
					 left join (select userid,scormid,max(ROUND(value,0)) as punteo from mdl_scorm_scoes_track
					 where  element='cmi.core.score.raw' GROUP BY userid,scormid) punteo
					 on u.id=punteo.userid and scorm.scormid=punteo.scormid 
					 left join (select userid,scormid,max(attempt),value from mdl_scorm_scoes_track
					 where  ( element='cmi.core.lesson_status'  or element = 'cmi.completion_status' ) and (value='passed' or value='completed' ) GROUP BY userid,scormid,value) estado
					 on u.id=estado.userid and scorm.scormid=estado.scormid");

			// var_dump($user); 
			// die();
            return $user;
		
    }


     public function cursos()
    {

          global $DB;
          
          $courses = $DB->get_records_sql 
          
         ("SELECT c.id,c.fullname 
			from mdl_course c
			inner join mdl_scorm s
			on c.id=s.course    
			where c.id <>1
			group by c.id,c.fullname") ;


            return $courses;

    }

     public function scorm($curso)
    {

          global $DB;
          
          $scorms = $DB->get_records_sql 
          
         ("SELECT id, name, course from mdl_scorm where course like '%$curso%' ") ;


            return $scorms;

    }
}
 
?>
