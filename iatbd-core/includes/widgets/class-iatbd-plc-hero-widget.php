<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Hero_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_hero';
	}

	public function get_title() {
		return esc_html__( 'IATBD PLC Hero Slider', 'iatbd-core' );
	}
	public function get_icon() {
		return 'eicon-slider-full-screen';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Tailwind class map (full strings so Tailwind can detect them) */
	private function themes() {
		return [
			'primary' => [
				'overlay'   => 'to-primary-900/55',
				'crumb'     => 'text-primary-300',
				'badge'     => 'bg-primary-500/20 border-primary-400/30 text-primary-300',
				'highlight' => 'text-primary-300',
				'btn'       => 'bg-primary-600 hover:bg-primary-500 shadow-primary-500/30',
			],
			'emerald' => [
				'overlay'   => 'to-emerald-900/50',
				'crumb'     => 'text-emerald-300',
				'badge'     => 'bg-emerald-500/20 border-emerald-400/30 text-emerald-300',
				'highlight' => 'text-emerald-300',
				'btn'       => 'bg-emerald-600 hover:bg-emerald-500',
			],
			'orange'  => [
				'overlay'   => 'to-orange-900/50',
				'crumb'     => 'text-orange-300',
				'badge'     => 'bg-orange-500/20 border-orange-400/30 text-orange-300',
				'highlight' => 'text-orange-300',
				'btn'       => 'bg-orange-500 hover:bg-orange-400',
			],
		];
	}

	private function defaults() {
		return [
			1 => [
				'label' => 'Slide 1',
				'bg'    => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1920&q=80',
				'theme' => 'primary',
				'b_icon' => 'fas fa-code',
				'badge' => 'PLC Programming',
				'h1'    => 'Expert',
				'h2'    => 'PLC Programming',
				'h3'    => 'for Every Brand',
				'desc'  => 'Ladder, Function Block ও Structured Text — Siemens, Allen-Bradley, Mitsubishi সহ সব প্ল্যাটফর্মে পরিষ্কার, ডকুমেন্টেড লজিক।',
				'btn1_icon' => 'fas fa-calendar-check',
				'btn1_text' => 'Request Quote',
				'btn1_link' => '#contact',
			],
			2 => [
				'label' => 'Slide 2',
				'bg'    => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=1920&q=80',
				'theme' => 'emerald',
				'b_icon' => 'fas fa-cogs',
				'badge' => 'Installation & Commissioning',
				'h1'    => 'Safe',
				'h2'    => 'Install & Commission',
				'h3'    => 'On Your Floor',
				'desc'  => 'প্যানেল স্থাপন, ওয়্যারিং, I/O টেস্ট, ড্রাই-রান ও লাইভ কমিশনিং — নিরাপদ স্টার্টআপ ও অপারেটর ট্রেনিংসহ।',
				'btn1_icon' => 'fas fa-calendar-check',
				'btn1_text' => 'Book Site Visit',
				'btn1_link' => '#contact',
			],
			3 => [
				'label' => 'Slide 3',
				'bg'    => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=80',
				'theme' => 'orange',
				'b_icon' => 'fas fa-headset',
				'badge' => 'Maintenance & 24/7 Support',
				'h1'    => 'Always-On',
				'h2'    => 'PLC Support',
				'h3'    => '& Maintenance',
				'desc'  => 'প্রিভেন্টিভ মেইনটেন্যান্স, ব্যাকআপ, ট্রাবলশুটিং ও রিপেয়ার — রিমোট বা অন-সাইট, যখনই দরকার।',
				'btn1_icon' => 'fas fa-phone-alt',
				'btn1_text' => 'Get Support',
				'btn1_link' => '#contact',
			],
		];
	}

	protected function register_controls() {

		/* Breadcrumb (same on all slides) */
		$this->start_controls_section( 'sec_crumb', [ 'label' => 'Breadcrumb' ] );
		$this->add_control( 'crumb_home_text', [ 'label' => 'Home Text', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => 'Home' ] );
		$this->add_control( 'crumb_home_link', [ 'label' => 'Home Link', 'type' => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '/' ] ] );
		$this->add_control( 'crumb_mid_text', [ 'label' => 'Middle Text', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => 'Services' ] );
		$this->add_control( 'crumb_current_text', [ 'label' => 'Current Text', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => 'PLC Service' ] );
		$this->end_controls_section();

		/* 3 fixed slide sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 's' . $i . '_';

			$this->start_controls_section( 'sec_slide_' . $i, [ 'label' => $d['label'] ] );

			$this->add_control( $p . 'bg', [
				'label'   => 'Background Image',
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [ 'url' => $d['bg'] ],
			] );
			$this->add_control( $p . 'theme', [
				'label'   => 'Color Theme',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d['theme'],
				'options' => [ 'primary' => 'Primary', 'emerald' => 'Emerald', 'orange' => 'Orange' ],
			] );
			$this->add_control( $p . 'b_icon', [
				'label'       => 'Badge Icon Class',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default'     => $d['b_icon'],
				'placeholder' => 'fas fa-cog',
			] );
			$this->add_control( $p . 'badge', [ 'label' => 'Badge Text', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d['badge'] ] );
			$this->add_control( $p . 'h1', [ 'label' => 'Heading (before highlight)', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d['h1'] ] );
			$this->add_control( $p . 'h2', [ 'label' => 'Heading (highlight)', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d['h2'] ] );
			$this->add_control( $p . 'h3', [ 'label' => 'Heading (new line)', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d['h3'] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['desc'] ] );

			$this->add_control( $p . 'btn1_icon', [ 'label' => 'Button 1 Icon Class', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d['btn1_icon'], 'separator' => 'before' ] );
			$this->add_control( $p . 'btn1_text', [ 'label' => 'Button 1 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => $d['btn1_text'] ] );
			$this->add_control( $p . 'btn1_link', [ 'label' => 'Button 1 Link', 'type' => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => $d['btn1_link'] ] ] );

			$this->add_control( $p . 'btn2_icon', [ 'label' => 'Button 2 Icon Class', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => 'fas fa-list', 'separator' => 'before' ] );
			$this->add_control( $p . 'btn2_text', [ 'label' => 'Button 2 Text', 'type' => \Elementor\Controls_Manager::TEXT, 'label_block' => true, 'default' => 'All Services' ] );
			$this->add_control( $p . 'btn2_link', [ 'label' => 'Button 2 Link', 'type' => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '#services-list' ] ] );

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
		<section class="relative pt-16 overflow-hidden plc-hero-slider">
		<?php
		for ( $i = 1; $i <= 3; $i++ ) :
			$p     = 's' . $i . '_';
			$t     = isset( $themes[ $s[ $p . 'theme' ] ] ) ? $themes[ $s[ $p . 'theme' ] ] : $themes['primary'];
			$bg    = ! empty( $s[ $p . 'bg' ]['url'] ) ? $s[ $p . 'bg' ]['url'] : '';
			$tag   = ( 1 === $i ) ? 'h1' : 'h2';
			?>
			<div class="plc-hero-slide<?php echo 1 === $i ? ' active' : ''; ?>" data-index="<?php echo esc_attr( $i - 1 ); ?>">
				<div class="slide-bg" style="background-image: url('<?php echo esc_url( $bg ); ?>');"></div>
				<div class="absolute inset-0 bg-gradient-to-r from-slate-950/92 via-slate-900/80 <?php echo esc_attr( $t['overlay'] ); ?>"></div>
				<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full py-16 sm:py-20">
					<nav class="flex items-center gap-2 text-sm text-slate-400 mb-6">
						<a<?php echo $this->link_attrs( $s['crumb_home_link'] ); ?> class="hover:text-white transition"><?php echo esc_html( $s['crumb_home_text'] ); ?></a>
						<i class="fas fa-chevron-right text-[10px]"></i>
						<span class="text-slate-400"><?php echo esc_html( $s['crumb_mid_text'] ); ?></span>
						<i class="fas fa-chevron-right text-[10px]"></i>
						<span class="<?php echo esc_attr( $t['crumb'] ); ?>"><?php echo esc_html( $s['crumb_current_text'] ); ?></span>
					</nav>
					<div class="max-w-3xl">
						<div class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full border text-sm font-medium mb-5 <?php echo esc_attr( $t['badge'] ); ?>">
							<i class="<?php echo esc_attr( $s[ $p . 'b_icon' ] ); ?>"></i> <?php echo esc_html( $s[ $p . 'badge' ] ); ?>
						</div>
						<<?php echo $tag; ?> class="font-display text-3xl sm:text-4xl lg:text-5xl font-bold text-white leading-tight mb-4">
							<?php echo esc_html( $s[ $p . 'h1' ] ); ?> <span class="<?php echo esc_attr( $t['highlight'] ); ?>"><?php echo esc_html( $s[ $p . 'h2' ] ); ?></span><br /><?php echo esc_html( $s[ $p . 'h3' ] ); ?>
						</<?php echo $tag; ?>>
						<p class="text-lg text-slate-300 leading-relaxed mb-8 max-w-2xl"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
						<div class="flex flex-wrap gap-3">
							<a<?php echo $this->link_attrs( $s[ $p . 'btn1_link' ] ); ?> class="inline-flex items-center gap-2 px-6 py-3 text-white font-semibold rounded-full shadow-lg transition hover:scale-105 <?php echo esc_attr( $t['btn'] ); ?>">
								<i class="<?php echo esc_attr( $s[ $p . 'btn1_icon' ] ); ?>"></i> <?php echo esc_html( $s[ $p . 'btn1_text' ] ); ?>
							</a>
							<a<?php echo $this->link_attrs( $s[ $p . 'btn2_link' ] ); ?> class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 hover:bg-white/15 border border-white/25 text-white font-semibold rounded-full backdrop-blur transition">
								<i class="<?php echo esc_attr( $s[ $p . 'btn2_icon' ] ); ?>"></i> <?php echo esc_html( $s[ $p . 'btn2_text' ] ); ?>
							</a>
						</div>
					</div>
				</div>
			</div>
		<?php endfor; ?>

			<div class="absolute bottom-6 left-1/2 -translate-x-1/2 z-20 flex gap-2.5">
				<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
					<button type="button" class="plc-hero-dot<?php echo 1 === $i ? ' active' : ''; ?>" data-index="<?php echo esc_attr( $i - 1 ); ?>" aria-label="Slide <?php echo esc_attr( $i ); ?>"></button>
				<?php endfor; ?>
			</div>
		</section>
		<?php
	}
}