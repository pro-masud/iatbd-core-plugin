<?php
/**
 * IATBD Home Store Widget
 * Elementor widget: Automation Products Store teaser with feature highlights and category cards.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Home_Store_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_home_store';
	}

	public function get_title() {
		return esc_html__( 'IATBD Home Store', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-cart-medium';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'store', 'shop', 'products', 'ecommerce', 'plc', 'hmi', 'vfd', 'servo', 'iatbd' ];
	}

	/**
	 * Predefined card color presets (kept literal for Tailwind scanning)
	 */
	private function get_card_color_styles() {
		return [
			'primary' => [
				'icon'   => 'text-primary-600 dark:text-primary-400',
				'border' => 'hover:border-primary-300 dark:hover:border-primary-600',
			],
			'orange'  => [
				'icon'   => 'text-orange-500',
				'border' => 'hover:border-orange-300 dark:hover:border-orange-600',
			],
			'emerald' => [
				'icon'   => 'text-emerald-600 dark:text-emerald-400',
				'border' => 'hover:border-emerald-300 dark:hover:border-emerald-600',
			],
			'purple'  => [
				'icon'   => 'text-purple-600 dark:text-purple-400',
				'border' => 'hover:border-purple-300 dark:hover:border-purple-600',
			],
		];
	}

	protected function register_controls() {

		/* ---------- Left Content / Header ---------- */
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content & Heading', 'iatbd-core' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => esc_html__( 'Section ID (Anchor)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'store',
			'description' => esc_html__( 'Used for #store anchor link. Without # sign.', 'iatbd-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Eyebrow', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Online Store',
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Automation Products Store',
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => 'PLC, HMI, VFD, Servo Drive, Sensors, Contactors, Cables এবং আরও অনেক অটোমেশন প্রোডাক্ট এক জায়গায়। জেনুইন পার্টস, দ্রুত ডেলিভারি।',
		] );

		$this->end_controls_section();

		/* ---------- Feature Badges ---------- */
		$this->start_controls_section( 'section_features', [
			'label' => esc_html__( 'Feature Highlights', 'iatbd-core' ),
		] );

		$feat_repeater = new \Elementor\Repeater();

		$feat_repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-shield-alt',
		] );

		$feat_repeater->add_control( 'icon_color', [
			'label'       => esc_html__( 'Icon Color Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'text-primary-600 dark:text-primary-400',
			'description' => esc_html__( 'Tailwind text color class, e.g. text-primary-600 dark:text-primary-400 or text-accent-500', 'iatbd-core' ),
		] );

		$feat_repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Genuine Parts',
		] );

		$feat_repeater->add_control( 'subtitle', [
			'label'       => esc_html__( 'Subtitle', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '100% Authentic',
		] );

		$this->add_control( 'features', [
			'label'       => esc_html__( 'Feature Badges', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $feat_repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'icon'       => 'fas fa-shield-alt',
					'icon_color' => 'text-primary-600 dark:text-primary-400',
					'title'      => 'Genuine Parts',
					'subtitle'   => '100% Authentic',
				],
				[
					'icon'       => 'fas fa-shipping-fast',
					'icon_color' => 'text-accent-500',
					'title'      => 'Fast Delivery',
					'subtitle'   => 'Nationwide',
				],
			],
		] );

		$this->end_controls_section();

		/* ---------- CTA Button ---------- */
		$this->start_controls_section( 'section_button', [
			'label' => esc_html__( 'CTA Button', 'iatbd-core' ),
		] );

		$this->add_control( 'btn_text', [
			'label'       => esc_html__( 'Button Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Browse Store',
		] );

		$this->add_control( 'btn_icon', [
			'label'       => esc_html__( 'Button Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-shopping-cart',
		] );

		$this->add_control( 'btn_link', [
			'label'         => esc_html__( 'Button Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'store-shop.html',
			'default'       => [
				'url' => 'store-shop.html',
			],
			'show_external' => true,
		] );

		$this->end_controls_section();

		/* ---------- Category Cards (Right Column) ---------- */
		$this->start_controls_section( 'section_cards', [
			'label' => esc_html__( 'Category Cards', 'iatbd-core' ),
		] );

		$card_repeater = new \Elementor\Repeater();

		$card_repeater->add_control( 'title', [
			'label'       => esc_html__( 'Category Title', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'PLC Modules',
		] );

		$card_repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-microchip',
		] );

		$card_repeater->add_control( 'desc', [
			'label'       => esc_html__( 'Description / Subtitle', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'CPU, I/O, Power Supply',
		] );

		$card_repeater->add_control( 'color_style', [
			'label'   => esc_html__( 'Color Theme', 'iatbd-core' ),
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

		$card_repeater->add_control( 'custom_icon_color', [
			'label'       => esc_html__( 'Custom Icon Color Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '',
			'condition'   => [
				'color_style' => 'custom',
			],
		] );

		$card_repeater->add_control( 'custom_border_color', [
			'label'       => esc_html__( 'Custom Hover Border Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '',
			'condition'   => [
				'color_style' => 'custom',
			],
		] );

		$card_repeater->add_control( 'link', [
			'label'         => esc_html__( 'Card Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'store-shop.html',
			'default'       => [
				'url' => 'store-shop.html',
			],
			'show_external' => true,
		] );

		$this->add_control( 'cards', [
			'label'       => esc_html__( 'Category Cards List', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $card_repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'title'       => 'PLC Modules',
					'icon'        => 'fas fa-microchip',
					'desc'        => 'CPU, I/O, Power Supply',
					'color_style' => 'primary',
					'link'        => [ 'url' => 'store-shop.html' ],
				],
				[
					'title'       => 'HMI Screens',
					'icon'        => 'fas fa-desktop',
					'desc'        => 'Touch & Keypad Panels',
					'color_style' => 'orange',
					'link'        => [ 'url' => 'store-shop.html' ],
				],
				[
					'title'       => 'VFD Series',
					'icon'        => 'fas fa-tachometer-alt',
					'desc'        => '0.4kW – 500kW+',
					'color_style' => 'emerald',
					'link'        => [ 'url' => 'store-shop.html' ],
				],
				[
					'title'       => 'Servo Systems',
					'icon'        => 'fas fa-cogs',
					'desc'        => 'Motors & Drives',
					'color_style' => 'purple',
					'link'        => [ 'url' => 'store-shop.html' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s            = $this->get_settings_for_display();
		$section_id   = ! empty( $s['section_id'] ) ? sanitize_html_class( $s['section_id'] ) : 'store';
		$features     = ! empty( $s['features'] ) ? $s['features'] : [];
		$cards        = ! empty( $s['cards'] ) ? $s['cards'] : [];
		$color_styles = $this->get_card_color_styles();

		// Button attributes
		$btn_key = 'store_cta_btn';
		$this->add_render_attribute( $btn_key, 'class', 'inline-flex items-center gap-2 px-7 py-3.5 bg-gradient-to-r from-accent-600 to-accent-500 text-white font-semibold rounded-full shadow-lg hover:scale-105 transition' );
		if ( ! empty( $s['btn_link']['url'] ) ) {
			$this->add_link_attributes( $btn_key, $s['btn_link'] );
		}
		?>
		<section id="<?php echo esc_attr( $section_id ); ?>" class="py-20 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid lg:grid-cols-2 gap-12 items-center">

					<!-- Left Column: Content, Feature Badges & CTA -->
					<div>
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-4 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-8"><?php echo esc_html( $s['description'] ); ?></p>
						<?php endif; ?>

						<?php if ( ! empty( $features ) ) : ?>
							<div class="grid grid-cols-2 gap-4 mb-8">
								<?php foreach ( $features as $feat ) : ?>
									<div class="flex items-center gap-3 bg-slate-50 dark:bg-slate-800/80 rounded-xl p-4 border border-slate-100 dark:border-slate-700">
										<?php if ( ! empty( $feat['icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $feat['icon'] ); ?> <?php echo esc_attr( $feat['icon_color'] ); ?> text-xl"></i>
										<?php endif; ?>
										<div>
											<?php if ( ! empty( $feat['title'] ) ) : ?>
												<p class="font-semibold text-sm text-slate-800 dark:text-slate-200"><?php echo esc_html( $feat['title'] ); ?></p>
											<?php endif; ?>
											<?php if ( ! empty( $feat['subtitle'] ) ) : ?>
												<p class="text-xs text-slate-400"><?php echo esc_html( $feat['subtitle'] ); ?></p>
											<?php endif; ?>
										</div>
									</div>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $s['btn_text'] ) ) : ?>
							<a <?php echo $this->get_render_attribute_string( $btn_key ); ?>>
								<?php if ( ! empty( $s['btn_icon'] ) ) : ?>
									<i class="<?php echo esc_attr( $s['btn_icon'] ); ?>"></i>
								<?php endif; ?>
								<?php echo esc_html( $s['btn_text'] ); ?>
							</a>
						<?php endif; ?>
					</div>

					<!-- Right Column: 4 Category Cards -->
					<?php if ( ! empty( $cards ) ) : ?>
						<div class="grid grid-cols-2 gap-4">
							<?php
							foreach ( $cards as $k => $card ) :
								$card_key = 'cat_card_' . $k;
								$style    = ! empty( $card['color_style'] ) ? $card['color_style'] : 'primary';

								if ( 'custom' === $style ) {
									$icon_cls   = ! empty( $card['custom_icon_color'] ) ? $card['custom_icon_color'] : 'text-primary-600';
									$border_cls = ! empty( $card['custom_border_color'] ) ? $card['custom_border_color'] : 'hover:border-primary-300';
								} elseif ( isset( $color_styles[ $style ] ) ) {
									$icon_cls   = $color_styles[ $style ]['icon'];
									$border_cls = $color_styles[ $style ]['border'];
								} else {
									$icon_cls   = $color_styles['primary']['icon'];
									$border_cls = $color_styles['primary']['border'];
								}

								$this->add_render_attribute( $card_key, 'class', 'bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl p-6 transition block ' . $border_cls );
								if ( ! empty( $card['link']['url'] ) ) {
									$this->add_link_attributes( $card_key, $card['link'] );
								}
								?>
								<a <?php echo $this->get_render_attribute_string( $card_key ); ?>>
									<?php if ( ! empty( $card['icon'] ) ) : ?>
										<i class="<?php echo esc_attr( $card['icon'] ); ?> text-3xl <?php echo esc_attr( $icon_cls ); ?> mb-3"></i>
									<?php endif; ?>
									<?php if ( ! empty( $card['title'] ) ) : ?>
										<h3 class="font-semibold text-slate-800 dark:text-slate-200 mb-1"><?php echo esc_html( $card['title'] ); ?></h3>
									<?php endif; ?>
									<?php if ( ! empty( $card['desc'] ) ) : ?>
										<p class="text-xs text-slate-400"><?php echo esc_html( $card['desc'] ); ?></p>
									<?php endif; ?>
								</a>
							<?php endforeach; ?>
						</div>
					<?php endif; ?>

				</div>
			</div>
		</section>
		<?php
	}
}

