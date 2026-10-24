<?php
/**
 * IATBD Stats Bar / Counter Widget
 * Elementor widget: animated stats counter strip with background pattern.
 *
 * @package IATBD_Core
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Stats_Bar_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_stats_bar';
	}

	public function get_title() {
		return esc_html__( 'IATBD Stats Counter', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-counter';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'counter', 'stats', 'numbers', 'clients', 'projects', 'experience', 'iatbd' ];
	}

	protected function register_controls() {

		/* ---------- Section Settings ---------- */
		$this->start_controls_section( 'section_settings', [
			'label' => esc_html__( 'Section Styling', 'iatbd-core' ),
		] );

		$this->add_control( 'gradient_classes', [
			'label'       => esc_html__( 'Background Gradient (Tailwind)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'from-primary-700 via-primary-600 to-primary-500',
			'description' => esc_html__( 'Tailwind gradient classes (applied with bg-gradient-to-r).', 'iatbd-core' ),
		] );

		$this->add_control( 'show_pattern', [
			'label'        => esc_html__( 'Show Pattern Overlay', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->end_controls_section();

		/* ---------- Stats Repeater ---------- */
		$this->start_controls_section( 'section_items', [
			'label' => esc_html__( 'Counter Items', 'iatbd-core' ),
		] );

		$repeater = new \Elementor\Repeater();

		$repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (Font Awesome)', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'fas fa-users',
			'placeholder' => 'fas fa-users',
		] );

		$repeater->add_control( 'is_counter', [
			'label'        => esc_html__( 'Animated Counter Number?', 'iatbd-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => esc_html__( 'Turn OFF if displaying static text like "24/7".', 'iatbd-core' ),
		] );

		$repeater->add_control( 'target', [
			'label'     => esc_html__( 'Target Number', 'iatbd-core' ),
			'type'      => \Elementor\Controls_Manager::NUMBER,
			'default'   => 100,
			'condition' => [
				'is_counter' => 'yes',
			],
		] );

		$repeater->add_control( 'suffix', [
			'label'       => esc_html__( 'Number Suffix', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '+',
			'placeholder' => '+ or %',
			'condition'   => [
				'is_counter' => 'yes',
			],
		] );

		$repeater->add_control( 'static_text', [
			'label'       => esc_html__( 'Static Value', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => '24/7',
			'condition'   => [
				'is_counter!' => 'yes',
			],
		] );

		$repeater->add_control( 'label', [
			'label'       => esc_html__( 'Label Text', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'     => 'Happy Clients',
		] );

		$this->add_control( 'items', [
			'label'       => esc_html__( 'Items List', 'iatbd-core' ),
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ label }}}',
			'default'     => [
				[
					'icon'       => 'fas fa-users',
					'is_counter' => 'yes',
					'target'     => 100,
					'suffix'     => '+',
					'label'      => 'Happy Clients',
				],
				[
					'icon'       => 'fas fa-award',
					'is_counter' => 'yes',
					'target'     => 10,
					'suffix'     => '+',
					'label'      => 'Years Experience',
				],
				[
					'icon'       => 'fas fa-project-diagram',
					'is_counter' => 'yes',
					'target'     => 250,
					'suffix'     => '+',
					'label'      => 'Projects Done',
				],
				[
					'icon'        => 'fas fa-headset',
					'is_counter'  => '',
					'static_text' => '24/7',
					'label'       => 'Support Available',
				],
			],
		] );

		$this->end_controls_section();
	}

	protected function render() {
		$s            = $this->get_settings_for_display();
		$items        = ! empty( $s['items'] ) ? $s['items'] : [];
		$gradient     = ! empty( $s['gradient_classes'] ) ? $s['gradient_classes'] : 'from-primary-700 via-primary-600 to-primary-500';
		$show_pattern = 'yes' === $s['show_pattern'];
		$wid          = $this->get_id();
		$wrapper_id   = 'stats-bar-' . esc_attr( $wid );
		?>
		<section id="<?php echo esc_attr( $wrapper_id ); ?>" class="relative py-16 bg-gradient-to-r <?php echo esc_attr( $gradient ); ?> overflow-hidden">

			<?php if ( $show_pattern ) : ?>
				<div
					class="absolute inset-0 opacity-10 pointer-events-none"
					style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'0.4\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"
				></div>
			<?php endif; ?>

			<div class="max-w-6xl mx-auto px-4 relative z-10">
				<div class="grid grid-cols-2 lg:grid-cols-4 gap-6 sm:gap-4 text-center">

					<?php
					foreach ( $items as $item ) :
						$icon       = ! empty( $item['icon'] ) ? $item['icon'] : 'fas fa-chart-bar';
						$is_counter = ! empty( $item['is_counter'] ) && 'yes' === $item['is_counter'];
						$target     = isset( $item['target'] ) ? (int) $item['target'] : 0;
						$suffix     = isset( $item['suffix'] ) ? $item['suffix'] : '+';
						$static     = ! empty( $item['static_text'] ) ? $item['static_text'] : '24/7';
						$label      = ! empty( $item['label'] ) ? $item['label'] : '';
						?>
						<div class="group count-box">
							<div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-white/15 mb-4 group-hover:bg-white/25 transition">
								<i class="<?php echo esc_attr( $icon ); ?> text-2xl text-white"></i>
							</div>

							<?php if ( $is_counter ) : ?>
								<p
									class="counter-value text-4xl sm:text-5xl font-display font-bold text-white mb-1"
									data-target="<?php echo esc_attr( $target ); ?>"
									data-suffix="<?php echo esc_attr( $suffix ); ?>"
								>
									0
								</p>
							<?php else : ?>
								<p class="text-4xl sm:text-5xl font-display font-bold text-white mb-1">
									<?php echo esc_html( $static ); ?>
								</p>
							<?php endif; ?>

							<?php if ( ! empty( $label ) ) : ?>
								<p class="text-primary-100 font-medium text-sm sm:text-base">
									<?php echo esc_html( $label ); ?>
								</p>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>

				</div>
			</div>

		</section>

		<script>
		(function() {
			function initStatsCounters_<?php echo esc_attr( $wid ); ?>() {
				var scope = document.getElementById('<?php echo esc_js( $wrapper_id ); ?>');
				if (!scope) return;

				var counters = scope.querySelectorAll('.counter-value[data-target]');
				if (!counters.length) return;

				function runAnimation() {
					counters.forEach(function(el) {
						if (el.getAttribute('data-counted') === 'true') return;
						el.setAttribute('data-counted', 'true');

						var target = parseFloat(el.getAttribute('data-target')) || 0;
						var suffix = el.getAttribute('data-suffix') || '';
						var duration = 1800;
						var startTime = null;

						function step(currentTime) {
							if (!startTime) startTime = currentTime;
							var progress = Math.min((currentTime - startTime) / duration, 1);
							var ease = 1 - Math.pow(1 - progress, 3);
							var currentVal = Math.floor(ease * target);
							el.textContent = currentVal + suffix;

							if (progress < 1) {
								requestAnimationFrame(step);
							} else {
								el.textContent = target + suffix;
							}
						}
						requestAnimationFrame(step);
					});
				}

				if ('IntersectionObserver' in window) {
					var observer = new IntersectionObserver(function(entries) {
						if (entries[0] && entries[0].isIntersecting) {
							runAnimation();
							observer.disconnect();
						}
					}, { threshold: 0.2 });
					observer.observe(scope);
				} else {
					runAnimation();
				}
			}

			if (window.elementorFrontend && window.elementorFrontend.hooks) {
				elementorFrontend.hooks.addAction('frontend/element_ready/iatbd_stats_bar.default', function() {
					initStatsCounters_<?php echo esc_attr( $wid ); ?>();
				});
			}

			if (document.readyState === 'loading') {
				document.addEventListener('DOMContentLoaded', initStatsCounters_<?php echo esc_attr( $wid ); ?>);
			} else {
				initStatsCounters_<?php echo esc_attr( $wid ); ?>();
			}
		})();
		</script>
		<?php
	}
}
