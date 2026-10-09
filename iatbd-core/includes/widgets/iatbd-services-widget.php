<?php
/**
 * IATBD Services Section (6 fixed cards, no repeater, no Elementor icon picker)
 *
 * Markup/classes are the same as the original static HTML
 * (#services, .svc-card ...). Only the content is made editable.
 */
class IATBD_Services extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_services';
	}

	public function get_title() {
		return esc_html__( 'IATBD Services', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'services', 'cards', 'grid', 'iatbd' ];
	}

	/** Default content of the 6 cards (same as the original HTML). */
	private function get_card_defaults() {
		return [
			1 => [
				'image' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=700&q=80',
				'icon'  => 'fas fa-calculator',
				'title' => 'Sizing & Selection',
				'desc'  => 'Torque, inertia ratio, encoder resolution and ambient conditions matched to the right motor–drive pair.',
			],
			2 => [
				'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=700&q=80',
				'icon'  => 'fas fa-sliders-h',
				'title' => 'Auto-Tuning & Gains',
				'desc'  => 'Position/speed/torque loops, notch filters and damping so axes settle cleanly without vibration.',
			],
			3 => [
				'image' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=700&q=80',
				'icon'  => 'fas fa-cogs',
				'title' => 'Install & Commission',
				'desc'  => 'Wiring, encoder cables, STO safety, homing routines and full load verification on site.',
			],
			4 => [
				'image' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=700&q=80',
				'icon'  => 'fas fa-project-diagram',
				'title' => 'Multi-Axis Sync',
				'desc'  => 'Electronic gearing, camming and coordinated motion with PLC or dedicated motion controllers.',
			],
			5 => [
				'image' => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=700&q=80',
				'icon'  => 'fas fa-sync-alt',
				'title' => 'Retrofit & Upgrade',
				'desc'  => 'Replace aging servos with modern drives while keeping mechanics and minimizing downtime.',
			],
			6 => [
				'image' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=700&q=80',
				'icon'  => 'fas fa-tools',
				'title' => 'Repair & Diagnostics',
				'desc'  => 'Alarm analysis, encoder/drive repair, parameter recovery and preventive health checks.',
			],
		];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		// ---- Section header ----
		$this->start_controls_section( 'header_section', [
			'label' => esc_html__( 'Section Header', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Small Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Services',
			'label_block' => true,
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Servo services we deliver',
			'label_block' => true,
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Right Side Text', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'From single axis retrofit to multi-axis packaging lines.',
		] );

		$this->end_controls_section();

		// ---- 6 cards ----
		foreach ( $this->get_card_defaults() as $n => $d ) {

			$this->start_controls_section( "card{$n}_section", [
				'label' => sprintf( esc_html__( 'Card %d', 'elementor-test' ), $n ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			] );

			$this->add_control( "c{$n}_image", [
				'label'   => esc_html__( 'Image', 'elementor-test' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [ 'url' => $d['image'] ],
			] );

			$this->add_control( "c{$n}_icon", [
				'label'       => esc_html__( 'Icon (Font Awesome class)', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['icon'],
				'placeholder' => 'fas fa-cogs',
				'label_block' => true,
			] );

			$this->add_control( "c{$n}_title", [
				'label'       => esc_html__( 'Title', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['title'],
				'label_block' => true,
			] );

			$this->add_control( "c{$n}_desc", [
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

		// Icon box colors per card — written out in full (same as the original)
		// so Tailwind can detect them.
		$colors = [
			1 => 'bg-primary-500',
			2 => 'bg-accent-500',
			3 => 'bg-emerald-500',
			4 => 'bg-purple-500',
			5 => 'bg-cyan-500',
			6 => 'bg-rose-500',
		];
		?>

		<section id="services" class="py-20 sm:py-24 bg-slate-50 dark:bg-slate-900/60">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<div class="flex flex-col sm:flex-row sm:items-end sm:justify-between gap-4 mb-12">
					<div>
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-2"><?php echo esc_html( $s['eyebrow'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>
					</div>
					<?php if ( ! empty( $s['description'] ) ) : ?>
						<p class="text-[17px] text-slate-600 dark:text-slate-300 max-w-sm"><?php echo esc_html( $s['description'] ); ?></p>
					<?php endif; ?>
				</div>

				<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-5">
					<?php
					for ( $n = 1; $n <= 6; $n++ ) :
						$img = ! empty( $s[ "c{$n}_image" ]['url'] ) ? $s[ "c{$n}_image" ]['url'] : '';
						?>
						<article class="svc-card bg-white dark:bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700/80">
							<div class="relative h-52 sm:h-56 overflow-hidden">
								<?php if ( $img ) : ?>
									<img src="<?php echo esc_url( $img ); ?>" alt="" class="w-full h-full object-cover" />
								<?php endif; ?>
								<div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
								<?php if ( ! empty( $s[ "c{$n}_icon" ] ) ) : ?>
									<span class="absolute bottom-3 left-3 w-10 h-10 rounded-lg <?php echo esc_attr( $colors[ $n ] ); ?> flex items-center justify-center text-white">
										<i class="<?php echo $this->icon_class( $s[ "c{$n}_icon" ] ); ?>"></i>
									</span>
								<?php endif; ?>
							</div>
							<div class="p-5">
								<h3 class="font-display font-semibold text-slate-900 dark:text-white mb-1.5"><?php echo esc_html( $s[ "c{$n}_title" ] ); ?></h3>
								<p class="text-[17px] text-slate-600 dark:text-slate-300 leading-relaxed"><?php echo esc_html( $s[ "c{$n}_desc" ] ); ?></p>
							</div>
						</article>
					<?php endfor; ?>
				</div>

			</div>
		</section>

		<?php
	}
}