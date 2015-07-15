<?php $this->beginContent('@app/views/layouts/distributer.php');?>
         <!--panel-->
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                    <a id="refresh" class="pull-right" href="<?=\yii\helpers\Url::toRoute(['site/refresh'])?>"><img src="../views/layouts/img/refresh.png" style="width:27px;"></a>
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
                      

                        <?php
                            use yii\helpers\Html;
                            use yii\widgets\LinkPager;
                        ?>
                        

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
                                    foreach($email as $useremail){
                                 ?>
                                <tr>
                           <td><input type="checkbox"></td>
                            <td><?=$useremail['sender'] ?></td>
                            <td><a href="<?=\yii\helpers\Url::toRoute(['site/emaildetail','id'=>$useremail['id'],'handle_status'=>$useremail['handle_status']]);?>"><?=$useremail['subject'] ?></a></td>
                            
                            <td><?=$useremail['sendtime'] ?></td>
                            <td>
                            	<?php
                            		
                            		if($useremail['handle_status']==1)
                            			echo '<button type="button" class="btn btn-success btn-xs">
                                        		&nbsp;&nbsp;已分发&nbsp;&nbsp;
                                    		</button>';
                                    if($useremail['handle_status']==0&&$useremail['is_back']==NULL)
                            			echo '<button type="button" class="btn btn-danger btn-xs">
                                        		&nbsp;&nbsp;未分发&nbsp;&nbsp;
                                    		</button>';
                                    if($useremail['handle_status']==0&&$useremail['is_back']!=NULL)
                            			echo '<button type="button" class="btn btn-warning btn-xs">
                                        		&nbsp;&nbsp;被退回&nbsp;&nbsp;
                                    		</button>';
                            	?>
                            </td>
                        </tr>


                                <?php    }?>

                             <tr><td colspan="6" style="text-align: center">   <?=LinkPager::widget(['pagination'=>$pagination]) ?></td></tr>
                                </tbody>
                                </table>





                    </div>
                </div>
            </div>
<?php $this->endContent();?>