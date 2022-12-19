<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class AI_Elementor_Slider_Captcha_Field extends \ElementorPro\Modules\Forms\Fields\Field_Base {

	public function get_type() {
		return 'ai-slider-captcha';
	}

	public function get_name() {
		return 'Slider CAPTCHA';
	}



	public function add_assets_depends( $form ) {
		error_log( "boom\n" );
	}

	public function update_controls( $widget ) {
		$control_data = \ElementorPro\Plugin::elementor()->controls_manager->get_control_from_stack( $widget->get_unique_name(), 'form_fields' );

		if ( is_wp_error( $control_data ) ) {
			 return;
		}

		$control_data['fields']['ai_slc_inner_text'] = [
			'name' => 'dh_min_companies_offer_emails',
			'label' => esc_html__( 'Text', 'elementor-slider-captcha' ),
			'type' => \Elementor\Controls_Manager::TEXT,
			'condition' => [
				'field_type' => $this->get_type(),
			],
			'default' => esc_html__( 'Swipe right if you are not a robot', 'elementor-slider-captcha' ),
			"tabs_wrapper" => "form_fields_tabs",
			"inner_tab" => "form_fields_content_tab",
			"tab" => "content",
		];

		// $control_data['fields']['required']['conditions']['terms'][0]['value'][] = $this->get_type();
		// $control_data['fields']['width']['conditions']['terms'][0]['value'][] = $this->get_type();
		$widget->update_control( 'form_fields', $control_data );
	}

	public function render( $item, $item_index, $form ) {
      echo '<input type="range" min="0" max="100" value="0" autocomplete="off">';
	}

}
new AI_Elementor_Slider_Captcha_Field();