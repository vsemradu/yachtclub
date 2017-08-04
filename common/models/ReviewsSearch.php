<?php namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Reviews;

/**
 * ReviewsSearch represents the model behind the search form about `common\models\Reviews`.
 */
class ReviewsSearch extends Reviews
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'user_id', 'business_id', 'yacht_id', 'pin_id', 'rating', 'kind_trip', 'rating_crew', 'rating_food', 'rating_cleanliness', 'rating_enjoyability', 'rating_maintenance', 'date_create', 'approved'], 'integer'],
            [['text', 'title', 'weather', 'sea_swell', 'wind_direction', 'vessel_name', 'vessel_draft', 'vessel_lenght', 'vessel_beam', 'vessel_air_draft', 'vessel_sail', 'type', 'userInfoFullName', 'businessBusinessName', 'pinPinFieldName', 'yachtName'], 'safe'],
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
        $query = Reviews::find();

        //TODO: Change to default page size query param name or add explanatory comment why this change is required.
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => \Yii::$app->params['reviewPageSize'],
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $query->orderBy('date_create DESC');

        $query->joinWith('user.userInfo');
        $query->joinWith('pin.pinField');
        $query->joinWith('business');
        $query->joinWith('yacht');
        $query->andFilterWhere([
            'id' => $this->id,
            'reviews.user_id' => $this->user_id,
            'business_id' => $this->business_id,
            'yacht_id' => $this->yacht_id,
            'reviews.pin_id' => $this->pin_id,
            'rating' => $this->rating,
            'kind_trip' => $this->kind_trip,
            'rating_crew' => $this->rating_crew,
            'rating_food' => $this->rating_food,
            'rating_cleanliness' => $this->rating_cleanliness,
            'rating_enjoyability' => $this->rating_enjoyability,
            'rating_maintenance' => $this->rating_maintenance,
            'date_create' => $this->date_create,
            'reviews.approved' => $this->approved,
        ]);

        $query->andFilterWhere(['like', 'text', $this->text])
            ->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'weather', $this->weather])
            ->andFilterWhere(['like', 'sea_swell', $this->sea_swell])
            ->andFilterWhere(['like', 'wind_direction', $this->wind_direction])
            ->andFilterWhere(['like', 'vessel_name', $this->vessel_name])
            ->andFilterWhere(['like', 'vessel_draft', $this->vessel_draft])
            ->andFilterWhere(['like', 'vessel_lenght', $this->vessel_lenght])
            ->andFilterWhere(['like', 'vessel_beam', $this->vessel_beam])
            ->andFilterWhere(['like', 'vessel_air_draft', $this->vessel_air_draft])
            ->andFilterWhere(['like', 'vessel_sail', $this->vessel_sail])
            ->andFilterWhere(['like', 'user_infos.first_name', $this->userInfoFullName])
            ->andFilterWhere(['like', 'business.business_name', $this->businessBusinessName])
            ->andFilterWhere(['like', 'pin_fields.name', $this->pinPinFieldName])
            ->andFilterWhere(['like', 'yachts.name', $this->yachtName])
            ->andFilterWhere(['like', 'reviews.type', $this->type]);

        return $dataProvider;
    }
}
