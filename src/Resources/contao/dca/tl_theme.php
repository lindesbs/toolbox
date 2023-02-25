<?php

declare(strict_types=1);

$GLOBALS['TL_DCA']['tl_theme']['fields']['alias'] = [
    'inputType' => 'text',
    'sql' => "varchar(255) NOT NULL default ''",
];
