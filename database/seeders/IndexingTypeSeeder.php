<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\IndexingTypeModel;

class IndexingTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            [
                'indexing_name' => 'Title',
                'description' => 'Indexing by title'
            ],
            [
                'indexing_name' => 'Author',
                'description' => 'Indexing by author name'
            ],
            [
                'indexing_name' => 'Keywords',
                'description' => 'Indexing based on keywords'
            ],
        ];

        foreach ($types as $type) {
            IndexingTypeModel::create($type);
        }
    }
}
