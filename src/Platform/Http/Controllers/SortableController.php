<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class SortableController extends Controller
{
    /**
     * Save the sort order for a sortable model.
     * Authorization is performed via the model's Policy method `isSortable`.
     *
     * @param Request $request Must contain 'model' (class name) and 'items' (array of {id, sortOrder})
     */
    public function saveSortOrder(Request $request): void
    {
        $request->validate([
            'model'             => 'required|string',
            'items'             => 'required|array',
            'items.*.id'        => 'required',
            'items.*.sortOrder' => 'required|integer|min:0',
        ]);

        $classModel = $request->input('model');

        abort_unless(is_subclass_of($classModel, Model::class), 400);

        $model = new $classModel;
        abort_unless(method_exists($model, 'getSortColumnName'), 400);

        $policy = Gate::getPolicyFor($model);

        if ($policy !== null && method_exists($policy, 'isSortable')) {
            $this->authorize('isSortable', $model);
        }

        $request->collect('items')->each(function ($item) use ($model) {
            $model->where($model->getKeyName(), '=', $item['id'])->update([
                $model->getSortColumnName() => $item['sortOrder'],
            ]);
        });
    }
}
