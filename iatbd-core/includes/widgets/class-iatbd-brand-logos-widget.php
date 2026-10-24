<?php
/**
 * IATBD Brand Logos Widget
 * Elementor widget: infinite marquee logo ticker with text or image items.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Brand_Logos_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_brand_logos';
	}

	public function get_title() {
		return esc_html__( 'IATBD Brand Logos Marquee', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-carousel';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'brands', 'logos', 'marquee', 'ticker', 'partners', 'clients', 'iatbd' ];
	}

	protected function register_controls() {

		/* ---------- Section Settings ---------- */
		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Section Settings', 'iatbd-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Eyebrow Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Trusted by Leading Brands',
		] );

		$this->add_control( 'bg_classes', [
			'label'       => esc_html__( 'Section Tailwind Classes', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'py-14 bg-slate-700 dark:bg-slate-800 overflow-hidden',
		] );

		$this->add_control( 'speed', [
			'label'       => esc_html__( 'Scroll Duration (seconds)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::NUMBER,
			'min'         => 5,
			'max'         => 120,
			'step'        => 1,
			'default'     => 30,
			'description' => esc_html__( 'Marquee speed in seconds. Lower number scrolls faster.', 'iatbd-core' ),
		] );

		$this->add_control( 'pause_on_hover', [
			'label'        => esc_html__( 'Pause on Hover', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		/* ---------- Brands Repeater ---------- */
		$this->start_controls_section( 'section_brands', [
			'label' => esc_html__( 'Brand Logos', 'iatbd-core' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'name', [
			'label'       => esc_html__( 'Brand Name', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Siemens',
		] );

		$repeater->add_control( 'image', [
			'label'       => esc_html__( 'Brand Logo Image (optional)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::MEDIA,
			'description' => esc_html__( 'If uploaded, the image is displayed; otherwise, the brand name text is shown.', 'iatbd-core' ),
		] );

		$repeater->add_control( 'link', [
			'label'         => esc_html__( 'Brand Link (optional)', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'https://',
			'show_external' => true,
		] );

		$this->add_control( 'brands', [
			'label'       => esc_html__( 'Brands List', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ name }}}',
			'default'     => [
				[ 'name' => 'Siemens' ],
				[ 'name' => 'Allen-Bradley' ],
				[ 'name' => 'Mitsubishi' ],
				[ 'name' => 'Delta' ],
				[ 'name' => 'Schneider' ],
				[ 'name' => 'Omron' ],
				[ 'name' => 'ABB' ],
				[ 'name' => 'Yaskawa' ],
				[ 'name' => 'Fuji Electric' ],
				[ 'name' => 'Panasonic' ],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['brands'] ) ? $s['brands'] : [];
		$speed = ! empty( $s['speed'] ) ? (int) $s['speed'] : 30;
		$pause = 'yes' === $s['pause_on_hover'];
		?>
		<section class="<?php echo esc_attr( $s['bg_classes'] ); ?>">
			<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
				<div class="max-w-7xl mx-auto px-4 mb-8 text-center">
					<p class="text-slate-300 text-sm font-medium tracking-wide uppercase">
						<?php echo esc_html( $s['eyebrow'] ); ?>
					</p>
				</div>
			<?php endif; ?>

			<?php if ( ! empty( $items ) ) : ?>
				<div class="relative">
					<div class="logo-track" style="animation-duration: <?php echo (int) $speed; ?>s;<?php echo ! $pause ? ' animation-play-state: running !important;' : ''; ?>">
						<?php
						// Output twice for seamless infinite marquee loop
						for ( $repeat = 0; $repeat < 2; $repeat++ ) :
							foreach ( $items as $idx => $item ) :
								$name     = ! empty( $item['name'] ) ? $item['name'] : '';
								$img_url  = ! empty( $item['image']['url'] ) ? $item['image']['url'] : '';
								$has_link = ! empty( $item['link']['url'] );
								$tag      = $has_link ? 'a' : 'div';
								$link_key = 'logo_item_' . $repeat . '_' . $idx;

								$this->add_render_attribute( $link_key, 'class', 'logo-item' );
								if ( $has_link ) {
									$this->add_link_attributes( $link_key, $item['link'] );
								}
								?>
								<<?php echo esc_attr( $tag ); ?> <?php echo $this->get_render_attribute_string( $link_key ); ?>>
									<?php if ( ! empty( $img_url ) ) : ?>
										<img src="<?php echo esc_url( $img_url ); ?>" alt="<?php echo esc_attr( $name ); ?>" class="max-h-10 max-w-[120px] object-contain" />
									<?php else : ?>
										<span><?php echo esc_html( $name ); ?></span>
									<?php endif; ?>
								</<?php echo esc_attr( $tag ); ?>>
								<?php
							endforeach;
						endfor;
						?>
					</div>
				</div>
			<?php endif; ?>
		</section>
		<?php
	}
}

