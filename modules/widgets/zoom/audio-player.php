<?php
namespace KoopoWidgets\Modules\Widgets\Zoom;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Core\Schemes;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;
use Elementor\Group_Control_Background;
use Elementor\Modules\DynamicTags\Module as TagsModule;

/**
 * Elementor image widget.
 *
 * Elementor widget that displays an image into the page.
 *
 * @since 1.0.0
 */
class AudioPlayer extends Widget_Base {

    /**
	 * Current instance.
	 *
	 * @access protected
	 *
	 * @var array
	 */
	protected $_current_instance = [];
	/**
	 * Get widget name.
	 *
	 * Retrieve image widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'audio-player';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve image widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget title.
	 */
	public function get_title() {
		return __( 'Audio Player', 'elementor' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve image widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-headphones';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the image widget belongs to.
	 *
	 * Used to determine where to display the widget in the editor.
	 *
	 * @since 2.0.0
	 * @access public
	 *
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'koopo-widgets' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the widget belongs to.
	 *
	 * @since 2.1.0
	 * @access public
	 *
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'audio', 'player', 'soundcloud', 'embed' ];
	}

	/**
	 * Register image widget controls.
	 *
	 * Adds different input fields to allow the user to change and customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function _register_controls() {
		$this->start_controls_section(
			'section_audio',
			[
				'label' => __( 'Audio Player', 'elementor' ),
			]
		);

        $this->add_control(
			'link',
			[
				'label' => __( 'Link', 'elementor' ),
				'type' => Controls_Manager::URL,
				'dynamic' => [
					'active' => true,
					'categories' => [
						TagsModule::POST_META_CATEGORY,
						TagsModule::URL_CATEGORY,
					],
				],
				'default' => [
					'url' => '',
				],
				'options' => false,
			]
		);

		$this->add_control(
			'visual',
			[
				'label' => __( 'Visual Player', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'no',
				'options' => [
					'yes' => __( 'Yes', 'elementor' ),
					'no' => __( 'No', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'config',
			[
				'label' => __( 'Audio Player Style', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'skinwave-full',
				'options' => [
					'skinwave-full' => __( 'Full Wave', 'elementor' ),
					'basic-wave' => __( 'Basic Wave', 'elementor' ),
					'footer-player' => __( 'Footer', 'elementor' ),
					'skinwave-full' => __( 'Full Wave', 'elementor' ),
					'skinwave-with-buttons' => __( 'Skin Wave w/buttons', 'elementor' ),
					'image-and-button' => __( 'Image Overlay' ),
					'button-only'  => __( 'Button Only'),
				],
			]
		);

		$this->add_control(
			'player_options',
			[
				'label' => __( 'Player Options', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		); 

		$this->add_control(
			'play_in_footer',
			[
				'label' => __( 'Play In Footer', 'elementor' ),
				'type' => Controls_Manager::SELECT,
				'default' => 'default',
				'options' => [
					'default' => __( 'Default', 'elementor' ),
					'off' => __( 'Off', 'elementor' ),
					'on' => __( 'On', 'elementor' ),
				],
			]
		);

		$this->add_control(
			'show_likes',
			[
				'label' => __( 'Show Likes', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_rating',
			[
				'label' => __( 'Show Rating', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_download',
			[
				'label' => __( 'Show Download', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_plays',
			[
				'label' => __( 'Show Play Count', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_artist',
			[
				'label' => __( 'Show Artist', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_title',
			[
				'label' => __( 'Show Title', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'show_image',
			[
				'label' => __( 'Show Image', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		//above is zoom options

		$this->add_control(
			'sc_options',
			[
				'label' => __( 'SoundCloud Options', 'elementor' ),
				'type' => Controls_Manager::HEADING,
				'separator' => 'before',
			]
		);

		$this->add_control(
			'sc_auto_play',
			[
				'label' => __( 'Autoplay', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
			]
		);

		$this->add_control(
			'sc_buying',
			[
				'label' => __( 'Buy Button', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_liking',
			[
				'label' => __( 'Like Button', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_download',
			[
				'label' => __( 'Download Button', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_show_artwork',
			[
				'label' => __( 'Artwork', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
				'condition' => [
					'visual' => 'no',
				],
			]
		);

		$this->add_control(
			'sc_sharing',
			[
				'label' => __( 'Share Button', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_show_comments',
			[
				'label' => __( 'Comments', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_show_playcount',
			[
				'label' => __( 'Play Counts', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_show_user',
			[
				'label' => __( 'Username', 'elementor' ),
				'type' => Controls_Manager::SWITCHER,
				'label_off' => __( 'Hide', 'elementor' ),
				'label_on' => __( 'Show', 'elementor' ),
				'default' => 'yes',
			]
		);

		$this->add_control(
			'sc_color',
			[
				'label' => __( 'Controls Color', 'elementor' ),
				'type' => Controls_Manager::COLOR,
			]
		);

		$this->add_control(
			'view',
			[
				'label' => __( 'View', 'elementor' ),
				'type' => Controls_Manager::HIDDEN,
				'default' => 'soundcloud',
			]
		);

		$this->end_controls_section();

	}
	

	/**
	 * Render image widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
        $settings = $this->get_settings_for_display();

        if ( empty( $settings['link'] ) ) {
			return;
		}
		global $post;
		$track_type = get_post_meta($post->ID, 'dzsap_meta_type', true);
		if ($track_type == 'soundcloud') {
		$this->_current_instance = $settings;

		add_filter( 'oembed_result', [ $this, 'filter_oembed_result' ], 50, 3 );
		$video_html = wp_oembed_get( $settings['link']['url'], wp_embed_defaults() );
		remove_filter( 'oembed_result', [ $this, 'filter_oembed_result' ], 50 );

		if ( $video_html ) : ?>
			<div class="elementor-soundcloud-wrapper">
				<?php echo $video_html; ?>
			</div>
			<?php
		endif;
	} else {
		$config = $settings['config'];
		$footPlayer = $settings['play_in_footer'];
	//	$footPlayer = get_post_meta($post->ID, 'dzsap_meta_play_in_footer_player', true);
        $trackimg = get_post_meta($post->ID, 'dzsap_meta_item_thumb', true);
        $trackid = get_post_meta($post->ID, 'dzsap_meta_playerid', true);
        $tracksrc = get_post_meta($post->ID, 'dzsap_meta_item_source', true);
        $trackname = get_post_meta($post->ID, 'dzsap_meta_replace_songname', true);
        $artist = get_post_meta($post->ID, 'dzsap_meta_replace_artistname', true);
        $likes = get_post_meta($post->ID, 'dzsap_meta_enable_likes', true);
        $views = get_post_meta($post->ID, 'dzsap_meta_enable_views', true);
        $rating = get_post_meta($post->ID, 'dzsap_meta_enable_rates', true);
        $download = get_post_meta($post->ID, 'dzsap_meta_enable_download_button', true);
        $customlinkon = get_post_meta($post->ID, 'dzsap_meta_download_custom_link_enable', true);
		$customlink = get_post_meta($post->ID, 'dzsap_meta_download_custom_link', true);
		$itunes = get_post_meta($post->ID, 'dzsap_meta_itunes_link', true);


        if (empty($trackname)){
            $trackname = $post->post_title;
        }

        if (empty($artist)){
            $artist = get_the_author();
        }

        if (empty($trackimg)){
            $trackimg = 'https://koopoonline.com/wp-content/uploads/2020/10/default-album-cover-1.jpg';
		} 

		if ($settings['show_artist'] !='yes' ) {
			$artist = '';
		}
		if ($settings['show_likes'] !='yes' ) {
			$likes = 'no';
		}
		if ($settings['show_rating'] !='yes' ) {
			$rating = 'no';
		}
		if ($settings['show_title'] !='yes' ) {
			$trackname = '';
		}
		if ($settings['show_download'] !='yes' ) {
			$download = 'no';
		}
		if ($settings['show_plays'] !='yes' ) {
			$views = 'no';
		}
		if ($settings['show_image'] !='yes' ) {
			$trackimg = '';
		}
		?>
		<div <?php echo $this->get_render_attribute_string( 'wrapper' ); ?>>	
            <?php 
           // echo Group_Control_Image_Size::get_attachment_image_html( $settings ); 
            echo do_shortcode('[zoomsounds_player artistname="'.$artist.'" songname="'.$trackname.'"  type="detect" dzsap_meta_playerid="'.$trackid.'" dzsap_meta_source_attachment_id="'.$trackid.'" source="'.$tracksrc.'" thumb="'.$trackimg.'" config="'.$config.'" enable_likes="'.$likes.'" itunes_link="'.$itunes.'" enable_views="'.$views.'" enable_rates="'.$rating.'" play_in_footer_player="'.$footPlayer.'"  enable_download_button="'.$download.'" download_custom_link_enable="'.$customlinkon.'"]');
            ?>
 
		</div>
		
		<?php
		}
	}
	
	/**
	 * Filter audio widget oEmbed results.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access public
	 *
	 * @param string $html The HTML returned by the oEmbed provider.
	 *
	 * @return string Filtered audio widget oEmbed HTML.
	 */
	public function filter_oembed_result( $html ) {
		$param_keys = [
			'auto_play',
			'buying',
			'liking',
			'download',
			'sharing',
			'show_comments',
			'show_playcount',
			'show_user',
			'show_artwork',
		];

		$params = [];

		foreach ( $param_keys as $param_key ) {
			$params[ $param_key ] = 'yes' === $this->_current_instance[ 'sc_' . $param_key ] ? 'true' : 'false';
		}

		$params['color'] = str_replace( '#', '', $this->_current_instance['sc_color'] );

		preg_match( '/<iframe.*src=\"(.*)\".*><\/iframe>/isU', $html, $matches );

		$url = esc_url( add_query_arg( $params, $matches[1] ) );

		$visual = 'yes' === $this->_current_instance['visual'] ? 'true' : 'false';

		$html = str_replace( [ $matches[1], 'visual=true' ], [ $url, 'visual=' . $visual ], $html );

		if ( 'false' === $visual ) {
			$html = str_replace( 'height="400"', 'height="200"', $html );
		}

		return $html;
	}
}

