<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Maintenance_Process_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_maintenance_process';
	}

	public function get_title() {
		return esc_html__( 'Maintenance Process', 'iatbd-addons' );
	}

	public function get_icon() {
		return 'eicon-number-field';
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
			'default' => 'process',
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__( 'Eyebrow', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'How It Works',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Heading', 'iatbd-addons' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Simple Maintenance Process',
		] );

		$this->end_controls_section();

		/* ---------- Steps (4 fixed sections) ---------- */
		$steps = [
			1 => [
				'title' => 'Scope & Schedule',
				'desc'  => 'We agree equipment list, frequency and preferred visit windows.',
			],
			2 => [
				'title' => 'On-Site Visit',
				'desc'  => 'Inspection, cleaning, measurements and parameter backup on site.',
			],
			3 => [
				'title' => 'Findings',
				'desc'  => 'Clear report of condition, risks and recommended actions.',
			],
			4 => [
				'title' => 'Follow-Up',
				'desc'  => 'Support for any urgent fixes and planning for the next cycle.',
			],
		];

		foreach ( $steps as $i => $step ) {

			$this->start_controls_section( 'section_step_' . $i, [
				'label' => sprintf( esc_html__( 'Step %d', 'iatbd-addons' ), $i ),
			] );

			$this->add_control( 'step_' . $i . '_number', [
				'label'   => esc_html__( 'Number', 'iatbd-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => (string) $i,
			] );

			$this->add_control( 'step_' . $i . '_title', [
				'label'   => esc_html__( 'Title', 'iatbd-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'default' => $step['title'],
			] );

			$this->add_control( 'step_' . $i . '_desc', [
				'label'   => esc_html__( 'Description', 'iatbd-addons' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 3,
				'default' => $step['desc'],
			] );

			$this->end_controls_section();
		}
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$id_attr = ! empty( $s['section_id'] ) ? ' id="' . esc_attr( $s['section_id'] ) . '"' : '';
		?>
		<section<?php echo $id_attr; ?> class="py-20 sm:py-28 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center mb-14">
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<?php endif; ?>
					<?php if ( ! empty( $s['heading'] ) ) : ?>
						<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<?php endif; ?>
				</div>

				<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
					<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
						<div class="process-card bg-slate-50 dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 text-center">
							<div class="process-num w-12 h-12 rounded-full bg-primary-600 text-white font-bold text-lg flex items-center justify-center mx-auto mb-4 shadow-lg shadow-primary-500/30"><?php echo esc_html( $s[ 'step_' . $i . '_number' ] ); ?></div>
							<h3 class="font-semibold text-slate-900 dark:text-white mb-2"><?php echo esc_html( $s[ 'step_' . $i . '_title' ] ); ?></h3>
							<p class="text-sm text-slate-600 dark:text-slate-400"><?php echo esc_html( $s[ 'step_' . $i . '_desc' ] ); ?></p>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}