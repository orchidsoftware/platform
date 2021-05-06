<?php

$finder = Symfony\Component\Finder\Finder::create()
    ->notPath('bootstrap/*')
    ->notPath('storage/*')
    ->notPath('resources/view/mail/*')
    ->in([
        __DIR__ . '/src',
        __DIR__ . '/tests',
        __DIR__ . '/stubs',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

return (new PhpCsFixer\Config())
    ->setRules([
        '@PSR2' => true,
        'array_syntax' => ['syntax' => 'short'],
        'ordered_imports' => ['sort_algorithm' => 'alpha'],
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'not_operator_with_successor_space' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],
        'phpdoc_scalar' => true,
        'unary_operator_spaces' => true,
        'binary_operator_spaces' => [
            'operators' => [
                '=>' => 'align_single_space',
            ],
        ],
        'blank_line_before_statement' => [
            'statements' => ['continue', 'declare', 'return', 'throw', 'try'],
        ],
        'phpdoc_separation' => true,
        'phpdoc_align' => true,
        'phpdoc_order' => true,
        'phpdoc_single_line_var_spacing' => true,
        'phpdoc_var_without_name' => true,
        'class_attributes_separation' => [
            'elements' => [
                'method'  => 'one',
            ],
        ],
        'method_argument_space' => [
            'on_multiline' => 'ignore',
        ],
        'trim_array_spaces' => true,
        'single_trait_insert_per_statement' => false,
    ])
    ->setFinder($finder);
