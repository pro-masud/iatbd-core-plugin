<?php
/**
 * Elementor List Widget.
 *
 * Elementor widget that inserts an embbedable content into the page, from any given URL.
 *
 * @since 1.0.0
 */
class Widget_1 extends \Elementor\Widget_Base {

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
		return 'test_widgets';
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
		return esc_html__( 'Elementor Test Widget', 'elementor-test' );
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
		return [ 'elementor', 'test', 'category', 'unordered' ];
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
		
   <header
      class="fixed top-0 inset-x-0 z-50 bg-white/85 dark:bg-slate-900/85 backdrop-blur-xl border-b border-slate-200/70 dark:border-slate-800"
    >
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16 lg:h-[70px]">
          <a href="#" class="flex items-center gap-3">
            <div
              class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-md shadow-primary-500/20"
            >
              <i class="fas fa-microchip text-white text-sm"></i>
            </div>
            <div>
              <span
                class="font-display font-bold text-lg text-slate-900 dark:text-white tracking-tight"
                >IATBD</span
              >
              <p
                class="text-[9px] text-slate-400 tracking-[0.2em] uppercase -mt-0.5"
              >
                Industrial Automation
              </p>
            </div>
          </a>
          <nav class="hidden lg:flex items-center gap-1">
            <a
              href="index.html"
              class="nav-link active px-3.5 py-2 text-sm font-medium text-primary-600 dark:text-primary-400"
              >Home</a
            >
            <a
              href="plc-service.html"
              class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600"
              >PLC</a
            >
            <a
              href="store-shop.html"
              class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600"
              >Store</a
            >
            <a
              href="hmi-service.html"
              class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600"
              >HMI</a
            >
            <a
              href="vfd-service.html"
              class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600"
              >VFD</a
            >
            <a
              href="index.html#services"
              class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600"
              >Servo</a
            >
            <a
              href="ai-service.html"
              class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600"
              >AI</a
            >
            <div class="relative group">
              <button
                class="nav-link px-3.5 py-2 text-sm font-medium text-slate-600 dark:text-slate-300 hover:text-primary-600 flex items-center gap-1.5"
              >
                Service <i class="fas fa-chevron-down text-[9px]"></i>
              </button>
              <div
                class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden z-50"
              >
                <a
                  href="#services"
                  class="block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20"
                  >Maintenance</a
                >
                <a
                  href="#services"
                  class="block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20"
                  >Troubleshooting</a
                >
                <a
                  href="#contact"
                  class="block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20"
                  >Repairing</a
                >
              </div>
            </div>
          </nav>
          <div class="flex items-center gap-2">
            <button
              id="theme-toggle"
              type="button"
              aria-label="Switch to dark mode"
              aria-pressed="false"
              class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition"
            >
              <i class="fas fa-sun theme-icon-sun text-xs text-amber-500"></i>
              <i class="fas fa-moon theme-icon-moon text-xs text-slate-200"></i>
            </button>
            <a
              href="#contact"
              class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold rounded-full shadow-lg shadow-primary-500/20 btn-cta"
              >Contact</a
            >
            <button
              id="mobile-menu-btn"
              type="button"
              aria-label="Toggle navigation menu"
              aria-controls="mobile-menu"
              aria-expanded="false"
              class="lg:hidden w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center"
            >
              <i class="fas fa-bars text-slate-700 dark:text-slate-300"></i>
            </button>
          </div>
        </div>
      </div>
      <div
        id="mobile-menu"
        class="lg:hidden hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900"
      >
        <div class="px-4 py-3 space-y-1">
          <a
            href="#"
            class="block px-3 py-2.5 rounded-lg text-sm font-medium text-primary-600 bg-primary-50 dark:bg-primary-900/20"
            >Home</a
          >
          <a
            href="plc-service.html"
            class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300"
            >PLC</a
          >
          <a
            href="store-shop.html"
            class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300"
            >Store</a
          >
          <a
            href="hmi-service.html"
            class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300"
            >HMI</a
          >
          <a
            href="vfd-service.html"
            class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300"
            >VFD</a
          >
          <a
            href="index.html#services"
            class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300"
            >Servo</a
          >
          <a
            href="ai-service.html"
            class="block px-3 py-2.5 rounded-lg text-sm text-slate-600 dark:text-slate-300"
            >AI</a
          >
          <a
            href="#contact"
            class="block mt-2 text-center py-2.5 bg-primary-600 text-white rounded-xl text-sm font-semibold"
            >Contact</a
          >
        </div>
      </div>
    </header>

		<?php
	}


}
