<?php
/**
 * WordPress Settings Framework
 *
 * @author Gilbert Pellegrom
 * @link https://github.com/gilbitron/WordPress-Settings-Framework
 * @license MIT
 */

/**
 * Define your settings
 */
add_filter( 'wpsf_register_settings', 'wpsf_example_settings' );
function wpsf_example_settings( $wpsf_settings ) {

    // General Settings section
    $wpsf_settings[] = [
        'section_id' => 'vacancy_settings',
        'section_title' => 'Настройки отображения',
        'section_order' => 5,
        'fields' => [
            [
                'id' => 'posts_per_page',
                'title' => 'Количество вакансий на странице',
                'type' => 'number',
                'std' => 10
            ],
            [
            	'id' => 'email',
            	'title' => 'Текст после регистрации',
            	'type' => 'textarea',
                'class' => ''
            ]
        ]
    ];
    $wpsf_settings[] = [
        'section_id' => 'vacancy_import',
        'section_title' => 'Импорт',
        'section_order' => 6,
        'fields' => [[]]
    ];

    return $wpsf_settings;
}