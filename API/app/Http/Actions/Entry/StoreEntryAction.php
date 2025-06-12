<?php

namespace App\Http\Actions\Entry;

use App\Models\Entry;

class StoreEntryAction
{

    public function __invoke(array $data)
    {
        $entry = new Entry($data);
        $entry->save();
        return $entry;
    }
}
