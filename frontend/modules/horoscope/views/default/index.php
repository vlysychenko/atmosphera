                <div class="container">
                    <div class="content">
                        <div class="title">Гороскоп</div>
                        <h2></h2>
                        <!--<span class="small">Абрам Гутан | 14 may 2012</span>-->
                            <div class="horoscope">
                            
                                <?
                                    foreach($data as $key => $item){
                                        $this->renderPartial('_item', array('signsOrder' => $signsOrder[$key], 'item' => $item));
                                    }
                                 ?>                            
                            </div>
<!--                        <ul class="pagination">
                            <li><a href="#">1</a></li>
                            <li class="active-page">2</li>
                            <li><a href="#">3...</a></li>
                            <li class="last"><a href="#">последняя</a></li>
                        </ul>-->
                    </div>
                </div>