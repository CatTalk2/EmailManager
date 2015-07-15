<?php $this->beginContent('@app/views/layouts/dealer.php');?>

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
                            
                        </br>
                    </h3>
                   
                    <div><span class="mailmst">收件人:</span> <?=$email['receiver']?></div>
                    <div><span class="mailmst">时　间:</span> <?=$email['send_time']?></div>
                    <div><span class="mailmst">附　件:</span>  <?php
                    
                    	if($email['attachment']!=NULL){

            			$fujian=explode(';', $email['attachment']);
            			for($i=0;$i<count($fujian)-1;$i++) {
            				echo basename($fujian[$i])."  ";
            				
            			}
            		}
            		
                    ?></div>
                    

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