<?php

//* Register Our Customizer
//* =============================================================== */

    //* Add custom theme options to the Customizer
    add_action( 'customize_register', 'ck_theme_options' );

    function ck_theme_options( $wp_customize ) {

        //* Add accent color to the Customizer
    	$wp_customize->add_setting('ck_accent_color', array(
            'default'           => '#02D4FF',
            'sanitize_callback' => 'sanitize_hex_color',
            'capability'        => 'edit_theme_options',
            'type'           	=> 'option',
     
        ));
     
        $wp_customize->add_control( new WP_Customize_Color_Control(
            $wp_customize, 
            'ck_accent_color', array(
                'label'    => __('Accent Color', TEXT_DOMAIN ),
                'section'  => 'colors',
                'settings' => 'ck_accent_color',
            ))
        );
    }