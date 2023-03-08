<?php

namespace Tests;
class TestData
{
    const companies = [
        [
            'company_id' => '0859100(729/II)',
            'tax_code' => '508770270004',
            'reg_id' => '08-350-290/14',
            'vat_id' => '',
            'name' => 'ZN Servis',
            'country' => 'BA',
            'place' => 'Zvornik',
            'postal_code' => '75400',
            'address' => 'Ulice bb',
            'iban' => '1610250038810038',
            'bank_name' => 'Raiffaisen Banka',
            'phone_num' => '065563246',
            'fax' => '065270592',
            'email' => 'info@znservis.ba',
            'url' => 'www.znservis.ba',
            'logo_url' => 'http:localhost:8000/api/images/testImage.jpg',
            'articles' => [],
        ], [
            'company_id' => '20598964',
            'tax_code' => '106423125',
            'reg_id' => '',
            'vat_id' => '',
            'name' => 'AS - Braća Stanković d.o.o',
            'country' => 'RS',
            'place' => 'Beograd',
            'postal_code' => '11000',
            'address' => 'Borisa Kidriča 1',
            'iban' => '165000700775727634',
            'bank_name' => 'Addiko Bank a.d.',
            'phone_num' => '0114409816',
            'fax' => '',
            'email' => 'posao@asgroup.rs',
            'url' => 'https://asgroup.rs/',
            'logo_url' => 'https://storage-profili-poslovi.infostud.com/893/20210819/ec9c5166c4b5753f2910e0edd79a0c22cb912513b0286ca62a9b38fa03d93256hq',
            'articles' => [
                [
                    'article_id' => 'BAFD336',
                    'serial_num' => '1265445',
                    'name' => 'Kifla AS Klas',
                    'unit' => 'kom',
                    'min_unit' => 1,
                    'max_unit' => 10000,
                    'price' => 59.99,
                    'description' => 'Kifla sa prelivom od cokolade',
                    'image_url' => 'http://localhost:8000/api/images/article4.jpg',
                    'available_quantity' => 10000,
                    'warranty_len' => 0
                ],
                [
                    'article_id' => 'BAFD337',
                    'serial_num' => '1265446',
                    'name' => 'Mleko Moja Kravica',
                    'unit' => 'l',
                    'min_unit' => 1,
                    'max_unit' => 500,
                    'price' => 89.99,
                    'description' => 'Sveže mleko od krave',
                    'image_url' => 'http://localhost:8000/api/images/article5.jpg',
                    'available_quantity' => 5000,
                    'warranty_len' => 2
                ],
            ],
        ],
    ];

    const articles = [
        [
            'article_id' => 'BAFD338',
            'serial_num' => '1265447',
            'name' => 'Jogurt',
            'unit' => 'l',
            'min_unit' => 1,
            'max_unit' => 200,
            'price' => 49.99,
            'description' => 'Prirodni jogurt bez dodataka',
            'image_url' => 'http://localhost:8000/api/images/article6.jpg',
            'available_quantity' => 3000,
            'warranty_len' => 1
        ],
        [
            'article_id' => 'BAFD339',
            'serial_num' => '1265448',
            'name' => 'Ruska salata',
            'unit' => 'kg',
            'min_unit' => 0.5,
            'max_unit' => 20,
            'price' => 159.99,
            'description' => 'Ruska salata sa krompirom, šargarepom i graškom',
            'image_url' => 'http://localhost:8000/api/images/article7.jpg',
            'available_quantity' => 500,
            'warranty_len' => 0
        ],
        [
            'article_id' => 'BAFD340',
            'serial_num' => '1265449',
            'name' => 'Hleb',
            'unit' => 'kom',
            'min_unit' => 1,
            'max_unit' => 50,
            'price' => 49.99,
            'description' => 'Svež hleb sa belim brašnom',
            'image_url' => 'http://localhost:8000/api/images/article8.jpg',
            'available_quantity' => 2000,
            'warranty_len' => 0
        ]
    ];

    const articleDetails = [
        [
            "url" => "www.pizzadelivery.com/cheese-pizza.html",
            "category" => "food",
            "supplier" => "Pizza Delivery Co.",
            "country_origin" => "United States",
            "country_origin_code" => "US",
            "weight" => 400,
            "dimensions" => "16 inch diameter",
            "color" => "Yellow"
        ],
        [
            "url" => "www.organicmarket.com/apples.html",
            "category" => "food",
            "supplier" => "Organic Market Co.",
            "country_origin" => "United States",
            "country_origin_code" => "US",
            "weight" => 1000,
            "dimensions" => "10x10x10",
            "color" => "Red"
        ],
        [
            "url" => "www.cookiesandmore.com/chocolate-chip-cookies.html",
            "category" => "food",
            "supplier" => "Cookies and More Co.",
            "country_origin" => "United States",
            "country_origin_code" => "US",
            "weight" => 250,
            "dimensions" => "8x8x2",
            "color" => "Brown"
        ]
    ];
}
