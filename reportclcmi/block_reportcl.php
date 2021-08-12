<?php
defined('MOODLE_INTERNAL') || die();
class block_reportcl extends block_list

 {
    public function init() {
        $this->title = get_string('pluginname', 'block_reportcl');
	


}
public function get_content() {

    global $COURSE;

  if ($this->content !== null) {
    return $this->content;
  }
 
$menuItems = array();
  $this->content         = new stdClass;
  $this->content->items  = array();
  $this->content->icons  = array();
  //$this->content->footer = 'Footer here...';
  //intento form
 $url = new moodle_url('/blocks/reportcl/Vistas/viewR1.php', array('blockid' => $this->instance->id, 'courseid' => $COURSE->id));
  $this->content->items[] = html_writer::link($url, get_string('addpage1', 'block_reportcl'));


}

    
public function instance_allow_multiple()
    {
        return true;
    }

    public function instance_allow_config()
    {
        return true;
    }

    public function has_config()
    {
        return true;
    }

    public function cron()
    {
       return true;
    }
}