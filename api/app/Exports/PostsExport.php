<?php

namespace App\Exports;

use App\Models\Post;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PostsExport implements FromQuery, ShouldQueue, WithHeadings
{
    use Exportable;

    public function query(): Relation|Builder|\Illuminate\Database\Query\Builder
    {
        return Post::query()
            ->select([
                DB::raw('DATE_FORMAT(publish_at, "%Y-%m-%d %H:%i")'),
                'title',
                'headline',
                'users.name',
                'content',
            ])
            ->join('users', 'posts.author_id', '=', 'users.id')
            ->orderBy('publish_at');
    }

    /**
     * @return string[]
     */
    public function headings(): array
    {
        return [
            'Publish At',
            'Title',
            'Headline',
            'Author',
            'Content',
        ];
    }
}
