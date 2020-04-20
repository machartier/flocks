<?php

namespace App\Services;

use App\Models\Node;
use App\Models\Tie;

class Hierarchy
{
    public function getRoots(Node $ref = null)
    {
        if ($ref) {
            $query = Node::query()
                ->whereHas('children', function ($query) use ($ref) {
                    $query->where(Tie::REF_COLUMN, '=', $ref->getKey());
                })
                ->whereDoesntHave('parents', function ($query) use ($ref) {
                    $query->where(Tie::REF_COLUMN, '=', $ref->getKey());
                });
        } else {
            $query = Node::query()
                ->whereDoesntHave('parents', function ($query) {
                    $query->where(Tie::REF_COLUMN, '=', 0);
                });
        }

        return $query->get();;
    }
}