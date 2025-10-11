<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proposal;
use App\Models\ProposalLine;
use App\Models\Entity;
use App\Models\Article;
use Illuminate\Support\Str;
use Carbon\Carbon;

class ProposalSeeder extends Seeder
{
    public function run(): void
    {
        $client = Entity::where('type', 'client')->first();
        $article = Article::first();
        if (!$client || !$article) return;

        $proposal = Proposal::create([
            'number' => 'PROP-' . Str::padLeft(1, 5, '0'),
            'date' => Carbon::today(),
            'client_id' => $client->id,
            'valid_until' => Carbon::today()->addDays(30),
            'total' => 100,
            'status' => 'draft',
        ]);

        ProposalLine::create([
            'proposal_id' => $proposal->id,
            'article_id' => $article->id,
            'supplier_id' => null,
            'quantity' => 2,
            'price' => 50,
            'cost_price' => 40,
        ]);
    }
}
