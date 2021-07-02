<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlacesTableSeeder extends Seeder
{
    static $types = ['Книга', 'Статья', 'Видео', 'Сайт/Блог', 'Подборка', 'Ключевые идеи книги'];
    static $categoryes = ['Деловые/Бизнес-процессы', 'Деловые/Найм', 'Деловые/Реклама', 'Деловые/Управление бизнесом', 'Деловые/Управление людьми', 'Деловые/Управление проектами', 'Детские/Воспитание', 'Дизайн/Общее', 'Дизайн/Logo', 'Дизайн/Web дизайн', 'Разработка/PHP', 'Разработка/HTML и CSS', 'Разработка/Проектирование'];
    static $materials = [
                        ['Путь джедая', 1, 5, 'Максим Дорофеев', 'Почитать стоит для личного роста'],
                        ['Финансы и инвестиции', 2, 1, '-', 'Научитесь распоряжаться вашими деньгами'],
                        ['Отец', 1, 7, 'Рыбаков Игорь', 'Воспитание ребенка от года до 5 лет'],
                        ['Отец и сын', 3, 7, 'Рыбаков Игорь', 'Как воспитьть чемпиона'],    
                        ];
    static $tags = ['Продуктивность', 'Личная эффективность', 'Ребенок', 'Воспитание', 'Финансы', 'Деньги'];
    static $tags_material = [[1,1],[2,1],[5,2],[6,2],[4,3],[3,3],[3,4]];
    static $links = [
                    [1, 'Купить книгу', 'https://www.mann-ivanov-ferber.ru/books/put-dzhedaya/'],
                    [1, 'Заказать книгу на Ozon', 'https://www.ozon.ru/product/put-dzhedaya-poisk-sobstvennoy-metodiki-produktivnosti-161055633/'],
                    [2, 'Статьи', 'http://www.ereport.ru/articles/finance.htm'],
                    [3, 'Заказать книгу на Ozon', 'https://www.ozon.ru/product/2019-otets-kak-vospitat-chempionov-v-sporte-biznese-i-zhizni-162363701/?utm_source=google&utm_medium=cpc&utm_campaign=RF_Product_Shopping_Books_super&gclid=EAIaIQobChMIl_vy4ovE8QIVIAWiAx2ojwLwEAQYASABEgI2NPD_BwE'],    
                    ];
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach (self::$types as $type) 
        {
            DB::table('type')->insert(['name' => $type]);
        }
        foreach (self::$categoryes as $category) 
        {
            DB::table('category')->insert(['name' => $category]);
        }
        foreach (self::$materials as $material) 
        {
            DB::table('material')->insert(['name' => $material[0],
                                        'fk_id_type'=>$material[1],
                                        'fk_id_category'=>$material[2],
                                        'autors'=>$material[3],
                                        'description'=>$material[4],]);
        }
        foreach (self::$tags as $tag) 
        {
            DB::table('teg')->insert(['name' => $tag]);
        }
        foreach (self::$tags_material as $tag_material) 
        {
            DB::table('tegs_material')->insert(['fk_id_teg' => $tag_material[0],'fk_id_material'=>$tag_material[1]]);
        }
        foreach (self::$links as $link) 
        {
            DB::table('links')->insert(['fk_id_material' => $link[0],
                                        'name'=>$link[1],
                                        'link'=>$link[2],
                                        ]);
        }
    }
}
