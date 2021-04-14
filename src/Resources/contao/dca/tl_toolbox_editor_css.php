<?php

/**
 * Table tl_toolbox_editor_css
 */
$GLOBALS['TL_DCA']['tl_toolbox_editor_css'] = [
    // Config
    'config'   => [
        'dataContainer'    => 'Table',
        'ptable'           => 'tl_toolbox_editor',
        'switchToEdit'     => true,
        'enableVersioning' => true,
        'sql'              => [
            'keys' => [
                'id'  => 'primary',
                'pid' => 'index'
            ]
        ]
    ],
    // List
    'list'     => [
        'sorting'           => [
            'mode'                  => 4,
            'fields'                => ['sorting'],
            'panelLayout'           => 'filter;sort,search,limit',
            'headerFields'          => ['title'],
            'child_record_callback' => function (array $row) {
                return sprintf(
                    '<div class="tl_content_left">%s <span style="color:#999;padding-left:3px">[%s]</span></div>',
                    $row['title'] ?? '',
                    implode(', ', array_column(StringUtil::deserialize($row['classes'] ?? '', true), 'key'))
                );
            },
        ],
        'label'             => [
            'fields' => ['title'],
            'format' => '%s'
        ],
        'global_operations' => [
            'all' => [
                'label'      => &$GLOBALS['TL_LANG']['MSC']['all'],
                'href'       => 'act=select',
                'class'      => 'header_edit_all',
                'attributes' => 'onclick="Backend.getScrollOffset()" accesskey="e"'
            ]
        ],
        'operations'        => [
            'edit'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['edit'],
                'href'  => 'act=edit',
                'icon'  => 'edit.gif'
            ],
            'copy'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['copy'],
                'href'  => 'act=copy',
                'icon'  => 'copy.gif',
            ],
            'delete' => [
                'label'      => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['delete'],
                'href'       => 'act=delete',
                'icon'       => 'delete.gif',
                'attributes' => sprintf(
                    "onclick=\"if(!confirm('%s'))return false;Backend.getScrollOffset()\"",
                    $GLOBALS['TL_LANG']['MSC']['deleteConfirm']
                )
            ],
            'show'   => [
                'label' => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['show'],
                'href'  => 'act=show',
                'icon'  => 'show.gif'
            ]
        ]
    ],
    // Palettes
    'palettes' => [
        'default' => '{title_legend},title,classes;{elements_legend},elements;{fields_legend},fields;{modules_legend},modules;'
    ],
    // Fields
    'fields'   => [
        'id'       => [
            'sql' => "int(10) unsigned NOT NULL auto_increment"
        ],
        'pid'      => [
            'foreignKey' => 'tl_toolbox_editor.title',
            'sql'        => "int(10) unsigned NOT NULL default 0",
            'relation'   => ['type' => 'belongsTo', 'load' => 'lazy']
        ],
        'tstamp'   => [
            'sql' => "int(10) unsigned NOT NULL default '0'"
        ],
        'sorting'  => [
            'sql' => "int(10) unsigned NOT NULL default '0'",
        ],
        'title'    => [
            'label'     => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['title'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'text',
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w50'],
            'sql'       => "varchar(255) NOT NULL default ''"
        ],
        'classes'  => [
            'label'     => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['class'],
            'exclude'   => true,
            'search'    => true,
            'inputType' => 'keyValueWizard',
            'eval'      => ['mandatory' => true, 'maxlength' => 255, 'tl_class' => 'w100 clr'],
            'sql'       => "text NULL"
        ],
        'elements' => [
            'label'            => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['elements'],
            'exclude'          => true,
            'filter'           => true,
            'inputType'        => 'checkbox',
            'options_callback' => function () {
                return array_map('array_keys', $GLOBALS['TL_CTE']);
            },
            'reference'        => &$GLOBALS['TL_LANG']['CTE'],
            'eval'             => ['multiple' => true, 'helpwizard' => true],
            'sql'              => "blob NULL"
        ],
        'fields'   => [
            'label'     => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['fields'],
            'exclude'   => true,
            'filter'    => true,
            'inputType' => 'checkbox',
            'options'   => array_keys($GLOBALS['TL_FFL']),
            'reference' => &$GLOBALS['TL_LANG']['FFL'],
            'eval'      => ['multiple' => true, 'helpwizard' => true],
            'sql'       => "blob NULL"
        ],
        'modules'  => [
            'label'            => &$GLOBALS['TL_LANG']['tl_toolbox_editor_css']['modules'],
            'exclude'          => true,
            'filter'           => true,
            'inputType'        => 'checkbox',
            'options_callback' => function () {
                $arrModules = [];

                foreach ($GLOBALS['BE_MOD'] as $k => $v) {
                    if (empty($v)) {
                        continue;
                    }

                    foreach ($v as $kk => $vv) {
                        if (isset($vv['disablePermissionChecks']) && $vv['disablePermissionChecks'] === true) {
                            unset($v[$kk]);
                        }
                    }

                    $arrModules[$k] = array_keys($v);
                }

                return $arrModules['content'];
            },
            'reference'        => &$GLOBALS['TL_LANG']['MOD'],
            'eval'             => ['multiple' => true, 'helpwizard' => true],
            'sql'              => "blob NULL"
        ],
    ]
];
