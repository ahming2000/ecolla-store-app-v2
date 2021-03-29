<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class ImportExampleData extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::table('items')->insert(
            array(
                'id' => 1,
                'name' => '脉动维生素功能饮料',
                'name_en' => 'MaiDong Energy Drink',
                'desc' => '好喝的饮料 Delicious Drink',
                'brand' => '脉动',
                'brand_en' => 'Mai Dong',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('items')->insert(
            array(
                'id' => 2,
                'name' => '好味屋手撕素肉排',
                'name_en' => 'Hao Wei Wu Vege Steak',
                'desc' => '面筋制品 Made from bean',
                'brand' => '好味屋',
                'brand_en' => 'Hao Wei Wu',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('items')->insert(
            array(
                'id' => 3,
                'name' => '湖湘贡鹌鹑蛋',
                'name_en' => 'Hu Xiang Gong Quail Eggs',
                'desc' => '风味鸳鸯蛋 Flavored quail eggs',
                'brand' => '湖湘贡',
                'brand_en' => 'Hu Xiang Gong',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('items')->insert(
            array(
                'id' => 4,
                'name' => 'RIO鸡尾酒',
                'name_en' => 'RIO Cocktail',
                'desc' => '精美玻璃，漂亮的颜色的鸡尾酒 Beautiful Bottle',
                'brand' => 'RIO',
                'brand_en' => 'RIO',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );
        DB::table('items')->insert(
            array(
                'id' => 5,
                'name' => 'RIO微醺鸡尾酒',
                'name_en' => 'RIO Cocktail Tin',
                'desc' => '来一杯，享受好时光 Enjoy life',
                'brand' => 'RIO',
                'brand_en' => 'RIO',
                'origin' => '中国',
                'origin_en' => 'China'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 1,
                'item_id' => 1,
                'image' => 'img/items/1/0.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 2,
                'item_id' => 1,
                'image' => 'img/items/1/1.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 3,
                'item_id' => 1,
                'image' => 'img/items/1/2.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 4,
                'item_id' => 1,
                'image' => 'img/items/1/3.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 5,
                'item_id' => 2,
                'image' => 'img/items/2/0.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 6,
                'item_id' => 2,
                'image' => 'img/items/2/1.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 7,
                'item_id' => 2,
                'image' => 'img/items/2/2.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 8,
                'item_id' => 2,
                'image' => 'img/items/2/3.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 9,
                'item_id' => 2,
                'image' => 'img/items/2/4.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 10,
                'item_id' => 3,
                'image' => 'img/items/3/0.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 11,
                'item_id' => 3,
                'image' => 'img/items/3/1.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 12,
                'item_id' => 3,
                'image' => 'img/items/3/2.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 13,
                'item_id' => 3,
                'image' => 'img/items/3/3.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 14,
                'item_id' => 3,
                'image' => 'img/items/3/4.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 15,
                'item_id' => 4,
                'image' => 'img/items/4/0.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 16,
                'item_id' => 4,
                'image' => 'img/items/4/1.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 17,
                'item_id' => 4,
                'image' => 'img/items/4/2.jpg'
            )
        );

        DB::table('item_images')->insert(
            array(
                'id' => 18,
                'item_id' => 5,
                'image' => 'img/items/5/0.jpg'
            )
        );

        DB::table('item_utils')->insert(
            array(
                'id' => 1,
                'is_listed' => 1,
                'view_count' => 0
            )
        );

        DB::table('item_utils')->insert(
            array(
                'id' => 2,
                'is_listed' => 1,
                'view_count' => 0
            )
        );

        DB::table('item_utils')->insert(
            array(
                'id' => 3,
                'is_listed' => 1,
                'view_count' => 0
            )
        );

        DB::table('item_utils')->insert(
            array(
                'id' => 4,
                'is_listed' => 1,
                'view_count' => 0
            )
        );

        DB::table('item_utils')->insert(
            array(
                'id' => 5,
                'is_listed' => 1,
                'view_count' => 0
            )
        );

        DB::table('wholesale_discounts')->insert(
            array(
                'id' => 1,
                'item_id' => 2,
                'min' => 20,
                'max' => 29,
                'rate' => 0.866667
            )
        );

        DB::table('wholesale_discounts')->insert(
            array(
                'id' => 2,
                'item_id' => 2,
                'min' => 30,
                'max' => 39,
                'rate' => 0.8
            )
        );

        DB::table('wholesale_discounts')->insert(
            array(
                'id' => 3,
                'item_id' => 2,
                'min' => 40,
                'max' => 49,
                'rate' => 0.733333
            )
        );

        DB::table('wholesale_discounts')->insert(
            array(
                'id' => 4,
                'item_id' => 2,
                'min' => 50,
                'max' => 59,
                'rate' => 0.933333
            )
        );


        DB::table('variations')->insert(
            array(
                'id' => 1,
                'barcode' => '6902538004045',
                'name1' => '青柠味',
                'name2' => '600ml',
                'name1_en' => 'Lime Flavour',
                'name2_en' => '600ml',
                'weight' => 0.6,
                'price' => 4.8,
                'image' => 'img/items/1/6902538004045.jpg',
                'item_id' => 1
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 2,
                'barcode' => '6902538005141',
                'name1' => '水蜜桃味',
                'name2' => '600ml',
                'name1_en' => 'Peach Flavour',
                'name2_en' => '600ml',
                'weight' => 0.6,
                'price' => 4.8,
                'image' => 'img/items/1/6902538005141.jpg',
                'item_id' => 1
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 3,
                'barcode' => '6902538007367',
                'name1' => '芒果味',
                'name2' => '600ml',
                'name1_en' => 'Mango Flavour',
                'name2_en' => '600ml',
                'weight' => 0.6,
                'price' => 4.8,
                'image' => 'img/items/1/6902538007367.jpg',
                'item_id' => 1
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 4,
                'barcode' => '6902538007381',
                'name1' => '仙人掌青橘味',
                'name2' => '600ml',
                'name1_en' => 'Cactus Green Orange Flavour',
                'name2_en' => '600ml',
                'weight' => 0.6,
                'price' => 4.8,
                'image' => 'img/items/1/6902538007381.jpg',
                'item_id' => 1
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 5,
                'barcode' => '6902538007862',
                'name1' => '竹子青提味',
                'name2' => '500ml',
                'name1_en' => 'Bamboo Green Tea Flavour',
                'name2_en' => '500ml',
                'weight' => 0.5,
                'price' => 4.8,
                'image' => 'img/items/1/6902538007862.jpg',
                'item_id' => 1
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 6,
                'barcode' => '6902538007886',
                'name1' => '卡曼橘味',
                'name2' => '500ml',
                'name1_en' => 'Lime Flavour',
                'name2_en' => '500ml',
                'weight' => 0.5,
                'price' => 4.8,
                'image' => 'img/items/1/6902538007886.jpg',
                'item_id' => 1
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 7,
                'barcode' => '6931754804900',
                'name1' => '香辣味',
                'name2' => '26g',
                'name1_en' => 'Spicy Flavour',
                'name2_en' => '26g',
                'weight' => 0.026,
                'price' => 1.5,
                'image' => 'img/items/2/6931754804900.jpg',
                'item_id' => 2
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 8,
                'barcode' => '6931754804917',
                'name1' => '黑椒味',
                'name2' => '26g',
                'name1_en' => 'Black Pepper Flavour',
                'name2_en' => '26g',
                'weight' => 0.026,
                'price' => 1.5,
                'image' => 'img/items/2/6931754804917.jpg',
                'item_id' => 2
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 9,
                'barcode' => '6931754804924',
                'name1' => '山椒味',
                'name2' => '26g',
                'name1_en' => 'Shasho Flavour',
                'name2_en' => '26g',
                'weight' => 0.026,
                'price' => 1.5,
                'image' => 'img/items/2/6931754804924.jpg',
                'item_id' => 2
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 10,
                'barcode' => '6931754804931',
                'name1' => '烧烤味',
                'name2' => '26g',
                'name1_en' => 'BBQ Flavour',
                'name2_en' => '26g',
                'weight' => 0.026,
                'price' => 1.5,
                'image' => 'img/items/2/6931754804931.jpg',
                'item_id' => 2
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 11,
                'barcode' => '6931754805655',
                'name1' => '黑鸭味',
                'name2' => '26g',
                'name1_en' => 'Duck Flavour',
                'name2_en' => '26g',
                'weight' => 0.026,
                'price' => 1.5,
                'image' => 'img/items/2/6931754805655.jpg',
                'item_id' => 2
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 12,
                'barcode' => '6935145301016',
                'name1' => '青柠',
                'name2' => '275ml',
                'name1_en' => 'Lime Flavour',
                'name2_en' => '275ml',
                'weight' => 0.275,
                'price' => 11.5,
                'image' => 'img/items/5/6935145301016.jpg',
                'item_id' => 5
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 13,
                'barcode' => '6935145301030',
                'name1' => '水蜜桃',
                'name2' => '275ml',
                'name1_en' => 'Peach Flavour',
                'name2_en' => '275ml',
                'weight' => 0.275,
                'price' => 11.5,
                'image' => 'img/items/5/6935145301030.jpg',
                'item_id' => 5
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 14,
                'barcode' => '6935145301047',
                'name1' => '蓝玫瑰',
                'name2' => '275ml',
                'name1_en' => 'Blue Rose Flavour',
                'name2_en' => '275ml',
                'weight' => 0.275,
                'price' => 11.5,
                'image' => 'img/items/5/6935145301047.jpg',
                'item_id' => 5
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 15,
                'barcode' => '6935145301061',
                'name1' => '混合水果',
                'name2' => '275ml',
                'name1_en' => 'Mix Fruit Flavour',
                'name2_en' => '275ml',
                'weight' => 0.275,
                'price' => 11.5,
                'image' => 'img/items/5/6935145301061.jpg',
                'item_id' => 5
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 16,
                'barcode' => '6935145301078',
                'name1' => '紫葡萄',
                'name2' => '275ml',
                'name1_en' => 'Purple Grape Flavour',
                'name2_en' => '275ml',
                'weight' => 0.275,
                'price' => 11.5,
                'image' => 'img/items/5/6935145301078.jpg',
                'item_id' => 5
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 17,
                'barcode' => '6935145343030',
                'name1' => '白桃+白兰地',
                'name2' => '330ml',
                'name1_en' => 'Peach + Brandy Flavour',
                'name2_en' => '330ml',
                'weight' => 0.33,
                'price' => 8.8,
                'image' => 'img/items/4/6935145343030.jpg',
                'item_id' => 4
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 18,
                'barcode' => '6935145343047',
                'name1' => '葡萄+白兰地',
                'name2' => '330ml',
                'name1_en' => 'Grape + Brandy Flavour',
                'name2_en' => '330ml',
                'weight' => 0.33,
                'price' => 8.8,
                'image' => 'img/items/4/6935145343047.jpg',
                'item_id' => 4
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 19,
                'barcode' => '6935145343061',
                'name1' => '玫瑰+荔枝',
                'name2' => '330ml',
                'name1_en' => 'Rose + Litchi Flavour',
                'name2_en' => '330ml',
                'weight' => 0.33,
                'price' => 8.8,
                'image' => 'img/items/4/6935145343061.jpg',
                'item_id' => 4
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 20,
                'barcode' => '6935145343092',
                'name1' => '果茶乐橘乌龙',
                'name2' => '330ml',
                'name1_en' => 'Nectar Orange Oolong Flavour',
                'name2_en' => '330ml',
                'weight' => 0.33,
                'price' => 8.8,
                'image' => 'img/items/4/6935145343092.jpg',
                'item_id' => 4
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 21,
                'barcode' => '6941025700084',
                'name1' => '香辣味',
                'name2' => '20g',
                'name1_en' => 'Spicy Flavour',
                'name2_en' => '20g',
                'weight' => 0.02,
                'price' => 1.2,
                'image' => 'img/items/3/6935145343092.jpg',
                'item_id' => 3
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 22,
                'barcode' => '6941025700138',
                'name1' => '盐焗味',
                'name2' => '20g',
                'name1_en' => 'Salt Baked Flavour',
                'name2_en' => '20g',
                'weight' => 0.02,
                'price' => 1.2,
                'image' => 'img/items/3/6941025700138.jpg',
                'item_id' => 3
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 23,
                'barcode' => '6941025701074',
                'name1' => '卤蛋味',
                'name2' => '20g',
                'name1_en' => 'Marinated Egg Flavour',
                'name2_en' => '20g',
                'weight' => 0.02,
                'price' => 1.2,
                'image' => 'img/items/3/6941025701074.jpg',
                'item_id' => 3
            )
        );

        DB::table('variations')->insert(
            array(
                'id' => 24,
                'barcode' => '6941025702019',
                'name1' => '泡辣味',
                'name2' => '20g',
                'name1_en' => 'Foam Flavour',
                'name2_en' => '20g',
                'weight' => 0.02,
                'price' => 1.2,
                'image' => 'img/items/5/6941025702019.jpg',
                'item_id' => 3
            )
        );

        DB::table('variation_discounts')->insert(
            array(
                'id' => 1,
                'variation_id' => 2,
                'start' => '2021-01-01 00:00:00',
                'rate' => 0.520833
            )
        );

        DB::table('variation_discounts')->insert(
            array(
                'id' => 2,
                'variation_id' => 8,
                'start' => '2021-01-01 00:00:00',
                'end' => '2021-04-01 00:00:00',
                'rate' => 0.8
            )
        );

        DB::table('variation_discounts')->insert(
            array(
                'id' => 3,
                'variation_id' => 17,
                'start' => '2021-01-01 00:00:00',
                'end' => '2021-06-01 00:00:00',
                'rate' => 0.58
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 1,
                'variation_id' => 1,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 25,
                'variation_id' => 1,
                'expire_date' => '2022-05-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 2,
                'variation_id' => 2,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 3,
                'variation_id' => 3,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 4,
                'variation_id' => 4,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 5,
                'variation_id' => 5,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 6,
                'variation_id' => 6,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 7,
                'variation_id' => 7,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 8,
                'variation_id' => 8,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 9,
                'variation_id' => 9,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 10,
                'variation_id' => 10,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 11,
                'variation_id' => 11,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 12,
                'variation_id' => 12,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 13,
                'variation_id' => 13,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 14,
                'variation_id' => 14,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 15,
                'variation_id' => 15,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 16,
                'variation_id' => 16,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 17,
                'variation_id' => 17,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 18,
                'variation_id' => 18,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 19,
                'variation_id' => 19,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 20,
                'variation_id' => 20,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 21,
                'variation_id' => 21,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 22,
                'variation_id' => 22,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 23,
                'variation_id' => 23,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('inventories')->insert(
            array(
                'id' => 24,
                'variation_id' => 24,
                'expire_date' => '2022-01-01',
                'stock' => 300
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 8,
                'name' => '饮料',
                'name_en' => 'Beverage'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 9,
                'name' => '零食',
                'name_en' => 'Snack'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 3,
                'name' => '素食',
                'name_en' => 'Vegetarian Friendly'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 4,
                'name' => '小零食',
                'name_en' => 'Pocket Snack'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 5,
                'name' => '维生素饮品',
                'name_en' => 'Vitamin Drink'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 7,
                'name' => '酒精饮品',
                'name_en' => 'Alcohol'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 1,
                'name' => '热卖',
                'name_en' => 'Hot Selling'
            )
        );

        DB::table('categories')->insert(
            array(
                'id' => 2,
                'name' => '新品',
                'name_en' => 'New Product'
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 1,
                'category_id' => 1
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 4,
                'category_id' => 1
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 5,
                'category_id' => 1
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 2,
                'category_id' => 2
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 3,
                'category_id' => 2
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 2,
                'category_id' => 3
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 3,
                'category_id' => 3
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 2,
                'category_id' => 4
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 3,
                'category_id' => 4
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 1,
                'category_id' => 5
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 4,
                'category_id' => 7
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 5,
                'category_id' => 7
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 1,
                'category_id' => 8
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 2,
                'category_id' => 8
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 3,
                'category_id' => 8
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 4,
                'category_id' => 8
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 5,
                'category_id' => 8
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 1,
                'category_id' => 9
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 2,
                'category_id' => 9
            )
        );

        DB::table('classifications')->insert(
            array(
                'item_id' => 3,
                'category_id' => 9
            )
        );

        DB::table('orders')->insert(
            array(
                'id' => 1,
                'code' => 'ECOLLA20210317143138',
                'mode' => 'delivery',
                // 'delivery_id' => '',
                // 'order_verify_id' => '',
                'shipping_fee' => 2.0,
                'payment_method' => 'tng',
                'status' => 'pending',
                'receipt_image' => 'img/orders/ECOLLA20210317143138.jpg'
            )
        );

        DB::table('orders')->insert(
            array(
                'id' => 2,
                'code' => 'ECOLLA20210117154008',
                'mode' => 'delivery',
                'delivery_id' => 'J&TABCD1234',
                // 'order_verify_id' => '',
                'shipping_fee' => 2.0,
                'payment_method' => 'boost',
                'status' => 'completed',
                'receipt_image' => 'img/orders/ECOLLA20210117154008.jpg'
            )
        );

        DB::table('orders')->insert(
            array(
                'id' => 3,
                'code' => 'ECOLLA20210317143138',
                'mode' => 'delivery',
                 'delivery_id' => 'J&TABCD1234',
                // 'order_verify_id' => '',
                'shipping_fee' => 2.0,
                'payment_method' => 'bank-in',
                'status' => 'refunded',
                'receipt_image' => 'img/orders/ECOLLA20210317143138.jpg'
            )
        );

        DB::table('orders')->insert(
            array(
                'id' => 4,
                'code' => 'ECOLLA20210112103353',
                'mode' => 'delivery',
                // 'delivery_id' => '',
                // 'order_verify_id' => '',
                'shipping_fee' => 2.0,
                'payment_method' => 'quin-pay',
                'status' => 'canceled',
                'receipt_image' => 'img/orders/ECOLLA20210112103353.jpg'
            )
        );

        DB::table('orders')->insert(
            array(
                'id' => 5,
                'code' => 'ECOLLA20210109083102',
                'mode' => 'delivery',
                'delivery_id' => 'J&TABCD1234',
                // 'order_verify_id' => '',
                'shipping_fee' => 2.0,
                'payment_method' => 'duit-now',
                'status' => 'prepared',
                'receipt_image' => 'img/orders/ECOLLA20210109083102.jpg'
            )
        );

        DB::table('orders')->insert(
            array(
                'id' => 6,
                'code' => 'ECOLLA20210111081323',
                'mode' => 'pickup',
                // 'delivery_id' = '',
                'order_verify_id' => '2123',
                'payment_method' => 'tng',
                'status' => 'pending',
                'receipt_image' => 'img/orders/ECOLLA20210111081323.jpg'
            )
        );

        DB::table('customers')->insert(
            array(
                'id' => 1,
                'name' => 'Alex Lee',
                'phone' => '0132323232',
                'addressLine1' => '1, Jalan Kampar 30',
                'postal_code' => '31900',
                'area' => 'Kampar',
                'state' => 'Perak',
                'country' => 'Malaysia'
            )
        );

        DB::table('customers')->insert(
            array(
                'id' => 2,
                'name' => 'Alex Lee',
                'phone' => '0132323232',
                'addressLine1' => '1, Jalan Kampar 30',
                'postal_code' => '31900',
                'area' => 'Kampar',
                'state' => 'Perak',
                'country' => 'Malaysia'
            )
        );

        DB::table('customers')->insert(
            array(
                'id' => 3,
                'name' => 'Alex Lee',
                'phone' => '0132323232',
                'addressLine1' => '1, Jalan Kampar 30',
                'postal_code' => '31900',
                'area' => 'Kampar',
                'state' => 'Perak',
                'country' => 'Malaysia'
            )
        );

        DB::table('customers')->insert(
            array(
                'id' => 4,
                'name' => 'Alex Lee',
                'phone' => '0132323232',
                'addressLine1' => '1, Jalan Kampar 30',
                'postal_code' => '31900',
                'area' => 'Kampar',
                'state' => 'Perak',
                'country' => 'Malaysia'
            )
        );

        DB::table('customers')->insert(
            array(
                'id' => 5,
                'name' => 'Alex Lee',
                'phone' => '0132323232',
                'addressLine1' => '1, Jalan Kampar 30',
                'postal_code' => '31900',
                'area' => 'Kampar',
                'state' => 'Perak',
                'country' => 'Malaysia'
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 1,
                'order_id' => 1,
                'name' => '脉动维生素功能饮料 青柠味600ml',
                'barcode' => '6902538004045',
                'price' => 4.8,
                'discount_rate' => 1.0,
                'quantity' => 3,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 2,
                'order_id' => 1,
                'name' => '好味屋手撕素肉排 香辣味26g',
                'barcode' => '6931754804900',
                'price' => 1.5,
                'discount_rate' => 0.8,
                'quantity' => 45,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 3,
                'order_id' => 2,
                'name' => '好味屋手撕素肉排 香辣味26g',
                'barcode' => '6931754804900',
                'price' => 1.5,
                'discount_rate' => 0.733333,
                'quantity' => 50,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 4,
                'order_id' => 3,
                'name' => '好味屋手撕素肉排 香辣味26g',
                'barcode' => '6931754804900',
                'price' => 1.5,
                'discount_rate' => 0.8,
                'quantity' => 45,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 5,
                'order_id' => 4,
                'name' => '好味屋手撕素肉排 香辣味26g',
                'barcode' => '6931754804900',
                'price' => 1.5,
                'discount_rate' => 0.6,
                'quantity' => 60,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 6,
                'order_id' => 4,
                'name' => 'RIO鸡尾酒 水蜜桃275ml',
                'barcode' => '6935145301030',
                'price' => 11.5,
                'discount_rate' => 0.9,
                'quantity' => 1,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 7,
                'order_id' => 5,
                'name' => '好味屋手撕素肉排 香辣味26g',
                'barcode' => '6931754804900',
                'price' => 1.5,
                'discount_rate' => 1.0,
                'quantity' => 1,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 8,
                'order_id' => 5,
                'name' => 'RIO鸡尾酒 水蜜桃275ml',
                'barcode' => '6935145301030',
                'price' => 11.5,
                'discount_rate' => 1.0,
                'quantity' => 1,
                'expire_date' => '2022-01-01',
            )
        );

        DB::table('order_items')->insert(
            array(
                'id' => 9,
                'order_id' => 5,
                'name' => '脉动维生素功能饮料 水蜜桃味600ml',
                'barcode' => '6902538005141',
                'price' => 4.8,
                'discount_rate' => 0.520833,
                'quantity' => 2,
                'expire_date' => '2022-01-01',
            )
        );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table('items')->where('id', '=', 1)->delete();
        DB::table('items')->where('id', '=', 2)->delete();
        DB::table('items')->where('id', '=', 3)->delete();
        DB::table('items')->where('id', '=', 4)->delete();
        DB::table('items')->where('id', '=', 5)->delete();
        DB::table('orders')->where('id', '=', 1)->delete();
        DB::table('orders')->where('id', '=', 2)->delete();
        DB::table('orders')->where('id', '=', 3)->delete();
        DB::table('orders')->where('id', '=', 4)->delete();
        DB::table('orders')->where('id', '=', 5)->delete();
        DB::table('categories')->where('id', '=', 1)->delete();
        DB::table('categories')->where('id', '=', 2)->delete();
        DB::table('categories')->where('id', '=', 3)->delete();
        DB::table('categories')->where('id', '=', 4)->delete();
        DB::table('categories')->where('id', '=', 5)->delete();
        DB::table('categories')->where('id', '=', 7)->delete();
        DB::table('categories')->where('id', '=', 8)->delete();
        DB::table('categories')->where('id', '=', 9)->delete();
    }
}
