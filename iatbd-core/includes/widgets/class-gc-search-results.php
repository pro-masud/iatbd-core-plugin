<?php
/**
 * GC Search Results
 * Elementor widget: hero + search form + dynamic results grid + pagination + no-results state.
 * Styled to match the GC Blog Archive widget.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Search_Results_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_search_results';
	}

	public function get_title() {
		return esc_html__( 'IATBD Search Results', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-search-results';
	}

	public function get_categories() {
		return [ 'iatbd-addons', 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'search', 'results', 'find', 'gc' ];
	}

	private function get_post_type_options() {
		$options = [];
		$types   = get_post_types( [ 'public' => true ], 'objects' );
		foreach ( $types as $slug => $obj ) {
			if ( 'attachment' === $slug ) {
				continue;
			}
			$options[ $slug ] = $obj->labels->singular_name;
		}
		return $options;
	}

	protected function register_controls() {

		/* ---------- General ---------- */
		$this->start_controls_section( 'section_general', [ 'label' => 'General' ] );

		$this->add_control( 'header_offset', [
			'label'        => 'Top spacing for fixed header',
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'fallback_image', [
			'label'       => 'Fallback Image URL',
			'type'        => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'description' => 'Used when a result has no featured image.',
		] );

		$this->end_controls_section();

		/* ---------- Hero ---------- */
		$this->start_controls_section( 'section_hero', [ 'label' => 'Hero' ] );

		$this->add_control( 'breadcrumb_show', [
			'label'        => 'Show Breadcrumb Pill',
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'crumb_home_text', [
			'label'     => 'Home Text',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Home',
			'condition' => [ 'breadcrumb_show' => 'yes' ],
		] );

		$this->add_control( 'crumb_home_link', [
			'label'     => 'Home Link',
			'type'      => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default'   => [ 'url' => '/' ],
			'condition' => [ 'breadcrumb_show' => 'yes' ],
		] );

		$this->add_control( 'crumb_current_text', [
			'label'     => 'Current Page Text',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Search',
			'condition' => [ 'breadcrumb_show' => 'yes' ],
		] );

		$this->add_control( 'heading_prefix', [
			'label'   => 'Heading (with search term)',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Search Results for:',
		] );

		$this->add_control( 'heading_empty', [
			'label'   => 'Heading (no search term)',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Search Our Blog',
		] );

		$this->add_control( 'subtitle_found', [
			'label'       => 'Subtitle (results found)',
			'type'        => \Elementor\Controls_Manager::TEXTAREA,
			'default'     => '{count} result(s) found for your search.',
			'description' => 'Use {count} and {query}.',
		] );

		$this->add_control( 'subtitle_none', [
			'label'   => 'Subtitle (no results)',
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'We could not find anything matching your search.',
		] );

		$this->add_control( 'subtitle_empty', [
			'label'   => 'Subtitle (no search term)',
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Type a keyword below to explore our latest articles and pages.',
		] );

		$this->end_controls_section();

		/* ---------- Search form ---------- */
		$this->start_controls_section( 'section_form', [ 'label' => 'Search Form' ] );

		$this->add_control( 'form_show', [
			'label'        => 'Show Search Form',
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'form_icon', [
			'label'     => 'Input Icon Class',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'fas fa-search',
			'condition' => [ 'form_show' => 'yes' ],
		] );

		$this->add_control( 'form_placeholder', [
			'label'     => 'Placeholder',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Search articles, topics, services...',
			'condition' => [ 'form_show' => 'yes' ],
		] );

		$this->add_control( 'form_button', [
			'label'     => 'Button Text',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Search',
			'condition' => [ 'form_show' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------- Query ---------- */
		$this->start_controls_section( 'section_query', [ 'label' => 'Search Query' ] );

		$this->add_control( 'post_types', [
			'label'       => 'Search In',
			'type'        => \Elementor\Controls_Manager::SELECT2,
			'multiple'    => true,
			'label_block' => true,
			'options'     => $this->get_post_type_options(),
			'default'     => [ 'post' ],
		] );

		$this->add_control( 'posts_per_page', [
			'label'   => 'Results Per Page',
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 60,
			'default' => 9,
		] );

		$this->add_control( 'orderby', [
			'label'   => 'Order By',
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'relevance',
			'options' => [
				'relevance' => 'Relevance',
				'date'      => 'Newest first',
				'title'     => 'Title (A-Z)',
			],
		] );

		$this->end_controls_section();

		/* ---------- Card ---------- */
		$this->start_controls_section( 'section_card', [ 'label' => 'Result Card' ] );

		$this->add_control( 'type_badge', [
			'label'        => 'Show Content Type Badge',
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'highlight', [
			'label'        => 'Highlight Search Term',
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'date_icon', [
			'label'   => 'Date Icon Class',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'far fa-calendar-alt',
		] );

		$this->add_control( 'date_format', [
			'label'   => 'Date Format',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'M d, Y',
		] );

		$this->add_control( 'excerpt_words', [
			'label'   => 'Excerpt Words',
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 5,
			'max'     => 80,
			'default' => 24,
		] );

		$this->add_control( 'read_more_text', [
			'label'   => 'Button Text',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Read More',
		] );

		$this->add_control( 'read_more_icon', [
			'label'   => 'Button Icon Class',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'fas fa-arrow-right',
		] );

		$this->end_controls_section();

		/* ---------- Pagination ---------- */
		$this->start_controls_section( 'section_pagination', [ 'label' => 'Pagination' ] );

		$this->add_control( 'pagination_show', [
			'label'        => 'Show Pagination',
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'prev_text', [
			'label'     => 'Previous Text',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Prev',
			'condition' => [ 'pagination_show' => 'yes' ],
		] );

		$this->add_control( 'next_text', [
			'label'     => 'Next Text',
			'type'      => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default'   => 'Next',
			'condition' => [ 'pagination_show' => 'yes' ],
		] );

		$this->end_controls_section();

		/* ---------- No results ---------- */
		$this->start_controls_section( 'section_empty', [ 'label' => 'No Results State' ] );

		$this->add_control( 'empty_icon', [
			'label'   => 'Icon Class',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'fas fa-magnifying-glass',
		] );

		$this->add_control( 'empty_title', [
			'label'   => 'Title',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'No results found',
		] );

		$this->add_control( 'empty_text', [
			'label'   => 'Text',
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Try different keywords, check your spelling, or browse all our articles.',
		] );

		$this->add_control( 'empty_btn_text', [
			'label'   => 'Button Text',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'label_block' => true,
			'default' => 'Browse All Blog',
		] );

		$this->add_control( 'empty_btn_link', [
			'label'   => 'Button Link',
			'type'    => \Elementor\Controls_Manager::URL,
			'label_block' => true,
			'default' => [ 'url' => '/blog/' ],
		] );

		$this->end_controls_section();
	}

	/**
	 * First page, window of 3 around current, last page, with ellipses.
	 */
	private function get_page_items( $current, $total ) {
		if ( $total < 1 ) {
			return [];
		}
		$start = max( 1, min( $current - 1, $total - 2 ) );
		$end   = min( $total, $start + 2 );
		$pages = array_unique( array_merge( [ 1 ], range( $start, $end ), [ $total ] ) );
		sort( $pages );

		$items = [];
		$prev  = 0;
		foreach ( $pages as $p ) {
			if ( $prev && $p - $prev > 1 ) {
				$items[] = 'dots';
			}
			$items[] = $p;
			$prev    = $p;
		}
		return $items;
	}

	/**
	 * Escape text and wrap every search word in <mark>.
	 */
	private function highlight( $text, $term, $enabled ) {
		$safe = esc_html( $text );
		if ( ! $enabled || '' === $term ) {
			return $safe;
		}
		$words = array_filter( preg_split( '/\s+/u', $term, -1, PREG_SPLIT_NO_EMPTY ) );
		if ( empty( $words ) ) {
			return $safe;
		}
		$parts = [];
		foreach ( $words as $w ) {
			$parts[] = preg_quote( esc_html( $w ), '/' );
		}
		$pattern = '/(' . implode( '|', $parts ) . ')/iu';
		$result  = preg_replace( $pattern, '<mark class="bg-primary-100 dark:bg-primary-900/50 text-inherit rounded px-0.5">$1</mark>', $safe );
		return null === $result ? $safe : $result;
	}

	protected function render() {
		$s = $this->get_settings_for_display();

		$term  = '';
		if ( isset( $_GET['s'] ) ) { // phpcs:ignore WordPress.Security.NonceVerification
			$term = sanitize_text_field( wp_unslash( $_GET['s'] ) ); // phpcs:ignore WordPress.Security.NonceVerification
		} elseif ( get_search_query() ) {
			$term = get_search_query();
		}
		$term = trim( $term );

		$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

		$types = ! empty( $s['post_types'] ) ? (array) $s['post_types'] : [ 'post' ];

		$q     = null;
		$total = 0;
		$found = 0;

		if ( '' !== $term ) {
			$args = [
				'post_type'           => $types,
				'post_status'         => 'publish',
				's'                   => $term,
				'posts_per_page'      => max( 1, (int) $s['posts_per_page'] ),
				'paged'               => $paged,
				'ignore_sticky_posts' => true,
			];
			if ( 'date' === $s['orderby'] ) {
				$args['orderby'] = 'date';
				$args['order']   = 'DESC';
			} elseif ( 'title' === $s['orderby'] ) {
				$args['orderby'] = 'title';
				$args['order']   = 'ASC';
			} else {
				$args['orderby'] = 'relevance';
			}

			$q     = new \WP_Query( $args );
			$total = (int) $q->max_num_pages;
			$found = (int) $q->found_posts;
		}

		$wrap_class = ( 'yes' === $s['header_offset'] ) ? 'pt-24 sm:pt-28 pb-20' : '';
		$hl         = ( 'yes' === $s['highlight'] );

		$btn_base   = 'page-num-btn w-10 h-10 rounded-xl flex items-center justify-center text-sm font-medium bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all';
		$btn_active = 'page-num-btn active w-10 h-10 rounded-xl flex items-center justify-center text-sm font-semibold bg-primary-600 text-white shadow-lg shadow-primary-500/25 transition-all';
		$btn_nav    = 'page-num-btn px-4 h-10 rounded-xl flex items-center justify-center text-sm font-medium bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all gap-2';

		/* Subtitle */
		if ( '' === $term ) {
			$subtitle = $s['subtitle_empty'];
		} elseif ( $found > 0 ) {
			$subtitle = str_replace( [ '{count}', '{query}' ], [ number_format_i18n( $found ), $term ], $s['subtitle_found'] );
		} else {
			$subtitle = $s['subtitle_none'];
		}

		$this->add_render_attribute( 'crumb_home', 'class', 'hover:text-primary-600 dark:hover:text-primary-400 transition-colors' );
		if ( ! empty( $s['crumb_home_link']['url'] ) ) {
			$this->add_link_attributes( 'crumb_home', $s['crumb_home_link'] );
		}
		?>
		<div class="gc-search-results-widget<?php echo $wrap_class ? ' ' . esc_attr( $wrap_class ) : ''; ?>">

			<!-- HERO -->
			<section class="relative overflow-hidden pt-8 pb-10 sm:pb-12 text-center">
				<div class="absolute inset-0 -z-10 flex items-center justify-center pointer-events-none">
					<div class="w-[600px] h-[320px] bg-primary-500/10 dark:bg-primary-500/15 blur-[120px] rounded-full -translate-y-12"></div>
					<div class="w-[400px] h-[250px] bg-accent-500/10 dark:bg-accent-500/10 blur-[100px] rounded-full translate-x-32"></div>
				</div>

				<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
					<?php if ( 'yes' === $s['breadcrumb_show'] ) : ?>
						<div class="inline-flex items-center justify-center mb-5">
							<div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-white/80 dark:bg-slate-900/90 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 shadow-sm backdrop-blur-md">
								<a <?php echo $this->get_render_attribute_string( 'crumb_home' ); ?>><?php echo esc_html( $s['crumb_home_text'] ); ?></a>
								<span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
								<span class="text-primary-600 dark:text-primary-400 font-bold"><?php echo esc_html( $s['crumb_current_text'] ); ?></span>
							</div>
						</div>
					<?php endif; ?>

					<h1 class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-4">
						<?php if ( '' !== $term ) : ?>
							<?php echo esc_html( $s['heading_prefix'] ); ?>
							<span class="text-primary-600 dark:text-primary-400"><?php echo esc_html( $term ); ?></span>
						<?php else : ?>
							<?php echo esc_html( $s['heading_empty'] ); ?>
						<?php endif; ?>
					</h1>

					<?php if ( $subtitle ) : ?>
						<p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed"><?php echo esc_html( $subtitle ); ?></p>
					<?php endif; ?>

					<?php if ( 'yes' === $s['form_show'] ) : ?>
						<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET" role="search" class="gc-search-form mt-8 max-w-xl mx-auto">
							<?php if ( 1 === count( $types ) ) : ?>
								<input type="hidden" name="post_type" value="<?php echo esc_attr( $types[0] ); ?>" />
							<?php endif; ?>
							<div class="gc-search-input-wrap relative">
								<?php if ( ! empty( $s['form_icon'] ) ) : ?>
									<i class="<?php echo esc_attr( $s['form_icon'] ); ?> gc-search-icon absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 text-sm pointer-events-none"></i>
								<?php endif; ?>
								<input type="search" name="s" value="<?php echo esc_attr( $term ); ?>" placeholder="<?php echo esc_attr( $s['form_placeholder'] ); ?>" class="gc-search-input w-full h-14 pl-11 pr-32 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-primary-500" />
								<button type="submit" class="gc-search-btn absolute right-2 top-2 h-10 px-5 rounded-xl bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold shadow-lg shadow-primary-500/20 transition">
									<?php echo esc_html( $s['form_button'] ); ?>
								</button>
							</div>
						</form>
					<?php endif; ?>
				</div>
			</section>

			<!-- RESULTS -->
			<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">

				<?php if ( $q && $q->have_posts() ) : ?>
					<div id="search-results-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
						<?php
						while ( $q->have_posts() ) :
							$q->the_post();

							$permalink = get_permalink();
							$title     = get_the_title();
							$img       = get_the_post_thumbnail_url( get_the_ID(), 'large' );
							if ( ! $img && ! empty( $s['fallback_image'] ) ) {
								$img = $s['fallback_image'];
							}

							$type_obj = get_post_type_object( get_post_type() );
							$type_lbl = $type_obj ? $type_obj->labels->singular_name : '';

							$excerpt = get_the_excerpt();
							if ( '' === trim( $excerpt ) ) {
								$excerpt = strip_shortcodes( get_the_content() );
							}
							$excerpt = wp_trim_words( wp_strip_all_tags( $excerpt ), max( 5, (int) $s['excerpt_words'] ), '...' );
							?>
							<article class="blog-card group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-2xl hover:border-primary-500/50 dark:hover:border-primary-500/50 transition-all duration-300 flex flex-col justify-between">
								<div class="p-4 sm:p-5">
									<a href="<?php echo esc_url( $permalink ); ?>" class="block relative aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 mb-4">
										<?php if ( $img ) : ?>
											<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
										<?php endif; ?>
										<div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
										<?php if ( 'yes' === $s['type_badge'] && $type_lbl ) : ?>
											<span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-md border border-white/10"><?php echo esc_html( $type_lbl ); ?></span>
										<?php endif; ?>
									</a>

									<div class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400 mb-2.5">
										<?php if ( ! empty( $s['date_icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $s['date_icon'] ); ?> text-primary-500 text-[11px]"></i>
										<?php endif; ?>
										<span><?php echo esc_html( get_the_date( $s['date_format'] ) ); ?></span>
									</div>

									<h2 class="font-display font-bold text-lg text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
										<a href="<?php echo esc_url( $permalink ); ?>"><?php echo wp_kses( $this->highlight( $title, $term, $hl ), [ 'mark' => [ 'class' => [] ] ] ); ?></a>
									</h2>

									<?php if ( $excerpt ) : ?>
										<p class="text-xs text-slate-600 dark:text-slate-400 mt-2.5 line-clamp-2 leading-relaxed"><?php echo wp_kses( $this->highlight( $excerpt, $term, $hl ), [ 'mark' => [ 'class' => [] ] ] ); ?></p>
									<?php endif; ?>
								</div>

								<div class="px-4 sm:px-5 pb-5 pt-0">
									<a href="<?php echo esc_url( $permalink ); ?>" class="read-more-btn inline-flex items-center gap-2 px-4 py-2.5 rounded-xl text-xs font-semibold bg-primary-50 dark:bg-primary-950/50 text-primary-600 dark:text-primary-400 border border-primary-200 dark:border-primary-800 hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 dark:hover:text-white transition-all duration-200">
										<?php echo esc_html( $s['read_more_text'] ); ?>
										<?php if ( ! empty( $s['read_more_icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $s['read_more_icon'] ); ?> text-[10px]"></i>
										<?php endif; ?>
									</a>
								</div>
							</article>
							<?php
						endwhile;
						wp_reset_postdata();
						?>
					</div>

					<?php if ( 'yes' === $s['pagination_show'] && $total > 1 ) : ?>
						<nav class="flex items-center justify-center gap-2 mt-12 sm:mt-16 flex-wrap" aria-label="<?php esc_attr_e( 'Search pagination', 'iatbd-core' ); ?>">

							<?php if ( $paged > 1 ) : ?>
								<a href="<?php echo esc_url( get_pagenum_link( $paged - 1 ) ); ?>" class="<?php echo esc_attr( $btn_nav ); ?>">
									<i class="fas fa-chevron-left text-xs"></i>
									<span><?php echo esc_html( $s['prev_text'] ); ?></span>
								</a>
							<?php endif; ?>

							<?php foreach ( $this->get_page_items( $paged, $total ) as $item ) : ?>
								<?php if ( 'dots' === $item ) : ?>
									<span class="w-8 h-10 flex items-center justify-center text-slate-400 dark:text-slate-500 text-sm font-bold">...</span>
								<?php elseif ( (int) $item === $paged ) : ?>
									<span class="<?php echo esc_attr( $btn_active ); ?>" aria-current="page"><?php echo (int) $item; ?></span>
								<?php else : ?>
									<a href="<?php echo esc_url( get_pagenum_link( $item ) ); ?>" class="<?php echo esc_attr( $btn_base ); ?>"><?php echo (int) $item; ?></a>
								<?php endif; ?>
							<?php endforeach; ?>

							<?php if ( $paged < $total ) : ?>
								<a href="<?php echo esc_url( get_pagenum_link( $paged + 1 ) ); ?>" class="<?php echo esc_attr( $btn_nav ); ?>">
									<span><?php echo esc_html( $s['next_text'] ); ?></span>
									<i class="fas fa-chevron-right text-xs"></i>
								</a>
							<?php endif; ?>
						</nav>
					<?php endif; ?>

				<?php elseif ( '' !== $term ) : ?>
					<?php
					wp_reset_postdata();
					$this->add_render_attribute( 'empty_btn', 'class', 'inline-flex items-center justify-center gap-2 px-6 py-3 rounded-xl bg-primary-600 hover:bg-primary-500 text-white text-sm font-semibold shadow-lg shadow-primary-600/20 transition' );
					if ( ! empty( $s['empty_btn_link']['url'] ) ) {
						$this->add_link_attributes( 'empty_btn', $s['empty_btn_link'] );
					}
					?>
					<div class="max-w-xl mx-auto text-center rounded-3xl border border-slate-200 dark:border-slate-800 bg-white dark:bg-slate-900 p-8 sm:p-12 shadow-sm">
						<?php if ( ! empty( $s['empty_icon'] ) ) : ?>
							<span class="mx-auto mb-5 flex h-16 w-16 items-center justify-center rounded-2xl bg-primary-50 dark:bg-primary-500/10 text-primary-600 dark:text-primary-400 text-2xl"><i class="<?php echo esc_attr( $s['empty_icon'] ); ?>"></i></span>
						<?php endif; ?>
						<?php if ( ! empty( $s['empty_title'] ) ) : ?>
							<h2 class="font-display text-xl sm:text-2xl font-bold text-slate-900 dark:text-white"><?php echo esc_html( $s['empty_title'] ); ?></h2>
						<?php endif; ?>
						<?php if ( ! empty( $s['empty_text'] ) ) : ?>
							<p class="mt-3 text-sm leading-relaxed text-slate-600 dark:text-slate-400"><?php echo esc_html( $s['empty_text'] ); ?></p>
						<?php endif; ?>
						<?php if ( ! empty( $s['empty_btn_text'] ) ) : ?>
							<div class="mt-6">
								<a <?php echo $this->get_render_attribute_string( 'empty_btn' ); ?>><?php echo esc_html( $s['empty_btn_text'] ); ?> <i class="fas fa-arrow-right text-xs"></i></a>
							</div>
						<?php endif; ?>
					</div>
				<?php endif; ?>

			</section>
		</div>
		<?php
	}
}