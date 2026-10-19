<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Brands_Marquee_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_brands_marquee';
	}

	public function get_title() {
		return esc_html__( 'Brands Marquee', 'iatbd-addons' );
	}

	public function get_icon() {
		return 'eicon-slider-push';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	protected function register_controls() {

		/* ---------- Heading ---------- */
		$this->start_controls_section( 'section_heading', [
			'label' => esc_html__( 'Heading', 'iatbd-addons' ),
		] );

		$this->add_control( 'section_id', [
			'label'   => esc_html__( 'Section ID', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'brands',
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__( 'Eyebrow', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Multi-Brand Coverage',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Heading', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'We Maintain All Major Brands',
		] );

		$this->end_controls_section();

		/* ---------- Banner ---------- */
		$this->start_controls_section( 'section_banner', [
			'label' => esc_html__( 'Banner', 'iatbd-addons' ),
		] );

		$this->add_control( 'banner_image', [
			'label'   => esc_html__( 'Image', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1200&q=80',
			],
		] );

		$this->add_control( 'banner_alt', [
			'label'   => esc_html__( 'Image Alt', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Industrial maintenance',
		] );

		$this->add_control( 'banner_title', [
			'label'   => esc_html__( 'Title', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Trusted across factories in Bangladesh',
		] );

		$this->add_control( 'banner_subtitle', [
			'label'   => esc_html__( 'Subtitle', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Siemens • ABB • Delta • Schneider • Mitsubishi • and more',
		] );

		$this->end_controls_section();

		/* ---------- Brands (Repeater) ---------- */
		$this->start_controls_section( 'section_brands', [
			'label' => esc_html__( 'Brands', 'iatbd-addons' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'name', [
			'label'   => esc_html__( 'Brand Name', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Siemens',
		] );

		$repeater->add_control( 'icon_class', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-addons' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-bolt',
			'placeholder' => 'fas fa-bolt',
		] );

		$repeater->add_control( 'icon_color_class', [
			'label'       => esc_html__( 'Icon Color Class', 'iatbd-addons' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'text-primary-500',
			'placeholder' => 'text-red-500',
		] );

		$defaults = [
			[ 'Siemens',       'text-primary-500' ],
			[ 'ABB',           'text-red-500' ],
			[ 'Danfoss',       'text-blue-500' ],
			[ 'Delta',         'text-emerald-500' ],
			[ 'Schneider',     'text-emerald-600' ],
			[ 'Mitsubishi',    'text-red-600' ],
			[ 'Yaskawa',       'text-blue-600' ],
			[ 'Allen-Bradley', 'text-orange-500' ],
			[ 'Omron',         'text-cyan-500' ],
			[ 'Fuji Electric', 'text-indigo-500' ],
			[ 'LS Electric',   'text-purple-500' ],
			[ 'Inovance',      'text-accent-500' ],
		];

		$default_items = [];
		foreach ( $defaults as $d ) {
			$default_items[] = [
				'name'             => $d[0],
				'icon_class'       => 'fas fa-bolt',
				'icon_color_class' => $d[1],
			];
		}

		$this->add_control( 'brands', [
			'label'       => esc_html__( 'Brand Items', 'iatbd-addons' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => $default_items,
			'title_field' => '{{{ name }}}',
		] );

		$this->end_controls_section();
	}

	/**
	 * Render a single set of brand chips (used twice for the marquee loop).
	 */
	private function render_chips( $items ) {
		foreach ( $items as $item ) {
			$icon  = ! empty( $item['icon_class'] ) ? $item['icon_class'] : 'fas fa-bolt';
			$color = ! empty( $item['icon_color_class'] ) ? $item['icon_color_class'] : '';
			?>
			<span class="brand-chip px-5 py-2.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-700 dark:text-slate-200 shadow-sm inline-flex items-center gap-2.5">
				<i class="<?php echo esc_attr( $icon . ' ' . $color ); ?>"></i> <?php echo esc_html( $item['name'] ); ?>
			</span>
			<?php
		}
	}

	protected function render() {
		$s        = $this->get_settings_for_display();
		$items    = ! empty( $s['brands'] ) ? $s['brands'] : [];
		$id_attr  = ! empty( $s['section_id'] ) ? ' id="' . esc_attr( $s['section_id'] ) . '"' : '';
		$img_url  = ! empty( $s['banner_image']['url'] ) ? $s['banner_image']['url'] : '';
		?>
		<section<?php echo $id_attr; ?> class="py-16 bg-slate-50 dark:bg-slate-900/60 overflow-hidden border-y border-slate-100 dark:border-slate-800/80">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mb-10">
				<div class="text-center">
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-2"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $s['heading'] ) ) : ?>
						<h2 class="font-display text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<?php endif; ?>
				</div>
			</div>

			<!-- Banner -->
			<div class="max-w-5xl mx-auto px-4 mb-10">
				<div class="relative rounded-2xl overflow-hidden h-40 sm:h-48 shadow-lg">
					<?php if ( $img_url ) : ?>
						<img
							src="<?php echo esc_url( $img_url ); ?>"
							alt="<?php echo esc_attr( $s['banner_alt'] ); ?>"
							class="w-full h-full object-cover"
							loading="lazy"
						/>
					<?php endif; ?>
					<div class="absolute inset-0 bg-gradient-to-r from-slate-900/85 via-slate-900/55 to-transparent flex items-center">
						<div class="px-8">
							<p class="text-white font-display font-bold text-xl sm:text-2xl"><?php echo esc_html( $s['banner_title'] ); ?></p>
							<p class="text-slate-300 text-sm mt-1"><?php echo esc_html( $s['banner_subtitle'] ); ?></p>
						</div>
					</div>
				</div>
			</div>

			<?php if ( $items ) : ?>
			<div class="brand-marquee">
				<div class="brand-track">
					<div class="flex items-center gap-8 px-4">
						<?php $this->render_chips( $items ); ?>
					</div>
					<div class="flex items-center gap-8 px-4" aria-hidden="true">
						<?php $this->render_chips( $items ); ?>
					</div>
				</div>
			</div>
			<?php endif; ?>
		</section>
		<?php
	}
}