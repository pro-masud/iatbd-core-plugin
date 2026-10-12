<?php
/**
 * GC Industrial CTA widget
 *
 * Original Tailwind markup, no new CSS/JS.
 * Icons use a plain TEXT field (Font Awesome class), not the Elementor icon picker.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Industrial_CTA_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_industrial_cta';
	}

	public function get_title() {
		return esc_html__( 'GC Industrial CTA', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'gc_widgets' ];
	}

	protected function register_controls() {

		// ---------- Content ----------
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'softro-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'section_id',
			[
				'label'       => esc_html__( 'Section ID', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'contact',
				'description' => esc_html__( 'Used for anchor links, e.g. #contact', 'softro-core' ),
			]
		);

		$this->add_control(
			'badge_icon',
			[
				'label'       => esc_html__( 'Badge Icon Class', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'fas fa-bolt',
				'description' => esc_html__( 'Font Awesome class, e.g. fas fa-bolt', 'softro-core' ),
			]
		);

		$this->add_control(
			'badge_text',
			[
				'label'   => esc_html__( 'Badge Text', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Start with one use case',
			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => esc_html__( 'Heading', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Bring practical AI to your production line',
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 4,
				'default' => 'Tell us about your equipment and process. Our automation team can help identify a focused first step.',
			]
		);

		$this->end_controls_section();

		// ---------- Buttons ----------
		$this->start_controls_section(
			'buttons_section',
			[
				'label' => esc_html__( 'Buttons', 'softro-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'text',
			[
				'label'   => esc_html__( 'Text', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Button',
			]
		);

		$repeater->add_control(
			'icon_class',
			[
				'label'       => esc_html__( 'Icon Class', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => 'fas fa-envelope',
				'description' => esc_html__( 'Font Awesome class, e.g. fas fa-envelope', 'softro-core' ),
			]
		);

		$repeater->add_control(
			'link',
			[
				'label'       => esc_html__( 'Link', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://your-link.com',
				'default'     => [
					'url' => '#',
				],
				'dynamic'     => [ 'active' => true ],
			]
		);

		$repeater->add_control(
			'style',
			[
				'label'   => esc_html__( 'Style', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => 'primary',
				'options' => [
					'primary' => esc_html__( 'Primary (solid)', 'softro-core' ),
					'outline' => esc_html__( 'Outline', 'softro-core' ),
				],
			]
		);

		$this->add_control(
			'buttons',
			[
				'label'       => esc_html__( 'Buttons', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => [
					[
						'text'       => 'Contact our team',
						'icon_class' => 'fas fa-envelope',
						'link'       => [ 'url' => 'mailto:info@iatbd.com?subject=Industrial%20AI%20Consultation' ],
						'style'      => 'primary',
					],
					[
						'text'       => 'AI applications',
						'icon_class' => 'fas fa-cogs',
						'link'       => [ 'url' => '#solutions' ],
						'style'      => 'outline',
					],
				],
			]
		);

		$this->end_controls_section();

		// ---------- Images ----------
		$this->start_controls_section(
			'images_section',
			[
				'label' => esc_html__( 'Images', 'softro-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'bg_image',
			[
				'label'   => esc_html__( 'Background Image', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1920&q=85',
				],
			]
		);

		$this->add_control(
			'bg_image_alt',
			[
				'label'   => esc_html__( 'Background Image Alt', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Industrial automation equipment in a factory',
			]
		);

		$this->add_control(
			'side_image',
			[
				'label'     => esc_html__( 'Side Image (desktop only)', 'softro-core' ),
				'type'      => \Elementor\Controls_Manager::MEDIA,
				'separator' => 'before',
				'default'   => [
					'url' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=900&q=85',
				],
			]
		);

		$this->add_control(
			'side_image_alt',
			[
				'label'   => esc_html__( 'Side Image Alt', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Engineer reviewing industrial control equipment',
			]
		);

		$this->add_control(
			'side_caption',
			[
				'label'   => esc_html__( 'Side Image Caption', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'PLC · HMI · VFD · AI',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$bg_url   = ! empty( $s['bg_image']['url'] ) ? $s['bg_image']['url'] : '';
		$side_url = ! empty( $s['side_image']['url'] ) ? $s['side_image']['url'] : '';
		?>
		<section <?php echo ! empty( $s['section_id'] ) ? 'id="' . esc_attr( $s['section_id'] ) . '"' : ''; ?> class="relative overflow-hidden">
			<div class="relative min-h-[420px] sm:min-h-[480px] flex items-center">
				<?php if ( $bg_url ) : ?>
					<img
						src="<?php echo esc_url( $bg_url ); ?>"
						alt="<?php echo esc_attr( $s['bg_image_alt'] ); ?>"
						class="absolute inset-0 h-full w-full object-cover"
						loading="lazy"
					/>
				<?php endif; ?>
				<div class="absolute inset-0 bg-gradient-to-r from-slate-950/95 via-blue-950/90 to-blue-900/75"></div>
				<div
					class="absolute inset-0 opacity-[0.07]"
					style="background-image: linear-gradient(rgba(255, 255, 255, 0.15) 1px, transparent 1px), linear-gradient(90deg, rgba(255, 255, 255, 0.15) 1px, transparent 1px); background-size: 40px 40px;"
				></div>
				<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16 sm:py-20">
					<div class="grid lg:grid-cols-2 gap-10 items-center">

						<?php if ( $side_url ) : ?>
							<div class="hidden lg:flex items-center justify-center">
								<div class="relative w-full max-w-md overflow-hidden rounded-2xl border border-white/20 shadow-2xl">
									<img
										src="<?php echo esc_url( $side_url ); ?>"
										alt="<?php echo esc_attr( $s['side_image_alt'] ); ?>"
										class="h-72 w-full object-cover"
										loading="lazy"
									/>
									<div class="absolute inset-0 bg-gradient-to-t from-slate-950/80 to-transparent"></div>
									<?php if ( ! empty( $s['side_caption'] ) ) : ?>
										<p class="absolute bottom-4 left-4 text-sm font-semibold text-white">
											<?php echo esc_html( $s['side_caption'] ); ?>
										</p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<div class="text-center lg:text-left">
							<?php if ( ! empty( $s['badge_text'] ) ) : ?>
								<div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-primary-500/20 border border-primary-400/30 text-primary-300 text-xs font-semibold uppercase mb-5">
									<?php if ( ! empty( $s['badge_icon'] ) ) : ?>
										<i class="<?php echo esc_attr( $s['badge_icon'] ); ?>" aria-hidden="true"></i>
									<?php endif; ?>
									<?php echo esc_html( $s['badge_text'] ); ?>
								</div>
							<?php endif; ?>

							<?php if ( ! empty( $s['heading'] ) ) : ?>
								<h2 class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-4 leading-tight">
									<?php echo esc_html( $s['heading'] ); ?>
								</h2>
							<?php endif; ?>

							<?php if ( ! empty( $s['description'] ) ) : ?>
								<p class="text-slate-300 text-base sm:text-lg mb-8 max-w-md mx-auto lg:mx-0 leading-relaxed">
									<?php echo esc_html( $s['description'] ); ?>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $s['buttons'] ) ) : ?>
								<div class="flex flex-wrap justify-center lg:justify-start gap-3">
									<?php
									foreach ( $s['buttons'] as $i => $btn ) :
										$is_outline = ( 'outline' === $btn['style'] );
										$classes    = $is_outline
											? 'inline-flex items-center gap-2.5 px-7 py-3.5 bg-white/10 hover:bg-white/15 border border-white/25 text-white font-semibold rounded-full btn-cta-outline'
											: 'inline-flex items-center gap-2.5 px-7 py-3.5 bg-primary-500 hover:bg-primary-400 text-white font-bold rounded-full btn-cta';

										$key = 'gc_btn_' . $i;
										$this->add_render_attribute( $key, 'class', $classes );
										if ( ! empty( $btn['link']['url'] ) ) {
											$this->add_link_attributes( $key, $btn['link'] );
										}
										?>
										<a <?php $this->print_render_attribute_string( $key ); ?>>
											<?php if ( ! empty( $btn['icon_class'] ) ) : ?>
												<i class="<?php echo esc_attr( $btn['icon_class'] ); ?>" aria-hidden="true"></i>
											<?php endif; ?>
											<?php echo esc_html( $btn['text'] ); ?>
										</a>
									<?php endforeach; ?>
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