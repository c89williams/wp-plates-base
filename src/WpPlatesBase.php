<?php

abstract class WpPlatesBase
{

    protected $engine;

    // can handle any action post-'after_setup_theme'
    public function __construct()
    {
        add_action( 'wp_theme_route', array( $this, 'themeRoute' ) );
        add_action( 'wp_theme_render', array( $this, 'themeRender' ), '10', '2' );

        $this->themeSetup();
    }

    public function themeSetup()
    {
        $this->engine = new \League\Plates\Engine( '.', 'phtml' );

        $this->engine->addFolder( 'layouts', dirname( __FILE__ ) . '/../layouts' );
        $this->engine->addFolder( 'partials', dirname( __FILE__ ) . '/../partials' );

        do_action( 'wp_plates_theme_setup' );
        
    }
    public function themeRoute()
    {

        if ( is_front_page() ) {
            do_action( 'wp_theme_render', 'single', 'front' );
            return;
        }

        if ( is_singular() ) {
            do_action( 'wp_theme_render', 'single', get_post_type() );
            return;
        }

        if ( is_archive() ) {
            do_action( 'wp_theme_render', 'archive', get_post_type() );
            return;
        }
    }

    abstract public function themeRender($type, $plurality);
}
