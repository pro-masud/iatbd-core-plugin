<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_PLC_Overview_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_plc_overview';
	}

	public function get_title() {
		return 'PLC Overview';
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Content */
		$this->start_controls_section( 'sec_content', [ 'label' => 'Content' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'default' => 'Overview' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Complete PLC Solutions for Your Industry' ] );
		$this->add_control( 'p1_before', [ 'label' => 'Paragraph 1 (before bold)', 'type' => $T, 'default' => 'IATBD ইন্ডাস্ট্রিয়াল অটোমেশনের হার্ট —' ] );
		$this->add_control( 'p1_strong', [ 'label' => 'Paragraph 1 (bold text)', 'type' => $T, 'default' => 'Programmable Logic Controller (PLC)' ] );
		$this->add_control( 'p1_after', [ 'label' => 'Paragraph 1 (after bold)', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => '— এর সম্পূর্ণ সার্ভিস প্রদান করে। নতুন সিস্টেম ডিজাইন থেকে পুরনো সিস্টেম আপগ্রেড, প্রোগ্রামিং, ইনস্টলেশন, কমিশনিং ও রক্ষণাবেক্ষণ — সব এক জায়গায়।' ] );
		$this->add_control( 'p2', [ 'label' => 'Paragraph 2', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'আমাদের এক্সপার্ট ইঞ্জিনিয়ার টিম Siemens, Rockwell (Allen-Bradley), Mitsubishi, Delta, Omron, Schneider সহ সব প্রধান ব্র্যান্ডের PLC-এ দক্ষ।' ] );
		$this->end_controls_section();

		/* 4 fixed list sections */
		$items = [
			1 => 'New PLC system design & panel building',
			2 => 'Ladder, FBD, ST programming & documentation',
			3 => 'Migration from old PLC to modern platforms',
			4 => 'SCADA / HMI integration & networking',
		];
		foreach ( $items as $i => $text ) {
			$this->start_controls_section( 'sec_item_' . $i, [ 'label' => 'List Item ' . $i ] );
			$this->add_control( 'item' . $i, [ 'label' => 'Text', 'type' => $T, 'default' => $text ] );
			$this->end_controls_section();
		}

		/* Image + badge */
		$this->start_controls_section( 'sec_image', [ 'label' => 'Image & Badge' ] );
		$this->add_control( 'image', [
			'label'   => 'Image',
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=900&q=80' ],
		] );
		$this->add_control( 'image_alt', [ 'label' => 'Image Alt', 'type' => $T, 'default' => 'PLC Control Panel' ] );
		$this->add_control( 'badge_icon', [ 'label' => 'Badge Icon Class', 'type' => $T, 'default' => 'fas fa-certificate', 'placeholder' => 'fas fa-cog', 'separator' => 'before' ] );
		$this->add_control( 'badge_title', [ 'label' => 'Badge Title', 'type' => $T, 'default' => 'Certified Engineers' ] );
		$this->add_control( 'badge_sub', [ 'label' => 'Badge Subtitle', 'type' => $T, 'default' => 'Brand-trained technicians' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s   = $this->get_settings_for_display();
		$img = ! empty( $s['image']['url'] ) ? $s['image']['url'] : '';
		?>
		<section class="py-16 sm:py-20 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid lg:grid-cols-2 gap-12 items-center">
					<div>
						<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
						<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-5 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
						<p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
							<?php echo esc_html( $s['p1_before'] ); ?>
							<strong class="text-slate-800 dark:text-slate-200"><?php echo esc_html( $s['p1_strong'] ); ?></strong>
							<?php echo esc_html( $s['p1_after'] ); ?>
						</p>
						<p class="text-slate-600 dark:text-slate-400 leading-relaxed mb-6"><?php echo esc_html( $s['p2'] ); ?></p>
						<ul class="space-y-3">
							<?php for ( $i = 1; $i <= 4; $i++ ) : ?>
								<li class="flex items-start gap-3">
									<span class="w-6 h-6 rounded-full bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center shrink-0 mt-0.5"><i class="fas fa-check text-primary-600 dark:text-primary-400 text-xs"></i></span>
									<span class="text-slate-700 dark:text-slate-300 text-sm"><?php echo esc_html( $s[ 'item' . $i ] ); ?></span>
								</li>
							<?php endfor; ?>
						</ul>
					</div>
					<div class="relative">
						<div class="rounded-2xl overflow-hidden shadow-xl border border-slate-200 dark:border-slate-700">
							<div class="h-72 sm:h-80 overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s['image_alt'] ); ?>" class="iatbd-widget-image" />
							</div>
						</div>
						<div class="absolute -bottom-4 -left-4 bg-white dark:bg-slate-800 rounded-xl shadow-lg border border-slate-100 dark:border-slate-700 px-4 py-3 flex items-center gap-3">
							<div class="w-10 h-10 rounded-lg bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center">
								<i class="<?php echo esc_attr( $s['badge_icon'] ); ?> text-primary-600 dark:text-primary-400"></i>
							</div>
							<div>
								<p class="text-sm font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['badge_title'] ); ?></p>
								<p class="text-xs text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['badge_sub'] ); ?></p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}