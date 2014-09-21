<?php

class DefaultController extends Controller
{
    public function actionIndex()
    {
        Yii::import('application.modules.portfolio.widgets.PhotoPortfolio.PhotoPortfolioWidget');
        $newsForMainPage = $this -> loadModel('Otherproperties','news_for_main_page');
        $linkFacebook = $this -> loadModel('Otherproperties','link_facebook');
        $linkVk = $this -> loadModel('Otherproperties','link_vk');
        $mainpage = $this -> loadModel('Otherproperties','mainpage');
        $news = Posting::model()->findAllByAttributes(array('post_type'=>1));
        $portfolio = new Portfolio();
        if (!empty($_POST['FileForm'])) {
            $portfolioWidget = New PhotoPortfolioWidget;
            $galleries = $portfolioWidget->validatePortfolio($_POST);
            if (!empty($galleries)) {
                $portfolio = $galleries[0];
            }
            $success = is_object($portfolio) && !$portfolio->hasErrors();
            $mainPagemodel = Otherproperties::model()->findByPk('mainpage');

            if($mainPagemodel !== null && !empty($portfolio->photos)){
                $mainPagemodel->value = $portfolio->photos[1]->filename;
                $mainPagemodel->save();
            }
            $strMessage = (Yii::t('main', 'Updated successfully'));

            if(isset($_POST['newsForMainPage'])){
                $idNews = trim($_POST['newsForMainPage']);
                $newsForMainPage = Otherproperties::model()->findByPk('news_for_main_page');
                if($newsForMainPage !== null){
                    $newsForMainPage->value = $idNews;
                    $newsForMainPage->save();
                }
            }

            if(isset($_POST['linkFacebook'])){
                $fb = $_POST['linkFacebook'];
                $facebook = Otherproperties::model()->findByPk('link_facebook');
                if(isset($facebook)){
                    $facebook->value = trim($fb);
                    $facebook->save();
                }
            }

            if(isset($_POST['linkVk'])){
                $vk = $_POST['linkVk'];
                $vkontakte = Otherproperties::model()->findByPk('link_vk');
                if(isset($facebook)){
                    $vkontakte->value = trim($vk);
                    $vkontakte->save();
                }
            }

            if ($success) {
                $transaction = Yii::app()->db->beginTransaction();
                if ($success = $portfolio->saveGallery()) {

                    $transaction->commit();

                    $resultMode = ($success ? 'success' : 'error');
                    Yii::app()->user->setFlash($resultMode, $strMessage); //show flash message

                    $this->redirect($this->createUrl('index'));
                } else {
                    $transaction->rollback();
                }

            }
        }
        $this->render(
            'index',
            array('newsForMainPage' => $newsForMainPage, 'news' => $news, 'portfolio' => $portfolio, 'linkFacebook'=> $linkFacebook,
                    'linkVk'=>$linkVk, 'mainpage'=>$mainpage)
        );
    }

    public function actionCreate()
    {
        $otherproperties = new Otherproperties();
        $news = News::model()->findAll();
        $this->render('index', array('otherproperties' => $otherproperties, 'news' => $news));
    }
}