<?php

namespace KoopoWidgets\Modules\DynamicTags\Tags\Base;

//use KoopoWidgets\License\API as License_API;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

trait Tag_Trait {

	public function is_editable() {
		return true;
	}
}
