<?php
add_action( 'after_setup_theme', function() {
    include 'vendor/autoload.php';
    do_action( 'wp_plates_loaded' );
});
