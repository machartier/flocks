<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Tie
 * @package App\Models
 * @property int $src
 * @property int $dest
 * @property int $ref
 */
class Tie extends Model
{
    const DEST_COLUMN = 'dest';
    const SRC_COLUMN = 'src';
    const REF_COLUMN = 'ref';
    const TABLE = 'ties';

    public $incrementing = false;

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function src()
    {
        return $this->belongsTo(Node::class, self::SRC_COLUMN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dest()
    {
        return $this->belongsTo(Node::class, self::DEST_COLUMN);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ref()
    {
        return $this->belongsTo(Node::class, self::REF_COLUMN);
    }
}
