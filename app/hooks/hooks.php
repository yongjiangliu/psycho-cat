<?php
/**
 * HTML compress hook
 * @since v0.1.0
 * @author bcli, 2016-8-25
 * @see https://github.com/bcit-ci/codeigniter/wiki/compress-html-output
 */
$hook['display_override'][] = array(
    'class' => '',
    'function' => 'compress',
    'filename' => 'compress.php',
    'filepath' => 'hooks'
);