<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = ['About','Career','Vision','Mission'];
        $count = 0;
        foreach($pages as $page){
            Page::create([
                'page_title' => $page,
                'page_image' => '/front/assets/img/about-bg.jpg',
                'page_content' => $page. ' Page. Lorem ipsum, dolor sit amet consectetur adipisicing elit. Quas optio, tenetur ex velit eius harum vitae architecto, sapiente repellat accusamus reprehenderit excepturi inventore itaque dignissimos. Nam sint enim numquam molestiae.',
                'page_slug' => $this->slugify($page),
                'page_order' => ++$count
            ]);
        }
    }

    private function slugify($text, string $divider = '-')
    {
        // Türkçe karakterleri düzenle
        $text = str_replace(
            ['ı', 'İ', 'ş', 'Ş', 'ğ', 'Ğ', 'ü', 'Ü', 'ö', 'Ö', 'ç', 'Ç'],
            ['i', 'I', 's', 'S', 'g', 'G', 'u', 'U', 'o', 'O', 'c', 'C'],
            $text
        );
        
        // replace non letter or digits by divider
        $text = preg_replace('~[^\pL\d]+~u', $divider, $text);

        // transliterate
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

        // remove unwanted characters
        $text = preg_replace('~[^-\w]+~', '', $text);

        // trim
        $text = trim($text, $divider);

        // remove duplicate divider
        $text = preg_replace('~-+~', $divider, $text);

        // lowercase
        $text = strtolower($text);

        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }
}
