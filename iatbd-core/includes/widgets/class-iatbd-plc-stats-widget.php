<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Stats_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_stats';
	}

	public function get_title() {
		return 'PLC Stats';
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	private function defaults() {
		return [
			1 => [ '15+', 'PLC Brands Supported' ],
			2 => [ '200+', 'PLC Projects Done' ],
			3 => [ '24/7', 'Technical Support' ],
			4 => [ '10+', 'Years Experience' ],
		];
	}

	protected function register_controls() {
		foreach ( $this->defaults() as $i => $d ) {
			$this->start_controls_section( 'sec_stat_' . $i, [ 'label' => 'Stat ' . $i ] );

			$this->add_control( 's' . $i . '_number', [
				'label'   => 'Number',
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => $d[0],
			] );
			$this->add_control( 's' . $i . '_label', [
				'label'   => 'Label',
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => $d[1],
			] );

			$this->end_controls_section();
		}
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="bg-primary-600 dark:bg-primary-700 py-6">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid grid-cols-2 md:grid-cols-4 gap-6 text-center text-white">
					<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
						<div>
							<p class="text-2xl sm:text-3xl font-display font-bold"><?php echo esc_html( $s[ 's' . $i . '_number' ] ); ?></p>
							<p class="text-primary-100 text-sm mt-0.5"><?php echo esc_html( $s[ 's' . $i . '_label' ] ); ?></p>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}