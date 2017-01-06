<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property string $content
 * @property integer $status
 * @property integer $create_time
 * @property integer $userid
 * @property string $email
 * @property string $url
 * @property integer $post_id
 *
 * @property Post $post
 * @property Commentstatus $status0
 * @property User $user
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['content', 'status', 'userid', 'email', 'post_id'], 'required'],
            [['content'], 'string'],
            [['status', 'create_time', 'userid', 'post_id'], 'integer'],
            [['email', 'url'], 'string', 'max' => 128],
            [['post_id'], 'exist', 'skipOnError' => true, 'targetClass' => Post::className(), 'targetAttribute' => ['post_id' => 'id']],
            [['status'], 'exist', 'skipOnError' => true, 'targetClass' => Commentstatus::className(), 'targetAttribute' => ['status' => 'id']],
            [['userid'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['userid' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'            => 'ID',
            'content'       => '评论内容',
            'status'        => '状态',
            'create_time'   => '添加时间',
            'email'         => 'Email',
            'url'           => 'Url',
            'post.title'    => '文章',
            'user.username' => '用户',
            'status0.name'  => '状态',
            'userid'        => '用户',
            'post_id'       => '文章',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPost()
    {
        return $this->hasOne(Post::className(), ['id' => 'post_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getStatus0()
    {
        return $this->hasOne(Commentstatus::className(), ['id' => 'status']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'userid']);
    }

    public function getCutout()
    {

        $content = strip_tags($this->content);
        $len = mb_strlen($content, 'utf-8');

        return mb_substr($content, 0, 20, 'utf-8') . ($len > 20 ? '...' : '');
    }

    public function approve()
    {
        $this->status = 2;

        return $this->save() ? true : false;
    }

    public static function getPengdingCommentCount()
    {
        return Comment::find()->where(['status' => 1])->count();
    }

    public function beforeSave($insert)
    {
        if(parent::beforeSave($insert)) {
            if($insert) {
                $this->create_time = time();
            }

            return true;
        } else {
            return false;
        }
    }

    public static function findRecentComments($limit=10)
    {
        return Comment::find()->where(['status' => 2])->orderBy('create_time desc')->limit($limit)->all();
    }

}
