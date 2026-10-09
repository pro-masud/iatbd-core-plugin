<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class IATBD_Benefits_Widget extends \Elementor\Widget_Base {

    public function get_name()  { return 'iatbd_benefits'; }
    public function get_title() { return 'IATBD Benefits'; }
    public function get_icon()  { return 'eicon-bullet-list'; }
    public function get_categories() { return [ 'iatbd-addons' ]; }

    /* ── Controls ── */
    protected function register_controls() {

        /* ── Section Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => __( 'Section Header', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow Text', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Benefits',
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => 'Why teams trust our servo work',
        ] );

        $this->end_controls_section();

        /* ── Card 1 ── */
        $this->start_controls_section( 'card_1', [
            'label' => __( 'Card 1', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_card_controls( 1,
            'fas fa-crosshairs',
            'Repeatable accuracy',
            'Closed-loop control keeps position and speed consistent cycle after cycle.',
            'bg-primary-100 dark:bg-primary-900/40 text-primary-600 dark:text-primary-400',
            'hover:border-primary-200 dark:hover:border-primary-700'
        );
        $this->end_controls_section();

        /* ── Card 2 ── */
        $this->start_controls_section( 'card_2', [
            'label' => __( 'Card 2', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_card_controls( 2,
            'fas fa-tachometer-alt',
            'Faster cycles',
            'High dynamic response shortens move times without sacrificing stability.',
            'bg-orange-100 dark:bg-orange-900/30 text-accent-500',
            'hover:border-accent-200 dark:hover:border-accent-700'
        );
        $this->end_controls_section();

        /* ── Card 3 ── */
        $this->start_controls_section( 'card_3', [
            'label' => __( 'Card 3', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_card_controls( 3,
            'fas fa-shield-alt',
            'Safer motion',
            'STO, limits and proper tuning reduce crash risk and mechanical stress.',
            'bg-emerald-100 dark:bg-emerald-900/30 text-emerald-600 dark:text-emerald-400',
            'hover:border-emerald-200 dark:hover:border-emerald-700'
        );
        $this->end_controls_section();

        /* ── Card 4 ── */
        $this->start_controls_section( 'card_4', [
            'label' => __( 'Card 4', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );
        $this->add_card_controls( 4,
            'fas fa-user-cog',
            'Brand-fluent team',
            'Siemens, Mitsubishi, Delta, Yaskawa and more — from design to repair.',
            'bg-purple-100 dark:bg-purple-900/30 text-purple-600 dark:text-purple-400',
            'hover:border-purple-200 dark:hover:border-purple-700'
        );
        $this->end_controls_section();
    }

    /* ── Helper: add icon + title + desc controls for one card ── */
    private function add_card_controls( $n, $default_icon, $default_title, $default_desc, $default_icon_class, $default_hover_class ) {

        $this->add_control( "card_{$n}_icon", [
            'label'       => __( 'Icon Class (Font Awesome)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $default_icon,
            'description' => __( 'e.g. fas fa-crosshairs', 'iatbd' ),
        ] );

        $this->add_control( "card_{$n}_icon_class", [
            'label'       => __( 'Icon Wrapper Tailwind Classes', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $default_icon_class,
            'description' => __( 'Tailwind classes for icon bg/color', 'iatbd' ),
        ] );

        $this->add_control( "card_{$n}_hover_class", [
            'label'       => __( 'Card Hover Border Classes', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'default'     => $default_hover_class,
            'description' => __( 'Tailwind hover border classes', 'iatbd' ),
        ] );

        $this->add_control( "card_{$n}_title", [
            'label'   => __( 'Title', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'default' => $default_title,
        ] );

        $this->add_control( "card_{$n}_desc", [
            'label'   => __( 'Description', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'default' => $default_desc,
            'rows'    => 3,
        ] );
    }

    /* ── Render ── */
    protected function render() {
        $s = $this->get_settings_for_display();

        $cards = [];
        for ( $i = 1; $i <= 4; $i++ ) {
            $cards[] = [
                'icon'        => esc_attr( $s[ "card_{$i}_icon" ] ),
                'icon_class'  => esc_attr( $s[ "card_{$i}_icon_class" ] ),
                'hover_class' => esc_attr( $s[ "card_{$i}_hover_class" ] ),
                'title'       => esc_html( $s[ "card_{$i}_title" ] ),
                'desc'        => esc_html( $s[ "card_{$i}_desc" ] ),
            ];
        }
        ?>
        <section class="py-20 sm:py-24 bg-white dark:bg-slate-950">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="text-center max-w-xl mx-auto mb-14">
                    <p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-3">
                        <?php echo esc_html( $s['eyebrow'] ); ?>
                    </p>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white">
                        <?php echo esc_html( $s['heading'] ); ?>
                    </h2>
                </div>

                <!-- Cards grid -->
                <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5">
                    <?php foreach ( $cards as $card ) : ?>
                    <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl p-6 border border-slate-200 dark:border-slate-800 text-center <?php echo $card['hover_class']; ?> transition">
                        <div class="w-16 h-16 mx-auto mb-4 rounded-2xl <?php echo $card['icon_class']; ?> flex items-center justify-center text-2xl">
                            <i class="<?php echo $card['icon']; ?>"></i>
                        </div>
                        <h3 class="font-semibold text-slate-900 dark:text-white mb-2">
                            <?php echo $card['title']; ?>
                        </h3>
                        <p class="text-[17px] text-slate-600 dark:text-slate-300 leading-relaxed">
                            <?php echo $card['desc']; ?>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>
        <?php
    }
}