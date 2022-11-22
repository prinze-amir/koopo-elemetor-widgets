<?php
namespace KoopoWidgets\Modules\DynamicTags\Tags\KoopoTags;
use Elementor\Controls_Manager;
use KoopoWidgets\Modules\DynamicTags\Tags\Base\Data_Tag;
use KoopoWidgets\Modules\DynamicTags\Module;
use WyzHelpers;
use WyzBusinessPost;
class BizBanner extends Data_Tag {

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
        return 'biz-banner';
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
        return __( 'Biz Banner', 'dokan' );
    }

    /**
     * Tag categories
     *
     * @since 2.9.11
     *
     * @return array
     */
    public function get_categories() {
		return [ Module::IMAGE_CATEGORY ];
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
        $id = $post->ID;
        $business_data = WyzBusinessPost::wyz_get_business_data($id);
        $bannerurl = get_post_meta($id, 'wyz_business_header_image', true);//the image url
        $banner = class_exists('WyzHelpers') ? WyzHelpers::get_image($id, true):$bannerurl;
        $bannerid = get_post_meta($post->ID, 'wyz_business_header_image_id', true);       

		if ( $banner ) {
			$image_data = [
				'id' => $bannerid, 
				'url' => $banner,
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
            ]
        );
    }
}
