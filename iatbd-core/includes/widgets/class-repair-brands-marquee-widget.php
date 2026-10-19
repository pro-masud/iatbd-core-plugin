<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Repair_Brands_Marquee_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_repair_brands_marquee';
	}

	public function get_title() {
		return esc_html__('IATBD Repair Brands Marquee', 'iatbd-core');
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
			'label' => esc_html__('Heading', 'iatbd-core'),
		] );

		$this->add_control( 'section_id', [
			'label'   => esc_html__('Section ID', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'brands',
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__('Eyebrow', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Multi-Brand Repair',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__('Heading', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'We Repair All Major Brands',
		] );

		$this->end_controls_section();

		/* ---------- Brands (Repeater) ---------- */
		$this->start_controls_section( 'section_brands', [
			'label' => esc_html__('Brands', 'iatbd-core'),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'name', [
			'label'   => esc_html__('Brand Name', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Siemens',
		] );

		$repeater->add_control( 'icon_class', [
			'label'       => esc_html__('Icon Class (Font Awesome)', 'iatbd-core'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-bolt',
			'placeholder' => 'fas fa-bolt',
		] );

		$repeater->add_control( 'icon_color_class', [
			'label'       => esc_html__('Icon Color Class', 'iatbd-core'),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
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
			'label'       => esc_html__('Brand Items', 'iatbd-core'),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'default'     => $default_items,
			'title_field' => '{{{ name }}}',
		] );

		$this->end_controls_section();
	}

	/**
	 * Render one set of brand chips (called twice for the marquee loop).
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
		$s       = $this->get_settings_for_display();
		$items   = ! empty( $s['brands'] ) ? $s['brands'] : [];
		$id_attr = ! empty( $s['section_id'] ) ? ' id="' . esc_attr( $s['section_id'] ) . '"' : '';
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