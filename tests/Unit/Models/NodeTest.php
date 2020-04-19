<?php

namespace Tests\Unit\Models;

use App\Models\Node;
use App\Models\Tie;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;
use Tests\TestCase;

class NodeTest extends TestCase
{
    use CreatesApplication;
    use RefreshDatabase;

    /**
     * @test
     */
    public function add_new_orphan_node(){

        $node = new Node();
        $node->data = 'orphan';
        $node->save();

        $this->assertTrue(true);
    }

    /**
     * @test
     */
    public function add_new_hierarchical_nodes(){

        $nodeA = new Node();
        $nodeA->data = 'node A';
        $nodeA->save();

        $nodeC = new Node();
        $nodeC->data = 'context 1';
        $nodeC->save();

        $nodeB = new Node();
        $nodeB->data = 'node B';
        $nodeB->save();

        $tie = new Tie();
        $tie->src()->associate($nodeA);
        $tie->dest()->associate($nodeB);
        $tie->ref()->associate($nodeC);

        $tie->save();

        $nodeD = new Node();
        $nodeD->data = 'context 2';
        $nodeD->save();

        $tie = new Tie();
        $tie->src()->associate($nodeA);
        $tie->dest()->associate($nodeB);
        $tie->ref()->associate($nodeD);

        $tie->save();

        $parentsA = $nodeA->parents;
        $parentsB = $nodeB->parents;
        $this->assertCount(0, $parentsA);
        $this->assertCount(2, $parentsB);

        $childrenA = $nodeA->children;
        $childrenB = $nodeB->children;
        $this->assertCount(2, $childrenA);
        $this->assertCount(0, $childrenB);

        $nodeA->addChild(Node::create(['data'=>'new child']), $nodeC);
        $nodeA->refresh('children');
        $this->assertCount(3, $nodeA->children);


    }
}