<?php

namespace App\Models\Traits;

use Illuminate\Http\Request;

trait UseDataTable
{
    public function scopeFilterByDataTable($query, Request $request)
    {
        $sort = collect($request->input('sort') ? explode(',', $request->input('sort')) : []);
        $sortable = collect($this->sortable);

        $sort->each(function ($sort_value) use ($query, $sortable) {
            $result = explode('|', $sort_value);
            $by = $result[0];
            $order = @$result[1] ? $result[1] : 'asc';

            if ($sortable->count() && !$sortable->contains($by)) {
                abort(503);
            }

            $query->orderBy($by, $order);
        });

        return $query;
    }
}
