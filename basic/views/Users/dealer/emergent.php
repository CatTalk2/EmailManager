
<?php $this->beginContent('@app/views/layouts/dealer.php');?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        <i class="glyphicon glyphicon-th-list"></i>
                        紧急邮件列表
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
                                <th> 紧急状态 </th>
                                <th>发件人</th>
                                <th>邮件主题</th>
                                <th>  </th>
                                <th>截止时间</th>
                                <th>处理状态</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php
                          
                           		foreach ($dealEmail as $demail) {
                            		if($demail['dead_time']!=NULL){
                            			foreach($emails as $email){
                            				if($email['id']==$demail['email_id']){
                                ?>
                                <tr>
                                <?php 
                                	if($demail['handle_status']==3){

                                
                                    echo '<td style="text-align:center; width:80px" ><i class="glyphicon glyphicon-flag" ></i></td>';
                                    
                                    }else{
                                   
                                    	echo '<td style="text-align:center; width:80px" ><i class="glyphicon glyphicon-flag" style="color:red" ></i></td>';
                                  
                                    	}
                                    ?>
                                    <td><?=$email['sender']?></td>
                                    <td><a href="<?=\yii\helpers\Url::toRoute(['site/dealeremaildetail','id'=>$email['id'],'handle_status'=>$email['handle_status']]);?>"><?=$email['subject']?></a></td>
                                    <td><?=$email['label']?></td>
                                    <?php
                                    	if($demail['handle_status']==3){
                                    ?>
                                    <td><?php
                                    		echo date("Y-m-d H:i:s",strtotime($demail['dead_time']));
                                    ?></td>
                                    <?php
                                		}
                                    	else{
                                    ?>
                                    <td style="color:red"><?php
                                    		echo date("Y-m-d H:i:s",strtotime($demail['dead_time']));
                                    ?></td>
                                    <?php
                                    	}
                                    ?>
                                    <td>
                                        <?php
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
                         <div  style="display:inline-block;vertical-align:middle;margin:auto">共 <?php   echo $emergent_count;?> 条</div>
                            
                            <div style="display:inline-block;vertical-align:middle;margin:auto">
                                <?=LinkPager::widget(['pagination'=>$pagination]) ?>

                            </div>

                        </div>




                    </div>
                </div>
            </div>


<?php $this->endContent();?>
