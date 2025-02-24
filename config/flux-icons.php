<?php return array (
  'request_npm_dev' => true,
  'icons' => 
  array (
    'tabler' => 
    array (
      0 => 'home',
      1 => 'confetti',
      2 => 'windmill',
      3 => 'icons',
      4 => 'brand-github',
      5 => 'info-square-rounded',
      6 => 'moon',
      7 => 'sun',
      8 => 'filter',
      9 => 'refresh',
      10 => 'chevron-right',
      11 => 'chevron-left',
    ),
  ),
  'default_stroke_width' => 1.5,
  'vendors' => 
  array (
    'bootstrap' => 
    array (
      'vendor_name' => 'Bootstrap',
      'namespace' => 'bootstrap',
      'package' => 'bootstrap-icons',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'source' => 
          array (
            'dir' => 'node_modules/bootstrap-icons/icons',
            'prefix' => NULL,
            'suffix' => NULL,
            'filter' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Bootstrap',
              1 => 'outlineFilter',
            ),
          ),
        ),
        'solid' => 
        array (
          'source' => 
          array (
            'dir' => 'node_modules/bootstrap-icons/icons',
            'prefix' => NULL,
            'suffix' => '-fill',
            'filter' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Bootstrap',
              1 => 'solidFilter',
            ),
          ),
        ),
      ),
    ),
    'codicons' => 
    array (
      'vendor_name' => 'VSCode Codicons',
      'namespace' => 'codicons',
      'package' => '@vscode/codicons',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'source' => 'node_modules/@vscode/codicons/src/icons',
        ),
        'solid' => 
        array (
          'source' => 'node_modules/@vscode/codicons/src/icons',
        ),
      ),
    ),
    'flags' => 
    array (
      'vendor_name' => 'Flag Icons',
      'namespace' => 'flags',
      'package' => 'flag-icons',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'raw' => true,
          'source' => 'node_modules/flag-icons/flags/4x3',
        ),
        'solid' => 
        array (
          'raw' => true,
          'source' => 'node_modules/flag-icons/flags/4x3',
        ),
      ),
    ),
    'flowbite' => 
    array (
      'vendor_name' => 'Flowbite',
      'namespace' => 'flowbite',
      'package' => 'flowbite-icons',
      'variants' => 
      array (
        'outline' => 
        array (
          'source' => 'node_modules/flowbite-icons/src/outline/*/',
        ),
        'solid' => 
        array (
          'source' => 'node_modules/flowbite-icons/src/solid/*/',
        ),
      ),
    ),
    'fluent' => 
    array (
      'vendor_name' => 'Fluent UI',
      'namespace' => 'fluent',
      'package' => '@fluentui/svg-icons',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'source' => 
          array (
            'dir' => 'node_modules/@fluentui/svg-icons/icons',
            'prefix' => NULL,
            'suffix' => '_24_regular',
          ),
        ),
        'solid' => 
        array (
          'source' => 
          array (
            'dir' => 'node_modules/@fluentui/svg-icons/icons',
            'prefix' => NULL,
            'suffix' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Fluent',
              1 => 'sourceSolidSuffix',
            ),
          ),
        ),
      ),
      'transform' => 
      array (
        0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Fluent',
        1 => 'transform',
      ),
    ),
    'healthicons' => 
    array (
      'vendor_name' => 'Healthicons',
      'namespace' => 'healthicons',
      'package' => 'healthicons',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'source' => 'node_modules/healthicons/public/icons/svg/outline/*/',
        ),
        'solid' => 
        array (
          'source' => 'node_modules/healthicons/public/icons/svg/filled/*/',
        ),
        'mini' => 
        array (
          'base' => 'solid',
          'fallback' => 'solid',
          'source' => 'node_modules/healthicons/public/icons/svg/filled-24px/*/',
        ),
        'micro' => 
        array (
          'base' => 'solid',
          'fallback' => 'solid',
          'source' => 'node_modules/healthicons/public/icons/svg/filled-24px/*/',
        ),
      ),
      'icon_name' => 
      array (
        0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Healthicons',
        1 => 'name',
      ),
    ),
    'lucide' => 
    array (
      'vendor_name' => 'Lucide',
      'namespace' => 'lucide',
      'package' => 'lucide-static',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'outline',
          'source' => 'node_modules/lucide-static/icons',
        ),
        'solid' => 
        array (
          'template' => 'outline',
          'source' => 'node_modules/lucide-static/icons',
        ),
      ),
    ),
    'material-icons' => 
    array (
      'vendor_name' => 'Material Design Icons',
      'namespace' => 'material',
      'package' => '@material-design-icons/svg',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'attributes' => 
          array (
            'stroke-linecap' => 'round',
            'stroke-linejoin' => 'round',
          ),
          'source' => 'node_modules/@material-design-icons/svg/outlined',
        ),
        'solid' => 
        array (
          'stroke_width' => false,
          'source' => 'node_modules/@material-design-icons/svg/filled',
        ),
      ),
    ),
    'material-symbols' => 
    array (
      'vendor_name' => 'Material Symbols 300',
      'namespace' => 'material-symbols',
      'package' => '@material-symbols/svg-300',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'source' => 
          array (
            'dir' => 'node_modules/@material-symbols/svg-300/outlined',
            'filter' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\MaterialSymbols',
              1 => 'outlineFilter',
            ),
          ),
        ),
        'solid' => 
        array (
          'source' => 
          array (
            'dir' => 'node_modules/@material-symbols/svg-300/outlined',
            'suffix' => '-fill',
            'filter' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\MaterialSymbols',
              1 => 'solidFilter',
            ),
          ),
        ),
      ),
    ),
    'mdi' => 
    array (
      'vendor_name' => 'MDI',
      'namespace' => 'mdi',
      'package' => '@mdi/svg',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'solid',
          'source' => 
          array (
            'dir' => 'node_modules/@mdi/svg/svg',
            'prefix' => NULL,
            'suffix' => '-outline',
            'filter' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Mdi',
              1 => 'outlineFilter',
            ),
          ),
        ),
        'solid' => 
        array (
          'source' => 
          array (
            'dir' => 'node_modules/@mdi/svg/svg',
            'prefix' => NULL,
            'suffix' => NULL,
            'filter' => 
            array (
              0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Mdi',
              1 => 'solidFilter',
            ),
          ),
        ),
      ),
    ),
    'tabler' => 
    array (
      'vendor_name' => 'Tabler',
      'namespace' => 'tabler',
      'package' => '@tabler/icons',
      'baseVariant' => 'outline',
      'variants' => 
      array (
        'outline' => 
        array (
          'template' => 'outline',
          'stroke_width' => 1.5,
          'size' => 24,
          'attributes' => 
          array (
            'stroke-linecap' => 'round',
            'stroke-linejoin' => 'round',
          ),
          'source' => 'node_modules/@tabler/icons/icons/outline',
        ),
        'solid' => 
        array (
          'template' => 'solid',
          'fallback' => 'default',
          'stroke_width' => false,
          'size' => 24,
          'attributes' => 
          array (
            'fill-rule' => 'evenodd',
            'clip-rule' => 'evenodd',
          ),
          'source' => 'node_modules/@tabler/icons/icons/filled',
        ),
        'mini' => 
        array (
          'base' => 'solid',
          'size' => 20,
        ),
        'micro' => 
        array (
          'base' => 'solid',
          'size' => 16,
        ),
      ),
      'attributes' => 
      array (
        0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Tabler',
        1 => 'attributes',
      ),
      'transform' => 
      array (
        0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Tabler',
        1 => 'transform',
      ),
      'stroke_width' => 
      array (
        0 => 'Ympact\\FluxIcons\\Services\\Vendors\\Tabler',
        1 => 'strokeWidth',
      ),
    ),
  ),
);