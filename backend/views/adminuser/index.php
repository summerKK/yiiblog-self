<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdminuserSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '管理员';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="adminuser-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('创建管理员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
            'username',
            'nickname',
            // 'password_reset_token',
             'email:email',
            // 'profile:ntext',

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}&nbsp;{view}&nbsp;{reset-password}&nbsp;{privilege}',
                'buttons' =>[
                      'reset-password' => function($url,$model,$key){
                            $options = [
                                'title'=>Yii::t('yii','重置密码'),
                                'aria-label' => Yii::t('yii','重置密码'),
                                'data-pjax' => '0',
                            ];
                          return Html::a('<span class="glyphicon glyphicon-send"></span>',$url,$options);
                      },
                    'privilege' => function($url,$model,$key){
                        $options = [
                            'title' => Yii::t('yii','账号认证'),
                            'aria-label' => Yii::t('yii','账号认证'),
                            'data-pjax' => '0',
                        ];
                        return Html::a('<span class="glyphicon glyphicon-ok-circle"></span>',$url,$options);
                    },
                ],

            ],
        ],
    ]); ?>
</div>
