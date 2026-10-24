<?php
/**
 * IATBD Home Contact Widget
 * Elementor widget: contact channels, quick stats, interactive contact form & embed map.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Home_Contact_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_home_contact';
	}

	public function get_title() {
		return esc_html__( 'IATBD Home Contact', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-form-horizontal';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'contact', 'form', 'info', 'map', 'email', 'phone', 'whatsapp', 'address', 'iatbd' ];
	}

	/**
	 * Predefined channel style classes (Tailwind)
	 */
	private function get_channel_styles() {
		return [
			'primary' => [
				'box'    => 'bg-primary-50 dark:bg-primary-900/40 text-primary-600 dark:text-primary-400',
				'border' => 'hover:border-primary-300 dark:hover:border-primary-600',
			],
			'emerald' => [
				'box'    => 'bg-emerald-50 dark:bg-emerald-900/40 text-emerald-600 dark:text-emerald-400',
				'border' => 'hover:border-emerald-300 dark:hover:border-emerald-600',
			],
			'orange'  => [
				'box'    => 'bg-orange-50 dark:bg-orange-900/40 text-orange-500',
				'border' => 'hover:border-orange-300 dark:hover:border-orange-600',
			],
			'purple'  => [
				'box'    => 'bg-purple-50 dark:bg-purple-900/40 text-purple-600 dark:text-purple-400',
				'border' => 'hover:border-purple-300 dark:hover:border-purple-600',
			],
		];
	}

	protected function register_controls() {

		/* ---------- Intro Section ---------- */
		$this->start_controls_section( 'section_intro', [
			'label' => esc_html__( 'Section Header', 'iatbd-core' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => esc_html__( 'Section Anchor ID', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'contact',
			'description' => esc_html__( 'Used for #contact navigation links. Without # sign.', 'iatbd-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Eyebrow', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Get In Touch',
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Contact IATBD',
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'আমাদের সাথে যোগাযোগ করুন — ফ্রি কনসালটেশন, কোয়োটেশন বা সাপোর্টের জন্য',
		] );

		$this->end_controls_section();

		/* ---------- Contact Channels (Left Column) ---------- */
		$this->start_controls_section( 'section_channels', [
			'label' => esc_html__( 'Contact Channels (Left)', 'iatbd-core' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'eyebrow', [
			'label'       => esc_html__( 'Channel Label', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Call Us',
		] );

		$repeater->add_control( 'title', [
			'label'       => esc_html__( 'Title / Contact Value', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '+880 1XXX-XXXXXX',
		] );

		$repeater->add_control( 'sub', [
			'label'       => esc_html__( 'Small Subtitle / Timing', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 2,
			'default'     => 'Sat – Thu, 9 AM – 6 PM',
		] );

		$repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-phone-alt',
		] );

		$repeater->add_control( 'color_style', [
			'label'   => esc_html__( 'Color Theme', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary (Blue)', 'iatbd-core' ),
				'emerald' => esc_html__( 'Emerald (Green)', 'iatbd-core' ),
				'orange'  => esc_html__( 'Orange', 'iatbd-core' ),
				'purple'  => esc_html__( 'Purple', 'iatbd-core' ),
			],
		] );

		$repeater->add_control( 'is_address', [
			'label'        => esc_html__( 'Is Static Address Box? (No link)', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => '',
		] );

		$repeater->add_control( 'link', [
			'label'         => esc_html__( 'Link', 'iatbd-core' ),
			'type'          => \Elementor\Controls_Manager::URL,
			'label_block'   => true,
			'placeholder'   => 'tel:+8801XXXXXXXXX',
			'default'       => [
				'url' => 'tel:+8801XXXXXXXXX',
			],
			'show_external' => true,
			'condition'     => [
				'is_address!' => 'yes',
			],
		] );

		$this->add_control( 'channels', [
			'label'       => esc_html__( 'Channels List', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ eyebrow }}} - {{{ title }}}',
			'default'     => [
				[
					'icon'        => 'fas fa-phone-alt',
					'color_style' => 'primary',
					'eyebrow'     => 'Call Us',
					'title'       => '+880 1XXX-XXXXXX',
					'sub'         => 'Sat – Thu, 9 AM – 6 PM',
					'is_address'  => '',
					'link'        => [ 'url' => 'tel:+8801XXXXXXXXX' ],
				],
				[
					'icon'        => 'fab fa-whatsapp',
					'color_style' => 'emerald',
					'eyebrow'     => 'WhatsApp',
					'title'       => 'Chat Instantly',
					'sub'         => 'Quick reply within minutes',
					'is_address'  => '',
					'link'        => [
						'url'         => 'https://wa.me/8801XXXXXXXXX',
						'is_external' => 'on',
						'nofollow'    => 'on',
					],
				],
				[
					'icon'        => 'fas fa-envelope',
					'color_style' => 'orange',
					'eyebrow'     => 'Email',
					'title'       => 'info@iatbd.com',
					'sub'         => 'We reply within 24 hours',
					'is_address'  => '',
					'link'        => [ 'url' => 'mailto:info@iatbd.com' ],
				],
				[
					'icon'        => 'fas fa-map-marker-alt',
					'color_style' => 'purple',
					'eyebrow'     => 'Office',
					'title'       => 'IATBD Head Office',
					'sub'         => "Your Address, Dhaka,\nBangladesh",
					'is_address'  => 'yes',
				],
			],
		] );

		$this->end_controls_section();

		/* ---------- Quick Stats Badges ---------- */
		$this->start_controls_section( 'section_stats', [
			'label' => esc_html__( 'Quick Stats Badges', 'iatbd-core' ),
		] );

		$this->add_control( 'show_stats', [
			'label'        => esc_html__( 'Show Stats Badges', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'stat1_val', [
			'label'       => esc_html__( 'Stat 1 Value', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '24/7',
			'condition'   => [ 'show_stats' => 'yes' ],
		] );

		$this->add_control( 'stat1_label', [
			'label'       => esc_html__( 'Stat 1 Label', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Support Available',
			'condition'   => [ 'show_stats' => 'yes' ],
		] );

		$this->add_control( 'stat2_val', [
			'label'       => esc_html__( 'Stat 2 Value', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '2hr',
			'condition'   => [ 'show_stats' => 'yes' ],
		] );

		$this->add_control( 'stat2_label', [
			'label'       => esc_html__( 'Stat 2 Label', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Avg. Response',
			'condition'   => [ 'show_stats' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------- Contact Form Card (Right Column) ---------- */
		$this->start_controls_section( 'section_form', [
			'label' => esc_html__( 'Contact Form Card (Right)', 'iatbd-core' ),
		] );

		$this->add_control( 'form_title', [
			'label'       => esc_html__( 'Form Title', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Send us a message',
		] );

		$this->add_control( 'form_subtitle', [
			'label'       => esc_html__( 'Form Subtitle', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'ফর্ম পূরণ করুন — আমরা দ্রুত যোগাযোগ করব',
		] );

		$this->add_control( 'btn_text', [
			'label'       => esc_html__( 'Submit Button Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Send Message',
		] );

		$this->add_control( 'btn_icon', [
			'label'       => esc_html__( 'Submit Button Icon Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-paper-plane',
		] );

		$this->add_control( 'success_msg', [
			'label'       => esc_html__( 'Success Message Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'ধন্যবাদ! আপনার মেসেজ পাঠানো হয়েছে। আমরা শীঘ্রই যোগাযোগ করব।',
		] );

		$this->add_control( 'cf7_shortcode', [
			'label'       => esc_html__( 'Optional Contact Form 7 Shortcode', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '',
			'placeholder' => '[contact-form-7 id="123" title="Contact form"]',
			'description' => esc_html__( 'Leave blank to use the built-in HTML contact form.', 'iatbd-core' ),
		] );

		$this->end_controls_section();

		/* ---------- Location Map ---------- */
		$this->start_controls_section( 'section_map', [
			'label' => esc_html__( 'Location Map (Bottom)', 'iatbd-core' ),
		] );

		$this->add_control( 'show_map', [
			'label'        => esc_html__( 'Show Map Section', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'map_iframe_url', [
			'label'       => esc_html__( 'Map Embed URL (iframe src)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'https://www.openstreetmap.org/export/embed.html?bbox=90.35%2C23.75%2C90.45%2C23.85&layer=mapnik&marker=23.80%2C90.40',
			'condition'   => [ 'show_map' => 'yes' ],
		] );

		$this->add_control( 'map_badge_text', [
			'label'       => esc_html__( 'Map Badge Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'IATBD — Dhaka, Bangladesh',
			'condition'   => [ 'show_map' => 'yes' ],
		] );

		$this->add_control( 'map_badge_icon', [
			'label'       => esc_html__( 'Map Badge Icon Class', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-map-marker-alt',
			'condition'   => [ 'show_map' => 'yes' ],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s          = $this->get_settings_for_display();
		$wid        = $this->get_id();
		$section_id = ! empty( $s['section_id'] ) ? sanitize_html_class( $s['section_id'] ) : 'contact';
		$channels   = ! empty( $s['channels'] ) ? $s['channels'] : [];
		$styles     = $this->get_channel_styles();
		$show_stats = 'yes' === $s['show_stats'];
		$show_map   = 'yes' === $s['show_map'];
		?>
		<section id="<?php echo esc_attr( $section_id ); ?>" class="py-20 bg-slate-50 dark:bg-slate-900">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<!-- Intro Header -->
				<?php if ( ! empty( $s['eyebrow'] ) || ! empty( $s['heading'] ) || ! empty( $s['description'] ) ) : ?>
					<div class="text-center max-w-2xl mx-auto mb-14">
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<span class="text-accent-500 font-semibold text-sm tracking-wider uppercase"><?php echo esc_html( $s['eyebrow'] ); ?></span>
						<?php endif; ?>

						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold mt-2 mb-3 text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>

						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<div class="grid lg:grid-cols-5 gap-8 lg:gap-10">

					<!-- Left: Contact Info Cards & Quick Stats -->
					<div class="lg:col-span-2 space-y-5">
						<?php
						foreach ( $channels as $i => $ch ) :
							$style_key  = ! empty( $ch['color_style'] ) ? $ch['color_style'] : 'primary';
							$st         = isset( $styles[ $style_key ] ) ? $styles[ $style_key ] : $styles['primary'];
							$is_addr    = 'yes' === $ch['is_address'];
							$link_key   = 'channel_link_' . $i;

							if ( ! $is_addr ) {
								$this->add_render_attribute( $link_key, 'class', 'flex items-start gap-4 p-5 bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700 hover:shadow-lg transition group ' . $st['border'] );
								if ( ! empty( $ch['link']['url'] ) ) {
									$this->add_link_attributes( $link_key, $ch['link'] );
								}
								?>
								<a <?php echo $this->get_render_attribute_string( $link_key ); ?>>
									<div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 group-hover:scale-110 transition <?php echo esc_attr( $st['box'] ); ?>">
										<i class="<?php echo esc_attr( $ch['icon'] ); ?> text-lg"></i>
									</div>
									<div>
										<p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1"><?php echo esc_html( $ch['eyebrow'] ); ?></p>
										<p class="font-semibold text-slate-900 dark:text-white text-lg"><?php echo esc_html( $ch['title'] ); ?></p>
										<p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5"><?php echo nl2br( esc_html( $ch['sub'] ) ); ?></p>
									</div>
								</a>
							<?php } else { ?>
								<div class="flex items-start gap-4 p-5 bg-white dark:bg-slate-800/80 rounded-2xl border border-slate-200 dark:border-slate-700">
									<div class="w-12 h-12 rounded-xl flex items-center justify-center shrink-0 <?php echo esc_attr( $st['box'] ); ?>">
										<i class="<?php echo esc_attr( $ch['icon'] ); ?> text-lg"></i>
									</div>
									<div>
										<p class="text-xs font-semibold text-slate-400 uppercase tracking-wider mb-1"><?php echo esc_html( $ch['eyebrow'] ); ?></p>
										<p class="font-semibold text-slate-900 dark:text-white"><?php echo esc_html( $ch['title'] ); ?></p>
										<p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5 leading-relaxed"><?php echo nl2br( esc_html( $ch['sub'] ) ); ?></p>
									</div>
								</div>
							<?php } ?>
						<?php endforeach; ?>

						<!-- Quick Stats Badges -->
						<?php if ( $show_stats ) : ?>
							<div class="grid grid-cols-2 gap-3 pt-2">
								<div class="text-center p-4 bg-primary-50 dark:bg-primary-900/30 rounded-xl border border-primary-100 dark:border-primary-800/50">
									<p class="text-2xl font-display font-bold text-primary-600 dark:text-primary-400"><?php echo esc_html( $s['stat1_val'] ); ?></p>
									<p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><?php echo esc_html( $s['stat1_label'] ); ?></p>
								</div>
								<div class="text-center p-4 bg-accent-500/10 dark:bg-accent-500/10 rounded-xl border border-orange-100 dark:border-orange-900/30">
									<p class="text-2xl font-display font-bold text-accent-500"><?php echo esc_html( $s['stat2_val'] ); ?></p>
									<p class="text-xs text-slate-500 dark:text-slate-400 mt-1"><?php echo esc_html( $s['stat2_label'] ); ?></p>
								</div>
							</div>
						<?php endif; ?>
					</div>

					<!-- Right: Contact Form -->
					<div class="lg:col-span-3">
						<div class="bg-white dark:bg-slate-800/80 rounded-3xl border border-slate-200 dark:border-slate-700 p-6 sm:p-8 shadow-sm">
							<?php if ( ! empty( $s['form_title'] ) ) : ?>
								<h3 class="font-display text-xl font-bold text-slate-900 dark:text-white mb-1"><?php echo esc_html( $s['form_title'] ); ?></h3>
							<?php endif; ?>

							<?php if ( ! empty( $s['form_subtitle'] ) ) : ?>
								<p class="text-sm text-slate-500 dark:text-slate-400 mb-6"><?php echo esc_html( $s['form_subtitle'] ); ?></p>
							<?php endif; ?>

							<?php if ( ! empty( $s['cf7_shortcode'] ) ) : ?>
								<div class="iatbd-cf7-form-wrap">
									<?php echo do_shortcode( sanitize_text_field( $s['cf7_shortcode'] ) ); ?>
								</div>
							<?php else : ?>
								<form id="contact-form-<?php echo esc_attr( $wid ); ?>" class="space-y-5">
									<div class="grid sm:grid-cols-2 gap-5">
										<div>
											<label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><?php esc_html_e( 'Full Name', 'iatbd-core' ); ?> <span class="text-red-500">*</span></label>
											<input
												type="text"
												name="name"
												required
												placeholder="আপনার নাম"
												class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
											/>
										</div>
										<div>
											<label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><?php esc_html_e( 'Phone', 'iatbd-core' ); ?> <span class="text-red-500">*</span></label>
											<input
												type="tel"
												name="phone"
												required
												placeholder="+880 1XXX-XXXXXX"
												class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
											/>
										</div>
									</div>

									<div>
										<label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><?php esc_html_e( 'Email', 'iatbd-core' ); ?></label>
										<input
											type="email"
											name="email"
											placeholder="you@company.com"
											class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
										/>
									</div>

									<div>
										<label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><?php esc_html_e( 'Service Interested In', 'iatbd-core' ); ?></label>
										<select
											name="service"
											class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition"
										>
											<option value=""><?php esc_html_e( 'Select a service...', 'iatbd-core' ); ?></option>
											<option value="plc"><?php esc_html_e( 'PLC Systems', 'iatbd-core' ); ?></option>
											<option value="hmi"><?php esc_html_e( 'HMI Panels', 'iatbd-core' ); ?></option>
											<option value="vfd"><?php esc_html_e( 'VFD Drives', 'iatbd-core' ); ?></option>
											<option value="servo"><?php esc_html_e( 'Servo Drive', 'iatbd-core' ); ?></option>
											<option value="maintenance"><?php esc_html_e( 'Maintenance', 'iatbd-core' ); ?></option>
											<option value="troubleshooting"><?php esc_html_e( 'Troubleshooting', 'iatbd-core' ); ?></option>
											<option value="repairing"><?php esc_html_e( 'Repairing', 'iatbd-core' ); ?></option>
											<option value="other"><?php esc_html_e( 'Other / General Inquiry', 'iatbd-core' ); ?></option>
										</select>
									</div>

									<div>
										<label class="block text-sm font-medium text-slate-700 dark:text-slate-300 mb-1.5"><?php esc_html_e( 'Message', 'iatbd-core' ); ?> <span class="text-red-500">*</span></label>
										<textarea
											name="message"
											required
											rows="4"
											placeholder="আপনার প্রয়োজন বা সমস্যা বিস্তারিত লিখুন..."
											class="w-full px-4 py-3 rounded-xl border border-slate-200 dark:border-slate-600 bg-slate-50 dark:bg-slate-900/50 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500 focus:border-transparent transition resize-none"
										></textarea>
									</div>

									<button
										type="submit"
										class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-3.5 bg-gradient-to-r from-primary-600 to-primary-500 hover:from-primary-500 hover:to-primary-400 text-white font-semibold rounded-full shadow-lg shadow-primary-500/25 transition hover:scale-[1.02]"
									>
										<?php if ( ! empty( $s['btn_icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $s['btn_icon'] ); ?>"></i>
										<?php endif; ?>
										<?php echo esc_html( $s['btn_text'] ); ?>
									</button>
								</form>

								<div
									id="form-success-<?php echo esc_attr( $wid ); ?>"
									class="hidden mt-5 p-4 rounded-xl bg-emerald-50 dark:bg-emerald-900/30 border border-emerald-200 dark:border-emerald-700 text-emerald-700 dark:text-emerald-300 text-sm"
								>
									<i class="fas fa-check-circle mr-2"></i>
									<?php echo esc_html( $s['success_msg'] ); ?>
								</div>

								<script>
								(function() {
									function initContact_<?php echo esc_attr( $wid ); ?>() {
										var form = document.getElementById('contact-form-<?php echo esc_js( $wid ); ?>');
										var success = document.getElementById('form-success-<?php echo esc_js( $wid ); ?>');
										if (!form || !success) return;
										form.addEventListener('submit', function(e) {
											e.preventDefault();
											form.classList.add('hidden');
											success.classList.remove('hidden');
										});
									}
									if (document.readyState === 'loading') {
										document.addEventListener('DOMContentLoaded', initContact_<?php echo esc_attr( $wid ); ?>);
									} else {
										initContact_<?php echo esc_attr( $wid ); ?>();
									}
								})();
								</script>
							<?php endif; ?>
						</div>
					</div>

				</div>

				<!-- Location Map -->
				<?php if ( $show_map && ! empty( $s['map_iframe_url'] ) ) : ?>
					<div class="mt-12 rounded-3xl overflow-hidden border border-slate-200 dark:border-slate-700 shadow-sm">
						<div class="relative h-64 sm:h-80 bg-slate-200 dark:bg-slate-800 flex items-center justify-center">
							<iframe
								class="absolute inset-0 w-full h-full border-0 grayscale-[30%] dark:grayscale-[50%] dark:opacity-80"
								src="<?php echo esc_url( $s['map_iframe_url'] ); ?>"
								loading="lazy"
								title="<?php echo esc_attr( $s['map_badge_text'] ); ?>"
							>
							</iframe>
							<?php if ( ! empty( $s['map_badge_text'] ) ) : ?>
								<div class="absolute bottom-4 left-4 bg-white dark:bg-slate-900/90 backdrop-blur px-4 py-2 rounded-xl shadow text-sm font-medium text-slate-700 dark:text-slate-200 z-10">
									<?php if ( ! empty( $s['map_badge_icon'] ) ) : ?>
										<i class="<?php echo esc_attr( $s['map_badge_icon'] ); ?> text-primary-500 mr-2"></i>
									<?php endif; ?>
									<?php echo esc_html( $s['map_badge_text'] ); ?>
								</div>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}

