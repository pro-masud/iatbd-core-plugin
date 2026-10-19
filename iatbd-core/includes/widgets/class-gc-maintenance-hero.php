<?php
/**
 * GC Maintenance Hero
 * Elementor widget: hero slider, one repeater item per slide.
 * Slider behaviour comes from the theme's existing JS/CSS
 * (.maintenance-slide, .maintenance-dot, .active, data-i).
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Maintenance_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_maintenance_hero';
	}

	public function get_title() {
		return esc_html__( 'IATBD Maintenance Hero Slider', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'iatbd-addons', 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'hero', 'slider', 'maintenance', 'banner', 'gc' ];
	}

	/**
	 * Full Tailwind class strings per color style (literal, so Tailwind can detect them).
	 */
	private function get_styles() {
		return [
			'accent'  => [
				'overlay' => 'bg-gradient-to-r from-slate-950/95 via-slate-900/85 to-slate-900/50',
				'badge'   => 'border-accent-500/40 bg-accent-500/15 text-accent-400',
				'span'    => 'text-accent-400',
				'btn'     => 'bg-accent-500 hover:bg-accent-400 shadow-lg shadow-accent-500/30',
			],
			'primary' => [
				'overlay' => 'bg-gradient-to-r from-slate-950/95 via-slate-900/85 to-primary-900/40',
				'badge'   => 'border-primary-400/40 bg-primary-500/15 text-primary-300',
				'span'    => 'text-primary-300',
				'btn'     => 'bg-primary-500 hover:bg-primary-400 shadow-lg',
			],
		];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_slides', [
			'label' => esc_html__( 'Slides', 'iatbd-core' ),
		] );

		$r = new \Elementor\Repeater();

		$r->add_control( 'bg_image', [
			'label'   => esc_html__( 'Background Image', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80' ],
		] );

		$r->add_control( 'style', [
			'label'   => esc_html__( 'Color Style', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'accent',
			'options' => [
				'accent'  => esc_html__( 'Accent (orange)', 'iatbd-core' ),
				'primary' => esc_html__( 'Primary', 'iatbd-core' ),
			],
		] );

		$r->add_control( 'badge_icon', [
			'label'     => esc_html__( 'Badge Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'fas fa-calendar-check',
			'separator' => 'before',
		] );

		$r->add_control( 'badge_text', [
			'label'   => esc_html__( 'Badge Text', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'PREVENTIVE & PREDICTIVE MAINTENANCE',
		] );

		$r->add_control( 'heading_1', [
			'label'     => esc_html__( 'Heading Line 1', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Keep Your Drives Running',
			'separator' => 'before',
		] );

		$r->add_control( 'heading_2', [
			'label'       => esc_html__( 'Heading Line 2 (colored)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Before They Fail',
			'description' => esc_html__( 'Leave empty for a single-line heading.', 'iatbd-core' ),
		] );

		$r->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Scheduled maintenance for VFD, PLC, HMI and Servo systems. We clean, inspect, measure, backup parameters and catch problems early — so production stays online.',
		] );

		$r->add_control( 'btn1_text', [
			'label'     => esc_html__( 'Primary Button Text', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Schedule Maintenance',
			'separator' => 'before',
		] );

		$r->add_control( 'btn1_icon', [
			'label'   => esc_html__( 'Primary Button Icon Class', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'fas fa-arrow-right',
		] );

		$r->add_control( 'btn1_link', [
			'label'   => esc_html__( 'Primary Button Link', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '/contact/' ],
		] );

		$r->add_control( 'btn2_text', [
			'label'       => esc_html__( 'Secondary Button Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'What We Cover',
			'description' => esc_html__( 'Leave empty to hide the secondary button.', 'iatbd-core' ),
			'separator'   => 'before',
		] );

		$r->add_control( 'btn2_link', [
			'label'   => esc_html__( 'Secondary Button Link', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '#services' ],
		] );

		$this->add_control( 'slides', [
			'label'       => esc_html__( 'Slides', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'title_field' => '{{{ heading_1 }}}',
			'default'     => [
				[
					'bg_image'    => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80' ],
					'style'       => 'accent',
					'badge_icon'  => 'fas fa-calendar-check',
					'badge_text'  => 'PREVENTIVE & PREDICTIVE MAINTENANCE',
					'heading_1'   => 'Keep Your Drives Running',
					'heading_2'   => 'Before They Fail',
					'description' => 'Scheduled maintenance for VFD, PLC, HMI and Servo systems. We clean, inspect, measure, backup parameters and catch problems early — so production stays online.',
					'btn1_text'   => 'Schedule Maintenance',
					'btn1_icon'   => 'fas fa-arrow-right',
					'btn1_link'   => [ 'url' => '/contact/' ],
					'btn2_text'   => 'What We Cover',
					'btn2_link'   => [ 'url' => '#services' ],
				],
				[
					'bg_image'    => [ 'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80' ],
					'style'       => 'primary',
					'badge_icon'  => 'fas fa-shield-alt',
					'badge_text'  => 'REDUCE UNPLANNED DOWNTIME',
					'heading_1'   => 'Planned care.',
					'heading_2'   => 'Fewer surprises.',
					'description' => 'Thermal checks, capacitor health, fan condition, parameter backup and communication tests — structured maintenance that extends equipment life and protects output.',
					'btn1_text'   => 'Get a Maintenance Plan',
					'btn1_icon'   => 'fas fa-arrow-right',
					'btn1_link'   => [ 'url' => '/contact/' ],
					'btn2_text'   => '',
					'btn2_link'   => [ 'url' => '' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$slides = ! empty( $s['slides'] ) ? $s['slides'] : [];
		if ( empty( $slides ) ) {
			return;
		}
		$styles = $this->get_styles();
		?>
		<section class="maintenance-hero relative min-h-[88vh] pt-16 overflow-hidden">

			<?php
			foreach ( $slides as $i => $item ) :
				$st    = isset( $styles[ $item['style'] ] ) ? $styles[ $item['style'] ] : $styles['accent'];
				$bg    = ! empty( $item['bg_image']['url'] ) ? $item['bg_image']['url'] : '';
				$h_tag = ( 0 === $i ) ? 'h1' : 'h2';

				$k1 = 'slide_' . $i . '_btn1';
				$this->add_render_attribute( $k1, 'class', 'inline-flex items-center gap-2 px-7 py-3.5 text-white font-semibold rounded-full btn-cta ' . $st['btn'] );
				if ( ! empty( $item['btn1_link']['url'] ) ) {
					$this->add_link_attributes( $k1, $item['btn1_link'] );
				}

				$k2 = 'slide_' . $i . '_btn2';
				$this->add_render_attribute( $k2, 'class', 'inline-flex items-center gap-2 px-7 py-3.5 border border-white/30 text-white font-medium rounded-full hover:bg-white/10 transition' );
				if ( ! empty( $item['btn2_link']['url'] ) ) {
					$this->add_link_attributes( $k2, $item['btn2_link'] );
				}
				?>
				<div class="maintenance-slide<?php echo 0 === $i ? ' active' : ''; ?>" data-i="<?php echo (int) $i; ?>">
					<div class="bg-img"<?php echo $bg ? ' style="background-image: url(\'' . esc_url( $bg ) . '\');"' : ''; ?>></div>
					<div class="absolute inset-0 <?php echo esc_attr( $st['overlay'] ); ?>"></div>
					<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-24 sm:py-32">
						<div class="max-w-2xl">

							<?php if ( ! empty( $item['badge_text'] ) ) : ?>
								<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border text-xs font-semibold mb-6 tracking-wide <?php echo esc_attr( $st['badge'] ); ?>">
									<?php if ( ! empty( $item['badge_icon'] ) ) : ?>
										<i class="<?php echo esc_attr( $item['badge_icon'] ); ?>"></i>
									<?php endif; ?>
									<?php echo esc_html( $item['badge_text'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $item['heading_1'] ) || ! empty( $item['heading_2'] ) ) : ?>
								<<?php echo esc_attr( $h_tag ); ?> class="font-display text-4xl sm:text-5xl lg:text-[3.4rem] font-bold text-white leading-[1.1] mb-6">
									<?php echo esc_html( $item['heading_1'] ); ?>
									<?php if ( ! empty( $item['heading_2'] ) ) : ?>
										<br />
										<span class="<?php echo esc_attr( $st['span'] ); ?>"><?php echo esc_html( $item['heading_2'] ); ?></span>
									<?php endif; ?>
								</<?php echo esc_attr( $h_tag ); ?>>
							<?php endif; ?>

							<?php if ( ! empty( $item['description'] ) ) : ?>
								<p class="text-slate-300 text-lg leading-relaxed mb-8 max-w-xl"><?php echo esc_html( $item['description'] ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $item['btn1_text'] ) || ! empty( $item['btn2_text'] ) ) : ?>
								<div class="flex flex-wrap gap-3">
									<?php if ( ! empty( $item['btn1_text'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $k1 ); ?>>
											<?php echo esc_html( $item['btn1_text'] ); ?>
											<?php if ( ! empty( $item['btn1_icon'] ) ) : ?>
												<i class="<?php echo esc_attr( $item['btn1_icon'] ); ?> text-sm"></i>
											<?php endif; ?>
										</a>
									<?php endif; ?>
									<?php if ( ! empty( $item['btn2_text'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $k2 ); ?>><?php echo esc_html( $item['btn2_text'] ); ?></a>
									<?php endif; ?>
								</div>
							<?php endif; ?>

						</div>
					</div>
				</div>
			<?php endforeach; ?>

			<?php if ( count( $slides ) > 1 ) : ?>
				<div class="absolute bottom-8 left-1/2 -translate-x-1/2 z-20 flex gap-2">
					<?php foreach ( $slides as $i => $item ) : ?>
						<button class="maintenance-dot<?php echo 0 === $i ? ' active' : ''; ?>" data-i="<?php echo (int) $i; ?>" type="button" aria-label="<?php echo esc_attr( 'Slide ' . ( $i + 1 ) ); ?>"></button>
					<?php endforeach; ?>
				</div>
			<?php endif; ?>

		</section>
		<?php
	}
}