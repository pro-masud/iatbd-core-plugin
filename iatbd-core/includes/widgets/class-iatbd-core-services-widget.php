<?php
/**
 * IATBD Core Services Widget
 * Elementor widget: 6 core service cards with background image overlay, icon badge, and description.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Core_Services_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_core_services';
	}

	public function get_title() {
		return esc_html__( 'IATBD Core Services', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'services', 'core', 'plc', 'hmi', 'vfd', 'maintenance', 'troubleshooting', 'repairing', 'iatbd' ];
	}

	protected function register_controls() {

		/* ---------- Section Header ---------- */
		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Section Header', 'iatbd-core' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => esc_html__( 'Section ID (Anchor)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'services',
			'description' => esc_html__( 'Anchor ID for #services menu navigation. Without # sign.', 'iatbd-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Eyebrow Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'What We Offer',
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Main Heading', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Our Core Services',
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'PLC, HMI, VFD থেকে মেইনটেন্যান্স, ট্রাবলশুটিং ও রিপেয়ারিং — সম্পূর্ণ সমাধান',
		] );

		$this->end_controls_section();

		/* ---------- Service Cards Repeater ---------- */
		$this->start_controls_section( 'section_cards', [
			'label' => esc_html__( 'Service Cards', 'iatbd-core' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'PLC',
		] );

		$repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-microchip',
			'placeholder' => 'fas fa-microchip',
		] );

		$repeater->add_control( 'desc', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 2,
			'default' => 'Programming, Installation & Commissioning for all major brands.',
		] );

		$repeater->add_control( 'image', [
			'label'   => esc_html__( 'Background Image', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
			],
		] );

		$repeater->add_control( 'link', [
			'label'         => esc_html__( 'Card Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'plc-service.html',
			'default'       => [
				'url' => 'plc-service.html',
			],
			'show_external' => true,
		] );

		$this->add_control( 'cards', [
			'label'       => esc_html__( 'Cards List', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'title' => 'PLC',
					'icon'  => 'fas fa-microchip',
					'desc'  => 'Programming, Installation & Commissioning for all major brands.',
					'image' => [
						'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80',
					],
					'link'  => [ 'url' => 'plc-service.html' ],
				],
				[
					'title' => 'HMI',
					'icon'  => 'fas fa-desktop',
					'desc'  => 'Touch panel design, screen development & system integration.',
					'image' => [
						'url' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=800&q=80',
					],
					'link'  => [ 'url' => 'hmi-service.html' ],
				],
				[
					'title' => 'VFD',
					'icon'  => 'fas fa-tachometer-alt',
					'desc'  => 'Drive selection, parameter setup & energy saving solutions.',
					'image' => [
						'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=800&q=80',
					],
					'link'  => [ 'url' => 'vfd-service.html' ],
				],
				[
					'title' => 'Maintenance',
					'icon'  => 'fas fa-tools',
					'desc'  => 'Preventive & predictive maintenance with health monitoring.',
					'image' => [
						'url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=800&q=80',
					],
					'link'  => [ 'url' => 'iatautomation-maintenance.html' ],
				],
				[
					'title' => 'Troubleshooting',
					'icon'  => 'fas fa-search',
					'desc'  => 'Rapid fault diagnosis, error code analysis & network fix.',
					'image' => [
						'url' => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=800&q=80',
					],
					'link'  => [ 'url' => 'iatautomation-troubleshooting.html' ],
				],
				[
					'title' => 'Repairing',
					'icon'  => 'fas fa-wrench',
					'desc'  => 'Board-level repair, genuine spare parts & full testing.',
					'image' => [
						'url' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=800&q=80',
					],
					'link'  => [ 'url' => 'iatautomation-repairing.html' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s          = $this->get_settings_for_display();
		$cards      = ! empty( $s['cards'] ) ? $s['cards'] : [];
		$section_id = ! empty( $s['section_id'] ) ? sanitize_html_class( $s['section_id'] ) : 'services';
		?>
		<section id="<?php echo esc_attr( $section_id ); ?>" class="py-20 bg-slate-50 dark:bg-slate-900">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<?php if ( ! empty( $s['eyebrow'] ) || ! empty( $s['heading'] ) || ! empty( $s['description'] ) ) : ?>
					<div class="text-center max-w-2xl mx-auto mb-14">
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $cards ) ) : ?>
					<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
						<?php
						foreach ( $cards as $i => $card ) :
							$link_key = 'card_link_' . $i;
							$img_url  = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
							$icon     = ! empty( $card['icon'] ) ? $card['icon'] : 'fas fa-cog';
							$title    = ! empty( $card['title'] ) ? $card['title'] : '';
							$desc     = ! empty( $card['desc'] ) ? $card['desc'] : '';

							$this->add_render_attribute( $link_key, 'class', 'svc-card group relative rounded-2xl overflow-hidden bg-slate-900 aspect-[4/3] block' );
							if ( ! empty( $card['link']['url'] ) ) {
								$this->add_link_attributes( $link_key, $card['link'] );
							}
							?>
							<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
								<div
									class="card-img absolute inset-0 bg-cover bg-center"
									<?php echo ! empty( $img_url ) ? 'style="background-image: url(\'' . esc_url( $img_url ) . '\');"' : ''; ?>
								></div>
								<div class="card-overlay absolute inset-0"></div>
								<div class="absolute bottom-0 left-0 right-0 p-6 z-10">
									<div class="flex items-center gap-3 mb-2">
										<?php if ( ! empty( $icon ) ) : ?>
											<div class="w-10 h-10 rounded-lg bg-white/20 backdrop-blur flex items-center justify-center">
												<i class="<?php echo esc_attr( $icon ); ?> text-white"></i>
											</div>
										<?php endif; ?>
										<?php if ( ! empty( $title ) ) : ?>
											<h3 class="font-display text-xl font-bold text-white"><?php echo esc_html( $title ); ?></h3>
										<?php endif; ?>
									</div>
									<?php if ( ! empty( $desc ) ) : ?>
										<p class="text-sm text-white/80"><?php echo esc_html( $desc ); ?></p>
									<?php endif; ?>
								</div>
							</a>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}

