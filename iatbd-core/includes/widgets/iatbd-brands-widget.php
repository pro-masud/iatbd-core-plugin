<?php
/**
 * IATBD Brand Chips (8 fixed fields, no repeater)
 *
 * Markup/classes are the same as the original static HTML
 * (.brand-chip ...). Only the content is made editable.
 */
class IATBD_Brands extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_brands';
	}

	public function get_title() {
		return esc_html__( 'IATBD Brands', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-tags';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'brands', 'chips', 'platforms', 'iatbd' ];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		$this->start_controls_section( 'content_section', [
			'label' => esc_html__( 'Content', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Motion platforms we support',
			'label_block' => true,
		] );

		$brands = [
			1 => 'Siemens',
			2 => 'Mitsubishi',
			3 => 'Delta',
			4 => 'Yaskawa',
			5 => 'Panasonic',
			6 => 'Omron',
			7 => 'Schneider',
			8 => 'Allen-Bradley',
		];

		foreach ( $brands as $n => $name ) {
			$this->add_control( "brand{$n}", [
				'label'       => sprintf( esc_html__( 'Brand %d', 'elementor-test' ), $n ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $name,
				'label_block' => true,
				'separator'   => 1 === $n ? 'before' : 'default',
			] );
		}

		$this->end_controls_section();
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();
		?>

		<section class="py-14 bg-white dark:bg-slate-950 border-y border-slate-100 dark:border-slate-800/80">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<?php if ( ! empty( $s['title'] ) ) : ?>
					<p class="text-center text-xs font-semibold text-slate-400 tracking-[0.2em] uppercase mb-8"><?php echo esc_html( $s['title'] ); ?></p>
				<?php endif; ?>

				<div class="flex flex-wrap justify-center gap-3">
					<?php
					for ( $n = 1; $n <= 8; $n++ ) :
						if ( empty( $s[ "brand{$n}" ] ) ) {
							continue;
						}
						?>
						<span class="brand-chip px-5 py-2.5 rounded-full border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-sm font-semibold text-slate-600 dark:text-slate-300 cursor-default shadow-sm"><?php echo esc_html( $s[ "brand{$n}" ] ); ?></span>
					<?php endfor; ?>
				</div>

			</div>
		</section>

		<?php
	}
}