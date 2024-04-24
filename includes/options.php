<?php
/**
 * OceanWP Customizer Class
 *
 * @package OceanWP WordPress theme
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$options = [
	'ocean_modal_window_settings' => [
		'title' => __( 'Modal Window', 'ocean-modal-window' ),
		'priority' => 5,
		'options' => [
			'omw_top_quick_links' => [
				'type' => 'ocean-links',
				'label' => 'Quick Menu',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'class' => 'top-quick-links',
				'linkIcon' => 'link-2',
				'titleIcon' => 'three-dot-menu',
				'active_callback' => 'ocean_is_oe_active',
				'links' => [
					'website_layout' => [
						'label' => esc_html__('Website Layout', 'ocean-modal-window'),
						'url' => '#'
					],
					'scroll_top' => [
						'label' => esc_html__('Scroll To Top', 'ocean-modal-window'),
						'url' => '#'
					],
					'pagination' => [
						'label' => esc_html__('Pagination', 'ocean-modal-window'),
						'url' => '#'
					]
				]
			],

			'omw_divider_after_top_quick_links' => [
				'type' => 'ocean-divider',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'top' => 10,
				'bottom' => 10
			],

            'omw_custom_width' => [
                'id'      => 'omw_custom_width',
                'label'    => esc_html__( 'Custom Width', 'ocean-modal-window' ),
                'type'     => 'ocean-range-slider',
                'section'  => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel'    => false,
                'isUnit'       => true,
                'isResponsive' => true,
                'min'          => 200,
                'max'          => 1200,
                'step'         => 1,
                'setting_args' => [
                    'desktop' => [
                        'id' => 'omw_custom_width',
                        'label' => 'Desktop',
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 700,
                        ],
                    ],
                    'tablet' => [
                        'id' => 'omw_tablet_custom_width',
                        'label' => esc_html__( 'Tablet', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 700,
                        ],
                    ],
                    'mobile' => [
                        'id' => 'omw_mobile_custom_width',
                        'label' => esc_html__( 'Mobile', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 700,
                        ],
                    ],
                    'unit' => [
                        'id' => 'omw_custom_width_unit',
                        'label' => 'Unit',
                        'attr' => [
                            'transport' => 'postMessage',
                            'default' => 'px',
                        ],
                    ],
                ],
                'preview' => 'queryWithType',
                'css' => [
                    '.omw-modal' => 'width'
                ]
            ],

            'omw_custom_height' => [
                'id'      => 'omw_custom_height',
                'label'    => esc_html__( 'Custom Height', 'ocean-modal-window' ),
                'type'     => 'ocean-range-slider',
                'section'  => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel'    => false,
                'isUnit'       => true,
                'isResponsive' => true,
                'min'          => 0,
                'max'          => 1200,
                'step'         => 1,
                'setting_args' => [
                    'desktop' => [
                        'id' => 'omw_custom_height',
                        'label' => 'Desktop',
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 0,
                        ],
                    ],
                    'tablet' => [
                        'id' => 'omw_tablet_custom_height',
                        'label' => esc_html__( 'Tablet', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 0,
                        ],
                    ],
                    'mobile' => [
                        'id' => 'omw_mobile_custom_height',
                        'label' => esc_html__( 'Mobile', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 0,
                        ],
                    ],
                    'unit' => [
                        'id' => 'omw_custom_height_unit',
                        'label' => 'Unit',
                        'attr' => [
                            'transport' => 'postMessage',
                            'default' => 'px',
                        ],
                    ],
                ],
                'preview' => 'queryWithType',
                'css' => [
                    '.omw-modal' => 'height'
                ]
            ],

            'omw_divider_after_custom_height' => [
				'type' => 'ocean-divider',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'top' => 10,
				'bottom' => 10
			],

            'omw_padding' => [
                'id' => 'omw_padding',
                'label'    => esc_html__( 'Padding (px)', 'ocean-modal-window' ),
                'type'     => 'ocean-spacing',
                'section'  => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel'    => false,
                'isType'       => 'padding',
                'setting_args' => [
                    'spacingTop' => [
                        'id' => 'omw_top_padding',
                        'label' => esc_html__( 'Top', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRight' => [
                        'id' => 'omw_right_padding',
                        'label' => esc_html__( 'Right', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottom' => [
                        'id' => 'omw_bottom_padding',
                        'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeft' => [
                        'id' => 'omw_left_padding',
                        'label' => esc_html__( 'Left', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingTopTablet' => [
                        'id' => 'omw_tablet_top_padding',
                        'label' => esc_html__( 'Top', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRightTablet' => [
                        'id' => 'omw_tablet_right_padding',
                        'label' => esc_html__( 'Right', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottomTablet' => [
                        'id' => 'omw_tablet_bottom_padding',
                        'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeftTablet' => [
                        'id' => 'omw_tablet_left_padding',
                        'label' => esc_html__( 'Left', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingTopMobile' => [
                        'id' => 'omw_mobile_top_padding',
                        'label' => esc_html__( 'Top', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRightMobile' => [
                        'id' => 'omw_mobile_right_padding',
                        'label' => esc_html__( 'Right', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottomMobile' => [
                        'id' => 'omw_mobile_bottom_padding',
                        'label' => esc_html__( 'Bottom', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeftMobile' => [
                        'id' => 'omw_mobile_left_padding',
                        'label' => esc_html__( 'Left', 'ocean-modal-window' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                ],
                'preview' => 'queryWithType',
                'css' => [
                    'selector' => '.omw-modal',
                    'property' => 'padding'
                ]
            ],

            'omw_divider_after_padding' => [
				'type' => 'ocean-divider',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'top' => 10,
				'bottom' => 10
			],

            'omw_background_image' => [
                'label' => esc_html__( 'Background Image', 'oceanwp' ),
                'type' => 'ocean-image',
                'section'  => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'mediaType' => 'image',
            ],

            'omw_divider_after_background_image' => [
				'type' => 'ocean-divider',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'top' => 10,
				'bottom' => 10
			],

            'omw_border_type' => [
                'id' => 'omw_border_type',
                'type' => 'ocean-select',
                'label' => esc_html__('Border Style', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'default' => 'solid',
                'priority' => 10,
                'hideLabel' => false,
                'multiple' => false,
                'choices' => [
                    'solid' 		=> esc_html__( 'Solid', 'oceanwp' ),
                    'double' 		=> esc_html__( 'Double', 'oceanwp' ),
                    'dashed' 		=> esc_html__( 'Dashed', 'oceanwp' ),
                    'dotted' 		=> esc_html__( 'Dotted', 'oceanwp' ),
                ],
                'preview' => 'queryWithAttr',
                'css' => [
                    'selector' => '.omw-modal',
                    'property' => 'border-style'
                ]
            ],

            'omw_border_width' => [
                'id' => 'omw_border_width',
                'label'    => esc_html__( 'Border Width (px)', 'oceanwp' ),
                'type'     => 'ocean-spacing',
                'section'  => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'isResponsive' => false,
                'hideLabel'    => false,
                'isType'       => 'border-width',
                'setting_args' => [
                    'spacingTop' => [
                        'id' => 'omw_top_border_width',
                        'label' => esc_html__( 'Top', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRight' => [
                        'id' => 'omw_right_border_width',
                        'label' => esc_html__( 'Right', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottom' => [
                        'id' => 'omw_bottom_border_width',
                        'label' => esc_html__( 'Bottom', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeft' => [
                        'id' => 'omw_left_border_width',
                        'label' => esc_html__( 'Left', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingTopTablet' => [
                        'id' => 'omw_tablet_top_border_width',
                        'label' => esc_html__( 'Top', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRightTablet' => [
                        'id' => 'omw_tablet_right_border_width',
                        'label' => esc_html__( 'Right', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottomTablet' => [
                        'id' => 'omw_tablet_bottom_border_width',
                        'label' => esc_html__( 'Bottom', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeftTablet' => [
                        'id' => 'omw_tablet_left_border_width',
                        'label' => esc_html__( 'Left', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingTopMobile' => [
                        'id' => 'omw_mobile_top_border_width',
                        'label' => esc_html__( 'Top', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRightMobile' => [
                        'id' => 'omw_mobile_right_border_width',
                        'label' => esc_html__( 'Right', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottomMobile' => [
                        'id' => 'omw_mobile_right_border_width',
                        'label' => esc_html__( 'Bottom', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeftMobile' => [
                        'id' => 'omw_mobile_left_border_width',
                        'label' => esc_html__( 'Left', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                ],
                'preview' => 'queryWithType',
                'css' => [
                    'selector' => '.omw-modal',
                    'property' => 'border-width'
                ],
            ],

            'omw_border_radius' => [
                'id' => 'omw_border_radius',
                'label'    => esc_html__( 'Border Radius (px)', 'oceanwp' ),
                'type'     => 'ocean-spacing',
                'section'  => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel'    => false,
                'isType'       => 'border-radius',
                'setting_args' => [
                    'spacingTop' => [
                        'id' => 'omw_top_border_radius',
                        'label' => esc_html__( 'Top', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRight' => [
                        'id' => 'omw_right_border_radius',
                        'label' => esc_html__( 'Right', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottom' => [
                        'id' => 'omw_bottom_border_radius',
                        'label' => esc_html__( 'Bottom', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeft' => [
                        'id' => 'omw_left_border_radius',
                        'label' => esc_html__( 'Left', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingTopTablet' => [
                        'id' => 'omw_tablet_top_border_radius',
                        'label' => esc_html__( 'Top', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRightTablet' => [
                        'id' => 'omw_tablet_right_border_radius',
                        'label' => esc_html__( 'Right', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottomTablet' => [
                        'id' => 'omw_tablet_bottom_border_radius',
                        'label' => esc_html__( 'Bottom', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeftTablet' => [
                        'id' => 'omw_tablet_left_border_radius',
                        'label' => esc_html__( 'Left', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingTopMobile' => [
                        'id' => 'omw_mobile_top_border_radius',
                        'label' => esc_html__( 'Top', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingRightMobile' => [
                        'id' => 'omw_mobile_right_border_radius',
                        'label' => esc_html__( 'Right', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingBottomMobile' => [
                        'id' => 'omw_mobile_right_border_radius',
                        'label' => esc_html__( 'Bottom', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'spacingLeftMobile' => [
                        'id' => 'omw_mobile_left_border_radius',
                        'label' => esc_html__( 'Left', 'oceanwp' ),
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                ],
                'preview' => 'queryWithType',
                'css' => [
                    'selector' => '.omw-modal',
                    'property' => 'border-radius'
                ],
            ],

            'omw_divider_after_border_radius' => [
				'type' => 'ocean-divider',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'top' => 10,
				'bottom' => 10
			],

            'omw_typography' => [
                'id' => 'omw_typography',
                'type' => 'ocean-typography',
                'label' => esc_html__('Typography', 'oceanwp'),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'selector' => '.omw-modal',
                'setting_args' => [
                    'fontFamily' => [
                        'id' => 'omw_font_family',
                        'label' => 'Font Family',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontWeight' => [
                        'id' => 'omw_font_weight',
                        'label' => 'Font Weight',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontWeightTablet' => [
                        'id' => 'omw_tablet_font_weight',
                        'label' => 'Font Weight',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontWeightMobile' => [
                        'id' => 'omw_mobile_font_weight',
                        'label' => 'Font Weight',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontSubset' => [
                        'id' => 'omw_font_subset',
                        'label' => 'Font Subset',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontSize' => [
                        'id' => 'omw_font_size',
                        'label' => 'Font Size',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontSizeTablet' => [
                        'id' => 'omw_tablet_font_size',
                        'label' => 'Font Size',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontSizeMobile' => [
                        'id' => 'omw_mobile_font_size',
                        'label' => 'Font Size',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'fontSizeUnit' => [
                        'id' => 'omw_font_size_unit',
                        'label' => 'Unit',
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 'px'
                        ],
                    ],
                    'letterSpacing' => [
                        'id' => 'omw_letter_spacing',
                        'label' => 'Letter Spacing',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'letterSpacingTablet' => [
                        'id' => 'omw_tablet_letter_spacing',
                        'label' => 'Letter Spacing',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'letterSpacingMobile' => [
                        'id' => 'omw_mobile_letter_spacing',
                        'label' => 'Letter Spacing',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'letterSpacingUnit' => [
                        'id' => 'omw_letter_spacing_unit',
                        'label' => 'Unit',
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 'px'
                        ],
                    ],
                    'lineHeight' => [
                        'id' => 'omw_line_height',
                        'label' => 'Line Height',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'lineHeightTablet' => [
                        'id' => 'omw_tablet_line_height',
                        'label' => 'Line Height',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'lineHeightMobile' => [
                        'id' => 'omw_mobile_line_height',
                        'label' => 'Line Height',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'lineHeightUnit' => [
                        'id' => 'omw_line_height_unit',
                        'label' => 'Unit',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'textTransform' => [
                        'id' => 'omw_text_transform',
                        'label' => 'Text Transform',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'textTransformTablet' => [
                        'id' => 'omw_tablet_text_transform',
                        'label' => 'Text Transform',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'textTransformMobile' => [
                        'id' => 'omw_mobile_text_transform',
                        'label' => 'Text Transform',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'textDecoration' => [
                        'id' => 'omw_text_decoration',
                        'label' => 'Text Decoration',
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                ]
            ],

            'omw_divider_after_typography' => [
				'type' => 'ocean-divider',
				'section' => 'ocean_modal_window_settings',
				'transport' => 'postMessage',
				'priority' => 10,
				'top' => 1,
				'bottom' => 10
			],

            'omw_overlay_bg' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Overlay Background', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_overlay_bg',
                        'key' => 'normal',
                        'label' => esc_html__( 'Select Color', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal-overlay' => 'background-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => 'rgb(0 0 0 / 50%)',
                        ],
                    ]
                ]
            ],

            'omw_modal_bg' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Background Color', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_modal_bg',
                        'key' => 'normal',
                        'label' => esc_html__( 'Select Color', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal' => 'background-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => '#ffffff',
                        ],
                    ]
                ]
            ],

            'omw_modal_border_color' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Border Color', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_modal_border_color',
                        'key' => 'normal',
                        'label' => esc_html__( 'Select Color', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal' => 'border-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ]
                ]
            ],

            'omw_modal_text_color' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Text Color', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_modal_text_color',
                        'key' => 'normal',
                        'label' => esc_html__( 'Select Color', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal' => 'color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ]
                ]
            ],

            'omw_modal_title_color' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Title Color', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_modal_title_color',
                        'key' => 'normal',
                        'label' => esc_html__( 'Select Color', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal .omw-modal-title' => 'color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                            'default'   => '#333333',
                        ],
                    ]
                ]
            ],

            'omw_modal_close_btn_bg' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Close Button Background', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_modal_close_btn_bg',
                        'key' => 'normal',
                        'label' => esc_html__( 'Normal', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal .omw-close-modal' => 'background-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'hover' => [
                        'id' => 'omw_modal_close_btn_hover_bg',
                        'key' => 'hover',
                        'label' => esc_html__( 'Hover', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal .omw-close-modal:hover' => 'background-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ]
                ]
            ],

            'omw_modal_close_btn_color' => [
                'type' => 'ocean-color',
                'label' => esc_html__( 'Close Button Color', 'oceanwp' ),
                'section' => 'ocean_modal_window_settings',
                'transport' => 'postMessage',
                'priority' => 10,
                'hideLabel' => false,
                'showAlpha' => true,
                'showPalette' => true,
                'setting_args' => [
                    'normal' => [
                        'id' => 'omw_modal_close_btn_color',
                        'key' => 'normal',
                        'label' => esc_html__( 'Normal', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal .omw-close-modal:before,.omw-modal .omw-close-modal:after' => 'background-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ],
                    'hover' => [
                        'id' => 'omw_modal_close_btn_hover_color',
                        'key' => 'hover',
                        'label' => esc_html__( 'Hover', 'oceanwp' ),
                        'selector' => [
                            '.omw-modal .omw-close-modal:hover:before,.omw-modal .omw-close-modal:hover:after' => 'background-color'
                        ],
                        'attr' => [
                            'transport' => 'postMessage',
                        ],
                    ]
                ]
            ],

        ]
    ]
];
