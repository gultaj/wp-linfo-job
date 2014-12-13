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
        'section_id' => 'job_settings',
        'section_title' => 'Настройки отображения',
        'section_order' => 5,
        'fields' => [
            [
                'id' => 'posts_per_page',
                'title' => 'Записей на странице',
                'type' => 'number',
                'std' => 10
            ], [
            	'id' => 'register_vacancy',
            	'title' => 'Текст после регистрации вакансии',
            	'type' => 'textarea',
                'class' => '',
                'desc' => 'Для отображения сгенерированного ключа вставте <strong>%key%</strong>'
            ], [
                'id' => 'register_resume',
                'title' => 'Текст после регистрации резюме',
                'type' => 'textarea',
                'class' => '',
                'desc' => 'Для отображения сгенерированного ключа вставте <strong>%key%</strong>'
            ]
        ]
    ];

    return $wpsf_settings;
}
