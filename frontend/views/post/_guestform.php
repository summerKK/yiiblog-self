<?php
/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2017/1/5
 * Time: 1:35
 */
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<div class="post-form">

    <?php $form = ActiveForm::begin([
        'action'=>['post/detail','id'=>$id,'#'=>'comments'],
    ]); ?>

    <div class="row">
        <div class="col-md-12"><?=$form->field($commentModel, 'content')->textarea(['row'=>6])?></div>
    </div>

    <div class="form-group">
        <?= Html::submitButton('发表评论',['class'=>'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>