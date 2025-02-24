<?php

if(!function_exists('exportShortArray')){

    function exportShortArray($array, $file, $indent = '')
    {
        $exported = "<?php\nreturn " . buildShortArray($array, $indent) . ";\n";
        file_put_contents($file, $exported);
    }
}


if(!function_exists('buildShortArray')){

    function buildShortArray($array, $indent = '')
    {
        if (!is_array($array)) {
            return var_export($array, true);
        }

        $indexed = array_keys($array) === range(0, count($array) - 1);
        $lines = [];
        foreach ($array as $key => $value) {
            $line = $indent . '    ';
            if (!$indexed) {
                $line .= var_export($key, true) . ' => ';
            }
            $line .= buildShortArray($value, $indent . '    ');
            $lines[] = $line;
        }

        return "[\n" . implode(",\n", $lines) . "\n" . $indent . "]";
    }


}
