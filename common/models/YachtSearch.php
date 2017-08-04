<?php namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Yacht;

/**
 * YachtSearch represents the model behind the search form about `common\models\Yacht`.
 */
class YachtSearch extends Yacht
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'type_id', 'type', 'subtype', 'year', 'background_image_id', 'date_create', 'rate'], 'integer'],
            [['name', 'yacht_build', 'home_port', 'length', 'beam', 'draft', 'air_draft', 'website', 'summary', 'enable_blog', 'charter_company', 'contact_info'], 'safe'],
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
        $query = Yacht::find();

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
            'user_id' => $this->user_id,
            'type_id' => $this->type_id,
            'rate' => $this->rate,
            'type' => $this->type,
            'subtype' => $this->subtype,
            'year' => $this->year,
            'background_image_id' => $this->background_image_id,
            'date_create' => $this->date_create,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'yacht_build', $this->yacht_build])
            ->andFilterWhere(['like', 'home_port', $this->home_port])
            ->andFilterWhere(['like', 'length', $this->length])
            ->andFilterWhere(['like', 'beam', $this->beam])
            ->andFilterWhere(['like', 'draft', $this->draft])
            ->andFilterWhere(['like', 'air_draft', $this->air_draft])
            ->andFilterWhere(['like', 'website', $this->website])
            ->andFilterWhere(['like', 'summary', $this->summary])
            ->andFilterWhere(['like', 'enable_blog', $this->enable_blog])
            ->andFilterWhere(['like', 'charter_company', $this->charter_company])
            ->andFilterWhere(['like', 'contact_info', $this->contact_info]);

        return $dataProvider;
    }
}
