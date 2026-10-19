<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class IATBD_Solutions_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'iatbd_solutions'; }
    public function get_title() {
		return esc_html__( 'IATBD Solutions', 'iatbd-core' );
	}
    public function get_icon()       { return 'eicon-gallery-grid'; }
    public function get_categories() { return [ 'iatbd-addons' ]; }

    /* ── Helper: controls for one card ── */
    private function card_controls( $n, $defaults ) {

        $this->start_controls_section( "card_{$n}", [
            'label' => __( "Card {$n}", 'iatbd-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( "c{$n}_image", [
            'label'   => __( 'Image', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => $defaults['image'] ],
        ] );

        $this->add_control( "c{$n}_image_alt", [
            'label'   => __( 'Image Alt Text', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $defaults['alt'],
        ] );

        $this->add_control( "c{$n}_icon", [
            'label'       => __( 'Icon (Font Awesome class)', 'iatbd-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['icon'],
            'description' => 'e.g. fas fa-wave-square',
        ] );

        $this->add_control( "c{$n}_icon_bg", [
            'label'       => __( 'Icon Badge BG (Tailwind)', 'iatbd-core' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['icon_bg'],
            'description' => 'e.g. bg-primary-600 / bg-accent-500 / bg-emerald-600',
        ] );

        $this->add_control( "c{$n}_title", [
            'label'   => __( 'Title', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $defaults['title'],
        ] );

        $this->add_control( "c{$n}_desc", [
            'label'   => __( 'Description', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => $defaults['desc'],
        ] );

        $this->end_controls_section();
    }

    protected function register_controls() {

        /* ── Section Header ── */
        $this->start_controls_section( 'section_header', [
            'label' => __( 'Section Header', 'iatbd-core' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'section_id', [
            'label'   => __( 'Section ID', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'solutions',
        ] );

        $this->add_control( 'eyebrow', [
            'label'   => __( 'Eyebrow Text', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'AI Applications',
        ] );

        $this->add_control( 'heading', [
            'label'   => __( 'Heading', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => 'Make machine data useful',
        ] );

        $this->add_control( 'description', [
            'label'   => __( 'Description', 'iatbd-core' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => 'Practical AI starts with reliable signals from your equipment. We help identify the right use case and connect it to your existing automation systems.',
        ] );

        $this->end_controls_section();

        /* ── 3 Cards ── */
        $this->card_controls( 1, [
            'image'   => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=900&q=85',
            'alt'     => 'Engineer checking industrial machinery',
            'icon'    => 'fas fa-wave-square',
            'icon_bg' => 'bg-primary-600',
            'title'   => 'Predictive maintenance',
            'desc'    => 'Surface changes in equipment behavior and help teams plan maintenance with better timing.',
        ] );

        $this->card_controls( 2, [
            'image'   => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=900&q=85',
            'alt'     => 'Industrial operator monitoring a production process',
            'icon'    => 'fas fa-eye',
            'icon_bg' => 'bg-accent-500',
            'title'   => 'Machine vision inspection',
            'desc'    => 'Flag visible defects and missing components with consistent, camera-based inspection.',
        ] );

        $this->card_controls( 3, [
            'image'   => 'https://images.unsplash.com/photo-1581092162384-8987c1d64718?auto=format&fit=crop&w=900&q=85',
            'alt'     => 'Technician working with factory control equipment',
            'icon'    => 'fas fa-chart-line',
            'icon_bg' => 'bg-emerald-600',
            'title'   => 'Production analytics',
            'desc'    => 'Connect PLC, HMI and drive data to make downtime, cycle and energy trends easier to see.',
        ] );
    }

    protected function render() {
        $s = $this->get_settings_for_display();

        $cards = [];
        for ( $n = 1; $n <= 3; $n++ ) {
            $cards[] = [
                'image'   => esc_url( $s["c{$n}_image"]['url'] ),
                'alt'     => esc_attr( $s["c{$n}_image_alt"] ),
                'icon'    => esc_attr( $s["c{$n}_icon"] ),
                'icon_bg' => esc_attr( $s["c{$n}_icon_bg"] ),
                'title'   => esc_html( $s["c{$n}_title"] ),
                'desc'    => esc_html( $s["c{$n}_desc"] ),
            ];
        }
        ?>

        <section
            id="<?php echo esc_attr( $s['section_id'] ); ?>"
            class="py-20 sm:py-24 bg-slate-50 dark:bg-slate-900/60"
        >
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <!-- Header -->
                <div class="max-w-2xl mb-12">
                    <p class="text-accent-500 text-xs font-semibold tracking-[0.2em] uppercase mb-2">
                        <?php echo esc_html( $s['eyebrow'] ); ?>
                    </p>
                    <h2 class="font-display text-3xl sm:text-4xl font-bold text-slate-900 dark:text-white mb-4">
                        <?php echo esc_html( $s['heading'] ); ?>
                    </h2>
                    <p class="text-[17px] leading-relaxed text-slate-600 dark:text-slate-300">
                        <?php echo esc_html( $s['description'] ); ?>
                    </p>
                </div>

                <!-- Cards -->
                <div class="grid md:grid-cols-3 gap-6">
                    <?php foreach ( $cards as $card ) : ?>
                    <article class="svc-card group relative aspect-[4/3] overflow-hidden rounded-xl bg-slate-900">

                        <img
                            src="<?php echo $card['image']; ?>"
                            alt="<?php echo $card['alt']; ?>"
                            class="absolute inset-0 h-full w-full object-cover"
                            loading="lazy"
                        />

                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950/90 via-slate-950/25 to-transparent"></div>

                        <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                            <span class="inline-flex w-10 h-10 items-center justify-center rounded-lg <?php echo $card['icon_bg']; ?> mb-3">
                                <i class="<?php echo $card['icon']; ?>"></i>
                            </span>
                            <h3 class="font-display text-xl font-bold mb-2">
                                <?php echo $card['title']; ?>
                            </h3>
                            <p class="text-sm leading-relaxed text-white/80">
                                <?php echo $card['desc']; ?>
                            </p>
                        </div>

                    </article>
                    <?php endforeach; ?>
                </div>

            </div>
        </section>

        <?php
    }
}