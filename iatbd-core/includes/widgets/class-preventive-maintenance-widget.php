<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Preventive_Maintenance_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_preventive_maintenance';
	}

	public function get_title() {
		return esc_html__('IATBD Preventive Maintenance', 'iatbd-core');
	}

	public function get_icon() {
		return 'eicon-info-box';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	protected function register_controls() {

		/* ---------- Heading ---------- */
		$this->start_controls_section( 'section_heading', [
			'label' => esc_html__('Heading', 'iatbd-core'),
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__('Eyebrow', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Why Preventive Maintenance',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__('Heading', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Stop failures before they stop production',
		] );

		$this->end_controls_section();

		/* ---------- Items (4 fixed sections) ---------- */
		$items = [
			1 => [
				'icon'  => 'fas fa-chart-line',
				'title' => 'Higher uptime',
				'desc'  => 'Catch overheating, weak capacitors and loose connections before they trip the line.',
			],
			2 => [
				'icon'  => 'fas fa-coins',
				'title' => 'Lower lifetime cost',
				'desc'  => 'Planned care costs less than emergency repair and lost production.',
			],
			3 => [
				'icon'  => 'fas fa-database',
				'title' => 'Parameter security',
				'desc'  => 'Regular backups mean faster recovery if a unit ever needs replacement.',
			],
			4 => [
				'icon'  => 'fas fa-file-alt',
				'title' => 'Clear documentation',
				'desc'  => 'Every visit ends with a written condition report for your records.',
			],
		];

		foreach ( $items as $i => $item ) {

			$this->start_controls_section( 'section_item_' . $i, [
				'label' => sprintf( esc_html__('Item %d', 'iatbd-core'), $i ),
			] );

			$this->add_control( 'item_' . $i . '_icon', [
				'label'       => esc_html__('Icon Class (Font Awesome)', 'iatbd-core'),
				'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => $item['icon'],
				'placeholder' => 'fas fa-cog',
			] );

			$this->add_control( 'item_' . $i . '_title', [
				'label'   => esc_html__('Title', 'iatbd-core'),
				'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => $item['title'],
			] );

			$this->add_control( 'item_' . $i . '_desc', [
				'label'   => esc_html__('Description', 'iatbd-core'),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => $item['desc'],
			] );

			$this->end_controls_section();
		}

		/* ---------- Image ---------- */
		$this->start_controls_section( 'section_image', [
			'label' => esc_html__('Image & Badge', 'iatbd-core'),
		] );

		$this->add_control( 'image', [
			'label'   => esc_html__('Image', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [
				'url' => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=900&q=80',
			],
		] );

		$this->add_control( 'image_alt', [
			'label'   => esc_html__('Image Alt', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Maintenance technician',
		] );

		$this->add_control( 'badge_title', [
			'label'   => esc_html__('Badge Big Text', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Fewer',
		] );

		$this->add_control( 'badge_text', [
			'label'   => esc_html__('Badge Small Text', 'iatbd-core'),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Unplanned stoppages',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$img_url = ! empty( $s['image']['url'] ) ? $s['image']['url'] : '';
		?>
		<section class="py-20 bg-slate-50 dark:bg-slate-900/60 border-t border-slate-100 dark:border-slate-800/80">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid lg:grid-cols-2 gap-12 items-center">
					<div>
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-6"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>
						<div class="space-y-5">
							<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
								<div class="flex gap-4">
									<div class="w-11 h-11 rounded-xl bg-primary-100 dark:bg-primary-900/30 flex items-center justify-center flex-shrink-0">
										<i class="<?php echo esc_attr( $s[ 'item_' . $i . '_icon' ] ); ?> text-primary-600 dark:text-primary-400"></i>
									</div>
									<div>
										<h4 class="font-semibold text-slate-900 dark:text-white"><?php echo esc_html( $s[ 'item_' . $i . '_title' ] ); ?></h4>
										<p class="text-slate-600 dark:text-slate-400 text-sm"><?php echo esc_html( $s[ 'item_' . $i . '_desc' ] ); ?></p>
									</div>
								</div>
							<?php endfor; ?>
						</div>
					</div>
					<div class="relative">
						<div class="rounded-3xl overflow-hidden shadow-2xl">
							<?php if ( $img_url ) : ?>
								<img
									src="<?php echo esc_url( $img_url ); ?>"
									alt="<?php echo esc_attr( $s['image_alt'] ); ?>"
									class="w-full h-80 object-cover"
									loading="lazy"
								/>
							<?php endif; ?>
						</div>
						<div class="absolute -bottom-6 -left-6 bg-white dark:bg-slate-800 rounded-2xl p-5 shadow-xl border border-slate-100 dark:border-slate-700">
							<p class="text-3xl font-bold text-primary-600 dark:text-primary-400"><?php echo esc_html( $s['badge_title'] ); ?></p>
							<p class="text-sm text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['badge_text'] ); ?></p>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}