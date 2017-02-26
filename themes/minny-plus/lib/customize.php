<?php

//* Register Our Customizer
//* =============================================================== */

    //* Hook in our options to the customizer
    add_action( 'customize_register', 'ck_theme_options' );
    function ck_theme_options( $wp_customize ) {

        //* Add accent color setting to the database
    	$wp_customize->add_setting('ck_accent_color', array(
            'default'           => '#70C1B3',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
            'type'           	=> 'option',
     
        ));
     
        //* Add accent color control to the customizer
        $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize, 
            'ck_accent_color', array(
                'label'    => __('Accent Color', TEXT_DOMAIN ),
                'section'  => 'colors',
                'settings' => 'ck_accent_color',
            ))
        );

    }