<?php

namespace App\Models;

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
        return $this->belongsToMany(Node::class, Tie::TABLE, Tie::DEST_COLUMN, Tie::SRC_COLUMN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function children()
    {
        return $this->belongsToMany(Node::class, Tie::TABLE, Tie::SRC_COLUMN, Tie::DEST_COLUMN);
    }

    /**
     * @param Node $child
     * @param Node $context
     * @param int|null $rank
     */
    public function addChild(Node $child, Node $context, int $rank = null)
    {
        $tie       = new Tie();
        $tie->src()->associate($this);
        $tie->dest()->associate($child);

        if ($context) {
            $tie->ref()->associate($context);
        }
        if($rank) {
            $tie->rank = $rank;
        }
        $tie->save();
    }
}