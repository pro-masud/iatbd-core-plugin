<?php
/**
 * GC Blog Single
 * Elementor widget: single blog post layout (article + sticky sidebar), fully dynamic.
 *
 * Body = the post's own content (the_content). Everything else is read from the post,
 * its author, categories, tags and neighbouring posts. Static labels are widget controls.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class GC_Blog_Single_Widget extends \Elementor\Widget_Base {

	public function get_name() {
		return 'gc_blog_single';
	}

	public function get_title() {
		return esc_html__( 'IATBD Blog Single', 'iatbd-core' );
	}

	public function get_icon() {
		return 'eicon-single-post';
	}

	public function get_categories() {
		return [ 'iatbd-addons', 'gc_widgets' ];
	}

	public function get_keywords() {
		return [ 'blog', 'post', 'single', 'article', 'sidebar', 'gc' ];
	}

	/* ------------------------------------------------------------------
	 * Control helpers
	 * ---------------------------------------------------------------- */

	private function txt( $id, $label, $default = '', $cond = [], $extra = [] ) {
		$args = array_merge( [
			'label'   => $label,
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => $default,
		], $extra );
		if ( $cond ) {
			$args['condition'] = $cond;
		}
		$this->add_control( $id, $args );
	}

	private function area( $id, $label, $default = '', $cond = [] ) {
		$args = [
			'label'   => $label,
			'type'    => \Elementor\Controls_Manager::TEXTAREA,
			'default' => $default,
		];
		if ( $cond ) {
			$args['condition'] = $cond;
		}
		$this->add_control( $id, $args );
	}

	private function sw( $id, $label, $default = 'yes', $cond = [] ) {
		$args = [
			'label'        => $label,
			'type'         => \Elementor\Controls_Manager::SWITCHER,
			'return_value' => 'yes',
			'default'      => $default,
		];
		if ( $cond ) {
			$args['condition'] = $cond;
		}
		$this->add_control( $id, $args );
	}

	private function num( $id, $label, $default, $min = 1, $max = 20, $cond = [] ) {
		$args = [
			'label'   => $label,
			'type'    => \Elementor\Controls_Manager::NUMBER,
			'min'     => $min,
			'max'     => $max,
			'default' => $default,
		];
		if ( $cond ) {
			$args['condition'] = $cond;
		}
		$this->add_control( $id, $args );
	}

	private function url( $id, $label, $default = '', $cond = [] ) {
		$args = [
			'label'   => $label,
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => $default ],
		];
		if ( $cond ) {
			$args['condition'] = $cond;
		}
		$this->add_control( $id, $args );
	}

	private function socials_repeater( $id, $defaults ) {
		$r = new \Elementor\Repeater();
		$r->add_control( 'icon', [
			'label'   => 'Icon Class (Font Awesome)',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'fab fa-linkedin-in',
		] );
		$r->add_control( 'label', [
			'label'   => 'Aria Label',
			'type'    => \Elementor\Controls_Manager::TEXT,
			'default' => 'LinkedIn',
		] );
		$r->add_control( 'link', [
			'label'   => 'Link',
			'type'    => \Elementor\Controls_Manager::URL,
			'default' => [ 'url' => '#' ],
		] );
		$this->add_control( $id, [
			'label'       => 'Social Links',
			'type'        => \Elementor\Controls_Manager::REPEATER,
			'fields'      => $r->get_controls(),
			'title_field' => '{{{ label }}}',
			'default'     => $defaults,
		] );
	}

	/* ------------------------------------------------------------------
	 * Controls
	 * ---------------------------------------------------------------- */

	protected function register_controls() {

		/* ---- General ---- */
		$this->start_controls_section( 'sec_general', [ 'label' => 'General' ] );
		$this->sw( 'header_offset', 'Top spacing for fixed header' );
		$this->txt( 'post_id', 'Post ID (empty = current post)', '', [], [
			'description' => 'Leave empty on a Single Post template. Use an ID only to preview a specific post.',
		] );
		$this->txt( 'fallback_image', 'Fallback Image URL', '', [], [
			'description' => 'Used when a post has no featured image.',
		] );
		$this->sw( 'sidebar_show', 'Show Sidebar' );
		$this->end_controls_section();

		/* ---- Breadcrumb ---- */
		$this->start_controls_section( 'sec_breadcrumb', [ 'label' => 'Breadcrumb' ] );
		$this->txt( 'crumb_home_text', 'Home Text', 'Home' );
		$this->url( 'crumb_home_link', 'Home Link', '/' );
		$this->txt( 'crumb_blog_text', 'Blog Text', 'Blog' );
		$this->url( 'crumb_blog_link', 'Blog Link', '/blog/' );
		$this->end_controls_section();

		/* ---- Article header ---- */
		$this->start_controls_section( 'sec_header', [ 'label' => 'Article Header' ] );
		$this->sw( 'cat_show', 'Show Category Badge' );
		$this->txt( 'cat_icon', 'Category Icon Class', 'fas fa-bullhorn', [ 'cat_show' => 'yes' ] );
		$this->txt( 'written_by', 'Written By Label', 'Written by' );
		$this->txt( 'avatar_override', 'Author Avatar URL (overrides for all authors)', '' );
		$this->txt( 'date_icon', 'Date Icon Class', 'far fa-calendar-alt' );
		$this->txt( 'date_format', 'Date Format', 'M d, Y' );
		$this->sw( 'time_show', 'Show Reading Time' );
		$this->txt( 'time_icon', 'Reading Time Icon Class', 'far fa-clock', [ 'time_show' => 'yes' ] );
		$this->num( 'wpm', 'Words Per Minute', 200, 80, 500, [ 'time_show' => 'yes' ] );
		$this->txt( 'time_suffix', 'Reading Time Suffix', 'Min Read', [ 'time_show' => 'yes' ] );
		$this->sw( 'views_show', 'Show Views' );
		$this->txt( 'views_icon', 'Views Icon Class', 'far fa-eye', [ 'views_show' => 'yes' ] );
		$this->txt( 'views_label', 'Views Label', 'Views', [ 'views_show' => 'yes' ] );
		$this->txt( 'views_key', 'Views Meta Key', 'post_views_count', [ 'views_show' => 'yes' ] );
		$this->sw( 'views_count', 'Count a view on each page load', 'yes', [ 'views_show' => 'yes' ] );
		$this->sw( 'share_top_show', 'Show Share Buttons (top)' );
		$this->txt( 'share_label', 'Share Label', 'Share:', [], [ 'description' => 'Used for both share bars.' ] );
		$this->end_controls_section();

		/* ---- Hero image ---- */
		$this->start_controls_section( 'sec_hero', [ 'label' => 'Featured Image' ] );
		$this->txt( 'hero_caption_fallback', 'Caption Badge Fallback', '', [], [
			'description' => 'The image caption from the Media Library is used first. This text is used when it is empty. Leave both empty to hide the badge.',
		] );
		$this->end_controls_section();

		/* ---- Body ---- */
		$this->start_controls_section( 'sec_body', [ 'label' => 'Article Body' ] );
		$this->add_control( 'body_note', [
			'type' => \Elementor\Controls_Manager::RAW_HTML,
			'raw'  => 'The article body is the post content from the WordPress editor. Headings, paragraphs, lists, quotes, images and tables are styled automatically.',
		] );
		$this->end_controls_section();

		/* ---- Article footer ---- */
		$this->start_controls_section( 'sec_footer', [ 'label' => 'Tags & Share (bottom)' ] );
		$this->sw( 'tags_show', 'Show Tags' );
		$this->txt( 'tags_label', 'Tags Label', 'Tags:', [ 'tags_show' => 'yes' ] );
		$this->sw( 'share_bottom_show', 'Show Share Buttons (bottom)' );
		$this->end_controls_section();

		/* ---- Prev / Next ---- */
		$this->start_controls_section( 'sec_nav', [ 'label' => 'Previous / Next' ] );
		$this->sw( 'nav_show', 'Show Previous / Next Cards' );
		$this->txt( 'prev_label', 'Previous Label', 'Previous Article', [ 'nav_show' => 'yes' ] );
		$this->txt( 'next_label', 'Next Label', 'Next Article', [ 'nav_show' => 'yes' ] );
		$this->end_controls_section();

		/* ---- Author box ---- */
		$this->start_controls_section( 'sec_author', [ 'label' => 'Author Box' ] );
		$this->sw( 'author_box_show', 'Show Author Box' );
		$this->txt( 'role_key', 'Author Role (User Meta Key)', 'gc_author_role', [], [
			'description' => 'Reads this user meta field for the role/title. Falls back to the text below.',
		] );
		$this->txt( 'author_role_fallback', 'Author Role Fallback', 'Industrial Automation Engineer & Growth Consultant' );
		$this->area( 'author_bio_fallback', 'Author Bio Fallback', 'Specialized in industrial automation architectures, PLC/VFD troubleshooting, predictive maintenance, and strategic ROI attribution frameworks for tech-enabled enterprises across Bangladesh.' );
		$this->socials_repeater( 'author_socials', [
			[ 'icon' => 'fab fa-linkedin', 'label' => 'LinkedIn', 'link' => [ 'url' => '#' ] ],
			[ 'icon' => 'fab fa-x-twitter', 'label' => 'Twitter', 'link' => [ 'url' => '#' ] ],
			[ 'icon' => 'fab fa-github', 'label' => 'GitHub', 'link' => [ 'url' => '#' ] ],
		] );
		$this->end_controls_section();

		/* ---- Related ---- */
		$this->start_controls_section( 'sec_related', [ 'label' => 'Related Articles' ] );
		$this->sw( 'related_show', 'Show Related Articles' );
		$this->txt( 'related_heading', 'Heading', 'Related Articles', [ 'related_show' => 'yes' ] );
		$this->num( 'related_count', 'Number of Posts', 3, 1, 9, [ 'related_show' => 'yes' ] );
		$this->txt( 'related_view_all_text', 'View All Text', 'View All Blog', [ 'related_show' => 'yes' ] );
		$this->url( 'related_view_all_link', 'View All Link', '/blog/', [ 'related_show' => 'yes' ] );
		$this->txt( 'related_read_text', 'Read Link Text', 'Read Article →', [ 'related_show' => 'yes' ] );
		$this->end_controls_section();

		/* ---- Sidebar: Search ---- */
		$this->start_controls_section( 'sec_sb_search', [ 'label' => 'Sidebar: Search' ] );
		$this->sw( 'sb_search_show', 'Show Search' );
		$this->txt( 'sb_search_icon', 'Icon Class', 'fas fa-search', [ 'sb_search_show' => 'yes' ] );
		$this->txt( 'sb_search_heading', 'Heading', 'Search Articles', [ 'sb_search_show' => 'yes' ] );
		$this->txt( 'sb_search_placeholder', 'Placeholder', 'Search insights...', [ 'sb_search_show' => 'yes' ] );
		$this->end_controls_section();

		/* ---- Sidebar: Author ---- */
		$this->start_controls_section( 'sec_sb_author', [ 'label' => 'Sidebar: Author Profile' ] );
		$this->sw( 'sb_author_show', 'Show Author Profile' );
		$this->txt( 'sb_author_role_fallback', 'Role Fallback', 'Lead Automation & Growth Specialist', [ 'sb_author_show' => 'yes' ] );
		$this->area( 'sb_author_bio_fallback', 'Bio Fallback', 'Writing about industrial engineering, PLC systems, conversion funnels, and enterprise automation strategies.', [ 'sb_author_show' => 'yes' ] );
		$this->txt( 'sb_author_online', 'Online Dot Title', 'Online', [ 'sb_author_show' => 'yes' ], [ 'description' => 'Leave empty to hide the green dot.' ] );
		$this->socials_repeater( 'sb_author_socials', [
			[ 'icon' => 'fab fa-linkedin-in', 'label' => 'LinkedIn', 'link' => [ 'url' => '#' ] ],
			[ 'icon' => 'fab fa-x-twitter', 'label' => 'Twitter', 'link' => [ 'url' => '#' ] ],
			[ 'icon' => 'fas fa-envelope', 'label' => 'Email', 'link' => [ 'url' => 'mailto:info@iatbd.com' ] ],
		] );
		$this->end_controls_section();

		/* ---- Sidebar: Recent ---- */
		$this->start_controls_section( 'sec_sb_recent', [ 'label' => 'Sidebar: Recent Posts' ] );
		$this->sw( 'sb_recent_show', 'Show Recent Posts' );
		$this->txt( 'sb_recent_icon', 'Icon Class', 'fas fa-clock', [ 'sb_recent_show' => 'yes' ] );
		$this->txt( 'sb_recent_heading', 'Heading', 'Recent Posts', [ 'sb_recent_show' => 'yes' ] );
		$this->num( 'sb_recent_count', 'Number of Posts', 4, 1, 12, [ 'sb_recent_show' => 'yes' ] );
		$this->end_controls_section();

		/* ---- Sidebar: Categories ---- */
		$this->start_controls_section( 'sec_sb_cats', [ 'label' => 'Sidebar: Categories' ] );
		$this->sw( 'sb_cats_show', 'Show Categories' );
		$this->txt( 'sb_cats_icon', 'Icon Class', 'fas fa-folder-open', [ 'sb_cats_show' => 'yes' ] );
		$this->txt( 'sb_cats_heading', 'Heading', 'Categories', [ 'sb_cats_show' => 'yes' ] );
		$this->num( 'sb_cats_count', 'Number of Categories', 5, 1, 20, [ 'sb_cats_show' => 'yes' ] );
		$this->end_controls_section();

		/* ---- Sidebar: CTA ---- */
		$this->start_controls_section( 'sec_sb_cta', [ 'label' => 'Sidebar: CTA Card' ] );
		$this->sw( 'sb_cta_show', 'Show CTA Card' );
		$this->txt( 'sb_cta_badge', 'Badge', 'Complimentary Consultation', [ 'sb_cta_show' => 'yes' ] );
		$this->txt( 'sb_cta_title', 'Title', 'Need a Professional PPC or Automation Audit?', [ 'sb_cta_show' => 'yes' ] );
		$this->area( 'sb_cta_text', 'Description', 'Speak with our certified automation engineers and growth analysts to eliminate wasteful spend and maximize machinery uptime.', [ 'sb_cta_show' => 'yes' ] );
		$this->txt( 'sb_cta_btn_text', 'Button Text', 'Book a Discovery Call', [ 'sb_cta_show' => 'yes' ] );
		$this->url( 'sb_cta_btn_link', 'Button Link', '/contact/', [ 'sb_cta_show' => 'yes' ] );
		$this->end_controls_section();

		/* ---- Toast ---- */
		$this->start_controls_section( 'sec_toast', [ 'label' => 'Copy Link Toast' ] );
		$this->txt( 'toast_text', 'Toast Text', 'Article link copied to clipboard!' );
		$this->end_controls_section();
	}

	/* ------------------------------------------------------------------
	 * Render helpers
	 * ---------------------------------------------------------------- */

	private function format_views( $n ) {
		$n = (int) $n;
		if ( $n >= 1000 ) {
			return rtrim( rtrim( number_format( $n / 1000, 1 ), '0' ), '.' ) . 'k';
		}
		return (string) $n;
	}

	private function get_thumb( $post_id, $size, $fallback ) {
		$url = get_the_post_thumbnail_url( $post_id, $size );
		return $url ? $url : $fallback;
	}

	private function get_neighbours( $target ) {
		global $post;
		$backup = $post;
		$post   = $target; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		setup_postdata( $post );
		$prev = get_previous_post();
		$next = get_next_post();
		$post = $backup; // phpcs:ignore WordPress.WP.GlobalVariablesOverride
		if ( $backup ) {
			setup_postdata( $backup );
		} else {
			wp_reset_postdata();
		}
		return [ $prev, $next ];
	}

	private function render_share( $variant ) {
		$top    = 'w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-primary-50 dark:hover:bg-primary-950/40 text-slate-600 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 flex items-center justify-center transition text-xs';
		$bottom = 'w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-primary-600 hover:text-white dark:hover:bg-primary-600 dark:hover:text-white text-slate-600 dark:text-slate-300 flex items-center justify-center transition text-xs';
		$wa     = 'w-8 h-8 rounded-lg bg-slate-100 dark:bg-slate-800 hover:bg-emerald-600 hover:text-white dark:hover:bg-emerald-600 dark:hover:text-white text-slate-600 dark:text-slate-300 flex items-center justify-center transition text-xs';
		$cls    = ( 'top' === $variant ) ? $top : $bottom;
		?>
		<button type="button" onclick="shareArticle('facebook')" aria-label="Share on Facebook" class="<?php echo esc_attr( $cls ); ?>"><i class="fab fa-facebook-f"></i></button>
		<button type="button" onclick="shareArticle('linkedin')" aria-label="Share on LinkedIn" class="<?php echo esc_attr( $cls ); ?>"><i class="fab fa-linkedin-in"></i></button>
		<button type="button" onclick="shareArticle('twitter')" aria-label="Share on Twitter" class="<?php echo esc_attr( $cls ); ?>"><i class="fab fa-x-twitter"></i></button>
		<?php if ( 'bottom' === $variant ) : ?>
			<button type="button" onclick="shareArticle('whatsapp')" aria-label="Share on WhatsApp" class="<?php echo esc_attr( $wa ); ?>"><i class="fab fa-whatsapp"></i></button>
		<?php endif; ?>
		<button type="button" onclick="copyArticleLink()" aria-label="<?php echo 'top' === $variant ? 'Copy Link' : 'Copy article URL'; ?>" class="<?php echo esc_attr( $cls ); ?>"><i class="fas fa-link"></i></button>
		<?php
	}

	private function render_socials( $items, $prefix, $class ) {
		foreach ( (array) $items as $i => $item ) {
			$key = $prefix . $i;
			$this->add_render_attribute( $key, 'class', $class );
			if ( ! empty( $item['label'] ) ) {
				$this->add_render_attribute( $key, 'aria-label', $item['label'] );
			}
			if ( ! empty( $item['link']['url'] ) ) {
				$this->add_link_attributes( $key, $item['link'] );
			}
			?>
			<a <?php echo $this->get_render_attribute_string( $key ); ?>><i class="<?php echo esc_attr( $item['icon'] ); ?>"></i></a>
			<?php
		}
	}

	/* ------------------------------------------------------------------
	 * Render
	 * ---------------------------------------------------------------- */

	protected function render() {
		$s = $this->get_settings_for_display();

		$is_editor = \Elementor\Plugin::$instance->editor->is_edit_mode();

		$post_id = ! empty( $s['post_id'] ) ? (int) $s['post_id'] : (int) get_the_ID();
		$post    = $post_id ? get_post( $post_id ) : null;

		if ( ! $post ) {
			if ( $is_editor ) {
				echo '<p>' . esc_html__( 'IATBD Blog Single: no post found. Set a Post ID or use this widget in a Single Post template.', 'iatbd-core' ) . '</p>';
			}
			return;
		}

		$pid       = $post->ID;
		$title     = get_the_title( $post );
		$permalink = get_permalink( $post );
		$fallback  = $s['fallback_image'];

		/* Author */
		$author_id     = (int) $post->post_author;
		$author_name   = get_the_author_meta( 'display_name', $author_id );
		$author_avatar = ! empty( $s['avatar_override'] ) ? $s['avatar_override'] : get_avatar_url( $author_id, [ 'size' => 240 ] );
		$author_desc   = get_the_author_meta( 'description', $author_id );
		$author_role   = $s['role_key'] ? get_user_meta( $author_id, $s['role_key'], true ) : '';
		$box_role      = $author_role ? $author_role : $s['author_role_fallback'];
		$sb_role       = $author_role ? $author_role : $s['sb_author_role_fallback'];
		$box_bio       = $author_desc ? $author_desc : $s['author_bio_fallback'];
		$sb_bio        = $author_desc ? $author_desc : $s['sb_author_bio_fallback'];

		/* Category */
		$cats = get_the_category( $pid );
		$cat  = ! empty( $cats ) ? $cats[0] : null;

		/* Views */
		if (
			'yes' === $s['views_show'] && 'yes' === $s['views_count'] && ! empty( $s['views_key'] ) &&
			! $is_editor && ! \Elementor\Plugin::$instance->preview->is_preview_mode() &&
			is_singular() && (int) get_queried_object_id() === $pid
		) {
			update_post_meta( $pid, $s['views_key'], (int) get_post_meta( $pid, $s['views_key'], true ) + 1 );
		}
		$views = ! empty( $s['views_key'] ) ? (int) get_post_meta( $pid, $s['views_key'], true ) : 0;

		/* Reading time */
		$words = count( preg_split( '/\s+/u', trim( wp_strip_all_tags( $post->post_content ) ), -1, PREG_SPLIT_NO_EMPTY ) );
		$mins  = max( 1, (int) ceil( $words / max( 1, (int) $s['wpm'] ) ) );

		/* Hero image */
		$hero_img     = $this->get_thumb( $pid, 'full', $fallback );
		$hero_caption = get_the_post_thumbnail_caption( $pid );
		if ( ! $hero_caption ) {
			$hero_caption = $s['hero_caption_fallback'];
		}

		/* Meta items (separators only between visible items) */
		$meta = [];
		$meta[] = [ 'icon' => $s['date_icon'] . ' text-primary-500', 'text' => get_the_date( $s['date_format'], $post ), 'id' => 'article-date-text' ];
		if ( 'yes' === $s['time_show'] ) {
			$meta[] = [ 'icon' => $s['time_icon'] . ' text-accent-500', 'text' => $mins . ' ' . $s['time_suffix'], 'id' => 'article-read-time' ];
		}
		if ( 'yes' === $s['views_show'] ) {
			$meta[] = [ 'icon' => $s['views_icon'] . ' text-emerald-500', 'text' => $this->format_views( $views ) . ' ' . $s['views_label'], 'id' => '' ];
		}

		/* Tags */
		$tags = get_the_tags( $pid );

		/* Prev / next */
		list( $prev, $next ) = $this->get_neighbours( $post );

		/* Related */
		$related = [];
		if ( 'yes' === $s['related_show'] ) {
			$n       = max( 1, (int) $s['related_count'] );
			$cat_ids = wp_get_post_categories( $pid );
			if ( $cat_ids ) {
				$related = get_posts( [
					'numberposts'  => $n,
					'post__not_in' => [ $pid ],
					'category__in' => $cat_ids,
				] );
			}
			if ( count( $related ) < $n ) {
				$exclude = array_merge( [ $pid ], wp_list_pluck( $related, 'ID' ) );
				$related = array_merge( $related, get_posts( [
					'numberposts'  => $n - count( $related ),
					'post__not_in' => $exclude,
				] ) );
			}
		}

		$wrap_class = ( 'yes' === $s['header_offset'] ) ? 'pt-24 sm:pt-28 pb-20' : '';
		$article_cl = ( 'yes' === $s['sidebar_show'] ) ? 'lg:col-span-8' : 'lg:col-span-12';

		$body_class = 'space-y-8 text-sm sm:text-base text-slate-700 dark:text-slate-300 leading-relaxed '
			. '[&>p]:leading-relaxed [&>p_strong]:font-semibold [&>p_strong]:text-slate-900 dark:[&>p_strong]:text-white '
			. '[&>p>a]:text-primary-600 dark:[&>p>a]:text-primary-400 [&>p>a]:underline '
			. '[&>h2]:font-display [&>h2]:text-2xl sm:[&>h2]:text-3xl [&>h2]:font-bold [&>h2]:tracking-tight [&>h2]:text-slate-900 dark:[&>h2]:text-white '
			. '[&>h3]:font-display [&>h3]:text-xl sm:[&>h3]:text-2xl [&>h3]:font-bold [&>h3]:tracking-tight [&>h3]:text-slate-900 dark:[&>h3]:text-white '
			. '[&>h4]:font-display [&>h4]:text-lg [&>h4]:font-bold [&>h4]:text-slate-900 dark:[&>h4]:text-white '
			. '[&>ul]:list-disc [&>ul]:pl-6 [&>ul]:space-y-2 [&>ol]:list-decimal [&>ol]:pl-6 [&>ol]:space-y-2 '
			. '[&>ul>li>a]:text-primary-600 dark:[&>ul>li>a]:text-primary-400 [&>ul>li>a]:underline '
			. '[&>blockquote]:rounded-r-2xl [&>blockquote]:border-l-4 [&>blockquote]:border-primary-500 [&>blockquote]:bg-primary-50/70 dark:[&>blockquote]:bg-primary-950/40 [&>blockquote]:p-6 [&>blockquote]:italic '
			. '[&>figure>img]:rounded-2xl [&>figure>img]:max-w-full [&>figure>img]:h-auto [&>p>img]:rounded-2xl [&>p>img]:max-w-full [&>p>img]:h-auto '
			. '[&>figure>figcaption]:mt-2 [&>figure>figcaption]:text-center [&>figure>figcaption]:text-xs [&>figure>figcaption]:text-slate-500 dark:[&>figure>figcaption]:text-slate-400 '
			. '[&>figure.wp-block-table]:overflow-x-auto [&>figure.wp-block-table]:rounded-2xl [&>figure.wp-block-table]:border [&>figure.wp-block-table]:border-slate-200 dark:[&>figure.wp-block-table]:border-slate-800 [&>figure.wp-block-table]:bg-white dark:[&>figure.wp-block-table]:bg-slate-900 '
			. '[&>figure>table]:w-full [&>figure>table]:text-left [&>figure>table]:border-collapse [&>figure>table]:text-xs sm:[&>figure>table]:text-sm '
			. '[&>figure>table_th]:py-3.5 [&>figure>table_th]:px-4 [&>figure>table_th]:font-semibold [&>figure>table_th]:bg-slate-100/70 dark:[&>figure>table_th]:bg-slate-800/70 [&>figure>table_th]:text-slate-700 dark:[&>figure>table_th]:text-slate-300 [&>figure>table_th]:border-b [&>figure>table_th]:border-slate-200 dark:[&>figure>table_th]:border-slate-800 '
			. '[&>figure>table_td]:py-3.5 [&>figure>table_td]:px-4 [&>figure>table_td]:border-b [&>figure>table_td]:border-slate-100 dark:[&>figure>table_td]:border-slate-800/70 [&>figure>table_td]:text-slate-600 dark:[&>figure>table_td]:text-slate-300 '
			. '[&>table]:w-full [&>table]:text-left [&>table]:border-collapse [&>table]:text-xs sm:[&>table]:text-sm '
			. '[&>hr]:border-slate-200 dark:[&>hr]:border-slate-800';

		$icon_btn = 'w-8 h-8 rounded-full bg-slate-100 dark:bg-slate-800 hover:bg-primary-600 hover:text-white text-slate-600 dark:text-slate-300 flex items-center justify-center text-xs transition';
		?>
		<div<?php echo $wrap_class ? ' class="' . esc_attr( $wrap_class ) . '"' : ''; ?>>

			<!-- ARTICLE TOP HEADER -->
			<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-4 pb-6">

				<?php
				$this->add_render_attribute( 'crumb_home', 'class', 'hover:text-primary-600 dark:hover:text-primary-400 transition-colors' );
				if ( ! empty( $s['crumb_home_link']['url'] ) ) {
					$this->add_link_attributes( 'crumb_home', $s['crumb_home_link'] );
				}
				$this->add_render_attribute( 'crumb_blog', 'class', 'hover:text-primary-600 dark:hover:text-primary-400 transition-colors' );
				if ( ! empty( $s['crumb_blog_link']['url'] ) ) {
					$this->add_link_attributes( 'crumb_blog', $s['crumb_blog_link'] );
				}
				?>
				<nav class="flex items-center gap-2 text-xs text-slate-500 dark:text-slate-400 mb-6 flex-wrap" aria-label="Breadcrumb">
					<a <?php echo $this->get_render_attribute_string( 'crumb_home' ); ?>><?php echo esc_html( $s['crumb_home_text'] ); ?></a>
					<span>/</span>
					<a <?php echo $this->get_render_attribute_string( 'crumb_blog' ); ?>><?php echo esc_html( $s['crumb_blog_text'] ); ?></a>
					<span>/</span>
					<span id="breadcrumb-current" class="text-slate-800 dark:text-slate-200 font-medium truncate max-w-md"><?php echo esc_html( $title ); ?></span>
				</nav>

				<?php if ( 'yes' === $s['cat_show'] && $cat ) : ?>
					<div class="mb-4">
						<a href="<?php echo esc_url( get_category_link( $cat->term_id ) ); ?>" id="article-category-badge" class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-xs font-bold uppercase tracking-wider bg-primary-100 dark:bg-primary-950/80 text-primary-700 dark:text-primary-300 border border-primary-200 dark:border-primary-800/60">
							<?php if ( ! empty( $s['cat_icon'] ) ) : ?>
								<i class="<?php echo esc_attr( $s['cat_icon'] ); ?> text-[10px]"></i>
							<?php endif; ?>
							<span id="article-category-text"><?php echo esc_html( $cat->name ); ?></span>
						</a>
					</div>
				<?php endif; ?>

				<h1 id="article-main-title" class="font-display text-3xl sm:text-4xl lg:text-5xl font-extrabold text-slate-900 dark:text-white leading-[1.2] tracking-tight mb-6 max-w-5xl"><?php echo esc_html( $title ); ?></h1>

				<div class="flex flex-wrap items-center justify-between gap-4 py-4 border-y border-slate-200 dark:border-slate-800 text-xs sm:text-sm text-slate-600 dark:text-slate-400">
					<div class="flex items-center gap-4 flex-wrap">
						<div class="flex items-center gap-2.5">
							<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="w-9 h-9 rounded-full object-cover border border-primary-500/30" />
							<div>
								<?php if ( ! empty( $s['written_by'] ) ) : ?>
									<span class="text-[11px] block text-slate-400"><?php echo esc_html( $s['written_by'] ); ?></span>
								<?php endif; ?>
								<span id="article-author-name" class="font-semibold text-slate-900 dark:text-white"><?php echo esc_html( $author_name ); ?></span>
							</div>
						</div>

						<?php foreach ( $meta as $m ) : ?>
							<span class="hidden sm:inline text-slate-300 dark:text-slate-700">•</span>
							<div class="flex items-center gap-1.5">
								<i class="<?php echo esc_attr( $m['icon'] ); ?>"></i>
								<span<?php echo $m['id'] ? ' id="' . esc_attr( $m['id'] ) . '"' : ''; ?>><?php echo esc_html( $m['text'] ); ?></span>
							</div>
						<?php endforeach; ?>
					</div>

					<?php if ( 'yes' === $s['share_top_show'] ) : ?>
						<div class="flex items-center gap-2">
							<?php if ( ! empty( $s['share_label'] ) ) : ?>
								<span class="text-xs text-slate-400 hidden md:inline"><?php echo esc_html( $s['share_label'] ); ?></span>
							<?php endif; ?>
							<?php $this->render_share( 'top' ); ?>
						</div>
					<?php endif; ?>
				</div>
			</section>

			<!-- MAIN CONTENT: ARTICLE + SIDEBAR -->
			<section class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
				<div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">

					<!-- ARTICLE -->
					<article class="<?php echo esc_attr( $article_cl ); ?> space-y-8">

						<?php if ( $hero_img ) : ?>
							<div class="relative rounded-2xl sm:rounded-3xl overflow-hidden bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-800 shadow-xl">
								<img id="article-hero-img" src="<?php echo esc_url( $hero_img ); ?>" alt="<?php echo esc_attr( $title ); ?>" class="w-full aspect-[16/9] object-cover" />
								<?php if ( $hero_caption ) : ?>
									<div class="absolute bottom-3 right-4 px-3 py-1 rounded-md text-[11px] bg-slate-900/80 text-white backdrop-blur-md"><?php echo esc_html( wp_strip_all_tags( $hero_caption ) ); ?></div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<!-- Body -->
						<div id="article-body-content" class="<?php echo esc_attr( $body_class ); ?>">
							<?php
							static $in_content = false;
							if ( ! $in_content ) {
								$in_content = true;
								echo apply_filters( 'the_content', $post->post_content ); // phpcs:ignore WordPress.Security.EscapeOutput
								$in_content = false;
							}
							?>
						</div>

						<!-- Tags + share -->
						<?php
						$show_tags  = ( 'yes' === $s['tags_show'] && ! empty( $tags ) );
						$show_share = ( 'yes' === $s['share_bottom_show'] );
						if ( $show_tags || $show_share ) :
							?>
							<div class="pt-8 pb-6 border-t border-slate-200 dark:border-slate-800 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
								<div class="flex items-center gap-1.5 flex-wrap">
									<?php if ( $show_tags ) : ?>
										<?php if ( ! empty( $s['tags_label'] ) ) : ?>
											<span class="text-xs font-semibold text-slate-400 mr-1"><?php echo esc_html( $s['tags_label'] ); ?></span>
										<?php endif; ?>
										<?php foreach ( $tags as $tag ) : ?>
											<a href="<?php echo esc_url( get_tag_link( $tag->term_id ) ); ?>" class="px-2.5 py-1 rounded-lg text-xs bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 hover:text-primary-600 dark:hover:text-primary-400 transition">#<?php echo esc_html( preg_replace( '/\s+/u', '', $tag->name ) ); ?></a>
										<?php endforeach; ?>
									<?php endif; ?>
								</div>

								<?php if ( $show_share ) : ?>
									<div class="flex items-center gap-2">
										<?php if ( ! empty( $s['share_label'] ) ) : ?>
											<span class="text-xs text-slate-400"><?php echo esc_html( $s['share_label'] ); ?></span>
										<?php endif; ?>
										<?php $this->render_share( 'bottom' ); ?>
									</div>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<!-- Prev / Next -->
						<?php if ( 'yes' === $s['nav_show'] && ( $prev || $next ) ) : ?>
							<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2">
								<?php if ( $prev ) : ?>
									<a id="prev-post-link" href="<?php echo esc_url( get_permalink( $prev ) ); ?>" class="group p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all flex flex-col justify-between">
										<div class="flex items-center gap-2 text-xs text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
											<i class="fas fa-arrow-left text-[11px]"></i>
											<span><?php echo esc_html( $s['prev_label'] ); ?></span>
										</div>
										<h4 id="prev-post-title" class="font-display font-bold text-sm sm:text-base text-slate-900 dark:text-white line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"><?php echo esc_html( get_the_title( $prev ) ); ?></h4>
										<span class="text-[11px] text-slate-400 mt-2 block"><?php echo esc_html( get_the_date( $s['date_format'], $prev ) ); ?></span>
									</a>
								<?php else : ?>
									<div></div>
								<?php endif; ?>

								<?php if ( $next ) : ?>
									<a id="next-post-link" href="<?php echo esc_url( get_permalink( $next ) ); ?>" class="group p-4 sm:p-5 rounded-2xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 hover:border-primary-500 dark:hover:border-primary-500 transition-all flex flex-col justify-between text-right">
										<div class="flex items-center justify-end gap-2 text-xs text-slate-400 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors mb-2">
											<span><?php echo esc_html( $s['next_label'] ); ?></span>
											<i class="fas fa-arrow-right text-[11px]"></i>
										</div>
										<h4 id="next-post-title" class="font-display font-bold text-sm sm:text-base text-slate-900 dark:text-white line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"><?php echo esc_html( get_the_title( $next ) ); ?></h4>
										<span class="text-[11px] text-slate-400 mt-2 block"><?php echo esc_html( get_the_date( $s['date_format'], $next ) ); ?></span>
									</a>
								<?php endif; ?>
							</div>
						<?php endif; ?>

						<!-- Author bio box -->
						<?php if ( 'yes' === $s['author_box_show'] ) : ?>
							<div class="rounded-3xl p-6 sm:p-8 bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm flex flex-col sm:flex-row gap-5 items-center sm:items-start text-center sm:text-left">
								<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl object-cover border-2 border-primary-500/40 shadow-md flex-shrink-0" />
								<div class="space-y-2">
									<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-1">
										<div>
											<h3 class="font-display font-bold text-lg text-slate-900 dark:text-white"><?php echo esc_html( $author_name ); ?></h3>
											<?php if ( $box_role ) : ?>
												<p class="text-xs text-primary-600 dark:text-primary-400 font-medium"><?php echo esc_html( $box_role ); ?></p>
											<?php endif; ?>
										</div>
										<?php if ( ! empty( $s['author_socials'] ) ) : ?>
											<div class="flex items-center justify-center sm:justify-end gap-2 pt-1 sm:pt-0">
												<?php $this->render_socials( $s['author_socials'], 'author_social_', 'text-slate-400 hover:text-primary-600 text-sm' ); ?>
											</div>
										<?php endif; ?>
									</div>
									<?php if ( $box_bio ) : ?>
										<p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400 leading-relaxed"><?php echo esc_html( $box_bio ); ?></p>
									<?php endif; ?>
								</div>
							</div>
						<?php endif; ?>

						<!-- Related -->
						<?php if ( 'yes' === $s['related_show'] && ! empty( $related ) ) : ?>
							<?php
							$this->add_render_attribute( 'related_all', 'class', 'text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline flex items-center gap-1' );
							if ( ! empty( $s['related_view_all_link']['url'] ) ) {
								$this->add_link_attributes( 'related_all', $s['related_view_all_link'] );
							}
							?>
							<div class="space-y-5 pt-6">
								<div class="flex items-center justify-between">
									<h3 class="font-display font-bold text-xl sm:text-2xl text-slate-900 dark:text-white"><?php echo esc_html( $s['related_heading'] ); ?></h3>
									<?php if ( ! empty( $s['related_view_all_text'] ) ) : ?>
										<a <?php echo $this->get_render_attribute_string( 'related_all' ); ?>><?php echo esc_html( $s['related_view_all_text'] ); ?> <i class="fas fa-arrow-right text-[10px]"></i></a>
									<?php endif; ?>
								</div>

								<div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
									<?php foreach ( $related as $rp ) : ?>
										<?php $rimg = $this->get_thumb( $rp->ID, 'medium_large', $fallback ); ?>
										<article class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200 dark:border-slate-800 overflow-hidden shadow-sm hover:border-primary-500 transition-all flex flex-col justify-between">
											<div>
												<a href="<?php echo esc_url( get_permalink( $rp ) ); ?>" class="block aspect-[16/10] overflow-hidden bg-slate-100 dark:bg-slate-800">
													<?php if ( $rimg ) : ?>
														<img src="<?php echo esc_url( $rimg ); ?>" alt="<?php echo esc_attr( get_the_title( $rp ) ); ?>" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300" />
													<?php endif; ?>
												</a>
												<div class="p-4">
													<span class="text-[11px] text-slate-400 block mb-1"><?php echo esc_html( get_the_date( $s['date_format'], $rp ) ); ?></span>
													<h4 class="font-display font-bold text-sm text-slate-900 dark:text-white line-clamp-2 hover:text-primary-600 transition-colors">
														<a href="<?php echo esc_url( get_permalink( $rp ) ); ?>"><?php echo esc_html( get_the_title( $rp ) ); ?></a>
													</h4>
												</div>
											</div>
											<div class="p-4 pt-0">
												<a href="<?php echo esc_url( get_permalink( $rp ) ); ?>" class="text-xs font-semibold text-primary-600 dark:text-primary-400 hover:underline"><?php echo esc_html( $s['related_read_text'] ); ?></a>
											</div>
										</article>
									<?php endforeach; ?>
								</div>
							</div>
						<?php endif; ?>
					</article>

					<!-- SIDEBAR -->
					<?php if ( 'yes' === $s['sidebar_show'] ) : ?>
						<aside class="lg:col-span-4 space-y-6 lg:sticky lg:top-24">

							<?php if ( 'yes' === $s['sb_search_show'] ) : ?>
								<div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
									<h3 class="font-display font-bold text-sm sm:text-base text-slate-900 dark:text-white mb-3 flex items-center gap-2">
										<?php if ( ! empty( $s['sb_search_icon'] ) ) : ?>
											<i class="<?php echo esc_attr( $s['sb_search_icon'] ); ?> text-primary-500"></i>
										<?php endif; ?>
										<?php echo esc_html( $s['sb_search_heading'] ); ?>
									</h3>
									<form action="<?php echo esc_url( home_url( '/' ) ); ?>" method="GET" class="relative gc-sidebar-search-form">
										<input type="hidden" name="post_type" value="post" />
										<input type="text" name="s" value="<?php echo esc_attr( get_search_query() ); ?>" placeholder="<?php echo esc_attr( $s['sb_search_placeholder'] ); ?>" class="gc-sidebar-search-input w-full h-11 pl-4 pr-11 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm text-slate-800 dark:text-slate-100 placeholder-slate-400 focus:outline-none focus:border-primary-500" />
										<button type="submit" aria-label="Search" class="gc-sidebar-search-btn absolute right-1.5 top-1.5 w-8 h-8 rounded-lg bg-primary-600 text-white flex items-center justify-center text-xs hover:bg-primary-500 transition">
											<i class="fas fa-arrow-right"></i>
										</button>
									</form>
								</div>
							<?php endif; ?>

							<?php if ( 'yes' === $s['sb_author_show'] ) : ?>
								<div class="p-6 rounded-2xl sm:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm text-center">
									<div class="relative w-20 h-20 mx-auto mb-3.5">
										<img src="<?php echo esc_url( $author_avatar ); ?>" alt="<?php echo esc_attr( $author_name ); ?>" class="w-20 h-20 rounded-full object-cover border-2 border-primary-500 p-0.5 shadow-md" />
										<?php if ( ! empty( $s['sb_author_online'] ) ) : ?>
											<span class="absolute bottom-1 right-1 w-4 h-4 rounded-full bg-emerald-500 border-2 border-white dark:border-slate-900" title="<?php echo esc_attr( $s['sb_author_online'] ); ?>"></span>
										<?php endif; ?>
									</div>
									<h4 class="font-display font-bold text-base text-slate-900 dark:text-white"><?php echo esc_html( $author_name ); ?></h4>
									<?php if ( $sb_role ) : ?>
										<p class="text-xs text-primary-600 dark:text-primary-400 font-medium mb-3"><?php echo esc_html( $sb_role ); ?></p>
									<?php endif; ?>
									<?php if ( $sb_bio ) : ?>
										<p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-4"><?php echo esc_html( $sb_bio ); ?></p>
									<?php endif; ?>
									<?php if ( ! empty( $s['sb_author_socials'] ) ) : ?>
										<div class="flex items-center justify-center gap-2.5">
											<?php $this->render_socials( $s['sb_author_socials'], 'sb_social_', $icon_btn ); ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>

							<?php if ( 'yes' === $s['sb_recent_show'] ) : ?>
								<?php $recent = get_posts( [ 'numberposts' => max( 1, (int) $s['sb_recent_count'] ) ] ); ?>
								<?php if ( $recent ) : ?>
									<div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
										<div class="flex items-center justify-between pb-3.5 mb-3.5 border-b border-slate-100 dark:border-slate-800">
											<h3 class="font-display font-bold text-sm sm:text-base text-slate-900 dark:text-white flex items-center gap-2">
												<?php if ( ! empty( $s['sb_recent_icon'] ) ) : ?>
													<i class="<?php echo esc_attr( $s['sb_recent_icon'] ); ?> text-accent-500"></i>
												<?php endif; ?>
												<?php echo esc_html( $s['sb_recent_heading'] ); ?>
											</h3>
										</div>
										<div class="space-y-4">
											<?php foreach ( $recent as $rp ) : ?>
												<?php $thumb = $this->get_thumb( $rp->ID, 'thumbnail', $fallback ); ?>
												<a href="<?php echo esc_url( get_permalink( $rp ) ); ?>" class="flex gap-3 group items-center">
													<?php if ( $thumb ) : ?>
														<img src="<?php echo esc_url( $thumb ); ?>" alt="" class="w-14 h-14 rounded-xl object-cover flex-shrink-0 group-hover:scale-105 transition-transform" />
													<?php endif; ?>
													<div class="min-w-0 flex-1">
														<p class="text-[11px] text-slate-400 mb-0.5"><?php echo esc_html( get_the_date( $s['date_format'], $rp ) ); ?></p>
														<h5 class="font-display font-semibold text-xs sm:text-sm text-slate-900 dark:text-white line-clamp-2 group-hover:text-primary-600 dark:group-hover:text-primary-400 transition-colors"><?php echo esc_html( get_the_title( $rp ) ); ?></h5>
													</div>
												</a>
											<?php endforeach; ?>
										</div>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ( 'yes' === $s['sb_cats_show'] ) : ?>
								<?php
								$cat_list = get_categories( [
									'orderby'    => 'count',
									'order'      => 'DESC',
									'number'     => max( 1, (int) $s['sb_cats_count'] ),
									'hide_empty' => true,
								] );
								?>
								<?php if ( ! empty( $cat_list ) && ! is_wp_error( $cat_list ) ) : ?>
									<div class="p-5 sm:p-6 rounded-2xl sm:rounded-3xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-800 shadow-sm">
										<h3 class="font-display font-bold text-sm sm:text-base text-slate-900 dark:text-white mb-3.5 pb-2 border-b border-slate-100 dark:border-slate-800 flex items-center gap-2">
											<?php if ( ! empty( $s['sb_cats_icon'] ) ) : ?>
												<i class="<?php echo esc_attr( $s['sb_cats_icon'] ); ?> text-primary-500"></i>
											<?php endif; ?>
											<?php echo esc_html( $s['sb_cats_heading'] ); ?>
										</h3>
										<ul class="space-y-2 text-xs sm:text-sm">
											<?php foreach ( $cat_list as $c ) : ?>
												<li>
													<a href="<?php echo esc_url( get_category_link( $c->term_id ) ); ?>" class="flex items-center justify-between py-1.5 px-2 rounded-lg text-slate-600 dark:text-slate-300 hover:bg-slate-50 dark:hover:bg-slate-800 hover:text-primary-600 transition">
														<span><?php echo esc_html( $c->name ); ?></span>
														<span class="px-2 py-0.5 rounded-full text-[11px] bg-slate-100 dark:bg-slate-800 text-slate-500"><?php echo (int) $c->count; ?></span>
													</a>
												</li>
											<?php endforeach; ?>
										</ul>
									</div>
								<?php endif; ?>
							<?php endif; ?>

							<?php if ( 'yes' === $s['sb_cta_show'] ) : ?>
								<?php
								$this->add_render_attribute( 'sb_cta_btn', 'class', 'block text-center py-2.5 px-4 rounded-xl bg-white text-primary-700 font-bold text-xs hover:bg-primary-50 transition shadow-md' );
								if ( ! empty( $s['sb_cta_btn_link']['url'] ) ) {
									$this->add_link_attributes( 'sb_cta_btn', $s['sb_cta_btn_link'] );
								}
								?>
								<div class="p-6 rounded-2xl sm:rounded-3xl bg-gradient-to-br from-primary-600 via-primary-700 to-indigo-800 text-white shadow-xl relative overflow-hidden">
									<div class="relative z-10">
										<?php if ( ! empty( $s['sb_cta_badge'] ) ) : ?>
											<span class="inline-block px-2.5 py-1 rounded text-[10px] font-extrabold uppercase bg-white/20 backdrop-blur-md mb-2 tracking-wider"><?php echo esc_html( $s['sb_cta_badge'] ); ?></span>
										<?php endif; ?>
										<?php if ( ! empty( $s['sb_cta_title'] ) ) : ?>
											<h4 class="font-display font-bold text-lg text-white mb-2 leading-snug"><?php echo esc_html( $s['sb_cta_title'] ); ?></h4>
										<?php endif; ?>
										<?php if ( ! empty( $s['sb_cta_text'] ) ) : ?>
											<p class="text-xs text-primary-100 leading-relaxed mb-4"><?php echo esc_html( $s['sb_cta_text'] ); ?></p>
										<?php endif; ?>
										<?php if ( ! empty( $s['sb_cta_btn_text'] ) ) : ?>
											<a <?php echo $this->get_render_attribute_string( 'sb_cta_btn' ); ?>><?php echo esc_html( $s['sb_cta_btn_text'] ); ?></a>
										<?php endif; ?>
									</div>
								</div>
							<?php endif; ?>
						</aside>
					<?php endif; ?>
				</div>
			</section>

			<!-- COPY LINK TOAST -->
			<div id="copy-toast" class="fixed bottom-6 right-6 z-50 px-4 py-2.5 rounded-xl bg-slate-900 text-white text-xs font-semibold shadow-2xl border border-slate-700 flex items-center gap-2 transform translate-y-20 opacity-0 transition-all duration-300 pointer-events-none">
				<i class="fas fa-check-circle text-emerald-400"></i>
				<span><?php echo esc_html( $s['toast_text'] ); ?></span>
			</div>
		</div>
		<?php
	}
}