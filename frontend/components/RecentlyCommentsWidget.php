<?php
namespace frontend\components;

use yii\base\Widget;
use yii\helpers\Html;

/**
 * Created by PhpStorm.
 * User: summer
 * Date: 2017/1/6
 * Time: 1:19
 */
class RecentlyCommentsWidget extends Widget
{
    public $comments;

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        $commentsString = '';
        foreach ($this->comments as $comment) {
            $commentsString .= '<div class="post">' .
                '<div class="title">' .
                '<p style="color:#777777;font-style:italic;">' .
                nl2br($comment->content) . '</p>' .
                '<p class="text"> <span class="glyphicon glyphicon-user" aria-hidden="ture">
							</span> ' . Html::encode($comment->user->username) . '</p>' .

                '<p style="font-size:8pt;color:bule">
							《<a href="' . $comment->post->url . '">' . Html::encode($comment->post->title) . '</a>》</p>' .
                '<hr></div></div>';

        }

        return $commentsString;
    }

}