<?php
use Illuminate\Support\Str;

if(!function_exists('fluxdown')){
    function fluxdown($content, $options = [], $extensions = []){
        Str::markdown($content, 
        [...[
            'html_input' => 'strip',
            'allow_unsafe_links' => true,
            'max_nesting_level' => 5,
        ], ...$options], 
        [...[
            new \Ympact\FluxMarkDown\Blocks\Header\HeaderExtension,
            //new MarkDownTooltipExtension,
            //new MarkDownDetailsExtension,
            //new MarkDownAttachmentExtension,
        ], ...$extensions]);
    }
}