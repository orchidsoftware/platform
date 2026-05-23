<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Http\Request;

class SortableController extends Controller
{
    /**
     * Save the sort order for a sortable model.
     * Authorization is performed via the model's Policy method `isSortable`.
     *
     * @param \Illuminate\Http\Request $request Must contain 'model' (class name) and 'items' (array of {id, sortOrder})
     *
     * @return void
     */
    public function saveSortOrder(Request $request): void
    {
        $request->validate([
            'model' => 'required|string',
            'items' => 'required|array',
            'items.*.id' => 'required',
            'items.*.sortOrder' => 'required|integer|min:0',
        ]);

        $classModel = $request->input('model');

        abort_unless(class_exists($classModel), 400);

        $model = new $classModel;

        $this->authorize('isSortable', $model);

        $request->collect('items')->each(function ($item) use ($model) {
            $model->where($model->getKeyName(), '=', $item['id'])->update([
                $model->getSortColumnName() => $item['sortOrder'],
            ]);
        });
    }
}
