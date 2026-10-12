<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_HMI_Overview_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hmi_overview';
	}

	public function get_title() {
		return 'HMI Overview';
	}

	public function get_icon() {
		return 'eicon-image-box';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	protected function register_controls() {
		$T  = \Elementor\Controls_Manager::TEXT;
		$TA = \Elementor\Controls_Manager::TEXTAREA;

		/* Content */
		$this->start_controls_section( 'sec_content', [ 'label' => 'Content' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'default' => 'Overview' ] );
		$this->add_control( 'h1', [ 'label' => 'Heading (line 1)', 'type' => $T, 'default' => 'HMI that makes' ] );
		$this->add_control( 'h2', [ 'label' => 'Heading (line 2)', 'type' => $T, 'default' => 'complex simple' ] );
		$this->add_control( 'desc', [ 'label' => 'Description', 'type' => $TA, 'default' => 'Human Machine Interface is where your operators meet the machine. We design screens that reduce mistakes, speed up decisions and stay reliable under real factory pressure.' ] );
		$this->end_controls_section();

		/* 3 fixed list items */
		$items = [
			1 => 'Operator-first screen architecture',
			2 => 'Alarm, recipe and trend systems',
			3 => 'Multi-brand PLC and SCADA linking',
		];
		foreach ( $items as $i => $text ) {
			$this->start_controls_section( 'sec_item_' . $i, [ 'label' => 'List Item ' . $i ] );
			$this->add_control( 'item' . $i, [ 'label' => 'Text', 'type' => $T, 'default' => $text ] );
			$this->end_controls_section();
		}

		/* Link */
		$this->start_controls_section( 'sec_link', [ 'label' => 'Link' ] );
		$this->add_control( 'link_text', [ 'label' => 'Link Text', 'type' => $T, 'default' => 'Start a project' ] );
		$this->add_control( 'link_icon', [ 'label' => 'Link Icon Class', 'type' => $T, 'default' => 'fas fa-arrow-right', 'placeholder' => 'fas fa-arrow-right' ] );
		$this->add_control( 'link_url', [ 'label' => 'Link', 'type' => \Elementor\Controls_Manager::URL, 'default' => [ 'url' => '#contact' ] ] );
		$this->end_controls_section();

		/* Image + floating card */
		$this->start_controls_section( 'sec_image', [ 'label' => 'Image & Card' ] );
		$this->add_control( 'image', [
			'label'   => 'Image',
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1000&q=80' ],
		] );
		$this->add_control( 'image_alt', [ 'label' => 'Image Alt', 'type' => $T, 'default' => 'Engineer working with industrial control equipment' ] );
		$this->add_control( 'card_icon', [ 'label' => 'Card Icon Class', 'type' => $T, 'default' => 'fas fa-desktop', 'placeholder' => 'fas fa-cog', 'separator' => 'before' ] );
		$this->add_control( 'card_title', [ 'label' => 'Card Title', 'type' => $T, 'default' => 'Operator-first' ] );
		$this->add_control( 'card_sub', [ 'label' => 'Card Subtitle', 'type' => $T, 'default' => 'Fewer errors. Faster action.' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$img  = ! empty( $s['image']['url'] ) ? $s['image']['url'] : '';
		$link = $s['link_url'];
		$href = ! empty( $link['url'] ) ? $link['url'] : '#';
		$attr = ' href="' . esc_url( $href ) . '"';
		if ( ! empty( $link['is_external'] ) ) {
			$attr .= ' target="_blank"';
		}
		if ( ! empty( $link['nofollow'] ) ) {
			$attr .= ' rel="nofollow"';
		}
		?>
		<section class="py-20 sm:py-24 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid lg:grid-cols-12 gap-12 lg:gap-16 items-center">
					<div class="lg:col-span-5">
						<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
						<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white leading-tight mb-5"><?php echo esc_html( $s['h1'] ); ?><br /><?php echo esc_html( $s['h2'] ); ?></h2>
						<p class="text-slate-500 dark:text-slate-400 leading-relaxed mb-6"><?php echo esc_html( $s['desc'] ); ?></p>
						<ul class="space-y-3 mb-8">
							<?php for ( $i = 1; $i <= 3; $i++ ) : ?>
								<li class="flex items-center gap-3 text-sm text-slate-700 dark:text-slate-300">
									<span class="w-5 h-5 rounded-full bg-primary-100 dark:bg-primary-900/40 flex items-center justify-center shrink-0"><i class="fas fa-check text-[10px] text-primary-600"></i></span><?php echo esc_html( $s[ 'item' . $i ] ); ?>
								</li>
							<?php endfor; ?>
						</ul>
						<a<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="inline-flex items-center gap-2 text-sm font-semibold text-primary-600 dark:text-primary-400 hover:gap-3 transition-all"><?php echo esc_html( $s['link_text'] ); ?> <i class="<?php echo esc_attr( $s['link_icon'] ); ?> text-xs"></i></a>
					</div>
					<div class="lg:col-span-7 relative pb-6">
						<div class="rounded-3xl overflow-hidden border border-slate-100 dark:border-slate-800">
							<div class="h-72 sm:h-[380px] overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s['image_alt'] ); ?>" class="iatbd-widget-image" />
							</div>
						</div>
						<div class="absolute bottom-0 left-6 right-6 sm:left-auto sm:right-8 sm:w-64 bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-700 shadow-xl p-4 flex items-center gap-3">
							<span class="w-11 h-11 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shrink-0"><i class="<?php echo esc_attr( $s['card_icon'] ); ?> text-white"></i></span><span><span class="block text-sm font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['card_title'] ); ?></span><span class="block text-xs text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['card_sub'] ); ?></span></span>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}
}