<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Http\Request;

class SortableController extends Controller
{
    /**
     * @param \Illuminate\Http\Request $request
     *
     * @return void
     */
    public function saveSortOrder(Request $request): void
    {
        $classModel = $request->input('model');

        abort_unless(class_exists($classModel), 400);

        $model = new $classModel;

        $request->collect('items')->each(function ($item) use ($model) {
            $model->where($model->getKeyName(), '=', $item['id'])->update([
                $model->getSortColumnName() => $item['sortOrder'],
            ]);
        });
    }
}
