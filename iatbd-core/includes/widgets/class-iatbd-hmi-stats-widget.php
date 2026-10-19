<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_HMI_Stats_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hmi_stats';
	}

	public function get_title() {
		return esc_html__( 'IATBD HMI Stats', 'iatbd-core' );
	}
	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	private function defaults() {
		return [
			1 => [ '12+', 'HMI Brands' ],
			2 => [ '150+', 'Projects Done' ],
			3 => [ '24/7', 'Support' ],
			4 => [ '10+', 'Years Experience' ],
		];
	}

	protected function register_controls() {
		foreach ( $this->defaults() as $i => $d ) {
			$this->start_controls_section( 'sec_stat_' . $i, [ 'label' => 'Stat ' . $i ] );
			$this->add_control( 's' . $i . '_number', [ 'label' => 'Number', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d[0] ] );
			$this->add_control( 's' . $i . '_label', [ 'label' => 'Label', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d[1] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="relative z-10 -mt-6" aria-label="HMI service statistics">
			<div class="max-w-5xl mx-auto px-4">
				<div class="hmi-float bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800 grid grid-cols-2 md:grid-cols-4 divide-x divide-slate-100 dark:divide-slate-800 overflow-hidden">
					<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
						<div class="p-5 sm:p-6 text-center">
							<p class="font-display text-2xl sm:text-3xl font-bold text-primary-600 dark:text-primary-400"><?php echo esc_html( $s[ 's' . $i . '_number' ] ); ?></p>
							<p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1"><?php echo esc_html( $s[ 's' . $i . '_label' ] ); ?></p>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}