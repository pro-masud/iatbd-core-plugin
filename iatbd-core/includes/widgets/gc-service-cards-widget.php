<?php
/**
 * GC Service Cards
 * Elementor widget: section heading + repeater of service cards (image, icon, text, checklist, link).
 * Uses the theme's existing .svc-card styles.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Service_Cards_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_service_cards';
	}

	public function get_title() {
		return esc_html__( 'IATBD Service Cards', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons', 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'service', 'cards', 'maintenance', 'checklist', 'gc' ];
	}

	/**
	 * Literal Tailwind classes per icon color (so Tailwind can detect them).
	 */
	private function get_icon_styles() {
		return [
			'primary' => [
				'box'  => 'bg-primary-100 dark:bg-primary-900/30',
				'icon' => 'text-primary-600 dark:text-primary-400',
			],
			'orange'  => [
				'box'  => 'bg-orange-100 dark:bg-orange-900/30',
				'icon' => 'text-orange-600 dark:text-orange-400',
			],
			'emerald' => [
				'box'  => 'bg-emerald-100 dark:bg-emerald-900/30',
				'icon' => 'text-emerald-600 dark:text-emerald-400',
			],
			'rose'    => [
				'box'  => 'bg-rose-100 dark:bg-rose-900/30',
				'icon' => 'text-rose-600 dark:text-rose-400',
			],
		];
	}

	private function get_column_classes() {
		return [
			'1' => '',
			'2' => 'md:grid-cols-2',
			'3' => 'md:grid-cols-2 lg:grid-cols-3',
		];
	}

	protected function register_controls() {

		/* ---------- Heading ---------- */
		$this->start_controls_section( 'section_heading', [
			'label' => esc_html__( 'Section Heading', 'iatbd-core' ),
		] );

		$this->add_control( 'anchor_id', [
			'label'       => esc_html__( 'Anchor ID', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'services',
			'description' => esc_html__( 'Used for #services links. No # sign. Leave empty for none.', 'iatbd-core' ),
		] );

		$this->add_control( 'eyebrow', [
			'label'   => esc_html__( 'Eyebrow', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Maintenance Services',
		] );

		$this->add_control( 'heading', [
			'label'   => esc_html__( 'Heading', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Preventive Maintenance for Critical Assets',
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Structured checks and care for the equipment that drives your production — so small issues never become line-stopping failures.',
		] );

		$this->add_control( 'columns', [
			'label'   => esc_html__( 'Columns (desktop)', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => '2',
			'options' => [
				'1' => '1',
				'2' => '2',
				'3' => '3',
			],
		] );

		$this->end_controls_section();

		/* ---------- Cards ---------- */
		$this->start_controls_section( 'section_cards', [
			'label' => esc_html__( 'Service Cards', 'iatbd-core' ),
		] );

		$r = new \Elementor\Repeater();

		$r->add_control( 'image', [
			'label'   => esc_html__( 'Image', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::MEDIA,
			'default' => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80' ],
		] );

		$r->add_control( 'icon', [
			'label'     => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'fas fa-tachometer-alt',
			'separator' => 'before',
		] );

		$r->add_control( 'icon_style', [
			'label'   => esc_html__( 'Icon Color', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary' => esc_html__( 'Primary', 'iatbd-core' ),
				'orange'  => esc_html__( 'Orange', 'iatbd-core' ),
				'emerald' => esc_html__( 'Emerald', 'iatbd-core' ),
				'rose'    => esc_html__( 'Rose', 'iatbd-core' ),
			],
		] );

		$r->add_control( 'title', [
			'label'   => esc_html__( 'Title', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'VFD Maintenance',
		] );

		$r->add_control( 'text', [
			'label'   => esc_html__( 'Description', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Thermal inspection, capacitor health, cooling system, terminals and parameter backup for reliable long-term drive performance.',
		] );

		$r->add_control( 'checklist', [
			'label'       => esc_html__( 'Checklist', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'rows'        => 5,
			'default'     => "Cleaning & dust removal\nFan & heat-sink inspection\nTerminal torque & connection check\nParameter backup & health report",
			'description' => esc_html__( 'One item per line.', 'iatbd-core' ),
		] );

		$r->add_control( 'link_text', [
			'label'     => esc_html__( 'Link Text', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Learn more about VFD service',
			'separator' => 'before',
		] );

		$r->add_control( 'link', [
			'label'   => esc_html__( 'Link', 'iatbd-core' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '/vfd-service/' ],
		] );

		$this->add_control( 'cards', [
			'label'       => esc_html__( 'Cards', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'title_field' => '{{{ title }}}',
			'default'     => [
				[
					'image'      => [ 'url' => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=800&q=80' ],
					'icon'       => 'fas fa-tachometer-alt',
					'icon_style' => 'primary',
					'title'      => 'VFD Maintenance',
					'text'       => 'Thermal inspection, capacitor health, cooling system, terminals and parameter backup for reliable long-term drive performance.',
					'checklist'  => "Cleaning & dust removal\nFan & heat-sink inspection\nTerminal torque & connection check\nParameter backup & health report",
					'link_text'  => 'Learn more about VFD service',
					'link'       => [ 'url' => '/vfd-service/' ],
				],
				[
					'image'      => [ 'url' => 'https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=800&q=80' ],
					'icon'       => 'fas fa-microchip',
					'icon_style' => 'orange',
					'title'      => 'PLC Maintenance',
					'text'       => 'Program backup, battery status, I/O health, communication status and environmental checks to keep control systems stable.',
					'checklist'  => "Program & project backup\nBattery & memory check\nI/O module status review\nNetwork & rack inspection",
					'link_text'  => 'Learn more about PLC service',
					'link'       => [ 'url' => '/plc-service/' ],
				],
				[
					'image'      => [ 'url' => 'https://images.unsplash.com/photo-1555949963-aa79dcee981c?auto=format&fit=crop&w=800&q=80' ],
					'icon'       => 'fas fa-desktop',
					'icon_style' => 'emerald',
					'title'      => 'HMI Maintenance',
					'text'       => 'Screen cleaning, touch response, project backup, communication link and backlight health for reliable operator interfaces.',
					'checklist'  => "Display & touch inspection\nProject backup & version check\nCommunication status test\nEnclosure & cable review",
					'link_text'  => 'Learn more about HMI service',
					'link'       => [ 'url' => '/hmi-service/' ],
				],
				[
					'image'      => [ 'url' => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=800&q=80' ],
					'icon'       => 'fas fa-cog',
					'icon_style' => 'rose',
					'title'      => 'Servo Drive Maintenance',
					'text'       => 'Cooling, power connections, encoder feedback path and parameter verification to maintain positioning accuracy and uptime.',
					'checklist'  => "Cooling & thermal check\nPower & signal cable inspection\nEncoder / feedback health\nParameter & alarm history review",
					'link_text'  => 'Learn more about Servo service',
					'link'       => [ 'url' => '/#services' ],
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s     = $this->get_settings_for_display();
		$cards = ! empty( $s['cards'] ) ? $s['cards'] : [];

		$icon_styles = $this->get_icon_styles();
		$col_classes = $this->get_column_classes();
		$col_cls     = isset( $col_classes[ $s['columns'] ] ) ? $col_classes[ $s['columns'] ] : $col_classes['2'];

		$anchor = ! empty( $s['anchor_id'] ) ? sanitize_html_class( $s['anchor_id'] ) : '';
		?>
		<section<?php echo $anchor ? ' id="' . esc_attr( $anchor ) . '"' : ''; ?> class="py-20 sm:py-28 bg-white dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

				<?php if ( ! empty( $s['eyebrow'] ) || ! empty( $s['heading'] ) || ! empty( $s['description'] ) ) : ?>
					<div class="text-center mb-14">
						<?php if ( ! empty( $s['eyebrow'] ) ) : ?>
							<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['heading'] ) ) : ?>
							<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4"><?php echo esc_html( $s['heading'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $s['description'] ) ) : ?>
							<p class="text-slate-600 dark:text-slate-400 max-w-2xl mx-auto text-lg"><?php echo esc_html( $s['description'] ); ?></p>
						<?php endif; ?>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $cards ) ) : ?>
					<div class="grid <?php echo esc_attr( $col_cls ); ?> gap-6">
						<?php
						foreach ( $cards as $i => $card ) :
							$st    = isset( $icon_styles[ $card['icon_style'] ] ) ? $icon_styles[ $card['icon_style'] ] : $icon_styles['primary'];
							$img   = ! empty( $card['image']['url'] ) ? $card['image']['url'] : '';
							$items = array_filter( array_map( 'trim', preg_split( '/\r\n|\r|\n/', (string) $card['checklist'] ) ) );

							$key = 'card_link_' . $i;
							$this->add_render_attribute( $key, 'class', 'inline-flex items-center gap-2 text-sm font-semibold text-primary-600 dark:text-primary-400 hover:gap-3 transition-all' );
							if ( ! empty( $card['link']['url'] ) ) {
								$this->add_link_attributes( $key, $card['link'] );
							}
							?>
							<div class="svc-card bg-white dark:bg-slate-900 rounded-2xl border border-slate-100 dark:border-slate-800">
								<?php if ( $img ) : ?>
									<div class="h-48 overflow-hidden rounded-t-2xl">
										<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $card['title'] ); ?>" class="w-full h-full object-cover" loading="lazy" />
									</div>
								<?php endif; ?>

								<div class="p-6">
									<div class="flex items-center gap-3 mb-3">
										<?php if ( ! empty( $card['icon'] ) ) : ?>
											<div class="w-10 h-10 rounded-xl flex items-center justify-center <?php echo esc_attr( $st['box'] ); ?>">
												<i class="<?php echo esc_attr( $card['icon'] . ' ' . $st['icon'] ); ?>"></i>
											</div>
										<?php endif; ?>
										<?php if ( ! empty( $card['title'] ) ) : ?>
											<h3 class="font-display text-xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $card['title'] ); ?></h3>
										<?php endif; ?>
									</div>

									<?php if ( ! empty( $card['text'] ) ) : ?>
										<p class="text-slate-600 dark:text-slate-400 mb-4 text-sm leading-relaxed"><?php echo esc_html( $card['text'] ); ?></p>
									<?php endif; ?>

									<?php if ( ! empty( $items ) ) : ?>
										<ul class="space-y-2 text-sm text-slate-600 dark:text-slate-400 mb-5">
											<?php foreach ( $items as $li ) : ?>
												<li class="flex items-center gap-2"><i class="fas fa-check text-emerald-500 text-xs"></i> <?php echo esc_html( $li ); ?></li>
											<?php endforeach; ?>
										</ul>
									<?php endif; ?>

									<?php if ( ! empty( $card['link_text'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( $key ); ?>>
											<?php echo esc_html( $card['link_text'] ); ?> <i class="fas fa-arrow-right text-xs"></i>
										</a>
									<?php endif; ?>
								</div>
							</div>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>

			</div>
		</section>
		<?php
	}
}