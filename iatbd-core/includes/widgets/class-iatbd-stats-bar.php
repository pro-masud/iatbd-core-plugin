<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class IATBD_Stats_Bar_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'iatbd_stats_bar'; }
    public function get_title()      { return 'IATBD Stats Bar'; }
    public function get_icon()       { return 'eicon-icon-box'; }
    public function get_categories() { return [ 'iatbd-addons' ]; }

    /* ── Helper: controls for one item ── */
    private function item_controls( $n, $icon, $title, $subtitle ) {

        $this->start_controls_section( "item_{$n}", [
            'label' => __( "Item {$n}", 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( "i{$n}_icon", [
            'label'       => __( 'Icon (Font Awesome class)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $icon,
            'description' => __( 'e.g. fas fa-microchip', 'iatbd' ),
        ] );

        $this->add_control( "i{$n}_title", [
            'label'   => __( 'Title', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $title,
        ] );

        $this->add_control( "i{$n}_subtitle", [
            'label'   => __( 'Subtitle', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $subtitle,
        ] );

        $this->end_controls_section();
    }

    protected function register_controls() {

        /* ── Section style ── */
        $this->start_controls_section( 'section_style', [
            'label' => __( 'Section', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'gradient_classes', [
            'label'       => __( 'Background Gradient (Tailwind)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => 'from-primary-700 via-primary-600 to-primary-500',
            'description' => 'Tailwind gradient classes (without bg-gradient-to-r)',
        ] );

        $this->add_control( 'show_pattern', [
            'label'        => __( 'Show Dot Pattern Overlay', 'iatbd' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->end_controls_section();

        /* ── 4 items ── */
        $this->item_controls( 1, 'fas fa-microchip',  'Machine data',       'PLC, HMI and drive signals' );
        $this->item_controls( 2, 'fas fa-wave-square', 'Early alerts',       'Condition monitoring' );
        $this->item_controls( 3, 'fas fa-eye',         'Visual inspection',  'Automated quality checks' );
        $this->item_controls( 4, 'fas fa-chart-line',  'Production insight', 'Clearer process trends' );
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $items = [];
        for ( $n = 1; $n <= 4; $n++ ) {
            $items[] = [
                'icon'     => esc_attr( $s["i{$n}_icon"] ),
                'title'    => esc_html( $s["i{$n}_title"] ),
                'subtitle' => esc_html( $s["i{$n}_subtitle"] ),
            ];
        }

        $gradient      = esc_attr( $s['gradient_classes'] );
        $show_pattern  = $s['show_pattern'] === 'yes';
        ?>

        <section class="relative py-12 bg-gradient-to-r <?php echo $gradient; ?> overflow-hidden">

            <?php if ( $show_pattern ) : ?>
            <div class="iatbd-stats-dot-pattern absolute inset-0 opacity-10 pointer-events-none"></div>
            <?php endif; ?>

            <div class="max-w-6xl mx-auto px-4 relative z-10">
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-6 text-center">

                    <?php foreach ( $items as $item ) : ?>
                    <div class="text-white">
                        <i class="<?php echo $item['icon']; ?> text-2xl mb-3"></i>
                        <p class="font-semibold"><?php echo $item['title']; ?></p>
                        <p class="text-sm text-primary-100"><?php echo $item['subtitle']; ?></p>
                    </div>
                    <?php endforeach; ?>

                </div>
            </div>

        </section>

        <?php
    }
}