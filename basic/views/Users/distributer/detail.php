<?php $this->beginContent('@app/views/layouts/distributer.php');?>

<div class="rs-dialog" id="myModal1">
				
     <form name="form1" method="post" action="<?=\yii\helpers\Url::toRoute(['site/distributing','emailId'=>$email['id']]);?>">
        <div class="rs-dialog-box">
            <a class="close" href="#">&times;</a>
            <div class="rs-dialog-header">
            	<div class="row">
            	<div class="col-md-10 col-md-offset-1">
            		<?php 
				use yii\helpers\Html;
            	use yii\widgets\ActiveForm;
            ?>
                  	<?php $form = ActiveForm::begin(); ?>
            		 <div class="input-group date form_datetime" data-date="" data-date-format="dd MM yyyy - HH:ii p" data-link-field="dtp_input1">
                            <span class="input-group-addon">截止时间</span>
                            <input class="form-control visibletime" size="16" type="text" value="" readonly>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></span>
                            <span class="input-group-addon"><span class="glyphicon glyphicon-time"></span></span>
                        </div>
                        <input type="hidden" id="dtp_input1" name="dead_time" /><br/>

            	
               <div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">处理者</span>
                  
               		

                  <input type="text" name="allName1" id="allName1" class="form-control" placeholder="可选多个处理者"  required autofocus >
                   <span class="input-group-addon"><a href="#" id="clearout1"><i class="glyphicon glyphicon-remove"></i></a></span>
              </div> 

              <br/>
              </div>

              <div class="col-md-10 col-md-offset-1">
               	<div class="input-group">
                  <span class="input-group-addon" id="basic-addon1">阅读者</span>
                  <input type="text" name="allName2" id="allName2" class="form-control" placeholder="可分发多人">
                  <span class="input-group-addon"><a href="#" id="clearout2"><i class="glyphicon glyphicon-remove"></i></a></span>
              	</div>    
              </div>
              </div>
          </div>

          <div class="rs-dialog-body"> 
            <div class="row" style="font-size:20px;font-weight:bold;">
            <div class="col-md-10 col-md-offset-1">
                    
                    <select id="friendGroups" name="friendGroups" class="form-control">
                        <option value="">所有职员</option>
                        <option value="001">广告部</option>
                        <option value="010">业务部</option>
                        <option value="011">人事部</option>
                        <option value="100">其它</option>
                    </select>
                </div>
                <div class="col-md-10 col-md-offset-1" >
                    <select class="form-control" id="friends1" name="friends1"  style="font-size:15px;height:180px;" multiple="multiple">
                    		<?php 
                    			foreach ($users as $user) {
                    				if($user['permission']!=1)
                    				echo '<option>'.$user['username'].'</option>';
                    			}
                    		?>
                    		
                    </select>
                </div>  
            </div>
        </div>
        <div class="rs-dialog-footer">
            
            <input type="submit" value="确定" class="btn btn-success" style="float:right" />
            <button type="button" class="btn btn-primary pull-right" style="margin-right:10px;" id="warningm">添加时限</button>
    		<button type="button" class="btn btn-primary pull-right" style="margin-right:10px;" id="ordinarym">普通邮件</button>
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
                            <?php 
                            	if($email['handle_status']!=1)
                            	echo '<button type="button" rel="rs-dialog" data-target="myModal1" class="btn btn btn-primary btn-lg pull-right">分发</button>'
                            ?>
                            <?php if($email['handle_status']==1)
                           		echo '<a type="button" class="btn btn btn-success pull-right">已分发</a>'

                           		
                           	?>
                        </br>
                    </h3>
                    <div><span class="mailmst">发件人:</span><?=$email['sender']?></div>
                    <div><span class="mailmst">收件人:</span> <?=$email['receiver']?></div>
                    <div><span class="mailmst">时　间:</span> <?=$email['sendtime']?></div>
                    <div><span class="mailmst">附　件:</span> <?php
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
               <?php echo $email['text']?>

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