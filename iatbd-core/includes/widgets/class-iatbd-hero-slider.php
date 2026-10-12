<?php
if ( ! defined( 'ABSPATH' ) ) exit;

class IATBD_Hero_Slider_Widget extends \Elementor\Widget_Base {

    public function get_name()       { return 'iatbd_hero_slider'; }
    public function get_title()      { return 'IATBD Hero Slider'; }
    public function get_icon()       { return 'eicon-slides'; }
    public function get_categories() { return [ 'iatbd-addons' ]; }

    /* ────────────────────────────────────────────
       HELPER — adds all controls for one slide
    ──────────────────────────────────────────── */
    private function slide_controls( $n, $defaults ) {

        $this->start_controls_section( "slide_{$n}", [
            'label' => __( "Slide {$n}", 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( "s{$n}_bg_image", [
            'label'   => __( 'Background Image', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::MEDIA,
            'default' => [ 'url' => $defaults['bg'] ],
        ] );

        $this->add_control( "s{$n}_gradient", [
            'label'       => __( 'Overlay Gradient (Tailwind classes)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['gradient'],
            'description' => 'e.g. from-slate-950/90 via-slate-900/70 to-primary-900/45',
        ] );

        $this->add_control( "s{$n}_badge_icon", [
            'label'       => __( 'Badge Icon (Font Awesome class)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['badge_icon'],
            'description' => 'e.g. fas fa-brain',
        ] );

        $this->add_control( "s{$n}_badge_icon_color", [
            'label'       => __( 'Badge Icon Color (Tailwind)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['badge_icon_color'],
            'description' => 'e.g. text-accent-400',
        ] );

        $this->add_control( "s{$n}_badge_text", [
            'label'   => __( 'Badge Text', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $defaults['badge_text'],
        ] );

        $this->add_control( "s{$n}_heading", [
            'label'   => __( 'Heading', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 2,
            'default' => $defaults['heading'],
        ] );

        $this->add_control( "s{$n}_highlight", [
            'label'       => __( 'Highlighted Word(s) in Heading', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['highlight'],
            'description' => 'This exact text in the heading will be wrapped in a colored span.',
        ] );

        $this->add_control( "s{$n}_highlight_color", [
            'label'       => __( 'Highlight Color (Tailwind)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['highlight_color'],
            'description' => 'e.g. text-primary-300 / text-emerald-300',
        ] );

        $this->add_control( "s{$n}_desc", [
            'label'   => __( 'Description', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXTAREA,
            'rows'    => 3,
            'default' => $defaults['desc'],
        ] );

        /* Primary button */
        $this->add_control( "s{$n}_btn1_text", [
            'label'   => __( 'Button 1 Text', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $defaults['btn1_text'],
        ] );

        $this->add_control( "s{$n}_btn1_url", [
            'label'   => __( 'Button 1 URL', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $defaults['btn1_url'],
        ] );

        $this->add_control( "s{$n}_btn1_icon", [
            'label'       => __( 'Button 1 Icon (Font Awesome)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => 'fas fa-arrow-right',
            'description' => 'Leave blank to hide icon.',
        ] );

        $this->add_control( "s{$n}_btn1_classes", [
            'label'       => __( 'Button 1 Tailwind Classes', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['btn1_classes'],
            'description' => 'Full class string for the primary button.',
        ] );

        /* Secondary button (optional) */
        $this->add_control( "s{$n}_btn2_text", [
            'label'       => __( 'Button 2 Text (optional)', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['btn2_text'] ?? '',
            'description' => 'Leave blank to hide.',
        ] );

        $this->add_control( "s{$n}_btn2_url", [
            'label'   => __( 'Button 2 URL', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default' => $defaults['btn2_url'] ?? '#contact',
        ] );

        $this->add_control( "s{$n}_btn2_classes", [
            'label'       => __( 'Button 2 Tailwind Classes', 'iatbd' ),
            'type'        => \Elementor\Controls_Manager::TEXT,
            'label_block' => true,
            'default'     => $defaults['btn2_classes'] ?? 'inline-flex items-center gap-2 px-7 py-3.5 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-semibold rounded-full backdrop-blur btn-cta-outline',
        ] );

        $this->end_controls_section();
    }

    /* ────────────────────────────────────────────
       REGISTER CONTROLS
    ──────────────────────────────────────────── */
    protected function register_controls() {

        /* ── Global settings ── */
        $this->start_controls_section( 'section_global', [
            'label' => __( 'Slider Settings', 'iatbd' ),
            'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
        ] );

        $this->add_control( 'autoplay', [
            'label'        => __( 'Autoplay', 'iatbd' ),
            'type'         => \Elementor\Controls_Manager::SWITCHER,
            'label_on'     => 'Yes',
            'label_off'    => 'No',
            'return_value' => 'yes',
            'default'      => 'yes',
        ] );

        $this->add_control( 'autoplay_speed', [
            'label'     => __( 'Autoplay Speed (ms)', 'iatbd' ),
            'type'      => \Elementor\Controls_Manager::NUMBER,
            'default'   => 5000,
            'condition' => [ 'autoplay' => 'yes' ],
        ] );

        $this->add_control( 'transition_speed', [
            'label'   => __( 'Transition Speed (ms)', 'iatbd' ),
            'type'    => \Elementor\Controls_Manager::NUMBER,
            'default' => 700,
        ] );

        $this->end_controls_section();

        /* ── Slide 1 ── */
        $this->slide_controls( 1, [
            'bg'              => 'https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?auto=format&fit=crop&w=1920&q=85',
            'gradient'        => 'from-slate-950/90 via-slate-900/70 to-slate-900/45',
            'badge_icon'      => 'fas fa-brain',
            'badge_icon_color'=> 'text-accent-400',
            'badge_text'      => 'Industrial AI',
            'heading'         => 'Smarter Automation, Better Decisions',
            'highlight'       => 'Automation',
            'highlight_color' => 'text-primary-300',
            'desc'            => 'Turn machine data into practical insight for predictive maintenance, quality inspection and more efficient production.',
            'btn1_text'       => 'Explore AI',
            'btn1_url'        => '#solutions',
            'btn1_classes'    => 'inline-flex items-center gap-2 px-7 py-3.5 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-full shadow-lg shadow-primary-500/40 btn-cta',
            'btn2_text'       => 'Talk to our team',
            'btn2_url'        => '#contact',
            'btn2_classes'    => 'inline-flex items-center gap-2 px-7 py-3.5 bg-white/15 hover:bg-white/25 border border-white/30 text-white font-semibold rounded-full backdrop-blur btn-cta-outline',
        ] );

        /* ── Slide 2 ── */
        $this->slide_controls( 2, [
            'bg'              => 'https://images.unsplash.com/photo-1581092160562-40aa08e78837?auto=format&fit=crop&w=1920&q=85',
            'gradient'        => 'from-slate-950/90 via-slate-900/70 to-primary-900/45',
            'badge_icon'      => 'fas fa-wave-square',
            'badge_icon_color'=> 'text-primary-300',
            'badge_text'      => 'Predictive Maintenance',
            'heading'         => 'Detect issues earlier',
            'highlight'       => 'earlier',
            'highlight_color' => 'text-primary-300',
            'desc'            => 'Identify changing machine conditions and give your team more time to plan maintenance before downtime occurs.',
            'btn1_text'       => 'See use cases',
            'btn1_url'        => '#solutions',
            'btn1_classes'    => 'inline-flex items-center gap-2 px-7 py-3.5 bg-primary-600 hover:bg-primary-500 text-white font-semibold rounded-full shadow-lg shadow-primary-500/40 btn-cta',
            'btn2_text'       => '',
            'btn2_url'        => '',
            'btn2_classes'    => '',
        ] );

        /* ── Slide 3 ── */
        $this->slide_controls( 3, [
            'bg'              => 'https://images.unsplash.com/photo-1581092918056-0c4c3acd3789?auto=format&fit=crop&w=1920&q=85',
            'gradient'        => 'from-slate-950/90 via-slate-900/70 to-emerald-900/40',
            'badge_icon'      => 'fas fa-eye',
            'badge_icon_color'=> 'text-emerald-300',
            'badge_text'      => 'Machine Vision',
            'heading'         => 'Consistent quality checks',
            'highlight'       => 'quality',
            'highlight_color' => 'text-emerald-300',
            'desc'            => 'Add visual inspection to your production process to flag defects and missing components with greater consistency.',
            'btn1_text'       => 'Discuss a pilot',
            'btn1_url'        => '#contact',
            'btn1_classes'    => 'inline-flex items-center gap-2 px-7 py-3.5 bg-emerald-600 hover:bg-emerald-500 text-white font-semibold rounded-full shadow-lg btn-cta',
            'btn2_text'       => '',
            'btn2_url'        => '',
            'btn2_classes'    => '',
        ] );
    }

    /* ────────────────────────────────────────────
       RENDER
    ──────────────────────────────────────────── */
    protected function render() {
        $s       = $this->get_settings_for_display();
        $wid     = $this->get_id();
        $autoplay= $s['autoplay'] === 'yes';
        $speed   = intval( $s['autoplay_speed'] );
        $trans   = intval( $s['transition_speed'] );

        $slides = [];
        for ( $n = 1; $n <= 3; $n++ ) {
            $slides[] = [
                'bg'              => esc_url( $s["s{$n}_bg_image"]['url'] ),
                'gradient'        => esc_attr( $s["s{$n}_gradient"] ),
                'badge_icon'      => esc_attr( $s["s{$n}_badge_icon"] ),
                'badge_icon_color'=> esc_attr( $s["s{$n}_badge_icon_color"] ),
                'badge_text'      => esc_html( $s["s{$n}_badge_text"] ),
                'heading'         => $s["s{$n}_heading"],
                'highlight'       => $s["s{$n}_highlight"],
                'highlight_color' => esc_attr( $s["s{$n}_highlight_color"] ),
                'desc'            => esc_html( $s["s{$n}_desc"] ),
                'btn1_text'       => esc_html( $s["s{$n}_btn1_text"] ),
                'btn1_url'        => esc_url( $s["s{$n}_btn1_url"] ),
                'btn1_icon'       => esc_attr( $s["s{$n}_btn1_icon"] ),
                'btn1_classes'    => esc_attr( $s["s{$n}_btn1_classes"] ),
                'btn2_text'       => esc_html( $s["s{$n}_btn2_text"] ),
                'btn2_url'        => esc_url( $s["s{$n}_btn2_url"] ),
                'btn2_classes'    => esc_attr( $s["s{$n}_btn2_classes"] ),
            ];
        }
        ?>

        <section class="servo-hero-<?php echo esc_attr( $wid ); ?> servo-hero pt-16 overflow-hidden relative">

            <?php foreach ( $slides as $i => $slide ) :
                $active = $i === 0 ? ' active' : '';
            ?>
            <div class="servo-slide<?php echo $active; ?>" data-i="<?php echo $i; ?>">

                <!-- Background image -->
                <div class="bg-img" style="background-image:url('<?php echo $slide['bg']; ?>')"></div>

                <!-- Overlay gradient -->
                <div class="absolute inset-0 bg-gradient-to-r <?php echo $slide['gradient']; ?>"></div>

                <!-- Content -->
                <div class="servo-slide-content max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="max-w-4xl mx-auto px-14 sm:px-0 text-center">

                        <!-- Badge -->
                        <?php if ( $slide['badge_text'] ) : ?>
                        <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/15 backdrop-blur border border-white/25 text-white text-sm font-medium mb-5">
                            <?php if ( $slide['badge_icon'] ) : ?>
                            <i class="<?php echo $slide['badge_icon']; ?> <?php echo $slide['badge_icon_color']; ?>"></i>
                            <?php endif; ?>
                            <?php echo $slide['badge_text']; ?>
                        </div>
                        <?php endif; ?>

                        <!-- Heading with highlight -->
                        <?php
                        $heading = esc_html( $slide['heading'] );
                        if ( $slide['highlight'] ) {
                            $highlighted = '<span class="' . $slide['highlight_color'] . '">' . esc_html( $slide['highlight'] ) . '</span>';
                            $heading     = str_replace( esc_html( $slide['highlight'] ), $highlighted, $heading );
                        }
                        ?>
                        <h<?php echo $i === 0 ? '1' : '2'; ?> class="font-display text-4xl sm:text-5xl lg:text-6xl font-bold text-white mb-4">
                            <?php echo $heading; ?>
                        </h<?php echo $i === 0 ? '1' : '2'; ?>>

                        <!-- Description -->
                        <p class="text-lg text-slate-200 max-w-2xl mx-auto mb-8">
                            <?php echo $slide['desc']; ?>
                        </p>

                        <!-- Buttons -->
                        <div class="flex flex-wrap justify-center gap-3">
                            <?php if ( $slide['btn1_text'] ) : ?>
                            <a href="<?php echo $slide['btn1_url']; ?>" class="<?php echo $slide['btn1_classes']; ?>">
                                <?php echo $slide['btn1_text']; ?>
                                <?php if ( $slide['btn1_icon'] ) : ?>
                                <i class="<?php echo $slide['btn1_icon']; ?> text-sm"></i>
                                <?php endif; ?>
                            </a>
                            <?php endif; ?>

                            <?php if ( $slide['btn2_text'] ) : ?>
                            <a href="<?php echo $slide['btn2_url']; ?>" class="<?php echo $slide['btn2_classes']; ?>">
                                <?php echo $slide['btn2_text']; ?>
                            </a>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>

            </div>
            <?php endforeach; ?>

            <!-- Prev / Next arrows -->
            <button class="hero-arrow prev absolute left-4 top-1/2 z-20 -translate-y-1/2" type="button" aria-label="Previous slide">
                <i class="fas fa-chevron-left"></i>
            </button>
            <button class="hero-arrow next absolute right-4 top-1/2 z-20 -translate-y-1/2" type="button" aria-label="Next slide">
                <i class="fas fa-chevron-right"></i>
            </button>

            <!-- Dot nav -->
            <div class="hero-nav" aria-label="Choose a slide">
                <?php for ( $i = 0; $i < 3; $i++ ) : ?>
                <button class="servo-dot<?php echo $i === 0 ? ' active' : ''; ?>"
                        type="button"
                        data-i="<?php echo $i; ?>"
                        aria-label="Slide <?php echo $i + 1; ?>">
                </button>
                <?php endfor; ?>
            </div>

        </section>
        <?php
    }
}