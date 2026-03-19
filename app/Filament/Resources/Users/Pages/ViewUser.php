<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Resources\Users\UserResource;
use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord;
use Filament\Schemas\Schema;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }


    public function content(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->hasInfolist() // This method returns `true` if the page has an infolist defined
                    ? $this->getInfolistContentComponent() // This method returns a component to display the infolist that is defined in this resource
                    : $this->getFormContentComponent(), // This method returns a component to display the form that is defined in this resource
                $this->getRelationManagersContentComponent(), // This method returns a component to display the relation managers that are defined in this resource
            ]);
    }
}
