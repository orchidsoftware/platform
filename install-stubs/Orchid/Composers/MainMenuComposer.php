<?php

declare(strict_types=1);

namespace App\Orchid\Composers;

use Orchid\Platform\Dashboard;

class MainMenuComposer
{
    /**
     * @var Dashboard
     */
    private $dashboard;

    /**
     * MenuComposer constructor.
     *
     * @param Dashboard $dashboard
     */
    public function __construct(Dashboard $dashboard)
    {
        $this->dashboard = $dashboard;
    }

    /**
     * Registering the main menu items.
     */
    public function compose()
    {
        // Profile
        $this->dashboard->menu
            ->add('Profile', [
                'slug'  => 'example1',
                'icon'  => 'icon-text-center',
                'label' => 'Example 1',
                'sort'  => 1000,
            ])
            ->add('Profile', [
                'slug'  => 'example2',
                'icon'  => 'icon-text-center',
                'label' => 'Example 2',
                'sort'  => 1000,
                'badge' => [
                    'class' => 'bg-primary',
                    'data'  => function () {
                        return 6;
                    },
                ],
            ])
            ->add('Profile', [
                'slug'  => 'example3',
                'icon'  => 'icon-text-center',
                'label' => 'Example 3',
                'sort'  => 1000,
            ]);

        // Quick
        $this->dashboard->menu
            ->add('Quick', [
                'slug'  => 'example4',
                'icon'  => 'icon-text-center',
                'label' => 'Example 4',
                'sort'  => 1000,
            ])
            ->add('Quick', [
                'slug'  => 'example5',
                'icon'  => 'icon-text-center',
                'label' => 'Example 5',
                'sort'  => 1000,
            ])
            ->add('Quick', [
                'slug'  => 'example6',
                'icon'  => 'icon-text-center',
                'label' => 'Example 6',
                'sort'  => 1000,
            ]);
    }
}
