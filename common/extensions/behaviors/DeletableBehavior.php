<?php

/**
 * DeletableBehavior help you delete many models with all relatives in one shot.
 * Supports composite keys.
 *
 * Example:
 * public function behaviors(){
 *     return array(
 *         'deletable' => array(
 *             'class' => 'path.to.DeletableBehavior',
 *             'relations' => array(
 *                  'comments' => DeletableBehavior::RESTRICT,
 *                  'likes'    => DeletableBehavior::CASCADE,
 *              ),
 *         )
 *     );
 * }
 *
 * User::model()->batchDelete(array(1,2,3,4));
 *
 * @author Vorotilov Vadim <fant.geass@gmail.com>
 */
class DeletableBehavior extends CActiveRecordBehavior
{
	const CASCADE = 'cascade';
	const RESTRICT = 'restrict';

	/**
	 * Example:
	 * array(comments' => DeletableBehavior::RESTRICT, 'likes'    => DeletableBehavior::CASCADE,)
	 * @var array
	 */
	public $relations = array();

	/**
	 * Default handlers flag
	 * @var bool
	 */
	protected $_addDefaultHandlers = false;

	/**
	 * Ids for batch delete, using on events methods
	 * @var array
	 */
	protected $_batchIds = array();

	/**
	 * @return array
	 */
	public function getBatchIds()
	{
		return $this->_batchIds;
	}

	/**
	 * After Batch Delete Handler
	 * @param CModelEvent $event
	 */
	public function afterBatchDeleteHandler(CModelEvent $event)
	{
		if (method_exists($this->owner, 'afterBatchDelete')) {
			$this->owner->afterBatchDelete($event);
		}
	}

	/**
	 * Before Batch Delete Handler
	 * @param CModelEvent $event
	 */
	public function beforeBatchDeleteHandler(CModelEvent $event)
	{
		if (method_exists($this->owner, 'beforeBatchDelete')) {
			return $this->owner->beforeBatchDelete($event);
		}

		return $event->isValid;
	}

	/**
	 * Responds to {@link CActiveRecord::onBeforeDelete} event.
	 * Overrides this method if you want to handle the corresponding event of the {@link CBehavior::owner owner}.
	 * You may set {@link CModelEvent::isValid} to be false to quit the deletion process.
	 * @param CEvent $event event parameter
	 */
	public function beforeDelete($event)
	{
		$this->batchDeleteRelatives(array($this->owner->primaryKey));
	}


	/**
	 * Get primary keys of relatives
	 *
	 * @param array $ids primary keys of models
	 * @param string $modelName model name
	 * @param string $attribute relation attribute
	 *
	 * @return array
	 */
	public function getRelativesIds(array $ids, $modelName, $attribute)
	{
		/**
		 * @var CActiveRecord $model
 		 */
		$model = $modelName::model($modelName);
		$pkAttr = $model->tableSchema->primaryKey;

		if (is_array($pkAttr)) {
			$r =  Yii::app()->db->createCommand()
				->select($pkAttr)
				->from($model->tableName())
				->where(array('in', $attribute, $ids))
				->queryAll();
		} else {
			$r =  Yii::app()->db->createCommand()
				->select($pkAttr)
				->from($model->tableName())
				->where(array('in', $attribute, $ids))
				->queryColumn();
		}

		return $r;

	}
    
    public function getOwnersAttrs(array $ids,  $attribute)
    {
        $pkAttr = $this->owner->tableSchema->primaryKey;

        if (is_array($attribute)) {
            $r =  Yii::app()->db->createCommand()
                ->select($attribute)
                ->from($this->owner->tableName())
                ->where(array('in', $pkAttr, $ids))
                ->queryAll();
        } else {
            $r =  Yii::app()->db->createCommand()
                ->select($attribute)
                ->from($this->owner->tableName())
                ->where(array('in', $pkAttr, $ids))
                ->queryColumn();
        }

        return $r;

    }    

