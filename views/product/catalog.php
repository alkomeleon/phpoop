<h2>Каталог</h2>
<?php foreach ($catalog as $item):?>
    <div>
        <h3><a href="/?c=product&a=card&id=<?=$item['id']?>"><?=$item['name']?></a></h3>
        <p>price: <?=$item['price']?></p>
        <button>Купить</button>
    </div>
<?php endforeach;?>