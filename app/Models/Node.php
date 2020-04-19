<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Node
 * @package App\Models
 * @property string $data
 */
class Node extends Model
{

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
}