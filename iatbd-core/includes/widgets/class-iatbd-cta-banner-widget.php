<?php
/**
 * IATBD CTA Banner Widget
 * Elementor widget: Industry 4.0 automation CTA banner with animated graphic and floating tech badges.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_CTA_Banner_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_cta_banner';
	}

	public function get_title() {
		return esc_html__( 'IATBD CTA Banner', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'cta', 'banner', 'automation', 'contact', 'call to action', 'industry', 'iatbd' ];
	}

	protected function register_controls() {

		/* ---------- Background & Section ---------- */
		$this->start_controls_section( 'section_bg', [
			'label' => esc_html__( 'Section & Background', 'iatbd-core' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => esc_html__( 'Section Anchor ID', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '',
			'description' => esc_html__( 'Optional anchor ID (without #).', 'iatbd-core' ),
		] );

		$this->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80',
			],
		] );

		$this->add_control( 'gradient', [
			'label'       => esc_html__( 'Gradient Overlay (Tailwind)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'from-slate-950/95 via-blue-950/90 to-blue-900/75',
		] );

		$this->add_control( 'show_grid_overlay', [
			'label'        => esc_html__( 'Show Tech Grid Overlay', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		/* ---------- Left Visual Graphic ---------- */
		$this->start_controls_section( 'section_visual', [
			'label' => esc_html__( 'Left Animated Visual', 'iatbd-core' ),
		] );

		$this->add_control( 'show_left_visual', [
			'label'        => esc_html__( 'Show Visual Graphic', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'center_icon', [
			'label'       => esc_html__( 'Center Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-industry',
			'condition'   => [ 'show_left_visual' => 'yes' ],
		] );

		$this->add_control( 'badge_top_text', [
			'label'       => esc_html__( 'Top Floating Badge Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Systems Online',
			'condition'   => [ 'show_left_visual' => 'yes' ],
		] );

		$this->add_control( 'badge_top_dot', [
			'label'        => esc_html__( 'Show Green Pulse Dot', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'condition'    => [ 'show_left_visual' => 'yes' ],
		] );

		$this->add_control( 'badge_bottom_icon', [
			'label'       => esc_html__( 'Bottom Badge Icon Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-microchip',
			'condition'   => [ 'show_left_visual' => 'yes' ],
		] );

		$this->add_control( 'badge_bottom_text', [
			'label'       => esc_html__( 'Bottom Floating Badge Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'PLC · HMI · VFD · Servo',
			'condition'   => [ 'show_left_visual' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------- Right Content ---------- */
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content & Text', 'iatbd-core' ),
		] );

		$this->add_control( 'badge_icon', [
			'label'       => esc_html__( 'Badge Icon Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-bolt',
		] );

		$this->add_control( 'badge_text', [
			'label'       => esc_html__( 'Badge Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Industry 4.0 Ready',
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => "Start Automation\n{gradient}Today{/gradient}",
			'description' => esc_html__( 'Wrap word in {gradient}text{/gradient} for gradient highlight, or enter HTML.', 'iatbd-core' ),
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'আপনার প্রোডাকশন লাইনকে স্মার্ট করুন। PLC, HMI, VFD ও Servo — সম্পূর্ণ ইন্ডাস্ট্রিয়াল অটোমেশন সলিউশন এক জায়গায়।',
		] );

		$this->end_controls_section();

		/* ---------- Action Buttons ---------- */
		$this->start_controls_section( 'section_buttons', [
			'label' => esc_html__( 'Buttons', 'iatbd-core' ),
		] );

		/* Button 1 */
		$this->add_control( 'btn1_heading', [
			'label'     => esc_html__( 'Button 1 (Primary)', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
		] );

		$this->add_control( 'btn1_text', [
			'label'       => esc_html__( 'Button 1 Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Contact Sales',
		] );

		$this->add_control( 'btn1_icon', [
			'label'       => esc_html__( 'Button 1 Icon Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-rocket',
		] );

		$this->add_control( 'btn1_link', [
			'label'         => esc_html__( 'Button 1 Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'contact.html',
			'default'       => [
				'url' => 'contact.html',
			],
			'show_external' => true,
		] );

		/* Button 2 */
		$this->add_control( 'btn2_heading', [
			'label'     => esc_html__( 'Button 2 (Glass Outline)', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$this->add_control( 'btn2_text', [
			'label'       => esc_html__( 'Button 2 Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Our Services',
		] );

		$this->add_control( 'btn2_icon', [
			'label'       => esc_html__( 'Button 2 Icon Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-cogs',
		] );

		$this->add_control( 'btn2_link', [
			'label'         => esc_html__( 'Button 2 Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => '#services',
			'default'       => [
				'url' => '#services',
			],
			'show_external' => true,
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s          = $this->get_settings_for_display();
		$section_id = ! empty( $s['section_id'] ) ? sanitize_html_class( $s['section_id'] ) : '';
		$bg_url     = ! empty( $s['bg_image']['url'] ) ? $s['bg_image']['url'] : '';
		$gradient   = ! empty( $s['gradient'] ) ? $s['gradient'] : 'from-slate-950/95 via-blue-950/90 to-blue-900/75';
		$show_grid  = 'yes' === $s['show_grid_overlay'];
		$show_vis   = 'yes' === $s['show_left_visual'];

		// Heading formatting with {gradient} highlight support
		$heading = $s['heading'];
		if ( ! empty( $heading ) ) {
			if ( strpos( $heading, '{gradient}' ) !== false ) {
				$heading_html = str_replace(
					[ '{gradient}', '{/gradient}' ],
					[ '<span class="bg-gradient-to-r from-primary-300 to-cyan-300 bg-clip-text text-transparent">', '</span>' ],
					esc_html( $heading )
				);
				$heading_html = nl2br( $heading_html );
			} else {
				$heading_html = nl2br( wp_kses( $heading, [
					'span'   => [ 'class' => [] ],
					'br'     => [],
					'strong' => [],
					'em'     => [],
				] ) );
			}
		} else {
			$heading_html = '';
		}

		// Button 1
		$b1_key = 'cta_btn_1';
		$this->add_render_attribute( $b1_key, 'class', 'inline-flex items-center gap-2.5 px-7 py-3.5 bg-primary-500 hover:bg-primary-400 text-white font-bold rounded-full transition-all hover:scale-105 shadow-lg shadow-primary-500/30' );
		if ( ! empty( $s['btn1_link']['url'] ) ) {
			$this->add_link_attributes( $b1_key, $s['btn1_link'] );
		}

		// Button 2
		$b2_key = 'cta_btn_2';
		$this->add_render_attribute( $b2_key, 'class', 'inline-flex items-center gap-2.5 px-7 py-3.5 bg-white/10 hover:bg-white/15 border border-white/25 text-white font-semibold rounded-full backdrop-blur transition' );
		if ( ! empty( $s['btn2_link']['url'] ) ) {
			$this->add_link_attributes( $b2_key, $s['btn2_link'] );
		}
		?>
		<section <?php echo ! empty( $section_id ) ? 'id="' . esc_attr( $section_id ) . '"' : ''; ?> class="relative overflow-hidden">
			<div class="relative min-h-[420px] sm:min-h-[480px] flex items-center">

				<!-- Background image -->
				<?php if ( ! empty( $bg_url ) ) : ?>
					<div
						class="absolute inset-0 bg-cover bg-center"
						style="background-image: url('<?php echo esc_url( $bg_url ); ?>');"
					></div>
				<?php endif; ?>

				<!-- Gradient overlay -->
				<div class="absolute inset-0 bg-gradient-to-r <?php echo esc_attr( $gradient ); ?>"></div>

				<!-- Grid pattern overlay -->
				<?php if ( $show_grid ) : ?>
					<div
						class="absolute inset-0 opacity-[0.07]"
						style="background-image: linear-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.15) 1px, transparent 1px); background-size: 40px 40px;"
					></div>
				<?php endif; ?>

				<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16 sm:py-20">
					<div class="grid lg:grid-cols-2 gap-10 items-center">

						<!-- Left visual -->
						<?php if ( $show_vis ) : ?>
							<div class="relative hidden lg:flex items-center justify-center">
								<div class="relative">
									<div
										class="w-64 h-64 rounded-full border border-blue-400/20 flex items-center justify-center animate-pulse"
										style="animation-duration: 3s;"
									>
										<div class="w-48 h-48 rounded-full border border-blue-400/30 flex items-center justify-center">
											<div class="w-32 h-32 rounded-2xl bg-gradient-to-br from-primary-500 to-blue-600 shadow-2xl shadow-primary-500/40 flex items-center justify-center">
												<?php if ( ! empty( $s['center_icon'] ) ) : ?>
													<i class="<?php echo esc_attr( $s['center_icon'] ); ?> text-5xl text-white"></i>
												<?php endif; ?>
											</div>
										</div>
									</div>

									<?php if ( ! empty( $s['badge_top_text'] ) ) : ?>
										<div class="absolute -top-3 -right-2 bg-slate-900/80 backdrop-blur border border-emerald-500/40 rounded-xl px-3.5 py-2 text-white text-xs font-medium flex items-center gap-2">
											<?php if ( 'yes' === $s['badge_top_dot'] ) : ?>
												<span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
											<?php endif; ?>
											<?php echo esc_html( $s['badge_top_text'] ); ?>
										</div>
									<?php endif; ?>

									<?php if ( ! empty( $s['badge_bottom_text'] ) ) : ?>
										<div class="absolute bottom-2 -left-4 bg-slate-900/80 backdrop-blur border border-primary-500/40 rounded-xl px-3.5 py-2 text-white text-xs font-medium">
											<?php if ( ! empty( $s['badge_bottom_icon'] ) ) : ?>
												<i class="<?php echo esc_attr( $s['badge_bottom_icon'] ); ?> text-primary-400 mr-1.5"></i>
											<?php endif; ?>
											<?php echo esc_html( $s['badge_bottom_text'] ); ?>
										</div>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- Right content -->
						<div class="text-center <?php echo $show_vis ? 'lg:text-left' : 'max-w-2xl mx-auto'; ?>">

							<?php if ( ! empty( $s['badge_text'] ) ) : ?>
								<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-500/20 border border-primary-400/30 text-primary-300 text-xs font-semibold tracking-wider uppercase mb-5">
									<?php if ( ! empty( $s['badge_icon'] ) ) : ?>
										<i class="<?php echo esc_attr( $s['badge_icon'] ); ?>"></i>
									<?php endif; ?>
									<?php echo esc_html( $s['badge_text'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $heading_html ) ) : ?>
								<h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
									<?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
								</h2>
							<?php endif; ?>

							<?php if ( ! empty( $s['description'] ) ) : ?>
								<p class="text-slate-300 text-base sm:text-lg mb-8 max-w-md <?php echo $show_vis ? 'mx-auto lg:mx-0' : 'mx-auto'; ?> leading-relaxed">
									<?php echo esc_html( $s['description'] ); ?>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $s['btn1_text'] ) || ! empty( $s['btn2_text'] ) ) : ?>
								<div class="flex flex-wrap justify-center <?php echo $show_vis ? 'lg:justify-start' : ''; ?> gap-3">
									<?php if ( ! empty( $s['btn1_text'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $b1_key ); ?>>
											<?php if ( ! empty( $s['btn1_icon'] ) ) : ?>
												<i class="<?php echo esc_attr( $s['btn1_icon'] ); ?>"></i>
											<?php endif; ?>
											<?php echo esc_html( $s['btn1_text'] ); ?>
										</a>
									<?php endif; ?>

									<?php if ( ! empty( $s['btn2_text'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $b2_key ); ?>>
											<?php if ( ! empty( $s['btn2_icon'] ) ) : ?>
												<i class="<?php echo esc_attr( $s['btn2_icon'] ); ?>"></i>
											<?php endif; ?>
											<?php echo esc_html( $s['btn2_text'] ); ?>
										</a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>

					</div>
				</div>

			</div>
		</section>
		<?php
	}
}

