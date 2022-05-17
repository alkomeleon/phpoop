<?php

class ProductTest extends PHPUnit\Framework\TestCase
{
    public function productProvider()
    {
        return [
            'Пустой объект должен создаваться, иначе PDO fetch все испортит' => [
                null,
                null,
                null,
                true,
            ],
            'Нормальный товар' => ['чай', 'просто чай', 10, true],
            'Пустое название' => [null, 'просто чай', 10, false],
            'Название пустой строкой' => ['', 'просто чай', 10, false],
            'Название из пробелов' => ['   ', 'просто чай', 10, false],
            'Название не строкой' => [[], 'просто чай', 10, false],

            'Пустое описание' => ['чай', null, 10, false],
            'Описание из пустой строки' => ['чай', '', 10, false],
            'Описание из пробелов' => ['чай', '    ', 10, false],
            'Описание не строкой' => ['чай', [], 10, false],

            'Нулевая цена' => ['чай', 'просто чай', 0, false],
            'Отрицательная цена' => ['чай', 'просто чай', -10, false],
            'Пустая цена' => ['чай', 'просто чай', null, false],
            'Цена строкой' => ['чай', 'просто чай', 'фыва', false],
            'Цена массивом' => ['чай', 'просто чай', [], false],
        ];
    }

    /**
     * @dataProvider productProvider
     */
    public function testProductConstructor(
        $name,
        $description,
        $price,
        $expectedResult
    ) {
        if (!$expectedResult) {
            $this->expectException(\Exception::class);
        }
        $product = new \app\models\entities\Product(
            $name,
            $description,
            $price
        );
        $this->assertEquals($name, $product->name);
        $this->assertEquals($description, $product->description);
        $this->assertEquals($price, $product->price);
    }
}
