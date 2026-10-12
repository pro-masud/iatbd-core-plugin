<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Store_Benefits_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_store_benefits';
	}

	public function get_title() {
		return 'Store Benefits Strip';
	}

	public function get_icon() {
		return 'eicon-icon-box';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function colors() {
		return [
			'emerald' => 'text-emerald-500',
			'primary' => 'text-primary-500',
			'accent'  => 'text-accent-500',
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		$this->start_controls_section( 'sec_items', [ 'label' => 'Benefits' ] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'label_block' => true, 'default' => '', 'placeholder' => 'fas fa-truck' ] );
		$rep->add_control( 'color', [
			'label'   => 'Icon Color',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'emerald',
			'options' => [ 'emerald' => 'Emerald', 'primary' => 'Primary', 'accent' => 'Accent' ],
		] );
		$rep->add_control( 'text', [ 'label' => 'Text', 'type' => $T, 'label_block' => true, 'default' => '' ] );

		$this->add_control( 'items', [
			'label'       => 'Items',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'default'     => [
				[ 'icon' => 'fas fa-money-bill-wave', 'color' => 'emerald', 'text' => 'Cash on Delivery' ],
				[ 'icon' => 'fas fa-shield-alt', 'color' => 'primary', 'text' => 'Genuine products' ],
				[ 'icon' => 'fas fa-truck', 'color' => 'accent', 'text' => 'Nationwide delivery' ],
			],
			'title_field' => '{{{ text }}}',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$colors = $this->colors();
		?>
		<section class="bg-white dark:bg-slate-900 border-b border-slate-200 dark:border-slate-800" aria-label="Store benefits">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6">
				<?php if ( ! empty( $s['items'] ) ) : ?>
					<?php foreach ( $s['items'] as $it ) : ?>
						<?php $col = isset( $colors[ $it['color'] ] ) ? $colors[ $it['color'] ] : $colors['emerald']; ?>
						<div class="flex items-center justify-center gap-2 text-sm font-medium text-slate-600 dark:text-slate-300">
							<i class="<?php echo esc_attr( $it['icon'] ); ?> <?php echo esc_attr( $col ); ?>"></i> <?php echo esc_html( $it['text'] ); ?>
						</div>
					<?php endforeach; ?>
				<?php endif; ?>
			</div>
		</section>
		<?php
	}
}
