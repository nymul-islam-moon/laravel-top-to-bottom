<?php
    include '../database.php';
    $sql="SELECT campaign_id campaign_name FROM `vicidial_campaigns`";
    $result=mysql_query($sql);
    // echo "<pre>";
    // print_r( $row);
?>
<div class="row-fluid sortable">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="fa fa-search"></i><span class="break"></span>Search Function</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="fa fa-chevron-up"></i></a>

            </div>
        </div>
        <div class="box-content">
            <form class="form-horizontal" method="post" action="<?php echo BASE_URL . '?p=' . $_GET['p']; ?>">
                <fieldset>
                    <div class="row">
                                <!--Select Campaign-->
                                <div class="span4">
                            <div class="control-group">
                                <label class="control-label" for="select_camp">Campaign: </label>
                                <div class="controls">
                                     <!--Select Campaign-->
                             <select  name="select_camp" id="select_camp">
                             <option value="all" selected >All</option>
                                <?php
                                include '../database.php';
                                $query = mysql_query("Select campaign_id from vicidial_campaigns");
                                while ($row = mysql_fetch_array($query)) {
                                    ?>
                                    <option value="<?php echo $row['campaign_id']; ?>"><?php echo $row['campaign_id']; ?></option>
                                <?php } ?>
                                </select>
                                </div>
                            </div>
                        </div>
                        <!-- date start -->

                        <div class="span4">


                            <div class="control-group">
                                <label class="control-label" for="startdate">Start Date: </label>
                                <div class="controls">
                                    <input name="date_start" type="text" class="input-medium datepicker" id="date_start" value="<?php
                                    if (isset($_POST['date_start'])) {
                                        echo $_POST['date_start'];
                                    } else
                                        echo date('m/d/Y');
                                    ?>" title="Date Format - MM/DD/YYYY">
                                </div>
                            </div>



                        </div>

                        <!-- date end -->

                        <div class="span4">


                            <div class="control-group">
                                <label class="control-label" for="startdate">End Date: </label>
                                <div class="controls">
                                    <input name="date_end" type="text" class="input-medium datepicker" id="date_end" value="<?php
                                    if (isset($_POST['date_end'])) {
                                        echo$_POST['date_end'];
                                    } else
                                        echo date('m/d/Y');
                                    ?>" title="Date Format - MM/DD/YYYY">
                                </div>
                            </div>


                        </div>


                    </div> <!-- /.row -->
                    <div class="form-actions">
                        <button name="search" type="submit" class="btn btn-primary" id="search">Search </button>
						<a href="" id="download" class="btn btn-info"><i class="fa fa-cloud-download"></i> Download</a>
                    </div>
                </fieldset>
            </form>

        </div>
    </div><!--/span-->

</div><!--/row-->


<!--Loading effect-->
<div class="loader">
    <img src="img/loading.gif" alt="loader" class="img-responsive" style="display: none; height: 80px; width: 80px; position: fixed; z-index: 100; background: white; border-radius: 50%; border: 1px solid powderblue;">
</div>


<!--display report result-->
<div class="row-fluid">
    <div class="box span12">
        <div class="box-header" data-original-title>
            <h2><i class="halflings-icon white time"></i><span class="break"></span>Outbound Report Log</h2>
            <div class="box-icon">
                <a href="#" class="btn-minimize"><i class="halflings-icon white chevron-up"></i></a>
            </div>
        </div>
        <div  class="box-content" style="overflow-x: scroll">
            <table style="width: 1500px" class="table table-striped table-bordered cdrDataTable" id="cdrDataTable">
                <thead>
                    <tr>
                        <th>No</th>
						<th>Call Date</th>
                        <th>Call Time</th>
						<th>Phone Number</th>
						<th>Wrap-up Status</th>
						<th>Call Status</th>
						<th>User</th>
						<th>Full Name</th>
						<th>Campaign ID</th>
						<th>Talk Time</th>
						<th>Hold Time</th>
                        <th>Dead Time</th>
						<th>Dispo Time</th>
						<!-- <th>List ID</th>
						<th>Phone Code</th> -->
						<th>length_In_Sec</th>
						<th>User Group</th>
						<th>ALT Dial</th>
						<!-- <th>Unique ID</th> -->
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div><!--/span-->

</div><!--/row-->

<script>

    /* loading effect */
    let wHeight = Math.ceil(($(window).height() - $('.loader img').innerHeight()) / 2);
    let wWidth = Math.ceil(($(window).width() - $('.loader img').innerWidth()) / 2);

    /* current page for pagination */
    let current_page = 1;
    /* jquery ready */
    $(document).ready(function () {

		/* Genereate downloadable url */
        var url = "reports/export-outbound-report-download.php?date_start=" + $('#date_start').val() + "&date_end=" + $('#date_end').val();
        $('#download').attr('href', url);
        $('#date_start').change(function () {
            url = "reports/export-outbound-report-download.php?date_start=" + $(this).val() + "&date_end=" + $('#date_end').val();
            $('#download').attr('href', url);

        });
        $('#date_end').change(function () {
            url = "reports/export-outbound-report-download.php?date_start=" + $('#date_start').val() + "&date_end=" + $(this).val();
            $('#download').attr('href', url);

        });

        $('#search').click(function (e) {
            e.preventDefault();
            let date_start = $('#date_start');
            let date_end = $('#date_end');
            let select_camp = $('#select_camp');
			$.ajax({
                url: 'reports/export-outbound-report-result.php',
                type: 'POST',
                beforeSend: (http) => {
                    $('.loader img').fadeIn('fast').css({
                        'top': wHeight + 'px',
                        'left': wWidth + 'px'
                    });
                },
                dataType: 'json',
                data: {
                    'date_start': date_start.val(),
                    'date_end': date_end.val(),
                    'select_camp':select_camp.val()
                },
                success: function (result) {
                    $('.loader img').fadeOut(1000);
                    var t = $("#cdrDataTable").DataTable({
                        data: result,
                        destroy: true,
                        columns: [
                            {data: []},
                            {data: 'call_date'},
                            {data: 'call_time'},
                            {data: 'phone_number'},
                            {data: 'status'},
							{data: 'call_status'},
                            {data: 'agent'},
                            {data: 'full_name'},
                            {data: 'campaign_id'},
                            {data: 'talk_time'},
                            {data: 'hold_time'},
                            {data: 'wrap_up_time'},
                            {data: 'dispo_sec'},
							// {data: 'list_id'},
							// {data: 'phone_code'},
                            {data: 'length_in_sec'},
							{data: 'user_group'},
							{data: 'alt_dial'},
                            // {data: 'uniqueid'}
                        ],
                        "columnDefs": [{
                                "defaultContent": "-",
                                "targets": "_all"
                            }],
                        "order": [[1, 'asc']]
                    });
                    t.on('order.dt search.dt', function () {
                        t.column(0, {search: 'applied', order: 'applied'}).nodes().each(function (cell, i) {
                            cell.innerHTML = i + 1;
                        });
                    }).draw();
                    /* End: showing result into datatable */

                }
            });

        });
    });

</script>
