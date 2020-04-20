<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Node
 * @package App\Models
 * @property string $data
 * @property Collection $children of Node
 * @property Collection $parents of Node
 */
class Node extends Model
{

    protected $guarded = [];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function parents()
    {
        return $this->belongsToMany(Node::class, Tie::TABLE, Tie::DEST_COLUMN, Tie::SRC_COLUMN)
            ->withPivot(Tie::REF_COLUMN, 'rank')
            ->withTimestamps();
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(Node::class, Tie::TABLE, Tie::SRC_COLUMN, Tie::DEST_COLUMN)
            ->withPivot(Tie::REF_COLUMN,'rank')
            ->withTimestamps();
    }

    /**
     * @param Node|null $ref
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function childrenRef(Node $ref = null)
    {
        return $this->children()->wherePivot(Tie::REF_COLUMN, $ref?$ref->getKey():0);
    }

    /**
     * @param Node $child
     * @param Node|null $ref
     * @param int|null $rank
     */
    public function addChild(Node $child, Node $ref = null, int $rank = null)
    {
        $tie = new Tie();
        $tie->src()->associate($this);
        $tie->dest()->associate($child);

        if ($ref) {
            $tie->ref()->associate($ref);
        }else{
            $tie->setAttribute(Tie::REF_COLUMN,0);
        }
        if ($rank) {
            $tie->rank = $rank;
        }
        $tie->save();
    }
}