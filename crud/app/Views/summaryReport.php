<div class="container-xl">
    <div class="table-responsive d-flex flex-column">

        <?php
        if (session()->getFlashdata("success")) {
        ?>
            <div class="alert w-50 align-self-center alert-success alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata("success"); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>

        <?php
        if (session()->getFlashdata("fail")) {  ?>
            <div class="alert w-50 align-self-center alert-danger alert-dismissible fade show" role="alert">
                <?php echo session()->getFlashdata("fail"); ?>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        <?php } ?>
        <div class="table-wrapper">
            <div class="table-title" style="background-color:rgb(36, 2, 44);">
                <div class="row">

                    <div class="col-sm-3">
                        <h2>Calling Data Summary</h2>
                    </div>
                    <select class="form-select" aria-label="Default select example" style="width: 250px; font-size:15px; " onchange="window.location.href=this.value;">
                        <option selected disabled>Download Logger Report</option>
                        <option value="<?php echo base_url('/getLoggerReport/1') ?>">Mysql Summary</option>
                        <option value="<?php echo base_url('/getLoggerReport/2') ?>">Mongo Summary</option>
                        <option value="<?php echo base_url('/getLoggerReport/3') ?>">Elastic Summary</option>
                    </select>
                    <select class="form-select" aria-label="Default select example" style="width: 250px; font-size:15px; margin-left:9px;" onchange="window.location.href=this.value;">
                        <option selected disabled>Download Summary Report</option>
                        <option value="<?php echo base_url('/getSummaryReport/1') ?>">Mysql Summary</option>
                        <option value="<?php echo base_url('/getSummaryReport/2') ?>">Mongo Summary</option>
                        <option value="<?php echo base_url('/getSummaryReport/3') ?>">Elastic Summary</option>
                    </select>

                </div>
            </div>
            <!-- mydatatable -->
            <table class="table table-striped table-hover" id="">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>ID</th>
                        <th>TotalCalls</th>
                        <th>CallHour</th>
                        <th>CallAnswered</th>
                        <th>MissedCalls</th>
                        <th>CallAutodrop</th>
                        <th>CallAutofail</th>
                        <th>Talktime</th>
                    </tr>
                </thead>
                <tbody>

                    <?php
                    $num = 1;

                    if ($callerdata) {

                        foreach ($callerdata as $user) {

                    ?>
                            <tr>
                                <input type="hidden" id="userId" name="id" value="<?php echo $num; ?>">
                                <td>
                                    <span class="custom-checkbox">
                                        <input type="checkbox" id="data_checkbox" class="data_checkbox" name="data_checkbox" value="<?php echo $num; ?>">
                                        <label for="data_checkbox"></label>
                                    </span>
                                </td>
                                <td><?php echo $num ?></td>

                                <?php if($reportNo == 3){?>
                                <td><?php echo $user->doc_count; ?></td>
                                <?php } else{  ?>
                                <td><?php echo $user->Total_Calls; ?></td>
                                <?php } ?>

                                <?php if($reportNo == 1){ ?>
                                <td><?php echo $user->Call_Hour.'-'.$user->Call_Hour+1; ?></td>
                                <?php }  ?>
                                <?php if($reportNo == 2){?>
                                <td><?php echo $user->_id.'-'.$user->_id+1; ?></td>
                                <?php }  ?>
                                <?php if($reportNo == 3){?>
                                <td><?php echo $user->key_as_string; ?></td>
                                <?php }  ?>

                                <?php if($reportNo == 3){?>
                                <td><?php echo $user->AnsweredCount->doc_count; ?></td>
                                <?php } else{  ?>
                                <td><?php echo $user->Call_Answered; ?></td>
                                <?php } ?>

                                <?php if($reportNo == 3){?>
                                <td><?php echo $user->missedCount->doc_count; ?></td>
                                <?php } else{  ?>
                                <td><?php echo $user->Missed_Calls; ?></td>
                                <?php } ?>

                                <?php if($reportNo == 3){?>
                                <td><?php echo $user->dropCount->doc_count; ?></td>
                                <?php } else{  ?>
                                <td><?php echo $user->Call_Autodrop; ?></td>
                                <?php } ?>

                                <?php if($reportNo == 3){?>
                                <td><?php echo $user->failCount->doc_count; ?></td>
                                <?php } else{  ?>
                                <td><?php echo $user->Call_Autofail; ?></td>
                                <?php } ?>

                                <?php if($reportNo == 3){?>
                                <td><?php echo gmdate('H:i:s',$user->Talktime->value); ?></td>
                                <?php } else{  ?>
                                <td><?php echo gmdate('H:i:s',$user->Talktime);  ?></td>
                                <?php } ?>  
                                <?php $num = $num + 1; ?>
                               
                            </tr>
                    <?php
                        }
                    }
                    ?>
                </tbody>
            </table>
            <!-- Pagination Links -->
            <div> <?= $pager ?> </div>

        </div>
    </div>
</div>