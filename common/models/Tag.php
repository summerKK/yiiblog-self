<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tag".
 *
 * @property integer $id
 * @property string $name
 * @property integer $frequency
 */
class Tag extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tag';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['frequency'], 'integer'],
            [['name'], 'string', 'max' => 128],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'        => 'ID',
            'name'      => 'Name',
            'frequency' => 'Frequency',
        ];
    }

    public static function string2array($tag)
    {
        return preg_split("#[\s,]+#", trim($tag), -1, PREG_SPLIT_NO_EMPTY);
    }

    public static function array2string($tag)
    {
        return implode(',', $tag);
    }

    public static function addTags($tags)
    {
        if(empty($tags)) return;
        foreach ($tags as $t) {
            $atag = Tag::find()->where(['name' => $t])->one();
            $tagCount = Tag::find()->where(['name' => $t])->count();
            if(!$tagCount) {
                $tag = new Tag();
                $tag->name = $t;
                $tag->frequency = 1;
                $tag->save();
            } else {
                $atag->frequency += 1;
                $atag->save();
            }
        }
    }

    public static function removeTags($tags)
    {
        if(empty($tags)) return;
        foreach ($tags as $t) {
            $atag = Tag::find()->where(['name' => $t])->one();
            $atagCount = Tag::find()->where(['name' => $t])->count();
            if($atagCount && $atag->frequency <= 1) {
                $atag->delete();
            } else {
                $atag->frequency -= 1;
                $atag->save();
            }
        }
    }

    public static function updateFrequency($oldTags, $newTags)
    {
        if(!empty($oldTags) || !empty($newTags)) {
            $oldTags = self::string2array($oldTags);
            $newTags = self::string2array($newTags);
            self::addTags(array_values(array_diff($newTags, $oldTags)));
            self::removeTags(array_values(array_diff($oldTags, $newTags)));
        }
    }

    public static function findTagWeights($limit=20)
    {
        $tag_size_level = 5;
        $models = Tag::find()->orderBy('frequency desc')->limit($limit)->all();
        $total = Tag::find()->limit($limit)->count();
        $stepper = ceil($total/$tag_size_level);
        $tags = [];
        $counter = 1;
        if($total > 0){
            foreach ($models as $model){
                $weight = ceil($counter/$stepper) + 1;
                $tags[$model->name] = $weight;
                $counter++;
            }
            ksort($tags);
        }
        return $tags;
    }
}
