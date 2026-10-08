<?php
/**
 * IATBD Hero Slider Widget (Dynamic + Styleable)
 *
 * Self-contained: slider CSS + JS are printed by the widget itself,
 * so it no longer depends on the old .servo-slide / .servo-dot CSS & JS.
 *
 * @since 1.0.0
 */
class IATBD_Hero_Slider extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hero_slider';
	}

	public function get_title() {
		return esc_html__( 'Hero Slider', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'hero', 'slider', 'banner', 'carousel', 'servo', 'iatbd' ];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		/* ------------------------------------------------------------
		 * CONTENT TAB — Slides
		 * ------------------------------------------------------------ */
		$this->start_controls_section( 'slides_section', [
			'label' => esc_html__( 'Slides', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$r = new \Elementor\Repeater();

		// -- Background --
		$r->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => \Elementor\Utils::get_placeholder_image_src() ],
		] );

		$r->add_control( 'overlay_from', [
			'label'   => esc_html__( 'Overlay Start (left)', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::COLOR,
			'alpha'   => true,
			'default' => 'rgba(2,6,23,0.95)',
		] );

		$r->add_control( 'overlay_via', [
			'label'   => esc_html__( 'Overlay Middle', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::COLOR,
			'alpha'   => true,
			'default' => 'rgba(15,23,42,0.80)',
		] );

		$r->add_control( 'overlay_to', [
			'label'   => esc_html__( 'Overlay End (right)', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::COLOR,
			'alpha'   => true,
			'default' => 'rgba(15,23,42,0.40)',
		] );

		$r->add_control( 'accent_color', [
			'label'       => esc_html__( 'Accent Color', 'elementor-test' ),
			'description' => esc_html__( 'Used for badge, highlighted heading text and the main button.', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::COLOR,
			'default'     => '#fb923c',
			'selectors'   => [
				'{{WRAPPER}} {{CURRENT_ITEM}} .iatbd-hero-accent' => 'color: {{VALUE}};',
				'{{WRAPPER}} {{CURRENT_ITEM}} .iatbd-hero-badge'  => 'color: {{VALUE}}; border-color: color-mix(in srgb, {{VALUE}} 40%, transparent); background-color: color-mix(in srgb, {{VALUE}} 15%, transparent);',
				'{{WRAPPER}} {{CURRENT_ITEM}} .iatbd-hero-btn1'   => 'background-color: {{VALUE}};',
			],
		] );

		// -- Text --
		$r->add_control( 'badge_icon', [
			'label'     => esc_html__( 'Badge Icon', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::ICONS,
			'default'   => [ 'value' => 'fas fa-cog', 'library' => 'fa-solid' ],
			'separator' => 'before',
		] );

		$r->add_control( 'badge_text', [
			'label'       => esc_html__( 'Badge Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'SERVO DRIVE',
			'label_block' => true,
		] );

		$r->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'elementor-test' ),
			'description' => esc_html__( 'New line = line break. Wrap text in {accent}...{/accent} to highlight it with the accent color.', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 3,
			'default'     => "Heading line one\n{accent}highlighted text{/accent}",
		] );

		$r->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Short description for this slide.',
		] );

		// -- Buttons --
		$r->add_control( 'btn1_text', [
			'label'       => esc_html__( 'Main Button Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Get a Quote',
			'label_block' => true,
			'separator'   => 'before',
		] );

		$r->add_control( 'btn1_link', [
			'label'   => esc_html__( 'Main Button Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#contact' ],
		] );

		$r->add_control( 'btn1_icon', [
			'label'   => esc_html__( 'Main Button Icon', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::ICONS,
			'default' => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
		] );

		$r->add_control( 'btn2_text', [
			'label'       => esc_html__( 'Second Button Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Our Services',
			'label_block' => true,
			'separator'   => 'before',
		] );

		$r->add_control( 'btn2_link', [
			'label'   => esc_html__( 'Second Button Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#services' ],
		] );

		// -- Layout + feature card --
		$r->add_control( 'layout', [
			'label'     => esc_html__( 'Layout', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::SELECT,
			'default'   => 'simple',
			'options'   => [
				'simple' => esc_html__( 'Text only', 'elementor-test' ),
				'split'  => esc_html__( 'Text + Feature Card (right)', 'elementor-test' ),
			],
			'separator' => 'before',
		] );

		$feature_colors = [ 1 => '#7dd3fc', 2 => '#fdba74', 3 => '#6ee7b7' ];

		for ( $n = 1; $n <= 3; $n++ ) {
			$r->add_control( "f{$n}_heading", [
				'label'     => sprintf( esc_html__( 'Feature %d', 'elementor-test' ), $n ),
				'type'      => \Elementor\Controls_Manager::HEADING,
				'separator' => 'before',
				'condition' => [ 'layout' => 'split' ],
			] );

			$r->add_control( "f{$n}_icon", [
				'label'     => esc_html__( 'Icon', 'elementor-test' ),
				'type'      => \Elementor\Controls_Manager::ICONS,
				'default'   => [ 'value' => 'fas fa-bolt', 'library' => 'fa-solid' ],
				'condition' => [ 'layout' => 'split' ],
			] );

			$r->add_control( "f{$n}_title", [
				'label'       => esc_html__( 'Title', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [ 'layout' => 'split' ],
			] );

			$r->add_control( "f{$n}_text", [
				'label'       => esc_html__( 'Text', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'condition'   => [ 'layout' => 'split' ],
			] );

			$r->add_control( "f{$n}_color", [
				'label'     => esc_html__( 'Icon Color', 'elementor-test' ),
				'type'      => \Elementor\Controls_Manager::COLOR,
				'default'   => $feature_colors[ $n ],
				'condition' => [ 'layout' => 'split' ],
				'selectors' => [
					"{{WRAPPER}} {{CURRENT_ITEM}} .iatbd-hero-f{$n} .iatbd-hero-fbox"     => 'background-color: color-mix(in srgb, {{VALUE}} 30%, transparent);',
					"{{WRAPPER}} {{CURRENT_ITEM}} .iatbd-hero-f{$n} .iatbd-hero-fbox i"   => 'color: {{VALUE}};',
					"{{WRAPPER}} {{CURRENT_ITEM}} .iatbd-hero-f{$n} .iatbd-hero-fbox svg" => 'fill: {{VALUE}};',
				],
			] );
		}

		// -- Default slides (same content as the original design) --
		$this->add_control( 'slides', [
			'label'       => esc_html__( 'Slides', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'title_field' => '{{{ badge_text }}}',
			'default'     => [
				[
					'bg_image'     => [ 'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80' ],
					'overlay_via'  => 'rgba(15,23,42,0.80)',
					'overlay_to'   => 'rgba(15,23,42,0.40)',
					'accent_color' => '#fb923c',
					'badge_icon'   => [ 'value' => 'fas fa-cog', 'library' => 'fa-solid' ],
					'badge_text'   => 'SERVO DRIVE',
					'heading'      => "Motion control\nwith {accent}micron precision{/accent}",
					'description'  => 'Servo motor & drive sizing, auto-tuning, multi-axis sync and field support — for packaging, CNC, robotics and high-speed lines.',
					'btn1_text'    => 'Get a Quote',
					'btn1_link'    => [ 'url' => '#contact' ],
					'btn1_icon'    => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
					'btn2_text'    => 'Our Services',
					'btn2_link'    => [ 'url' => '#services' ],
					'layout'       => 'split',
					'f1_icon'      => [ 'value' => 'fas fa-crosshairs', 'library' => 'fa-solid' ],
					'f1_title'     => 'Position accuracy',
					'f1_text'      => 'Closed-loop encoder feedback',
					'f1_color'     => '#7dd3fc',
					'f2_icon'      => [ 'value' => 'fas fa-bolt', 'library' => 'fa-solid' ],
					'f2_title'     => 'Dynamic response',
					'f2_text'      => 'Fast accel, tight torque control',
					'f2_color'     => '#fdba74',
					'f3_icon'      => [ 'value' => 'fas fa-layer-group', 'library' => 'fa-solid' ],
					'f3_title'     => 'Multi-axis ready',
					'f3_text'      => 'Sync, camming & electronic gearing',
					'f3_color'     => '#6ee7b7',
				],
				[
					'bg_image'     => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80' ],
					'overlay_via'  => 'rgba(15,23,42,0.80)',
					'overlay_to'   => 'rgba(30,58,138,0.40)',
					'accent_color' => '#7dd3fc',
					'badge_icon'   => [ 'value' => 'fas fa-sliders-h', 'library' => 'fa-solid' ],
					'badge_text'   => 'TUNING & COMMISSIONING',
					'heading'      => "Auto-tune.\n{accent}Zero vibration.{/accent}",
					'description'  => 'Gain tuning, notch filters, inertia matching and load tests — so your axes settle fast without overshoot or resonance.',
					'btn1_text'    => 'Book Tuning',
					'btn1_link'    => [ 'url' => '#contact' ],
					'btn1_icon'    => [ 'value' => 'fas fa-arrow-right', 'library' => 'fa-solid' ],
					'btn2_text'    => 'Capabilities',
					'btn2_link'    => [ 'url' => '#services' ],
					'layout'       => 'simple',
				],
				[
					'bg_image'     => [ 'url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1920&q=80' ],
					'overlay_via'  => 'rgba(15,23,42,0.80)',
					'overlay_to'   => 'rgba(6,78,59,0.35)',
					'accent_color' => '#6ee7b7',
					'badge_icon'   => [ 'value' => 'fas fa-tools', 'library' => 'fa-solid' ],
					'badge_text'   => 'REPAIR & SUPPORT',
					'heading'      => "Encoder, drive, motor.\n{accent}We fix the chain.{/accent}",
					'description'  => 'Alarm diagnosis, encoder repair, drive replacement, parameter recovery and 24/7 support for critical motion axes.',
					'btn1_text'    => 'Get Support',
					'btn1_link'    => [ 'url' => '#contact' ],
					'btn1_icon'    => [ 'value' => 'fas fa-phone-alt', 'library' => 'fa-solid' ],
					'btn2_text'    => 'View Services',
					'btn2_link'    => [ 'url' => '#services' ],
					'layout'       => 'simple',
				],
			],
		] );

		$this->end_controls_section();

		/* ------------------------------------------------------------
		 * CONTENT TAB — Slider settings
		 * ------------------------------------------------------------ */
		$this->start_controls_section( 'slider_section', [
			'label' => esc_html__( 'Slider Settings', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'autoplay', [
			'label'        => esc_html__( 'Autoplay', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => esc_html__( 'Autoplay is paused inside the Elementor editor.', 'elementor-test' ),
		] );

		$this->add_control( 'autoplay_speed', [
			'label'     => esc_html__( 'Autoplay Speed (ms)', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'min'       => 1500,
			'step'      => 500,
			'default'   => 6000,
			'condition' => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'pause_hover', [
			'label'        => esc_html__( 'Pause on Hover', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'autoplay' => 'yes' ],
		] );

		$this->add_control( 'show_arrows', [
			'label'        => esc_html__( 'Show Arrows', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'show_dots', [
			'label'        => esc_html__( 'Show Dots', 'elementor-test' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		/* ------------------------------------------------------------
		 * STYLE TAB
		 * ------------------------------------------------------------ */

		// ---- Hero ----
		$this->start_controls_section( 'style_hero', [
			'label' => esc_html__( 'Hero', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'hero_min_height', [
			'label'      => esc_html__( 'Min Height', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', 'vh' ],
			'range'      => [
				'px' => [ 'min' => 300, 'max' => 1200 ],
				'vh' => [ 'min' => 30, 'max' => 100 ],
			],
			'default'    => [ 'size' => 600, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-slide' => 'min-height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'hero_top_offset', [
			'label'       => esc_html__( 'Top Offset (for fixed header)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::SLIDER,
			'size_units'  => [ 'px' ],
			'range'       => [ 'px' => [ 'min' => 0, 'max' => 200 ] ],
			'default'     => [ 'size' => 64, 'unit' => 'px' ],
			'selectors'   => [ '{{WRAPPER}} .iatbd-hero' => 'padding-top: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_padding', [
			'label'      => esc_html__( 'Content Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-content' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'content_max_width', [
			'label'      => esc_html__( 'Container Max Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [
				'px' => [ 'min' => 600, 'max' => 1920 ],
				'%'  => [ 'min' => 50, 'max' => 100 ],
			],
			'default'    => [ 'size' => 1280, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-content' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'hero_bg_color', [
			'label'     => esc_html__( 'Fallback Background Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ---- Badge ----
		$this->start_controls_section( 'style_badge', [
			'label' => esc_html__( 'Badge', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'badge_typo',
			'selector' => '{{WRAPPER}} .iatbd-hero-badge',
		] );

		$this->add_responsive_control( 'badge_padding', [
			'label'      => esc_html__( 'Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-badge' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'badge_radius', [
			'label'      => esc_html__( 'Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-badge' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Heading ----
		$this->start_controls_section( 'style_heading', [
			'label' => esc_html__( 'Heading', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'heading_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-heading' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'heading_typo',
			'selector' => '{{WRAPPER}} .iatbd-hero-heading',
		] );

		$this->add_responsive_control( 'heading_spacing', [
			'label'      => esc_html__( 'Bottom Spacing', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 80 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-heading' => 'margin-bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Description ----
		$this->start_controls_section( 'style_desc', [
			'label' => esc_html__( 'Description', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'desc_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-desc' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'desc_typo',
			'selector' => '{{WRAPPER}} .iatbd-hero-desc',
		] );

		$this->add_responsive_control( 'desc_max_width', [
			'label'      => esc_html__( 'Max Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 200, 'max' => 900 ], '%' => [ 'min' => 20, 'max' => 100 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-desc' => 'max-width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->end_controls_section();

		// ---- Buttons ----
		$this->start_controls_section( 'style_buttons', [
			'label' => esc_html__( 'Buttons', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'btn_typo',
			'selector' => '{{WRAPPER}} .iatbd-hero-btn1, {{WRAPPER}} .iatbd-hero-btn2',
		] );

		$this->add_responsive_control( 'btn_padding', [
			'label'      => esc_html__( 'Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-btn1, {{WRAPPER}} .iatbd-hero-btn2' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'btn_radius', [
			'label'      => esc_html__( 'Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-btn1, {{WRAPPER}} .iatbd-hero-btn2' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'btn_gap', [
			'label'      => esc_html__( 'Gap Between Buttons', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-btns' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'btn1_heading', [
			'label'     => esc_html__( 'Main Button', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'btn1_color', [
			'label'     => esc_html__( 'Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-btn1' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn1_color_hover', [
			'label'     => esc_html__( 'Hover Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-btn1:hover' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn2_heading', [
			'label'     => esc_html__( 'Second Button', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'btn2_color', [
			'label'     => esc_html__( 'Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-btn2' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn2_border', [
			'label'     => esc_html__( 'Border Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-btn2' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn2_bg_hover', [
			'label'     => esc_html__( 'Hover Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-btn2:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'btn2_color_hover', [
			'label'     => esc_html__( 'Hover Text Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-btn2:hover' => 'color: {{VALUE}};' ],
		] );

		$this->end_controls_section();

		// ---- Feature card ----
		$this->start_controls_section( 'style_card', [
			'label' => esc_html__( 'Feature Card', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_control( 'card_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'alpha'     => true,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-card' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'card_border', [
			'label'     => esc_html__( 'Border Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'alpha'     => true,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-card' => 'border-color: {{VALUE}};' ],
		] );

		$this->add_responsive_control( 'card_radius', [
			'label'      => esc_html__( 'Border Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 60 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-card' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'card_padding', [
			'label'      => esc_html__( 'Padding', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::DIMENSIONS,
			'size_units' => [ 'px', 'em' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-card' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_box_size', [
			'label'      => esc_html__( 'Icon Box Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 24, 'max' => 100 ] ],
			'default'    => [ 'size' => 48, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-fbox' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_box_radius', [
			'label'      => esc_html__( 'Icon Box Radius', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px', '%' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 50 ], '%' => [ 'min' => 0, 'max' => 50 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-fbox' => 'border-radius: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'icon_size', [
			'label'      => esc_html__( 'Icon Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 10, 'max' => 60 ] ],
			'selectors'  => [
				'{{WRAPPER}} .iatbd-hero-fbox i'   => 'font-size: {{SIZE}}{{UNIT}};',
				'{{WRAPPER}} .iatbd-hero-fbox svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
			],
		] );

		$this->add_control( 'ftitle_heading', [
			'label'     => esc_html__( 'Feature Title', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'ftitle_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-ftitle' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'ftitle_typo',
			'selector' => '{{WRAPPER}} .iatbd-hero-ftitle',
		] );

		$this->add_control( 'ftext_heading', [
			'label'     => esc_html__( 'Feature Text', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'ftext_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-ftext' => 'color: {{VALUE}};' ],
		] );

		$this->add_group_control( \Elementor\Group_Control_Typography::get_type(), [
			'name'     => 'ftext_typo',
			'selector' => '{{WRAPPER}} .iatbd-hero-ftext',
		] );

		$this->end_controls_section();

		// ---- Navigation ----
		$this->start_controls_section( 'style_nav', [
			'label' => esc_html__( 'Arrows & Dots', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
		] );

		$this->add_responsive_control( 'nav_bottom', [
			'label'      => esc_html__( 'Bottom Offset', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 150 ] ],
			'default'    => [ 'size' => 24, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-nav' => 'bottom: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'nav_gap', [
			'label'      => esc_html__( 'Gap', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 0, 'max' => 40 ] ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-nav' => 'gap: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'arrow_heading', [
			'label'     => esc_html__( 'Arrows', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'arrow_size', [
			'label'      => esc_html__( 'Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 20, 'max' => 70 ] ],
			'default'    => [ 'size' => 36, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-arrow' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'arrow_color', [
			'label'     => esc_html__( 'Icon Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-arrow' => 'color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_bg', [
			'label'     => esc_html__( 'Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'alpha'     => true,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-arrow' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'arrow_bg_hover', [
			'label'     => esc_html__( 'Hover Background', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'alpha'     => true,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-arrow:hover' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'dot_heading', [
			'label'     => esc_html__( 'Dots', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_responsive_control( 'dot_size', [
			'label'      => esc_html__( 'Size', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 30 ] ],
			'default'    => [ 'size' => 10, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-dot' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_responsive_control( 'dot_active_width', [
			'label'      => esc_html__( 'Active Dot Width', 'elementor-test' ),
			'type'       => \Elementor\Controls_Manager::SLIDER,
			'size_units' => [ 'px' ],
			'range'      => [ 'px' => [ 'min' => 4, 'max' => 80 ] ],
			'default'    => [ 'size' => 28, 'unit' => 'px' ],
			'selectors'  => [ '{{WRAPPER}} .iatbd-hero-dot.active' => 'width: {{SIZE}}{{UNIT}};' ],
		] );

		$this->add_control( 'dot_color', [
			'label'     => esc_html__( 'Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'alpha'     => true,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-dot' => 'background-color: {{VALUE}};' ],
		] );

		$this->add_control( 'dot_active_color', [
			'label'     => esc_html__( 'Active Color', 'elementor-test' ),
			'type'      => \Elementor\Controls_Manager::COLOR,
			'selectors' => [ '{{WRAPPER}} .iatbd-hero-dot.active' => 'background-color: {{VALUE}};' ],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * HELPERS
	 * ===================================================================== */

	/** Heading: new line => <br>, {accent}..{/accent} => highlighted span. */
	private function format_heading( $text ) {
		$text = esc_html( $text );
		$text = str_replace(
			[ '{accent}', '{/accent}' ],
			[ '<span class="iatbd-hero-accent">', '</span>' ],
			$text
		);
		return nl2br( $text );
	}

	/** Slider mechanics CSS (printed once per page). */
	private function print_base_css() {
		static $printed = false;
		if ( $printed ) {
			return;
		}
		$printed = true;
		?>
		<style>
			.iatbd-hero{position:relative;overflow:hidden}
			.iatbd-hero-slides{display:grid}
			.iatbd-hero-slide{grid-area:1/1;position:relative;display:flex;align-items:center;min-height:600px;opacity:0;visibility:hidden;transition:opacity .7s ease,visibility .7s ease}
			.iatbd-hero-slide.active{opacity:1;visibility:visible;z-index:1}
			.iatbd-hero-bg,.iatbd-hero-overlay{position:absolute;top:0;right:0;bottom:0;left:0}
			.iatbd-hero-bg{background-size:cover;background-position:center;background-repeat:no-repeat}
			.iatbd-hero-content{position:relative;z-index:2;width:100%;padding-top:3rem;padding-bottom:5rem}
			.iatbd-hero-badge{display:inline-flex;align-items:center;gap:.5rem;border:1px solid transparent}
			.iatbd-hero-btn1,.iatbd-hero-btn2{display:inline-flex;align-items:center;gap:.5rem;text-decoration:none;transition:all .2s ease}
			.iatbd-hero-btn1:hover{filter:brightness(1.1)}
			.iatbd-hero-btn2{border:1px solid rgba(255,255,255,.25)}
			.iatbd-hero-btn2:hover{background-color:rgba(255,255,255,.1)}
			.iatbd-hero-nav{position:absolute;left:0;right:0;bottom:24px;z-index:5;display:flex;align-items:center;justify-content:center;gap:10px}
			.iatbd-hero-arrow,.iatbd-hero-dot{-webkit-appearance:none;appearance:none;cursor:pointer;outline:none;box-shadow:none}
			.iatbd-hero-arrow{width:36px;height:36px;padding:0;border-radius:9999px;display:inline-flex;align-items:center;justify-content:center;background-color:rgba(255,255,255,.12);color:#fff;border:1px solid rgba(255,255,255,.2);transition:background-color .2s ease}
			.iatbd-hero-arrow:hover{background-color:rgba(255,255,255,.25)}
			.iatbd-hero-dot{width:10px;height:10px;padding:0;border:0;border-radius:9999px;background-color:rgba(255,255,255,.4);transition:all .3s ease}
			.iatbd-hero-dot.active{width:28px;background-color:#fff}
		</style>
		<?php
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		if ( empty( $s['slides'] ) ) {
			return;
		}

		$this->print_base_css();

		$root_id   = 'iatbd-hero-' . $this->get_id();
		$count     = count( $s['slides'] );
		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();
		$autoplay  = ( 'yes' === $s['autoplay'] && ! $is_editor && $count > 1 );
		$delay     = max( 1500, (int) $s['autoplay_speed'] );
		?>

		<section id="<?php echo esc_attr( $root_id ); ?>" class="iatbd-hero servo-hero overflow-hidden">
			<div class="iatbd-hero-slides">

				<?php
				foreach ( $s['slides'] as $i => $slide ) :
					$is_split = ( 'split' === $slide['layout'] );
					$bg_url   = ! empty( $slide['bg_image']['url'] ) ? $slide['bg_image']['url'] : '';
					$overlay  = sprintf(
						'background-image:linear-gradient(to right,%s,%s,%s);',
						$slide['overlay_from'] ?: 'rgba(2,6,23,0.95)',
						$slide['overlay_via'] ?: 'rgba(15,23,42,0.8)',
						$slide['overlay_to'] ?: 'rgba(15,23,42,0.4)'
					);

					$btn1_key = 'btn1_' . $i;
					$btn2_key = 'btn2_' . $i;
					$this->add_render_attribute( $btn1_key, 'class', 'iatbd-hero-btn1 px-6 py-3 text-white font-semibold rounded-full shadow-lg btn-cta' );
					$this->add_render_attribute( $btn2_key, 'class', 'iatbd-hero-btn2 px-6 py-3 text-white font-medium rounded-full btn-cta-outline' );
					if ( ! empty( $slide['btn1_link']['url'] ) ) {
						$this->add_link_attributes( $btn1_key, $slide['btn1_link'] );
					}
					if ( ! empty( $slide['btn2_link']['url'] ) ) {
						$this->add_link_attributes( $btn2_key, $slide['btn2_link'] );
					}
					?>
					<div class="iatbd-hero-slide servo-slide elementor-repeater-item-<?php echo esc_attr( $slide['_id'] ); ?><?php echo 0 === $i ? ' active' : ''; ?>" data-i="<?php echo esc_attr( $i ); ?>" aria-hidden="<?php echo 0 === $i ? 'false' : 'true'; ?>">

						<div class="iatbd-hero-bg"<?php echo $bg_url ? ' style="background-image:url(\'' . esc_url( $bg_url ) . '\')"' : ''; ?>></div>
						<div class="iatbd-hero-overlay" style="<?php echo esc_attr( $overlay ); ?>"></div>

						<div class="iatbd-hero-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
							<div class="<?php echo $is_split ? 'grid lg:grid-cols-2 gap-10 items-center' : 'max-w-2xl'; ?>">

								<div>
									<?php if ( ! empty( $slide['badge_text'] ) ) : ?>
										<div class="iatbd-hero-badge px-3 py-1 rounded-full text-xs font-semibold mb-6 tracking-wide">
											<?php
											if ( ! empty( $slide['badge_icon']['value'] ) ) {
												\Elementor\Icons_Manager::render_icon( $slide['badge_icon'], [ 'aria-hidden' => 'true' ] );
											}
											echo esc_html( $slide['badge_text'] );
											?>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $slide['heading'] ) ) : ?>
										<h1 class="iatbd-hero-heading font-display text-4xl sm:text-5xl font-bold text-white leading-[1.12] mb-5"><?php echo wp_kses_post( $this->format_heading( $slide['heading'] ) ); ?></h1>
									<?php endif; ?>

									<?php if ( ! empty( $slide['description'] ) ) : ?>
										<p class="iatbd-hero-desc text-slate-300 text-[17px] leading-relaxed mb-8 max-w-md"><?php echo esc_html( $slide['description'] ); ?></p>
									<?php endif; ?>

									<?php if ( ! empty( $slide['btn1_text'] ) || ! empty( $slide['btn2_text'] ) ) : ?>
										<div class="iatbd-hero-btns flex flex-wrap gap-3">
											<?php if ( ! empty( $slide['btn1_text'] ) ) : ?>
												<a <?php $this->print_render_attribute_string( $btn1_key ); ?>>
													<?php
													echo esc_html( $slide['btn1_text'] ) . ' ';
													if ( ! empty( $slide['btn1_icon']['value'] ) ) {
														\Elementor\Icons_Manager::render_icon( $slide['btn1_icon'], [ 'aria-hidden' => 'true', 'class' => 'text-xs' ] );
													}
													?>
												</a>
											<?php endif; ?>
											<?php if ( ! empty( $slide['btn2_text'] ) ) : ?>
												<a <?php $this->print_render_attribute_string( $btn2_key ); ?>><?php echo esc_html( $slide['btn2_text'] ); ?></a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>

								<?php if ( $is_split ) : ?>
									<div class="hidden lg:block">
										<div class="iatbd-hero-card bg-white/10 backdrop-blur-md border border-white/15 rounded-3xl p-8 space-y-5">
											<?php
											for ( $n = 1; $n <= 3; $n++ ) :
												if ( empty( $slide[ "f{$n}_title" ] ) && empty( $slide[ "f{$n}_text" ] ) ) {
													continue;
												}
												?>
												<div class="iatbd-hero-f<?php echo (int) $n; ?> flex items-center gap-4">
													<div class="iatbd-hero-fbox w-12 h-12 rounded-2xl flex items-center justify-center">
														<?php
														if ( ! empty( $slide[ "f{$n}_icon" ]['value'] ) ) {
															\Elementor\Icons_Manager::render_icon( $slide[ "f{$n}_icon" ], [ 'aria-hidden' => 'true', 'class' => 'text-lg' ] );
														}
														?>
													</div>
													<div>
														<p class="iatbd-hero-ftitle text-white font-semibold"><?php echo esc_html( $slide[ "f{$n}_title" ] ); ?></p>
														<p class="iatbd-hero-ftext text-slate-400 text-[17px]"><?php echo esc_html( $slide[ "f{$n}_text" ] ); ?></p>
													</div>
												</div>
											<?php endfor; ?>
										</div>
									</div>
								<?php endif; ?>

							</div>
						</div>
					</div>
				<?php endforeach; ?>

			</div>

			<?php if ( $count > 1 && ( 'yes' === $s['show_arrows'] || 'yes' === $s['show_dots'] ) ) : ?>
				<div class="iatbd-hero-nav hero-nav">
					<?php if ( 'yes' === $s['show_arrows'] ) : ?>
						<button type="button" class="iatbd-hero-arrow prev" aria-label="<?php esc_attr_e( 'Previous slide', 'elementor-test' ); ?>">
							<i class="fas fa-chevron-left text-xs"></i>
						</button>
					<?php endif; ?>

					<?php if ( 'yes' === $s['show_dots'] ) : ?>
						<?php for ( $d = 0; $d < $count; $d++ ) : ?>
							<button type="button" class="iatbd-hero-dot<?php echo 0 === $d ? ' active' : ''; ?>" data-i="<?php echo (int) $d; ?>" aria-label="<?php echo esc_attr( sprintf( __( 'Go to slide %d', 'elementor-test' ), $d + 1 ) ); ?>"></button>
						<?php endfor; ?>
					<?php endif; ?>

					<?php if ( 'yes' === $s['show_arrows'] ) : ?>
						<button type="button" class="iatbd-hero-arrow next" aria-label="<?php esc_attr_e( 'Next slide', 'elementor-test' ); ?>">
							<i class="fas fa-chevron-right text-xs"></i>
						</button>
					<?php endif; ?>
				</div>
			<?php endif; ?>
		</section>

		<script>
		(function () {
			var root = document.getElementById('<?php echo esc_js( $root_id ); ?>');
			if (!root) return;
			var slides = root.querySelectorAll('.iatbd-hero-slide');
			var dots   = root.querySelectorAll('.iatbd-hero-dot');
			var cur = 0, timer = null;
			var auto = <?php echo $autoplay ? 'true' : 'false'; ?>;
			var delay = <?php echo (int) $delay; ?>;
			var pauseHover = <?php echo ( 'yes' === $s['pause_hover'] ) ? 'true' : 'false'; ?>;

			function go(i) {
				cur = (i + slides.length) % slides.length;
				for (var a = 0; a < slides.length; a++) {
					var on = (a === cur);
					slides[a].classList.toggle('active', on);
					slides[a].setAttribute('aria-hidden', on ? 'false' : 'true');
				}
				for (var b = 0; b < dots.length; b++) {
					dots[b].classList.toggle('active', b === cur);
				}
			}
			function stop() { if (timer) { clearInterval(timer); timer = null; } }
			function start() {
				if (!auto) return;
				stop();
				timer = setInterval(function () {
					if (!document.body.contains(root)) { stop(); return; }
					go(cur + 1);
				}, delay);
			}

			var prev = root.querySelector('.iatbd-hero-arrow.prev');
			var next = root.querySelector('.iatbd-hero-arrow.next');
			if (prev) prev.addEventListener('click', function () { go(cur - 1); start(); });
			if (next) next.addEventListener('click', function () { go(cur + 1); start(); });
			for (var d = 0; d < dots.length; d++) {
				(function (idx) {
					dots[idx].addEventListener('click', function () { go(idx); start(); });
				})(d);
			}
			if (pauseHover) {
				root.addEventListener('mouseenter', stop);
				root.addEventListener('mouseleave', start);
			}
			start();
		})();
		</script>

		<?php
	}
}