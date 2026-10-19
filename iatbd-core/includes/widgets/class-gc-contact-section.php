<?php
/**
 * GC Contact Section
 * Elementor widget: contact channels + tips box + Contact Form 7 shortcode.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Contact_Section_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_contact_section';
	}

	public function get_title() {
		return esc_html__( 'GC Contact Section', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'cf7', 'contact form 7', 'gc' ];
	}

	/**
	 * Full Tailwind class strings per style (kept literal so Tailwind can detect them).
	 */
	private function get_styles() {
		return [
			'primary' => [
				'card'  => 'hover:border-primary-300 dark:hover:border-primary-700',
				'icon'  => 'bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400',
				'arrow' => 'group-hover:text-primary-500',
			],
			'orange'  => [
				'card'  => 'hover:border-primary-300 dark:hover:border-primary-700',
				'icon'  => 'bg-orange-50 dark:bg-orange-500/10 text-orange-500',
				'arrow' => 'group-hover:text-primary-500',
			],
			'emerald' => [
				'card'  => 'hover:border-emerald-300 dark:hover:border-emerald-700',
				'icon'  => 'bg-emerald-50 dark:bg-emerald-500/10 text-emerald-600',
				'arrow' => 'group-hover:text-emerald-500',
			],
		];
	}

	protected function register_controls() {

		/* ---------- Intro ---------- */
		$this->start_controls_section( 'section_intro', [
			'label' => esc_html__( 'Intro', 'softro-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__( 'Eyebrow', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'GET IN TOUCH',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Heading', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'How can we help?',
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'For service, repair, or product enquiries, choose the channel that works best for you.',
		] );

		$this->end_controls_section();

		/* ---------- Contact channels ---------- */
		$this->start_controls_section( 'section_channels', [
			'label' => esc_html__( 'Contact Channels', 'softro-core' ),
		] );

		$channels = new \Elementor\Repeater();

		$channels->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-phone-alt',
			'placeholder' => 'fas fa-phone-alt',
		] );

		$channels->add_control( 'label', [
			'label'   => esc_html__( 'Label', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Call us',
		] );

		$channels->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '+880 1XXX-XXXXXX',
		] );

		$channels->add_control( 'text', [
			'label'   => esc_html__( 'Small Text', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Speak with our service team',
		] );

		$channels->add_control( 'link', [
			'label'         => esc_html__( 'Link', 'softro-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'placeholder'   => 'tel:+8801XXXXXXXXX',
			'default'       => [ 'url' => 'tel:+8801XXXXXXXXX' ],
			'show_external' => true,
		] );

		$channels->add_control( 'style', [
			'label'   => esc_html__( 'Color Style', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary', 'softro-core' ),
				'orange'  => esc_html__( 'Orange', 'softro-core' ),
				'emerald' => esc_html__( 'Emerald (WhatsApp)', 'softro-core' ),
			],
		] );

		$this->add_control( 'channels', [
			'label'       => esc_html__( 'Channels', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $channels->get_controls(),
			'title_field' => '{{{ label }}} - {{{ title }}}',
			'default'     => [
				[
					'icon'  => 'fas fa-phone-alt',
					'label' => 'Call us',
					'title' => '+880 1XXX-XXXXXX',
					'text'  => 'Speak with our service team',
					'link'  => [ 'url' => 'tel:+8801XXXXXXXXX' ],
					'style' => 'primary',
				],
				[
					'icon'  => 'fas fa-envelope',
					'label' => 'Email us',
					'title' => 'info@iatbd.com',
					'text'  => 'Send specifications or questions',
					'link'  => [ 'url' => 'mailto:info@iatbd.com' ],
					'style' => 'orange',
				],
				[
					'icon'  => 'fab fa-whatsapp',
					'label' => 'WhatsApp',
					'title' => 'Message our team',
					'text'  => 'Quick questions and service requests',
					'link'  => [
						'url'         => 'https://wa.me/8801XXXXXXXXX',
						'is_external' => 'on',
						'nofollow'    => 'on',
					],
					'style' => 'emerald',
				],
			],
		] );

		$this->end_controls_section();

		/* ---------- Tips box ---------- */
		$this->start_controls_section( 'section_tips', [
			'label' => esc_html__( 'Helpful Details Box', 'softro-core' ),
		] );

		$this->add_control( 'tips_show', [
			'label'        => esc_html__( 'Show Box', 'softro-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'tips_icon', [
			'label'   => esc_html__( 'Icon Class (Font Awesome)', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'fas fa-gears',
		] );

		$this->add_control( 'tips_title', [
			'label'   => esc_html__( 'Title', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Helpful details to include',
		] );

		$tips = new \Elementor\Repeater();

		$tips->add_control( 'text', [
			'label'   => esc_html__( 'Text', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => '',
		] );

		$this->add_control( 'tips', [
			'label'       => esc_html__( 'Items', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $tips->get_controls(),
			'title_field' => '{{{ text }}}',
			'default'     => [
				[ 'text' => 'Machine type and service needed' ],
				[ 'text' => 'Equipment brand and model number' ],
				[ 'text' => 'Alarm code or a brief description of the issue' ],
			],
		] );

		$this->end_controls_section();

		/* ---------- Form card ---------- */
		$this->start_controls_section( 'section_form', [
			'label' => esc_html__( 'Form Card', 'softro-core' ),
		] );

		$this->add_control( 'form_eyebrow', [
			'label'   => esc_html__( 'Eyebrow', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'SEND A MESSAGE',
		] );

		$this->add_control( 'form_heading', [
			'label'   => esc_html__( 'Heading', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Tell us about your project',
		] );

		$this->add_control( 'form_note', [
			'label'       => esc_html__( 'Note under heading', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => 'Fields marked <span class="text-accent-500">*</span> are required.',
			'description' => esc_html__( 'Leave empty to hide. Basic HTML allowed.', 'softro-core' ),
		] );

		$this->add_control( 'form_icon', [
			'label'       => esc_html__( 'Header Icon Class (Font Awesome)', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-paper-plane',
			'description' => esc_html__( 'Leave empty to hide the icon badge.', 'softro-core' ),
		] );

		$this->add_control( 'form_anchor', [
			'label'       => esc_html__( 'Anchor ID', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'message',
			'description' => esc_html__( 'Used for #message links. No # sign.', 'softro-core' ),
		] );

		$this->add_control( 'cf7_shortcode', [
			'label'       => esc_html__( 'Contact Form 7 Shortcode', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => '[contact-form-7 id="123" title="Contact form"]',
			'placeholder' => '[contact-form-7 id="123" title="Contact form"]',
			'separator'   => 'before',
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$styles = $this->get_styles();

		$anchor = ! empty( $s['form_anchor'] ) ? sanitize_html_class( $s['form_anchor'] ) : '';
		?>
		<section class="py-12 sm:py-16 lg:py-20">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid lg:grid-cols-[0.82fr_1.18fr] gap-8 lg:gap-12 items-start">

					<aside class="space-y-7">
						<div>
							<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
								<p class="text-sm font-semibold text-primary-600 dark:text-primary-400"><?php echo esc_html( $s['eyebrow'] ); ?></p>
							<?php endif; ?>
							<?php if ( ! empty( $s['heading'] ) ) : ?>
								<h2 class="mt-2 font-display text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
							<?php endif; ?>
							<?php if ( ! empty( $s['description'] ) ) : ?>
								<p class="mt-3 leading-relaxed text-slate-600 dark:text-slate-400"><?php echo esc_html( $s['description'] ); ?></p>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $s['channels'] ) ) : ?>
							<div class="space-y-3">
								<?php
								foreach ( $s['channels'] as $i => $item ) :
									$style = isset( $styles[ $item['style'] ] ) ? $styles[ $item['style'] ] : $styles['primary'];
									$key   = 'channel_link_' . $i;

									$this->add_render_attribute( $key, 'class', 'group flex gap-4 rounded-2xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-4 sm:p-5 shadow-sm transition ' . $style['card'] );
									if ( ! empty( $item['link']['url'] ) ) {
										$this->add_link_attributes( $key, $item['link'] );
									}
									?>
									<a <?php echo $this->get_render_attribute_string( $key ); ?>>
										<span class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl <?php echo esc_attr( $style['icon'] ); ?>">
											<?php if ( ! empty( $item['icon'] ) ) : ?>
												<i class="<?php echo esc_attr( $item['icon'] ); ?>"></i>
											<?php endif; ?>
										</span>
										<span>
											<?php if ( ! empty( $item['label'] ) ) : ?>
												<span class="block text-xs font-semibold uppercase tracking-wider text-slate-500 dark:text-slate-400"><?php echo esc_html( $item['label'] ); ?></span>
											<?php endif; ?>
											<?php if ( ! empty( $item['title'] ) ) : ?>
												<span class="mt-1 block font-semibold text-slate-900 dark:text-white"><?php echo esc_html( $item['title'] ); ?></span>
											<?php endif; ?>
											<?php if ( ! empty( $item['text'] ) ) : ?>
												<span class="mt-1 block text-sm text-slate-500 dark:text-slate-400"><?php echo esc_html( $item['text'] ); ?></span>
											<?php endif; ?>
										</span>
										<i class="fas fa-arrow-up-right-from-square ml-auto mt-1 text-xs text-slate-400 <?php echo esc_attr( $style['arrow'] ); ?>"></i>
									</a>
								<?php endforeach; ?>
							</div>
						<?php endif; ?>

						<?php if ( 'yes' === $s['tips_show'] ) : ?>
							<div class="rounded-2xl border border-primary-100 dark:border-primary-900/70 bg-primary-50/70 dark:bg-primary-950/40 p-5 sm:p-6">
								<div class="flex items-center gap-3">
									<?php if ( ! empty( $s['tips_icon'] ) ) : ?>
										<span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white dark:bg-slate-900 text-primary-600 dark:text-primary-400 shadow-sm"><i class="<?php echo esc_attr( $s['tips_icon'] ); ?>"></i></span>
									<?php endif; ?>
									<?php if ( ! empty( $s['tips_title'] ) ) : ?>
										<h3 class="font-display font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['tips_title'] ); ?></h3>
									<?php endif; ?>
								</div>
								<?php if ( ! empty( $s['tips'] ) ) : ?>
									<ul class="mt-4 space-y-2.5 text-sm leading-relaxed text-slate-600 dark:text-slate-300">
										<?php foreach ( $s['tips'] as $tip ) : ?>
											<?php if ( empty( $tip['text'] ) ) { continue; } ?>
											<li class="flex gap-2.5"><i class="fas fa-check mt-1 text-primary-500"></i><span><?php echo esc_html( $tip['text'] ); ?></span></li>
										<?php endforeach; ?>
									</ul>
								<?php endif; ?>
							</div>
						<?php endif; ?>
					</aside>

					<div<?php echo $anchor ? ' id="' . esc_attr( $anchor ) . '"' : ''; ?> class="scroll-mt-24 rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-5 sm:p-8 lg:p-10 shadow-xl shadow-slate-200/50 dark:shadow-black/20">
						<div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-7">
							<div>
								<?php if ( ! empty( $s['form_eyebrow'] ) ) : ?>
									<p class="text-sm font-semibold text-primary-600 dark:text-primary-400"><?php echo esc_html( $s['form_eyebrow'] ); ?></p>
								<?php endif; ?>
								<?php if ( ! empty( $s['form_heading'] ) ) : ?>
									<h2 class="mt-2 font-display text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['form_heading'] ); ?></h2>
								<?php endif; ?>
								<?php if ( ! empty( $s['form_note'] ) ) : ?>
									<p class="mt-2 text-sm leading-relaxed text-slate-500 dark:text-slate-400"><?php echo wp_kses_post( $s['form_note'] ); ?></p>
								<?php endif; ?>
							</div>
							<?php if ( ! empty( $s['form_icon'] ) ) : ?>
								<span class="hidden sm:flex h-12 w-12 items-center justify-center rounded-2xl bg-gradient-to-br from-primary-500 to-accent-500 text-white shadow-lg shadow-primary-500/20"><i class="<?php echo esc_attr( $s['form_icon'] ); ?>"></i></span>
							<?php endif; ?>
						</div>

						<?php if ( ! empty( $s['cf7_shortcode'] ) ) : ?>
							<?php echo do_shortcode( shortcode_unautop( trim( $s['cf7_shortcode'] ) ) ); ?>
						<?php elseif ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) : ?>
							<p class="text-sm text-slate-500 dark:text-slate-400"><?php esc_html_e( 'Add your Contact Form 7 shortcode in the widget settings.', 'softro-core' ); ?></p>
						<?php endif; ?>
					</div>

				</div>
			</div>
		</section>
		<?php
	}
}