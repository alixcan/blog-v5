<?php

namespace App\Filament\Resources\PostResource\Pages;

use App\Jobs\RecommendPosts;
use App\Filament\Resources\PostResource;
use Filament\Resources\Pages\CreateRecord;

class CreatePost extends CreateRecord
{
    protected static string $resource = PostResource::class;

    protected function afterCreate() : void
    {
        RecommendPosts::dispatch($this->record);
    }
}
