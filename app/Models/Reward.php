<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder as EloquentBuilder;

class Reward extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function scopeWithCollected(EloquentBuilder $query): void
    {
        $rewards = $this->getTable();
        $donations = (new Donation())->getTable();

        $subquery = Donation::selectRaw("SUM(`{$donations}`.`amount`)")
            ->whereRaw("`{$donations}`.reward_id = `{$rewards}`.id");

        $query->select("{$rewards}.*")->selectSub($subquery, 'collected');
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }
}
