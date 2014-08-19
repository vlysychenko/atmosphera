<?php if(count($comments) > 0):?>
    <ul class="comments-list">
        <?php foreach($comments as $comment):?>
            <li id="comment-<?php echo $comment->comment_id; ?>">
                <div class="comment-header">
                    <?php echo Yii::app()->dateFormatter->formatDateTime($comment->create_time);?>
                    <?php echo $comment->userName;?>
                </div>
                <?php if($this->adminMode === true):?>
                    <div class="admin-panel">
                        <?php if($comment->status === null || $comment->status == Comment::STATUS_NOT_APPROVED) echo CHtml::link(Yii::t('CommentsModule.msg', 'approve'), Yii::app()->urlManager->createUrl(
                            CommentsModule::APPROVE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                        ), array('class'=>'approve'));?>
                        <?php echo CHtml::link(Yii::t('CommentsModule.msg', 'delete'), Yii::app()->urlManager->createUrl(
                            CommentsModule::DELETE_ACTION_ROUTE, array('id'=>$comment->comment_id)
                        ), array('class'=>'delete'));?>
                    </div>
                <?php endif; ?>
                <div class="comment-text">
                    <?php echo CHtml::encode($comment->comment_text);?>
                </div>

                <?php
                    if($this->allowSubcommenting === true && ($this->registeredOnly === false || Yii::app()->user->isGuest === false)) {
                        echo CHtml::link(Yii::t('CommentsModule.msg', 'Answer'), '#', array(
                            'rel'=>$comment->comment_id, 
                            'class'=>'add-comment'
                        ));
                    }
                ?>

                <?php if(count($comment->childs) > 0 && $this->allowSubcommenting === true) 
                    $this->render('ECommentsWidgetComments', array('comments' => $comment->childs));
                ?>
            </li>
        <?php endforeach;?>
    </ul>
<?php else:?>
    <p><?php echo Yii::t('CommentsModule.msg', 'No comments');?></p>
<?php endif; ?>

