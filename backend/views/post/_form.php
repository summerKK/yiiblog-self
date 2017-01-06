<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Poststatus;
use yii\helpers\ArrayHelper;

/* @var $this yii\web\View */
/* @var $model common\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => TRUE]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'tags')->textarea(['rows' => 6]) ?>

    <?php
    //    $post = Poststatus::find()->all();
    //    $allStatus = ArrayHelper::map($post,'id','name');
    $allStatus = (new \yii\db\Query())
        ->select(['id', 'name'])
        ->from('poststatus')
        ->all();
    $data = (new \yii\db\Query())
        ->select(['name', 'id'])
        ->from('poststatus')
        ->indexBy('id')
        ->column();
    var_dump($data);
    $allStatus = ArrayHelper::map($allStatus, 'id', 'name');
    ?>

    <?= $form->field($model, 'status')->dropDownList(
        $allStatus,
        ['prompt' => '请选择状态']

    ) ?>

    <? //= $form->field($model, 'author_id')->textInput() ?>

    <?= $form->field($model, 'author_id')->dropDownList(
        \common\models\Adminuser::find()
            ->select(['nickname', 'id'])
            ->indexBy('id')
            ->column()
    ,
    ['prompt' => '请选择作者']
    ) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? '新增' : '更新', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
