<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_HMI_Services_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hmi_services';
	}

	public function get_title() {
		return 'HMI Services';
	}

	public function get_icon() {
		return 'eicon-gallery-grid';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function colors() {
		return [
			'orange'  => 'bg-orange-500',
			'primary' => 'bg-primary-500',
			'emerald' => 'bg-emerald-500',
			'violet'  => 'bg-violet-500',
			'cyan'    => 'bg-cyan-500',
			'rose'    => 'bg-rose-500',
		];
	}

	private function defaults() {
		return [
			1 => [
				'img'   => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=600&q=80',
				'color' => 'orange',
				'icon'  => 'fas fa-paint-brush',
				'title' => 'Screen Design',
				'desc'  => 'Process-aware layouts, alarm pages and navigation operators can learn quickly.',
			],
			2 => [
				'img'   => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=600&q=80',
				'color' => 'primary',
				'icon'  => 'fas fa-network-wired',
				'title' => 'PLC & Device Linking',
				'desc'  => 'Tag mapping, protocol setup and stable communication across major platforms.',
			],
			3 => [
				'img'   => 'https://images.unsplash.com/photo-1565043589221-1a6fd9ae45c7?auto=format&fit=crop&w=600&q=80',
				'color' => 'emerald',
				'icon'  => 'fas fa-cogs',
				'title' => 'Install & Commission',
				'desc'  => 'Panel setup, live testing, recipes and operator training through handover.',
			],
			4 => [
				'img'   => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=600&q=80',
				'color' => 'violet',
				'icon'  => 'fas fa-chart-area',
				'title' => 'SCADA & Logging',
				'desc'  => 'Trends, history, reports and remote production visibility.',
			],
			5 => [
				'img'   => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=600&q=80',
				'color' => 'cyan',
				'icon'  => 'fas fa-sync-alt',
				'title' => 'Upgrade & Migration',
				'desc'  => 'Move legacy panels to modern touch systems with planned downtime and project recovery.',
			],
			6 => [
				'img'   => 'https://images.unsplash.com/photo-1504328345606-18bbc8c9d7d1?auto=format&fit=crop&w=600&q=80',
				'color' => 'rose',
				'icon'  => 'fas fa-tools',
				'title' => 'Maintenance & Repair',
				'desc'  => 'Backups, firmware, touch calibration, display faults and remote or on-site support.',
			],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'default' => 'Services' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'default' => 'Everything your HMI needs' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'From first screen to ongoing support, one partner for the full lifecycle.' ] );
		$this->end_controls_section();

		/* 6 fixed card sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'c' . $i . '_';
			$this->start_controls_section( 'sec_card_' . $i, [ 'label' => 'Service ' . $i ] );
			$this->add_control( $p . 'img', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => $d['img'] ] ] );
			$this->add_control( $p . 'alt', [ 'label' => 'Image Alt (empty = decorative)', 'type' => $T, 'default' => '' ] );
			$this->add_control( $p . 'color', [
				'label'   => 'Icon Box Color',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d['color'],
				'options' => [
					'orange'  => 'Orange',
					'primary' => 'Primary',
					'emerald' => 'Emerald',
					'violet'  => 'Violet',
					'cyan'    => 'Cyan',
					'rose'    => 'Rose',
				],
			] );
			$this->add_control( $p . 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'default' => $d['icon'], 'placeholder' => 'fas fa-cog' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'default' => $d['title'] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d['desc'] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$colors = $this->colors();
		?>
		<section id="services" class="py-20 sm:py-24 bg-[#f7f9fc] dark:bg-slate-900/50">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center max-w-xl mx-auto mb-14">
					<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-3"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400 text-sm sm:text-base"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>
				<div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6">
					<?php
					for ( $i = 1; $i <= 6; $i++ ) :
						$p   = 'c' . $i . '_';
						$img = ! empty( $s[ $p . 'img' ]['url'] ) ? $s[ $p . 'img' ]['url'] : '';
						$col = isset( $colors[ $s[ $p . 'color' ] ] ) ? $colors[ $s[ $p . 'color' ] ] : $colors['orange'];
						?>
						<article class="svc-card bg-white dark:bg-slate-800/80 rounded-2xl overflow-hidden border border-slate-100 dark:border-slate-700/80">
							<div class="relative h-44 overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $s[ $p . 'alt' ] ); ?>" class="w-full h-full object-cover" />
								<div class="absolute inset-0 bg-gradient-to-t from-slate-900/50 to-transparent"></div>
								<span class="absolute bottom-3 left-3 w-9 h-9 rounded-lg flex items-center justify-center text-white <?php echo esc_attr( $col ); ?>"><i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?>"></i></span>
							</div>
							<div class="p-5">
								<h3 class="font-display font-semibold text-slate-900 dark:text-white mb-1.5"><?php echo esc_html( $s[ $p . 'title' ] ); ?></h3>
								<p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
							</div>
						</article>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}