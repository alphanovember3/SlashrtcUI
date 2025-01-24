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
            <div class="table-title" style="background-color:rgb(19, 47, 58);">
                <div class="row">

                    <div class="col-sm-2">
                        <h2>Calling Data</h2>
                    </div>
                    <!-- <button id="#filterEmployeeModal" data-toggle="modal">filter</button> -->
                    <a href="#filterEmployeeModal" class="btn btn-success" data-toggle="modal" style="background-color:rgb(158, 236, 183);width: 150px; font-size:15px; "><i class="material-icons">&#xE147;</i> <span>Filter</span></a>
                   
                    <select class="form-select" aria-label="Default select example" style="width: 230px; font-size:15px;margin-left:9px; " onchange="window.location.href=this.value;">
                        <option selected disabled>Download Logger Report</option>
                        <option value="<?php echo base_url('/getLoggerReport/1') ?>">Mysql Summary</option>
                        <option value="<?php echo base_url('/getLoggerReport/2') ?>">Mongo Summary</option>
                        <option value="<?php echo base_url('/getLoggerReport/3') ?>">Elastic Summary</option>
                    </select>
                    <select class="form-select" aria-label="Default select example" style="width: 230px; font-size:15px; margin-left:9px;" onchange="window.location.href=this.value;">
                        <option selected disabled>Download Summary Report</option>
                        <option value="<?php echo base_url('/getSummaryReport/1') ?>">Mysql Summary</option>
                        <option value="<?php echo base_url('/getSummaryReport/2') ?>">Mongo Summary</option>
                        <option value="<?php echo base_url('/getSummaryReport/3') ?>">Elastic Summary</option>
                    </select>
                    <select class="form-select" aria-label="Default select example" style="width: 230px; font-size:15px; margin-left:9px;" onchange="window.location.href=this.value;">
                        <option selected disabled>Select the Summaryreport Type</option>
                        <option value="<?php echo base_url('/showSummaryReport/1') ?>">Mysql Summary</option>
                        <option value="<?php echo base_url('/showSummaryReport/2') ?>">Mongo Summary</option>
                        <option value="<?php echo base_url('/showSummaryReport/3') ?>">Elastic Summary</option>
                    </select>

                </div>
            </div>
            <!-- mydatatable -->
            <table class="table table-striped table-hover" id="" style="font-size: 13px;">
                <thead>
                    <tr>
                        <th>
                            <span class="custom-checkbox">
                                <input type="checkbox" id="selectAll">
                                <label for="selectAll"></label>
                            </span>
                        </th>
                        <th>ID</th>
                        <th>datetime</th>
                        <th>calltype</th>
                        <th>disposeType</th>
                        <th>callDuration</th>
                        <th>agentName</th>
                        <th>campaignName</th>
                        <th>processName</th>
                        <th>leadsetId</th>
                        <th>referenceUuid</th>
                        <th>customerUuid</th>
                        <th>holdTime</th>
                        <th>muteTime</th>
                        <th>ringingTime</th>
                        <th>transferTime</th>
                        <th>conferenceTime</th>
                        <th>callTime</th>
                        <th>DisposeTime</th>
                        <th>DisposeName</th>
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
                                <td><?php echo $user->datetime; ?></td>
                                <td><?php echo $user->calltype; ?></td>
                                <td><?php echo $user->disposeType; ?></td>
                                <td><?php echo gmdate('H:i:s', $user->callDuration); ?></td>
                                <td><?php echo $user->agentName; ?></td>
                                <td><?php echo $user->campaignName; ?></td>
                                <td><?php echo $user->processName; ?></td>
                                <td><?php echo $user->leadsetId; ?></td>
                                <td><?php echo $user->referenceUuid; ?></td>
                                <td><?php echo $user->customerUuid; ?></td>
                                <td><?php echo gmdate('H:i:s', $user->holdTime); ?></td>
                                <td><?php echo gmdate('H:i:s', $user->muteTime); ?></td>
                                <td><?php echo gmdate('H:i:s', $user->ringingTime); ?></td>
                                <td><?php echo gmdate('H:i:s', $user->transferTime); ?></td>
                                <td><?php echo gmdate('H:i:s', $user->conferenceTime); ?></td>
                                <td><?php echo gmdate('H:i:s', $user->callTime); ?></td>
                                <td><?php echo gmdate('H:i:s', $user->disposeTime); ?></td>
                                <td><?php echo $user->disposeName; ?></td>
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



<!-- Filter Modal HTML -->
<div id="filterEmployeeModal" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<!-- /filter -->
			<form action="/showReport/<?php echo $reportNo ?>" method="get">
				<div class="modal-header">
					<h4 class="modal-title">Filter</h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true" style="margin-left: 130px;">&times;</button>
				</div>
				<div class="modal-body">
					
                    <div>Select Calltype:</div>
					<select class="form-select" aria-label="Default select example" name="calltype" value = <?=set_value('calltype') ?>>
                            <option disabled selected >Select The calltype</option>
                            <option value="Dispose" >Answered calls</option>
                            <option value="Missed" >Missed calls</option>
                            <option value="Autodrop" >Autodrop calls</option>
                            <option value="Autofail" >Autofail calls</option>
                           
					</select>

					<div>Search AgentName:</div>
					<input type="text" name="agent" value = "<?=set_value('agent') ?>">
					<div>Search campaignName:</div>
					<input type="text" name="campaign" value ="<?=set_value('campaign')?>">
                 
				</div>
				<div class="modal-footer">
					<input type="button" name="submit" class="btn btn-default" data-dismiss="modal" value="Cancel">
					<input type="submit" class="btn btn-info" value="Save">
				</div>
			</form>
		</div>
	</div>
</div>


