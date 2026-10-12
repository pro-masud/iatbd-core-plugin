<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class IATBD_Store_Products_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'iatbd_store_products';
	}

	public function get_title() {
		return 'Store Products';
	}

	public function get_icon() {
		return 'eicon-products';
	}

	public function get_categories() {
		return [ 'iatbd-addons' ];
	}

	/* Full class strings so Tailwind can detect them */
	private function badge_colors() {
		return [
			'primary'     => 'bg-primary-600',
			'orange'      => 'bg-orange-500',
			'emerald'     => 'bg-emerald-700',
			'orange_dark' => 'bg-orange-700',
			'cyan'        => 'bg-cyan-700',
			'slate'       => 'bg-slate-700',
		];
	}

	/* 1234567 => 12,34,567 (BDT style grouping) */
	private function bdt( $n ) {
		$s = (string) (int) round( (float) $n );
		if ( strlen( $s ) <= 3 ) {
			return $s;
		}
		$last = substr( $s, -3 );
		$rest = substr( $s, 0, -3 );
		$rest = preg_replace( '/\B(?=(\d{2})+(?!\d))/', ',', $rest );
		return $rest . ',' . $last;
	}

	private function default_categories() {
		return [
			[ 'slug' => 'all', 'label' => 'All' ],
			[ 'slug' => 'plc', 'label' => 'PLC' ],
			[ 'slug' => 'hmi', 'label' => 'HMI' ],
			[ 'slug' => 'vfd', 'label' => 'VFD' ],
			[ 'slug' => 'servo', 'label' => 'Servo' ],
			[ 'slug' => 'cable', 'label' => 'Cables' ],
			[ 'slug' => 'accessory', 'label' => 'Accessories' ],
		];
	}

	private function default_products() {
		$u = 'https://images.unsplash.com/';
		$q = '?auto=format&fit=crop&w=600&q=80';
		return [
			[ 'plc-1', 'plc', 'PLC', 'primary', 'Siemens', 'Siemens S7-1200 CPU 1214C', 'S7-1200 CPU 1214C', 'Compact PLC, 14 DI / 10 DO, Ethernet. Ideal for machine control.', 28500, $u . 'photo-1581091226825-a6a2a5aee158' . $q, 'Industrial PLC control equipment' ],
			[ 'plc-2', 'plc', 'PLC', 'primary', 'Delta', 'Delta DVP14SS2 Slim PLC', 'DVP14SS2 Slim PLC', '8 DI / 6 DO and high-speed counters for compact machines.', 9200, $u . 'photo-1581092160562-40aa08e78837' . $q, 'PLC automation equipment' ],
			[ 'hmi-1', 'hmi', 'HMI', 'orange', 'Weintek', 'Weintek MT8071iE 7 inch HMI', 'MT8071iE 7-inch Touch HMI', '7-inch TFT, Ethernet and multi-protocol connectivity.', 18500, $u . 'photo-1550751827-4bd374c3f58b' . $q, 'Industrial HMI and electronics' ],
			[ 'hmi-2', 'hmi', 'HMI', 'orange', 'Siemens', 'Siemens KTP700 Basic PN HMI', 'KTP700 Basic PN', '7-inch color touch panel with PROFINET connectivity.', 42000, $u . 'photo-1518770660439-4636190af475' . $q, 'Electronic components for industrial control' ],
			[ 'vfd-1', 'vfd', 'VFD', 'emerald', 'Danfoss', 'Danfoss FC-51 2.2kW VFD', 'VLT Micro Drive FC-51 2.2 kW', 'Compact drive for pumps and fans, with simple setup.', 24500, $u . 'photo-1504328345606-18bbc8c9d7d1' . $q, 'Industrial motor and drive equipment' ],
			[ 'vfd-2', 'vfd', 'VFD', 'emerald', 'Delta', 'Delta VFD-EL 1.5kW VFD', 'VFD-EL 1.5 kW 230V', 'Sensorless vector drive for conveyors and small fans.', 12800, $u . 'photo-1581092918056-0c4c3acd3789' . $q, 'Industrial electrical drive' ],
			[ 'servo-1', 'servo', 'SERVO', 'orange_dark', 'Delta', 'Delta ASD-B2 400W Servo Kit', 'ASD-B2 400W Servo Kit', 'Drive, motor and encoder cable for precise positioning.', 32000, $u . 'photo-1565043589221-1a6fd9ae45c7' . $q, 'Servo and motion-control equipment' ],
			[ 'servo-2', 'servo', 'SERVO', 'orange_dark', 'Mitsubishi', 'Mitsubishi MR-JE 750W Servo Package', 'MR-JE 750W Servo Package', 'High-response motion package for packaging and positioning.', 48000, $u . 'photo-1581092162384-8987c1d64718' . $q, 'Industrial motion control system' ],
			[ 'cable-1', 'cable', 'CABLE', 'cyan', 'Communication', 'PROFIBUS DP Cable 100m', 'PROFIBUS DP Cable 100 m', 'Shielded industrial fieldbus cable for reliable communication.', 8500, $u . 'photo-1558618666-fcd25c85cd64' . $q, 'Industrial communication cable' ],
			[ 'cable-2', 'cable', 'CABLE', 'cyan', 'Communication', 'Industrial Cat6 Ethernet Cable 50m', 'Industrial Cat6 Ethernet 50 m', 'Shielded, oil-resistant jacket for machine networking.', 3200, $u . 'photo-1544197150-b99a549f55c5' . $q, 'Ethernet networking cable' ],
			[ 'acc-1', 'accessory', 'ACCESSORY', 'slate', 'Power', '24V 5A DIN Rail Power Supply', '24V 5A DIN Rail PSU', 'Industrial switching supply for PLCs, HMIs and sensors.', 2800, $u . 'photo-1581092918056-0c4c3acd3789' . $q, 'Industrial power supply equipment' ],
			[ 'acc-2', 'accessory', 'ACCESSORY', 'slate', 'Automation', 'Industrial Photoelectric Sensor', 'Photoelectric Sensor', 'Compact sensing for object detection on production lines.', 4500, $u . 'photo-1518770660439-4636190af475' . $q, 'Electronic sensor components' ],
		];
	}

	protected function register_controls() {
		$T  = \Elementor\Controls_Manager::TEXT;
		$TA = \Elementor\Controls_Manager::TEXTAREA;
		$N  = \Elementor\Controls_Manager::NUMBER;

		/* Heading */
		$this->start_controls_section( 'sec_head', [ 'label' => 'Heading' ] );
		$this->add_control( 'eyebrow', [ 'label' => 'Small Title', 'type' => $T, 'label_block' => true, 'default' => 'IATBD Store' ] );
		$this->add_control( 'heading', [ 'label' => 'Heading', 'type' => $T, 'label_block' => true, 'default' => 'Shop automation products' ] );
		$this->add_control( 'subtitle', [ 'label' => 'Subtitle', 'type' => $TA, 'default' => 'Genuine components for industrial systems and machine builders.' ] );
		$this->end_controls_section();

		/* Filter bar */
		$this->start_controls_section( 'sec_filters', [ 'label' => 'Search, Sort & Price' ] );
		$this->add_control( 'search_label', [ 'label' => 'Search Screen-reader Label', 'type' => $T, 'label_block' => true, 'default' => 'Search products' ] );
		$this->add_control( 'search_placeholder', [ 'label' => 'Search Placeholder', 'type' => $T, 'label_block' => true, 'default' => 'Search PLC, HMI, VFD, cable...' ] );
		$this->add_control( 'sort_label', [ 'label' => 'Sort Screen-reader Label', 'type' => $T, 'label_block' => true, 'default' => 'Sort products' ] );
		$this->add_control( 'sort_default', [ 'label' => 'Sort: Default', 'type' => $T, 'label_block' => true, 'default' => 'Featured', 'separator' => 'before' ] );
		$this->add_control( 'sort_price_asc', [ 'label' => 'Sort: Price Low to High', 'type' => $T, 'label_block' => true, 'default' => 'Price: Low to High' ] );
		$this->add_control( 'sort_price_desc', [ 'label' => 'Sort: Price High to Low', 'type' => $T, 'label_block' => true, 'default' => 'Price: High to Low' ] );
		$this->add_control( 'sort_name', [ 'label' => 'Sort: Name', 'type' => $T, 'label_block' => true, 'default' => 'Name A to Z' ] );
		$this->add_control( 'currency', [ 'label' => 'Currency Symbol', 'type' => $T, 'label_block' => true, 'default' => '৳', 'separator' => 'before' ] );
		$this->add_control( 'min_label', [ 'label' => 'Minimum Price Label', 'type' => $T, 'label_block' => true, 'default' => 'Minimum price' ] );
		$this->add_control( 'max_label', [ 'label' => 'Maximum Price Label', 'type' => $T, 'label_block' => true, 'default' => 'Maximum price' ] );
		$this->add_control( 'price_min', [ 'label' => 'Slider Minimum', 'type' => $N, 'default' => 1000 ] );
		$this->add_control( 'price_max', [ 'label' => 'Slider Maximum', 'type' => $N, 'default' => 200000 ] );
		$this->add_control( 'price_step', [ 'label' => 'Slider Step', 'type' => $N, 'default' => 500 ] );
		$this->end_controls_section();

		/* Categories repeater */
		$this->start_controls_section( 'sec_cats', [ 'label' => 'Categories' ] );
		$crep = new \Elementor\Repeater();
		$crep->add_control( 'slug', [ 'label' => 'Slug (used in products, e.g. plc)', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$crep->add_control( 'label', [ 'label' => 'Button Label', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$this->add_control( 'cats', [
			'label'       => 'Category Buttons (first one = All, slug: all)',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $crep->get_controls(),
			'default'     => $this->default_categories(),
			'title_field' => '{{{ label }}}',
		] );
		$this->end_controls_section();

		/* Products repeater */
		$this->start_controls_section( 'sec_products', [ 'label' => 'Products' ] );
		$this->add_control( 'cod_text', [ 'label' => 'Top-right Badge Text (all products)', 'type' => $T, 'label_block' => true, 'default' => 'COD' ] );
		$this->add_control( 'btn_text', [ 'label' => 'Add Button Text', 'type' => $T, 'label_block' => true, 'default' => 'Add' ] );
		$this->add_control( 'btn_icon', [ 'label' => 'Add Button Icon Class', 'type' => $T, 'label_block' => true, 'default' => 'fas fa-cart-plus' ] );

		$prep = new \Elementor\Repeater();
		$prep->add_control( 'pid', [ 'label' => 'Product ID (cart id, e.g. plc-1)', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'cat', [ 'label' => 'Category Slug', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'badge', [ 'label' => 'Badge Text (top-left)', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'badge_color', [
			'label'   => 'Badge Color',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'primary',
			'options' => [
				'primary'     => 'Primary',
				'orange'      => 'Orange',
				'emerald'     => 'Emerald',
				'orange_dark' => 'Orange (dark)',
				'cyan'        => 'Cyan',
				'slate'       => 'Slate',
			],
		] );
		$prep->add_control( 'image', [ 'label' => 'Image', 'type' => \Elementor\Controls_Manager::MEDIA, 'default' => [ 'url' => '' ] ] );
		$prep->add_control( 'alt', [ 'label' => 'Image Alt', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'brand', [ 'label' => 'Brand', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'full_name', [ 'label' => 'Full Name (search, sort & cart)', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'title', [ 'label' => 'Card Title', 'type' => $T, 'label_block' => true, 'default' => '' ] );
		$prep->add_control( 'desc', [ 'label' => 'Description', 'type' => $TA, 'default' => '' ] );
		$prep->add_control( 'price', [ 'label' => 'Price (number only)', 'type' => $N, 'default' => 0 ] );

		$defaults = [];
		foreach ( $this->default_products() as $p ) {
			$defaults[] = [
				'pid'         => $p[0],
				'cat'         => $p[1],
				'badge'       => $p[2],
				'badge_color' => $p[3],
				'brand'       => $p[4],
				'full_name'   => $p[5],
				'title'       => $p[6],
				'desc'        => $p[7],
				'price'       => $p[8],
				'image'       => [ 'url' => $p[9] ],
				'alt'         => $p[10],
			];
		}

		$this->add_control( 'products', [
			'label'       => 'Products',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $prep->get_controls(),
			'default'     => $defaults,
			'title_field' => '{{{ full_name }}}',
		] );
		$this->end_controls_section();

		/* Empty state */
		$this->start_controls_section( 'sec_empty', [ 'label' => 'Empty State' ] );
		$this->add_control( 'empty_icon', [ 'label' => 'Icon Class', 'type' => $T, 'label_block' => true, 'default' => 'fas fa-box-open' ] );
		$this->add_control( 'empty_title', [ 'label' => 'Title', 'type' => $T, 'label_block' => true, 'default' => 'No products match these filters.' ] );
		$this->add_control( 'empty_text', [ 'label' => 'Text', 'type' => $T, 'label_block' => true, 'default' => 'Try another category, search term or price range.' ] );
		$this->end_controls_section();
	}

	protected function render() {
		$s      = $this->get_settings_for_display();
		$badges = $this->badge_colors();
		$sym    = $s['currency'];
		$pmin   = (int) $s['price_min'];
		$pmax   = (int) $s['price_max'];
		$step   = max( 1, (int) $s['price_step'] );
		$prods  = ! empty( $s['products'] ) ? $s['products'] : [];
		$cats   = ! empty( $s['cats'] ) ? $s['cats'] : [];
		$total  = count( $prods );
		?>
		<section id="store-products" class="py-8 sm:py-12" aria-label="Store products">
			<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-3 mb-6">
					<div>
						<p class="text-xs font-bold uppercase tracking-[0.16em] text-accent-600 mb-1"><?php echo esc_html( $s['eyebrow'] ); ?></p>
						<h2 class="font-display text-2xl sm:text-3xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['heading'] ); ?></h2>
					</div>
					<p class="text-sm text-slate-500 dark:text-slate-400"><?php echo esc_html( $s['subtitle'] ); ?></p>
				</div>

				<div class="sticky top-16 lg:top-17.5 z-30 -mx-4 px-4 sm:mx-0 sm:px-0 py-4 bg-slate-50/95 dark:bg-slate-950/95 backdrop-blur-lg border-y sm:border border-slate-200 dark:border-slate-800 sm:rounded-xl">
					<div class="flex flex-col sm:flex-row gap-3 sm:items-center sm:justify-between mb-4">
						<label class="relative flex-1 max-w-lg">
							<span class="sr-only"><?php echo esc_html( $s['search_label'] ); ?></span>
							<i class="fas fa-search absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-sm"></i>
							<input id="store-search" type="search" placeholder="<?php echo esc_attr( $s['search_placeholder'] ); ?>" class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-800 dark:text-slate-100 placeholder:text-slate-400 focus:outline-none focus:ring-2 focus:ring-primary-500/40" />
						</label>
						<div class="flex items-center justify-between sm:justify-end gap-3 text-sm text-slate-500 dark:text-slate-400">
							<span id="store-result-count" aria-live="polite"><?php echo esc_html( $total . ( 1 === $total ? ' product' : ' products' ) ); ?></span>
							<label class="sr-only" for="store-sort"><?php echo esc_html( $s['sort_label'] ); ?></label>
							<select id="store-sort" class="px-3 py-2 rounded-lg border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 text-sm text-slate-700 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-primary-500/30">
								<option value="default"><?php echo esc_html( $s['sort_default'] ); ?></option>
								<option value="price-asc"><?php echo esc_html( $s['sort_price_asc'] ); ?></option>
								<option value="price-desc"><?php echo esc_html( $s['sort_price_desc'] ); ?></option>
								<option value="name"><?php echo esc_html( $s['sort_name'] ); ?></option>
							</select>
						</div>
					</div>
					<div class="grid sm:grid-cols-[1fr_auto] gap-4 items-center mb-4">
						<div>
							<div class="flex items-center justify-between gap-3 mb-2">
								<label for="store-price-min" class="text-xs font-semibold text-slate-600 dark:text-slate-300"><?php echo esc_html( $s['min_label'] ); ?></label>
								<span id="store-min-label" class="text-xs font-semibold text-primary-700 dark:text-primary-300"><?php echo esc_html( $sym . ' ' . $this->bdt( $pmin ) ); ?></span>
							</div>
							<input id="store-price-min" class="store-range w-full" type="range" min="<?php echo esc_attr( $pmin ); ?>" max="<?php echo esc_attr( $pmax ); ?>" step="<?php echo esc_attr( $step ); ?>" value="<?php echo esc_attr( $pmin ); ?>" />
						</div>
						<div>
							<div class="flex items-center justify-between gap-3 mb-2">
								<label for="store-price-max" class="text-xs font-semibold text-slate-600 dark:text-slate-300"><?php echo esc_html( $s['max_label'] ); ?></label>
								<span id="store-max-label" class="text-xs font-semibold text-primary-700 dark:text-primary-300"><?php echo esc_html( $sym . ' ' . $this->bdt( $pmax ) ); ?></span>
							</div>
							<input id="store-price-max" class="store-range w-full sm:w-48" type="range" min="<?php echo esc_attr( $pmin ); ?>" max="<?php echo esc_attr( $pmax ); ?>" step="<?php echo esc_attr( $step ); ?>" value="<?php echo esc_attr( $pmax ); ?>" />
						</div>
					</div>
					<div class="flex gap-2 overflow-x-auto pb-1" id="store-categories" aria-label="Filter by category">
						<?php foreach ( $cats as $ci => $c ) : ?>
							<?php if ( 0 === $ci ) : ?>
								<button type="button" class="store-category-btn active shrink-0 px-4 py-2 rounded-full border border-slate-300 dark:border-slate-600 text-sm font-semibold" data-category="<?php echo esc_attr( $c['slug'] ); ?>" aria-pressed="true"><?php echo esc_html( $c['label'] ); ?></button>
							<?php else : ?>
								<button type="button" class="store-category-btn shrink-0 px-4 py-2 rounded-full border border-slate-300 dark:border-slate-600 text-sm font-semibold text-slate-600 dark:text-slate-300" data-category="<?php echo esc_attr( $c['slug'] ); ?>" aria-pressed="false"><?php echo esc_html( $c['label'] ); ?></button>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>

				<div id="store-product-grid" class="grid sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5 mt-7">
					<?php
					foreach ( $prods as $i => $p ) :
						$img   = ! empty( $p['image']['url'] ) ? $p['image']['url'] : '';
						$thumb = str_replace( 'w=600', 'w=200', $img );
						$bc    = isset( $badges[ $p['badge_color'] ] ) ? $badges[ $p['badge_color'] ] : $badges['primary'];
						$price = (float) $p['price'];
						?>
						<article class="store-product-card bg-white dark:bg-slate-900 rounded-xl border border-slate-200 dark:border-slate-800 overflow-hidden flex flex-col" data-cat="<?php echo esc_attr( $p['cat'] ); ?>" data-brand="<?php echo esc_attr( $p['brand'] ); ?>" data-name="<?php echo esc_attr( $p['full_name'] ); ?>" data-price="<?php echo esc_attr( $price ); ?>" data-order="<?php echo esc_attr( $i + 1 ); ?>">
							<div class="relative h-48 bg-slate-100 dark:bg-slate-800 overflow-hidden">
								<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $p['alt'] ); ?>" class="iatbd-widget-image" loading="lazy" /><span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-white text-[11px] font-bold <?php echo esc_attr( $bc ); ?>"><?php echo esc_html( $p['badge'] ); ?></span><span class="absolute top-3 right-3 px-2.5 py-1 rounded-md bg-emerald-600 text-white text-[11px] font-bold"><?php echo esc_html( $s['cod_text'] ); ?></span>
							</div>
							<div class="p-4 flex flex-col flex-1">
								<p class="text-xs text-slate-400 mb-1"><?php echo esc_html( $p['brand'] ); ?></p>
								<h3 class="font-semibold text-slate-900 dark:text-white text-[15px] leading-snug mb-2"><?php echo esc_html( $p['title'] ); ?></h3>
								<p class="text-[13px] text-slate-500 dark:text-slate-400 mb-4"><?php echo esc_html( $p['desc'] ); ?></p>
								<div class="mt-auto flex items-center justify-between gap-2">
									<p class="font-display font-bold text-lg text-primary-600 dark:text-primary-400"><?php echo esc_html( $sym . ' ' . $this->bdt( $price ) ); ?></p>
									<button type="button" class="store-add-cart px-3.5 py-2 rounded-lg bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold transition flex items-center gap-1.5" data-id="<?php echo esc_attr( $p['pid'] ); ?>" data-title="<?php echo esc_attr( $p['full_name'] ); ?>" data-price="<?php echo esc_attr( $price ); ?>" data-image="<?php echo esc_url( $thumb ); ?>">
										<i class="<?php echo esc_attr( $s['btn_icon'] ); ?> text-xs"></i> <?php echo esc_html( $s['btn_text'] ); ?>
									</button>
								</div>
							</div>
						</article>
					<?php endforeach; ?>
				</div>

				<div id="store-empty-state" class="hidden py-16 text-center">
					<i class="<?php echo esc_attr( $s['empty_icon'] ); ?> text-3xl text-slate-300 dark:text-slate-600 mb-3"></i>
					<p class="font-semibold text-slate-800 dark:text-white"><?php echo esc_html( $s['empty_title'] ); ?></p>
					<p class="text-sm text-slate-500 dark:text-slate-400 mt-1"><?php echo esc_html( $s['empty_text'] ); ?></p>
				</div>
			</div>
		</section>

		<script>
		(function () {
			var grid = document.getElementById('store-product-grid');
			if (!grid || grid.getAttribute('data-bound')) { return; }
			grid.setAttribute('data-bound', '1');

			var cards   = [].slice.call(grid.querySelectorAll('.store-product-card'));
			var search  = document.getElementById('store-search');
			var sortSel = document.getElementById('store-sort');
			var minR    = document.getElementById('store-price-min');
			var maxR    = document.getElementById('store-price-max');
			var minL    = document.getElementById('store-min-label');
			var maxL    = document.getElementById('store-max-label');
			var count   = document.getElementById('store-result-count');
			var empty   = document.getElementById('store-empty-state');
			var catWrap = document.getElementById('store-categories');
			var sym     = <?php echo wp_json_encode( $sym ); ?>;
			var cat     = 'all';
			var idle    = ['text-slate-600', 'dark:text-slate-300'];

			function fmt(n) { return sym + ' ' + Number(n).toLocaleString('en-IN'); }

			function sorter(mode) {
				return function (a, b) {
					if (mode === 'price-asc')  { return a.dataset.price - b.dataset.price; }
					if (mode === 'price-desc') { return b.dataset.price - a.dataset.price; }
					if (mode === 'name')       { return a.dataset.name.localeCompare(b.dataset.name); }
					return a.dataset.order - b.dataset.order;
				};
			}

			function apply() {
				var q   = search.value.trim().toLowerCase();
				var min = Number(minR.value);
				var max = Number(maxR.value);
				var shown = 0;

				cards.forEach(function (c) {
					var p   = Number(c.dataset.price);
					var hay = (c.dataset.name + ' ' + c.dataset.brand + ' ' + c.dataset.cat).toLowerCase();
					var ok  = (cat === 'all' || c.dataset.cat === cat) && p >= min && p <= max && (!q || hay.indexOf(q) > -1);
					c.classList.toggle('hidden', !ok);
					if (ok) { shown++; }
				});

				cards.slice().sort(sorter(sortSel.value)).forEach(function (c) { grid.appendChild(c); });

				count.textContent = shown + (shown === 1 ? ' product' : ' products');
				empty.classList.toggle('hidden', shown !== 0);
			}

			function labels() {
				minL.textContent = fmt(minR.value);
				maxL.textContent = fmt(maxR.value);
			}

			minR.addEventListener('input', function () {
				if (Number(minR.value) > Number(maxR.value)) { maxR.value = minR.value; }
				labels(); apply();
			});
			maxR.addEventListener('input', function () {
				if (Number(maxR.value) < Number(minR.value)) { minR.value = maxR.value; }
				labels(); apply();
			});
			search.addEventListener('input', apply);
			sortSel.addEventListener('change', apply);

			catWrap.addEventListener('click', function (e) {
				var btn = e.target.closest('.store-category-btn');
				if (!btn) { return; }
				cat = btn.getAttribute('data-category');
				[].slice.call(catWrap.querySelectorAll('.store-category-btn')).forEach(function (b) {
					var on = (b === btn);
					b.classList.toggle('active', on);
					b.setAttribute('aria-pressed', on ? 'true' : 'false');
					idle.forEach(function (cl) { b.classList.toggle(cl, !on); });
				});
				apply();
			});

			labels();
			apply();
		})();
		</script>
		<?php
	}
}