<?php
/**
 * GC Related Services – Elementor widget (repeater based)
 *
 * Original HTML markup + Tailwind classes are used as-is.
 * No CSS / JS is added by this widget — it only makes the content dynamic.
 *
 * Category : gc_widgets
 * Name     : gc_related_services
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class GC_Related_Services_Widget extends Widget_Base {

	public function get_name() {
		return 'gc_related_services';
	}

	public function get_title() {
		return esc_html__( 'GC Related Services', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'related', 'services', 'links', 'cards', 'gc' ];
	}

	protected function register_controls() {

		/* ---------- Header ---------- */
		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'softro-core' ),
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Small Title', 'softro-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Related services',
		] );

		$this->end_controls_section();

		/* ---------- Services (repeater) ---------- */
		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'Services', 'softro-core' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class', 'softro-core' ),
			'description' => esc_html__( 'Font Awesome class, e.g. fas fa-microchip', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'fas fa-microchip',
			'label_block' => true,
		] );

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Service Name',
			'label_block' => true,
		] );

		$repeater->add_control( 'subtitle', [
			'label'       => esc_html__( 'Short Text', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Short description',
			'label_block' => true,
		] );

		$repeater->add_control( 'link', [
			'label'         => esc_html__( 'Link', 'softro-core' ),
			'type'          => Controls_Manager::URL,
			'placeholder'   => 'https://your-link.com',
			'default'       => [ 'url' => '#' ],
			'show_external' => true,
		] );

		$repeater->add_control( 'tone', [
			'label'   => esc_html__( 'Icon Color', 'softro-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary', 'softro-core' ),
				'orange'  => esc_html__( 'Orange', 'softro-core' ),
				'emerald' => esc_html__( 'Green', 'softro-core' ),
				'rose'    => esc_html__( 'Rose', 'softro-core' ),
			],
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'softro-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ title }}}',
			'button_text' => esc_html__( 'Add Service', 'softro-core' ),
			'default'     => [
				[
					'icon'     => 'fas fa-microchip',
					'title'    => 'PLC Service',
					'subtitle' => 'Programming & install',
					'tone'     => 'primary',
					'link'     => [ 'url' => '#' ],
				],
				[
					'icon'     => 'fas fa-desktop',
					'title'    => 'HMI Service',
					'subtitle' => 'Screen design',
					'tone'     => 'orange',
					'link'     => [ 'url' => '#' ],
				],
				[
					'icon'     => 'fas fa-tachometer-alt',
					'title'    => 'VFD Service',
					'subtitle' => 'Drive setup',
					'tone'     => 'emerald',
					'link'     => [ 'url' => '#' ],
				],
				[
					'icon'     => 'fas fa-wrench',
					'title'    => 'Repairing',
					'subtitle' => 'Servo & encoder',
					'tone'     => 'rose',
					'link'     => [ 'url' => '#' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Full literal class strings so Tailwind can detect them.
	 */
	private function tone_class( $tone ) {
		$map = [
			'primary' => 'bg-primary-100 dark:bg-primary-900/30 text-primary-600',
			'orange'  => 'bg-orange-100 dark:bg-orange-900/30 text-orange-500',
			'emerald' => 'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600',
			'rose'    => 'bg-rose-100 dark:bg-rose-900/30 text-rose-500',
		];
		return isset( $map[ $tone ] ) ? $map[ $tone ] : $map['primary'];
	}

	/**
	 * Normalise the icon value to a Font Awesome class string.
	 * - accepts old saved array values (from the previous icon picker)
	 * - adds the "fas" prefix if only e.g. "fa-microchip" / "microchip" was typed
	 */
	private function icon_class( $icon ) {
		if ( is_array( $icon ) ) {
			$icon = isset( $icon['value'] ) && is_string( $icon['value'] ) ? $icon['value'] : '';
		}
		$icon = trim( (string) $icon );

		if ( '' === $icon ) {
			return 'fas fa-circle';
		}
		if ( ! preg_match( '/(^|\s)(fas|far|fab|fal|fad|fa-solid|fa-regular|fa-brands|fa)(\s|$)/', $icon ) ) {
			if ( 0 !== strpos( $icon, 'fa-' ) ) {
				$icon = 'fa-' . $icon;
			}
			$icon = 'fas ' . $icon;
		}
		return $icon;
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['items'] ) ? $s['items'] : [];
		?>
		<section class="py-16 bg-slate-50 dark:bg-slate-900/60">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<?php if ( ! empty( $s['heading'] ) ) : ?>
					<p class="text-center text-xs font-semibold text-slate-400 tracking-[0.15em] uppercase mb-8"><?php echo esc_html( $s['heading'] ); ?></p>
				<?php endif; ?>

				<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-4">
					<?php foreach ( $items as $i => $item ) :
						$key = 'link_' . $i;

						$this->add_render_attribute( $key, 'class', 'group flex items-center gap-4 p-4 rounded-2xl bg-white dark:bg-slate-900 border border-slate-100 dark:border-slate-800 hover:border-primary-300 transition shadow-sm' );

						if ( ! empty( $item['link']['url'] ) ) {
							$this->add_link_attributes( $key, $item['link'] );
						} else {
							$this->add_render_attribute( $key, 'href', '#' );
						}
						?>
						<a <?php $this->print_render_attribute_string( $key ); ?>>
							<span class="w-10 h-10 rounded-xl <?php echo esc_attr( $this->tone_class( $item['tone'] ) ); ?> flex items-center justify-center group-hover:scale-105 transition">
								<i class="<?php echo esc_attr( $this->icon_class( isset( $item['icon'] ) ? $item['icon'] : '' ) ); ?>"></i>
							</span>
							<div>
								<p class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo esc_html( $item['title'] ); ?></p>
								<?php if ( ! empty( $item['subtitle'] ) ) : ?>
									<p class="text-xs text-slate-500 dark:text-slate-400"><?php echo esc_html( $item['subtitle'] ); ?></p>
								<?php endif; ?>
							</div>
						</a>
					<?php endforeach; ?>
				</div>

			</div>
		</section>
		<?php
	}
}