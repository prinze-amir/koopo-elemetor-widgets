<?php
namespace KoopoWidgets;
 
use KoopoWidgets\Core\Modules_Manager;

/**
 * Class Plugin
 *
 * Main Plugin class
 * @since 1.0.0
 */
class Plugin {
 
  /**
   * Instance
   *
   * @since 1.0.0
   * @access private
   * @static
   *
   * @var Plugin The single instance of the class.
   */
  private static $_instance = null;
 	/**
	 * @var GSAP Version
	 */
	public $gsap_version = '2.1.3';
	/**
	 * @var Modules_Manager
	 */
	public $modules_manager;

	public $extensions_manager;


	public function __construct() {

		spl_autoload_register( [ $this, 'autoload' ] );

		add_action( 'elementor/init', [$this, 'on_elementor_init'], 0 );

	}


	public function on_elementor_init() {

		$this->add_actions();

		$this->init_components();

		$this->init_panel_section();

	//	$this->add_includes();

		/**
		 * Elementor Pro init.
		 *
		 * Fires on Elementor Pro init, after Elementor has finished loading but
		 * before any headers are sent.
		 *
		 * @since 1.0.0
		 */
		do_action( 'elementor_koopo/init' );
  }

  /**
   * Instance
   *
   * Ensures only one instance of the class is loaded or can be loaded.
   *
   * @since 1.2.0
   * @access public
   *
   * @return Plugin An instance of the class.
   */
	public static function instance() {
		if ( is_null( self::$_instance ) ) {
		self::$_instance = new self();
		}
			
		return self::$_instance;
	}

	/**
	 * @return \Elementor\Plugin
	 */
	public static function elementor() {
		return \Elementor\Plugin::$instance;
	}

  private function add_actions() {

	add_action( 'elementor/dynamic_tags/register_tags', [ $this, 'register_custom_tags' ] );

    // Register widgets
    add_action( 'elementor/widgets/widgets_registered', [ $this, 'register_widgets' ] );
  }

  public function init_panel_section() {
	\Elementor\Plugin::instance()->elements_manager->add_category(
		'koopo-widgets',
		array( 'title'  => esc_html__( 'Koopo Elementor', 'koopo-widgets' ), ),
		1
	);
}

	/**
	 * Autoload Classes
	 *
	 * @since 1.6.0
	 */
	public function autoload( $class ) {

		if ( 0 !== strpos( $class, __NAMESPACE__ ) ) {
			return;
		}

		$has_class_alias = isset( $this->classes_aliases[ $class ] );

		// Backward Compatibility: Save old class name for set an alias after the new class is loaded
		if ( $has_class_alias ) {
			$class_alias_name = $this->classes_aliases[ $class ];
			$class_to_load = $class_alias_name;
		} else {
			$class_to_load = $class;
		}

		if ( ! class_exists( $class_to_load ) ) {

			$filename = strtolower(
				preg_replace(
					[ '/^' . __NAMESPACE__ . '\\\/', '/([a-z])([A-Z])/', '/_/', '/\\\/' ],
					[ '', '$1-$2', '-', DIRECTORY_SEPARATOR ],
					$class_to_load
				)
			);

			$filename = plugin_dir_path( __FILE__ ) . $filename . '.php';

			if ( is_readable( $filename ) ) {
				include( $filename );
			}
		}

		if ( $has_class_alias ) {
			class_alias( $class_alias_name, $class );
		}
	}

	private function init_components(){

		$this->modules_manager = new Modules_Manager();
	//	$this->extensions_manager = new Extensions_Manager();
	}
 
 
  /**
   * Register Widgets
   *
   * Register new Elementor widgets.
   *
   * @since 1.2.0
   * @access public
   */
  public function register_widgets() {
 
    // Register Widgets
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Modules\Widgets\WeBox() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Modules\Widgets\PostMeta() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Modules\Widgets\Zoom\TrackImage() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Modules\Widgets\Zoom\BannerImage() );
    \Elementor\Plugin::instance()->widgets_manager->register_widget_type( new Modules\Widgets\Zoom\AudioPlayer() );

  }

	/**
     * Register module tags
     *
     * @since 2.9.11
     *
     * @return void
     */
    public function register_custom_tags() {
		$tags = [
			'AudioBanner',
			'AudioThumb',
			'CustomImage',
			'BizBanner'
		];

		$module = \Elementor\Plugin::$instance->dynamic_tags;
		$module->register_group( 'koopo-widgets', [
			'title' => 'Koopo Widgets' 
		] );

		foreach ( $tags as $tag ) {
			$module->register_tag( "\\KoopoWidgets\\Modules\\DynamicTags\\Tags\\KoopoTags\\" .$tag );

		}
  	}
/*
	public function register_controls(){
		
		koopo_include( 'includes/query.php' );
		\Elementor\Plugin::instance()->controls_manager->register_control( 'ee-query', new Control_Query() );

	}
*/
/*	public function register_group_controls() {
		$controls_manager = \Elementor\Plugin::instance()->controls_manager;

		// Include Control Groups
		koopo_include( 'includes/button-effect.php' );
		koopo_include( 'includes/transition.php' );
		
		// Add Control Groups
		$controls_manager->add_group_control( 'effect', new Group_Control_Button_Effect() );
		$controls_manager->add_group_control( 'ee-transition', new Group_Control_Transition() );
  	}
  */
  /**
	 * Check if Woocommerce is installed and active
	 *
	 * @since 1.1.0
	 *
	 * @access public
	 */
	public function is_woocommerce_active() {
		return in_array( 
			'woocommerce/woocommerce.php', 
			apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) 
		);
	}
}
// Instantiate Plugin Class
Plugin::instance();