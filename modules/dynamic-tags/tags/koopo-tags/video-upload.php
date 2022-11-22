<?php
namespace KoopoWidgets\Modules\DynamicTags\Tags\KoopoTags;
use Elementor\Controls_Manager;
use KoopoWidgets\Modules\DynamicTags\Tags\Base\Data_Tag;
use KoopoWidgets\Modules\DynamicTags\Module;

class VideoUpload extends Data_Tag {

    /**
     * Class constructor
     *
     * @since 2.9.11
     *
     * @param array $data
     */
    public function __construct( $data = [] ) {
        parent::__construct( $data );
    }

    /**
     * Tag name
     *
     * @since 2.9.11
     *
     * @return string
     */
    public function get_name() {
        return 'video-upload';
    }

    public function get_group() {
		return 'koopo-widgets';
	}
    /**
     * Tag title
     *
     * @since 2.9.11
     *
     * @return string
     */
    public function get_title() {
        return __( 'Video Upload', 'dokan' );
    }

    /**
     * Tag categories
     *
     * @since 2.9.11
     *
     * @return array
     */
    public function get_categories() {
        return ['koopo-widgets' ];
    }

    /**
     * Store profile picture
     *
     * @since 2.9.11
     *
     * @return void
     */
    protected function get_value( array $options = [] ) {
       
        global $post;
        $video = get_post_meta($post->ID, 'kvid_upload', true);
        $videourl = attachment_url_to_postid($video);       

		if ( $video ) {
			$image_data = [
				'id' => $video,
				'url' => $videourl,
			];
		} else {
			$image_data = $this->get_settings( 'fallback' );
		}

		return $image_data;
    }

    /**
     * Register tag controls
     *
     * @since 2.9.11
     *
     * @return void
     */
    protected function _register_controls() {
        $this->add_control(
            'fallback',
            [
                'label' => __( 'Fallback', 'koopo-widgets' ),
               'type' => Controls_Manager::MEDIA,
                'default' => [
                    'url' =>  '',
                ]
            ]
        );
    }
}
