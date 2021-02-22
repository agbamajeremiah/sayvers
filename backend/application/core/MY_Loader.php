<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class MY_Loader extends CI_Loader {
    public function template($template_name, $vars = array(), $return = FALSE)
    {
		$CI =& get_instance();
        $vars['template_name'] = $template_name;

        if($return):
			$content  = $this->view('shared/header', $vars, $return);
			$content .= $this->view('shared/sidebar', $vars, $return);
			$content .= $this->view('layouts/content', $vars, $return);
            $content .= $this->view('shared/footer', $vars, $return);

            return $content;
        else:
            $this->view('shared/header', $vars);
			$this->view('shared/sidebar', $vars);
			$this->view('layouts/content', $vars);
            $this->view('shared/footer', $vars);
        endif;
    }

}