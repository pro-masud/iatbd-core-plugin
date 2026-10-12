<?php
/**
 * GC AI Automation widget
 *
 * Original Tailwind markup, no new CSS/JS.
 * Icons use a plain TEXT field (Font Awesome class), not the Elementor icon picker.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_AI_Automation_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_ai_automation';
	}

	public function get_title() {
		return esc_html__( 'GC AI Automation', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-check-circle';
	}

	public function get_categories() {
		return [ 'gc_widgets' ];
	}

	protected function register_controls() {

		// ---------- Content ----------
		$this->start_controls_section(
			'content_section',
			[
				'label' => esc_html__( 'Content', 'softro-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'eyebrow',
			[
				'label'   => esc_html__( 'Eyebrow Text', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Built around your plant',
			]
		);

		$this->add_control(
			'heading',
			[
				'label'   => esc_html__( 'Heading', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'AI that works with your automation',
			]
		);

		$this->add_control(
			'description',
			[
				'label'   => esc_html__( 'Description', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXTAREA,
				'rows'    => 5,
				'default' => 'Your equipment and process come first. We assess the available signals, define a useful pilot and integrate the result with your PLC, HMI, VFD or existing monitoring workflow.',
			]
		);

		$this->end_controls_section();

		// ---------- Checklist ----------
		$this->start_controls_section(
			'list_section',
			[
				'label' => esc_html__( 'Checklist', 'softro-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new \Elementor\Repeater();

		$repeater->add_control(
			'icon_class',
			[
				'label'       => esc_html__( 'Icon Class', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'fas fa-check',
				'placeholder' => 'fas fa-check',
				'description' => esc_html__( 'Font Awesome class, e.g. fas fa-check', 'softro-core' ),
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'icon_color',
			[
				'label'       => esc_html__( 'Icon Color Class', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => 'text-emerald-500',
				'placeholder' => 'text-emerald-500',
				'label_block' => true,
			]
		);

		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'rows'        => 2,
				'default'     => 'List item text',
				'label_block' => true,
			]
		);

		$this->add_control(
			'items',
			[
				'label'       => esc_html__( 'Items', 'softro-core' ),
				'type'        => \Elementor\Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'title_field' => '{{{ text }}}',
				'default'     => [
					[
						'icon_class' => 'fas fa-check',
						'icon_color' => 'text-emerald-500',
						'text'       => 'Start with an engineering review of your machines and data.',
					],
					[
						'icon_class' => 'fas fa-check',
						'icon_color' => 'text-emerald-500',
						'text'       => 'Run a focused pilot against a measurable production goal.',
					],
					[
						'icon_class' => 'fas fa-check',
						'icon_color' => 'text-emerald-500',
						'text'       => 'Keep operators and engineers in control of decisions.',
					],
				],
			]
		);

		$this->end_controls_section();

		// ---------- Image ----------
		$this->start_controls_section(
			'image_section',
			[
				'label' => esc_html__( 'Image', 'softro-core' ),
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'image',
			[
				'label'   => esc_html__( 'Image', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::MEDIA,
				'default' => [
					'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1100&q=85',
				],
			]
		);

		$this->add_control(
			'image_alt',
			[
				'label'   => esc_html__( 'Image Alt Text', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'Engineer monitoring industrial automation equipment',
			]
		);

		$this->add_control(
			'image_caption',
			[
				'label'   => esc_html__( 'Image Caption', 'softro-core' ),
				'type'    => \Elementor\Controls_Manager::TEXT,
				'label_block' => true,
				'default' => 'From sensor signals to clearer production decisions',
			]
		);

		$this->end_controls_section();
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$img_url = ! empty( $s['image']['url'] ) ? $s['image']['url'] : '';
		?>
		<section class="py-20 sm:py-24 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid lg:grid-cols-2 gap-12 items-center">
				<div>
					<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
						<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-2">
							<?php echo esc_html( $s['eyebrow'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $s['heading'] ) ) : ?>
						<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-5">
							<?php echo esc_html( $s['heading'] ); ?>
						</h2>
					<?php endif; ?>

					<?php if ( ! empty( $s['description'] ) ) : ?>
						<p class="text-[17px] leading-relaxed text-slate-600 dark:text-slate-300 mb-7">
							<?php echo esc_html( $s['description'] ); ?>
						</p>
					<?php endif; ?>

					<?php if ( ! empty( $s['items'] ) ) : ?>
						<ul class="space-y-4 text-[17px] text-slate-700 dark:text-slate-300">
							<?php foreach ( $s['items'] as $item ) : ?>
								<li class="flex items-start gap-3">
									<?php if ( ! empty( $item['icon_class'] ) ) : ?>
										<i class="<?php echo esc_attr( trim( $item['icon_class'] . ' ' . $item['icon_color'] ) ); ?> mt-1" aria-hidden="true"></i>
									<?php endif; ?>
									<span><?php echo esc_html( $item['text'] ); ?></span>
								</li>
							<?php endforeach; ?>
						</ul>
					<?php endif; ?>
				</div>

				<div class="relative min-h-80 overflow-hidden rounded-xl bg-slate-900">
					<?php if ( $img_url ) : ?>
						<img
							src="<?php echo esc_url( $img_url ); ?>"
							alt="<?php echo esc_attr( $s['image_alt'] ); ?>"
							class="absolute inset-0 h-full w-full object-cover"
							loading="lazy"
						/>
					<?php endif; ?>
					<div class="absolute inset-0 bg-linear-to-t from-slate-950/80 via-transparent to-transparent"></div>
					<?php if ( ! empty( $s['image_caption'] ) ) : ?>
						<p class="absolute bottom-5 left-5 right-5 text-white font-display text-xl font-semibold">
							<?php echo esc_html( $s['image_caption'] ); ?>
						</p>
					<?php endif; ?>
				</div>
			</div>
		</section>
		<?php
	}
}