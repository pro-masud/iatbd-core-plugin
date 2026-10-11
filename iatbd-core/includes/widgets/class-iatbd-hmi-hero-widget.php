<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_HMI_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hmi_hero';
	}

	public function get_title() {
		return 'HMI Hero Slider';
	}

	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function themes() {
		return [
			'primary' => [
				'overlay'   => 'to-primary-900/40',
				'crumb'     => 'text-primary-300',
				'icon'      => 'text-primary-400',
				'highlight' => 'bg-gradient-to-r from-primary-300 to-accent-400 bg-clip-text text-transparent',
				'btn'       => 'bg-primary-500 hover:bg-primary-400 shadow-lg shadow-primary-500/30',
			],
			'accent'  => [
				'overlay'   => 'to-orange-900/40',
				'crumb'     => 'text-accent-300',
				'icon'      => 'text-accent-400',
				'highlight' => 'bg-gradient-to-r from-accent-400 to-primary-300 bg-clip-text text-transparent',
				'btn'       => 'bg-accent-500 hover:bg-accent-400',
			],
			'emerald' => [
				'overlay'   => 'to-emerald-900/40',
				'crumb'     => 'text-emerald-300',
				'icon'      => 'text-emerald-400',
				'highlight' => 'text-emerald-300',
				'btn'       => 'bg-emerald-500 hover:bg-emerald-400',
			],
		];
	}

	private function defaults() {
		return [
			1 => [
				'label'  => 'Slide 1',
				'bg'     => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1920&q=80',
				'theme'  => 'primary',
				'crumb'  => 'HMI Service',
				'icon'   => '',
				'badge'  => 'HUMAN MACHINE INTERFACE',
				'h1'     => 'Interfaces that',
				'h2'     => 'operators trust',
				'desc'   => 'Custom HMI screen design, PLC integration and commissioning, built for clarity, speed and confident decisions on the factory floor.',
				'b1_icon' => 'fas fa-arrow-right',
				'b1_text' => 'Get a Quote',
				'b2_text' => 'Explore Services',
			],
			2 => [
				'label'  => 'Slide 2',
				'bg'     => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80',
				'theme'  => 'accent',
				'crumb'  => 'Integration',
				'icon'   => 'fas fa-network-wired',
				'badge'  => 'INTEGRATION',
				'h1'     => 'One screen.',
				'h2'     => 'Full plant control.',
				'desc'   => 'Seamless HMI-PLC linking, alarms, recipes and trends, so your team sees what matters in real time.',
				'b1_icon' => 'fas fa-arrow-right',
				'b1_text' => 'Discuss Integration',
				'b2_text' => 'Our Capabilities',
			],
			3 => [
				'label'  => 'Slide 3',
				'bg'     => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80',
				'theme'  => 'emerald',
				'crumb'  => 'Support & Upgrade',
				'icon'   => 'fas fa-headset',
				'badge'  => 'SUPPORT & UPGRADE',
				'h1'     => 'Upgrade today.',
				'h2'     => 'Support always.',
				'desc'   => 'Legacy panel migration, backups, repairs and responsive technical support, so downtime does not own your production.',
				'b1_icon' => 'fas fa-phone-alt',
				'b1_text' => 'Get Support',
				'b2_text' => 'View Services',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Breadcrumb (same on all slides) */
		$this->start_controls_section( 'sec_crumb', [ 'label' => 'Breadcrumb' ] );
		$this->add_control( 'crumb_home_text', [ 'label' => 'Home Text', 'type' => $T, 'default' => 'Home' ] );
		$this->add_control( 'crumb_home_link', [ 'label' => 'Home Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => 'index.html' ] ] );
		$this->end_controls_section();

		/* 3 fixed slide sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 's' . $i . '_';
			$this->start_controls_section( 'sec_slide_' . $i, [ 'label' => $d['label'] ] );

			$this->add_control( $p . 'bg', [ 'label' => 'Background Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => $d['bg'] ] ] );
			$this->add_control( $p . 'theme', [
				'label'   => 'Color Theme',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d['theme'],
				'options' => [ 'primary' => 'Primary', 'accent' => 'Accent (Orange)', 'emerald' => 'Emerald' ],
			] );
			$this->add_control( $p . 'crumb', [ 'label' => 'Breadcrumb Current Text', 'type' => $T, 'default' => $d['crumb'] ] );
			$this->add_control( $p . 'icon', [
				'label'       => 'Badge Icon Class (empty = pulsing dot)',
				'type'        => $T,
				'default'     => $d['icon'],
				'placeholder' => 'fas fa-cog',
			] );
			$this->add_control( $p . 'badge', [ 'label' => 'Badge Text', 'type' => $T, 'default' => $d['badge'] ] );
			$this->add_control( $p . 'h1', [ 'label' => 'Heading (line 1)', 'type' => $T, 'default' => $d['h1'] ] );
			$this->add_control( $p . 'h2', [ 'label' => 'Heading (line 2, highlighted)', 'type' => $T, 'default' => $d['h2'] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['desc'] ] );

			$this->add_control( $p . 'b1_icon', [ 'label' => 'Button 1 Icon Class', 'type' => $T, 'default' => $d['b1_icon'], 'separator' => 'before' ] );
			$this->add_control( $p . 'b1_text', [ 'label' => 'Button 1 Text', 'type' => $T, 'default' => $d['b1_text'] ] );
			$this->add_control( $p . 'b1_link', [ 'label' => 'Button 1 Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#contact' ] ] );

			$this->add_control( $p . 'b2_text', [ 'label' => 'Button 2 Text', 'type' => $T, 'default' => $d['b2_text'], 'separator' => 'before' ] );
			$this->add_control( $p . 'b2_link', [ 'label' => 'Button 2 Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#services' ] ] );

			$this->end_controls_section();
		}
	}

	private function link_attrs( $url ) {
		$href = ! empty( $url['url'] ) ? $url['url'] : '#';
		$out  = ' href="' . esc_url( $href ) . '"';
		if ( ! empty( $url['is_external'] ) ) {
			$out .= ' target="_blank"';
		}
		if ( ! empty( $url['nofollow'] ) ) {
			$out .= ' rel="nofollow"';
		}
		return $out;
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$themes = $this->themes();
		?>
		<section class="hmi-hero relative pt-16 overflow-hidden" aria-label="HMI services">
			<?php
			for ( $i = 1; $i <= 3; $i++ ) :
				$p   = 's' . $i . '_';
				$t   = isset( $themes[ $s[ $p . 'theme' ] ] ) ? $themes[ $s[ $p . 'theme' ] ] : $themes['primary'];
				$bg  = ! empty( $s[ $p . 'bg' ]['url'] ) ? $s[ $p . 'bg' ]['url'] : '';
				$tag = 1 === $i ? 'h1' : 'h2';
				?>
				<article class="hmi-slide<?php echo 1 === $i ? ' active' : ''; ?>" data-slide="<?php echo esc_attr( $i - 1 ); ?>" aria-hidden="<?php echo 1 === $i ? 'false' : 'true'; ?>">
					<div class="slide-bg" style="background-image: url('<?php echo esc_url( $bg ); ?>');"></div>
					<div class="absolute inset-0 bg-gradient-to-br from-slate-950/90 via-slate-900/75 <?php echo esc_attr( $t['overlay'] ); ?>"></div>
					<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-24 sm:py-32">
						<nav class="flex items-center gap-2 text-sm text-slate-400 mb-7"<?php echo 1 === $i ? ' aria-label="Breadcrumb"' : ''; ?>>
							<a<?php echo $this->link_attrs( $s['crumb_home_link'] ); // phpcs:ignore WordPress.Security.EscapeOutput ?> class="hover:text-white"><?php echo esc_html( $s['crumb_home_text'] ); ?></a><i class="fas fa-chevron-right text-[10px]"></i><span class="<?php echo esc_attr( $t['crumb'] ); ?>"><?php echo esc_html( $s[ $p . 'crumb' ] ); ?></span>
						</nav>
						<div class="max-w-2xl">
							<p class="inline-flex items-center gap-2 px-3 py-1 rounded-full border border-white/15 bg-white/10 text-white/90 text-xs font-medium mb-6">
								<?php if ( ! empty( $s[ $p . 'icon' ] ) ) : ?>
									<i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?> <?php echo esc_attr( $t['icon'] ); ?>"></i>
								<?php else : ?>
									<span class="w-1.5 h-1.5 rounded-full bg-accent-400 animate-pulse"></span>
								<?php endif; ?>
								<?php echo esc_html( $s[ $p . 'badge' ] ); ?>
							</p>
							<<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="font-display text-4xl sm:text-5xl lg:text-[3.4rem] font-bold text-white leading-[1.15] mb-5"><?php echo esc_html( $s[ $p . 'h1' ] ); ?><br /><span class="<?php echo esc_attr( $t['highlight'] ); ?>"><?php echo esc_html( $s[ $p . 'h2' ] ); ?></span></<?php echo $tag; // phpcs:ignore WordPress.Security.EscapeOutput ?>>
							<p class="text-slate-300 text-base sm:text-lg leading-relaxed mb-8 max-w-lg"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
							<div class="flex flex-wrap gap-3">
								<a<?php echo $this->link_attrs( $s[ $p . 'b1_link' ] ); // phpcs:ignore WordPress.Security.EscapeOutput ?> class="inline-flex items-center gap-2 px-6 py-3 text-white font-semibold rounded-full transition <?php echo esc_attr( $t['btn'] ); ?>"><?php echo esc_html( $s[ $p . 'b1_text'] ); ?> <i class="<?php echo esc_attr( $s[ $p . 'b1_icon'] ); ?> text-xs"></i></a><a<?php echo $this->link_attrs( $s[ $p . 'b2_link' ] ); // phpcs:ignore WordPress.Security.EscapeOutput ?> class="inline-flex items-center gap-2 px-6 py-3 border border-white/25 text-white font-medium rounded-full hover:bg-white/10 transition"><?php echo esc_html( $s[ $p . 'b2_text'] ); ?></a>
							</div>
						</div>
					</div>
				</article>
			<?php endfor; ?>

			<div class="absolute bottom-7 left-1/2 -translate-x-1/2 z-20 flex items-center gap-2" role="group" aria-label="Choose hero slide">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<button type="button" class="hmi-dot<?php echo 1 === $i ? ' active' : ''; ?>" data-slide-to="<?php echo esc_attr( $i - 1 ); ?>" aria-label="Show slide <?php echo esc_attr( $i ); ?>" aria-pressed="<?php echo 1 === $i ? 'true' : 'false'; ?>"></button>
				<?php endfor; ?>
			</div>
		</section>
		<?php
	}
}