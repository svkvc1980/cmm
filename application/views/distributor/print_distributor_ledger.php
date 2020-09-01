<!DOCTYPE html>
<html>
<head>
    <title>AP Oil Fed</title>
    <link href="<?php echo assets_url(); ?>custom/css/print.css" media="print" rel="stylesheet" type="text/css" />
    <link href="<?php echo assets_url(); ?>custom/css/report.css" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" href="<?php echo assets_url(); ?>layouts/layout3/img/small-tile.png" /> 
</head>
<body>
    <h2 align="center">AP Cooperative Oilseeds Growers Federation Ltd</h2>
    <p align="center"><b>Ledger Report Of <?php echo $distributor['agency_name'].' ( '.$distributor['distributor_code'].' ) [ '.$distributor['distributor_place'].' ]';?></b></p>
    <p align="center"><b>From <?php echo date('d-m-Y',strtotime($from_date));?> TO <?php echo date('d-m-Y',strtotime($to_date));?></b></p>

    <br>

    <table  align="center" width="350" cellspacing="0" cellpadding="2" >
        <tr class="blue_head black"><th colspan="2">Current Balance Info</th></tr>
        <tr><td><b>SD Amount</b></td><td align="right"><?php echo price_format($distributor['sd_amount']);?></td></tr>
        <tr><td><b>Total BG Amount</b></td><td align="right"><?php echo price_format($tot_bg_amount);?></td></tr>
        <tr><td><b>Outstanding Amount</b></td><td align="right"><?php echo price_format($distributor['outstanding_amount'])?></td></tr>
        <tr><td><b>Available Amount</b></td><td align="right"><?php echo price_format($distributor['sd_amount']+$distributor['outstanding_amount']+$tot_bg_amount);?></td></tr>
        <tr><td><b>Pending DO Amount</b></td><td align="right"><?php echo price_format($current_pending_do_amount);?></td></tr>
    </table>
    <br>
    <?php $amount_width = 85;?>
    <table  align="center" width="1350" cellspacing="0" cellpadding="2" >
        <thead class="blue_head black">
            <tr>
                <th rowspan="2" width="75">Date</th>
                <th rowspan="2" width="<?php echo $amount_width;?>">O/B</th>
                <th rowspan="1" colspan="2">Receits (DD/Online)</th>
                <th rowspan="1" colspan="2">DO</th>
                <th rowspan="1" colspan="2">Invoice</th>
                <th rowspan="1" colspan="2">Debit Note</th>
                <th rowspan="1" colspan="2">Credit Note</th>
                <th rowspan="2" width="<?php echo $amount_width;?>">Penalty</th>
                <th rowspan="2" width="<?php echo $amount_width;?>">Debit</th>
                <th rowspan="2" width="<?php echo $amount_width;?>">Credit</th>
                <th rowspan="2" width="<?php echo $amount_width;?>">Balance</th>
            </tr>
            <tr>
                <th width="90">DD No</th>
                <th width="<?php echo $amount_width;?>">Amount</th>
                <th width="55">DO No</th>
                <th width="<?php echo $amount_width;?>">Amount</th>
                <th width="65">Inv No</th>
                <th width="<?php echo $amount_width;?>">Amount</th>
                <th width="100">Purpose</th>
                <th width="<?php echo $amount_width;?>">Amount</th>
                <th width="100">Purpose</th>
                <th width="<?php echo $amount_width;?>">Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if(count($transaction_results)>0)
            {
                $cur_outstanding_amount = $opening_outstanding_amount;
                $dd_total = $do_total = $invoice_total = $debit_note_total = $credit_note_total = $penality_total = $credit_grand_total = $debit_grand_total = 0;
                $j = 0; $opening_bal = ''; $closing_bal = '';
                foreach ($transaction_results as $trow) {
                    $credit_total = $debit_total = 0;
                    $sd_amount = get_sd_amount($distributor['distributor_id'],$trow['transaction_date']);
                    $bg_amount = get_bg_amount($distributor['distributor_id'],$trow['transaction_date']);
                    $cur_available_amount = $cur_outstanding_amount + $sd_amount + $bg_amount;
                    if($j==0)
                        $opening_bal = $cur_available_amount;
                    ?>
                <tr>
                    <td valign="top"><?php echo format_date($trow['transaction_date']);?></td>
                    <td align="right" valign="top"><?php echo price_format($cur_available_amount);?></td>
                    <?php
                    $dd_numbers_str = ''; $dd_amounts_str = '';
                    if(isset($dd_receipts[$trow['transaction_date']]))
                    {
                        $i=0;
                        foreach ($dd_receipts[$trow['transaction_date']] as $ddr_row) {

                            if($i>0)
                            {

                                $dd_numbers_str .= '<br>';
                                $dd_amounts_str .= '<br>';
                            }
                            $dd_numbers_str .= $ddr_row['dd_number'];
                            $dd_amounts_str .= price_format($ddr_row['amount']);
                            //echo price_format($ddr_row['amount']).'('.$ddr_row['dd_number'].')';
                            $dd_total += $ddr_row['amount'];
                            $credit_total += $ddr_row['amount'];
                            $i++;
                        }
                    }
                    ?>
                    <td align="left" valign="top"><?php echo $dd_numbers_str;?></td>
                    <td align="right" valign="top"><?php echo $dd_amounts_str;?></td>
                    <?php
                    $do_numbers_str = ''; $do_amounts_str = '';
                    if(isset($do_list[$trow['transaction_date']]))
                    {
                        $i=0;
                        foreach ($do_list[$trow['transaction_date']] as $drow) {
                            if($i>0)
                            {

                                $do_numbers_str .= '<br>';
                                $do_amounts_str .= '<br>';
                            }
                            $do_numbers_str .= $drow['do_number'];
                            $do_amounts_str .= price_format($drow['do_amt']);
                            //echo price_format($drow['do_amt']).'('.$drow['do_number'].')';
                            $do_total += $drow['do_amt'];
                            //$debit_total += $drow['do_amt'];
                            $i++;
                        }
                    }
                    ?>
                    <td align="left" valign="top"><?php echo $do_numbers_str;?></td>
                    <td align="right" valign="top"><?php echo $do_amounts_str;?></td>
                    <?php
                    $invoice_numbers_str = ''; $invoice_amounts_str = '';
                    if(isset($invoice_list[$trow['transaction_date']]))
                    {
                        $i=0;
                        foreach ($invoice_list[$trow['transaction_date']] as $drow) {
                            if($i>0)
                            {

                                $invoice_numbers_str .= '<br>';
                                $invoice_amounts_str .= '<br>';
                            }
                            $invoice_numbers_str .= $drow['invoice_number'];
                            $invoice_amounts_str .= price_format($drow['invoice_amt']);
                            //echo price_format($drow['invoice_amt']).'('.$drow['invoice_number'].')';
                            $invoice_total += $drow['invoice_amt'];
                            $debit_total += $drow['invoice_amt'];
                            $i++;
                        }
                    }
                    ?>
                    <td align="left" valign="top"><?php echo $invoice_numbers_str;?></td>
                    <td align="right" valign="top"><?php echo $invoice_amounts_str;?></td>
                    <?php
                    $dnote_purpose_str = ''; $dnote_amounts_str = '';
                    if(isset($debit_note[$trow['transaction_date']]))
                    {
                        $i=0;
                        foreach ($debit_note[$trow['transaction_date']] as $drow) {
                            if($i>0)
                            {

                                $dnote_purpose_str .= '<br>';
                                $dnote_amounts_str .= '<br>';
                            }
                            if($drow['purpose']=='')
                            $drow['purpose'] = "Others";
                            $dnote_purpose_str .= $drow['purpose'];
                            $dnote_amounts_str .= price_format($drow['amount']);
                            //echo price_format($drow['amount']).'('.$drow['purpose'].')';
                            $debit_note_total += $drow['amount'];
                            $debit_total += $drow['amount'];
                            $i++;
                        }
                    }
                    ?>
                    <td align="left" valign="top"><?php echo $dnote_purpose_str;?></td>
                    <td align="right" valign="top"><?php echo $dnote_amounts_str;?></td>
                    <?php
                    $cnote_purpose_str = ''; $cnote_amounts_str = '';
                    if(isset($credit_note[$trow['transaction_date']]))
                    {
                        $i=0;
                        foreach ($credit_note[$trow['transaction_date']] as $row) {
                            if($i>0)
                            {

                                $cnote_purpose_str .= '<br>';
                                $cnote_amounts_str .= '<br>';
                            }
                            if($row['purpose']=='')
                            $row['purpose'] = "Others";
                            $cnote_purpose_str .= $row['purpose'];
                            $cnote_amounts_str .= price_format($row['amount']);
                            //echo price_format($row['amount']).'('.$row['purpose'].')';
                            $credit_note_total += $row['amount'];
                            $credit_total += $row['amount'];
                            $i++;
                        }
                    }
                    ?>
                    <td align="left" valign="top"><?php echo $cnote_purpose_str;?></td>
                    <td align="right" valign="top"><?php echo $cnote_amounts_str;?></td>
                    <td align="right" valign="top">
                        <?php
                        if(isset($penality_list[$trow['transaction_date']]))
                        {
                            $i=0;
                            foreach ($penality_list[$trow['transaction_date']] as $row) {
                                if($i>0)
                                    echo '<br>';
                                echo price_format($row['penality_amount']);
                                $penality_total += $row['penality_amount'];
                                $debit_total += $row['penality_amount'];
                                $i++;
                            }
                        }
                        ?>
                    </td>
                    <td align="right" valign="top"><?php echo price_format($debit_total);?></td>
                    <td align="right" valign="top"><?php echo price_format($credit_total);?></td>
                    <td align="right" valign="top">
                        <?php
                        $cur_outstanding_amount += $credit_total;
                        $cur_outstanding_amount -= $debit_total;
                        $cur_available_amount = $cur_outstanding_amount + $sd_amount + $bg_amount;
                        echo price_format($cur_available_amount);
                        $closing_bal = $cur_available_amount;
                        ?>
                    </td>
                </tr>
                    <?php
                    $debit_grand_total += $debit_total;
                    $credit_grand_total += $credit_total;
                    $j++;
                }
                ?>
                <tr>
                    <th></th>
                    <th align="right"><?php echo price_format($opening_bal);?></th>
                    <th></th>
                    <th align="right"><?php echo ($dd_total>0)?price_format($dd_total):'';?></th>
                    <th></th>
                    <th align="right"><?php echo ($do_total>0)?price_format($do_total):'';?></th>
                    <th></th>
                    <th align="right"><?php echo ($invoice_total>0)?price_format($invoice_total):'';?></th>
                    <th></th>
                    <th align="right"><?php echo ($debit_note_total>0)?price_format($debit_note_total):'';?></th>
                    <th></th>
                    <th align="right"><?php echo ($credit_note_total>0)?price_format($credit_note_total):'';?></th>
                    <th align="right"><?php echo ($penality_total>0)?price_format($penality_total):'';?></th>
                    <th align="right"><?php echo ($debit_grand_total>0)?price_format($debit_grand_total):'';?></th>
                    <th align="right"><?php echo ($credit_grand_total>0)?price_format($credit_grand_total):'';?></th>
                    <th align="right"><?php echo price_format($closing_bal);?></th>
                </tr>
                <?php
            }
            else
            {
                ?>
                <tr><td colspan="14" align="center"> No Records Found</td></tr>
                <?php
            }
            ?>
        </tbody>
    </table><br>
    <div class="wrapper" style="text-align:center">
        <button class="print_element"  onclick="print_srn()">Print</button>
        <a class="button print_element" href="<?php echo SITE_URL.'distributor_ledger';?>">Back</a>
    </div>
<script type="text/javascript">
    function print_srn()
    {
        window.print(); 
    }
</script>
</body>
</html>