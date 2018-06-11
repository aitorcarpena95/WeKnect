<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Admin class.
 * 
 * @extends CI_Controller
 */
class Admin extends CI_Controller {

	/**
	 * __construct function.
	 * 
	 * @access public
	 * @return void
	 */
	public function __construct() {
		
		parent::__construct();
		$this->load->library(array('session'));
		$this->load->helper(array('url'));
		$this->load->model('forum_model');
		$this->load->model('user_model');
		$this->load->model('admin_model');
		
		//$this->output->enable_profiler(TRUE);
		
	}
	
	public function index() {
		
		// si el usuario no es administrador, redirigelo
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		
		// crea los objetos data
		$data = new stdClass();
		
		$this->load->view('header');
		$this->load->view('admin/home/index', $data);
		$this->load->view('footer');
		
	}
	
	public function users() {
		
		// si el usuario no es admin, redirigelo a la url base
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		
		// create the data object
		$data = new stdClass();
		
		$data->users = $this->user_model->get_users();
		
		$this->load->view('header');
		$this->load->view('admin/users/users', $data);
		$this->load->view('footer');
		
	}
	
	/**
	 * edit_user function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
	public function edit_user($username = false) {
		
		// si el usuario no es admin, redirigelo a la url base
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		
		if ($username === false) {
			
			redirect(base_url('index.php/admin/users'));
			return;
			
		}
		
		// crea los objetos data
		$data = new stdClass();
		
		// crea los objetos user
		$user_id = $this->user_model->get_user_id_from_username($username);
		$user    = $this->user_model->get_user($user_id);
		
		// especifica las opciones
		if ($user->is_admin === '1') {
			$options  = '<option value="administrator" selected>Administrator</option>';
			$options .= '<option value="moderator">Moderator</option>';
			$options .= '<option value="user">User</option>';
		} elseif ($user->is_moderator === '1') {
			$options  = '<option value="administrator">Administrator</option>';
			$options .= '<option value="moderator" selected>Moderator</option>';
			$options .= '<option value="user">User</option>';
		} else {
			$options  = '<option value="administrator">Administrator</option>';
			$options .= '<option value="moderator">Moderator</option>';
			$options .= '<option value="user" selected>User</option>';
		}
		
		// asigna valores a los objetos data
		$data->user    = $user;
		$data->options = $options;
		if ($user->updated_by !== null) {
			$data->user->updated_by = $this->user_model->get_username_from_user_id($user->updated_by);
		}
		
		// carga el helper y la libreria validaciones
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// especifica las reglas de validacion
		$this->form_validation->set_rules('user_rights', 'User Rights', 'required|in_list[administrator,moderator,user]', array('in_list' => 'Don\'t try to hack the form!'));
		
		if ($this->form_validation->run() == false) {
			
			$this->load->view('header');
			$this->load->view('admin/users/edit_user', $data);
			$this->load->view('footer');
			
		} else {
			
			// asigna permisos a las variables
			if ($this->input->post('user_rights') === 'administrator') {
				$is_admin     = '1';
				$is_moderator = '0';
			} elseif ($this->input->post('user_rights') === 'moderator') {
				$is_admin     = '0';
				$is_moderator = '1';
			} else {
				$is_admin     = '0';
				$is_moderator = '0';
			}
			
			if ($this->admin_model->update_user_rights($user_id, $is_admin, $is_moderator)) {
				// actualizar usuario correcto
				$data->success = $user->username . ' se ha actualizado con exito.';
			} else {
				//error al actualizar el usuario
				$data->error = 'Hubo un problema tratando de actualizar el usuario. Porfavor intentelo de nuevo.';
			}
			
			$this->load->view('header');
			$this->load->view('admin/users/edit_user', $data);
			$this->load->view('footer');
			
		}
		
	}
	
	public function forums_and_topics() {
		
		// si el usuario no es admin, redirigelo a la url base
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		
		// crea los objetos data
		$data = new stdClass();
		
		$this->load->view('header');
		$this->load->view('admin/forums_and_topics/forums_and_topics', $data);
		$this->load->view('footer');
		
	}
	
	public function options() {
		
		// si el usuario no es admin, redirigelo a la url base
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		
		// crea los objetos data
		$data = new stdClass();
		
		$this->load->view('header');
		$this->load->view('admin/options/options', $data);
		$this->load->view('footer');
		
	}
	
	public function emails() {
		
		// si el usuario no es admin, redirigelo a la url base
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		
		// crea los objetos data
		$data = new stdClass();
		
		$this->load->view('header');
		$this->load->view('admin/emails/emails', $data);
		$this->load->view('footer');
		
	}
        
        public function delete_user() {
		
// si el usuario no es admin, redirigelo a la url base
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			redirect(base_url());
			return;
		}
		$data->delete = $this->user_model->delete_user();
		
                
                if ($username === false) {
			
			redirect(base_url('index.php/admin/users'));
			return;
			
		}
		
		// crea los objetos data
		
			$this->load->view('header');
			$this->load->view('admin/users/delete_user', $data);
			$this->load->view('footer');
			
		
		
	}
	
		

}
