<?php
/**
 * IATBD Overview Section (fixed fields, no repeater, no Elementor icon picker)
 *
 * Markup/classes are the same as the original static HTML.
 * Only the content is made editable from Elementor.
 */
class IATBD_Overview extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_overview';
	}

	public function get_title() {
		return esc_html__( 'IATBD Overview', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'overview', 'about', 'image', 'text', 'iatbd' ];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		// ---- Image ----
		$this->start_controls_section( 'image_section', [
			'label' => esc_html__( 'Image', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1000&q=80' ],
		] );

		$this->add_control( 'image_alt', [
			'label'       => esc_html__( 'Image Alt Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Servo Drive System',
			'label_block' => true,
		] );

		$this->add_control( 'badge_text', [
			'label'       => esc_html__( 'Badge Text (on image)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Closed-loop control',
			'label_block' => true,
			'separator'   => 'before',
		] );

		$this->end_controls_section();

		// ---- Text ----
		$this->start_controls_section( 'text_section', [
			'label' => esc_html__( 'Text', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Small Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Overview',
			'label_block' => true,
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'elementor-test' ),
			'description' => esc_html__( 'New line = line break.', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => "Precision motion\nfor modern machines",
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 5,
			'default' => 'Servo systems deliver exact position, speed and torque. IATBD covers motor–drive matching, wiring, auto-tuning, multi-axis coordination and long-term support — so your axes stay accurate under real production loads.',
		] );

		$this->end_controls_section();

		// ---- Checklist ----
		$this->start_controls_section( 'list_section', [
			'label' => esc_html__( 'Checklist', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'list_icon', [
			'label'       => esc_html__( 'List Icon (Font Awesome class)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-check',
			'placeholder' => 'fas fa-check',
			'label_block' => true,
		] );

		$list_defaults = [
			1 => 'Correct motor & drive sizing for inertia ratio',
			2 => 'Gain tuning, filters & vibration suppression',
			3 => 'PLC / motion controller integration',
		];

		foreach ( $list_defaults as $n => $text ) {
			$this->add_control( "list{$n}", [
				'label'       => sprintf( esc_html__( 'Item %d', 'elementor-test' ), $n ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $text,
				'label_block' => true,
			] );
		}

		$this->end_controls_section();

		// ---- Link ----
		$this->start_controls_section( 'link_section', [
			'label' => esc_html__( 'Bottom Link', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'link_text', [
			'label'       => esc_html__( 'Link Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Discuss your axes',
			'label_block' => true,
		] );

		$this->add_control( 'link_url', [
			'label'   => esc_html__( 'Link URL', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#contact' ],
		] );

		$this->add_control( 'link_icon', [
			'label'       => esc_html__( 'Link Icon (Font Awesome class)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-arrow-right',
			'placeholder' => 'fas fa-arrow-right',
			'label_block' => true,
		] );

		$this->end_controls_section();
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

		$this->add_render_attribute( 'link_a', 'class', 'inline-flex items-center gap-2 text-[17px] font-semibold text-primary-600 dark:text-primary-400 hover:gap-3 transition-all' );
		if ( ! empty( $s['link_url']['url'] ) ) {
			$this->add_link_attributes( 'link_a', $s['link_url'] );
		}
		?>

		<section class="py-20 sm:py-24 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">

					<div class="lg:col-span-6 order-2 lg:order-1 relative">
						<?php if ( ! empty( $s['image']['url'] ) ) : ?>
							<div class="rounded-3xl overflow-hidden shadow-2xl shadow-slate-200/50 dark:shadow-none border border-slate-100 dark:border-slate-800">
								<img
									src="<?php echo esc_url( $s['image']['url'] ); ?>"
									alt="<?php echo esc_attr( $s['image_alt'] ); ?>"
									class="w-full h-72 sm:h-[380px] object-cover"
								/>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $s['badge_text'] ) ) : ?>
							<div class="absolute -top-4 -right-2 sm:right-4 bg-accent-500 text-white text-xs font-bold px-3 py-1.5 rounded-full shadow-lg"><?php echo esc_html( $s['badge_text'] ); ?></div>
						<?php endif; ?>
					</div>

					<div class="lg:col-span-6 order-1 lg:order-2">
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white leading-tight mb-5"><?php echo wp_kses_post( nl2br( esc_html( $s['heading'] ) ) ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="text-[17px] text-slate-600 dark:text-slate-300 leading-relaxed mb-6"><?php echo esc_html( $s['description'] ); ?></p>
						<?php endif; ?>

						<ul class="space-y-3 mb-8">
							<?php
							for ( $n = 1; $n <= 3; $n++ ) :
								if ( empty( $s[ "list{$n}" ] ) ) {
									continue;
								}
								?>
								<li class="flex items-center gap-3 text-[17px] text-slate-700 dark:text-slate-300">
									<span class="w-6 h-6 rounded-lg bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center shrink-0">
										<?php if ( ! empty( $s['list_icon'] ) ) : ?>
											<i class="<?php echo $this->icon_class( $s['list_icon'] ); ?> text-[10px] text-primary-600"></i>
										<?php endif; ?>
									</span>
									<?php echo esc_html( $s[ "list{$n}" ] ); ?>
								</li>
							<?php endfor; ?>
						</ul>

						<?php if ( ! empty( $s['link_text'] ) ) : ?>
							<a <?php $this->print_render_attribute_string( 'link_a' ); ?>>
								<?php echo esc_html( $s['link_text'] ); ?>
								<?php if ( ! empty( $s['link_icon'] ) ) : ?>
									<i class="<?php echo $this->icon_class( $s['link_icon'] ); ?> text-xs"></i>
								<?php endif; ?>
							</a>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</section>

		<?php
	}
}