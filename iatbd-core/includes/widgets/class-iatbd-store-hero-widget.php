<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Store_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_store_hero';
	}

	public function get_title() {
		return 'Store Hero Slider';
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	private function default_items() {
		return [
			[
				'image' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1800&q=80',
				'icon'  => 'fas fa-microchip',
				'badge' => 'PLC CONTROL',
				'title' => 'Industrial automation, ready for work.',
				'desc'  => 'PLCs, HMIs, drives and dependable accessories for your next machine build.',
				'btn'   => 'Shop products',
			],
			[
				'image' => 'https://images.unsplash.com/photo-1550751827-4bd374c3f58b?auto=format&fit=crop&w=1800&q=80',
				'icon'  => 'fas fa-tablet-alt',
				'badge' => 'HMI & CONTROL',
				'title' => 'Clear control for every operator.',
				'desc'  => 'Touch panels and communication essentials to keep your systems connected.',
				'btn'   => 'Explore the range',
			],
			[
				'image' => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=1800&q=80',
				'icon'  => 'fas fa-bolt',
				'badge' => 'DRIVES & MOTION',
				'title' => 'Motion components for precise machines.',
				'desc'  => 'Find VFDs, servo kits and the cables that bring your installation together.',
				'btn'   => 'Browse motion products',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		$this->start_controls_section( 'sec_slides', [ 'label' => 'Slides' ] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'image', [ 'label' => 'Background Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => '' ] ] );
		$rep->add_control( 'icon', [ 'label' => 'Badge Icon Class', 'type' => $T, 'label_block' => true, 'default' => '', 'placeholder' => 'fas fa-cog' ] );
		$rep->add_control( 'badge', [ 'label' => 'Badge Text', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$rep->add_control( 'title', [ 'label' => 'Heading', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '' ] );
		$rep->add_control( 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '' ] );
		$rep->add_control( 'btn', [ 'label' => 'Button Text', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$rep->add_control( 'link', [ 'label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#store-products' ] ] );

		$defaults = [];
		foreach ( $this->default_items() as $d ) {
			$defaults[] = [
				'image' => [ 'url' => $d['image'] ],
				'icon'  => $d['icon'],
				'badge' => $d['badge'],
				'title' => $d['title'],
				'desc'  => $d['desc'],
				'btn'   => $d['btn'],
				'link'  => [ 'url' => '#store-products' ],
			];
		}

		$this->add_control( 'slides', [
			'label'       => 'Slides',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'default'     => $defaults,
			'title_field' => '{{{ badge }}}',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$slides = ! empty( $s['slides'] ) ? $s['slides'] : [];
		?>
		<section class="store-hero-slider relative h-105 sm:h-117.5 lg:h-125 overflow-hidden pt-16 lg:pt-17.5" aria-label="Featured products">
			<?php
			foreach ( $slides as $i => $sl ) :
				$img  = ! empty( $sl['image']['url'] ) ? $sl['image']['url'] : '';
				$tag  = 0 === $i ? 'h1' : 'h2';
				$link = $sl['link'];
				$href = ! empty( $link['url'] ) ? $link['url'] : '#';
				$attr = ' href="' . esc_url( $href ) . '"';
				if ( ! empty( $link['is_external'] ) ) {
					$attr .= ' target="_blank"';
				}
				if ( ! empty( $link['nofollow'] ) ) {
					$attr .= ' rel="nofollow"';
				}
                ?>
				<div class="store-hero-slide<?php echo 0 === $i ? ' active' : ''; ?>" style="background-image: url('<?php echo esc_url( $img ); ?>');">
					<div class="relative z-10 max-w-7xl mx-auto h-full px-4 sm:px-6 lg:px-8 flex flex-col justify-center">
						<span class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/25 bg-white/10 text-white text-xs font-semibold mb-4 w-fit"><i class="<?php echo esc_attr( $sl['icon'] ); ?>"></i> <?php echo esc_html( $sl['badge'] ); ?></span>
						<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white mb-3 max-w-2xl leading-tight"><?php echo esc_html( $sl['title'] ); ?></<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
						<p class="text-base sm:text-lg text-slate-200 max-w-xl mb-6"><?php echo esc_html( $sl['desc'] ); ?></p>
						<a<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="inline-flex items-center gap-2 px-5 py-2.5 rounded-full bg-white text-primary-700 font-bold text-sm hover:bg-primary-50 transition w-fit"><?php echo esc_html( $sl['btn'] ); ?> <i class="fas fa-arrow-right text-xs"></i></a>
					</div>
				</div>
			<?php endforeach; ?>

			<button id="store-hero-prev" type="button" aria-label="Previous featured slide" class="absolute left-3 sm:left-6 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full flex items-center justify-center text-white bg-white/15 border border-white/25 hover:bg-white/30 transition">
				<i class="fas fa-chevron-left"></i>
			</button>
			<button id="store-hero-next" type="button" aria-label="Next featured slide" class="absolute right-3 sm:right-6 top-1/2 -translate-y-1/2 z-20 w-10 h-10 rounded-full flex items-center justify-center text-white bg-white/15 border border-white/25 hover:bg-white/30 transition">
				<i class="fas fa-chevron-right"></i>
			</button>
			<div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2" aria-label="Choose featured slide">
				<?php foreach ( $slides as $i => $sl ) : ?>
					<button type="button" class="store-hero-dot<?php echo 0 === $i ? ' active' : ''; ?>" aria-label="Show slide <?php echo esc_attr( $i + 1 ); ?>"></button>
				<?php endforeach; ?>
			</div>
		</section>
		<?php
	}
}