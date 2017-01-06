<?php
namespace frontend\components;

use Yii;
use yii\base\Widget;

/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2017/1/6
 * Time: 1:19
 */
class TagsCloudWidget extends Widget
{
    public $tags;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $tagString = '';
        $fontStyle = [
            2 => 'success',
            3 => 'primary',
            4 => 'warning',
            5 => 'info',
            6 => 'danger',
        ];
        foreach ($this->tags as $tag=>$weight){
            $url = Yii::$app->urlManager->createUrl(['post/index','PostSearch[tags]'=>$tag]);
            $tagString.='<a href="'.$url.'">'.
                ' <h'.$weight.' style="display:inline-block;"><span class="label label-'
                .$fontStyle[$weight].'">'.$tag.'</span></h'.$weight.'></a>';
        }
        return $tagString;
    }

}