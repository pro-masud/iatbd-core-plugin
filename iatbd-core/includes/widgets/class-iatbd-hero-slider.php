<?php
/**
 * IATBD Hero Slider
 * Elementor widget: multi-slide hero carousel with PLC, HMI, VFD, Servo defaults.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Hero_Slider_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hero_slider';
	}

	public function get_title() {
		return esc_html__( 'IATBD Hero Slider', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-slides';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'hero', 'slider', 'carousel', 'plc', 'hmi', 'vfd', 'servo', 'iatbd' ];
	}

	/**
	 * Button 1 style classes (Tailwind)
	 */
	private function get_btn1_styles() {
		return [
			'primary' => 'bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-full shadow-lg shadow-primary-500/40 transition hover:scale-105',
			'orange'  => 'bg-orange-500 hover:bg-orange-400 text-white font-semibold rounded-full shadow-lg transition hover:scale-105',
			'emerald' => 'bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-full shadow-lg transition hover:scale-105',
			'purple'  => 'bg-purple-600 hover:bg-purple-500 text-white font-semibold rounded-full shadow-lg transition hover:scale-105',
		];
	}

	/**
	 * Button 2 style classes (Tailwind)
	 */
	private function get_btn2_styles() {
		return [
			'glass'   => 'bg-white/15 hover:bg-white/25 border border-white/30 text-white font-semibold rounded-full backdrop-blur transition',
			'primary' => 'bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-full shadow-lg transition',
			'white'   => 'bg-white hover:bg-slate-100 text-slate-900 font-semibold rounded-full shadow-lg transition',
		];
	}

	protected function register_controls() {

		/* ---------- Slider Global Settings ---------- */
		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Slider Settings', 'iatbd-core' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => esc_html__( 'Section ID (Anchor)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'home',
			'description' => esc_html__( 'ID for #home navigation link. Without # sign.', 'iatbd-core' ),
		] );

		$this->add_control( 'autoplay', [
			'label'        => esc_html__( 'Autoplay', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'interval', [
			'label'     => esc_html__( 'Autoplay Interval (ms)', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'min'       => 2000,
			'max'       => 15000,
			'step'      => 500,
			'default'   => 5000,
			'condition' => [
				'autoplay' => 'yes',
			],
		] );

		$this->add_control( 'show_arrows', [
			'label'        => esc_html__( 'Show Navigation Arrows', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'show_dots', [
			'label'        => esc_html__( 'Show Indicator Dots', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		/* ---------- Slides Repeater ---------- */
		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'Slides', 'iatbd-core' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80',
			],
		] );

		$repeater->add_control( 'badge_icon', [
			'label'       => esc_html__( 'Badge Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-microchip',
			'placeholder' => 'fas fa-microchip',
			'separator'   => 'before',
		] );

		$repeater->add_control( 'badge_text', [
			'label'       => esc_html__( 'Badge Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'PLC Systems',
		] );

		$repeater->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => 'Advanced {accent}PLC{/accent} Solutions',
			'description' => esc_html__( 'Wrap highlighted word in {accent}word{/accent} or write HTML.', 'iatbd-core' ),
			'separator'   => 'before',
		] );

		$repeater->add_control( 'highlight_color', [
			'label'       => esc_html__( 'Accent Color Class (Tailwind)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'text-primary-300',
			'description' => esc_html__( 'e.g. text-primary-300, text-orange-300, text-emerald-300, text-purple-300', 'iatbd-core' ),
		] );

		$repeater->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Siemens, Allen-Bradley, Mitsubishi, Delta — সম্পূর্ণ PLC প্রোগ্রামিং, ইনস্টলেশন ও ২৪/৭ সাপোর্ট।',
		] );

		/* Primary Button */
		$repeater->add_control( 'btn1_heading', [
			'label'     => esc_html__( 'Primary Button', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$repeater->add_control( 'btn1_text', [
			'label'       => esc_html__( 'Button 1 Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Explore PLC',
		] );

		$repeater->add_control( 'btn1_link', [
			'label'         => esc_html__( 'Button 1 Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'plc-service.html',
			'default'       => [
				'url' => 'plc-service.html',
			],
			'show_external' => true,
		] );

		$repeater->add_control( 'btn1_icon', [
			'label'       => esc_html__( 'Button 1 Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-arrow-right',
		] );

		$repeater->add_control( 'btn1_style', [
			'label'   => esc_html__( 'Button 1 Color Style', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary (Blue)', 'iatbd-core' ),
				'orange'  => esc_html__( 'Orange', 'iatbd-core' ),
				'emerald' => esc_html__( 'Emerald (Green)', 'iatbd-core' ),
				'purple'  => esc_html__( 'Purple', 'iatbd-core' ),
				'custom'  => esc_html__( 'Custom Classes', 'iatbd-core' ),
			],
		] );

		$repeater->add_control( 'btn1_custom', [
			'label'       => esc_html__( 'Button 1 Custom Classes', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '',
			'condition'   => [
				'btn1_style' => 'custom',
			],
		] );

		/* Secondary Button */
		$repeater->add_control( 'btn2_heading', [
			'label'     => esc_html__( 'Secondary Button', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::HEADING,
			'separator' => 'before',
		] );

		$repeater->add_control( 'btn2_text', [
			'label'       => esc_html__( 'Button 2 Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Get Quote',
		] );

		$repeater->add_control( 'btn2_link', [
			'label'         => esc_html__( 'Button 2 Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'contact.html',
			'default'       => [
				'url' => 'contact.html',
			],
			'show_external' => true,
		] );

		$repeater->add_control( 'btn2_style', [
			'label'   => esc_html__( 'Button 2 Color Style', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'glass',
			'options' => [
				'glass'   => esc_html__( 'Glass / Outline Blur', 'iatbd-core' ),
				'primary' => esc_html__( 'Primary (Blue)', 'iatbd-core' ),
				'white'   => esc_html__( 'Solid White', 'iatbd-core' ),
				'custom'  => esc_html__( 'Custom Classes', 'iatbd-core' ),
			],
		] );

		$repeater->add_control( 'btn2_custom', [
			'label'       => esc_html__( 'Button 2 Custom Classes', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '',
			'condition'   => [
				'btn2_style' => 'custom',
			],
		] );

		$this->add_control( 'slides', [
			'label'       => esc_html__( 'Slides List', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ badge_text }}} - {{{ heading }}}',
			'default'     => [
				[
					'bg_image'        => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80' ],
					'badge_icon'      => 'fas fa-microchip',
					'badge_text'      => 'PLC Systems',
					'heading'         => 'Advanced {accent}PLC{/accent} Solutions',
					'highlight_color' => 'text-primary-300',
					'description'     => 'Siemens, Allen-Bradley, Mitsubishi, Delta — সম্পূর্ণ PLC প্রোগ্রামিং, ইনস্টলেশন ও ২৪/৭ সাপোর্ট।',
					'btn1_text'       => 'Explore PLC',
					'btn1_link'       => [ 'url' => 'plc-service.html' ],
					'btn1_icon'       => 'fas fa-arrow-right',
					'btn1_style'      => 'primary',
					'btn2_text'       => 'Get Quote',
					'btn2_link'       => [ 'url' => 'contact.html' ],
					'btn2_style'      => 'glass',
				],
				[
					'bg_image'        => [ 'url' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1920&q=80' ],
					'badge_icon'      => 'fas fa-desktop',
					'badge_text'      => 'HMI Panels',
					'heading'         => 'Smart {accent}HMI{/accent} Interfaces',
					'highlight_color' => 'text-orange-300',
					'description'     => 'ইউজার-ফ্রেন্ডলি টাচ প্যানেল ডিজাইন, স্ক্রিন ডেভেলপমেন্ট ও সিস্টেম ইন্টিগ্রেশন।',
					'btn1_text'       => 'Explore HMI',
					'btn1_link'       => [ 'url' => 'hmi-service.html' ],
					'btn1_icon'       => 'fas fa-arrow-right',
					'btn1_style'      => 'orange',
					'btn2_text'       => 'Get Quote',
					'btn2_link'       => [ 'url' => 'contact.html' ],
					'btn2_style'      => 'glass',
				],
				[
					'bg_image'        => [ 'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80' ],
					'badge_icon'      => 'fas fa-tachometer-alt',
					'badge_text'      => 'VFD Drives',
					'heading'         => 'Efficient {accent}VFD{/accent} Drives',
					'highlight_color' => 'text-emerald-300',
					'description'     => 'Variable Frequency Drive সিলেকশন, প্যারামিটার সেটআপ ও এনার্জি সেভিং সলিউশন।',
					'btn1_text'       => 'Explore VFD',
					'btn1_link'       => [ 'url' => 'vfd-service.html' ],
					'btn1_icon'       => 'fas fa-arrow-right',
					'btn1_style'      => 'emerald',
					'btn2_text'       => 'Get Quote',
					'btn2_link'       => [ 'url' => 'contact.html' ],
					'btn2_style'      => 'glass',
				],
				[
					'bg_image'        => [ 'url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1920&q=80' ],
					'badge_icon'      => 'fas fa-cogs',
					'badge_text'      => 'Servo Drive',
					'heading'         => 'Precision {accent}Servo{/accent} Systems',
					'highlight_color' => 'text-purple-300',
					'description'     => 'হাই-প্রিসিশন সার্ভো মোটর ও ড্রাইভ, মোশন কন্ট্রোল ও টিউনিং সাপোর্ট।',
					'btn1_text'       => 'Explore Servo',
					'btn1_link'       => [ 'url' => 'servo-service.html' ],
					'btn1_icon'       => 'fas fa-arrow-right',
					'btn1_style'      => 'purple',
					'btn2_text'       => 'Get Quote',
					'btn2_link'       => [ 'url' => 'contact.html' ],
					'btn2_style'      => 'glass',
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s           = $this->get_settings_for_display();
		$slides      = ! empty( $s['slides'] ) ? $s['slides'] : [];
		$section_id  = ! empty( $s['section_id'] ) ? sanitize_html_class( $s['section_id'] ) : 'home';
		$wid         = $this->get_id();
		$slider_id   = 'hero-slider-' . esc_attr( $wid );
		$btn1_styles = $this->get_btn1_styles();
		$btn2_styles = $this->get_btn2_styles();
		?>
		<section id="<?php echo esc_attr( $section_id ); ?>" class="relative hero-slider pt-16" aria-label="<?php esc_attr_e( 'Hero carousel', 'iatbd-core' ); ?>" data-slider-instance="<?php echo esc_attr( $slider_id ); ?>">

			<?php
			foreach ( $slides as $i => $item ) :
				$bg_url  = ! empty( $item['bg_image']['url'] ) ? $item['bg_image']['url'] : '';
				$h_tag   = ( 0 === $i ) ? 'h1' : 'h2';

				// Heading formatting with {accent} tag
				$heading = $item['heading'];
				if ( ! empty( $heading ) ) {
					$accent_color = ! empty( $item['highlight_color'] ) ? esc_attr( $item['highlight_color'] ) : 'text-primary-300';
					if ( strpos( $heading, '{accent}' ) !== false ) {
						$heading_html = str_replace(
							[ '{accent}', '{/accent}' ],
							[ '<span class="' . $accent_color . '">', '</span>' ],
							esc_html( $heading )
						);
					} else {
						// Allow direct HTML spans if used
						$heading_html = wp_kses( $heading, [
							'span'   => [ 'class' => [] ],
							'br'     => [],
							'strong' => [],
							'em'     => [],
						] );
					}
				} else {
					$heading_html = '';
				}

				// Button 1 attributes
				$b1_key = 'slide_' . $i . '_btn1';
				$b1_cls = 'inline-flex items-center gap-2 px-7 py-3.5 ';
				if ( ! empty( $item['btn1_style'] ) && 'custom' === $item['btn1_style'] ) {
					$b1_cls .= ! empty( $item['btn1_custom'] ) ? $item['btn1_custom'] : '';
				} elseif ( ! empty( $item['btn1_style'] ) && isset( $btn1_styles[ $item['btn1_style'] ] ) ) {
					$b1_cls .= $btn1_styles[ $item['btn1_style'] ];
				} else {
					$b1_cls .= $btn1_styles['primary'];
				}
				$this->add_render_attribute( $b1_key, 'class', $b1_cls );
				if ( ! empty( $item['btn1_link']['url'] ) ) {
					$this->add_link_attributes( $b1_key, $item['btn1_link'] );
				}

				// Button 2 attributes
				$b2_key = 'slide_' . $i . '_btn2';
				$b2_cls = 'inline-flex items-center gap-2 px-7 py-3.5 ';
				if ( ! empty( $item['btn2_style'] ) && 'custom' === $item['btn2_style'] ) {
					$b2_cls .= ! empty( $item['btn2_custom'] ) ? $item['btn2_custom'] : '';
				} elseif ( ! empty( $item['btn2_style'] ) && isset( $btn2_styles[ $item['btn2_style'] ] ) ) {
					$b2_cls .= $btn2_styles[ $item['btn2_style'] ];
				} else {
					$b2_cls .= $btn2_styles['glass'];
				}
				$this->add_render_attribute( $b2_key, 'class', $b2_cls );
				if ( ! empty( $item['btn2_link']['url'] ) ) {
					$this->add_link_attributes( $b2_key, $item['btn2_link'] );
				}
				?>
				<!-- Slide <?php echo (int) $i; ?> -->
				<div class="hero-slide<?php echo 0 === $i ? ' active' : ''; ?>" data-index="<?php echo (int) $i; ?>"<?php echo 0 !== $i ? ' aria-hidden="true"' : ''; ?>>
					<div class="slide-bg"<?php echo ! empty( $bg_url ) ? ' style="background-image: url(\'' . esc_url( $bg_url ) . '\');"' : ''; ?>></div>
					<div class="overlay"></div>
					<div class="relative z-10 max-w-4xl mx-auto px-6 text-center">

						<?php if ( ! empty( $item['badge_text'] ) ) : ?>
							<div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur border border-white/25 text-white text-sm font-medium mb-5">
								<?php if ( ! empty( $item['badge_icon'] ) ) : ?>
									<i class="<?php echo esc_attr( $item['badge_icon'] ); ?>"></i>
								<?php endif; ?>
								<?php echo esc_html( $item['badge_text'] ); ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $heading_html ) ) : ?>
							<<?php echo esc_attr( $h_tag ); ?> class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4 drop-shadow-lg">
								<?php echo $heading_html; // phpcs:ignore WordPress.Security.EscapeOutput ?>
							</<?php echo esc_attr( $h_tag ); ?>>
						<?php endif; ?>

						<?php if ( ! empty( $item['description'] ) ) : ?>
							<p class="text-lg text-slate-200 max-w-xl mx-auto mb-8">
								<?php echo esc_html( $item['description'] ); ?>
							</p>
						<?php endif; ?>

						<?php if ( ! empty( $item['btn1_text'] ) || ! empty( $item['btn2_text'] ) ) : ?>
							<div class="flex flex-wrap justify-center gap-3">
								<?php if ( ! empty( $item['btn1_text'] ) ) : ?>
									<a <?php echo $this->get_render_attribute_string( $b1_key ); ?>>
										<?php echo esc_html( $item['btn1_text'] ); ?>
										<?php if ( ! empty( $item['btn1_icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $item['btn1_icon'] ); ?> text-sm"></i>
										<?php endif; ?>
									</a>
								<?php endif; ?>

								<?php if ( ! empty( $item['btn2_text'] ) ) : ?>
									<a <?php echo $this->get_render_attribute_string( $b2_key ); ?>>
										<?php echo esc_html( $item['btn2_text'] ); ?>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

					</div>
				</div>
			<?php endforeach; ?>

			<!-- Navigation Arrows -->
			<?php if ( 'yes' === $s['show_arrows'] && count( $slides ) > 1 ) : ?>
				<button class="slider-arrow prev hidden sm:flex" type="button" aria-label="<?php esc_attr_e( 'Previous slide', 'iatbd-core' ); ?>">
					<i class="fas fa-chevron-left"></i>
				</button>
				<button class="slider-arrow next hidden sm:flex" type="button" aria-label="<?php esc_attr_e( 'Next slide', 'iatbd-core' ); ?>">
					<i class="fas fa-chevron-right"></i>
				</button>
			<?php endif; ?>

			<!-- Indicator Dots -->
			<?php if ( 'yes' === $s['show_dots'] && count( $slides ) > 1 ) : ?>
				<div class="slider-nav" aria-label="<?php esc_attr_e( 'Slider navigation', 'iatbd-core' ); ?>">
					<?php foreach ( $slides as $i => $item ) : ?>
						<button class="slider-dot<?php echo 0 === $i ? ' active' : ''; ?>" data-index="<?php echo (int) $i; ?>" type="button" aria-label="<?php echo esc_attr( sprintf( /* translators: %d: slide number */ esc_html__( 'Slide %d', 'iatbd-core' ), $i + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</section>
		<?php
	}
}
