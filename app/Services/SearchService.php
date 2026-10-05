<?php

namespace App\Services;

use App\Models\Project;
use App\Models\BlogPost;
use App\Models\Note;
use App\Models\Skill;
use App\Models\Service;
use Illuminate\Support\Collection;

class SearchService
{
    public function search(string $query): array
    {
        $query = trim($query);

        if ($query === '') {
            return [
                'projects' => collect(),
                'blogs' => collect(),
                'notes' => collect(),
                'skills' => collect(),
                'services' => collect(),
            ];
        }

        return [
            'projects' => Project::query()
                ->where('is_published', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('short_description', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->latest()
                ->get(),

            'blogs' => BlogPost::query()
                ->where('status', 'published')
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('excerpt', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                })
                ->latest('published_at')
                ->get(),

            'notes' => Note::query()
                ->where('is_published', true)
                ->where(function ($q) use ($query) {
                    $q->where('title', 'like', "%{$query}%")
                        ->orWhere('topic', 'like', "%{$query}%")
                        ->orWhere('content', 'like', "%{$query}%");
                })
                ->latest()
                ->get(),

            'skills' => Skill::query()
                ->where('is_active', true)
                ->where('name', 'like', "%{$query}%")
                ->get(),

            'services' => Service::query()
                ->where('is_active', true)
                ->where(function ($q) use ($query) {
                    $q->where('name', 'like', "%{$query}%")
                        ->orWhere('short_description', 'like', "%{$query}%")
                        ->orWhere('description', 'like', "%{$query}%");
                })
                ->get(),
        ];
    }
}
