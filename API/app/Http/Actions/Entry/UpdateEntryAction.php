<?php

namespace App\Http\Actions\Entry;

use App\Models\Entry;

class UpdateEntryAction
{
    public function __invoke(Entry $entry, array $data): Entry
    {
        $entry->update($data);
        return $entry->refresh();
    }
}
