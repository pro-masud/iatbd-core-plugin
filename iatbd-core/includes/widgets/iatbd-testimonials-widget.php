<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Utils;
use Elementor\Widget_Base;

class GC_Testimonials_Slider_Widget extends Widget_Base {

	public function get_name() {
		return 'gc_testimonials_slider';
	}

	public function get_title() {
		return esc_html__( 'GC Testimonials Slider', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-testimonial-carousel';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'testimonial', 'review', 'slider', 'client', 'gc' ];
	}

	protected function register_controls() {

		/* ---------- Header ---------- */
		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'softro-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__( 'Small Title', 'softro-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Testimonials',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Heading', 'softro-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'What clients say',
		] );

		$this->add_control( 'show_badge', [
			'label'        => esc_html__( 'Show Rating Badge', 'softro-core' ),
			'type'         => Controls_Manager::SWITCHER,
			'default'      => 'yes',
			'return_value' => 'yes',
			'separator'    => 'before',
		] );

		$this->add_control( 'badge_rating', [
			'label'     => esc_html__( 'Rating Number', 'softro-core' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => '4.9',
			'condition' => [ 'show_badge' => 'yes' ],
		] );

		$this->add_control( 'badge_label', [
			'label'     => esc_html__( 'Rating Label', 'softro-core' ),
			'type'      => Controls_Manager::TEXT,
			'default'   => '· Servo clients',
			'condition' => [ 'show_badge' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------- Testimonials (repeater) ---------- */
		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'Testimonials', 'softro-core' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'image', [
			'label'   => esc_html__( 'Photo', 'softro-core' ),
			'type'    => Controls_Manager::MEDIA,
			'default' => [ 'url' => Utils::get_placeholder_image_src() ],
		] );

		$repeater->add_control( 'name', [
			'label'       => esc_html__( 'Name', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Client Name',
			'label_block' => true,
		] );

		$repeater->add_control( 'role', [
			'label'       => esc_html__( 'Role / Company', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Engineer, Company Ltd.',
			'label_block' => true,
		] );

		$repeater->add_control( 'quote', [
			'label'   => esc_html__( 'Review', 'softro-core' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => 'Write the client review here.',
		] );

		$repeater->add_control( 'rating', [
			'label'   => esc_html__( 'Stars', 'softro-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => '5',
			'options' => [ '1' => '1', '2' => '2', '3' => '3', '4' => '4', '5' => '5' ],
		] );

		$repeater->add_control( 'tone', [
			'label'   => esc_html__( 'Role Color', 'softro-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary', 'softro-core' ),
				'accent'  => esc_html__( 'Accent', 'softro-core' ),
				'emerald' => esc_html__( 'Green', 'softro-core' ),
				'purple'  => esc_html__( 'Purple', 'softro-core' ),
			],
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'softro-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ name }}} — {{{ role }}}',
			'button_text' => esc_html__( 'Add Testimonial', 'softro-core' ),
			'default'     => [
				[
					'name'  => 'Hasan Mahmud',
					'role'  => 'OEM Engineer, PackTech BD',
					'quote' => 'Mitsubishi servo axes on our packing machine were retuned by IATBD. Overshoot gone, cycle time improved.',
					'tone'  => 'primary',
					'image' => [ 'url' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=80&h=80&q=80' ],
				],
				[
					'name'  => 'Imtiaz Chowdhury',
					'role'  => 'Production, LabelPrint Ltd.',
					'quote' => 'Delta servo + PLC gearing set up cleanly. Two axes stay in sync even at higher line speed.',
					'tone'  => 'accent',
					'image' => [ 'url' => 'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?auto=format&fit=crop&w=80&h=80&q=80' ],
				],
				[
					'name'  => 'Farzana Akter',
					'role'  => 'Maintenance, Pharma Forming',
					'quote' => 'Encoder fault overnight — they diagnosed and replaced next morning. Parameter backup saved hours.',
					'tone'  => 'emerald',
					'image' => [ 'url' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?auto=format&fit=crop&w=80&h=80&q=80' ],
				],
				[
					'name'  => 'Karim Reza',
					'role'  => 'Plant Head, MetalStamp BD',
					'quote' => 'Yaskawa retrofit on an old machine. Accuracy better than before and vibration is under control.',
					'tone'  => 'primary',
					'image' => [ 'url' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?auto=format&fit=crop&w=80&h=80&q=80' ],
				],
				[
					'name'  => 'Shuvo Rahman',
					'role'  => 'Automation Lead, AutoLine',
					'quote' => 'Siemens S120 multi-axis with our PLC. Commissioning was structured and documented. Recommend.',
					'tone'  => 'purple',
					'image' => [ 'url' => 'https://images.unsplash.com/photo-1519085360753-af0119f7cbe7?auto=format&fit=crop&w=80&h=80&q=80' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Full literal class strings so Tailwind can detect them.
	 */
	private function tone_class( $tone ) {
		$map = [
			'primary' => 'text-primary-600 dark:text-primary-400',
			'accent'  => 'text-accent-600 dark:text-accent-400',
			'emerald' => 'text-emerald-600 dark:text-emerald-400',
			'purple'  => 'text-purple-600 dark:text-purple-400',
		];
		return isset( $map[ $tone ] ) ? $map[ $tone ] : $map['primary'];
	}

	private function stars_html( $count ) {
		$count = max( 1, min( 5, (int) $count ) );
		return str_repeat( '<i class="fas fa-star"></i>', $count );
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['items'] ) ? $s['items'] : [];
		?>
		<section class="py-20 sm:py-24 bg-slate-50 dark:bg-slate-900/60">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<div class="text-center max-w-xl mx-auto mb-12">
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $s['heading'] ) ) : ?>
						<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-3"><?php echo esc_html( $s['heading'] ); ?></h2>
					<?php endif; ?>

					<?php if ( 'yes' === $s['show_badge'] ) : ?>
						<div class="inline-flex items-center gap-2 mt-2 px-4 py-1.5 rounded-full bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 text-sm shadow-sm">
							<span class="text-amber-400 text-xs"><?php echo $this->stars_html( 5 ); // phpcs:ignore WordPress.Security.EscapeOutput ?></span>
							<span class="font-bold text-slate-800 dark:text-white"><?php echo esc_html( $s['badge_rating'] ); ?></span>
							<?php if ( ! empty( $s['badge_label'] ) ) : ?>
								<span class="text-slate-400 text-xs"><?php echo esc_html( $s['badge_label'] ); ?></span>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="overflow-hidden" id="testimonial-viewport">
					<div class="testimonial-track" id="testimonial-track">
						<?php foreach ( $items as $item ) : ?>
							<div class="testimonial-card">
								<div class="t-card-inner h-full bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-100 dark:border-slate-800 flex flex-col">
									<div class="text-amber-400 text-xs mb-3">
										<?php echo $this->stars_html( $item['rating'] ?: 5 ); // phpcs:ignore WordPress.Security.EscapeOutput ?>
									</div>

									<p class="text-[17px] text-slate-600 dark:text-slate-300 leading-relaxed flex-1 mb-5">“<?php echo esc_html( $item['quote'] ); ?>”</p>

									<div class="flex items-center gap-3 pt-4 border-t border-slate-200 dark:border-slate-700">
										<?php if ( ! empty( $item['image']['url'] ) ) : ?>
											<img src="<?php echo esc_url( $item['image']['url'] ); ?>" class="w-10 h-10 rounded-full object-cover" alt="<?php echo esc_attr( $item['name'] ); ?>">
										<?php endif; ?>
										<div>
											<p class="text-sm font-semibold text-slate-900 dark:text-white"><?php echo esc_html( $item['name'] ); ?></p>
											<p class="text-xs <?php echo esc_attr( $this->tone_class( $item['tone'] ) ); ?>"><?php echo esc_html( $item['role'] ); ?></p>
										</div>
									</div>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				</div>

				<div class="flex justify-center gap-2 mt-8" id="testimonial-dots"></div>

			</div>
		</section>
		<?php
	}
}