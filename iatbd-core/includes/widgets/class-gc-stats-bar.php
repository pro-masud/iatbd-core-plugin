<?php
/**
 * GC Stats Bar
 * Elementor widget: a strip of stats (value + label), repeater driven.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Stats_Bar_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_stats_bar';
	}

	public function get_title() {
		return esc_html__( 'IATBD Stats Bar 2', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'iatbd-addons', 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'stats', 'counter', 'numbers', 'strip', 'gc' ];
	}

	/**
	 * Literal Tailwind classes per desktop column count (so Tailwind can detect them).
	 */
	private function get_column_classes() {
		return [
			'2' => 'md:grid-cols-2',
			'3' => 'md:grid-cols-3',
			'4' => 'md:grid-cols-4',
			'5' => 'md:grid-cols-5',
			'6' => 'md:grid-cols-6',
		];
	}

	protected function register_controls() {

		$this->start_controls_section( 'section_stats', [
			'label' => esc_html__( 'Stats', 'iatbd-core' ),
		] );

		$this->add_control( 'columns', [
			'label'   => esc_html__( 'Columns (desktop)', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '4',
			'options' => [
				'2' => '2',
				'3' => '3',
				'4' => '4',
				'5' => '5',
				'6' => '6',
			],
		] );

		$r = new \Elementor\Repeater();

		$r->add_control( 'value', [
			'label'   => esc_html__( 'Value', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => '300+',
		] );

		$r->add_control( 'label', [
			'label'   => esc_html__( 'Label', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Maintenance Visits Completed',
		] );

		$this->add_control( 'stats', [
			'label'       => esc_html__( 'Items', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'title_field' => '{{{ value }}} - {{{ label }}}',
			'default'     => [
				[ 'value' => '300+', 'label' => 'Maintenance Visits Completed' ],
				[ 'value' => '15+', 'label' => 'Brands Covered' ],
				[ 'value' => 'Plans', 'label' => 'Quarterly & Annual' ],
				[ 'value' => 'Report', 'label' => 'After Every Visit' ],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['stats'] ) ? $s['stats'] : [];
		if ( empty( $items ) ) {
			return;
		}

		$cols    = $this->get_column_classes();
		$col_cls = isset( $cols[ $s['columns'] ] ) ? $cols[ $s['columns'] ] : $cols['4'];
		?>
		<section class="py-8 bg-slate-50 dark:bg-slate-900 border-y border-slate-200 dark:border-slate-800">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid grid-cols-2 <?php echo esc_attr( $col_cls ); ?> gap-6 text-center">
					<?php foreach ( $items as $item ) : ?>
						<div class="p-2">
							<?php if ( '' !== (string) $item['value'] ) : ?>
								<p class="text-2xl md:text-3xl font-bold text-primary-600 dark:text-primary-400"><?php echo esc_html( $item['value'] ); ?></p>
							<?php endif; ?>
							<?php if ( '' !== (string) $item['label'] ) : ?>
								<p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?php echo esc_html( $item['label'] ); ?></p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}