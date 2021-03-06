<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * Years Model
 *
 * @property \App\Model\Table\QuestionsIndicatorsTable|\Cake\ORM\Association\BelongsToMany $QuestionsIndicators
 *
 * @method \App\Model\Entity\Year get($primaryKey, $options = [])
 * @method \App\Model\Entity\Year newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\Year[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\Year|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\Year patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\Year[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\Year findOrCreate($search, callable $callback = null, $options = [])
 *
 * @mixin \Cake\ORM\Behavior\TimestampBehavior
 */
class YearsTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('years');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->addBehavior('Timestamp');

        $this->belongsToMany('QuestionsIndicators', [
            'foreignKey' => 'year_id',
            'targetForeignKey' => 'question_indicator_id',
            'joinTable' => 'questions_indicators_years'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->allowEmpty('id', 'create');

        $validator
            ->scalar('description')
            ->requirePresence('description', 'create')
            ->notEmpty('description');

        return $validator;
    }
}
