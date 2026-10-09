<?php
/**
 * IATBD Counter Boxes (repeater)
 *
 * Markup/classes are the same as the original static HTML
 * (.count-box, .counter[data-target][data-suffix]), so your existing
 * counter JS keeps working. Only the content is made editable.
 */
class IATBD_Counter extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_counter';
	}

	public function get_title() {
		return esc_html__( 'IATBD Counter Boxes', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'counter', 'count', 'stats', 'numbers', 'iatbd' ];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		$this->start_controls_section( 'counter_section', [
			'label' => esc_html__( 'Counter Boxes', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$r = new \Elementor\Repeater();

		$r->add_control( 'target', [
			'label'   => esc_html__( 'Number', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'default' => 10,
		] );

		$r->add_control( 'suffix', [
			'label'       => esc_html__( 'Suffix', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '+',
			'placeholder' => '+  or  /7  or  %',
		] );

		$r->add_control( 'label', [
			'label'       => esc_html__( 'Label', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Label',
			'label_block' => true,
		] );

		$r->add_control( 'color', [
			'label'   => esc_html__( 'Number Color', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary', 'elementor-test' ),
				'accent'  => esc_html__( 'Accent', 'elementor-test' ),
				'emerald' => esc_html__( 'Emerald', 'elementor-test' ),
				'purple'  => esc_html__( 'Purple', 'elementor-test' ),
			],
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'title_field' => '{{{ target }}}{{{ suffix }}} — {{{ label }}}',
			'default'     => [
				[ 'target' => 12,  'suffix' => '+',  'label' => 'Servo Brands',       'color' => 'primary' ],
				[ 'target' => 120, 'suffix' => '+',  'label' => 'Axes Commissioned',  'color' => 'accent' ],
				[ 'target' => 24,  'suffix' => '/7', 'label' => 'Support',            'color' => 'emerald' ],
				[ 'target' => 10,  'suffix' => '+',  'label' => 'Years Experience',   'color' => 'purple' ],
			],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		if ( empty( $s['items'] ) ) {
			return;
		}

		// Color classes written out in full (same as the original design)
		// so Tailwind can detect them.
		$colors = [
			'primary' => 'text-primary-600 dark:text-primary-400',
			'accent'  => 'text-accent-500',
			'emerald' => 'text-emerald-500',
			'purple'  => 'text-purple-500',
		];
		?>

		<section class="relative z-10 -mt-8 px-4">
			<div class="max-w-5xl mx-auto">
				<div class="grid grid-cols-2 md:grid-cols-4 gap-3 sm:gap-4">

					<?php
					foreach ( $s['items'] as $item ) :
						$color = isset( $colors[ $item['color'] ] ) ? $colors[ $item['color'] ] : $colors['primary'];
						?>
						<div class="count-box bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 p-5 sm:p-6 text-center shadow-lg shadow-slate-200/40 dark:shadow-none">
							<p class="font-display text-3xl sm:text-4xl font-bold <?php echo esc_attr( $color ); ?>">
								<span class="counter" data-target="<?php echo esc_attr( $item['target'] ); ?>" data-suffix="<?php echo esc_attr( $item['suffix'] ); ?>">0</span>
							</p>
							<p class="text-[17px] text-slate-600 dark:text-slate-400 mt-1"><?php echo esc_html( $item['label'] ); ?></p>
						</div>
					<?php endforeach; ?>

				</div>
			</div>
		</section>

		<?php
	}
}