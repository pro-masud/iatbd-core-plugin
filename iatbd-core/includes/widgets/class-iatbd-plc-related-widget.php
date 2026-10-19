<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Related_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_related';
	}

	public function get_title() {
		return esc_html__( 'IATBD PLC Related Services', 'iatbd-core' );
	}
	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function colors() {
		return [
			'orange'  => [
				'box'  => 'bg-orange-100 dark:bg-orange-900/30',
				'icon' => 'text-orange-500',
			],
			'emerald' => [
				'box'  => 'bg-emerald-100 dark:bg-emerald-900/30',
				'icon' => 'text-emerald-600',
			],
			'cyan'    => [
				'box'  => 'bg-cyan-100 dark:bg-cyan-900/30',
				'icon' => 'text-cyan-600',
			],
			'rose'    => [
				'box'  => 'bg-rose-100 dark:bg-rose-900/30',
				'icon' => 'text-rose-500',
			],
		];
	}

	private function defaults() {
		return [
			1 => [ 'orange', 'fas fa-desktop', 'HMI Service', 'Touch panel design', 'hmi-service.html' ],
			2 => [ 'emerald', 'fas fa-tachometer-alt', 'VFD Service', 'Drive setup & tuning', '#' ],
			3 => [ 'cyan', 'fas fa-tools', 'Maintenance', 'Preventive care', '#' ],
			4 => [ 'rose', 'fas fa-wrench', 'Repairing', 'Module & board repair', '#' ],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'Related Services' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'PLC-এর সাথে আরও যেসব সার্ভিস নিতে পারেন' ] );
		$this->end_controls_section();

		/* 4 fixed item sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'r' . $i . '_';
			$this->start_controls_section( 'sec_item_' . $i, [ 'label' => 'Service ' . $i ] );
			$this->add_control( $p . 'color', [
				'label'   => 'Icon Box Color',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d[0],
				'options' => [ 'orange' => 'Orange', 'emerald' => 'Emerald', 'cyan' => 'Cyan', 'rose' => 'Rose' ],
			] );
			$this->add_control( $p . 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'label_block' => true, 'default' => $d[1], 'placeholder' => 'fas fa-cog' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'label_block' => true, 'default' => $d[2] ] );
			$this->add_control( $p . 'sub', [ 'label' => 'Subtitle', 'type' => $T, 'label_block' => true, 'default' => $d[3] ] );
			$this->add_control( $p . 'link', [ 'label' => 'Link', 'type' => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => $d[4] ] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$colors = $this->colors();
		?>
		<section class="py-16 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center mb-10">
					<h2 class="font-display text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400 text-sm mt-2"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>
				<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
					<?php
					for ( $i = 1; $i <= 4; $i++ ) :
						$p    = 'r' . $i . '_';
						$c    = isset( $colors[ $s[ $p . 'color' ] ] ) ? $colors[ $s[ $p . 'color' ] ] : $colors['orange'];
						$link = $s[ $p . 'link' ];
						$href = ! empty( $link['url'] ) ? $link['url'] : '#';
						$attr = ' href="' . esc_url( $href ) . '"';
						if ( ! empty( $link['is_external'] ) ) {
							$attr .= ' target="_blank"';
						}
						if ( ! empty( $link['nofollow'] ) ) {
							$attr .= ' rel="nofollow"';
						}
						?>
						<a<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="group flex items-center gap-4 p-4 bg-slate-50 dark:bg-slate-800/80 rounded-xl border border-slate-100 dark:border-slate-700 hover:border-primary-300 dark:hover:border-primary-600 transition">
							<div class="w-11 h-11 rounded-lg flex items-center justify-center group-hover:scale-110 transition <?php echo esc_attr( $c['box'] ); ?>">
								<i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?> <?php echo esc_attr( $c['icon'] ); ?>"></i>
							</div>
							<div>
								<p class="font-semibold text-sm text-slate-900 dark:text-white"><?php echo esc_html( $s[ $p . 'title' ] ); ?></p>
								<p class="text-xs text-slate-500 dark:text-slate-400"><?php echo esc_html( $s[ $p . 'sub' ] ); ?></p>
							</div>
						</a>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}