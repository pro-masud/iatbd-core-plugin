<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_FAQ_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_faq';
	}

	public function get_title() {
		return 'PLC FAQ';
	}

	public function get_icon() {
		return 'eicon-help-o';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	private function default_items() {
		return [
			[
				'q' => 'কোন কোন ব্র্যান্ডের PLC সাপোর্ট করেন?',
				'a' => 'Siemens (S7-1200/1500), Allen-Bradley (ControlLogix, CompactLogix, MicroLogix), Mitsubishi (FX, Q, iQ-R), Delta, Omron, Schneider, ABB, Fatek সহ প্রায় সব প্রধান ব্র্যান্ড।',
			],
			[
				'q' => 'নতুন প্রজেক্টে কত সময় লাগে?',
				'a' => 'প্রজেক্টের স্কোপ অনুযায়ী ১–৮ সপ্তাহ। ছোট অ্যাপ্লিকেশন দ্রুত, বড় লাইন/মাল্টি-PLC সিস্টেমে সময় বেশি লাগতে পারে। সাইট স্টাডির পর সঠিক টাইমলাইন দিই।',
			],
			[
				'q' => 'রিমোট সাপোর্ট পাওয়া যায় কি?',
				'a' => 'হ্যাঁ। VPN / remote access এর মাধ্যমে অনেক সমস্যা দূর থেকেই সমাধান করা যায়। জরুরি ক্ষেত্রে অন-সাইট ভিজিটও আয়োজন করা হয়।',
			],
			[
				'q' => 'ওয়ারেন্টি ও ডকুমেন্টেশন কি দেন?',
				'a' => 'হ্যাঁ। প্রোগ্রাম ব্যাকআপ, I/O লিস্ট, লজিক ডকুমেন্টেশন ও সার্ভিস ওয়ারেন্টি (প্রজেক্ট অনুযায়ী) প্রদান করা হয়।',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'label_block' => true, 'default' => 'FAQ' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'Frequently Asked Questions' ] );
		$this->end_controls_section();

		/* FAQ items (repeater) */
		$this->start_controls_section( 'sec_faq', [ 'label' => 'FAQ Items' ] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'q', [ 'label' => 'Question', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '' ] );
		$rep->add_control( 'a', [ 'label' => 'Answer', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '' ] );

		$this->add_control( 'faqs', [
			'label'       => 'Questions',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'default'     => $this->default_items(),
			'title_field' => '{{{ q }}}',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();
		?>
		<section class="py-16 sm:py-20 bg-slate-50 dark:bg-slate-900">
			<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center mb-12">
					<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
					<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
				</div>

				<div class="space-y-3" id="faq-list">
					<?php if ( ! empty( $s['faqs'] ) ) : ?>
						<?php foreach ( $s['faqs'] as $f ) : ?>
							<div class="faq-item bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
								<button class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left">
									<span class="font-medium text-slate-900 dark:text-white text-sm sm:text-base"><?php echo esc_html( $f['q'] ); ?></span>
									<i class="fas fa-chevron-down faq-icon text-slate-400 text-sm transition-transform"></i>
								</button>
								<div class="faq-answer px-5">
									<p class="text-sm text-slate-500 dark:text-slate-400 pb-4 leading-relaxed"><?php echo esc_html( $f['a'] ); ?></p>
								</div>
							</div>
						<?php endforeach; ?>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}