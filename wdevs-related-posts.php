<?php
/*
Plugin Name: wDevs Related Posts
Description: Show related posts below single post content section
Version:     1.0.0
Author:      Md. Abdul Hannan
Author URI:  #
Text Domain: wdevs
Domain Path: /languages
*/

defined( 'ABSPATH' ) or die;

/**
 * Define required constants
 */
define( 'WDEVS_VER', '1.0.0' );
define( 'WDEVS_URL', plugins_url('', __FILE__) );
define( 'WDEVS_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WDEVS_URL_ASSETS', WDEVS_URL . '/assets' );

/**
 * Class Wdevs_Related_Posts
 */
if ( ! class_exists( 'Wdevs_Related_Posts' ) ) {
    class Wdevs_Related_Posts {
        /**
		 * Properties
		 */
        private static $instance = null;

        /**
		 * Instance
		 */
        public static function get_instance() {
			if ( self::$instance == null ) {
				self::$instance = new self();
			}
			return self::$instance;
		}

        /**
		 * Constructors
		 */
        public function __construct() {
            // Actions
			add_action( 'wp_loaded', array( $this, 'initialize_features' ) );
            add_action( 'wp_enqueue_scripts', array( $this, 'wp_enqueue_frontend_assets' ) );
        }

        /**
		 * Initialize features
		 */
		public function initialize_features() {
			load_plugin_textdomain( 'wdevs', false, dirname( plugin_basename( __FILE__ ) ) . '/languages' );
		}

        /**
		 * Enqueue frontend assets
		 */
		public function wp_enqueue_frontend_assets( ) {
			wp_enqueue_style( 'wdevs-style', WDEVS_URL_ASSETS . '/css/frontend.css', array(), WDEVS_VER, 'all' );
			wp_enqueue_script( 'wdevs-script', WDEVS_URL_ASSETS . '/js/frontend.js', array( 'jquery' ), WDEVS_VER, true );
		}

    }

    /**
	 * Instantiate
	 */
	$Wdevs_Related_Posts = new Wdevs_Related_Posts();
	$Wdevs_Related_Posts->get_instance();

	/**
	 * Include php files
	 */
	require_once( __DIR__ . '/inc/functions.php');
}
