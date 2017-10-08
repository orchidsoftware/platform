<?php

return [
    'title'       => 'Menu',
    'description' => 'Choose an accessible menu',

    'not_found' => 'No menu available',
    'form'      => [
        'title'             => 'Name',
        'title_description' => 'About us',
        'alt'               => 'Alternative name',
        'alt_description'   => 'History of the company',
        'url'               => 'URL',
        'url_description'   => '/about',
        'display'           => [
            'name'      => 'Display',
            'variables' => [
                'no_auth' => 'Visible to everyone',
                'auth'    => 'Only authorized users',
            ],
        ],
        'class'             => 'Class',
        'relations'         => [
            'name'      => 'Relations',
            'variables' => [
                'answer'     => 'Answer to the question',
                'chapter'    => 'Section or chapter of the current document',
                'co-worker'  => "Link to a colleague's page",
                'colleague'  => "Link to a colleague's page (not at work)",
                'contact'    => 'Link to the page with contact information',
                'details'    => 'Link to page with details',
                'edit'       => 'Editable version of the current document',
                'friend'     => 'Link to friend page',
                'question'   => 'Question',
                'archives'   => 'Link to the site archive',
                'author'     => 'Link to the page about the author on the same domain',
                'bookmark'   => 'Permanent link to a section or entry',
                'first'      => 'Link to the first page',
                'help'       => 'Link to a document with help',
                'index'      => 'Link to content',
                'last'       => 'Link to the last page',
                'license'    => 'Link to a page with a license agreement or copyrights',
                'me'         => 'Link to author page on another domain',
                'next'       => 'Link to next page or section',
                'nofollow'   => 'Do not pass on the link TIC and PR.',
                'noreferrer' => 'Do not pass HTTP headers over the link',
                'prefetch'   => 'Indicates that you must cache the specified resource in advance',
                'prev'       => 'Link to the previous page or section',
                'search'     => 'Link to search',
                'sidebar'    => 'Add link to browser favorites',
                'tag'        => 'Indicates that the tag (tag) is relevant to the current document',
                'up'         => 'Link to the parent page',
            ],
        ],
        'target'            => [
            'name'      => 'Link Target',
            'variables' => [
                'self'  => 'In the current window',
                'blank' => 'In a new window',
            ],
        ],
        'control'           => [
            'remove' => 'Remove',
            'reset'  => 'Reset',
            'create' => 'Create',
            'save'   => 'Save',
        ],
    ],
];
