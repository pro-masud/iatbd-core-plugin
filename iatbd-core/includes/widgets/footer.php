<?php
/**
 * IATBD Footer (fixed fields, no repeater, no Elementor icon picker)
 *
 * Markup/classes are the same as the original static HTML.
 * Only the content is made editable from Elementor.
 */
class IATBD_Footer extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_footer';
	}

	public function get_title() {
		return esc_html__( 'IATBD Footer', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-footer';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'footer', 'iatbd' ];
	}

	/** Default content (same as the original HTML). */
	private function get_defaults() {
		return [
			'contact'  => [
				[ 'fas fa-phone-alt', '+880 1XXX-XXXXXX' ],
				[ 'fas fa-envelope',  'info@iatbd.com' ],
			],
		];
	}

	/** All WordPress menus for the select controls. */
	private function get_menu_options() {
		$options = [ '' => esc_html__( '— Select Menu —', 'elementor-test' ) ];
		$menus   = wp_get_nav_menus();
		if ( ! empty( $menus ) && ! is_wp_error( $menus ) ) {
			foreach ( $menus as $menu ) {
				$options[ $menu->term_id ] = $menu->name;
			}
		}
		return $options;
	}

	/** Registers a "title + WordPress menu" section. */
	private function register_links_section( $prefix, $label, $default_title ) {

		$this->start_controls_section( "{$prefix}_section", [
			'label' => $label,
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( "{$prefix}_title", [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => $default_title,
			'label_block' => true,
		] );

		$this->add_control( "{$prefix}_menu", [
			'label'       => esc_html__( 'Select Menu', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'options'     => $this->get_menu_options(),
			'default'     => '',
			'label_block' => true,
			'description' => sprintf(
				/* translators: %s: link to Menus screen */
				esc_html__( 'Create or edit menus from %s.', 'elementor-test' ),
				'<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance → Menus', 'elementor-test' ) . '</a>'
			),
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		$d = $this->get_defaults();

		// ---- Brand ----
		$this->start_controls_section( 'brand_section', [
			'label' => esc_html__( 'Brand', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'brand_icon', [
			'label'       => esc_html__( 'Logo Icon (Font Awesome class)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-microchip',
			'placeholder' => 'fas fa-microchip',
			'label_block' => true,
		] );

		$this->add_control( 'brand_name', [
			'label'       => esc_html__( 'Brand Name', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'IATBD',
			'label_block' => true,
		] );

		$this->add_control( 'brand_desc', [
			'label'   => esc_html__( 'Description', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'rows'    => 4,
			'default' => 'Industrial automation — PLC, HMI, VFD, Servo and professional service.',
		] );

		$this->end_controls_section();

		// ---- Services & Support ----
		$this->register_links_section( 'svc', esc_html__( 'Column 2 (Services)', 'elementor-test' ), 'Services' );
		$this->register_links_section( 'sup', esc_html__( 'Column 3 (Support)', 'elementor-test' ), 'Support' );

		// ---- Contact ----
		$this->start_controls_section( 'contact_section', [
			'label' => esc_html__( 'Column 4 (Contact)', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'con_title', [
			'label'       => esc_html__( 'Title', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Contact',
			'label_block' => true,
		] );

		foreach ( $d['contact'] as $i => $item ) {
			$n = $i + 1;

			$this->add_control( "con{$n}_icon", [
				'label'       => sprintf( esc_html__( 'Item %d Icon (Font Awesome class)', 'elementor-test' ), $n ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $item[0],
				'label_block' => true,
				'separator'   => 'before',
			] );

			$this->add_control( "con{$n}_text", [
				'label'       => sprintf( esc_html__( 'Item %d Text', 'elementor-test' ), $n ),
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => $item[1],
				'label_block' => true,
			] );
		}

		$this->end_controls_section();

		// ---- Bottom bar ----
		$this->start_controls_section( 'bottom_section', [
			'label' => esc_html__( 'Bottom Bar', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'copyright', [
			'label'       => esc_html__( 'Copyright Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '© 2026 IATBD. All rights reserved.',
			'label_block' => true,
		] );

		$this->add_control( 'bottom_link_text', [
			'label'       => esc_html__( 'Right Link Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => '← Home',
			'label_block' => true,
		] );

		$this->add_control( 'bottom_link', [
			'label'   => esc_html__( 'Right Link URL', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * HELPERS
	 * ===================================================================== */

	/** Keep only safe characters for a Font Awesome class string. */
	private function icon_class( $class ) {
		return esc_attr( trim( preg_replace( '/[^a-zA-Z0-9\s\-_]/', '', (string) $class ) ) );
	}

	/** One <ul> from a WordPress menu (top-level items). */
	private function render_links( $s, $menu_key ) {
		$menu_id = ! empty( $s[ $menu_key ] ) ? (int) $s[ $menu_key ] : 0;
		$items   = $menu_id ? wp_get_nav_menu_items( $menu_id ) : [];

		if ( empty( $items ) || is_wp_error( $items ) ) {
			if ( \Elementor\Plugin::$instance->editor->is_edit_mode() ) {
				echo '<p class="text-sm">' . esc_html__( 'Select a menu in the widget settings.', 'elementor-test' ) . '</p>';
			}
			return;
		}
		?>
		<ul class="space-y-2 text-sm">
			<?php
			foreach ( $items as $item ) :
				if ( 0 !== (int) $item->menu_item_parent ) {
					continue; // top-level items only
				}
				$attrs = 'href="' . esc_url( $item->url ) . '" class="hover:text-primary-400 transition"';
				if ( ! empty( $item->target ) ) {
					$attrs .= ' target="' . esc_attr( $item->target ) . '"';
				}
				$rel = trim( $item->xfn . ( '_blank' === $item->target ? ' noopener' : '' ) );
				if ( $rel ) {
					$attrs .= ' rel="' . esc_attr( $rel ) . '"';
				}
				?>
				<li>
					<a <?php echo $attrs; // phpcs:ignore WordPress.Security.EscapeOutput -- built from escaped parts ?>><?php echo esc_html( $item->title ); ?></a>
				</li>
			<?php endforeach; ?>
		</ul>
		<?php
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		$this->add_render_attribute( 'bottom_a', 'class', 'hover:text-primary-400 transition' );
		if ( ! empty( $s['bottom_link']['url'] ) ) {
			$this->add_link_attributes( 'bottom_a', $s['bottom_link'] );
		}
		?>

		<footer class="bg-slate-900 dark:bg-slate-950 text-slate-400 pt-14 pb-8 border-t border-slate-800">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid md:grid-cols-4 gap-10 mb-10">

					<div>
						<div class="flex items-center gap-2.5 mb-4">
							<?php if ( ! empty( $s['brand_icon'] ) ) : ?>
								<div class="w-8 h-8 rounded-lg bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center">
									<i class="<?php echo $this->icon_class( $s['brand_icon'] ); ?> text-white text-xs"></i>
								</div>
							<?php endif; ?>
							<span class="font-display font-bold text-white"><?php echo esc_html( $s['brand_name'] ); ?></span>
						</div>
						<p class="text-[17px] leading-relaxed"><?php echo esc_html( $s['brand_desc'] ); ?></p>
					</div>

					<div>
						<h4 class="text-white text-sm font-semibold mb-3"><?php echo esc_html( $s['svc_title'] ); ?></h4>
						<?php $this->render_links( $s, 'svc_menu' ); ?>
					</div>

					<div>
						<h4 class="text-white text-sm font-semibold mb-3"><?php echo esc_html( $s['sup_title'] ); ?></h4>
						<?php $this->render_links( $s, 'sup_menu' ); ?>
					</div>

					<div>
						<h4 class="text-white text-sm font-semibold mb-3"><?php echo esc_html( $s['con_title'] ); ?></h4>
						<ul class="space-y-2 text-sm">
							<?php
							for ( $n = 1; $n <= 2; $n++ ) :
								if ( empty( $s[ "con{$n}_text" ] ) ) {
									continue;
								}
								?>
								<li>
									<?php if ( ! empty( $s[ "con{$n}_icon" ] ) ) : ?>
										<i class="<?php echo $this->icon_class( $s[ "con{$n}_icon" ] ); ?> text-primary-400 mr-2"></i>
									<?php endif; ?>
									<?php echo esc_html( $s[ "con{$n}_text" ] ); ?>
								</li>
							<?php endfor; ?>
						</ul>
					</div>

				</div>

				<div class="border-t border-slate-800 pt-6 flex flex-col sm:flex-row justify-between items-center gap-2 text-xs text-slate-400">
					<p><?php echo esc_html( $s['copyright'] ); ?></p>
					<?php if ( ! empty( $s['bottom_link_text'] ) ) : ?>
						<a <?php $this->print_render_attribute_string( 'bottom_a' ); ?>><?php echo esc_html( $s['bottom_link_text'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</footer>

		<?php
	}
}