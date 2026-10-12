<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Benefits_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_benefits';
	}

	public function get_title() {
		return 'PLC Benefits';
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function colors() {
		return [
			'primary' => 'bg-primary-500',
			'emerald' => 'bg-emerald-500',
			'orange'  => 'bg-orange-500',
			'purple'  => 'bg-purple-500',
		];
	}

	private function defaults() {
		return [
			1 => [
				'img'   => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=500&q=80',
				'alt'   => 'Higher Productivity',
				'color' => 'primary',
				'icon'  => 'fas fa-tachometer-alt',
				'title' => 'Higher Productivity',
				'desc'  => 'স্মার্ট সিকোয়েন্স ও অপটিমাইজড কন্ট্রোলে চক্র সময় কমে, আউটপুট ও গুণমান দুটোই বাড়ে।',
			],
			2 => [
				'img'   => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=500&q=80',
				'alt'   => 'Reliable Operation',
				'color' => 'emerald',
				'icon'  => 'fas fa-shield-alt',
				'title' => 'Reliable Operation',
				'desc'  => 'পরীক্ষিত লজিক, ব্যাকআপ ও প্রিভেন্টিভ কেয়ারে অপ্রত্যাশিত থেমে যাওয়া কমে, প্রসেস স্থিতিশীল থাকে।',
			],
			3 => [
				'img'   => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=500&q=80',
				'alt'   => 'Easy Scalability',
				'color' => 'orange',
				'icon'  => 'fas fa-chart-line',
				'title' => 'Easy Scalability',
				'desc'  => 'মডুলার ডিজাইনে নতুন মেশিন বা লাইন যোগ করা সহজ — ভবিষ্যতের এক্সপ্যানশনের জন্য প্রস্তুত।',
			],
			4 => [
				'img'   => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=500&q=80',
				'alt'   => 'Skilled Automation Team',
				'color' => 'purple',
				'icon'  => 'fas fa-user-check',
				'title' => 'Expert Team',
				'desc'  => 'মাল্টি-ব্র্যান্ড অভিজ্ঞ ইঞ্জিনিয়ার টিম — প্রজেক্ট শুরু থেকে হ্যান্ডওভার ও পরে সাপোর্ট পর্যন্ত পাশে।',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Section heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'default' => 'Why Choose Us' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'default' => 'Benefits of IATBD PLC Service' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'শুধু ইনস্টল নয় — দীর্ঘমেয়াদী নির্ভরযোগ্যতা, স্বচ্ছ ডকুমেন্টেশন ও দ্রুত সাপোর্ট' ] );
		$this->end_controls_section();

		/* 4 fixed benefit sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'b' . $i . '_';
			$this->start_controls_section( 'sec_benefit_' . $i, [ 'label' => 'Benefit ' . $i ] );
			$this->add_control( $p . 'img', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => $d['img'] ] ] );
			$this->add_control( $p . 'alt', [ 'label' => 'Image Alt', 'type' => $T, 'default' => $d['alt'] ] );
			$this->add_control( $p . 'color', [
				'label'   => 'Icon Box Color',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d['color'],
				'options' => [ 'primary' => 'Primary', 'emerald' => 'Emerald', 'orange' => 'Orange', 'purple' => 'Purple' ],
			] );
			$this->add_control( $p . 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'default' => $d['icon'], 'placeholder' => 'fas fa-cog' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'default' => $d['title'] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['desc'] ] );
			$this->end_controls_section();
		}

		/* CTA button */
		$this->start_controls_section( 'sec_cta', [ 'label' => 'Button' ] );
		$this->add_control( 'cta_text', [ 'label' => 'Button Text', 'type' => $T, 'default' => 'Discuss Your Project' ] );
		$this->add_control( 'cta_icon', [ 'label' => 'Button Icon Class', 'type' => $T, 'default' => 'fas fa-arrow-right', 'placeholder' => 'fas fa-arrow-right' ] );
		$this->add_control( 'cta_link', [ 'label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#contact' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$colors = $this->colors();

		$cta  = $s['cta_link'];
		$href = ! empty( $cta['url'] ) ? $cta['url'] : '#';
		$attr = ' href="' . esc_url( $href ) . '"';
		if ( ! empty( $cta['is_external'] ) ) {
			$attr .= ' target="_blank"';
		}
		if ( ! empty( $cta['nofollow'] ) ) {
			$attr .= ' rel="nofollow"';
		}
		?>
		<section class="py-16 sm:py-20 bg-slate-50 dark:bg-slate-900">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center max-w-2xl mx-auto mb-12">
					<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>

				<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6">
					<?php
					for ( $i = 1; $i <= 4; $i++ ) :
						$p   = 'b' . $i . '_';
						$img = ! empty( $s[ $p . 'img' ]['url'] ) ? $s[ $p . 'img' ]['url'] : '';
						$col = isset( $colors[ $s[ $p . 'color' ] ] ) ? $colors[ $s[ $p . 'color' ] ] : $colors['primary'];
						?>
						<div class="group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700 shadow-sm hover:shadow-xl hover:border-primary-200 dark:hover:border-primary-700 transition">
							<div class="relative h-40 overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s[ $p . 'alt' ] ); ?>" class="iatbd-widget-image group-hover:scale-105 transition duration-500" />
								<div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 to-transparent"></div>
								<div class="absolute bottom-3 left-3 w-10 h-10 rounded-lg flex items-center justify-center <?php echo esc_attr( $col ); ?>">
									<i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?> text-white"></i>
								</div>
							</div>
							<div class="p-5">
								<h3 class="font-display font-semibold text-slate-900 dark:text-white mb-2"><?php echo esc_html( $s[ $p . 'title' ] ); ?></h3>
								<p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
							</div>
						</div>
					<?php endfor; ?>
				</div>

				<div class="text-center mt-10">
					<a<?php echo $attr; ?> class="inline-flex items-center gap-2 px-7 py-3.5 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-full shadow-lg shadow-primary-500/25 transition hover:scale-105">
						<?php echo esc_html( $s['cta_text'] ); ?> <i class="<?php echo esc_attr( $s['cta_icon'] ); ?> text-sm"></i>
					</a>
				</div>
			</div>
		</section>
		<?php
	}
}