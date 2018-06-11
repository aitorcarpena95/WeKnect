<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Forum class.
 * 
 * @extends CI_Controller
 */
class Forum extends CI_Controller {

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
		
		//$this->output->enable_profiler(TRUE);
		
	}
	
	/**
	 * index function.
	 * 
	 * @access public
	 * @param mixed $slug (default: false)
	 * @return void
	 */
	public function index($slug = false) {
		
		// create los objetos de data
		$data = new stdClass();
		
		if ($slug === false) {
			
			// crea objetos
			$forums = $this->forum_model->get_forums();
			
			foreach ($forums as $forum) {
				
				$forum->permalink    = base_url($forum->slug);
				$forum->topics       = $this->forum_model->get_forum_topics($forum->id);
				$forum->count_topics = count($forum->topics);
				$forum->count_posts  = $this->forum_model->count_forum_posts($forum->id);
				
				if ($forum->count_topics > 0) {
					
					// $forum tiene los subforos
					$forum->latest_topic            = $this->forum_model->get_forum_latest_topic($forum->id);
					$forum->latest_topic->permalink = $forum->slug . '/' . $forum->latest_topic->slug;
					$forum->latest_topic->author    = $this->user_model->get_username_from_user_id($forum->latest_topic->user_id);
					
				} else {
					
					// $forum no tiene subforos aún
					$forum->latest_topic = new stdClass();
					$forum->latest_topic->permalink = null;
					$forum->latest_topic->title = null;
					$forum->latest_topic->author = null;
					$forum->latest_topic->created_at = null;
					
				}
	
			}
			
			// crear breadcrumb
			$breadcrumb  = '<ol class="breadcrumb">';
			$breadcrumb .= '<li class="active" style="color:black">Home</li>';
			$breadcrumb .= '</ol>';
			
			// assignar objectos creados a los data object
			$data->forums     = $forums;
			$data->breadcrumb = $breadcrumb;
			
			// carga las vistas y envia data
			$this->load->view('header');
			$this->load->view('forum/index', $data);
			$this->load->view('footer');
			
		} else {
			
			// sacar id de slug
			$forum_id = $this->forum_model->get_forum_id_from_forum_slug($slug);
			
			// crear objetos
			$forum    = $this->forum_model->get_forum($forum_id);
			$topics   = $this->forum_model->get_forum_topics($forum_id);
			
			// crear breadcrumb
			$breadcrumb  = '<ol class="breadcrumb">';
			$breadcrumb .= '<li><a href="' . base_url() . '">Home</a></li>';
			$breadcrumb .= '<li class="active" style="color:black">' . $forum->title . '</li>';
			$breadcrumb .= '</ol>';
			
			foreach ($topics as $topic) {
				
				$topic->author                  = $this->user_model->get_username_from_user_id($topic->user_id);
				$topic->permalink               = $slug . '/' . $topic->slug;
				$topic->posts                   = $this->forum_model->get_posts($topic->id);
				$topic->count_posts             = count($topic->posts);
				$topic->latest_post             = $this->forum_model->get_topic_latest_post($topic->id);
				$topic->latest_post->author     = $this->user_model->get_username_from_user_id($topic->latest_post->user_id);
				
			}
			
			// assignar objetos creados a los data object
			$data->forum      = $forum;
			$data->topics     = $topics;
			$data->breadcrumb = $breadcrumb;
			
			// carga vistas y envia data
			$this->load->view('header');
			$this->load->view('forum/single', $data);
			$this->load->view('footer');
			
		}
		
	}	
	
	/**
	 * create function.
	 * 
	 * @access public
	 * @return void
	 */
	public function create_forum() {
		
		// crea objetos data
		$data = new stdClass();
		
		// Si el usuario no esta logueado como admin, no puede crear un nuevo foro
		if (!isset($_SESSION['is_admin']) || $_SESSION['is_admin'] !== true) {
			$data->login_as_admin_needed = true;
		} else {
			$data->login_as_admin_needed = false;
		}
		
		// crear breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url() . '">Home</a></li>';
		$breadcrumb .= '<li class="active" style="color:black">Crear un nuevo foro</li>';
		$breadcrumb .= '</ol>';
		
		// asignar breadcrumb a el objeto data
		$data->breadcrumb = $breadcrumb;
		
		// cargar el helper y la libreria de validacion
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// especificar las reglas
		$this->form_validation->set_rules('title', 'Forum Title', 'trim|required|min_length[4]|max_length[255]|is_unique[forums.title]', array('is_unique' => 'El titulo que has propuesto ya existe, piensa otro!'));
		$this->form_validation->set_rules('description', 'Description', 'trim|max_length[80]');
		
		if ($this->form_validation->run() === false) {
			
			// mantener los datos que el usuario habia puesto en los campos
			$data->title       = $this->input->post('title');
			$data->description = $this->input->post('description');
			
			// la validacion no es correcta, envia errores a la vista
			$this->load->view('header');
			$this->load->view('forum/create/create', $data);
			$this->load->view('footer');
			
		} else {
			
			// concreta variables del formulario
			$title       = $this->input->post('title');
			$description = $this->input->post('description');
			
			if ($this->forum_model->create_forum($title, $description)) {
				
				// creacion del foro ok
				$this->load->view('header');
				$this->load->view('forum/create/create_success', $data);
				$this->load->view('footer');
				
			} else {
				
				// creacion del foro fallida, esto no deberia pasar
				$data->error = 'Wops! Ocurrió un problema creando el foro, intentalo de nuevo.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('forum/create/create', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
	/**
	 * create_topic function.
	 * 
	 * @access public
	 * @param string $forum_slug
	 * @return void
	 */
	public function create_topic($forum_slug) {
		
		// create the data object
		$data = new stdClass();
		
		// Si el usuario no esta logueado, no puede crear subforos
		if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
			$data->login_needed = true;
		} else {
			$data->login_needed = false;
		}
		
		// especificar variables de la URI
		$forum_slug = $this->uri->segment(1);
		$forum_id   = $this->forum_model->get_forum_id_from_forum_slug($forum_slug);
		$forum      = $this->forum_model->get_forum($forum_id);
		
		// crear breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li><a href="' . base_url() . '">Home</a></li>';
		$breadcrumb .= '<li style="color:black"><a href="' . base_url("index.php/".$forum->slug) . '">' . $forum->title . '</a></li>';
		$breadcrumb .= '<li class="active" style="color:black">Crear un nuevo subforo</li>';
		$breadcrumb .= '</ol>';
		
		// asignar breadcrumb al objeto data
		$data->breadcrumb = $breadcrumb;
		
		// cargar helper y libreria de validacion
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// especificar reglas
		$this->form_validation->set_rules('title', 'Topic Title', 'trim|required|min_length[4]|max_length[255]|is_unique[topics.title]', array('is_unique' => 'El subforo que has intentado crear ya existe, intentalo de nuevo cambiando algo!'));
		$this->form_validation->set_rules('content', 'Content', 'required|min_length[4]');
		
		if ($this->form_validation->run() === false) {
			
			// mantener los datos que el usuario habia puesto en los campos
			$data->title   = $this->input->post('title');
			$data->content = $this->input->post('content');
			
			// validacion no ok, enviar errores de validación a la vista
			$this->load->view('header');
			$this->load->view('topic/create/create', $data);
			$this->load->view('footer');
			
		} else {
			
			// especificar variables del formulario
			$title   = $this->input->post('title');
			$content = $this->input->post('content');
			$user_id = $_SESSION['user_id'];
			
			if ($this->forum_model->create_topic($forum_id, $title, $content, $user_id)) {
				
				// creación del subforo ok
				redirect("https://knect.asir6.enganxat.net/index.php/".$forum_slug . '/' . strtolower(url_title($title)));
				
			} else {
				
				// error al crear el subforo, esto no debería pasar
				$data->error = 'Wops! Hubo un problema creando el subforo, intentalo de nuevo.';
				
				// envia errores a la vista
				$this->load->view('header');
				$this->load->view('topic/create/create', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
	/**
	 * topic function.
	 * 
	 * @access public
	 * @param string $forum_slug
	 * @param string $topic_slug
	 * @return void
	 */
	public function topic($forum_slug, $topic_slug) {
		
		// crear objetos data
		$data = new stdClass();
		
		// coger ids de slugs
		$forum_id = $this->forum_model->get_forum_id_from_forum_slug($forum_slug);
		$topic_id = $this->forum_model->get_topic_id_from_topic_slug($topic_slug);
		
		// crear objetos
		$forum = $this->forum_model->get_forum($forum_id);
		$topic = $this->forum_model->get_topic($topic_id);
		$posts = $this->forum_model->get_posts($topic_id);
		
		foreach ($posts as $post) {
			
			$post->author = $this->user_model->get_username_from_user_id($post->user_id);
			
		}
		
		// crear breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li style="color:black"><a href="' . base_url() . '">Home</a></li>';
		$breadcrumb .= '<li style="color:black"><a href="' . base_url("index.php/".$forum->slug) . '">' . $forum->title . '</a></li>';
		$breadcrumb .= '<li class="active" style="color:black">' . $topic->title . '</li>';
		$breadcrumb .= '</ol>';
		
		// asignar obejos a los objetos data
		$data->forum      = $forum;
		$data->topic      = $topic;
		$data->posts      = $posts;
		$data->breadcrumb = $breadcrumb;
		
		// cargar vistas y enviar data
		$this->load->view('header');
		$this->load->view('topic/single', $data);
		$this->load->view('footer');
		
	}
	
	/**
	 * create_post function.
	 * 
	 * @access public
	 * @param string $forum_slug
	 * @param string $topic_slug
	 * @return void
	 */
	public function create_post($forum_slug, $topic_slug) {
		
		// crear objeto data
		$data = new stdClass();
		
		// si el usuario no esta logueado, no puede postear una respuesta
		if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
			$data->login_needed = true;
		} else {
			$data->login_needed = false;
		}
		
		// coger ids de slugs
		$forum_id = $this->forum_model->get_forum_id_from_forum_slug($forum_slug);
		$topic_id = $this->forum_model->get_topic_id_from_topic_slug($topic_slug);
		
		// crear objetos
		$forum = $this->forum_model->get_forum($forum_id);
		$topic = $this->forum_model->get_topic($topic_id);
		$posts = $this->forum_model->get_posts($topic_id);
		
		foreach ($posts as $post) {
			
			$post->author = $this->user_model->get_username_from_user_id($post->user_id);
			
		}
		
		// create breadcrumb
		$breadcrumb  = '<ol class="breadcrumb">';
		$breadcrumb .= '<li style="color:black"><a href="' . base_url() . '">Home</a></li>';
		$breadcrumb .= '<li style="color:black"><a href="' . base_url("index.php/".$forum->slug) . '">' . $forum->title . '</a></li>';
		$breadcrumb .= '<li class="active" style="color:black">' . $topic->title . '</li>';
		$breadcrumb .= '</ol>';
		
		// assign created objects to the data object
		$data->forum      = $forum;
		$data->topic      = $topic;
		$data->posts      = $posts;
		$data->breadcrumb = $breadcrumb;
		
		// cargar el helper y la libreria de validación
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		// escpecificar las reglas
		$this->form_validation->set_rules('reply', 'Reply', 'required|min_length[2]');
		
		if ($this->form_validation->run() === false) {
			
			// mantener los datos que el usuario habia puesto en los campos
			$data->content = $this->input->post('reply');
			
			// validación no ok, envia erores de validación a la vista
			$this->load->view('header');
			$this->load->view('topic/reply', $data);
			$this->load->view('footer');
			
		} else {
			
			$user_id = $_SESSION['user_id'];
			$content = $this->input->post('reply');
			
			if ($this->forum_model->create_post($topic_id, $user_id, $content)) {
				
				// creación del post ok
				redirect("https://knect.asir6.enganxat.net/index.php/".$forum_slug . '/' . $topic_slug);
                                
				
			} else {
				
				// creación del post fallida
				$data->error = 'Wops! Hubo un problema con tu respuesta, intentalo de nuevo.';
				
				// send error to the view
				$this->load->view('header');
				$this->load->view('topic/reply', $data);
				$this->load->view('footer');
				
			}
			
		}
		
	}
	
}
