<?php

declare(strict_types=1);

namespace Orchid\Platform\Http\Controllers;

use Composer\InstalledVersions;
use Composer\Semver\VersionParser;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Collection as BaseCollection;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Log;
use Orchid\Support\QuerySerializer;

class Select2Controller extends Controller
{

    public function view(Request $request)
    {
        $name = $request->get('name');
        $display = $request->get('display') ? Crypt::decryptString($request->get('display')) : $name;
        $search = $request->get('search');
        $key = $request->get('key');

        $query = QuerySerializer::unserialize($request->get('query'));

        $searchColumns = $request->get('searchColumns')
            ? Crypt::decrypt($request->get('searchColumns'))
            : null;

        if (InstalledVersions::satisfies(new VersionParser, 'laravel/framework', '>11.17.0')) {
            $query = $query->where(function ($query) use ($name, $search, $searchColumns) {
                $value = '%'.$search.'%';

                $query->whereLike($name, $value);

                $query->when($searchColumns !== null, function ($query) use ($searchColumns, $value) {
                    foreach ($searchColumns as $column) {
                        $query->orWhereLike($column, $value);
                    }
                });
            });
        } else {
            $query = $query->where(function ($query) use ($name, $search, $searchColumns) {
                $value = '%'.$search.'%';

                $query->where($name, 'like', $value);

                $query->when($searchColumns !== null, function ($query) use ($searchColumns, $value) {
                    foreach ($searchColumns as $column) {
                        $query->orWhere($column, 'like', $value);
                    }
                });
            });
        }

        return response()->json($query->get()->map(function ($item) use ($display, $key) {
            return [
                'label' => $item->$display,
                'value' => $item->$key,
            ];
        }));
    }
}
