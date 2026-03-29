<?php

namespace App\Filament\Infolists\Components;

use Filament\Infolists\Components\Entry;

class SpatieMediaDownloadEntry extends Entry
{
    protected string $view = 'filament.infolists.components.spatie-media-download-entry';

    protected string $collection = 'default';
    
    protected $relation; //J'étais obligé de na pas typer cette variable... les chose de laravel

    public function relation(string $relation): static
    {
        $this->relation = $relation;
        return $this;
    }

    public function collection(string $collection): self
    {
        $this->collection = $collection;
        return $this;
    }

    public function getMedia(): \Illuminate\Support\Collection
    {
        $record = $this->getRecord();

        $rel = $this->relation;

        if($this->relation)
            return $record->$rel->getMedia($this->collection);

        return $record->getMedia($this->collection);

    }


}
