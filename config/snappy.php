<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Snappy PDF / Image Configuration
    |--------------------------------------------------------------------------
    |
    | This option contains settings for PDF generation.
    |
    | Enabled:
    |
    |    Whether to load PDF / Image generation.
    |
    | Binary:
    |
    |    The file path of the wkhtmltopdf / wkhtmltoimage executable.
    |
    | Timout:
    |
    |    The amount of time to wait (in seconds) before PDF / Image generation is stopped.
    |    Setting this to false disables the timeout (unlimited processing time).
    |
    | Options:
    |
    |    The wkhtmltopdf command options. These are passed directly to wkhtmltopdf.
    |    See https://wkhtmltopdf.org/usage/wkhtmltopdf.txt for all options.
    |
    | Env:
    |
    |    The environment variables to set while running the wkhtmltopdf process.
    |
    */

    'pdf' => [
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltopdf',
//        'binary'  => 'C:/wkhtmltopdf/bin/wkhtmltopdf',
//        'binary'  => base_path('public/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64'),
//        'binary'  => 'C:/h4cc/wkhtmltopdf-amd64/bin/wkhtmltopdf-amd64',
//        'binary'  => '/usr/local/bin/wkhtmltopdf',
        'timeout' => false,
        'options' => array(
            'page-size' => 'A4',
            'margin-top' => 34,
            'margin-right' => 5,
            'margin-left' => 5,
            'margin-bottom' => 20,
            'orientation' => 'Portrait',
            'footer-center' => 'Page [page] of [toPage]',
            'footer-font-size' => 8,
            'footer-left' => '',
            'encoding' => 'utf-8',
        ),
        'env'     => [],
    ],

    'image' => [
        'enabled' => true,
        'binary'  => '/usr/local/bin/wkhtmltoimage',
        'timeout' => false,
        'options' => [],
        'env'     => [],
    ],

];
