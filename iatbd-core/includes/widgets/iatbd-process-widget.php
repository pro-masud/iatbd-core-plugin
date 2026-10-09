<?php
/**
 * IATBD Process Section (4 fixed steps, no repeater, no Elementor icon picker)
 *
 * Markup/classes are the same as the original static HTML
 * (.process-card, .process-num ...). Only the content is made editable.
 */
class IATBD_Process extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_process';
	}

	public function get_title() {
		return esc_html__( 'IATBD Process', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'process', 'steps', 'how it works', 'iatbd' ];
	}

	/** Default content of the 4 steps (same as the original HTML). */
	private function get_step_defaults() {
		return [
			1 => [
				'icon'  => 'fas fa-calculator',
				'label' => 'STEP 01',
				'title' => 'Load & inertia study',
				'desc'  => 'Mass, friction, duty cycle and required accuracy — motor and drive selected to match.',
			],
			2 => [
				'icon'  => 'fas fa-plug',
				'label' => 'STEP 02',
				'title' => 'Wire, power & safety',
				'desc'  => 'Power, encoder, STO and network cables installed to OEM and EMC best practice.',
			],
			3 => [
				'icon'  => 'fas fa-sliders-h',
				'label' => 'STEP 03',
				'title' => 'Tune & integrate',
				'desc'  => 'Auto-tune, filters, homing and PLC/motion link — verified under real load.',
			],
			4 => [
				'icon'  => 'fas fa-file-alt',
				'label' => 'STEP 04',
				'title' => 'Document & support',
				'desc'  => 'Parameter backup, operator notes and ongoing fault response when you need it.',
			],
		];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		// ---- Background + header ----
		$this->start_controls_section( 'header_section', [
			'label' => esc_html__( 'Background & Header', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80' ],
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Small Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Process',
			'label_block' => true,
			'separator'   => 'before',
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'How a servo project runs',
			'label_block' => true,
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Clear steps from load calculation to stable production.',
		] );

		$this->end_controls_section();

		// ---- 4 steps ----
		foreach ( $this->get_step_defaults() as $n => $d ) {

			$this->start_controls_section( "step{$n}_section", [
				'label' => sprintf( esc_html__( 'Step %d', 'elementor-test' ), $n ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			] );

			$this->add_control( "s{$n}_icon", [
				'label'       => esc_html__( 'Icon (Font Awesome class)', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['icon'],
				'placeholder' => 'fas fa-cogs',
				'label_block' => true,
			] );

			$this->add_control( "s{$n}_label", [
				'label'       => esc_html__( 'Step Label', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['label'],
				'label_block' => true,
			] );

			$this->add_control( "s{$n}_title", [
				'label'       => esc_html__( 'Title', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['title'],
				'label_block' => true,
			] );

			$this->add_control( "s{$n}_desc", [
				'label'   => esc_html__( 'Description', 'elementor-test' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => $d['desc'],
			] );

			$this->end_controls_section();
		}
	}

	/* =====================================================================
	 * HELPERS
	 * ===================================================================== */

	/** Keep only safe characters for a Font Awesome class string. */
	private function icon_class( $class ) {
		return esc_attr( trim( preg_replace( '/[^a-zA-Z0-9\s\-_]/', '', (string) $class ) ) );
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		// Per-step colors — written out in full (same as the original)
		// so Tailwind can detect them.
		$colors = [
			1 => [ 'box' => 'bg-primary-500',  'label' => 'text-primary-500 dark:text-primary-400' ],
			2 => [ 'box' => 'bg-accent-500',   'label' => 'text-accent-500 dark:text-accent-400' ],
			3 => [ 'box' => 'bg-emerald-500',  'label' => 'text-emerald-500 dark:text-emerald-400' ],
			4 => [ 'box' => 'bg-purple-500',   'label' => 'text-purple-500 dark:text-purple-400' ],
		];

		$bg_url = ! empty( $s['bg_image']['url'] ) ? $s['bg_image']['url'] : '';
		?>

		<section class="relative py-20 sm:py-28 overflow-hidden">
			<!-- Full background image (always visible) -->
			<div
				class="absolute inset-0 bg-cover bg-center bg-no-repeat scale-105"
				<?php echo $bg_url ? 'style="background-image: url(\'' . esc_url( $bg_url ) . '\');"' : ''; ?>
			></div>
			<!-- Light: ~55% white so image still shows | Dark: ~75% slate -->
			<div class="absolute inset-0 bg-white/55 dark:bg-slate-950/78"></div>
			<div class="absolute inset-0 bg-gradient-to-t from-white/40 via-transparent to-white/30 dark:from-slate-950/50 dark:via-transparent dark:to-slate-950/40"></div>

			<div class="relative z-10 max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center mb-12 sm:mb-14">
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<p class="text-accent-600 dark:text-accent-400 text-xs font-semibold tracking-[0.2em] uppercase mb-3 drop-shadow-sm"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $s['heading'] ) ) : ?>
						<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-3 drop-shadow-sm"><?php echo esc_html( $s['heading'] ); ?></h2>
					<?php endif; ?>
					<?php if ( ! empty( $s['description'] ) ) : ?>
						<p class="text-[17px] text-slate-700 dark:text-slate-200 max-w-lg mx-auto font-medium"><?php echo esc_html( $s['description'] ); ?></p>
					<?php endif; ?>
				</div>

				<div class="grid sm:grid-cols-2 gap-5">
					<?php for ( $n = 1; $n <= 4; $n++ ) : ?>
						<div class="process-card group bg-white dark:bg-slate-800 rounded-2xl p-6 border border-slate-200 dark:border-slate-700 shadow-lg cursor-default">
							<div class="flex items-start gap-4">
								<div class="process-num w-12 h-12 rounded-2xl <?php echo esc_attr( $colors[ $n ]['box'] ); ?> text-white flex items-center justify-center text-lg shrink-0 shadow-md">
									<?php if ( ! empty( $s[ "s{$n}_icon" ] ) ) : ?>
										<i class="<?php echo $this->icon_class( $s[ "s{$n}_icon" ] ); ?>"></i>
									<?php endif; ?>
								</div>
								<div>
									<?php if ( ! empty( $s[ "s{$n}_label" ] ) ) : ?>
										<span class="text-xs font-bold <?php echo esc_attr( $colors[ $n ]['label'] ); ?> tracking-wide"><?php echo esc_html( $s[ "s{$n}_label" ] ); ?></span>
									<?php endif; ?>
									<h3 class="font-semibold text-slate-900 dark:text-white mb-1.5 mt-0.5"><?php echo esc_html( $s[ "s{$n}_title" ] ); ?></h3>
									<p class="text-[17px] text-slate-600 dark:text-slate-300 leading-relaxed"><?php echo esc_html( $s[ "s{$n}_desc" ] ); ?></p>
								</div>
							</div>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</section>

		<?php
	}
}