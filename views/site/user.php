<?php
use yii\grid\GridView;
use yii\grid\DataColumn;
use yii\bootstrap\Nav;

$this->title = 'All users';
?>
<div class="site-user">
<p>Logged in as USER</p>
</br>

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

<?php
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
            Yii::$app->user->isGuest ?
                ['label' => 'Login', 'url' => ['/site/login']] :
                ['label' => 'Logout (' . Yii::$app->user->identity->login . ')',
                    'url' => ['/site/logout'],
                    'linkOptions' => ['data-method' => 'post']],
        ],
    ]);
?>

</div>