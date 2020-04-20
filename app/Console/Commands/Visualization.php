<?php

namespace App\Console\Commands;

use App\Models\Node;
use App\Services\Hierarchy;
use Illuminate\Console\Command;

class visualization extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'flocks:visualization';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $service = app(Hierarchy::class);

        $indents = [0 => ''];
        foreach ($service->getRoots() as $node) {
            $this->displayNode($node, 0, 0, $indents);
        }
    }

    /**
     * @param Node $node
     * @param $level
     */
    public function displayNode(Node $node, $refid, $level, $indents)
    {
        $indent = '';
        $indents[$level] = '    ';
        for ($i = 0; $i < $level; $i++) {
            $indent .= $indents[$i];
        }
        $this->line($indent . ' -> ' . $node->data);

        $children = $node->childrenRef(null)->get();

        foreach ($children as $item) {
            $indents[$level + 1] = '    ';
            $this->displayNode($item, $refid, $level + 1, $indents);

        }
    }
}