	/**
	 * Delete relatives of models
	 *
	 * @param array $ids primary keys of models
	 */
	public function batchDeleteRelatives($ids)
	{
		foreach ($this->relations as $relation => $type) {
			$rels = $this->owner->relations();
			$modelName = $rels[$relation][1];
			$attribute = $rels[$relation][2];
            
            if(is_array($attribute)) {
             $ownerAttribute = key($attribute);                   
             $attribute = $attribute[$ownerAttribute]; 
            } else $ownerAttribute = $attribute;
            
            switch($rels[$relation][0]) {
             case CActiveRecord::BELONGS_TO :
             //owner field references other`s model primary key
             $relativesIds = array_values(array_filter($this->getOwnersAttrs($ids, $ownerAttribute))); 
             break;
             default :   
             $relativesIds = $this->getRelativesIds($ids, $modelName, $attribute);
            }



			if (!empty($relativesIds) && $type == self::RESTRICT) {
				throw new RestrictException("Can not delete because of restrict \"$modelName\" data");
			}

			$modelName::model($modelName)->batchDelete($relativesIds, true, false);
		}
	}


	/**
	 * Delete models & relatives
	 *
	 * @param array $ids models primary keys for deleting
	 * @param bool $deleteRelatives delete or not relatives
	 * @param bool $first need this param for control transaction
	 *
	 * @return int numbers of rows that deleted.
	 */
	public function batchDelete(array $ids, $deleteRelatives = true, $first = true)
	{
		$db = $this->owner->getDbConnection();
		if ($db->getCurrentTransaction() === null) {
			$transaction = $db->beginTransaction();
		}
 
		try {

			$this->_batchIds = $ids;
			$this->_addDefaultHandlers();

			if ($this->beforeBatchDelete()) {

				if ($deleteRelatives) {
					$this->batchDeleteRelatives($ids);
				}

				$result = $this->owner->deleteAllByAttributes($this->_convertIdsForDeleteMethod($ids));

				$this->afterBatchDelete();

				if ($first && isset($transaction)) {
					$transaction->commit();
				}

				return $result;
			}

		} catch(Exception $e) {
			if(isset($transaction)) {
				$transaction->rollBack();
			}

			throw $e;
		}


		return false;
	}



	/**
	 * This event is raised before the models is deleted.
	 * @param CEvent $event the event parameter
	 */
	public function onBeforeBatchDelete($event)
	{           
		$this->raiseEvent('onBeforeBatchDelete',$event);
	}

	/**
	 * This method is invoked before batch deleting a models.
	 * The default implementation raises the {@link onBeforeBatchDelete} event.
	 * You may override this method to do any preparation work for models deletions.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 * @return boolean whether the models should be deleted. Defaults to true.
	 */
	protected function beforeBatchDelete()
	{
		if($this->hasEventHandler('onBeforeBatchDelete')) {
			$event = new CModelEvent($this);
			$this->onBeforeBatchDelete($event);
			return $event->isValid;
		} else {
			return true;
		}
	}

	/**
	 * This event is raised after the models is deleted.
	 * @param CEvent $event the event parameter
	 */
	public function onAfterBatchDelete($event)
	{
		$this->raiseEvent('onAfterBatchDelete',$event);
	}

	/**
	 * This method is invoked after batch deleting a models.
	 * The default implementation raises the {@link onAfterBatchDelete} event.
	 * You may override this method to do postprocessing after the batch is deleted.
	 * Make sure you call the parent implementation so that the event is raised properly.
	 */
	protected function afterBatchDelete()
	{
		if($this->hasEventHandler('onAfterBatchDelete')) {
			$this->onAfterBatchDelete(new CModelEvent($this));
		}
	}

	/**
	 * Add default handlers to events
	 */
	private function _addDefaultHandlers()
	{
		if (!$this->_addDefaultHandlers) {
			$this->onBeforeBatchDelete->add(array($this, 'beforeBatchDeleteHandler'));
			$this->onAfterBatchDelete->add(array($this, 'afterBatchDeleteHandler'));

			$this->_addDefaultHandlers = true;
		}
	}

	/**
	 * Convert ids for deleteAllByAttributes() method
	 * @param array $ids
	 *
	 * @return array
	 */
	private function _convertIdsForDeleteMethod(array $ids)
	{
		$pkAttr = $this->owner->tableSchema->primaryKey;

		$attributes = array();
		if (is_array($pkAttr)) {
			foreach ($pkAttr as $attr) {
                if(!empty($ids)) {
				foreach ($ids as $id) {
					$attributes[$attr][] = $id[$attr];
				}
                } else {
                  $attributes[$attr][] = '0';  
                }
			}
		} else {
			$attributes = array($pkAttr => $ids);
		}

		return $attributes;
	}



}

/**
 * RestrictException class
 *
 * If type is RESTRICT and relatives exists, then throw this exception
 *
 */
class RestrictException extends CException {}