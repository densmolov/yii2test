<?php
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\bootstrap\Nav;

$this->title = 'All users';
?>
<div class="site-user">

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        'login',
        ['class' => DataColumn::className(),
        'attribute' => 'email',
        'format' => 'email',]
    ],
]);
?>

</div>