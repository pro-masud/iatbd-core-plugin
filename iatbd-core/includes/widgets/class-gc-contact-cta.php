<?php
/**
 * GC Contact CTA – Elementor widget (repeater based)
 *
 * Original HTML markup + Tailwind classes + existing theme classes
 * (btn-cta, btn-cta-light, btn-cta-outline) are used as-is.
 * No CSS / JS is added by this widget — it only makes the content dynamic.
 *
 * Category : gc_widgets
 * Name     : gc_contact_cta
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Widget_Base;

class GC_Contact_CTA_Widget extends Widget_Base {

	public function get_name() {
		return 'gc_contact_cta';
	}

	public function get_title() {
		return esc_html__( 'GC Contact CTA', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-call-to-action';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'cta', 'contact', 'call', 'whatsapp', 'button', 'gc' ];
	}

	protected function register_controls() {

		/* ---------- Content ---------- */
		$this->start_controls_section( 'section_content', [
			'label' => esc_html__( 'Content', 'softro-core' ),
		] );

		$this->add_control( 'section_id', [
			'label'       => esc_html__( 'Section ID (anchor)', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'contact',
			'description' => esc_html__( 'Used for #contact style links. Leave empty for none.', 'softro-core' ),
		] );

		$this->add_control( 'heading', [
			'label'       => esc_html__( 'Heading', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Need precise motion control?',
			'label_block' => true,
		] );

		$this->add_control( 'description', [
			'label'   => esc_html__( 'Description', 'softro-core' ),
			'type'    => Controls_Manager::TEXTAREA,
			'rows'    => 3,
			'default' => 'Tell us about your axes — sizing, tuning or repair. We respond fast.',
		] );

		$this->end_controls_section();

		/* ---------- Buttons (repeater) ---------- */
		$this->start_controls_section( 'section_buttons', [
			'label' => esc_html__( 'Buttons', 'softro-core' ),
		] );

		$repeater = new Repeater();

		$repeater->add_control( 'text', [
			'label'       => esc_html__( 'Button Text', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => 'Button',
			'label_block' => true,
		] );

		$repeater->add_control( 'icon', [
			'label'       => esc_html__( 'Icon Class (optional)', 'softro-core' ),
			'description' => esc_html__( 'Font Awesome class, e.g. fas fa-phone-alt or fab fa-whatsapp', 'softro-core' ),
			'type'        => Controls_Manager::TEXT,
			'default'     => '',
			'label_block' => true,
		] );

		$repeater->add_control( 'link', [
			'label'         => esc_html__( 'Link', 'softro-core' ),
			'type'          => Controls_Manager::URL,
			'placeholder'   => 'tel:+8801XXXXXXXXX',
			'default'       => [ 'url' => '#' ],
			'show_external' => true,
		] );

		$repeater->add_control( 'style', [
			'label'   => esc_html__( 'Style', 'softro-core' ),
			'type'    => Controls_Manager::SELECT,
			'default' => 'light',
			'options' => [
				'light'   => esc_html__( 'White (Call)', 'softro-core' ),
				'success' => esc_html__( 'Green (WhatsApp)', 'softro-core' ),
				'outline' => esc_html__( 'Outline (Message)', 'softro-core' ),
			],
		] );

		$this->add_control( 'buttons', [
			'label'       => esc_html__( 'Buttons', 'softro-core' ),
			'type'        => Controls_Manager::REPEATER,
			'fields'      => $repeater->get_controls(),
			'title_field' => '{{{ text }}}',
			'button_text' => esc_html__( 'Add Button', 'softro-core' ),
			'default'     => [
				[
					'text'  => 'Call Now',
					'icon'  => 'fas fa-phone-alt',
					'link'  => [ 'url' => 'tel:+8801XXXXXXXXX' ],
					'style' => 'light',
				],
				[
					'text'  => 'WhatsApp',
					'icon'  => 'fab fa-whatsapp',
					'link'  => [ 'url' => 'https://wa.me/8801XXXXXXXXX', 'is_external' => 'on' ],
					'style' => 'success',
				],
				[
					'text'  => 'Message',
					'icon'  => '',
					'link'  => [ 'url' => '#contact' ],
					'style' => 'outline',
				],
			],
		] );

		$this->end_controls_section();
	}

	/**
	 * Full literal class strings so Tailwind can detect them.
	 */
	private function button_class( $style ) {
		$map = [
			'light'   => 'inline-flex items-center gap-2 px-6 py-3 bg-white text-primary-700 font-bold rounded-full shadow-lg btn-cta btn-cta-light',
			'success' => 'inline-flex items-center gap-2 px-6 py-3 bg-emerald-500 hover:bg-emerald-400 text-white font-bold rounded-full btn-cta',
			'outline' => 'inline-flex items-center gap-2 px-6 py-3 border border-white/30 text-white font-semibold rounded-full btn-cta-outline',
		];
		return isset( $map[ $style ] ) ? $map[ $style ] : $map['light'];
	}

	/**
	 * Normalise to a Font Awesome class string (adds "fas" if only fa-xxx / xxx typed).
	 */
	private function icon_class( $icon ) {
		if ( is_array( $icon ) ) {
			$icon = isset( $icon['value'] ) && is_string( $icon['value'] ) ? $icon['value'] : '';
		}
		$icon = trim( (string) $icon );

		if ( '' === $icon ) {
			return '';
		}
		if ( ! preg_match( '/(^|\s)(fas|far|fab|fal|fad|fa-solid|fa-regular|fa-brands|fa)(\s|$)/', $icon ) ) {
			if ( 0 !== strpos( $icon, 'fa-' ) ) {
				$icon = 'fa-' . $icon;
			}
			$icon = 'fas ' . $icon;
		}
		return $icon;
	}

	protected function render() {
		$s       = $this->get_settings_for_display();
		$buttons = ! empty( $s['buttons'] ) ? $s['buttons'] : [];
		$id_attr = ! empty( $s['section_id'] ) ? ' id="' . esc_attr( sanitize_html_class( $s['section_id'] ) ) . '"' : '';
		?>
		<section<?php echo $id_attr; // phpcs:ignore WordPress.Security.EscapeOutput ?> class="relative py-20 sm:py-24 overflow-hidden">
			<div class="absolute inset-0 bg-gradient-to-br from-slate-900 via-primary-800 to-primary-600"></div>
			<div
				class="absolute inset-0 opacity-20"
				style="background-image: radial-gradient(circle at 20% 50%, #ff7a1a 0%, transparent 40%), radial-gradient(circle at 80% 20%, #338bff 0%, transparent 35%);"
			></div>

			<div class="relative z-10 max-w-3xl mx-auto px-4 text-center">
				<?php if ( ! empty( $s['heading'] ) ) : ?>
					<h2 class="font-display text-3xl sm:text-4xl font-bold text-white mb-4"><?php echo esc_html( $s['heading'] ); ?></h2>
				<?php endif; ?>

				<?php if ( ! empty( $s['description'] ) ) : ?>
					<p class="text-[17px] text-slate-300 mb-8 max-w-md mx-auto"><?php echo esc_html( $s['description'] ); ?></p>
				<?php endif; ?>

				<div class="flex flex-wrap justify-center gap-3">
					<?php foreach ( $buttons as $i => $btn ) :
						$key = 'cta_btn_' . $i;
						$this->add_render_attribute( $key, 'class', $this->button_class( $btn['style'] ) );

						if ( ! empty( $btn['link']['url'] ) ) {
							$this->add_link_attributes( $key, $btn['link'] );
						} else {
							$this->add_render_attribute( $key, 'href', '#' );
						}

						$icon = $this->icon_class( isset( $btn['icon'] ) ? $btn['icon'] : '' );
						if ( $icon && 'light' === $btn['style'] ) {
							$icon .= ' text-sm';
						}
						?>
						<a <?php $this->print_render_attribute_string( $key ); ?>>
							<?php if ( $icon ) : ?><i class="<?php echo esc_attr( $icon ); ?>"></i> <?php endif; ?><?php echo esc_html( $btn['text'] ); ?>
						</a>
					<?php endforeach; ?>
				</div>
			</div>
		</section>
		<?php
	}
}