<?php

namespace App\Models\Traits;

use App\Models\Group;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

trait Groupable
{
    /**
     * Gets the groups this item belongs to.
     */
    public function groups(): MorphToMany {
        return $this->morphToMany(Group::class, 'groupable');
    }
}
