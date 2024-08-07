<?php

/**
 * Custom Fonts
 */


Kirki::add_field( 'themegoods_customize', array(
    'type' => 'title',
    'settings'  => 'tg_custom_fonts_title',
    'label'    => esc_html__('Uploaded Fonts Settings', 'avante' ),
    'section'  => 'general_fonts',
	'priority' => 5,
) );

Kirki::add_field( 'themegoods_customize', array(
    'type' => 'repeater',
    'label' => esc_html__( 'Uploaded Fonts', 'avante' ) ,
    'description' => esc_html__( 'Here you can add your custom fonts', 'avante' ) ,
    'settings' => 'tg_custom_fonts',
    'priority' => 6,
    'transport' => 'auto',
    'section' => 'general_fonts',
    'row_label' => array(
        'type' => 'text',
        'value' => esc_html__( 'Upload Font', 'avante' ) ,
    ),
    'fields' => array(
        'font_name' => array(
            'type' => 'text',
            'label' => esc_html__( 'Name', 'avante' ) ,
        ) ,
        'font_url' => array(
            'type' => 'upload',
            'label' => esc_html__( 'Font File (*.woff)', 'avante' ) ,
        ) ,
        'font_weight' => array(
            'type' => 'select',
            'label' => esc_html__( 'Font Weight', 'avante' ) ,
            'defalut' => 'bold',
            'choices' => array(
                100 => 100 ,
                200 => 200 ,
                300 => 300 ,
                400 => 400 ,
                500 => 500 ,
                500 => 500 ,
                600 => 600 ,
                700 => 700 ,
                800 => 800 ,
                900 => 900 ,
            )
        ) ,
        'font_style' => array(
            'type' => 'select',
            'label' => esc_html__( 'Font Style', 'avante' ) ,
            'defalut' => 'normal',
            'choices' => array(
                'normal' => esc_html__( 'Normal', 'avante' ) ,
                'italic' => esc_html__( 'Italic', 'avante' ) ,
            )
        ) ,
    ) 
) );