<?php


namespace Tests\Unit\Services;


use App\Models\Node;
use App\Services\Hierarchy;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\CreatesApplication;
use Tests\TestCase;

class HierarchyTest extends TestCase
{

    use CreatesApplication;
    use RefreshDatabase;

    public function testGetRoots(){
        $nodeA = Node::create(['data'=>'A']);
        $nodeB = Node::create(['data'=>'B']);
        $nodeC = Node::create(['data'=>'C']);
        $nodeD = Node::create(['data'=>'D']);

        $nodeA->addChild($nodeC);
        $nodeC->addChild($nodeD);

        $nodeC->addChild($nodeD, $nodeA);
        $nodeD->addChild($nodeB, $nodeA);


        $roots = app(Hierarchy::class)->getRoots();

        $this->assertCount(2, $roots);
        $this->assertTrue($roots->contains($nodeA));
        $this->assertTrue($roots->contains($nodeB));
        $this->assertFalse($roots->contains($nodeC));
        $this->assertFalse($roots->contains($nodeD));

        $rootsContext = app(Hierarchy::class)->getRoots($nodeA);
        $this->assertCount(1, $rootsContext);
        $this->assertTrue($rootsContext->contains($nodeC));
    }
}