<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * User class.
 * 
 * @extends CI_Controller
 */
class User extends CI_Controller {

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
		$this->load->model('user_model');
		
	}
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
	public function index($username = false) {
		
		if ($username === false) {
			redirect(base_url());
			return;
		}
		
		// crear objetos data
		$data = new stdClass();
		
		// cargar el modelo foro
		$this->load->model('forum_model');
		
		// coger el id del usuario de el nombre de usuario
		$user_id = $this->user_model->get_user_id_from_username($username);
		
		// crear el objeto user
		$user               = $this->user_model->get_user($user_id);
		$user->count_topics = $this->user_model->count_user_topics($user_id);
		$user->count_posts  = $this->user_model->count_user_posts($user_id);
		$user->latest_post  = $this->user_model->get_user_last_post($user_id);
		if ($user->latest_post !== null) {
			$user->latest_post->topic            = $this->forum_model->get_topic($user->latest_post->topic_id);
			$user->latest_post->topic->forum     = $this->forum_model->get_forum($user->latest_post->topic->forum_id);
			//$user->latest_post->topic->permalink = base_url($user->latest_post->topic->forum->slug . '/' . $user->latest_post->topic->slug);
		} else {
			$user->latest_post = new stdClass();
			$user->latest_post->created_at = $user->username . ' Aún no ha posteado nada';
		}
		$user->latest_topic = $this->user_model->get_user_last_topic($user_id);
		if ($user->latest_topic !== null) {
			$user->latest_topic->forum     = $this->forum_model->get_forum($user->latest_topic->forum_id);
			//$user->latest_topic->permalink = base_url($user->latest_topic->forum->slug . '/' . $user->latest_topic->slug);
		} else {
			$user->latest_topic        = new stdClass();
			$user->latest_topic->title = $user->username . ' Aún no ha posteado nada';
		}
		
		// crear breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url() . '">Home</a></li>';
		$breadcrumb .= '<li class="active">' . $username . '</li>';
		$breadcrumb .= '</ol>';
		
		// crear un boton para permitir la edición del perfil
		$edit_button = '<a href="' . base_url('index.php/user/' . $user->username . '/edit') . '" class="btn btn-xs btn-success">Edita tu perfil</a>';
		
		// asignar los objetos creados a los objetos data
		$data->user       = $user;
		$data->breadcrumb = $breadcrumb;
		if (isset($_SESSION['username']) && $_SESSION['username'] === $username) {
			// el usuario está en su propio perfil
			$data->edit_button = $edit_button;
		} else {
			// el usuario no está en su propio perfil
			$data->edit_button = null;
		}
		
		$this->load->view('header');
		$this->load->view('user/profile/profile', $data);
		$this->load->view('footer');
		
	}
	
	/**
	 * register function.
	 * 
	 * @access public
	 * @return void
	 */
	public function register() {
		
		// crear los objetos data
		$data = new stdClass();
		
		// cargar el helper y la libreria de validación
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// especificar las reglas
		$this->form_validation->set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[4]|max_length[20]|is_unique[users.username]', array('is_unique' => 'Este nombre de usuario ya existe, porfavor elija otro.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email|is_unique[users.email]');
		$this->form_validation->set_rules('password', 'Password', 'trim|required|min_length[6]');
		$this->form_validation->set_rules('password_confirm', 'Confirm Password', 'trim|required|min_length[6]|matches[password]');
		
		if ($this->form_validation->run() === false) {
			
			// validación no ok, envia erorres de la validación a la vista
			$this->load->view('header');
			$this->load->view('user/register/register', $data);
			$this->load->view('footer');
			
		} else {
			
			// especificar variables del formulario
			$username = $this->input->post('username');
			$email    = $this->input->post('email');
			$password = $this->input->post('password');
			
			if ($this->user_model->create_user($username, $email, $password)) {
				
				// creación de usuario ok
				$this->load->view('header');
				$this->load->view('user/register/register_success', $data);
				$this->load->view('footer');
				
			} else {
				
				// fallo al crear usuario
				$data->error = 'Hubo un problema al crear su cuenta, porfavor intentelo de nuevo.';
				
				// enviar error a la vista
				$this->load->view('header');
				$this->load->view('user/register/register', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
		
	/**
	 * login function.
	 * 
	 * @access public
	 * @return void
	 */
	public function login() {
		
		// crear el objeto data
		$data = new stdClass();
		
		// cargar el helper y la libreria de validación
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// especificar reglas
		$this->form_validation->set_rules('username', 'Username', 'required|alpha_numeric');
		$this->form_validation->set_rules('password', 'Password', 'required');
		
		if ($this->form_validation->run() == false) {
			
			// validación no ok, enviar errores de la validación a la vista
			$this->load->view('header');
			$this->load->view('user/login/login');
			$this->load->view('footer');
			
		} else {
			
			// especificar las variables del formulario
			$username = $this->input->post('username');
			$password = $this->input->post('password');
			
			if ($this->user_model->resolve_user_login($username, $password)) {
				
				$user_id = $this->user_model->get_user_id_from_username($username);
				$user    = $this->user_model->get_user($user_id);
				
				// especificar la data de la sesión de usuario
				$_SESSION['user_id']      = (int)$user->id;
				$_SESSION['username']     = (string)$user->username;
				$_SESSION['logged_in']    = (bool)true;
				$_SESSION['is_confirmed'] = (bool)$user->is_confirmed;
				$_SESSION['is_admin']     = (bool)$user->is_admin;
				
				// user login ok
				$this->load->view('header');
				$this->load->view('user/login/login_success', $data);
				$this->load->view('footer');
				
			} else {
				
				// login fallido
				$data->error = 'Wrong username or password.';
				
				// enviar errores a la vista
				$this->load->view('header');
				$this->load->view('user/login/login', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	

	public function logout() {
		
		// crear objetp data
		$data = new stdClass();
		
		if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
			
			// eliminar datos de sesión
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			
			// user logout ok
			$this->load->view('header');
			$this->load->view('user/logout/logout_success', $data);
			$this->load->view('footer');
			
		} else {
			
			
			redirect('/');
			
		}
		
	}
	
	/**
	 * email_validation function.
	 * 
	 * @access public
	 * @param string $username
	 * @param string $hash
	 * @return void
	 */
	public function email_validation($username, $hash) {
		
		// crear objetos data
		$data = new stdClass();
		
		// evitar espacio en blanco al final de la url
		$hash = trim($hash);
		
		if ($this->user_model->confirm_account($username, $hash)) {
			
			// validacion cuenta ok
			$data->success = 'Enhorabuena, su correo ha sido validado y su cuenta está activa! Porfavor <a href="https://knect.asir6.enganxat.net/index.php/login">logueate</a>.';
			$this->load->view('header');
			$this->load->view('user/register/confirmation', $data);
			$this->load->view('footer');
			
		} else {
			
			// validation cuenta fallida 
			$data->error = 'Wops! Su cuenta no ha podido ser validada debido a un error inesperado. Porfavor contacta con un administrador.';
			$this->load->view('header');
			$this->load->view('user/register/confirmation', $data);
			$this->load->view('footer');
			
		}
		
	}
	
	/**
	 * edit function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
      
	public function edit($username = false) {
		
		// un usuario solo puede editar su propio perfil
		if ($username === false || $username !== $_SESSION['username']) {
			redirect(base_url());
			return;
		}
		
		// crear objeto data
		$data = new stdClass();
		
		// cargar helper y libreria de validación
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// form validation 
		$password_required_if = $this->input->post('password') ? '|required' : ''; // if there is something on password input, current password is required
		$this->form_validation->set_rules('username', 'Username', 'trim|min_length[4]|max_length[20]|alpha_numeric|is_unique[users.username]', array('is_unique' => 'This username already exists. Please choose another username.'));
		$this->form_validation->set_rules('email', 'Email', 'trim|valid_email|is_unique[users.email]', array('is_unique' => 'The email you entered already exists in our database.'));
		$this->form_validation->set_rules('current_password', 'Current Password', 'trim' . $password_required_if . '|callback_verify_current_password');
		$this->form_validation->set_rules('password', 'New Password', 'trim|min_length[6]|matches[password_confirm]');
		$this->form_validation->set_rules('password_confirm', 'Password Confirmation', 'trim|min_length[6]');
		
		// especificar el objeto user
		$user_id = $this->user_model->get_user_id_from_username($username);
		$user    = $this->user_model->get_user($user_id);
		
		// crear breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url() . '">Home</a></li>';
		$breadcrumb .= '<li><a href="' . base_url('index.php/user/' . $username) . '">' . $username . '</a></li>';
		$breadcrumb .= '<li class="active">Edit</li>';
		$breadcrumb .= '</ol>';
		
		// asignar objetos al objeto data
		$data->user       = $user;
		$data->breadcrumb = $breadcrumb;
		
		if ($this->form_validation->run() === false) {
			
			// validacion no ok, enviar errores de validacion a la vista
			$this->load->view('header');
			$this->load->view('user/profile/edit', $data);
			$this->load->view('footer');
			
		} else {
			
			$user_id = $_SESSION['user_id'];
			$update_data = [];
			
			if ($this->input->post('username') != '') {
				$update_data['username'] = $this->input->post('username');
			}
			if ($this->input->post('email') != '') {
				$update_data['email'] = $this->input->post('email');
			}
			if ($this->input->post('password') != '') {
				$update_data['password'] = $this->input->post('password');
			}
			
			// subir avatar
			if (isset($_FILES['userfile']['name']) && !empty($_FILES['userfile']['name'])) {
				
				// configuracion paras subir img y cargar libreria upload
				$config['upload_path']      = './uploads/avatars/';
				$config['allowed_types']    = 'gif|jpg|png';
				$config['max_size']         = 2048;
				$config['max_width']        = 1024;
				$config['max_height']       = 1024;
				$config['file_ext_tolower'] = true;
				$config['encrypt_name']     = true;			
				$this->load->library('upload', $config);
				
				if (!$this->upload->do_upload()) {
					
					// upload NO ok
					$error = array('error' => $this->upload->display_errors());
					$this->load->view('upload_form', $error);
				
				} else {
					
					// Upload ok enviame nombre a $updated_data
					$update_data['avatar'] = $this->upload->data('file_name');
					
				}
				
			}
			
			// si todo ok
			if ($this->user_model->update_user($user_id, $update_data)) {
				
				// si nombre usuario cambia, actualizar sesión
				if(isset($update_data['username'])) {
					$_SESSION['username'] = $update_data['username'];
					if ($this->input->post('username') != '') {
						// un pequeño hook para enviar el mensaje de success a la nueva url del perfil si el nombre de usuario ha sido actualizado
						$_SESSION['flash']    = 'Tu perfil ha sido actualizado con exito!';
					}
				}
				
				// solucionar el hecho de que no se muestre el nuevo avatar hasta que se actualize la página
				if(isset($update_data['avatar'])) {
					$data->user->avatar = $update_data['avatar'];
				}
				
				if ($this->input->post('username') != '') {
					
					// redirigir a la nueva url del perfil
					redirect(base_url('index.php/user/' . $update_data['username'] . '/edit'));
					
				} else {
					
					// crear mensaje de success
					$data->success = 'Tu perfil ha sido actualizado con exito!';
					
					// enviar mensaje a la vista
					$this->load->view('header');
					$this->load->view('user/profile/edit', $data);
					$this->load->view('footer');
					
				}
				
			} else {
				
				// fallo al actualizar el usuario
				$data->error = 'Wops! Hubo un problema actualizando tu perfil. Porfavor, vuelva a intentarlo.';
				
				// enviar errores a la vista
				$this->load->view('header');
				$this->load->view('user/profile/edit', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
	/**
	 * delete function.
	 * 
	 * @access public
	 * @param mixed $username (default: false)
	 * @return void
	 */
	public function delete($username = false) {
		
		// solo el propio usuario puede borrar su perfil y debe de estar logueado
		if ($username == false || !isset($_SESSION['username']) || $username !== $_SESSION['username']) {
			redirect(base_url());
			return;
		}
		
		// crear objeto data
		$data = new stdClass();
		
		if ($_SESSION['username'] === $username) {
			
			// crear breadcrumb
			$breadcrumb  = '<ol class="breadcrumb">';
			$breadcrumb .= '<li><a href="' . base_url() . '">Home</a></li>';
			$breadcrumb .= '<li><a href="' . base_url('index.php/user/' . $username) . '">' . $username . '</a></li>';
			$breadcrumb .= '<li class="active">Delete</li>';
			$breadcrumb .= '</ol>';
			
			$user_id          = $this->user_model->get_user_id_from_username($username);
			$data->user       = $this->user_model->get_user($user_id);
			$data->breadcrumb = $breadcrumb;
			
			if ($this->user_model->delete_user($user_id)) {
				
				$data->success = 'Tu cuenta ha sido borrada con éxito. Bye bye :(';
				
				// borrado de usuario ok, cargar vistas
				$this->load->view('header');
				$this->load->view('user/profile/delete', $data);
				$this->load->view('footer');
				
			} else {
				
				// borrado de usuario no ok
				$data->error = 'Ha surgido un problema al borrar tu cuenta. Porfavor contacta con un administrador.';
				
				// enviar errores a la vista
				$this->load->view('header');
				$this->load->view('user/profile/edit', $data);
				$this->load->view('footer');
				
			}
			
		} else {
			
			// solo el propio usuario puede borrar su cuenta y debe estar logueado
			redirect(base_url());
			return;
			
		}
		
	}
	
	/**
	 * verify_current_password function.
	 * 
	 * @access public
	 * @param string $str
	 * @return bool
	 */
	public function verify_current_password($str) {
		
		if ($str != '') {
			
			if ($this->user_model->resolve_user_login($_SESSION['username'], $str) === true) {
				return true;
			}
			$this->form_validation->set_message('verify_current_password', 'El campo {field} no coincide con tu contraseña.');
			return false;
			
		}
		return true;
		
	}
        
 
}
