<?php

namespace App\Orchid\Screens\Examples;

use Orchid\Screen\Action;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Layout;

class ExampleChartsScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'trend' => [
                'labels'   => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'datasets' => [
                    ['name' => 'Interactions', 'values' => [32, 48, 43, 61, 54, 76, 68]],
                ],
            ],
            'charts' => [
                'labels'   => ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
                'datasets' => [
                    ['name' => 'This week', 'values' => [32, 48, 43, 61, 54, 76, 68]],
                    ['name' => 'Last week', 'values' => [28, 35, 46, 39, 48, 57, 52]],
                ],
            ],
            'distribution' => [
                'labels'   => ['Clicks', 'Likes', 'Replies', 'Reposts'],
                'datasets' => [
                    ['values' => [176, 122, 54, 30]],
                ],
            ],
        ];
    }

    /**
     * The name of the screen displayed in the header.
     */
    public function name(): ?string
    {
        return 'Charts';
    }

    /**
     * Display header description.
     */
    public function description(): ?string
    {
        return 'A guide to designing and implementing charts, from bar to pie.';
    }

    /**
     * The screen's action buttons.
     *
     * @return Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @throws \Throwable
     *
     * @return string[]|\Orchid\Screen\Layout[]
     */
    public function layout(): iterable
    {
        return [
            Layout::chart('trend', 'Actions with a Tweet')
                ->height(300)->smooth()->gradient()
                ->marker('Medium', 40, ['lineStyle' => 'dashed'])
                ->description('The total number of interactions a user has with a tweet. This includes all clicks on any links in the tweet (including hashtags, links, avatar, username, and expand button), retweets, replies, likes, and additions to the read list.'),

            Layout::columns([
                Layout::chart('charts', 'Line Chart')
                    ->height(300)->smooth()->gradient()
                    ->marker('Medium', 40, ['lineStyle' => 'dashed'])
                    ->description('Visualize data trends with multi-colored line graphs.'),
                Layout::chart('charts', 'Bar Chart')->type('bar')->height(300)
                    ->description('Compare data sets with colorful bar graphs.'),
            ]),

            Layout::columns([
                Layout::chart('distribution', 'Percentage Chart')->type('percentage')->height(88)
                    ->description('Display data as visually appealing and modern percentage graphs.'),

                Layout::chart('distribution', 'Pie Chart')->type('pie')->height(280)
                    ->description('Break down data into easy-to-understand pie graphs with modern design.'),
            ]),
        ];
    }
}
