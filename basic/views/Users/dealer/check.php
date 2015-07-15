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

        </div>

        <div class="form bidform">
            <table class="table table-striped table-bordered">
                <thead>
                <tr >

                    <th>发件人</th>
                    <th>邮件主题</th>
                    <th>收件人</th>
                    <th>状态</th>
                    <th>发送时间</th>


                </tr>
                </thead>
                <tbody>
                <?php
                foreach($emails as $email){
                    ?>
                    <tr>

                        <td><?=$check['username']?></td>
                        <td><a  href="<?=\yii\helpers\Url::toRoute(['site/checkdetail','id'=>$email['id'],'username'=>$check['username'],'check_status'=>$email['check_status'],'checker'=>$email['checker'],'check_advise'=>$email['check_advise']]);?>"><?=$email['subject']?></a></td>
                        <td><?=$email['receiver']?></td>
                        <td>
                            <?php
                            if($email['check_status']==0)
                                echo "<button type='button' class='btn btn-warning btn-xs'>
                                               &nbsp;&nbsp;待审核&nbsp;&nbsp;
                                               </button>";
                            else if($email['check_status']==1)
                                echo "<button type='button' class='btn btn-success btn-xs'>
                                               &nbsp;&nbsp;通&nbsp;&nbsp;&nbsp;过&nbsp;&nbsp;
                                               </button>";
                            else if($email['check_status']==2)
                                echo "<button type='button' class='btn btn-danger btn-xs'>
                                               &nbsp;&nbsp;未通过&nbsp;&nbsp;
                                               </button>";

                            ?>


                        </td>


                        <td><?=$email['send_time']?></td>

                    </tr>



                <?php } ?>

                </tbody>
            </table>
            <?php
            use yii\helpers\Html;
            use yii\widgets\LinkPager;
            ?>
            <div style="text-align: center">
                <div  style="display:inline-block;vertical-align:middle;margin:auto">共 <?=$check['count']?> 条</div>

                <div style="display:inline-block;vertical-align:middle;margin:auto">
                    <?=LinkPager::widget(['pagination'=>$pagination]) ?>

                </div>

            </div>




        </div>
    </div>
</div>
<?php $this->endContent();?>
