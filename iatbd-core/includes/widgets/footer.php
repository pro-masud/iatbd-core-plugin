<?php
/**
 * IATBD Footer Widget (Dynamic + Styleable)
 *
 * @since 1.0.0
 */
class Footer extends \Elementor\Widget_Base {

	public function get_name() {
		return 'footer';
	}

	public function get_title() {
		return esc_html__( 'Footer', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'footer', 'iatbd', 'contact', 'links', 'copyright' ];
	}

	/* =====================================================================
	 * HELPERS (controls)
	 * ===================================================================== */

	/** All WordPress menus for select controls. */
	private function get_menu_options() {
		$options = [ '' => esc_html__( '— Select Menu —', 'elementor-test' ) ];
		$menus   = wp_get_nav_menus();
		if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
			foreach ( $menus as $menu ) {
				$options[ $menu->term_id ] = $menu->name;
			}
		}
		return $options;
	}

	/** Registers a "links column" content section (title + custom links or WP menu). */
	private function register_link_column( $prefix, $label, $default_title, $default_links ) {

		$this->start_controls_section( $prefix . '_section', [
			'label' => $label,
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( $prefix . '_show', [
			'label'        => esc_html__( 'Show Column', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( $prefix . '_title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => $default_title,
			'label_block' => true,
			'condition'   => [ $prefix . '_show' => 'yes' ],
		] );

		$this->add_control( $prefix . '_source', [
			'label'     => esc_html__( 'Links Source', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'custom',
			'options'   => [
				'custom' => esc_html__( 'Custom Links', 'elementor-test' ),
				'wp'     => esc_html__( 'WordPress Menu', 'elementor-test' ),
			],
			'condition' => [ $prefix . '_show' => 'yes' ],
		] );

		$this->add_control( $prefix . '_wp_menu', [
			'label'       => esc_html__( 'Select Menu', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'options'     => $this->get_menu_options(),
			'default'     => '',
			'label_block' => true,
			'description' => esc_html__( 'Top-level items of the menu are listed.', 'elementor-test' ),
			'condition'   => [ $prefix . '_show' => 'yes', $prefix . '_source' => 'wp' ],
		] );

		$rep = new \Elementor\Repeater();

		$rep->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Link',
			'label_block' => true,
		] );

		$rep->add_control( 'link', [
			'label'   => esc_html__( 'Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$this->add_control( $prefix . '_links', [
			'label'       => esc_html__( 'Links', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => $default_links,
			'condition'   => [ $prefix . '_show' => 'yes', $prefix . '_source' => 'custom' ],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		/* ------------------------------------------------------------
		 * CONTENT TAB
		 * ------------------------------------------------------------ */

		// ---- Brand column ----
		$this->start_controls_section( 'brand_section', [
			'label' => esc_html__( 'Brand / About', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'logo_type', [
			'label'   => esc_html__( 'Logo Type', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'icon',
			'options' => [
				'icon'  => esc_html__( 'Icon', 'elementor-test' ),
				'image' => esc_html__( 'Image', 'elementor-test' ),
			],
		] );

		$this->add_control( 'logo_icon', [
			'label'     => esc_html__( 'Icon', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::ICONS,
			'default'   => [ 'value' => 'fas fa-microchip', 'library' => 'fa-solid' ],
			'condition' => [ 'logo_type' => 'icon' ],
		] );

		$this->add_control( 'logo_image', [
			'label'     => esc_html__( 'Image', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::MEDIA,
			'default'   => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
			'condition' => [ 'logo_type' => 'image' ],
		] );

		$this->add_control( 'logo_text', [
			'label'       => esc_html__( 'Brand Name', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'IATBD',
			'label_block' => true,
			'separator'   => 'before',
		] );

		$this->add_control( 'logo_link', [
			'label' => esc_html__( 'Brand Link (optional)', 'elementor-test' ),
			'type'  => \Elementor\Controls_Manager::URL,
		] );

		$this->add_control( 'description', [
			'label'     => esc_html__( 'Description', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::TEXTAREA,
			'default'   => 'Industrial automation — PLC, HMI, VFD, Servo and professional service.',
			'rows'      => 4,
			'separator' => 'before',
		] );

		$social = new \Elementor\Repeater();

		$social->add_control( 'icon', [
			'label'   => esc_html__( 'Icon', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [ 'value' => 'fab fa-facebook-f', 'library' => 'fa-brands' ],
		] );

		$social->add_control( 'link', [
			'label'   => esc_html__( 'Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$this->add_control( 'social_links', [
			'label'       => esc_html__( 'Social Icons', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $social->get_controls(),
			'title_field' => esc_html__( 'Social Icon', 'elementor-test' ),
			'default'     => [],
			'separator'   => 'before',
		] );

		$this->end_controls_section();

		// ---- Link columns ----
		$this->register_link_column(
			'col2',
			esc_html__( 'Column 2 (Links)', 'elementor-test' ),
			'Services',
			[
				[ 'title' => 'PLC',   'link' => [ 'url' => 'plc-service.html' ] ],
				[ 'title' => 'Store', 'link' => [ 'url' => 'store-shop.html' ] ],
				[ 'title' => 'HMI',   'link' => [ 'url' => 'hmi-service.html' ] ],
				[ 'title' => 'VFD',   'link' => [ 'url' => '#services' ] ],
				[ 'title' => 'Servo', 'link' => [ 'url' => '#services' ] ],
			]
		);

		$this->register_link_column(
			'col3',
			esc_html__( 'Column 3 (Links)', 'elementor-test' ),
			'Support',
			[
				[ 'title' => 'Maintenance',     'link' => [ 'url' => '#' ] ],
				[ 'title' => 'Troubleshooting', 'link' => [ 'url' => '#' ] ],
				[ 'title' => 'Repairing',       'link' => [ 'url' => '#' ] ],
			]
		);

		// ---- Contact column ----
		$this->start_controls_section( 'contact_section', [
			'label' => esc_html__( 'Column 4 (Contact)', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'contact_show', [
			'label'        => esc_html__( 'Show Column', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'contact_title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Contact',
			'label_block' => true,
			'condition'   => [ 'contact_show' => 'yes' ],
		] );

		$contact = new \Elementor\Repeater();

		$contact->add_control( 'icon', [
			'label'   => esc_html__( 'Icon', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
		] );

		$contact->add_control( 'text', [
			'label'       => esc_html__( 'Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Contact info',
			'label_block' => true,
		] );

		$contact->add_control( 'link', [
			'label'       => esc_html__( 'Link (optional)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::URL,
			'placeholder' => 'tel:+8801XXXXXXXXX  or  mailto:info@iatbd.com',
			'options'     => false,
		] );

		$this->add_control( 'contact_items', [
			'label'       => esc_html__( 'Contact Items', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $contact->get_controls(),
			'title_field' => '{{{ text }}}',
			'condition'   => [ 'contact_show' => 'yes' ],
			'default'     => [
				[
					'icon' => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
					'text' => '+880 1XXX-XXXXXX',
				],
				[
					'icon' => [ 'value' => 'fas fa-envelope', 'library' => 'fa-solid' ],
					'text' => 'info@iatbd.com',
				],
			],
		] );

		$this->end_controls_section();

		// ---- Bottom bar ----
		$this->start_controls_section( 'bottom_section', [
			'label' => esc_html__( 'Bottom Bar', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_bottom', [
			'label'        => esc_html__( 'Show Bottom Bar', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'copyright', [
			'label'       => esc_html__( 'Copyright Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => '© {year} IATBD. All rights reserved.',
			'description' => esc_html__( 'Use {year} for the current year (auto-updates).', 'elementor-test' ),
			'condition'   => [ 'show_bottom' => 'yes' ],
		] );

		$this->add_control( 'show_bottom_link', [
			'label'        => esc_html__( 'Show Right Link', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'show_bottom' => 'yes' ],
		] );

		$this->add_control( 'bottom_link_text', [
			'label'     => esc_html__( 'Right Link Text', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => '← Home',
			'condition' => [ 'show_bottom' => 'yes', 'show_bottom_link' => 'yes' ],
		] );

		$this->add_control( 'bottom_link', [
			'label'     => esc_html__( 'Right Link URL', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::URL,
			'default'   => [ 'url' => '#' ],
			'condition' => [ 'show_bottom' => 'yes', 'show_bottom_link' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ------------------------------------------------------------
		 * STYLE TAB
		 * ------------------------------------------------------------ */

		// ---- Footer wrapper ----
		$this->start_controls_section( 'style_footer', [
			'label' => esc_html__( 'Footer', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'footer_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'footer_bg_dark', [
			'label'     => esc_html__( 'Background (Dark Mode)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '.dark {{WRAPPER}} .iatbd-footer' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'footer_text_color', [
			'label'     => esc_html__( 'Default Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'footer_padding', [
			'label'      => esc_html__( 'Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'footer_max_width', [
			'label'      => esc_html__( 'Container Max Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 600, 'max' => 1920 ],
				'%'  => [ 'min' => 50, 'max' => 100 ],
			],
			'default'    => [ 'size' => 1280, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-container' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'grid_columns', [
			'label'          => esc_html__( 'Columns', 'elementor-test' ),
			'type'           => \Elementor\Controls_Manager::SELECT,
			'default'        => '4',
			'tablet_default' => '2',
			'mobile_default' => '1',
			'options'        => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			],
			'selectors'      => [ '{{WRAPPER}} .iatbd-footer-grid' => 'grid-template-columns: repeat({{VALUE}}, minmax(0, 1fr));' ],
		] );

		$this->add_responsive_control( 'grid_gap', [
			'label'      => esc_html__( 'Columns Gap', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'size' => 40, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-grid' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'grid_margin_bottom', [
			'label'      => esc_html__( 'Space Above Bottom Bar', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 120 ] ],
			'default'    => [ 'size' => 40, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-grid' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Brand style ----
		$this->start_controls_section( 'style_brand', [
			'label' => esc_html__( 'Brand / About', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'logo_box_size', [
			'label'      => esc_html__( 'Logo Box Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 120 ] ],
			'default'    => [ 'size' => 32, 'unit' => 'px' ],
			'condition'  => [ 'logo_type' => 'icon' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-logo-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
			'default'    => [ 'size' => 12, 'unit' => 'px' ],
			'condition'  => [ 'logo_type' => 'icon' ],
			'selectors'  => [
				'{{WRAPPER}} .iatbd-footer-logo-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .iatbd-footer-logo-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'logo_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'condition' => [ 'logo_type' => 'icon' ],
			'selectors' => [
				'{{WRAPPER}} .iatbd-footer-logo-box i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .iatbd-footer-logo-box svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Background::get_type(), [
			'name'      => 'logo_box_bg',
			'types'     => [ 'classic', 'gradient' ],
			'selector'  => '{{WRAPPER}} .iatbd-footer-logo-box',
			'condition' => [ 'logo_type' => 'icon' ],
		] );

		$this->add_responsive_control( 'logo_box_radius', [
			'label'      => esc_html__( 'Box Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'condition'  => [ 'logo_type' => 'icon' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-logo-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_image_width', [
			'label'      => esc_html__( 'Image Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 300 ] ],
			'condition'  => [ 'logo_type' => 'image' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-logo-img' => 'width: {{SIZE}}{{UNIT}}; height: auto;' ],
		] );

		$this->add_control( 'brand_name_heading', [
			'label'     => esc_html__( 'Brand Name', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'brand_name_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-brand' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'brand_name_typo',
			'selector' => '{{WRAPPER}} .iatbd-footer-brand',
		] );

		$this->add_control( 'desc_heading', [
			'label'     => esc_html__( 'Description', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'desc_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'desc_typo',
			'selector' => '{{WRAPPER}} .iatbd-footer-desc',
		] );

		$this->add_responsive_control( 'desc_align', [
			'label'     => esc_html__( 'Alignment', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::CHOOSE,
			'options'   => [
				'left'   => [ 'title' => esc_html__( 'Left', 'elementor-test' ),   'icon' => 'eicon-text-align-left' ],
				'center' => [ 'title' => esc_html__( 'Center', 'elementor-test' ), 'icon' => 'eicon-text-align-center' ],
				'right'  => [ 'title' => esc_html__( 'Right', 'elementor-test' ),  'icon' => 'eicon-text-align-right' ],
			],
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-desc' => 'text-align: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ---- Column titles ----
		$this->start_controls_section( 'style_titles', [
			'label' => esc_html__( 'Column Titles', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'title_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-title' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'title_typo',
			'selector' => '{{WRAPPER}} .iatbd-footer-title',
		] );

		$this->add_responsive_control( 'title_spacing', [
			'label'      => esc_html__( 'Bottom Spacing', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-title' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Links ----
		$this->start_controls_section( 'style_links', [
			'label' => esc_html__( 'Links', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'links_typo',
			'selector' => '{{WRAPPER}} .iatbd-footer-links a',
		] );

		$this->add_control( 'links_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-links a' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'links_color_hover', [
			'label'     => esc_html__( 'Hover Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-links a:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'links_gap', [
			'label'      => esc_html__( 'Gap Between Links', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-links' => 'display: flex; flex-direction: column; gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Contact ----
		$this->start_controls_section( 'style_contact', [
			'label'     => esc_html__( 'Contact', 'elementor-test' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'contact_show' => 'yes' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'contact_typo',
			'selector' => '{{WRAPPER}} .iatbd-footer-contact li',
		] );

		$this->add_control( 'contact_text_color', [
			'label'     => esc_html__( 'Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-contact li, {{WRAPPER}} .iatbd-footer-contact li a' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'contact_text_hover', [
			'label'     => esc_html__( 'Link Hover Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-contact li a:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'contact_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .iatbd-footer-contact i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .iatbd-footer-contact svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_responsive_control( 'contact_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
			'selectors'  => [
				'{{WRAPPER}} .iatbd-footer-contact i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .iatbd-footer-contact svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'contact_icon_gap', [
			'label'      => esc_html__( 'Icon Gap', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 30 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-contact i, {{WRAPPER}} .iatbd-footer-contact svg' => 'margin-right: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Social ----
		$this->start_controls_section( 'style_social', [
			'label' => esc_html__( 'Social Icons', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'social_size', [
			'label'      => esc_html__( 'Button Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 80 ] ],
			'default'    => [ 'size' => 36, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-social a' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'social_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
			'selectors'  => [
				'{{WRAPPER}} .iatbd-footer-social i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .iatbd-footer-social svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_responsive_control( 'social_gap', [
			'label'      => esc_html__( 'Gap', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-social' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'social_color', [
			'label'     => esc_html__( 'Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [
				'{{WRAPPER}} .iatbd-footer-social a'     => 'color: {{VALUE}};',
				'{{WRAPPER}} .iatbd-footer-social svg'   => 'fill: {{VALUE}};',
			],
		] );

		$this->add_control( 'social_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-social a' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'social_color_hover', [
			'label'     => esc_html__( 'Hover Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-social a:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'social_bg_hover', [
			'label'     => esc_html__( 'Hover Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-social a:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'social_radius', [
			'label'      => esc_html__( 'Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ], '%' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-social a' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Bottom bar ----
		$this->start_controls_section( 'style_bottom', [
			'label'     => esc_html__( 'Bottom Bar', 'elementor-test' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_bottom' => 'yes' ],
		] );

		$this->add_control( 'bottom_border_color', [
			'label'     => esc_html__( 'Top Border Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-bottom' => 'border-top-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'bottom_padding_top', [
			'label'      => esc_html__( 'Top Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-footer-bottom' => 'padding-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'bottom_typo',
			'selector' => '{{WRAPPER}} .iatbd-footer-bottom, {{WRAPPER}} .iatbd-footer-bottom a',
		] );

		$this->add_control( 'bottom_text_color', [
			'label'     => esc_html__( 'Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-bottom, {{WRAPPER}} .iatbd-footer-bottom p' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'bottom_link_color', [
			'label'     => esc_html__( 'Link Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-bottom a' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'bottom_link_hover', [
			'label'     => esc_html__( 'Link Hover Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-footer-bottom a:hover' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * RENDER HELPERS
	 * ===================================================================== */

	/** Renders one links column (custom links or WP menu top-level items). */
	private function render_link_column( $s, $prefix ) {
		if ( 'yes' !== $s[ $prefix . '_show' ] ) {
			return;
		}

		echo '<div class="iatbd-footer-col">';

		if ( ! empty( $s[ $prefix . '_title' ] ) ) {
			echo '<h4 class="iatbd-footer-title text-white text-sm font-semibold mb-3">' . esc_html( $s[ $prefix . '_title' ] ) . '</h4>';
		}

		echo '<ul class="iatbd-footer-links space-y-2 text-sm">';

		if ( 'wp' === $s[ $prefix . '_source' ] && ! empty( $s[ $prefix . '_wp_menu' ] ) ) {
			$items = wp_get_nav_menu_items( (int) $s[ $prefix . '_wp_menu' ] );
			if ( ! empty( $items ) && ! is_wp_error( $items ) ) {
				foreach ( $items as $item ) {
					if ( 0 !== (int) $item->menu_item_parent ) {
						continue; // top-level only
					}
					$attrs = 'href="' . esc_url( $item->url ) . '" class="hover:text-primary-400 transition"';
					if ( ! empty( $item->target ) ) {
						$attrs .= ' target="' . esc_attr( $item->target ) . '"';
					}
					$rel = trim( $item->xfn . ( '_blank' === $item->target ? ' noopener' : '' ) );
					if ( $rel ) {
						$attrs .= ' rel="' . esc_attr( $rel ) . '"';
					}
					echo '<li><a ' . $attrs . '>' . esc_html( $item->title ) . '</a></li>';
				}
			}
		} elseif ( ! empty( $s[ $prefix . '_links' ] ) ) {
			foreach ( $s[ $prefix . '_links' ] as $i => $item ) {
				$key = $prefix . '_link_' . $i;
				$this->add_render_attribute( $key, 'class', 'hover:text-primary-400 transition' );
				if ( ! empty( $item['link']['url'] ) ) {
					$this->add_link_attributes( $key, $item['link'] );
				}
				echo '<li><a ' . $this->get_render_attribute_string( $key ) . '>' . esc_html( $item['title'] ) . '</a></li>';
			}
		}

		echo '</ul></div>';
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		// Brand link wrapper (optional).
		$brand_tag = 'div';
		if ( ! empty( $s['logo_link']['url'] ) ) {
			$brand_tag = 'a';
			$this->add_link_attributes( 'brand_wrap', $s['logo_link'] );
		}
		$this->add_render_attribute( 'brand_wrap', 'class', 'iatbd-footer-brand-wrap flex items-center gap-2.5 mb-4' );

		$copyright = '';
		if ( 'yes' === $s['show_bottom'] && ! empty( $s['copyright'] ) ) {
			$copyright = wp_kses_post( str_replace( '{year}', date_i18n( 'Y' ), $s['copyright'] ) );
		}
		?>

		<footer class="iatbd-footer bg-slate-900 dark:bg-slate-950 text-slate-400 pt-14 pb-8 border-t border-slate-800">
			<div class="iatbd-footer-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<div class="iatbd-footer-grid grid gap-10 mb-10">

					<!-- Brand / About -->
					<div class="iatbd-footer-col">
						<<?php echo esc_html( $brand_tag ); ?> <?php echo $this->get_render_attribute_string( 'brand_wrap' ); ?>>
							<?php if ( 'image' === $s['logo_type'] && ! empty( $s['logo_image']['url'] ) ) : ?>
								<img class="iatbd-footer-logo-img" src="<?php echo esc_url( $s['logo_image']['url'] ); ?>" alt="<?php echo esc_attr( $s['logo_text'] ); ?>">
							<?php elseif ( 'icon' === $s['logo_type'] && ! empty( $s['logo_icon']['value'] ) ) : ?>
								<div class="iatbd-footer-logo-box w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
									<?php \Elementor\Icons_Manager::render_icon( $s['logo_icon'], [ 'aria-hidden' => 'true', 'class' => 'text-white text-xs' ] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $s['logo_text'] ) ) : ?>
								<span class="iatbd-footer-brand font-display font-bold text-white"><?php echo esc_html( $s['logo_text'] ); ?></span>
							<?php endif; ?>
						</<?php echo esc_html( $brand_tag ); ?>>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="iatbd-footer-desc text-[17px] leading-relaxed"><?php echo esc_html( $s['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $s['social_links'] ) ) : ?>
							<div class="iatbd-footer-social flex items-center gap-3 mt-4">
								<?php
								foreach ( $s['social_links'] as $i => $item ) :
									$key = 'social_' . $i;
									$this->add_render_attribute( $key, 'class', 'inline-flex items-center justify-center w-9 h-9 rounded-full bg-slate-800 text-slate-300 hover:bg-primary-600 hover:text-white transition' );
									if ( ! empty( $item['link']['url'] ) ) {
										$this->add_link_attributes( $key, $item['link'] );
									}
									?>
									<a <?php $this->print_render_attribute_string( $key ); ?>>
										<?php \Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true' ] ); ?>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>
					</div>

					<!-- Column 2 & 3 -->
					<?php
					$this->render_link_column( $s, 'col2' );
					$this->render_link_column( $s, 'col3' );
					?>

					<!-- Contact -->
					<?php if ( 'yes' === $s['contact_show'] ) : ?>
						<div class="iatbd-footer-col">
							<?php if ( ! empty( $s['contact_title'] ) ) : ?>
								<h4 class="iatbd-footer-title text-white text-sm font-semibold mb-3"><?php echo esc_html( $s['contact_title'] ); ?></h4>
							<?php endif; ?>

							<?php if ( ! empty( $s['contact_items'] ) ) : ?>
								<ul class="iatbd-footer-contact space-y-2 text-sm">
									<?php
									foreach ( $s['contact_items'] as $i => $item ) :
										$key = 'contact_' . $i;
										$has_link = ! empty( $item['link']['url'] );
										if ( $has_link ) {
											$this->add_render_attribute( $key, 'class', 'hover:text-primary-400 transition' );
											$this->add_link_attributes( $key, $item['link'] );
										}
										?>
										<li>
											<?php
											if ( ! empty( $item['icon']['value'] ) ) {
												\Elementor\Icons_Manager::render_icon( $item['icon'], [ 'aria-hidden' => 'true', 'class' => 'text-primary-400 mr-2' ] );
											}
											if ( $has_link ) {
												echo '<a ' . $this->get_render_attribute_string( $key ) . '>' . esc_html( $item['text'] ) . '</a>';
											} else {
												echo esc_html( $item['text'] );
											}
											?>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php endif; ?>
						</div>
					<?php endif; ?>

				</div>

				<?php if ( 'yes' === $s['show_bottom'] ) : ?>
					<div class="iatbd-footer-bottom border-t border-slate-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-slate-500">
						<?php if ( $copyright ) : ?>
							<p><?php echo $copyright; // phpcs:ignore WordPress.Security.EscapeOutput -- sanitized with wp_kses_post ?></p>
						<?php endif; ?>

						<?php
						if ( 'yes' === $s['show_bottom_link'] && ! empty( $s['bottom_link_text'] ) ) :
							$this->add_render_attribute( 'bottom_link', 'class', 'hover:text-primary-400 transition' );
							if ( ! empty( $s['bottom_link']['url'] ) ) {
								$this->add_link_attributes( 'bottom_link', $s['bottom_link'] );
							}
							?>
							<a <?php $this->print_render_attribute_string( 'bottom_link' ); ?>><?php echo esc_html( $s['bottom_link_text'] ); ?></a>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</div>
		</footer>

		<?php
	}
}