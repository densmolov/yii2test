<?php

use yii\grid\GridView;
use yii\data\ActiveDataProvider;


<div class="site-user">
    <h3>Please User</h3>

$dataProvider = new ActiveDataProvider([
    'query' => Post::find(),
]);

echo GridView::widget([
    'dataProvider' => $dataProvider,
]);

</div>