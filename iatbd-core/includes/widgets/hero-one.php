<?php
/**
 * IATBD Servo Hero (3 fixed slides, no repeater)
 *
 * Markup/classes are the same as the original static HTML,
 * so your existing .servo-slide / .servo-dot / .hero-arrow CSS & JS keep working.
 * Only the content is made editable from Elementor.
 */
class IATBD_Servo_Hero extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_servo_hero';
	}

	public function get_title() {
		return esc_html__( 'Servo Hero Slider', 'elementor-test' );
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
		return [ 'hero', 'slider', 'servo', 'iatbd' ];
	}

	/** Default content (same as the original HTML). */
	private function get_defaults() {
		return [
			1 => [
				'bg'         => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80',
				'badge_icon' => 'fas fa-cog fa-spin',
				'badge_text' => 'SERVO DRIVE',
				'heading'    => "Motion control\nwith {accent}micron precision{/accent}",
				'desc'       => 'Servo motor & drive sizing, auto-tuning, multi-axis sync and field support — for packaging, CNC, robotics and high-speed lines.',
				'btn1_text'  => 'Get a Quote',
				'btn1_url'   => '#contact',
				'btn1_icon'  => 'fas fa-arrow-right',
				'btn2_text'  => 'Our Services',
				'btn2_url'   => '#services',
			],
			2 => [
				'bg'         => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80',
				'badge_icon' => 'fas fa-sliders-h',
				'badge_text' => 'TUNING & COMMISSIONING',
				'heading'    => "Auto-tune.\n{accent}Zero vibration.{/accent}",
				'desc'       => 'Gain tuning, notch filters, inertia matching and load tests — so your axes settle fast without overshoot or resonance.',
				'btn1_text'  => 'Book Tuning',
				'btn1_url'   => '#contact',
				'btn1_icon'  => 'fas fa-arrow-right',
				'btn2_text'  => 'Capabilities',
				'btn2_url'   => '#services',
			],
			3 => [
				'bg'         => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1920&q=80',
				'badge_icon' => 'fas fa-tools',
				'badge_text' => 'REPAIR & SUPPORT',
				'heading'    => "Encoder, drive, motor.\n{accent}We fix the chain.{/accent}",
				'desc'       => 'Alarm diagnosis, encoder repair, drive replacement, parameter recovery and 24/7 support for critical motion axes.',
				'btn1_text'  => 'Get Support',
				'btn1_url'   => '#contact',
				'btn1_icon'  => 'fas fa-phone-alt',
				'btn2_text'  => 'View Services',
				'btn2_url'   => '#services',
			],
		];
	}

	/** Slide 1 feature card defaults. */
	private function get_feature_defaults() {
		return [
			1 => [ 'icon' => 'fas fa-crosshairs',   'title' => 'Position accuracy', 'text' => 'Closed-loop encoder feedback' ],
			2 => [ 'icon' => 'fas fa-bolt',         'title' => 'Dynamic response',  'text' => 'Fast accel, tight torque control' ],
			3 => [ 'icon' => 'fas fa-layer-group',  'title' => 'Multi-axis ready',  'text' => 'Sync, camming & electronic gearing' ],
		];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		$defaults = $this->get_defaults();
		$features = $this->get_feature_defaults();

		foreach ( $defaults as $n => $d ) {

			$this->start_controls_section( "slide{$n}_section", [
				'label' => sprintf( esc_html__( 'Slide %d', 'elementor-test' ), $n ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			] );

			$this->add_control( "s{$n}_bg", [
				'label'   => esc_html__( 'Background Image', 'elementor-test' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [ 'url' => $d['bg'] ],
			] );

			$this->add_control( "s{$n}_badge_icon", [
				'label'       => esc_html__( 'Badge Icon (Font Awesome class)', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['badge_icon'],
				'placeholder' => 'fas fa-cog',
				'label_block' => true,
				'separator'   => 'before',
			] );

			$this->add_control( "s{$n}_badge_text", [
				'label'       => esc_html__( 'Badge Text', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['badge_text'],
				'label_block' => true,
			] );

			$this->add_control( "s{$n}_heading", [
				'label'       => esc_html__( 'Heading', 'elementor-test' ),
				'description' => esc_html__( 'New line = line break. Put {accent}text{/accent} around the colored part.', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 3,
				'default'     => $d['heading'],
			] );

			$this->add_control( "s{$n}_desc", [
				'label'   => esc_html__( 'Description', 'elementor-test' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => $d['desc'],
			] );

			$this->add_control( "s{$n}_btn1_text", [
				'label'       => esc_html__( 'Button 1 Text', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['btn1_text'],
				'label_block' => true,
				'separator'   => 'before',
			] );

			$this->add_control( "s{$n}_btn1_link", [
				'label'   => esc_html__( 'Button 1 Link', 'elementor-test' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => [ 'url' => $d['btn1_url'] ],
			] );

			$this->add_control( "s{$n}_btn1_icon", [
				'label'       => esc_html__( 'Button 1 Icon (Font Awesome class)', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['btn1_icon'],
				'placeholder' => 'fas fa-arrow-right',
				'label_block' => true,
			] );

			$this->add_control( "s{$n}_btn2_text", [
				'label'       => esc_html__( 'Button 2 Text', 'elementor-test' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $d['btn2_text'],
				'label_block' => true,
				'separator'   => 'before',
			] );

			$this->add_control( "s{$n}_btn2_link", [
				'label'   => esc_html__( 'Button 2 Link', 'elementor-test' ),
				'type'    => \Elementor\Controls_Manager::URL,
				'default' => [ 'url' => $d['btn2_url'] ],
			] );

			// Slide 1 only: right-side feature card.
			if ( 1 === $n ) {
				foreach ( $features as $k => $f ) {
					$this->add_control( "s1_f{$k}_heading", [
						'label'     => sprintf( esc_html__( 'Card Item %d', 'elementor-test' ), $k ),
						'type'      => \Elementor\Controls_Manager::HEADING,
						'separator' => 'before',
					] );

					$this->add_control( "s1_f{$k}_icon", [
						'label'       => esc_html__( 'Icon (Font Awesome class)', 'elementor-test' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => $f['icon'],
						'label_block' => true,
					] );

					$this->add_control( "s1_f{$k}_title", [
						'label'       => esc_html__( 'Title', 'elementor-test' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => $f['title'],
						'label_block' => true,
					] );

					$this->add_control( "s1_f{$k}_text", [
						'label'       => esc_html__( 'Text', 'elementor-test' ),
						'type'        => \Elementor\Controls_Manager::TEXT,
						'default'     => $f['text'],
						'label_block' => true,
					] );
				}
			}

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

	/** Heading: new line => <br>, {accent}..{/accent} => colored span. */
	private function format_heading( $text, $accent_class ) {
		$text = esc_html( $text );
		$text = str_replace(
			[ '{accent}', '{/accent}' ],
			[ '<span class="' . esc_attr( $accent_class ) . '">', '</span>' ],
			$text
		);
		return nl2br( $text );
	}

	/** Left text block (badge, heading, description, buttons). */
	private function render_text( $s, $n, $t ) {
		$this->add_render_attribute( "s{$n}_b1", 'class', $t['btn1'] );
		$this->add_render_attribute( "s{$n}_b2", 'class', 'inline-flex items-center gap-2 px-6 py-3 border border-white/25 text-white font-medium rounded-full btn-cta-outline transition' );

		if ( ! empty( $s[ "s{$n}_btn1_link" ]['url'] ) ) {
			$this->add_link_attributes( "s{$n}_b1", $s[ "s{$n}_btn1_link" ] );
		}
		if ( ! empty( $s[ "s{$n}_btn2_link" ]['url'] ) ) {
			$this->add_link_attributes( "s{$n}_b2", $s[ "s{$n}_btn2_link" ] );
		}
		?>
		<?php if ( ! empty( $s[ "s{$n}_badge_text" ] ) ) : ?>
			<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full border <?php echo esc_attr( $t['badge'] ); ?> text-xs font-semibold mb-6 tracking-wide">
				<?php if ( ! empty( $s[ "s{$n}_badge_icon" ] ) ) : ?>
					<i class="<?php echo $this->icon_class( $s[ "s{$n}_badge_icon" ] ); ?>" style="animation-duration: 3s"></i>
				<?php endif; ?>
				<?php echo esc_html( $s[ "s{$n}_badge_text" ] ); ?>
			</div>
		<?php endif; ?>

		<?php if ( ! empty( $s[ "s{$n}_heading" ] ) ) : ?>
			<h1 class="font-display text-4xl sm:text-5xl font-bold text-white leading-[1.12] mb-5"><?php echo wp_kses_post( $this->format_heading( $s[ "s{$n}_heading" ], $t['accent'] ) ); ?></h1>
		<?php endif; ?>

		<?php if ( ! empty( $s[ "s{$n}_desc" ] ) ) : ?>
			<p class="text-slate-300 text-[17px] leading-relaxed mb-8 <?php echo esc_attr( $t['desc'] ); ?>"><?php echo esc_html( $s[ "s{$n}_desc" ] ); ?></p>
		<?php endif; ?>

		<div class="flex flex-wrap gap-3">
			<?php if ( ! empty( $s[ "s{$n}_btn1_text" ] ) ) : ?>
				<a <?php $this->print_render_attribute_string( "s{$n}_b1" ); ?>>
					<?php echo esc_html( $s[ "s{$n}_btn1_text" ] ); ?>
					<?php if ( ! empty( $s[ "s{$n}_btn1_icon" ] ) ) : ?>
						<i class="<?php echo $this->icon_class( $s[ "s{$n}_btn1_icon" ] ); ?> text-xs"></i>
					<?php endif; ?>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $s[ "s{$n}_btn2_text" ] ) ) : ?>
				<a <?php $this->print_render_attribute_string( "s{$n}_b2" ); ?>><?php echo esc_html( $s[ "s{$n}_btn2_text" ] ); ?></a>
			<?php endif; ?>
		</div>
		<?php
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		// Per-slide color classes — written out in full (same as the original design)
		// so Tailwind can detect them.
		$themes = [
			1 => [
				'overlay' => 'bg-gradient-to-r from-slate-950/95 via-slate-900/80 to-slate-900/40',
				'badge'   => 'border-accent-500/40 bg-accent-500/15 text-accent-400',
				'accent'  => 'text-accent-400',
				'btn1'    => 'inline-flex items-center gap-2 px-6 py-3 bg-accent-500 hover:bg-accent-400 text-white font-semibold rounded-full shadow-lg shadow-accent-500/25 btn-cta btn-cta-accent',
				'desc'    => 'max-w-md',
			],
			2 => [
				'overlay' => 'bg-gradient-to-r from-slate-950/95 via-slate-900/80 to-primary-900/40',
				'badge'   => 'border-primary-400/30 bg-primary-500/15 text-primary-300',
				'accent'  => 'text-primary-300',
				'btn1'    => 'inline-flex items-center gap-2 px-6 py-3 bg-primary-500 hover:bg-primary-400 text-white font-semibold rounded-full shadow-lg btn-cta',
				'desc'    => 'max-w-lg',
			],
			3 => [
				'overlay' => 'bg-gradient-to-r from-slate-950/95 via-slate-900/80 to-emerald-900/35',
				'badge'   => 'border-emerald-400/30 bg-emerald-500/15 text-emerald-300',
				'accent'  => 'text-emerald-300',
				'btn1'    => 'inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white font-semibold rounded-full shadow-lg btn-cta',
				'desc'    => 'max-w-lg',
			],
		];

		// Slide 1 card icon-box colors (same as the original).
		$card_colors = [
			1 => [ 'box' => 'bg-primary-500/30',  'icon' => 'text-primary-300' ],
			2 => [ 'box' => 'bg-accent-500/30',   'icon' => 'text-accent-300' ],
			3 => [ 'box' => 'bg-emerald-500/30',  'icon' => 'text-emerald-300' ],
		];
		?>

		<section class="servo-hero pt-16 overflow-hidden">

			<?php
			for ( $n = 1; $n <= 3; $n++ ) :
				$t      = $themes[ $n ];
				$bg_url = ! empty( $s[ "s{$n}_bg" ]['url'] ) ? $s[ "s{$n}_bg" ]['url'] : '';
				?>
				<div class="servo-slide<?php echo 1 === $n ? ' active' : ''; ?>" data-i="<?php echo (int) ( $n - 1 ); ?>">
					<div class="bg-img"<?php echo $bg_url ? ' style="background-image: url(\'' . esc_url( $bg_url ) . '\');"' : ''; ?>></div>
					<div class="absolute inset-0 <?php echo esc_attr( $t['overlay'] ); ?>"></div>

					<div class="servo-slide-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

						<?php if ( 1 === $n ) : ?>
							<div class="grid lg:grid-cols-2 gap-10 items-center">
								<div>
									<?php $this->render_text( $s, $n, $t ); ?>
								</div>

								<div class="hidden lg:block">
									<div class="bg-white/10 backdrop-blur-md border border-white/15 rounded-3xl p-8 space-y-5">
										<?php
										for ( $k = 1; $k <= 3; $k++ ) :
											if ( empty( $s[ "s1_f{$k}_title" ] ) && empty( $s[ "s1_f{$k}_text" ] ) ) {
												continue;
											}
											?>
											<div class="flex items-center gap-4">
												<div class="w-12 h-12 rounded-2xl <?php echo esc_attr( $card_colors[ $k ]['box'] ); ?> flex items-center justify-center">
													<?php if ( ! empty( $s[ "s1_f{$k}_icon" ] ) ) : ?>
														<i class="<?php echo $this->icon_class( $s[ "s1_f{$k}_icon" ] ); ?> <?php echo esc_attr( $card_colors[ $k ]['icon'] ); ?> text-lg"></i>
													<?php endif; ?>
												</div>
												<div>
													<p class="text-white font-semibold"><?php echo esc_html( $s[ "s1_f{$k}_title" ] ); ?></p>
													<p class="text-slate-400 text-[17px]"><?php echo esc_html( $s[ "s1_f{$k}_text" ] ); ?></p>
												</div>
											</div>
										<?php endfor; ?>
									</div>
								</div>
							</div>
						<?php else : ?>
							<div class="max-w-2xl">
								<?php $this->render_text( $s, $n, $t ); ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endfor; ?>

			<div class="hero-nav">
				<button class="hero-arrow prev" aria-label="Previous slide">
					<i class="fas fa-chevron-left text-xs"></i>
				</button>
				<button class="servo-dot active" data-i="0"></button>
				<button class="servo-dot" data-i="1"></button>
				<button class="servo-dot" data-i="2"></button>
				<button class="hero-arrow next" aria-label="Next slide">
					<i class="fas fa-chevron-right text-xs"></i>
				</button>
			</div>
		</section>

		<?php
	}
}