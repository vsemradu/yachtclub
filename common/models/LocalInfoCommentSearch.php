<?php namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LocalInfoComment;

/**
 * LocalInfoCommentSearch represents the model behind the search form about `common\models\LocalInfoComment`.
 */
class LocalInfoCommentSearch extends LocalInfoComment
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'local_info_id', 'user_id', 'rate', 'type', 'date_create'], 'integer'],
            [['text'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = LocalInfoComment::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'local_info_id' => $this->local_info_id,
            'user_id' => $this->user_id,
            'rate' => $this->rate,
            'type' => $this->type,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text]);
        $query->orderBy(['date_create' => SORT_DESC]);
        return $dataProvider;
    }
}
