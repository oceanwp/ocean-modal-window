<?php
/**
 * OceanWP Customizer Class: Modal Window
 *
 * @package OceanWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Customizer Options
 */
function omw_customizer_options() {

	$options = [
		'title'    => __( 'Modal Window', 'ocean-modal-window' ),
		'priority' => 15,
		'options'  => [
			'omw_spacer_before_custom_width' => [
				'type'      => 'ocean-spacer',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
			],

			'omw_custom_width' => [
				'id'                => 'omw_custom_width',
				'label'             => esc_html__( 'Custom Width', 'ocean-modal-window' ),
				'type'              => 'ocean-range-slider',
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'isUnit'            => true,
				'isResponsive'      => true,
				'min'               => 200,
				'max'               => 1200,
				'step'              => 1,
				'sanitize_callback' => 'oceanwp_sanitize_number_blank',
				'setting_args'      => [
					'desktop' => [
						'id'    => 'omw_custom_width',
						'label' => esc_html__( 'Desktop', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 700,
						],
					],
					'tablet' => [
						'id'    => 'omw_tablet_custom_width',
						'label' => esc_html__( 'Tablet', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 700,
						],
					],
					'mobile' => [
						'id'    => 'omw_mobile_custom_width',
						'label' => esc_html__( 'Mobile', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 700,
						],
					],
					'unit' => [
						'id'    => 'omw_custom_width_unit',
						'label' => esc_html__( 'Unit', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default' => 'px',
						],
					],
				],
				'preview' => 'queryWithType',
				'css'     => [
					'.omw-modal' => ['width']
				]
			],

			'omw_custom_height' => [
				'id'                => 'omw_custom_height',
				'label'             => esc_html__( 'Custom Height', 'ocean-modal-window' ),
				'type'              => 'ocean-range-slider',
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'isUnit'            => true,
				'isResponsive'      => true,
				'min'               => 0,
				'max'               => 1200,
				'step'              => 1,
				'sanitize_callback' => 'oceanwp_sanitize_number_blank',
				'setting_args'      => [
					'desktop' => [
						'id'    => 'omw_custom_height',
						'label' => esc_html__( 'Desktop', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 0,
						],
					],
					'tablet' => [
						'id'    => 'omw_tablet_custom_height',
						'label' => esc_html__( 'Tablet', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 0,
						],
					],
					'mobile' => [
						'id'    => 'omw_mobile_custom_height',
						'label' => esc_html__( 'Mobile', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 0,
						],
					],
					'unit' => [
						'id'    => 'omw_custom_height_unit',
						'label' => esc_html__( 'Unit', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default' => 'px',
						],
					],
				],
				'preview' => 'queryWithType',
				'css'     => [
					'.omw-modal' => ['height']
				]
			],

			'omw_divider_after_custom_height' => [
				'type'      => 'ocean-divider',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
				'top'       => 10,
				'bottom'    => 10,
			],

			'omw_padding' => [
				'id'           => 'omw_padding',
				'label'        => esc_html__( 'Padding (px)', 'ocean-modal-window' ),
				'type'         => 'ocean-spacing',
				'section'      => 'ocean_modal_window_settings',
				'transport'    => 'postMessage',
				'priority'     => 10,
				'hideLabel'    => false,
				'isType'       => 'padding',
				'setting_args' => [
					'spacingTop' => [
						'id'    => 'omw_top_padding',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRight' => [
						'id'    => 'omw_right_padding',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottom' => [
						'id'    => 'omw_bottom_padding',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeft' => [
						'id'    => 'omw_left_padding',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingTopTablet' => [
						'id'    => 'omw_tablet_top_padding',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRightTablet' => [
						'id'    => 'omw_tablet_right_padding',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottomTablet' => [
						'id'    => 'omw_tablet_bottom_padding',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeftTablet' => [
						'id'    => 'omw_tablet_left_padding',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingTopMobile' => [
						'id'    => 'omw_mobile_top_padding',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRightMobile' => [
						'id'    => 'omw_mobile_right_padding',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottomMobile' => [
						'id'    => 'omw_mobile_bottom_padding',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeftMobile' => [
						'id'    => 'omw_mobile_left_padding',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
				],
				'preview' => 'queryWithType',
				'css'     => [
					'selector' => '.omw-modal',
					'property' => 'padding',
				]
			],

			'omw_divider_after_padding' => [
				'type'      => 'ocean-divider',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
				'top'       => 10,
				'bottom'    => 10,
			],

			'omw_background_image' => [
				'label'     => esc_html__( 'Background Image', 'ocean-modal-window' ),
				'type'      => 'ocean-image',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
				'hideLabel' => false,
				'mediaType' => 'image',
				'savetype'  => 'url',
				'sanitize_callback' => 'ocean_sanitize_image_control'
			],

			'omw_divider_after_background_image' => [
				'type'      => 'ocean-divider',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
				'top'       => 10,
				'bottom'    => 10,
			],

			'omw_border_type' => [
				'id'                => 'omw_border_type',
				'type'              => 'ocean-select',
				'label'             => esc_html__( 'Border Style', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'default'           => 'solid',
				'priority'          => 10,
				'hideLabel'         => false,
				'multiple'          => false,
				'sanitize_callback' => 'sanitize_key',
				'choices'           => [
					'solid'  => esc_html__( 'Solid', 'ocean-modal-window' ),
					'double' => esc_html__( 'Double', 'ocean-modal-window' ),
					'dashed' => esc_html__( 'Dashed', 'ocean-modal-window' ),
					'dotted' => esc_html__( 'Dotted', 'ocean-modal-window' ),
				],
				'preview' => 'queryWithAttr',
				'css'     => [
					'selector' => '.omw-modal',
					'property' => 'border-style',
				]
			],

			'omw_spacer_before_border_width' => [
				'type'      => 'ocean-spacer',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
			],

			'omw_border_width' => [
				'id'           => 'omw_border_width',
				'label'        => esc_html__( 'Border Width (px)', 'ocean-modal-window' ),
				'type'         => 'ocean-spacing',
				'section'      => 'ocean_modal_window_settings',
				'transport'    => 'postMessage',
				'priority'     => 10,
				'isResponsive' => false,
				'hideLabel'    => false,
				'isType'       => 'border-width',
				'setting_args' => [
					'spacingTop' => [
						'id'    => 'omw_top_border_width',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRight' => [
						'id'    => 'omw_right_border_width',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottom' => [
						'id'    => 'omw_bottom_border_width',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeft' => [
						'id'    => 'omw_left_border_width',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingTopTablet' => [
						'id'    => 'omw_tablet_top_border_width',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRightTablet' => [
						'id'    => 'omw_tablet_right_border_width',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottomTablet' => [
						'id'    => 'omw_tablet_bottom_border_width',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeftTablet' => [
						'id'    => 'omw_tablet_left_border_width',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingTopMobile' => [
						'id'    => 'omw_mobile_top_border_width',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRightMobile' => [
						'id'    => 'omw_mobile_right_border_width',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottomMobile' => [
						'id'    => 'omw_mobile_right_border_width',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeftMobile' => [
						'id'    => 'omw_mobile_left_border_width',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
				],
				'preview' => 'queryWithType',
				'css'     => [
					'selector' => '.omw-modal',
					'property' => 'border-width',
				],
			],

			'omw_spacer_before_border_radius' => [
				'type'      => 'ocean-spacer',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
			],

			'omw_border_radius' => [
				'id'           => 'omw_border_radius',
				'label'        => esc_html__( 'Border Radius (px)', 'ocean-modal-window' ),
				'type'         => 'ocean-spacing',
				'section'      => 'ocean_modal_window_settings',
				'transport'    => 'postMessage',
				'priority'     => 10,
				'hideLabel'    => false,
				'isType'       => 'border-radius',
				'setting_args' => [
					'spacingTop' => [
						'id'    => 'omw_top_border_radius',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRight' => [
						'id'    => 'omw_right_border_radius',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottom' => [
						'id'    => 'omw_bottom_border_radius',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeft' => [
						'id'    => 'omw_left_border_radius',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingTopTablet' => [
						'id'    => 'omw_tablet_top_border_radius',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRightTablet' => [
						'id'    => 'omw_tablet_right_border_radius',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottomTablet' => [
						'id'    => 'omw_tablet_bottom_border_radius',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeftTablet' => [
						'id'    => 'omw_tablet_left_border_radius',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingTopMobile' => [
						'id'    => 'omw_mobile_top_border_radius',
						'label' => esc_html__( 'Top', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingRightMobile' => [
						'id'    => 'omw_mobile_right_border_radius',
						'label' => esc_html__( 'Right', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingBottomMobile' => [
						'id'    => 'omw_mobile_right_border_radius',
						'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'spacingLeftMobile' => [
						'id'    => 'omw_mobile_left_border_radius',
						'label' => esc_html__( 'Left', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
				],
				'preview' => 'queryWithType',
				'css'     => [
					'selector' => '.omw-modal',
					'property' => 'border-radius'
				],
			],

			'omw_title_for_typography_and_colors' => [
				'type'      => 'ocean-title',
				'label'     => esc_html__( 'Typography and Colors', 'ocean-modal-window' ),
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
				'top'       => 20,
				'bottom'    => 20,
			],

			'omw_typography' => [
				'id'           => 'omw_typography',
				'type'         => 'ocean-typography',
				'label'        => esc_html__( 'MW Typography', 'ocean-modal-window' ),
				'section'      => 'ocean_modal_window_settings',
				'transport'    => 'postMessage',
				'priority'     => 10,
				'hideLabel'    => false,
				'selector'     => '.omw-modal',
				'setting_args' => [
					'fontFamily' => [
						'id'    => 'omw_font_family',
						'label' => esc_html__( 'Font Family', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontWeight' => [
						'id'    => 'omw_font_weight',
						'label' => esc_html__( 'Font Weight', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontWeightTablet' => [
						'id'    => 'omw_tablet_font_weight',
						'label' => esc_html__( 'Font Weight', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontWeightMobile' => [
						'id'    => 'omw_mobile_font_weight',
						'label' => esc_html__( 'Font Weight', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontSubset' => [
						'id'    => 'omw_font_subset',
						'label' => esc_html__( 'Font Subset', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontSize' => [
						'id'    => 'omw_font_size',
						'label' => esc_html__( 'Font Size', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontSizeTablet' => [
						'id'    => 'omw_tablet_font_size',
						'label' => esc_html__( 'Font Size', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontSizeMobile' => [
						'id'    => 'omw_mobile_font_size',
						'label' => esc_html__( 'Font Size', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'fontSizeUnit' => [
						'id'    => 'omw_font_size_unit',
						'label' => esc_html__( 'Unit', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 'px',
						],
					],
					'letterSpacing' => [
						'id'    => 'omw_letter_spacing',
						'label' => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'letterSpacingTablet' => [
						'id'    => 'omw_tablet_letter_spacing',
						'label' => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'letterSpacingMobile' => [
						'id'    => 'omw_mobile_letter_spacing',
						'label' => esc_html__( 'Letter Spacing', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'letterSpacingUnit' => [
						'id'    => 'omw_letter_spacing_unit',
						'label' => esc_html__( 'Unit', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
							'default'   => 'px',
						],
					],
					'lineHeight' => [
						'id'    => 'omw_line_height',
						'label' => esc_html__( 'Line Height', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'lineHeightTablet' => [
						'id'    => 'omw_tablet_line_height',
						'label' => esc_html__( 'Line Height', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'lineHeightMobile' => [
						'id'    => 'omw_mobile_line_height',
						'label' => esc_html__( 'Line Height', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'lineHeightUnit' => [
						'id'    => 'omw_line_height_unit',
						'label' => esc_html__( 'Unit', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'textTransform' => [
						'id'    => 'omw_text_transform',
						'label' => esc_html__( 'Text Transform', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'textTransformTablet' => [
						'id'    => 'omw_tablet_text_transform',
						'label' => esc_html__( 'Text Transform', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'textTransformMobile' => [
						'id'    => 'omw_mobile_text_transform',
						'label' => esc_html__( 'Text Transform', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
					'textDecoration' => [
						'id'    => 'omw_text_decoration',
						'label' => esc_html__( 'Text Decoration', 'ocean-modal-window' ),
						'attr'  => [
							'transport' => 'postMessage',
						],
					],
				]
			],

			'omw_divider_after_typography' => [
				'type'      => 'ocean-divider',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
				'top'       => 10,
				'bottom'    => 20,
			],

			'omw_overlay_bg' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Overlay Background', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_overlay_bg',
						'key'      => 'normal',
						'label'    => esc_html__( 'Select Color', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal-overlay' => 'background-color',
						],
						'attr'     => [
							'transport' => 'postMessage',
							'default'   => 'rgb(0 0 0 / 50%)',
						],
					]
				]
			],

			'omw_modal_bg' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Background', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_modal_bg',
						'key'      => 'normal',
						'label'    => esc_html__( 'Select Color', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal' => 'background-color',
						],
						'attr'     => [
							'transport' => 'postMessage',
							'default'   => '#ffffff',
						],
					]
				]
			],

			'omw_modal_border_color' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Border', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_modal_border_color',
						'key'      => 'normal',
						'label'    => esc_html__( 'Select Color', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal' => 'border-color'
						],
						'attr'     => [
							'transport' => 'postMessage',
						],
					]
				]
			],

			'omw_modal_text_color' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Text', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_modal_text_color',
						'key'      => 'normal',
						'label'    => esc_html__( 'Select Color', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal' => 'color',
						],
						'attr'     => [
							'transport' => 'postMessage',
						],
					]
				]
			],

			'omw_modal_title_color' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Title', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_modal_title_color',
						'key'      => 'normal',
						'label'    => esc_html__( 'Select Color', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal .omw-modal-title' => 'color',
						],
						'attr'     => [
							'transport' => 'postMessage',
							'default'   => '#333333',
						],
					]
				]
			],

			'omw_modal_close_btn_bg' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Close Bttn Background', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_modal_close_btn_bg',
						'key'      => 'normal',
						'label'    => esc_html__( 'Normal', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal .omw-close-modal' => 'background-color'
						],
						'attr' => [
							'transport' => 'postMessage',
						],
					],
					'hover' => [
						'id'       => 'omw_modal_close_btn_hover_bg',
						'key'      => 'hover',
						'label'    => esc_html__( 'Hover', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal .omw-close-modal:hover' => 'background-color',
						],
						'attr'     => [
							'transport' => 'postMessage',
						],
					]
				]
			],

			'omw_modal_close_btn_color' => [
				'type'              => 'ocean-color',
				'label'             => esc_html__( 'MW Close Button', 'ocean-modal-window' ),
				'section'           => 'ocean_modal_window_settings',
				'transport'         => 'postMessage',
				'priority'          => 10,
				'hideLabel'         => false,
				'showAlpha'         => true,
				'showPalette'       => true,
				'sanitize_callback' => 'wp_kses_post',
				'setting_args'      => [
					'normal' => [
						'id'       => 'omw_modal_close_btn_color',
						'key'      => 'normal',
						'label'    => esc_html__( 'Normal', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal .omw-close-modal:before,.omw-modal .omw-close-modal:after' => 'background-color',
						],
						'attr'     => [
							'transport' => 'postMessage',
						],
					],
					'hover' => [
						'id'       => 'omw_modal_close_btn_hover_color',
						'key'      => 'hover',
						'label'    => esc_html__( 'Hover', 'ocean-modal-window' ),
						'selector' => [
							'.omw-modal .omw-close-modal:hover:before,.omw-modal .omw-close-modal:hover:after' => 'background-color',
						],
						'attr'     => [
							'transport' => 'postMessage',
						],
					]
				]
			],

			'omw_modal_need_help_link' => [
				'type'      => 'ocean-content',
				'isContent' => sprintf( esc_html__( '%1$s Need Help? %2$s', 'ocean-modal-window' ), '<a href="https://docs.oceanwp.org/article/913-customizer-modal-window/" target="_blank">', '</a>' ),
				'class'     => 'need-help',
				'section'   => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority'  => 10,
			]

		]
	];

	return apply_filters( 'omw_customizer_options', $options );

}
