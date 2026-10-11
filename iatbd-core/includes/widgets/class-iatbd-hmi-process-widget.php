<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_HMI_Process_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_hmi_process';
	}

	public function get_title() {
		return 'HMI Process';
	}

	public function get_icon() {
		return 'eicon-flow';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function themes() {
		return [
			'primary' => [
				'num' => 'text-primary-100 dark:text-primary-900/50',
				'box' => 'bg-primary-500',
			],
			'orange'  => [
				'num' => 'text-orange-100 dark:text-orange-900/30',
				'box' => 'bg-orange-500',
			],
			'emerald' => [
				'num' => 'text-emerald-100 dark:text-emerald-900/30',
				'box' => 'bg-emerald-500',
			],
			'violet'  => [
				'num' => 'text-violet-100 dark:text-violet-900/30',
				'box' => 'bg-violet-500',
			],
		];
	}

	private function defaults() {
		return [
			1 => [ 'primary', '01', 'fas fa-search', 'Discover', 'Site study, operator needs, screen list and PLC tag requirements.' ],
			2 => [ 'orange', '02', 'fas fa-pen-ruler', 'Design', 'UI, alarms, recipes, trends and security levels reviewed with you.' ],
			3 => [ 'emerald', '03', 'fas fa-plug', 'Integrate', 'Panel setup, PLC link, live testing and floor-level tuning.' ],
			4 => [ 'violet', '04', 'fas fa-graduation-cap', 'Train & Support', 'Operator training, project backup, documentation and ongoing support.' ],
		];
	}

	protected function register_controls() {
		$T = \Elementor\Controls_Manager::TEXT;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'default' => 'Process' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'default' => 'How we deliver' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => 'Four clear steps from brief to operator training.' ] );
		$this->end_controls_section();

		/* 4 fixed step sections */
		foreach ( $this->defaults() as $i => $d ) {
			$p = 'st' . $i . '_';
			$this->start_controls_section( 'sec_step_' . $i, [ 'label' => 'Step ' . $i ] );
			$this->add_control( $p . 'theme', [
				'label'   => 'Color Theme',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => $d[0],
				'options' => [ 'primary' => 'Primary', 'orange' => 'Orange', 'emerald' => 'Emerald', 'violet' => 'Violet' ],
			] );
			$this->add_control( $p . 'num', [ 'label' => 'Step Number', 'type' => $T, 'default' => $d[1] ] );
			$this->add_control( $p . 'icon', [ 'label' => 'Icon Class', 'type' => $T, 'default' => $d[2], 'placeholder' => 'fas fa-cog' ] );
			$this->add_control( $p . 'title', [ 'label' => 'Title', 'type' => $T, 'default' => $d[3] ] );
			$this->add_control( $p . 'desc', [ 'label' => 'Description', 'type' => \Elementor\Controls_Manager::TEXTAREA, 'default' => $d[4] ] );
			$this->end_controls_section();
		}
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$themes = $this->themes();
		?>
		<section class="py-20 sm:py-24 bg-[#f7f9fc] dark:bg-slate-950">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="text-center max-w-xl mx-auto mb-14">
					<p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3"><?php echo esc_html( $s['eyebrow'] ); ?></p>
					<h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-3"><?php echo esc_html( $s['heading'] ); ?></h2>
					<p class="text-slate-500 dark:text-slate-400 text-sm"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>
				<div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
					<?php
					for ( $i = 1; $i <= 4; $i++ ) :
						$p = 'st' . $i . '_';
						$t = isset( $themes[ $s[ $p . 'theme' ] ] ) ? $themes[ $s[ $p . 'theme' ] ] : $themes['primary'];
						?>
						<article class="step-card relative bg-white dark:bg-slate-900 rounded-2xl p-6 border border-slate-200/80 dark:border-slate-800">
							<span class="font-display text-4xl font-bold absolute top-4 right-5 <?php echo esc_attr( $t['num'] ); ?>"><?php echo esc_html( $s[ $p . 'num' ] ); ?></span><span class="w-10 h-10 rounded-xl text-white flex items-center justify-center mb-4 <?php echo esc_attr( $t['box'] ); ?>"><i class="<?php echo esc_attr( $s[ $p . 'icon' ] ); ?>"></i></span>
							<h3 class="font-semibold text-slate-900 dark:text-white mb-2"><?php echo esc_html( $s[ $p . 'title' ] ); ?></h3>
							<p class="text-sm text-slate-500 dark:text-slate-400 leading-relaxed"><?php echo esc_html( $s[ $p . 'desc' ] ); ?></p>
						</article>
					<?php endfor; ?>
				</div>
			</div>
		</section>
		<?php
	}
}