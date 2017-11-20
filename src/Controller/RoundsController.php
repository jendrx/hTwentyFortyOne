<?php
/**
 * Created by PhpStorm.
 * User: rom
 * Date: 10/24/17
 * Time: 11:03 AM
 */

namespace App\Controller;


use Cake\Collection\Collection;

class RoundsController extends AppController
{

    public function view( $id = null )
    {
        // find questions by get round by id and extract

        $round = $this->Rounds->get($id,['contain' => 'Studies']);
        $query = $this->Rounds->find('all',['conditions' => ['Rounds.id' => $id],'contain' => ['Studies','QuestionsIndicatorsYears.QuestionsIndicators.Questions']]);
        $questions = array_unique($query->extract('questions_indicators_years.{*}.questions_indicator.question')->toArray());
        foreach($questions as &$question)
        {

            $questionsIndicators = $this->Rounds
                ->QuestionsIndicatorsYears
                ->QuestionsIndicators->find('all',['conditions' => ['QuestionsIndicators.question_id' => $question['id']],
                    'contain' => ['Indicators','QuestionsIndicatorsYears' => ['Years','Rounds' => ['conditions' => ['Rounds.id' => $id]]]]]);

            $question['questions_indicators'] = $questionsIndicators;
        }

        $this->set(compact('questions','round'));
        $this->set('_serialize',[ 'questions', 'round']);
    }
}