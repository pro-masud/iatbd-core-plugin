<?php
/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Footer extends \Elementor\Widget_Base {

	/**
	 * Get widget name.
	 *
	 * Retrieve list widget name.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget name.
	 */
	public function get_name() {
		return 'footer';
	}

	/**
	 * Get widget title.
	 *
	 * Retrieve list widget title.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget title.
	 */
	public function get_title() {
		return esc_html__( 'Footer', 'elementor-test' );
	}

	/**
	 * Get widget icon.
	 *
	 * Retrieve list widget icon.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget icon.
	 */
	public function get_icon() {
		return 'eicon-bullet-list';
	}

	/**
	 * Get custom help URL.
	 *
	 * Retrieve a URL where the user can get more information about the widget.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return string Widget help URL.
	 */
	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	/**
	 * Get widget categories.
	 *
	 * Retrieve the list of categories the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget categories.
	 */
	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/**
	 * Get widget keywords.
	 *
	 * Retrieve the list of keywords the list widget belongs to.
	 *
	 * @since 1.0.0
	 * @access public
	 * @return array Widget keywords.
	 */
	public function get_keywords() {
		return [ 'Footer', 'test', 'category', 'unordered' ];
	}

	/**
	 * Register list widget controls.
	 *
	 * Add input fields to allow the user to customize the widget settings.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function register_controls() {

		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Elementor Test Widgets', 'elementor-test' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);


		$this->add_control(
			'heading',
			[
				'label'	=> esc_html__('Somthing Text', 'elementor-test'),
				'type'	=> \Elementor\Controls_Manager::TEXT,
				'default'	=> "Something Text",
			]
		);

		$this->add_control(
			'description',
			[
				'label'	=> esc_html__('Description', 'elementor-test'),
				'type'	=> \Elementor\Controls_Manager::TEXTAREA,
				'default'	=> "lorem ispsam text here",
			]
		);

		$this->end_controls_section();

		$this->start_controls_section(
			'text_alintment_header',
			[
				'label' => esc_html__( 'Text Alientment', 'elementor-test' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'text_alintment',
			[
				'label'	=> esc_html__('Alientment', 'elementor-test'),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default'	=> "center",
				'options'	=> [
					'left'		=> esc_html('Left', 'elementor-test'),
					'right'		=> esc_html('Right', 'elementor-test'),
					'center'		=> esc_html('Center', 'elementor-test'),
				],
				'selectors'	=> [
					'{{WRAPPER}} h2' => 'text-align:{{VALUE}}',
				],
			]
		);

		$this->add_control(
			'description_alintment',
			[
				'label'	=> esc_html__('Alientment', 'elementor-test'),
				'type'	=> \Elementor\Controls_Manager::SELECT,
				'default'	=> "center",
				'options'	=> [
					'left'		=> esc_html('Left', 'elementor-test'),
					'right'		=> esc_html('Right', 'elementor-test'),
					'center'		=> esc_html('Center', 'elementor-test'),
				],
				'selectors'	=> [
					'{{WRAPPER}} p' => 'text-align:{{VALUE}}',
				],
			]
		);

		$this->end_controls_section();


		$this->start_controls_section(
			'color',
			[
				'label' => esc_html__( 'Color', 'elementor-test' ),
				'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'border_popover_toggle',
			[
				'label' => esc_html__( 'Border', 'elementor-test' ),
				'type' => \Elementor\Controls_Manager::POPOVER_TOGGLE,
			]
		);

		$this->start_popover();
			$this->add_control(
				'header_color',
				[
					'label'	=> esc_html__('Heading Color', 'elementor-test'),
					'type'	=> \Elementor\Controls_Manager::COLOR,
					'default'	=> "#000",
					'selectors'	=> [
						'{{WRAPPER}} h2' => 'color:{{VALUE}}',
					],
				]
			);

			$this->add_control(
				'description_color',
				[
					'label'	=> esc_html__('Description Color', 'elementor-test'),
					'type'	=> \Elementor\Controls_Manager::COLOR,
					'default'	=> "red",
					'selectors'	=> [
						'{{WRAPPER}} p' => 'color:{{VALUE}}',
					],
				]
			);
		$this->end_popover();

		$this->end_controls_section();

	}

	/**
	 * Render list widget output on the frontend.
	 *
	 * Written in PHP and used to generate the final HTML.
	 *
	 * @since 1.0.0
	 * @access protected
	 */
	protected function render() {
		$settings = $this->get_settings_for_display();
		$heading = $settings['heading'];
		$description = $settings['description'];

		$this->add_inline_editing_attributes('heading', 'basic');
		$this->add_render_attribute(
			'pro',
			[
				'class' => [ 'heading', 'promasud', $heading ],
			]
		);

		$this->add_inline_editing_attributes('description', 'basic');
		?>
		
	<footer class="bg-slate-900 dark:bg-slate-950 text-slate-400 pt-14 pb-8 border-t border-slate-800">
		<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
			<div class="grid md:grid-cols-4 gap-10 mb-10">
				<div>
					<div class="flex items-center gap-2.5 mb-4">
					<div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center" >
						<i class="fas fa-microchip text-white text-xs"></i>
					</div>
					<span class="font-display font-bold text-white">IATBD</span>
					</div>
					<p class="text-[17px] leading-relaxed">
					Industrial automation — PLC, HMI, VFD, Servo and professional
					service.
					</p>
				</div>
				<div>
					<h4 class="text-white text-sm font-semibold mb-3">Services</h4>
					<ul class="space-y-2 text-sm">
						<li>
							<a
							href="plc-service.html"
							class="hover:text-primary-400 transition"
							>PLC</a
							>
						</li>
						<li>
							<a
							href="store-shop.html"
							class="hover:text-primary-400 transition"
							>Store</a
							>
						</li>
						<li>
							<a
							href="hmi-service.html"
							class="hover:text-primary-400 transition"
							>HMI</a
							>
						</li>
						<li>
							<a href="#services" class="hover:text-primary-400 transition"
							>VFD</a
							>
						</li>
						<li>
							<a href="#services" class="hover:text-primary-400 transition"
							>Servo</a
							>
						</li>
					</ul>
				</div>
				<div>
					<h4 class="text-white text-sm font-semibold mb-3">Support</h4>
					<ul class="space-y-2 text-sm">
						<li>
							<a href="#" class="hover:text-primary-400 transition"
							>Maintenance</a
							>
						</li>
						<li>
							<a href="#" class="hover:text-primary-400 transition"
							>Troubleshooting</a
							>
						</li>
						<li>
							<a href="#" class="hover:text-primary-400 transition"
							>Repairing</a
							>
						</li>
					</ul>
				</div>
				<div>
					<h4 class="text-white text-sm font-semibold mb-3">Contact</h4>
					<ul class="space-y-2 text-sm">
						<li>
							<i class="fas fa-phone-alt text-primary-400 mr-2"></i>+880
							1XXX-XXXXXX
						</li>
						<li>
							<i class="fas fa-envelope text-primary-400 mr-2"></i
							>info@iatbd.com
						</li>
					</ul>
				</div>
			</div>
			<div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-slate-500" >
				<p>© 2026 IATBD. All rights reserved.</p>
				<a href="#" class="hover:text-primary-400 transition">← Home</a>
			</div>
		</div>
	</footer>

		<?php
	}
}
