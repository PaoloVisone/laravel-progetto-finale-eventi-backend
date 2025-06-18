<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Concerti',
                'description' => 'Eventi musicali e concerti dal vivo',
                'color' => '#FF6B6B',
                'slug' => 'concerti'
            ],
            [
                'name' => 'Sport',
                'description' => 'Eventi sportivi e competizioni',
                'color' => '#4ECDC4',
                'slug' => 'sport'
            ],
            [
                'name' => 'Teatro',
                'description' => 'Spettacoli teatrali e performance artistiche',
                'color' => '#45B7D1',
                'slug' => 'teatro'
            ],
            [
                'name' => 'Conferenze',
                'description' => 'Seminari, workshop e conferenze professionali',
                'color' => '#FFA07A',
                'slug' => 'conferenze'
            ],
            [
                'name' => 'Festival',
                'description' => 'Festival musicali, culturali e gastronomici',
                'color' => '#98D8C8',
                'slug' => 'festival'
            ],
            [
                'name' => 'Arte',
                'description' => 'Mostre d\'arte, gallerie e eventi culturali',
                'color' => '#FFBE0B',
                'slug' => 'arte'
            ]
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}
