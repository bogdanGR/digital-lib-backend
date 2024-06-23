<?php

namespace App\Models\search;

use App\Models\Publication;
use Illuminate\Http\Request;

class PublicationSearch
{
    public static function apply(Request $request)
    {
        $query = Publication::with('authors');

        if ($request->filled('author')) {
            $query->whereHas('authors', function($q) use ($request) {
                $q->where('first_name', 'like', '%' . $request->input('author') . '%')
                    ->orWhere('last_name', 'like', '%' . $request->input('author') . '%');
            });
        }
        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->input('title') . '%');
        }
        if ($request->filled('abstract')) {
            $query->where('abstract', 'like', '%' . $request->input('abstract') . '%');
        }
        if ($request->filled('publisher')) {
            $query->where('publisher', 'like', '%' . $request->input('publisher') . '%');
        }
        if ($request->filled('from')) {
            $query->where('publication_date', '>=', $request->input('from'));
        }
        if ($request->filled('to')) {
            $query->where('publication_date', '<=', $request->input('to'));
        }

        if ($request->filled('text')) {
            $query->whereHas('file', function ($q) use ($request) {
                $q->where('text_content', 'like', '%' . $request->input('text') . '%');
            });
        }

        if ($request->filled('type') && $request->input('type') !== 'All') {
            $query->where('publication_type', Publication::getPublicationTypeIdByType($request->input('type')));
        }

        return $query->get();
    }
}
