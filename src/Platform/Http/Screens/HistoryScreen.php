<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Screens;

use Base64Url\Base64Url;
use Orchid\Platform\Models\Activity;
use Orchid\Platform\Http\Layouts\HistoryLayout;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;

class HistoryScreen extends Screen
{
    /**
     * Display header name.
     *
     * @var string
     */
    public $name = 'История изменений';

    /**
     * @var string
     */
    public $permission = 'platform.systems.history';

    /**
     * Query data.
     *
     * @param string $class
     * @param string $slug
     *
     * @return array
     */
    public function query(string $class, string $slug): array
    {
        $class = Base64Url::decode($class);
        $model = \call_user_func([$class, 'findOrFail'], $slug);

        $this->description = $model->historyDescription();

        return [
            'history' => $model->activity()->paginate(),
        ];
    }

    /**
     * @return array
     */
    public function commandBar(): array
    {
        return [];
    }

    /**
     * Views.
     *
     * @return array
     */
    public function layout(): array
    {
        return [
            HistoryLayout::class,
        ];
    }

    /**
     * @param \Orchid\Platform\Models\Activity $activity
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function revertHistory(Activity $activity)
    {
        foreach ($activity->changes()['old'] ?? [] as $key => $value) {
            $activity->subject->setAttribute($key, $value);
        }

        $activity->subject->save();

        Alert::info('Информация востановлена');

        return back();
    }
}
