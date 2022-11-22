<?php
namespace KoopoWidgets\Modules\DynamicTags\Tags;

use KoopoWidgets\Modules\DynamicTags\Tags\Base\Data_Tag;
use KoopoWidgets\Core\Utils;
use KoopoWidgets\Modules\DynamicTags\Module;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

class Archive_URL extends Data_Tag {

	public function get_name() {
		return 'archive-url';
	}

	public function get_group() {
		return Module::ARCHIVE_GROUP;
	}

	public function get_categories() {
		return [ Module::URL_CATEGORY ];
	}

	public function get_title() {
		return __( 'Archive URL', 'elementor-pro' );
	}

	public function get_panel_template() {
		return ' ({{ url }})';
	}

	public function get_value( array $options = [] ) {
		return Utils::get_the_archive_url();
	}
}

