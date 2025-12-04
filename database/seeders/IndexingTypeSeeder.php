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
                'indexing_name' => 'ISSN',
                'description' => 'Indexing by title'
            ],
            [
                'indexing_name' => 'Google Schollar',
                'description' => 'Indexing by author name'
            ],
            [
                'indexing_name' => 'DOI',
                'description' => 'Indexing based on keywords'
            ],
            [
                'indexing_name' => 'Scopus',
                'description' => 'Indexing by publication year'
            ],
            [
                'indexing_name' => 'Web of Science',
                'description' => 'Indexing by journal impact factor'
            ],
            [
                'indexing_name' => 'DOAJ',
                'description' => 'Indexing for medical and life sciences'
            ],
            [
                'indexing_name' => 'Dimensions',
                'description' => 'Indexing for preprints in various fields'
            ],
        ];

        foreach ($types as $type) {
            IndexingTypeModel::create($type);
        }
    }
}
