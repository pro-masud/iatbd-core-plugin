<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_HMI_Benefits_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hmi_benefits';
	}

	public function get_title() {
		return 'HMI Benefits';
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	private function defaults() {
		return [
			1 => [
				'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=500&q=80',
				'Clear operator UI',
				'Less confusion, fewer wrong presses and faster response to alarms.',
			],
			2 => [
				'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=500&q=80',
				'Stable integration',
				'Reliable PLC links mean fewer communication faults and data gaps.',
			],
			3 => [
				'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=500&q=80',
				'Faster decisions',
				'Live dashboards and trends make production status clear at a glance.',
			],
			4 => [
				'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=500&q=80',
				'Expert team',
				'Multi-brand HMI engineers from design through long-term support.',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'label_block' => true, 'default' => 'Benefits' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'Why plants choose IATBD' ] );
		$this->end_controls_section();

		/* 4 fixed benefit sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'b' . $i . '_';
			$this->start_controls_section( 'sec_benefit_' . $i, [ 'label' => 'Benefit ' . $i ] );
			$this->add_control( $p . 'img', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => $d[0] ] ] );
			$this->add_control( $p . 'alt', [ 'label' => 'Image Alt (empty = decorative)', 'type' => $T, 'label_block' => true, 'default' => '' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'label_block' => true, 'default' => $d[1] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d[2] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="py-20 sm:py-24 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center max-w-xl mx-auto mb-14">
					<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-3"><?php echo esc_html( $s['heading'] ); ?></h2>
				</div>
				<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
					<?php
					for ( $i = 1; $i <= 4; $i++ ) :
						$p   = 'b' . $i . '_';
						$img = ! empty( $s[ $p . 'img' ]['url'] ) ? $s[ $p . 'img' ]['url'] : '';
						?>
						<article class="svc-card bg-white dark:bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700/80">
							<div class="relative h-36 overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s[ $p . 'alt' ] ); ?>" class="iatbd-widget-image" />
							</div>
							<div class="p-5">
								<h3 class="font-semibold text-slate-900 dark:text-white mb-1.5"><?php echo esc_html( $s[ $p . 'title' ] ); ?></h3>
								<p class="text-sm text-slate-500 dark:text-slate-400"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
							</div>
						</article>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}