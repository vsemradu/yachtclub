<?php namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserPin;

/**
 * UserPinSearch represents the model behind the search form about `common\models\UserPin`.
 */
class UserPinSearch extends UserPin
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type', 'approved'], 'integer'],
            [['lat', 'lan', 'description', 'pinFieldName'], 'safe'],
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
        $query = UserPin::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->joinWith('pinField');
        $query->andFilterWhere([
            'id' => $this->id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'approved' => $this->approved,
        ]);

        $query->andFilterWhere(['like', 'lat', $this->lat])
            ->andFilterWhere(['like', 'lan', $this->lan])
            ->andFilterWhere(['like', 'pin_fields.name', $this->pinFieldName])
            ->andFilterWhere(['like', 'description', $this->description]);
        $query->orderBy(['id'=>SORT_DESC]);
        return $dataProvider;
    }
}
