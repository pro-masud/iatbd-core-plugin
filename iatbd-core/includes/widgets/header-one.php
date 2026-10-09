<?php
/**
 * IATBD Header (simple: WordPress menu, no repeater, no Elementor icon picker)
 *
 * Markup/classes/IDs are the same as the original static HTML
 * (#theme-toggle, #mobile-menu-btn, #mobile-menu), so your existing
 * global JS keeps working. Only the content is made editable.
 */
class Widget_1 extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_header';
	}

	public function get_title() {
		return esc_html__( 'IATBD Header', 'elementor-test' );
	}

	public function get_icon() {
		return 'eicon-header';
	}

	public function get_custom_help_url() {
		return 'https://developers.elementor.com/docs/widgets/';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	public function get_keywords() {
		return [ 'header', 'menu', 'navbar', 'nav', 'iatbd' ];
	}

	/* =====================================================================
	 * CONTROLS
	 * ===================================================================== */
	protected function register_controls() {

		// ---- Logo ----
		$this->start_controls_section( 'logo_section', [
			'label' => esc_html__( 'Logo', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'logo_icon', [
			'label'       => esc_html__( 'Logo Icon (Font Awesome class)', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'fas fa-microchip',
			'placeholder' => 'fas fa-microchip',
			'label_block' => true,
		] );

		$this->add_control( 'logo_text', [
			'label'       => esc_html__( 'Logo Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'IATBD',
			'label_block' => true,
		] );

		$this->add_control( 'logo_tagline', [
			'label'       => esc_html__( 'Tagline', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Industrial Automation',
			'label_block' => true,
		] );

		$this->add_control( 'logo_link', [
			'label'   => esc_html__( 'Logo Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );

		$this->end_controls_section();

		// ---- Menu ----
		$this->start_controls_section( 'menu_section', [
			'label' => esc_html__( 'Menu', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$menu_options = $this->get_menu_options();
		$menu_keys    = array_keys( $menu_options );

		$this->add_control( 'wp_menu', [
			'label'       => esc_html__( 'Select Menu', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::SELECT,
			'options'     => $menu_options,
			'default'     => count( $menu_options ) > 1 ? $menu_keys[1] : '',
			'label_block' => true,
			'description' => sprintf(
				/* translators: %s: link to Menus screen */
				esc_html__( 'Sub menus become the dropdown automatically. Create or edit menus from %s.', 'elementor-test' ),
				'<a href="' . esc_url( admin_url( 'nav-menus.php' ) ) . '" target="_blank">' . esc_html__( 'Appearance → Menus', 'elementor-test' ) . '</a>'
			),
		] );

		$this->end_controls_section();

		// ---- Contact button ----
		$this->start_controls_section( 'cta_section', [
			'label' => esc_html__( 'Contact Button', 'elementor-test' ),
			'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
		] );

		$this->add_control( 'cta_text', [
			'label'       => esc_html__( 'Button Text', 'elementor-test' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'Contact',
			'label_block' => true,
		] );

		$this->add_control( 'cta_link', [
			'label'   => esc_html__( 'Button Link', 'elementor-test' ),
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#contact' ],
		] );

		$this->end_controls_section();
	}

	/* =====================================================================
	 * HELPERS
	 * ===================================================================== */

	/** All WordPress menus for the select control. */
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

	/** Keep only safe characters for a Font Awesome class string. */
	private function icon_class( $class ) {
		return esc_attr( trim( preg_replace( '/[^a-zA-Z0-9\s\-_]/', '', (string) $class ) ) );
	}

	/** Menu items grouped by parent ID: [ parent_id => [ items ] ]. */
	private function get_wp_menu_tree( $menu_id ) {
		$items = wp_get_nav_menu_items( $menu_id );
		if ( empty( $items ) || is_wp_error( $items ) ) {
			return [];
		}
		if ( function_exists( '_wp_menu_item_classes_by_context' ) ) {
			_wp_menu_item_classes_by_context( $items ); // sets current / ancestor flags
		}
		$tree = [];
		foreach ( $items as $item ) {
			$tree[ (int) $item->menu_item_parent ][] = $item;
		}
		return $tree;
	}

	private function is_item_active( $item ) {
		return ! empty( $item->current ) || ! empty( $item->current_item_ancestor ) || ! empty( $item->current_item_parent );
	}

	/** href / class / target / rel attribute string for a WP menu item. */
	private function item_attrs( $item, $class, $extra = '' ) {
		$attrs = 'href="' . esc_url( $item->url ) . '" class="' . esc_attr( $class ) . '"';
		if ( ! empty( $item->target ) ) {
			$attrs .= ' target="' . esc_attr( $item->target ) . '"';
		}
		$rel = trim( $item->xfn . ( '_blank' === $item->target ? ' noopener' : '' ) );
		if ( $rel ) {
			$attrs .= ' rel="' . esc_attr( $rel ) . '"';
		}
		return $attrs . $extra;
	}

	/** Desktop nav (top level + dropdown for items that have sub menus). */
	private function render_desktop( $tree ) {
		if ( empty( $tree[0] ) ) {
			return;
		}
		foreach ( $tree[0] as $item ) {
			$has_children = ! empty( $tree[ $item->ID ] );
			$class        = 'nav-link px-3.5 py-2 text-sm font-medium';
			$class       .= $this->is_item_active( $item )
				? ' active text-primary-600 dark:text-primary-400'
				: ' text-slate-600 dark:text-slate-300 hover:text-primary-600';

			if ( ! $has_children ) {
				echo '<a ' . $this->item_attrs( $item, $class ) . '>' . esc_html( $item->title ) . '</a>';
				continue;
			}

			echo '<div class="relative group">';
			echo '<a ' . $this->item_attrs( $item, $class . ' flex items-center gap-1.5' ) . '>' . esc_html( $item->title ) . ' <i class="fas fa-chevron-down text-[9px]"></i></a>';
			echo '<div class="dropdown-menu absolute top-full left-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-xl overflow-hidden z-50">';
			$this->render_dropdown_items( $tree, $item->ID, 0 );
			echo '</div></div>';
		}
	}

	/** Dropdown links (deeper levels are indented). */
	private function render_dropdown_items( $tree, $parent, $depth ) {
		if ( empty( $tree[ $parent ] ) ) {
			return;
		}
		foreach ( $tree[ $parent ] as $sub ) {
			$extra = $depth ? ' style="padding-left:calc(1rem + ' . ( $depth * 14 ) . 'px)"' : '';
			echo '<a ' . $this->item_attrs( $sub, 'block px-4 py-2.5 text-sm text-slate-600 dark:text-slate-300 hover:bg-primary-50 dark:hover:bg-primary-900/20', $extra ) . '>' . esc_html( $sub->title ) . '</a>';
			$this->render_dropdown_items( $tree, $sub->ID, $depth + 1 );
		}
	}

	/** Mobile menu (sub items are indented under their parent). */
	private function render_mobile( $tree, $parent, $depth ) {
		if ( empty( $tree[ $parent ] ) ) {
			return;
		}
		foreach ( $tree[ $parent ] as $item ) {
			$class = 'block px-3 py-2.5 rounded-lg text-sm';
			$class .= ( 0 === $depth && $this->is_item_active( $item ) )
				? ' font-medium text-primary-600 bg-primary-50 dark:bg-primary-900/20'
				: ' text-slate-600 dark:text-slate-300';
			$extra = $depth ? ' style="padding-left:calc(0.75rem + ' . ( $depth * 16 ) . 'px)"' : '';

			echo '<a ' . $this->item_attrs( $item, $class, $extra ) . '>' . esc_html( $item->title ) . '</a>';
			$this->render_mobile( $tree, $item->ID, $depth + 1 );
		}
	}

	/* =====================================================================
	 * RENDER
	 * ===================================================================== */
	protected function render() {
		$s = $this->get_settings_for_display();

		$tree = ! empty( $s['wp_menu'] ) ? $this->get_wp_menu_tree( (int) $s['wp_menu'] ) : [];

		$this->add_render_attribute( 'logo_a', 'class', 'flex items-center gap-3' );
		if ( ! empty( $s['logo_link']['url'] ) ) {
			$this->add_link_attributes( 'logo_a', $s['logo_link'] );
		}

		$has_cta = ! empty( $s['cta_text'] );
		if ( $has_cta ) {
			$this->add_render_attribute( 'cta_a', 'class', 'hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold rounded-full shadow-lg shadow-primary-500/20 btn-cta' );
			$this->add_render_attribute( 'cta_mob', 'class', 'block mt-2 text-center py-2.5 bg-primary-600 text-white rounded-xl text-sm font-semibold' );
			if ( ! empty( $s['cta_link']['url'] ) ) {
				$this->add_link_attributes( 'cta_a', $s['cta_link'] );
				$this->add_link_attributes( 'cta_mob', $s['cta_link'] );
			}
		}
		?>

		<header class="fixed top-0 inset-x-0 z-50 bg-white/85 dark:bg-slate-900/85 backdrop-blur-xl border-b border-slate-200/70 dark:border-slate-800">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex items-center justify-between h-16 lg:h-[70px]">

					<!-- Logo -->
					<a <?php $this->print_render_attribute_string( 'logo_a' ); ?>>
						<?php if ( ! empty( $s['logo_icon'] ) ) : ?>
							<div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary-500 to-accent-500 flex items-center justify-center shadow-md shadow-primary-500/20">
								<i class="<?php echo $this->icon_class( $s['logo_icon'] ); ?> text-white text-sm"></i>
							</div>
						<?php endif; ?>
						<div>
							<span class="font-display font-bold text-lg text-slate-900 dark:text-white tracking-tight"><?php echo esc_html( $s['logo_text'] ); ?></span>
							<?php if ( ! empty( $s['logo_tagline'] ) ) : ?>
								<p class="text-[9px] text-slate-400 tracking-[0.2em] uppercase -mt-0.5"><?php echo esc_html( $s['logo_tagline'] ); ?></p>
							<?php endif; ?>
						</div>
					</a>

					<!-- Desktop Navigation -->
					<nav class="hidden lg:flex items-center gap-1">
						<?php $this->render_desktop( $tree ); ?>
					</nav>

					<!-- Actions -->
					<div class="flex items-center gap-2">
						<button
							id="theme-toggle"
							type="button"
							aria-label="Switch to dark mode"
							aria-pressed="false"
							class="w-9 h-9 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-slate-600 dark:text-slate-300 hover:bg-slate-200 dark:hover:bg-slate-700 transition"
						>
							<i class="fas fa-sun theme-icon-sun text-xs text-amber-500"></i>
							<i class="fas fa-moon theme-icon-moon text-xs text-slate-200"></i>
						</button>

						<?php if ( $has_cta ) : ?>
							<a <?php $this->print_render_attribute_string( 'cta_a' ); ?>><?php echo esc_html( $s['cta_text'] ); ?></a>
						<?php endif; ?>

						<button
							id="mobile-menu-btn"
							type="button"
							aria-label="Toggle navigation menu"
							aria-controls="mobile-menu"
							aria-expanded="false"
							class="lg:hidden w-9 h-9 rounded-lg bg-slate-100 dark:bg-slate-800 flex items-center justify-center"
						>
							<i class="fas fa-bars text-slate-700 dark:text-slate-300"></i>
						</button>
					</div>
				</div>
			</div>

			<!-- Mobile Navigation Menu -->
			<div id="mobile-menu" class="lg:hidden hidden border-t border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900">
				<div class="px-4 py-3 space-y-1">
					<?php $this->render_mobile( $tree, 0, 0 ); ?>
					<?php if ( $has_cta ) : ?>
						<a <?php $this->print_render_attribute_string( 'cta_mob' ); ?>><?php echo esc_html( $s['cta_text'] ); ?></a>
					<?php endif; ?>
				</div>
			</div>
		</header>

		<?php
	}
}