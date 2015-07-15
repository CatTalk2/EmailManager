
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
                                <th>发件人</th>
                                <th>邮件主题</th>
                                
                                <th>发送时间</th>
                                <th>状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                            foreach($emails as $email){
                                ?>
                                <tr>

                                    <td><input type="checkbox"></td>
                                    <td><?=$email['sender']?></td>
                                    <td><a href="<?=\yii\helpers\Url::toRoute(['site/dealeremaildetail','id'=>$email['id'],'handle_status'=>$email['handle_status']]);?>"><?=$email['subject']?></a></td>
                                    
                                    <td><?=$email['sendtime']?></td>
                                    <td>
                                        <?php
                                        	foreach ($dealEmail as $demail) {
                                        		if($demail['email_id']==$email['id']){
                                        			if($demail['handle_status']==0)
                            			echo '<button type="button" class="btn btn-danger btn-xs">
                                        		&nbsp;&nbsp;未阅读&nbsp;&nbsp;
                                    		</button>';
                            		if($demail['handle_status']==1)
                            			echo '<button type="button" class="btn btn-warning btn-xs">
                                        		&nbsp;&nbsp;已&nbsp;&nbsp;&nbsp;读&nbsp;&nbsp;
                                    		</button>';
                                    if($demail['handle_status']==2)
                            			echo '<button type="button" class="btn btn-primary btn-xs">
                                        		&nbsp;&nbsp;已处理&nbsp;&nbsp;
                                    		</button>';
                                    if($demail['handle_status']==3)
                            			echo '<button type="button" class="btn btn-primary btn-xs">
                                        		&nbsp;&nbsp;已回复&nbsp;&nbsp;
                                    		</button>';
                                        		}
                                        		
                                        	}
                            		
                            		?>
                                    </td>
                                </tr>

                            <?php
                            }

                            ?>

                            </tbody>
                        </table>

                        <?php
                        use yii\helpers\Html;
                        use yii\widgets\LinkPager;
                        ?>
                        <!--<nav>
                            <ul class="pagination pull-right">-->
                        <div style="text-align: center">
                         <div  style="display:inline-block;vertical-align:middle;margin:auto">共 <?php  $session=Yii::$app->session; echo $session['count'];?> 条</div>
                            
                            <div style="display:inline-block;vertical-align:middle;margin:auto">
                                <?=LinkPager::widget(['pagination'=>$pagination]) ?>

                            </div>

                        </div>




                    </div>
                </div>
            </div>


<?php $this->endContent();?>
