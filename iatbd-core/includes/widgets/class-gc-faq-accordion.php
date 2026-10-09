<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class GC_FAQ_Accordion_Widget extends Widget_Base {

	public function get_name() {
		return 'gc_faq_accordion';
	}

	public function get_title() {
		return esc_html__( 'GC FAQ Accordion', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-accordion';
	}

	public function get_categories() {
		return [ 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'faq', 'accordion', 'question', 'answer', 'gc' ];
	}

	protected function register_controls() {

		/* ---------- Header ---------- */
		$this->start_controls_section( 'section_header', [
			'label' => esc_html__( 'Header', 'softro-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__( 'Small Title', 'softro-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'FAQ',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Heading', 'softro-core' ),
			'type'    => Controls_Manager::TEXT,
			'default' => 'Common questions',
		] );

		$this->end_controls_section();

		/* ---------- FAQ items (repeater) ---------- */
		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'FAQ Items', 'softro-core' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'question', [
			'label'       => esc_html__( 'Question', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Your question here?',
			'label_block' => true,
		] );

		$repeater->add_control( 'answer', [
			'label'   => esc_html__( 'Answer', 'softro-core' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => 'Write the answer here.',
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items', 'softro-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ question }}}',
			'button_text' => esc_html__( 'Add Question', 'softro-core' ),
			'default'     => [
				[
					'question' => 'Which servo brands do you support?',
					'answer'   => 'Siemens, Mitsubishi, Delta, Yaskawa, Panasonic, Omron, Schneider, Allen-Bradley and other major servo platforms.',
				],
				[
					'question' => 'Can you retrofit servo on an old machine?',
					'answer'   => 'Yes. We size for existing mechanics, adapt mounting where needed, and commission with minimal process change.',
				],
				[
					'question' => 'Do you handle multi-axis synchronization?',
					'answer'   => 'Yes — electronic gearing, camming and coordinated motion with PLC or dedicated motion controllers.',
				],
				[
					'question' => 'Is parameter backup included?',
					'answer'   => 'Always after commissioning or repair — so recovery is fast if a drive is replaced later.',
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$items = ! empty( $s['items'] ) ? $s['items'] : [];
		?>
		<section class="py-20 sm:py-24 bg-white dark:bg-slate-950">
			<div class="max-w-2xl mx-auto px-4 sm:px-6">

				<div class="text-center mb-12">
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<?php endif; ?>

					<?php if ( ! empty( $s['heading'] ) ) : ?>
						<h2 class="font-display text-3xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					<?php endif; ?>
				</div>

				<div class="space-y-3">
					<?php foreach ( $items as $item ) : ?>
						<div class="faq-item bg-white dark:bg-slate-800 rounded-xl border border-slate-200 dark:border-slate-700 overflow-hidden">
							<button class="faq-btn w-full flex items-center justify-between px-5 py-4 text-left" type="button">
								<span class="font-medium text-[17px] text-slate-900 dark:text-white"><?php echo esc_html( $item['question'] ); ?></span>
								<i class="fas fa-chevron-down faq-icon text-slate-400 text-xs transition-transform"></i>
							</button>
							<div class="faq-answer px-5">
								<p class="text-[17px] text-slate-600 dark:text-slate-300 pb-4"><?php echo esc_html( $item['answer'] ); ?></p>
							</div>
						</div>
					<?php endforeach; ?>
				</div>

			</div>
		</section>
		<?php
	}
}