<?php

use App\DbConnect;

require dirname(__DIR__) . '/vendor/autoload.php';

$faker = Faker\Factory::create('fr_FR');

$pdo = DbConnect::getPDO();

$pdo->exec('SET FOREIGN_KEY_CHECKS = 0');
$pdo->exec('TRUNCATE TABLE post_category');
$pdo->exec('TRUNCATE TABLE post');
$pdo->exec('TRUNCATE TABLE category');
$pdo->exec('TRUNCATE TABLE user');
$pdo->exec('SET FOREIGN_KEY_CHECKS = 1');

$posts = [];
$categories = [];

for ($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post SET name='Article #{$i}', slug='article-{$i}', created_at='2021-11-19 14:00:00', content='Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus auctor, felis ac tincidunt varius, magna mi efficitur nibh, id convallis ipsum lacus et orci. Phasellus luctus felis eu sagittis laoreet. Vestibulum dignissim scelerisque pulvinar. Duis sed erat quis turpis convallis vestibulum. Vestibulum sodales velit nec pulvinar luctus. Proin a varius sem, id gravida justo. Etiam mollis volutpat leo, sed fermentum neque. Suspendisse volutpat nunc ex, eu porta nunc placerat quis.
Morbi ornare nec velit ac convallis. Phasellus mattis, libero et condimentum molestie, orci enim gravida leo, non sagittis ex justo ut leo. Ut metus enim, molestie a arcu commodo, tempor mollis dui. Duis metus odio, tempor ac consectetur posuere, pharetra auctor mi. Etiam nec pretium ante. Sed placerat sagittis luctus. Fusce vel tempus diam. Morbi vestibulum vitae dui vitae venenatis. Nullam ac nulla sit amet ante sollicitudin efficitur vel id eros. Phasellus id turpis lacus. Mauris fringilla leo at leo sagittis, eget feugiat eros gravida. Sed vel lectus lectus. Vivamus nec tellus magna. In ac eros sed nunc lacinia ullamcorper. Aliquam imperdiet ac urna nec sagittis.
Vestibulum aliquam nunc at sapien posuere, a pharetra ipsum tristique. Mauris at ligula eu libero sodales pretium. Maecenas eu leo quis turpis dignissim feugiat. Quisque ullamcorper sapien nec lectus malesuada hendrerit. Sed vitae venenatis lorem, eget auctor libero. Phasellus et fringilla tellus, sollicitudin pellentesque mauris. Sed vel dapibus lacus, quis luctus mi. Suspendisse scelerisque mollis est quis facilisis. Fusce eu velit nibh. Phasellus ipsum leo, luctus non pharetra varius, blandit semper lectus. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Quisque dignissim vulputate lectus, vitae blandit libero efficitur quis.
Morbi quis porttitor risus, non fermentum augue. Morbi et metus imperdiet eros tristique ultricies. Proin suscipit dui vel augue interdum pellentesque a eget lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas vel velit congue erat luctus lobortis. Morbi vel risus lorem. In ultrices, sapien semper placerat tincidunt, ligula velit auctor ligula, sed laoreet leo massa quis turpis. Nulla facilisi. Nulla tempor nec magna nec luctus. In consequat cursus tortor id dapibus. Aenean malesuada felis id diam consectetur, eget lacinia felis accumsan. Maecenas pharetra mi augue, nec finibus lacus blandit quis. Morbi a risus et nunc imperdiet feugiat id sagittis libero.
Nam et nunc quis urna dignissim malesuada eu eget risus. Aliquam vitae viverra massa, sit amet feugiat risus. Etiam nec turpis venenatis, egestas orci eu, egestas odio. Morbi iaculis, risus a pulvinar facilisis, nibh lorem dapibus elit, in congue lectus lacus ut nisi. Aliquam et viverra urna. Suspendisse eget leo non sapien tempus pellentesque. Nam at leo sit amet dui porta consectetur vitae gravida neque. Aliquam nec enim at orci tincidunt eleifend. Nulla aliquet tristique dignissim. Nulla sed enim nisl. In hac habitasse platea dictumst. Quisque sit amet sollicitudin diam.'");
    $posts[] = $pdo->lastInsertId();
}

for ($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category SET name='Catégories #{$i}', slug='category-{$i}'");
    $categories[] = $pdo->lastInsertId();
}

foreach ($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach ($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category SET post_id=$post, category_id=$category");
    }
}

$password = password_hash('admin', PASSWORD_BCRYPT);
$pdo->exec("INSERT INTO user SET username='admin', password='$password'");

