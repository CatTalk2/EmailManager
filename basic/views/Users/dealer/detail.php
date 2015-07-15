<?php $this->beginContent('@app/views/layouts/dealer.php');?>

<?php
	$session=Yii::$app->session;
?>
<div class="rs-dialog" id="myModal1">
     <form name="form1" method="post" action="<?=\yii\helpers\Url::toRoute(['site/backemail','emailId'=>$email['id'],'userId'=>$session['user_id']]);?>">
        <div class="rs-dialog-box">
            <a class="close" href="#">&times;</a>
            <div class="rs-dialog-header">
                <h3><strong>确认通知</strong></h3>
            </div>
          <div class="rs-dialog-body" style="font-family:'微软雅黑';font-size:20px;"> 
          <div class="row">
          <?php 
				use yii\helpers\Html;
            	use yii\widgets\ActiveForm;
            ?>
                  	<?php $form = ActiveForm::begin(); ?>
          <div class="col-md-8 col-md-offset-2">
            <div id="confirmmeg"><p>这封邮件将被退回给分发人,是否确定?</p></div>
             <div id="workergroup"> 
                    <label>转发给:</label>
                    <select class="form-control" id="workerlist" name="workerlist">
                    	<option> </option>
                        <?php 
                        		$session=Yii::$app->session;
                    			foreach ($users as $user) {
                    				if($user['permission']==3&&$user['id']!=$session['user_id'])
                    				echo '<option>'.$user['username'].'</option>';
                    			}
                    		?>
                    </select>
                    
            </div>
            </div>
            </div>
        </div>
        <div class="rs-dialog-footer">
             <input type="button" class="btn btn-primary pull-right" value="转发给其他人" id="transmit">
            <input type="submit" style="margin-right:10px;" class="btn btn-success pull-right" value="确定">
            <input type="button" style="margin-right:10px;" class="btn btn-primary pull-right" value="退回给分发者" id="backtodis">

        </div>
         <?php ActiveForm::end(); ?>
    </div>  
</form>
</div>

<div class="panel panel-default" style="box-shadow: 2px 2px 2px rgba(0,0,0,.05);border: 1px solid #e5e5e5;">
                <div class="panel-heading">
                    <h3 class="panel-title" style="font-size:20px;font-weight:bold;">
                        <!-- <span class="label label-default">主题</span>-->
                        邮件详情
                    </h3>
                </div>
                <div class="panel-body" style="padding-left: 0;padding-right: 0;padding-top: 0;min-height: 330px;">
                  <div id="mailmsgbk">
                    <div id="mailmsg">
                        <h3 class="mailtt">
                            <?=$email['subject']?>

                            <div class="btn-group pull-right">
                            <?php
                            	if($email_user['permission']==1){
										if($email_user['handle_status']==3){

                            		?>
                            	<a href="<?=\yii\helpers\Url::toRoute(['site/emaildeal','emailId'=>$email['id'],'deal_type'=>1]);?>" role="button" class="btn btn btn-warning btn-lg">已处理</a>
                            	<?php
                            		}else{
                            			if($email_user['dead_time']==NULL){

                            			
                            	?>  
                            		<a href="<?=\yii\helpers\Url::toRoute(['site/emaildeal','emailId'=>$email['id'],'deal_type'=>2]);?>" role="button" class="btn btn btn-warning btn-lg">处理</a>

                            		<?php
                            			}
                            		?>
                            		<a href="<?=\yii\helpers\Url::toRoute(['site/emaildeal','emailId'=>$email['id'],'deal_type'=>1]);?>" role="button" class="btn btn btn-primary btn-lg">回复</a>
                            		
                            		<button type="button" rel="rs-dialog" data-target="myModal1" class="btn btn btn-success btn-lg pull-right">退回</button>
                            	
                            <?php  
                        			}	
                        		}

                            ?>
                                
                               
                                                           
                               
                                </div>
                        </br>
                    </h3>
                    <div><span class="mailmst">发件人:</span><?=$email['sender']?></div>
                    <div><span class="mailmst">收件人:</span> <?=$email['receiver']?></div>
                    <div><span class="mailmst">时　间:</span> <?=$email['sendtime']?></div>
                    <div><span class="mailmst">附　件:</span> 

                    <?php
                    	if($email['attachment']!=NULL){
            			$fujian=explode(';', $email['attachment']);
            			for($i=0;$i<count($fujian)-1;$i++) {
            				echo basename($fujian[$i])."  ";
            				//print_r($email['attachment']);
            			}
            		}
            		
                    ?>
                    </div>
                    

                </div>

            </div>

            <!--<div><label class="label-primary">正文：</label></div>-->
            <div id="mailtext">
               <p><?=$email['text']?></p>

            </div>
        </div>

        <div class="panel-footer">
            <div><h4><span class="label label-default">附件信息：</span></h4></div>

            <div class="row">
            		
            		<?php 
            			
            			 	function type($file){

            				if(strstr($file,'.doc')!=NULL){
            					return 1;
            				}
            				if(strstr($file,'.xls')!=NULL){
            					return 2;
            				}
            				if(strstr($file,'.pdf')!=NULL){
            					return 3;
            				}
            				if(strstr($file,'.txt')!=NULL){
            					return 4;
            				}
            				if(strstr($file,'.zip')!=NULL||strstr($file,'.rar')!=NULL){
            					return 5;
            				}
            				if(strstr($file,'.png')!=NULL||strstr($file,'.jpg')!=NULL){
            					return 6;
            				}

            				return 0;
  
            			}
            			


            			$files=explode(';', $email['attachment']);
            			$file_type=array();

            			for($i=0;$i<count($files)-1;$i++) {
            				$file_type[]=type($files[$i]);
            			}
            			
            			//print_r(count($files));
            			
            		?>
                    <input id="filecount" class="hidden" value="<?= count($files)-1;?>" />
                    <input id="filetype" class="hidden" value="<?php
                    	for($i=0;$i<count($files)-1;$i++){
                    		echo $file_type[$i].';';
                    	}
                    ?>" />
                    <input id="filelinkfield" class="hidden" value="<?php
                    	echo $email['attachment'];
                    ?>"/>
                   
                   

                     <input id="filenamefield" class="hidden" value="<?php 
                    	for($i=0;$i<count($files)-1;$i++){
                    		echo basename($files[$i]).';';
                    	}
                    ?>" />

                     <?php 
                    	for($i=0;$i<count($files)-1;$i++){
                    ?>

                    <div class="fileico col-md-2">

                       <a href="<?=\yii\helpers\Url::toRoute(['mail/download','file'=>$files[$i]]);?>" class="filelink"><img class="fileimg" src="" ></a>
                        <a href="<?=\yii\helpers\Url::toRoute(['mail/download','file'=>$files[$i]]);?>" class="filename">doc.png</a>
                    </div>
                    <?php
                    	}
                    
                    ?>

        </div>


    </div>
<?php $this->endContent();?>