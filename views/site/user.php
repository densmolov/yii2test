<?php
use yii\grid\GridView;

$this->title = 'All users';
?>
<div class="site-user">

<?php
echo GridView::widget([
    'dataProvider' => $dataProvider,
    'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
        // Simple columns defined by the data contained in $dataProvider.
        // Data from the model's column will be used.
        'login',
        'email',
    ],
]);

</div>