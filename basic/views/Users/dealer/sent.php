<?php $this->beginContent('@app/views/layouts/dealer.php');?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-th-list"></i>
                        邮件列表
                    </h3>
                </div>

                <div class="panel-body">
                    <div class="page-header" id="table-divider">
                        <!--checkbox-->

                    </div>

                    <!--information table context-->
                    <div class="form bidform" >

                        <table class="table table-striped table-bordered">
                            <thead>
                            <tr >
                                <th style="width:65px">选中</th>
                                <th>收件人</th>
                                <th>邮件主题</th>
                               
                                <th style="width:200px">发送时间</th>
                                
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            	
                                    foreach($sent_emails as $email){
                                    	
                                 ?>
                                <tr>
                           <td><input type="checkbox"></td>
                            <td><?=$email['receiver'] ?></td>
                            <td><a href="<?=\yii\helpers\Url::toRoute(['site/sentdetail','id'=>$email['id']]);?>"><?=$email['subject'] ?></a></td>
                            
                            <td><?=$email['send_time'] ?></td>
                            
                        </tr>


                                <?php    }?>

                             
                            </tbody>

                        </table>
                        <?php
                        use yii\helpers\Html;
                        use yii\widgets\LinkPager;
                        ?>
                        <!--<nav>
                            <ul class="pagination pull-right">-->
                        <div style="text-align: center">
                         <div  style="display:inline-block;vertical-align:middle;margin:auto">共 
                         <?php echo $count?> 条</div>
                            
                            <div style="display:inline-block;vertical-align:middle;margin:auto">
                                <?=LinkPager::widget(['pagination'=>$pagination]) ?>

                            </div>

                        </div>

                       




                    </div>
                </div>
            </div>


<?php $this->endContent();?>
