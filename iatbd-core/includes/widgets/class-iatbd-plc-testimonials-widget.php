<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Testimonials_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_testimonials';
	}

	public function get_title() {
		return esc_html__( 'IATBD PLC Testimonials', 'iatbd-core' );
	}
	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function colors() {
		return [
			'primary' => [
				'ring' => 'ring-primary-100 dark:ring-primary-900',
				'text' => 'text-primary-600 dark:text-primary-400',
			],
			'accent'  => [
				'ring' => 'ring-accent-100 dark:ring-accent-900',
				'text' => 'text-accent-600 dark:text-accent-400',
			],
			'emerald' => [
				'ring' => 'ring-emerald-100 dark:ring-emerald-900',
				'text' => 'text-emerald-600 dark:text-emerald-400',
			],
			'purple'  => [
				'ring' => 'ring-purple-100 dark:ring-purple-900',
				'text' => 'text-purple-600 dark:text-purple-400',
			],
		];
	}

	private function default_items() {
		return [
			[
				'quote'   => '“Siemens S7-1500 দিয়ে আমাদের প্যাকেজিং লাইন অটোমেশন করেছে IATBD। প্রোগ্রামিং পরিষ্কার, ডকুমেন্টেশন পূর্ণাঙ্গ। কমিশনিং সময়মতো শেষ।”',
				'image'   => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=100&h=100&q=80',
				'name'    => 'Farhan Ahmed',
				'role'    => 'Maintenance Manager',
				'company' => 'Bengal Packaging Ltd.',
				'color'   => 'primary',
			],
			[
				'quote'   => '“পুরনো Allen-Bradley থেকে CompactLogix-এ মাইগ্রেশন একদিনের শিফটেই শেষ। ডাউনটাইম প্রায় শূন্য। টিম খুব প্রফেশনাল।”',
				'image'   => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=100&h=100&q=80',
				'name'    => 'Sabbir Rahman',
				'role'    => 'Plant Engineer',
				'company' => 'Prime Foods Industries',
				'color'   => 'accent',
			],
			[
				'quote'   => '“ট্রাবলশুটিংয়ে রাতের বেলাও সাপোর্ট পেয়েছি। Mitsubishi FX সমস্যা দ্রুত ধরে ফিক্স করে দিয়েছে। আবার কাজ দেবই।”',
				'image'   => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=100&h=100&q=80',
				'name'    => 'Taslima Akter',
				'role'    => 'Operations Lead',
				'company' => 'GreenTech Ceramics',
				'color'   => 'emerald',
			],
			[
				'quote'   => '“নতুন Delta PLC ও HMI ইন্টিগ্রেশন একসাথে করেছে। অপারেটর ট্রেনিংও দিয়েছে। প্রোডাকশন এখন অনেক স্মুথ।”',
				'image'   => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=100&h=100&q=80',
				'name'    => 'Imran Hossain',
				'role'    => 'Factory In-Charge',
				'company' => 'Sunrise Textiles BD',
				'color'   => 'primary',
			],
			[
				'quote'   => '“বার্ষিক মেইনটেন্যান্স কন্ট্রাক্ট নিয়েছি। প্রতি মাসে চেকআপ ও ব্যাকআপ — কোনো বড় ফল্ট হয়নি এক বছরে।”',
				'image'   => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=100&h=100&q=80',
				'name'    => 'Rashed Khan',
				'role'    => 'Technical Director',
				'company' => 'Nova Pharma Plant',
				'color'   => 'purple',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow_icon', [ 'label' => 'Small Title Icon Class', 'type' => $T, 'label_block' => true, 'default' => 'fas fa-quote-left', 'placeholder' => 'fas fa-quote-left' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'label_block' => true, 'default' => 'Testimonials' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'What Our Clients Say' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'যারা IATBD PLC সার্ভিস নিয়েছেন — তাদের অভিজ্ঞতা' ] );
		$this->end_controls_section();

		/* Rating pill */
		$this->start_controls_section( 'sec_rating', [ 'label' => 'Rating Pill' ] );
		$this->add_control( 'rating', [ 'label' => 'Rating', 'type' => $T, 'label_block' => true, 'default' => '4.9/5' ] );
		$this->add_control( 'rating_label', [ 'label' => 'Rating Label', 'type' => $T, 'label_block' => true, 'default' => 'PLC Clients' ] );
		$this->end_controls_section();

		/* Reviews (repeater) */
		$this->start_controls_section( 'sec_reviews', [ 'label' => 'Reviews' ] );

		$rep = new \Elementor\Repeater();
		$rep->add_control( 'quote', [ 'label' => 'Review Text', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '' ] );
		$rep->add_control( 'image', [ 'label' => 'Photo', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => '' ] ] );
		$rep->add_control( 'name', [ 'label' => 'Name', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$rep->add_control( 'role', [ 'label' => 'Role', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$rep->add_control( 'company', [ 'label' => 'Company', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$rep->add_control( 'color', [
			'label'   => 'Accent Color',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [ 'primary' => 'Primary', 'accent' => 'Accent', 'emerald' => 'Emerald', 'purple' => 'Purple' ],
		] );

		$defaults = [];
		foreach ( $this->default_items() as $d ) {
			$defaults[] = [
				'quote'   => $d['quote'],
				'image'   => [ 'url' => $d['image'] ],
				'name'    => $d['name'],
				'role'    => $d['role'],
				'company' => $d['company'],
				'color'   => $d['color'],
			];
		}

		$this->add_control( 'reviews', [
			'label'       => 'Reviews',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $rep->get_controls(),
			'default'     => $defaults,
			'title_field' => '{{{ name }}}',
		] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$colors = $this->colors();
		$stars  = '<i class="fas fa-star text-amber-400 text-sm"></i><i class="fas fa-star text-amber-400 text-sm"></i><i class="fas fa-star text-amber-400 text-sm"></i><i class="fas fa-star text-amber-400 text-sm"></i><i class="fas fa-star text-amber-400 text-sm"></i>';
		?>
		<section class="py-16 sm:py-20 bg-white dark:bg-slate-950 relative overflow-hidden">
			<div class="absolute top-0 right-0 w-80 h-80 bg-primary-500/5 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3 pointer-events-none"></div>
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
				<div class="text-center max-w-2xl mx-auto mb-12">
					<span class="inline-flex items-center gap-1.5 text-accent-500 font-semibold text-sm tracking-wider uppercase">
						<i class="<?php echo esc_attr( $s['eyebrow_icon'] ); ?> text-xs"></i> <?php echo esc_html( $s['eyebrow'] ); ?>
					</span>
					<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['subtitle'] ); ?></p>
					<div class="inline-flex items-center gap-3 mt-5 px-5 py-2.5 bg-slate-50 dark:bg-slate-800 rounded-full border border-slate-200 dark:border-slate-700">
						<div class="flex gap-0.5"><?php echo $stars; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
						<span class="text-sm font-bold text-slate-800 dark:text-white"><?php echo esc_html( $s['rating'] ); ?></span>
						<span class="text-xs text-slate-400 border-l border-slate-200 dark:border-slate-600 pl-3"><?php echo esc_html( $s['rating_label'] ); ?></span>
					</div>
				</div>

				<div class="overflow-hidden testimonial-viewport" id="testimonial-viewport">
					<div class="testimonial-track" id="testimonial-track">
						<?php
						if ( ! empty( $s['reviews'] ) ) :
							foreach ( $s['reviews'] as $r ) :
								$c   = isset( $colors[ $r['color'] ] ) ? $colors[ $r['color'] ] : $colors['primary'];
								$img = ! empty( $r['image']['url'] ) ? $r['image']['url'] : '';
								?>
								<div class="testimonial-card">
									<div class="bg-slate-50 dark:bg-slate-800/80 rounded-2xl p-6 border border-slate-100 dark:border-slate-700 h-full flex flex-col">
										<div class="flex gap-0.5 mb-4"><?php echo $stars; // phpcs:ignore WordPress.Security.EscapeOutput ?></div>
										<p class="text-sm text-slate-600 dark:text-slate-300 leading-relaxed mb-6 flex-1"><?php echo esc_html( $r['quote'] ); ?></p>
										<div class="flex items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
											<div class="w-11 h-11 shrink-0 rounded-full overflow-hidden ring-2 <?php echo esc_attr( $c['ring'] ); ?>">
												<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $r['name'] ); ?>" class="iatbd-widget-image rounded-full" />
											</div>
											<div>
												<p class="font-semibold text-sm text-slate-900 dark:text-white"><?php echo esc_html( $r['name'] ); ?></p>
												<p class="text-xs text-slate-500 dark:text-slate-400"><?php echo esc_html( $r['role'] ); ?></p>
												<p class="text-xs font-medium <?php echo esc_attr( $c['text'] ); ?>"><?php echo esc_html( $r['company'] ); ?></p>
											</div>
										</div>
									</div>
								</div>
							<?php
							endforeach;
						endif;
						?>
					</div>
				</div>

				<!-- Carousel dots -->
				<div class="flex justify-center gap-2 mt-8 testimonial-dots" id="testimonial-dots"></div>
			</div>
		</section>
		<?php
	}
}