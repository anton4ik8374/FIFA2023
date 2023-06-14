<?php


namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductsTypesSeeder extends Seeder
{
    public function run()
    {
        $typeData = [
            [
                'name' => 'Еда',
                'code' => 1,
                'description' => 'Продукты питания которые едим дома готовим из них',
                'actual' => 1
            ],
            [
                'name' => 'Химия',
                'code' => 2,
                'description' => 'Бытовая химия, косметика',
                'actual' => 1
            ],
            [
                'name' => 'Животные',
                'code' => 3,
                'description' => 'Траты на животных',
                'actual' => 1
            ],
            [
                'name' => 'Софт',
                'code' => 4,
                'description' => 'Траты на программное обеспечение, телефоны покупки виртуальных копий, ключей, сертификатов',
                'actual' => 1
            ],
            [
                'name' => 'Одежда',
                'code' => 5,
                'description' => 'Траты на одежду',
                'actual' => 1
            ],
            [
                'name' => 'Отдых',
                'code' => 6,
                'description' => 'Траты на отдых, рестораны, кафе, фастфуд, увеселительные программы',
                'actual' => 1
            ],
            [
                'name' => 'Привычки',
                'code' => 7,
                'description' => 'Сигареты, алкоголь, и т.п.',
                'actual' => 1
            ],
            [
                'name' => 'Дом',
                'code' => 8,
                'description' => 'Коммунальные услуги, съём, квартплата, ремонт, покупка мебели',
                'actual' => 1
            ],
            [
                'name' => 'Кредиты',
                'code' => 9,
                'description' => 'Платежи по кредитам, долги',
                'actual' => 1
            ],
            [
                'name' => 'Медицина',
                'code' => 10,
                'description' => 'Лекарства, врачи',
                'actual' => 1
            ],
            [
                'name' => 'Машина',
                'code' => 12,
                'description' => 'Расходы на автомобиль',
                'actual' => 1
            ],
            [
                'name' => 'Остальное',
                'code' => 11,
                'description' => 'Все остальные расходы',
                'actual' => 1
            ],
            [
                'name' => 'Дети',
                'code' => 13,
                'description' => 'Дети',
                'actual' => 1
            ],
        ];

        foreach ($typeData as $item) {
            $productType = ProductType::whereCode($item['code'])->first();
            if ($productType) {
                $productType->edit($item);
            } else {
                $productType = ProductType::add($item);
            }
        }
    }
}
