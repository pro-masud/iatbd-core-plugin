<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Services_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_services';
	}

	public function get_title() {
		return 'PLC Services';
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
			'orange'  => 'bg-orange-500',
			'emerald' => 'bg-emerald-500',
			'purple'  => 'bg-purple-500',
			'cyan'    => 'bg-cyan-500',
			'rose'    => 'bg-rose-500',
		];
	}

	private function defaults() {
		return [
			1 => [
				'img'   => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80',
				'color' => 'primary',
				'icon'  => 'fas fa-drafting-compass',
				'title' => 'PLC System Design',
				'desc'  => 'প্রসেস ম্যাপ, I/O তালিকা, কন্ট্রোল আর্কিটেকচার ও প্যানেল লেআউট — আপনার লাইনের জন্য কাস্টম ডিজাইন ও হার্ডওয়্যার সিলেকশন।',
			],
			2 => [
				'img'   => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=600&q=80',
				'color' => 'orange',
				'icon'  => 'fas fa-code',
				'title' => 'PLC Programming',
				'desc'  => 'Ladder, Function Block ও Structured Text-এ পরিষ্কার, ডকুমেন্টেড লজিক। সহজে বদলানো ও ভবিষ্যতে রক্ষণাবেক্ষণযোগ্য কোড।',
			],
			3 => [
				'img'   => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=600&q=80',
				'color' => 'emerald',
				'icon'  => 'fas fa-cogs',
				'title' => 'Installation & Commissioning',
				'desc'  => 'সাইটে ওয়্যারিং, I/O চেক, ড্রাই-রান, লাইভ কমিশনিং ও অপারেটর ট্রেনিং — নিরাপদ স্টার্টআপ নিশ্চিত করে।',
			],
			4 => [
				'img'   => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=600&q=80',
				'color' => 'purple',
				'icon'  => 'fas fa-sync-alt',
				'title' => 'PLC Migration & Upgrade',
				'desc'  => 'পুরনো কন্ট্রোলার থেকে আধুনিক প্ল্যাটফর্মে স্থানান্তর। ডাউনটাইম কমিয়ে প্রোগ্রাম ও নেটওয়ার্ক মাইগ্রেশন।',
			],
			5 => [
				'img'   => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=600&q=80',
				'color' => 'cyan',
				'icon'  => 'fas fa-tools',
				'title' => 'Maintenance & Support',
				'desc'  => 'নিয়মিত ব্যাকআপ, ফার্মওয়্যার আপডেট, প্রিভেন্টিভ চেক ও ২৪/৭ রিমোট বা অন-সাইট টেকনিক্যাল সাপোর্ট।',
			],
			6 => [
				'img'   => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=600&q=80',
				'color' => 'rose',
				'icon'  => 'fas fa-search',
				'title' => 'Troubleshooting & Repair',
				'desc'  => 'ফল্ট ডায়াগনোসিস, মডিউল মেরামত বা রিপ্লেসমেন্ট, নেটওয়ার্ক সমস্যা সমাধান ও রুট কজ অ্যানালিসিস।',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Section heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'default' => 'What We Offer' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'default' => 'Our PLC Services' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'ডিজাইন থেকে দৈনন্দিন সাপোর্ট পর্যন্ত — আপনার ফ্যাক্টরির জন্য সম্পূর্ণ PLC সমাধান' ] );
		$this->end_controls_section();

		/* 6 fixed card sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'c' . $i . '_';
			$this->start_controls_section( 'sec_card_' . $i, [ 'label' => 'Service ' . $i ] );
			$this->add_control( $p . 'img', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => $d['img'] ] ] );
			$this->add_control( $p . 'color', [
				'label'   => 'Icon Box Color',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d['color'],
				'options' => [
					'primary' => 'Primary',
					'orange'  => 'Orange',
					'emerald' => 'Emerald',
					'purple'  => 'Purple',
					'cyan'    => 'Cyan',
					'rose'    => 'Rose',
				],
			] );
			$this->add_control( $p . 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'default' => $d['icon'], 'placeholder' => 'fas fa-cog' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'default' => $d['title'] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['desc'] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$colors = $this->colors();
		?>
		<section id="services-list" class="py-16 sm:py-20 bg-slate-50 dark:bg-slate-900">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center max-w-2xl mx-auto mb-12">
					<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>

				<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
					<?php
					for ( $i = 1; $i <= 6; $i++ ) :
						$p   = 'c' . $i . '_';
						$img = ! empty( $s[ $p . 'img' ]['url'] ) ? $s[ $p . 'img' ]['url'] : '';
						$col = isset( $colors[ $s[ $p . 'color' ] ] ) ? $colors[ $s[ $p . 'color' ] ] : $colors['primary'];
						?>
						<div class="feature-card group bg-white dark:bg-slate-800 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700 shadow-sm">
							<div class="relative h-44 overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s[ $p . 'title' ] ); ?>" class="iatbd-widget-image group-hover:scale-105 transition duration-500" />
								<div class="absolute inset-0 bg-gradient-to-t from-slate-900/70 to-transparent"></div>
								<div class="absolute bottom-3 left-3 w-10 h-10 rounded-lg flex items-center justify-center <?php echo esc_attr( $col ); ?>">
									<i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?> text-white"></i>
								</div>
							</div>
							<div class="p-5">
								<h3 class="font-display text-lg font-semibold text-slate-900 dark:text-white mb-2"><?php echo esc_html( $s[ $p . 'title' ] ); ?></h3>
								<p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
							</div>
						</div>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}