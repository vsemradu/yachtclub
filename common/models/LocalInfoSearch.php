<?php namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LocalInfo;

/**
 * LocalInfoSearch represents the model behind the search form about `common\models\LocalInfo`.
 */
class LocalInfoSearch extends LocalInfo
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'zoom', 'image_id', 'featured_business_id', 'local_life_id'], 'integer'],
            [['location_lat', 'location_lng', 'area_box_ne_lat', 'area_box_sw_lat', 'area_box_ne_lng', 'area_box_sw_lng', 'area_name', 'type_of_address', 'summary', 'customs_immigrations', 'marine_laws_regulations', 'local_life'], 'safe'],
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
        $query = LocalInfo::find();

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
            'zoom' => $this->zoom,
            'image_id' => $this->image_id,
            'featured_business_id' => $this->featured_business_id,
            'local_life_id' => $this->local_life_id,
        ]);

        $query->andFilterWhere(['like', 'location_lat', $this->location_lat])
            ->andFilterWhere(['like', 'location_lng', $this->location_lng])
            ->andFilterWhere(['like', 'area_box_ne_lat', $this->area_box_ne_lat])
            ->andFilterWhere(['like', 'area_box_sw_lat', $this->area_box_sw_lat])
            ->andFilterWhere(['like', 'area_box_ne_lng', $this->area_box_ne_lng])
            ->andFilterWhere(['like', 'area_box_sw_lng', $this->area_box_sw_lng])
            ->andFilterWhere(['like', 'area_name', $this->area_name])
            ->andFilterWhere(['like', 'type_of_address', $this->type_of_address])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'customs_immigrations', $this->customs_immigrations])
            ->andFilterWhere(['like', 'marine_laws_regulations', $this->marine_laws_regulations])
            ->andFilterWhere(['like', 'local_life', $this->local_life]);

        return $dataProvider;
    }
}
