<?php
/**
 * GC Blog Archive
 * Elementor widget: hero + dynamic blog grid (WP posts) + pagination.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Blog_Archive_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_blog_archive';
	}

	public function get_title() {
		return esc_html__( 'GC Blog Archive', 'softro-core' );
	}

	public function get_icon() {
		return 'eicon-posts-grid';
	}

	public function get_categories() {
		return [ 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'blog', 'posts', 'archive', 'grid', 'gc' ];
	}

	private function get_category_options() {
		$options = [];
		$terms   = get_categories( [ 'hide_empty' => false ] );
		if ( ! is_wp_error( $terms ) ) {
			foreach ( $terms as $term ) {
				$options[ $term->term_id ] = $term->name;
			}
		}
		return $options;
	}

	protected function register_controls() {

		/* ---------- Hero ---------- */
		$this->start_controls_section( 'section_hero', [
			'label' => esc_html__( 'Hero', 'softro-core' ),
		] );

		$this->add_control( 'header_offset', [
			'label'        => esc_html__( 'Top spacing for fixed header', 'softro-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
			'description'  => esc_html__( 'Adds pt-24 / sm:pt-28 and pb-20 like the original main wrapper. Turn off if your theme already adds it.', 'softro-core' ),
		] );

		$this->add_control( 'hero_show', [
			'label'        => esc_html__( 'Show Hero', 'softro-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'breadcrumb_show', [
			'label'        => esc_html__( 'Show Breadcrumb Pill', 'softro-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'crumb_home_text', [
			'label'     => esc_html__( 'Home Text', 'softro-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Home',
			'condition' => [ 'breadcrumb_show' => 'yes' ],
		] );

		$this->add_control( 'crumb_home_link', [
			'label'     => esc_html__( 'Home Link', 'softro-core' ),
			'type'      => \Elementor\Controls_Manager::URL,
			'default'   => [ 'url' => '/' ],
			'condition' => [ 'breadcrumb_show' => 'yes' ],
		] );

		$this->add_control( 'crumb_current_text', [
			'label'     => esc_html__( 'Current Page Text', 'softro-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Blog',
			'condition' => [ 'breadcrumb_show' => 'yes' ],
		] );

		$this->add_control( 'hero_heading', [
			'label'   => esc_html__( 'Heading', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Our All Blog',
		] );

		$this->add_control( 'hero_subtitle', [
			'label'   => esc_html__( 'Subtitle', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => 'Explore the latest strategies, innovations, and agency thought leadership.',
		] );

		$this->end_controls_section();

		/* ---------- Query ---------- */
		$this->start_controls_section( 'section_query', [
			'label' => esc_html__( 'Blog Query', 'softro-core' ),
		] );

		$this->add_control( 'posts_per_page', [
			'label'   => esc_html__( 'Posts Per Page', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 1,
			'max'     => 60,
			'default' => 9,
		] );

		$this->add_control( 'categories', [
			'label'       => esc_html__( 'Categories (empty = all)', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::SELECT2,
			'multiple'    => true,
			'label_block' => true,
			'options'     => $this->get_category_options(),
		] );

		$this->add_control( 'orderby', [
			'label'   => esc_html__( 'Order By', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'date',
			'options' => [
				'date'          => esc_html__( 'Date', 'softro-core' ),
				'modified'      => esc_html__( 'Last Modified', 'softro-core' ),
				'title'         => esc_html__( 'Title', 'softro-core' ),
				'rand'          => esc_html__( 'Random', 'softro-core' ),
				'comment_count' => esc_html__( 'Comment Count', 'softro-core' ),
			],
		] );

		$this->add_control( 'order', [
			'label'   => esc_html__( 'Order', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'DESC',
			'options' => [
				'DESC' => esc_html__( 'Newest / Descending', 'softro-core' ),
				'ASC'  => esc_html__( 'Oldest / Ascending', 'softro-core' ),
			],
		] );

		$this->add_control( 'empty_text', [
			'label'   => esc_html__( 'No Posts Message', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'No blog posts found.',
		] );

		$this->end_controls_section();

		/* ---------- Card ---------- */
		$this->start_controls_section( 'section_card', [
			'label' => esc_html__( 'Blog Card', 'softro-core' ),
		] );

		$this->add_control( 'featured_mode', [
			'label'   => esc_html__( 'Featured Badge On', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::SELECT,
			'default' => 'first',
			'options' => [
				'none'   => esc_html__( 'None', 'softro-core' ),
				'first'  => esc_html__( 'First post on page 1', 'softro-core' ),
				'sticky' => esc_html__( 'Sticky posts', 'softro-core' ),
			],
		] );

		$this->add_control( 'featured_text', [
			'label'     => esc_html__( 'Badge Text', 'softro-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Featured',
			'condition' => [ 'featured_mode!' => 'none' ],
		] );

		$this->add_control( 'date_icon', [
			'label'   => esc_html__( 'Date Icon Class (Font Awesome)', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'far fa-calendar-alt',
		] );

		$this->add_control( 'date_format', [
			'label'       => esc_html__( 'Date Format', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'default'     => 'M d, Y',
			'description' => esc_html__( 'PHP date format, e.g. M d, Y', 'softro-core' ),
		] );

		$this->add_control( 'excerpt_words', [
			'label'   => esc_html__( 'Excerpt Words', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => 5,
			'max'     => 80,
			'default' => 24,
		] );

		$this->add_control( 'read_more_text', [
			'label'   => esc_html__( 'Button Text', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'Read More',
		] );

		$this->add_control( 'read_more_icon', [
			'label'   => esc_html__( 'Button Icon Class (Font Awesome)', 'softro-core' ),
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'fas fa-arrow-right',
		] );

		$this->add_control( 'fallback_image', [
			'label'       => esc_html__( 'Fallback Image URL', 'softro-core' ),
			'type'        => \Elementor\Controls_Manager::TEXT,
			'placeholder' => 'https://...',
			'description' => esc_html__( 'Used when a post has no featured image.', 'softro-core' ),
		] );

		$this->end_controls_section();

		/* ---------- Pagination ---------- */
		$this->start_controls_section( 'section_pagination', [
			'label' => esc_html__( 'Pagination', 'softro-core' ),
		] );

		$this->add_control( 'pagination_show', [
			'label'        => esc_html__( 'Show Pagination', 'softro-core' ),
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => 'yes',
		] );

		$this->add_control( 'prev_text', [
			'label'     => esc_html__( 'Previous Text', 'softro-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Prev',
			'condition' => [ 'pagination_show' => 'yes' ],
		] );

		$this->add_control( 'next_text', [
			'label'     => esc_html__( 'Next Text', 'softro-core' ),
			'type'      => \Elementor\Controls_Manager::TEXT,
			'default'   => 'Next',
			'condition' => [ 'pagination_show' => 'yes' ],
		] );

		$this->end_controls_section();
	}

	/**
	 * Page numbers to show: first, a window of 3 around current, last, with ellipses.
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

	protected function render() {
		$s = $this->get_settings_for_display();

		$paged = max( 1, (int) get_query_var( 'paged' ), (int) get_query_var( 'page' ) );

		$args = [
			'post_type'           => 'post',
			'post_status'         => 'publish',
			'posts_per_page'      => max( 1, (int) $s['posts_per_page'] ),
			'paged'               => $paged,
			'orderby'             => $s['orderby'],
			'order'               => $s['order'],
			'ignore_sticky_posts' => true,
		];
		if ( ! empty( $s['categories'] ) ) {
			$args['category__in'] = array_map( 'intval', (array) $s['categories'] );
		}

		$q     = new \WP_Query( $args );
		$total = (int) $q->max_num_pages;

		$wrap_class = ( 'yes' === $s['header_offset'] ) ? 'pt-24 sm:pt-28 pb-20' : '';

		$btn_base   = 'page-num-btn w-10 h-10 rounded-xl flex items-center justify-center text-sm font-medium bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all';
		$btn_active = 'page-num-btn active w-10 h-10 rounded-xl flex items-center justify-center text-sm font-semibold bg-primary-600 text-white shadow-lg shadow-primary-500/25 transition-all';
		$btn_nav    = 'page-num-btn px-4 h-10 rounded-xl flex items-center justify-center text-sm font-medium bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 text-slate-700 dark:text-slate-300 hover:border-primary-500 hover:text-primary-600 dark:hover:text-primary-400 transition-all gap-2';
		?>
		<div<?php echo $wrap_class ? ' class="' . esc_attr( $wrap_class ) . '"' : ''; ?>>

			<?php if ( 'yes' === $s['hero_show'] ) : ?>
				<section class="relative overflow-hidden pt-8 pb-12 sm:pb-16 text-center">
					<div class="absolute inset-0 -z-10 flex items-center justify-center pointer-events-none">
						<div class="w-[600px] h-[320px] bg-primary-500/10 dark:bg-primary-500/15 blur-[120px] rounded-full -translate-y-12"></div>
						<div class="w-[400px] h-[250px] bg-accent-500/10 dark:bg-accent-500/10 blur-[100px] rounded-full translate-x-32"></div>
					</div>

					<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
						<?php if ( 'yes' === $s['breadcrumb_show'] ) : ?>
							<?php
							$this->add_render_attribute( 'crumb_home', 'class', 'hover:text-primary-600 dark:hover:text-primary-400 transition-colors' );
							if ( ! empty( $s['crumb_home_link']['url'] ) ) {
								$this->add_link_attributes( 'crumb_home', $s['crumb_home_link'] );
							}
							?>
							<div class="inline-flex items-center justify-center mb-5">
								<div class="inline-flex items-center gap-2.5 px-4 py-1.5 rounded-full text-xs font-semibold bg-white/80 dark:bg-slate-900/90 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-800 shadow-sm backdrop-blur-md">
									<a <?php echo $this->get_render_attribute_string( 'crumb_home' ); ?>><?php echo esc_html( $s['crumb_home_text'] ); ?></a>
									<span class="w-1.5 h-1.5 rounded-full bg-primary-500"></span>
									<span class="text-primary-600 dark:text-primary-400 font-bold"><?php echo esc_html( $s['crumb_current_text'] ); ?></span>
								</div>
							</div>
						<?php endif; ?>

						<?php if ( ! empty( $s['hero_heading'] ) ) : ?>
							<h1 class="font-display text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 dark:text-white mb-4"><?php echo esc_html( $s['hero_heading'] ); ?></h1>
						<?php endif; ?>

						<?php if ( ! empty( $s['hero_subtitle'] ) ) : ?>
							<p class="text-slate-600 dark:text-slate-400 text-base sm:text-lg max-w-2xl mx-auto leading-relaxed"><?php echo esc_html( $s['hero_subtitle'] ); ?></p>
						<?php endif; ?>
					</div>
				</section>
			<?php endif; ?>

			<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4">

				<?php if ( $q->have_posts() ) : ?>
					<div id="blog-posts-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 sm:gap-8">
						<?php
						$index = 0;
						while ( $q->have_posts() ) :
							$q->the_post();

							$permalink = get_permalink();
							$title     = get_the_title();
							$img       = get_the_post_thumbnail_url( get_the_ID(), 'large' );
							if ( ! $img && ! empty( $s['fallback_image'] ) ) {
								$img = $s['fallback_image'];
							}

							$featured = (
								( 'first' === $s['featured_mode'] && 0 === $index && 1 === $paged ) ||
								( 'sticky' === $s['featured_mode'] && is_sticky() )
							);

							$excerpt = wp_trim_words( wp_strip_all_tags( get_the_excerpt() ), max( 5, (int) $s['excerpt_words'] ), '...' );
							?>
							<article class="blog-card group bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:shadow-2xl hover:border-primary-500/50 dark:hover:border-primary-500/50 transition-all duration-300 flex flex-col justify-between">
								<div class="p-4 sm:p-5">
									<a href="<?php echo esc_url( $permalink ); ?>" class="block relative aspect-[16/10] rounded-xl overflow-hidden bg-slate-100 dark:bg-slate-800 mb-4">
										<?php if ( $img ) : ?>
											<img src="<?php echo esc_url( $img ); ?>" alt="<?php echo esc_attr( $title ); ?>" loading="lazy" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" />
										<?php endif; ?>
										<div class="absolute inset-0 bg-gradient-to-t from-slate-950/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
										<?php if ( $featured && ! empty( $s['featured_text'] ) ) : ?>
											<span class="absolute top-3 left-3 px-2.5 py-1 rounded-md text-[10px] font-bold uppercase tracking-wider bg-slate-900/80 text-white backdrop-blur-md border border-white/10"><?php echo esc_html( $s['featured_text'] ); ?></span>
										<?php endif; ?>
									</a>

									<div class="flex items-center gap-2 text-xs font-medium text-slate-500 dark:text-slate-400 mb-2.5">
										<?php if ( ! empty( $s['date_icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $s['date_icon'] ); ?> text-primary-500 text-[11px]"></i>
										<?php endif; ?>
										<span><?php echo esc_html( get_the_date( $s['date_format'] ) ); ?></span>
									</div>

									<h2 class="font-display font-bold text-lg text-slate-900 dark:text-white line-clamp-2 leading-snug group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors">
										<a href="<?php echo esc_url( $permalink ); ?>"><?php echo esc_html( $title ); ?></a>
									</h2>

									<?php if ( $excerpt ) : ?>
										<p class="text-xs text-slate-600 dark:text-slate-400 mt-2.5 line-clamp-2 leading-relaxed"><?php echo esc_html( $excerpt ); ?></p>
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
							$index++;
						endwhile;
						wp_reset_postdata();
						?>
					</div>

					<?php if ( 'yes' === $s['pagination_show'] && $total > 1 ) : ?>
						<nav class="flex items-center justify-center gap-2 mt-12 sm:mt-16 flex-wrap" aria-label="<?php esc_attr_e( 'Blog pagination', 'softro-core' ); ?>">

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

				<?php else : ?>
					<?php wp_reset_postdata(); ?>
					<p class="text-center text-slate-600 dark:text-slate-400"><?php echo esc_html( $s['empty_text'] ); ?></p>
				<?php endif; ?>

			</section>
		</div>
		<?php
	}
}