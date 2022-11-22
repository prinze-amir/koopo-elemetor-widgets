<?php
namespace KoopoWidgets\Modules\DynamicTags\Tags;

use Elementor\Controls_Manager;
use KoopoWidgets\Modules\DynamicTags\Tags\Base\Data_Tag;
use KoopoWidgets\Modules\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Post_Featured_Image extends Data_Tag {

	public function get_name() {
		return 'post-featured-image';
	}

	public function get_group() {
		return Module::POST_GROUP;
	}

	public function get_categories() {
		return [ Module::IMAGE_CATEGORY ];
	}

	public function get_title() {
		return __( 'Featured Image', 'elementor-pro' );
	}

	public function get_value( array $options = [] ) {
		global $post;

		$img = get_post_meta( $post->ID, 'wyz_offers_image_id', true );

		$thumbnail_id = get_post_thumbnail_id();

		if ('wyz_offers' == $post->post_type ){

			$thumbnail_id = $img;
		}
		
		if ( $thumbnail_id ) {
			$image_data = [
				'id' => $thumbnail_id,
				'url' => wp_get_attachment_image_src( $thumbnail_id, 'full' )[0],
			];
		} else {
			$image_data = $this->get_settings( 'fallback' );
		}

		return $image_data;
	}

	protected function _register_controls() {
		$this->add_control(
			'fallback',
			[
				'label' => __( 'Fallback', 'elementor-pro' ),
				'type' => Controls_Manager::MEDIA,
			]
		);
	}
}
