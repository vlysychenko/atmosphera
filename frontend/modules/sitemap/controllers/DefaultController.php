<?php
    class DefaultController extends FrontendController {
        
        
        protected $items = array();
        
        const ALWAYS = 'always';
        const HOURLY = 'hourly';
        const DAILY = 'daily';
        const WEEKLY = 'weekly';
        const MONTHLY = 'monthly';
        const YEARLY = 'yearly';
        const NEVER = 'never';
        
        private $arrSQL = array(
            'articles' => 'SELECT n.post_id, p.`title` AS p_title, n.`publication_date`, u.`firstname`, u.`lastname`, n.anounce, n.content FROM news AS n
                                                        LEFT JOIN users AS u ON u.`user_id` = n.`user_id`
                                                        LEFT JOIN posting AS p ON p.`post_id` = n.`post_id`
                                                        WHERE p.is_active = 1 AND n.`publication_date` <= NOW()
                                                        ORDER BY n.`publication_date` DESC',
            'gallery' => 'SELECT n.post_id, p.title AS p_title, n.publication_date, u.firstname, u.lastname, n.anounce,
                                                    (SELECT filename FROM photo WHERE gallery_id = p.gallery_id AND is_top = 1 LIMIT 1) filename
                                                        FROM galleryposts AS n
                                                        LEFT JOIN users AS u ON u.user_id = n.user_id
                                                        LEFT JOIN posting AS p ON p.post_id = n.post_id
                                                        WHERE p.is_active > 0 AND n.publication_date <= NOW()
                                                        ORDER BY n.publication_date DESC',
        );
        
        public function actionIndex(){
            $this->render('sitemap');
        }
        
        //action: generation of sitemapindex.xml
        public function actionIndexXml(){
            $this->addUrl(Yii::app()->createAbsoluteUrl('/'));
            foreach(Yii::app()->modules as $module => $val){
                switch($module){
                    case 'articles':                    
                    case 'gallery':
                        $ids = Yii::app()->db->createCommand($this->arrSQL[$module])->queryAll();
                        if(is_array($ids)){
                            foreach($ids as $id){
                                $this->addUrl(Yii::app()->createAbsoluteUrl("$module/default/view/", array('id' => $id['post_id'])));
                            }
                        }
                    case 'about':
                    case 'partners':
                    case 'search':
                    case 'horoscope':
                    case 'contacts':
                    case 'sitemap':
                        $this->addUrl(Yii::app()->createAbsoluteUrl("$module"));
                        break;
                    default:
                        break;
                }
            }
            $this->layout = false;
            header("Content-type: text/xml; charset=UTF-8");
            $this->render('xml', array('items'=>$this->items));
        }

    
        /**
         * @param $url
         * @param string $changeFreq
         * @param float $priority
         * @param int $lastmod
         */
        public function addUrl($url, $changeFreq=self::DAILY, $priority=0.5, $lastMod=0)
        {
    //        $host = Yii::app()->request->hostInfo;
            $item = array(
                'loc' => /*$host . */$url,
                'changefreq' => $changeFreq,
                'priority' => $priority
            );
    //        if ($lastMod)
    //            $item['lastmod'] = $this->dateToW3C($lastMod);
     
            $this->items[] = $item;
        }
        
        protected function dateToW3C($date)
        {
            if (is_int($date))
                return date(DATE_W3C, $date);
            else
                return date(DATE_W3C, strtotime($date));
        }
    }
?>