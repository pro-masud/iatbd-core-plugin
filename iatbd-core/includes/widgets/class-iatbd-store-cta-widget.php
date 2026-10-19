<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Store_CTA_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_store_cta';
	}

	public function get_title() {
		return esc_html__( 'IATBD Store CTA', 'iatbd-core' );
	}
	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		$this->start_controls_section( 'sec_content', [ 'label' => 'Content' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'label_block' => true, 'default' => 'Need help selecting?' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'Talk to an automation specialist.' ] );
		$this->add_control( 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Get help matching components to your machine and application.' ] );
		$this->end_controls_section();

		$this->start_controls_section( 'sec_button', [ 'label' => 'Button' ] );
		$this->add_control( 'btn_icon', [ 'label' => 'Button Icon Class', 'type' => $T, 'label_block' => true, 'default' => 'fas fa-comment-dots', 'placeholder' => 'fas fa-comment-dots' ] );
		$this->add_control( 'btn_text', [ 'label' => 'Button Text', 'type' => $T, 'label_block' => true, 'default' => 'Contact IATBD' ] );
		$this->add_control( 'btn_link', [ 'label' => 'Button Link', 'type' => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '#contact' ] ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s    = $this->get_settings_for_display();
		$link = $s['btn_link'];
		$href = ! empty( $link['url'] ) ? $link['url'] : '#';
		$attr = ' href="' . esc_url( $href ) . '"';
		if ( ! empty( $link['is_external'] ) ) {
			$attr .= ' target="_blank"';
		}
		if ( ! empty( $link['nofollow'] ) ) {
			$attr .= ' rel="nofollow"';
		}
		?>
		<section class="bg-slate-100 dark:bg-slate-900 border-y border-slate-200 dark:border-slate-800 py-10 sm:py-12">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row md:items-center md:justify-between gap-5">
				<div>
					<p class="text-xs font-bold uppercase tracking-[0.16em] text-accent-600 mb-1"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<h2 class="font-display text-xl sm:text-2xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-sm text-slate-600 dark:text-slate-400 mt-1"><?php echo esc_html( $s['desc'] ); ?></p>
				</div>
				<a<?php echo $attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="inline-flex items-center justify-center gap-2 px-5 py-3 rounded-lg bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold transition w-fit"><i class="<?php echo esc_attr( $s['btn_icon'] ); ?>"></i> <?php echo esc_html( $s['btn_text'] ); ?></a>
			</div>
		</section>
		<?php
	}
}