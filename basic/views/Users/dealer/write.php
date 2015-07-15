<?php $this->beginContent('@app/views/layouts/dealer.php');?>
         <!--panel-->
            <div class="panel panel-default">
               
                <div class="panel-body">
                   
                    <form>
                    <div class="form-group">
                    <label>收件人</label><input type="email" class="form-control" placeholder="Email地址"/>
                    </div>
                    <div class="form-group">
                    <label>主题</label><input type="text" class="form-control" placeholder="主题"/>
                    </div>
                    <div class="form-group">
                    <label>添加附件</label><input type="file"/>
                    </div>
                    <div class="form-group">
                    <label>正文</label><p></p>  
                    <textarea cols="135" rows="10"></textarea>               
                    </div>
                    <button type="submit"  class="btn btn-primary btn-lg" style="width:150px;">发送</button>
                    
                    </form>
                    
                    

                 
                </div>
            
                    </div>
<?php $this->endContent();?>