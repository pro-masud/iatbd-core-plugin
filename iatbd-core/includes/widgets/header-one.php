<?php
/**
 * IATBD Header Widget (Dynamic + Styleable)
 *
 * @since 1.0.0
 */
class Widget_1 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_header';
	}

	public function get_title() {
		return esc_html__( 'IATBD Header', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'header', 'menu', 'navbar', 'nav', 'iatbd' ];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		/* ------------------------------------------------------------
		 * CONTENT TAB
		 * ------------------------------------------------------------ */

		// ---- Logo ----
		$this->start_controls_section( 'logo_section', [
			'label' => esc_html__( 'Logo', 'elementor-test' ),
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
			'label'       => esc_html__( 'Logo Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'IATBD',
			'label_block' => true,
			'separator'   => 'before',
		] );

		$this->add_control( 'logo_tagline', [
			'label'       => esc_html__( 'Tagline', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Industrial Automation',
			'label_block' => true,
		] );

		$this->add_control( 'logo_link', [
			'label'   => esc_html__( 'Logo Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$this->end_controls_section();

		// ---- Menu Items ----
		$this->start_controls_section( 'menu_section', [
			'label' => esc_html__( 'Menu', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$menu_options = $this->get_menu_options();
		$menu_keys    = array_keys( $menu_options );
		$has_wp_menus = count( $menu_options ) > 1;

		$this->add_control( 'menu_source', [
			'label'   => esc_html__( 'Menu Source', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => $has_wp_menus ? 'wp' : 'custom',
			'options' => [
				'wp'     => esc_html__( 'WordPress Menu', 'elementor-test' ),
				'custom' => esc_html__( 'Custom Items', 'elementor-test' ),
			],
		] );

		$this->add_control( 'wp_menu', [
			'label'       => esc_html__( 'Select Menu', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'options'     => $menu_options,
			'default'     => $has_wp_menus ? $menu_keys[1] : '',
			'label_block' => true,
			'condition'   => [ 'menu_source' => 'wp' ],
			'description' => sprintf(
				/* translators: %s: link to Menus screen */
				esc_html__( 'Sub menus (dropdown) are shown automatically. Create or edit menus from %s.', 'elementor-test' ),
				'<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance → Menus', 'elementor-test' ) . '</a>'
			),
		] );

		$this->add_control( 'mobile_submenu', [
			'label'        => esc_html__( 'Show Sub Menu in Mobile', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'menu_source' => 'wp' ],
		] );

		$menu = new \Elementor\Repeater();

		$menu->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Menu Item',
			'label_block' => true,
		] );

		$menu->add_control( 'link', [
			'label'   => esc_html__( 'Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$menu->add_control( 'is_active', [
			'label'        => esc_html__( 'Active Item', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
		] );

		$this->add_control( 'menu_items', [
			'label'       => esc_html__( 'Items', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'condition'   => [ 'menu_source' => 'custom' ],
			'fields'      => $menu->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[ 'title' => 'Home',  'link' => [ 'url' => 'index.html' ],          'is_active' => 'yes' ],
				[ 'title' => 'PLC',   'link' => [ 'url' => 'plc-service.html' ] ],
				[ 'title' => 'Store', 'link' => [ 'url' => 'store-shop.html' ] ],
				[ 'title' => 'HMI',   'link' => [ 'url' => 'hmi-service.html' ] ],
				[ 'title' => 'VFD',   'link' => [ 'url' => 'vfd-service.html' ] ],
				[ 'title' => 'Servo', 'link' => [ 'url' => 'index.html#services' ] ],
				[ 'title' => 'AI',    'link' => [ 'url' => 'ai-service.html' ] ],
			],
		] );

		$this->end_controls_section();

		// ---- Dropdown ----
		$this->start_controls_section( 'dropdown_section', [
			'label'     => esc_html__( 'Dropdown Menu (Custom Items)', 'elementor-test' ),
			'tab'       => \Elementor\Controls_Manager::TAB_CONTENT,
			'condition' => [ 'menu_source' => 'custom' ],
		] );

		$this->add_control( 'show_dropdown', [
			'label'        => esc_html__( 'Show Dropdown', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'dropdown_label', [
			'label'     => esc_html__( 'Dropdown Label', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Service',
			'condition' => [ 'show_dropdown' => 'yes' ],
		] );

		$dd = new \Elementor\Repeater();

		$dd->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Sub Item',
			'label_block' => true,
		] );

		$dd->add_control( 'link', [
			'label'   => esc_html__( 'Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$this->add_control( 'dropdown_items', [
			'label'       => esc_html__( 'Dropdown Items', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $dd->get_controls(),
			'title_field' => '{{{ title }}}',
			'condition'   => [ 'show_dropdown' => 'yes' ],
			'default'     => [
				[ 'title' => 'Maintenance',     'link' => [ 'url' => '#services' ] ],
				[ 'title' => 'Troubleshooting', 'link' => [ 'url' => '#services' ] ],
				[ 'title' => 'Repairing',       'link' => [ 'url' => '#contact' ] ],
			],
		] );

		$this->add_control( 'dropdown_in_mobile', [
			'label'        => esc_html__( 'Show Dropdown Items in Mobile Menu', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
			'condition'    => [ 'show_dropdown' => 'yes' ],
		] );

		$this->end_controls_section();

		// ---- Actions ----
		$this->start_controls_section( 'actions_section', [
			'label' => esc_html__( 'Actions (Toggle & Button)', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'show_theme_toggle', [
			'label'        => esc_html__( 'Show Dark/Light Toggle', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_cta', [
			'label'        => esc_html__( 'Show CTA Button', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'cta_text', [
			'label'     => esc_html__( 'Button Text', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Contact',
			'condition' => [ 'show_cta' => 'yes' ],
		] );

		$this->add_control( 'cta_link', [
			'label'     => esc_html__( 'Button Link', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::URL,
			'default'   => [ 'url' => '#contact' ],
			'condition' => [ 'show_cta' => 'yes' ],
		] );

		$this->end_controls_section();

		// ---- Layout ----
		$this->start_controls_section( 'layout_section', [
			'label' => esc_html__( 'Header Behavior', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'position_type', [
			'label'   => esc_html__( 'Position', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'fixed',
			'options' => [
				'fixed'  => esc_html__( 'Fixed (top)', 'elementor-test' ),
				'sticky' => esc_html__( 'Sticky', 'elementor-test' ),
				'static' => esc_html__( 'Static (normal)', 'elementor-test' ),
			],
		] );

		$this->end_controls_section();

		/* ------------------------------------------------------------
		 * STYLE TAB
		 * ------------------------------------------------------------ */

		// ---- Header Wrapper ----
		$this->start_controls_section( 'style_header', [
			'label' => esc_html__( 'Header', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'header_bg', [
			'label'     => esc_html__( 'Background (Light)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-header' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'header_bg_dark', [
			'label'     => esc_html__( 'Background (Dark Mode)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '.dark {{WRAPPER}} .iatbd-header' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'header_height', [
			'label'      => esc_html__( 'Height', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 40, 'max' => 160 ] ],
			'default'    => [ 'size' => 70, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-header-inner' => 'height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'header_max_width', [
			'label'      => esc_html__( 'Container Max Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 600, 'max' => 1920 ],
				'%'  => [ 'min' => 50, 'max' => 100 ],
			],
			'default'    => [ 'size' => 1280, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-header-container' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'header_padding', [
			'label'      => esc_html__( 'Container Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em', '%' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-header-container' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'header_border',
			'selector' => '{{WRAPPER}} .iatbd-header',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'header_shadow',
			'selector' => '{{WRAPPER}} .iatbd-header',
		] );

		$this->add_responsive_control( 'header_z_index', [
			'label'     => esc_html__( 'Z-Index', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 50,
			'selectors' => [ '{{WRAPPER}} .iatbd-header' => 'z-index: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ---- Logo Style ----
		$this->start_controls_section( 'style_logo', [
			'label' => esc_html__( 'Logo', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'logo_box_size', [
			'label'      => esc_html__( 'Logo Box Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 120 ] ],
			'default'    => [ 'size' => 36, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-logo-box' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 80 ] ],
			'default'    => [ 'size' => 14, 'unit' => 'px' ],
			'condition'  => [ 'logo_type' => 'icon' ],
			'selectors'  => [
				'{{WRAPPER}} .iatbd-logo-box i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .iatbd-logo-box svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'logo_icon_color', [
			'label'     => esc_html__( 'Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'condition' => [ 'logo_type' => 'icon' ],
			'selectors' => [
				'{{WRAPPER}} .iatbd-logo-box i'   => 'color: {{VALUE}};',
				'{{WRAPPER}} .iatbd-logo-box svg' => 'fill: {{VALUE}};',
			],
		] );

		$this->add_group_control( \Elementor\Group_Control_Background::get_type(), [
			'name'      => 'logo_box_bg',
			'types'     => [ 'classic', 'gradient' ],
			'selector'  => '{{WRAPPER}} .iatbd-logo-box',
			'condition' => [ 'logo_type' => 'icon' ],
		] );

		$this->add_responsive_control( 'logo_box_radius', [
			'label'      => esc_html__( 'Box Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-logo-box' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'logo_image_width', [
			'label'      => esc_html__( 'Image Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 300 ] ],
			'condition'  => [ 'logo_type' => 'image' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-logo-img' => 'width: {{SIZE}}{{UNIT}}; height: auto;' ],
		] );

		$this->add_responsive_control( 'logo_gap', [
			'label'      => esc_html__( 'Gap (Logo ↔ Text)', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-logo' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'logo_text_heading', [
			'label'     => esc_html__( 'Logo Text', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'logo_text_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-logo-text' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'logo_text_color_dark', [
			'label'     => esc_html__( 'Color (Dark Mode)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '.dark {{WRAPPER}} .iatbd-logo-text' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'logo_text_typo',
			'selector' => '{{WRAPPER}} .iatbd-logo-text',
		] );

		$this->add_control( 'logo_tagline_heading', [
			'label'     => esc_html__( 'Tagline', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'logo_tagline_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-logo-tagline' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'logo_tagline_typo',
			'selector' => '{{WRAPPER}} .iatbd-logo-tagline',
		] );

		$this->end_controls_section();

		// ---- Menu Style ----
		$this->start_controls_section( 'style_menu', [
			'label' => esc_html__( 'Menu Links', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'menu_typo',
			'selector' => '{{WRAPPER}} .iatbd-nav-link',
		] );

		$this->add_responsive_control( 'menu_gap', [
			'label'      => esc_html__( 'Gap Between Items', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-nav' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'menu_padding', [
			'label'      => esc_html__( 'Link Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-nav-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'menu_radius', [
			'label'      => esc_html__( 'Link Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-nav-link' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->start_controls_tabs( 'menu_tabs' );

		// Normal
		$this->start_controls_tab( 'menu_tab_normal', [ 'label' => esc_html__( 'Normal', 'elementor-test' ) ] );
		$this->add_control( 'menu_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-nav-link' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'menu_color_dark', [
			'label'     => esc_html__( 'Color (Dark Mode)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '.dark {{WRAPPER}} .iatbd-nav-link' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'menu_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-nav-link' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		// Hover
		$this->start_controls_tab( 'menu_tab_hover', [ 'label' => esc_html__( 'Hover', 'elementor-test' ) ] );
		$this->add_control( 'menu_color_hover', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-nav-link:hover' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'menu_bg_hover', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-nav-link:hover' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		// Active
		$this->start_controls_tab( 'menu_tab_active', [ 'label' => esc_html__( 'Active', 'elementor-test' ) ] );
		$this->add_control( 'menu_color_active', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-nav-link.active' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'menu_bg_active', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-nav-link.active' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->end_controls_section();

		// ---- Dropdown Style ----
		$this->start_controls_section( 'style_dropdown', [
			'label' => esc_html__( 'Dropdown / Sub Menu', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'dd_width', [
			'label'      => esc_html__( 'Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 120, 'max' => 400 ] ],
			'default'    => [ 'size' => 192, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .dropdown-menu' => 'width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'dd_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .dropdown-menu' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'dd_bg_dark', [
			'label'     => esc_html__( 'Background (Dark Mode)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '.dark {{WRAPPER}} .dropdown-menu' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'dd_typo',
			'selector' => '{{WRAPPER}} .iatbd-dd-link',
		] );

		$this->add_control( 'dd_link_color', [
			'label'     => esc_html__( 'Link Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-dd-link' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'dd_link_hover_color', [
			'label'     => esc_html__( 'Link Hover Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-dd-link:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'dd_link_hover_bg', [
			'label'     => esc_html__( 'Link Hover Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-dd-link:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'dd_link_padding', [
			'label'      => esc_html__( 'Link Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-dd-link' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'dd_radius', [
			'label'      => esc_html__( 'Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px' ],
			'selectors'  => [ '{{WRAPPER}} .dropdown-menu' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'dd_border',
			'selector' => '{{WRAPPER}} .dropdown-menu',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'dd_shadow',
			'selector' => '{{WRAPPER}} .dropdown-menu',
		] );

		$this->end_controls_section();

		// ---- Theme Toggle Style ----
		$this->start_controls_section( 'style_toggle', [
			'label'     => esc_html__( 'Theme Toggle', 'elementor-test' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_theme_toggle' => 'yes' ],
		] );

		$this->add_responsive_control( 'toggle_size', [
			'label'      => esc_html__( 'Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 70 ] ],
			'default'    => [ 'size' => 36, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-theme-toggle' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'toggle_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-theme-toggle' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'toggle_bg_hover', [
			'label'     => esc_html__( 'Background Hover', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-theme-toggle:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'toggle_sun_color', [
			'label'     => esc_html__( 'Sun Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .theme-icon-sun' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'toggle_moon_color', [
			'label'     => esc_html__( 'Moon Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .theme-icon-moon' => 'color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'toggle_icon_size', [
			'label'      => esc_html__( 'Icon Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 8, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-theme-toggle i' => 'font-size: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- CTA Style ----
		$this->start_controls_section( 'style_cta', [
			'label'     => esc_html__( 'CTA Button', 'elementor-test' ),
			'tab'       => \Elementor\Controls_Manager::TAB_STYLE,
			'condition' => [ 'show_cta' => 'yes' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'cta_typo',
			'selector' => '{{WRAPPER}} .iatbd-cta',
		] );

		$this->start_controls_tabs( 'cta_tabs' );

		$this->start_controls_tab( 'cta_tab_normal', [ 'label' => esc_html__( 'Normal', 'elementor-test' ) ] );
		$this->add_control( 'cta_color', [
			'label'     => esc_html__( 'Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-cta' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'cta_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-cta' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->start_controls_tab( 'cta_tab_hover', [ 'label' => esc_html__( 'Hover', 'elementor-test' ) ] );
		$this->add_control( 'cta_color_hover', [
			'label'     => esc_html__( 'Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-cta:hover' => 'color: {{VALUE}};' ],
		] );
		$this->add_control( 'cta_bg_hover', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-cta:hover' => 'background-color: {{VALUE}};' ],
		] );
		$this->end_controls_tab();

		$this->end_controls_tabs();

		$this->add_responsive_control( 'cta_padding', [
			'label'      => esc_html__( 'Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'separator'  => 'before',
			'selectors'  => [ '{{WRAPPER}} .iatbd-cta' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'cta_radius', [
			'label'      => esc_html__( 'Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', '%' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-cta' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Border::get_type(), [
			'name'     => 'cta_border',
			'selector' => '{{WRAPPER}} .iatbd-cta',
		] );

		$this->add_group_control( \Elementor\Group_Control_Box_Shadow::get_type(), [
			'name'     => 'cta_shadow',
			'selector' => '{{WRAPPER}} .iatbd-cta',
		] );

		$this->end_controls_section();

		// ---- Mobile Style ----
		$this->start_controls_section( 'style_mobile', [
			'label' => esc_html__( 'Mobile Menu', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'burger_color', [
			'label'     => esc_html__( 'Hamburger Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-burger i' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'burger_bg', [
			'label'     => esc_html__( 'Hamburger Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-burger' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'mobile_bg', [
			'label'     => esc_html__( 'Menu Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'separator' => 'before',
			'selectors' => [ '{{WRAPPER}} .iatbd-mobile-menu' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'mobile_bg_dark', [
			'label'     => esc_html__( 'Menu Background (Dark Mode)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '.dark {{WRAPPER}} .iatbd-mobile-menu' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'mobile_typo',
			'selector' => '{{WRAPPER}} .iatbd-mobile-link',
		] );

		$this->add_control( 'mobile_link_color', [
			'label'     => esc_html__( 'Link Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-mobile-link' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'mobile_link_active_color', [
			'label'     => esc_html__( 'Active Link Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-mobile-link.active' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'mobile_link_active_bg', [
			'label'     => esc_html__( 'Active Link Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-mobile-link.active' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'mobile_cta_bg', [
			'label'     => esc_html__( 'Mobile CTA Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-mobile-cta' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'mobile_cta_color', [
			'label'     => esc_html__( 'Mobile CTA Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-mobile-cta' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * HELPERS
	 * ===================================================================== */

	/** All WordPress menus for the select control. */
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

	/** Menu items grouped by parent ID: [ parent_id => [ items ] ]. */
	private function get_wp_menu_tree( $menu_id ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( empty( $items ) || is_wp_error( $items ) ) {
			return [];
		}
		if ( function_exists( '_wp_menu_item_classes_by_context' ) ) {
			_wp_menu_item_classes_by_context( $items ); // sets current / ancestor flags
		}
		$tree = [];
		foreach ( $items as $item ) {
			$tree[ (int) $item->menu_item_parent ][] = $item;
		}
		return $tree;
	}

	private function is_item_active( $item ) {
		return ! empty( $item->current ) || ! empty( $item->current_item_ancestor ) || ! empty( $item->current_item_parent );
	}

	/** href / class / target / rel attribute string for a WP menu item. */
	private function item_attrs( $item, $class, $extra = '' ) {
		$attrs = 'href="' . esc_url( $item->url ) . '" class="' . esc_attr( $class ) . '"';
		if ( ! empty( $item->target ) ) {
			$attrs .= ' target="' . esc_attr( $item->target ) . '"';
		}
		$rel = trim( $item->xfn . ( '_blank' === $item->target ? ' noopener' : '' ) );
		if ( $rel ) {
			$attrs .= ' rel="' . esc_attr( $rel ) . '"';
		}
		return $attrs . $extra;
	}

	/** Desktop nav from a WP menu (top level + dropdown sub menus). */
	private function render_wp_desktop( $tree ) {
		if ( empty( $tree[0] ) ) {
			return;
		}
		foreach ( $tree[0] as $item ) {
			$active       = $this->is_item_active( $item );
			$has_children = ! empty( $tree[ $item->ID ] );
			$color        = $active
				? ' active text-primary-600 dark:text-primary-400'
				: ' text-slate-600 dark:text-slate-300 hover:text-primary-600';
			$base         = 'iatbd-nav-link nav-link px-3.5 py-2 text-sm font-medium' . $color;

			if ( ! $has_children ) {
				echo '<a ' . $this->item_attrs( $item, $base ) . '>' . esc_html( $item->title ) . '</a>';
				continue;
			}

			echo '<div class="relative group">';
			echo '<a ' . $this->item_attrs( $item, $base . ' flex items-center gap-1.5' ) . '>' . esc_html( $item->title ) . ' <i class="fas fa-chevron-down text-[9px]"></i></a>';
			echo '<div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden z-50">';
			$this->render_wp_dropdown_items( $tree, $item->ID, 0 );
			echo '</div></div>';
		}
	}

	/** Dropdown links (deeper levels are shown indented). */
	private function render_wp_dropdown_items( $tree, $parent, $depth ) {
		if ( empty( $tree[ $parent ] ) ) {
			return;
		}
		foreach ( $tree[ $parent ] as $sub ) {
			$extra = $depth ? ' style="padding-left:calc(1rem + ' . ( $depth * 14 ) . 'px)"' : '';
			echo '<a ' . $this->item_attrs( $sub, 'iatbd-dd-link block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20', $extra ) . '>' . esc_html( $sub->title ) . '</a>';
			$this->render_wp_dropdown_items( $tree, $sub->ID, $depth + 1 );
		}
	}

	/** Mobile menu from a WP menu (sub items indented). */
	private function render_wp_mobile( $tree, $parent, $depth, $show_sub ) {
		if ( empty( $tree[ $parent ] ) ) {
			return;
		}
		foreach ( $tree[ $parent ] as $item ) {
			$active = ( 0 === $depth ) && $this->is_item_active( $item );
			$class  = 'iatbd-mobile-link block px-3 py-2.5 rounded-lg text-sm';
			$class .= $active
				? ' active font-medium text-primary-600 bg-primary-50 dark:bg-primary-900/20'
				: ' text-slate-600 dark:text-slate-300';
			$extra  = $depth ? ' style="padding-left:calc(0.75rem + ' . ( $depth * 16 ) . 'px)"' : '';

			echo '<a ' . $this->item_attrs( $item, $class, $extra ) . '>' . esc_html( $item->title ) . '</a>';

			if ( $show_sub ) {
				$this->render_wp_mobile( $tree, $item->ID, $depth + 1, $show_sub );
			}
		}
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s  = $this->get_settings_for_display();
		$id = $this->get_id();

		$btn_id  = 'iatbd-burger-' . $id;
		$menu_id = 'iatbd-mobile-' . $id;

		// Header position classes.
		$pos_classes = [
			'fixed'  => 'fixed top-0 inset-x-0',
			'sticky' => 'sticky top-0 inset-x-0',
			'static' => 'relative',
		];
		$pos_class = isset( $pos_classes[ $s['position_type'] ] ) ? $pos_classes[ $s['position_type'] ] : $pos_classes['fixed'];

		// Menu source: WordPress menu (falls back to custom items if empty).
		$use_wp = ( 'wp' === $s['menu_source'] && ! empty( $s['wp_menu'] ) );
		$tree   = $use_wp ? $this->get_wp_menu_tree( (int) $s['wp_menu'] ) : [];
		if ( $use_wp && empty( $tree ) ) {
			$use_wp = false;
		}

		$has_dropdown = ( ! $use_wp && 'yes' === $s['show_dropdown'] && ! empty( $s['dropdown_items'] ) );

		// Logo link attributes.
		$this->add_render_attribute( 'logo_link', 'class', 'iatbd-logo flex items-center gap-3' );
		if ( ! empty( $s['logo_link']['url'] ) ) {
			$this->add_link_attributes( 'logo_link', $s['logo_link'] );
		}
		?>

		<header class="iatbd-header <?php echo esc_attr( $pos_class ); ?> z-50 bg-white/85 dark:bg-slate-900/85 backdrop-blur-xl border-b border-slate-200/70 dark:border-slate-800">
			<div class="iatbd-header-container max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="iatbd-header-inner flex items-center justify-between h-16 lg:h-[70px]">

					<!-- Logo -->
					<a <?php $this->print_render_attribute_string( 'logo_link' ); ?>>
						<?php if ( 'image' === $s['logo_type'] && ! empty( $s['logo_image']['url'] ) ) : ?>
							<img class="iatbd-logo-img" src="<?php echo esc_url( $s['logo_image']['url'] ); ?>" alt="<?php echo esc_attr( $s['logo_text'] ); ?>">
						<?php elseif ( 'icon' === $s['logo_type'] && ! empty( $s['logo_icon']['value'] ) ) : ?>
							<div class="iatbd-logo-box w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-md shadow-primary-500/20">
								<?php \Elementor\Icons_Manager::render_icon( $s['logo_icon'], [ 'aria-hidden' => 'true', 'class' => 'text-white text-sm' ] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $s['logo_text'] ) || ! empty( $s['logo_tagline'] ) ) : ?>
							<div>
								<?php if ( ! empty( $s['logo_text'] ) ) : ?>
									<span class="iatbd-logo-text font-display font-bold text-lg text-slate-900 dark:text-white tracking-tight"><?php echo esc_html( $s['logo_text'] ); ?></span>
								<?php endif; ?>
								<?php if ( ! empty( $s['logo_tagline'] ) ) : ?>
									<p class="iatbd-logo-tagline text-[9px] text-slate-400 tracking-[0.2em] uppercase -mt-0.5"><?php echo esc_html( $s['logo_tagline'] ); ?></p>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</a>

					<!-- Desktop Navigation -->
					<nav class="iatbd-nav hidden lg:flex items-center gap-1">
						<?php
						if ( $use_wp ) :
							$this->render_wp_desktop( $tree );
						else :
							if ( ! empty( $s['menu_items'] ) ) :
								foreach ( $s['menu_items'] as $index => $item ) :
									$key = 'nav_item_' . $index;
									$cls = 'iatbd-nav-link nav-link px-3.5 py-2 text-sm font-medium';
									$cls .= ( 'yes' === $item['is_active'] )
										? ' active text-primary-600 dark:text-primary-400'
										: ' text-slate-600 dark:text-slate-300 hover:text-primary-600';
									$this->add_render_attribute( $key, 'class', $cls );
									if ( ! empty( $item['link']['url'] ) ) {
										$this->add_link_attributes( $key, $item['link'] );
									}
									?>
									<a <?php $this->print_render_attribute_string( $key ); ?>><?php echo esc_html( $item['title'] ); ?></a>
									<?php
								endforeach;
							endif;
						endif;
						?>

						<?php if ( $has_dropdown ) : ?>
							<!-- Custom Dropdown -->
							<div class="relative group">
								<button type="button" class="iatbd-nav-link nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 flex items-center gap-1.5">
									<?php echo esc_html( $s['dropdown_label'] ); ?> <i class="fas fa-chevron-down text-[9px]"></i>
								</button>
								<div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden z-50">
									<?php
									foreach ( $s['dropdown_items'] as $i => $item ) :
										$key = 'dd_item_' . $i;
										$this->add_render_attribute( $key, 'class', 'iatbd-dd-link block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20' );
										if ( ! empty( $item['link']['url'] ) ) {
											$this->add_link_attributes( $key, $item['link'] );
										}
										?>
										<a <?php $this->print_render_attribute_string( $key ); ?>><?php echo esc_html( $item['title'] ); ?></a>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</nav>

					<!-- Actions -->
					<div class="flex items-center gap-2">
						<?php if ( 'yes' === $s['show_theme_toggle'] ) : ?>
							<button
								id="theme-toggle"
								type="button"
								aria-label="Switch to dark mode"
								aria-pressed="false"
								class="iatbd-theme-toggle w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition"
							>
								<i class="fas fa-sun theme-icon-sun text-xs text-amber-500"></i>
								<i class="fas fa-moon theme-icon-moon text-xs text-slate-200"></i>
							</button>
						<?php endif; ?>

						<?php
						if ( 'yes' === $s['show_cta'] && ! empty( $s['cta_text'] ) ) :
							$this->add_render_attribute( 'cta', 'class', 'iatbd-cta hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold rounded-full shadow-lg shadow-primary-500/20 btn-cta' );
							if ( ! empty( $s['cta_link']['url'] ) ) {
								$this->add_link_attributes( 'cta', $s['cta_link'] );
							}
							?>
							<a <?php $this->print_render_attribute_string( 'cta' ); ?>><?php echo esc_html( $s['cta_text'] ); ?></a>
						<?php endif; ?>

						<button
							id="<?php echo esc_attr( $btn_id ); ?>"
							type="button"
							aria-label="Toggle navigation menu"
							aria-controls="<?php echo esc_attr( $menu_id ); ?>"
							aria-expanded="false"
							class="iatbd-burger lg:hidden w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center"
						>
							<i class="fas fa-bars text-slate-700 dark:text-slate-300"></i>
						</button>
					</div>
				</div>
			</div>

			<!-- Mobile Navigation Menu -->
			<div id="<?php echo esc_attr( $menu_id ); ?>" class="iatbd-mobile-menu lg:hidden hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
				<div class="px-4 py-3 space-y-1">
					<?php
					if ( $use_wp ) :
						$this->render_wp_mobile( $tree, 0, 0, 'yes' === $s['mobile_submenu'] );
					else :
						if ( ! empty( $s['menu_items'] ) ) :
							foreach ( $s['menu_items'] as $index => $item ) :
								$key = 'mob_item_' . $index;
								$cls = 'iatbd-mobile-link block px-3 py-2.5 rounded-lg text-sm';
								$cls .= ( 'yes' === $item['is_active'] )
									? ' active font-medium text-primary-600 bg-primary-50 dark:bg-primary-900/20'
									: ' text-slate-600 dark:text-slate-300';
								$this->add_render_attribute( $key, 'class', $cls );
								if ( ! empty( $item['link']['url'] ) ) {
									$this->add_link_attributes( $key, $item['link'] );
								}
								?>
								<a <?php $this->print_render_attribute_string( $key ); ?>><?php echo esc_html( $item['title'] ); ?></a>
								<?php
							endforeach;
						endif;

						if ( $has_dropdown && 'yes' === $s['dropdown_in_mobile'] ) :
							foreach ( $s['dropdown_items'] as $i => $item ) :
								$key = 'mob_dd_' . $i;
								$this->add_render_attribute( $key, 'class', 'iatbd-mobile-link block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300' );
								if ( ! empty( $item['link']['url'] ) ) {
									$this->add_link_attributes( $key, $item['link'] );
								}
								?>
								<a <?php $this->print_render_attribute_string( $key ); ?>><?php echo esc_html( $item['title'] ); ?></a>
								<?php
							endforeach;
						endif;
					endif;

					if ( 'yes' === $s['show_cta'] && ! empty( $s['cta_text'] ) ) :
						$this->add_render_attribute( 'mob_cta', 'class', 'iatbd-mobile-cta block mt-2 text-center py-2.5 bg-primary-600 text-white rounded-xl text-sm font-semibold' );
						if ( ! empty( $s['cta_link']['url'] ) ) {
							$this->add_link_attributes( 'mob_cta', $s['cta_link'] );
						}
						?>
						<a <?php $this->print_render_attribute_string( 'mob_cta' ); ?>><?php echo esc_html( $s['cta_text'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</header>

	

		<?php
	}
}