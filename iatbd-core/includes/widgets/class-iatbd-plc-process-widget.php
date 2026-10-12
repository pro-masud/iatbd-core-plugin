<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Process_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_process';
	}

	public function get_title() {
		return 'PLC Process';
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function themes() {
		return [
			'primary' => [
				'num'  => 'from-primary-500 to-primary-700 shadow-primary-500/30',
				'box'  => 'bg-primary-50 dark:bg-primary-900/40',
				'icon' => 'text-primary-600 dark:text-primary-400',
			],
			'orange'  => [
				'num'  => 'from-orange-400 to-orange-600 shadow-orange-500/30',
				'box'  => 'bg-orange-50 dark:bg-orange-900/30',
				'icon' => 'text-orange-500',
			],
			'emerald' => [
				'num'  => 'from-emerald-400 to-emerald-600 shadow-emerald-500/30',
				'box'  => 'bg-emerald-50 dark:bg-emerald-900/30',
				'icon' => 'text-emerald-600 dark:text-emerald-400',
			],
			'purple'  => [
				'num'  => 'from-purple-400 to-purple-600 shadow-purple-500/30',
				'box'  => 'bg-purple-50 dark:bg-purple-900/30',
				'icon' => 'text-purple-600 dark:text-purple-400',
			],
		];
	}

	private function defaults() {
		return [
			1 => [ 'primary', '01', 'fas fa-clipboard-list', 'Requirement Study', 'সাইট ভিজিট, প্রসেস ফ্লো বোঝা, সেন্সর/অ্যাকচুয়েটর তালিকা ও স্পেসিফিকেশন চূড়ান্ত করা।' ],
			2 => [ 'orange', '02', 'fas fa-laptop-code', 'Design & Programming', 'হার্ডওয়্যার বাছাই, কন্ট্রোল লজিক লেখা, সিমুলেশন ও সম্পূর্ণ ডকুমেন্টেশন প্রস্তুত করা।' ],
			3 => [ 'emerald', '03', 'fas fa-plug', 'Install & Commission', 'প্যানেল স্থাপন, কেবলিং, I/O টেস্ট, ড্রাই-রান ও লাইভ কমিশনিং — নিরাপদ হ্যান্ডওভার পর্যন্ত।' ],
			4 => [ 'purple', '04', 'fas fa-handshake', 'Handover & Support', 'অপারেটর ট্রেনিং, প্রোগ্রাম ব্যাকআপ, ওয়ারেন্টি ও চলমান টেকনিক্যাল সাপোর্ট।' ],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Section heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'label_block' => true, 'default' => 'Our Process' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'How We Deliver PLC Projects' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'চারটি স্পষ্ট ধাপে আপনার প্রজেক্ট সম্পন্ন — স্বচ্ছ যোগাযোগ ও মান নিয়ন্ত্রণসহ' ] );
		$this->end_controls_section();

		/* 4 fixed step sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'st' . $i . '_';
			$this->start_controls_section( 'sec_step_' . $i, [ 'label' => 'Step ' . $i ] );
			$this->add_control( $p . 'theme', [
				'label'   => 'Color Theme',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d[0],
				'options' => [ 'primary' => 'Primary', 'orange' => 'Orange', 'emerald' => 'Emerald', 'purple' => 'Purple' ],
			] );
			$this->add_control( $p . 'num', [ 'label' => 'Step Number', 'type' => $T, 'label_block' => true, 'default' => $d[1] ] );
			$this->add_control( $p . 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'label_block' => true, 'default' => $d[2], 'placeholder' => 'fas fa-cog' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'label_block' => true, 'default' => $d[3] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d[4] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$themes = $this->themes();
		?>
		<section id="process" class="py-16 sm:py-20 bg-white dark:bg-slate-950 relative overflow-hidden">
			<div class="absolute top-0 left-1/2 -translate-x-1/2 w-[600px] h-[600px] bg-primary-500/5 rounded-full blur-3xl pointer-events-none"></div>
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
				<div class="text-center max-w-2xl mx-auto mb-14">
					<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>

				<div class="relative">
					<!-- Connector line (desktop) -->
					<div class="hidden lg:block absolute top-16 left-[12%] right-[12%] h-0.5 bg-gradient-to-r from-primary-200 via-primary-400 to-primary-200 dark:from-primary-800 dark:via-primary-600 dark:to-primary-800"></div>

					<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 lg:gap-6">
						<?php
						for ( $i = 1; $i <= 4; $i++ ) :
							$p = 'st' . $i . '_';
							$t = isset( $themes[ $s[ $p . 'theme' ] ] ) ? $themes[ $s[ $p . 'theme' ] ] : $themes['primary'];
							?>
							<div class="relative group">
								<div class="bg-slate-50 dark:bg-slate-800/80 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 hover:border-primary-300 dark:hover:border-primary-600 hover:shadow-lg transition text-center h-full">
									<div class="relative z-10 w-16 h-16 mx-auto -mt-2 mb-5 rounded-2xl bg-gradient-to-br text-white flex items-center justify-center font-display font-bold text-xl shadow-lg group-hover:scale-110 transition <?php echo esc_attr( $t['num'] ); ?>"><?php echo esc_html( $s[ $p . 'num' ] ); ?></div>
									<div class="w-12 h-12 mx-auto mb-4 rounded-xl flex items-center justify-center <?php echo esc_attr( $t['box'] ); ?>">
										<i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?> text-lg <?php echo esc_attr( $t['icon'] ); ?>"></i>
									</div>
									<h3 class="font-display font-semibold text-slate-900 dark:text-white mb-2"><?php echo esc_html( $s[ $p . 'title' ] ); ?></h3>
									<p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
								</div>
							</div>
						<?php endfor; ?>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}