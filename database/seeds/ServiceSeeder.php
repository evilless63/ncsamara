<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Service::truncate();
        DB::table('services')->insert([ //1
            'name' => 'Секс',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //2
            'name' => 'Ласки',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //3
            'name' => 'Окончание',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //4
            'name' => 'БДСМ',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //5
            'name' => 'Экстрим',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //6
            'name' => 'Стриптиз',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //7
            'name' => 'Массаж',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //8
            'name' => 'Лесби шоу',
            'is_category' => true,
            'parent_id' => null
        ]);

        DB::table('services')->insert([ //9
            'name' => 'Дополнительно',
            'is_category' => true,
            'parent_id' => null
        ]);

            DB::table('services')->insert([ 
                'name' => 'Классический',
                'is_category' => false,
                'parent_id' => 1
            ]);
            DB::table('services')->insert([ 
                'name' => 'Анальный',
                'is_category' => false,
                'parent_id' => 1
            ]);
            DB::table('services')->insert([ 
                'name' => 'Групповой ',
                'is_category' => false,
                'parent_id' => 1
            ]);


        

            DB::table('services')->insert([ 
                'name' => 'В презервативе',
                'is_category' => false,
                'parent_id' => 2
            ]);
            DB::table('services')->insert([ 
                'name' => 'Без преерватива',
                'is_category' => false,
                'parent_id' => 2
            ]);
            DB::table('services')->insert([ 
                'name' => 'Глубокий',
                'is_category' => false,
                'parent_id' => 2
            ]);

            DB::table('services')->insert([ 
                'name' => 'В машине',
                'is_category' => false,
                'parent_id' => 2
            ]);
            DB::table('services')->insert([ 
                'name' => 'Кунилингус делаю',
                'is_category' => false,
                'parent_id' => 2
            ]);
            DB::table('services')->insert([ 
                'name' => 'Кунилингус принимаю',
                'is_category' => false,
                'parent_id' => 2
            ]);

            DB::table('services')->insert([ 
                'name' => 'Анилингус делаю',
                'is_category' => false,
                'parent_id' => 2
            ]);
            DB::table('services')->insert([ 
                'name' => 'Анилингус принимаю',
                'is_category' => false,
                'parent_id' => 2
            ]);


       
            DB::table('services')->insert([ 
                'name' => 'В рот',
                'is_category' => false,
                'parent_id' => 3
            ]);

            DB::table('services')->insert([ 
                'name' => 'На грудь',
                'is_category' => false,
                'parent_id' => 3
            ]);

            DB::table('services')->insert([ 
                'name' => 'На лицо',
                'is_category' => false,
                'parent_id' => 3
            ]);

        

            DB::table('services')->insert([ 
                'name' => 'Бандаж',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Госпожа',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Ролевые игры',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Легкая доминация',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Порка',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Рабыня',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Фетиш',
                'is_category' => false,
                'parent_id' => 4
            ]);

            DB::table('services')->insert([ 
                'name' => 'Трамплинг',
                'is_category' => false,
                'parent_id' => 4
            ]);

        

            DB::table('services')->insert([ 
                'name' => 'Страпон',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Игрушки',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Золотой дождь делаю',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Золотой дождь принимаю',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Фистинг анальный делаю',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Фистинг анальный принимаю',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Фистинг класический делаю',
                'is_category' => false,
                'parent_id' => 5
            ]);

            DB::table('services')->insert([ 
                'name' => 'Фистинг класический принимаю',
                'is_category' => false,
                'parent_id' => 5
            ]);

        

            DB::table('services')->insert([ 
                'name' => 'Профи',
                'is_category' => false,
                'parent_id' => 6
            ]);

            DB::table('services')->insert([ 
                'name' => 'Не профи',
                'is_category' => false,
                'parent_id' => 6
            ]);

        

            DB::table('services')->insert([ 
                'name' => 'Классический',
                'is_category' => false,
                'parent_id' => 7
            ]);

            DB::table('services')->insert([ 
                'name' => 'Профессиональный',
                'is_category' => false,
                'parent_id' => 7
            ]);

            DB::table('services')->insert([ 
                'name' => 'Расслабляющий',
                'is_category' => false,
                'parent_id' => 7
            ]);

            DB::table('services')->insert([ 
                'name' => 'Тайский',
                'is_category' => false,
                'parent_id' => 7
            ]);

            DB::table('services')->insert([ 
                'name' => 'Урологический',
                'is_category' => false,
                'parent_id' => 7
            ]);

            DB::table('services')->insert([ 
                'name' => 'Эротический',
                'is_category' => false,
                'parent_id' => 7
            ]);

            DB::table('services')->insert([ 
                'name' => 'Ветка сакуры',
                'is_category' => false,
                'parent_id' => 7
            ]);

        

            DB::table('services')->insert([ 
                'name' => 'Откровенное',
                'is_category' => false,
                'parent_id' => 8
            ]);

            DB::table('services')->insert([ 
                'name' => 'Легкое',
                'is_category' => false,
                'parent_id' => 8
            ]);

        

            DB::table('services')->insert([ //9
                'name' => 'Фото/Видео',
                'is_category' => false,
                'parent_id' => 9
            ]);

            DB::table('services')->insert([ //9
                'name' => 'Эскорт',
                'is_category' => false,
                'parent_id' => 9
            ]);

            DB::table('services')->insert([ //9
                'name' => 'Услуги семейной паре',
                'is_category' => false,
                'parent_id' => 9
            ]);
    }
}
