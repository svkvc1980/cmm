<br><br><br><br>
<p align="right"> <?php echo date('Y-m-d H:i:s') ?> </p>
<h3 align="center">Distributor Reports</h3>
<table align="center" border="1px" width="100%">
    <thead>
        <tr>
            <th><b>S. No</b></th>
            <th><b>Distributor Code</b></th>
            <th><b>Distributor Type</b></th>
            <th><b>Agency Name</b></th>
            <th><b>Concerned Person</b></th>
            <th><b>Location</b></th>
            <th><b>Mobile</b></th>
            <th><b>Executive</b></th>
            <th><b>SD amount</b></th>
            <th><b>Available Amount</b></th>
        </tr>
    </thead>
    <tbody>
        <?php $sn = 1;
        if($distributor_reports)
        {
            foreach($distributor_reports as $row)
            {
        ?>
        <tr>
            <td> <?php echo $sn++ ?> </td>
            <td><?php echo $row['distributor_code']; ?></td>
            <td><?php echo $row['type_name']; ?></td>
            <td><?php echo $row['agency_name']; ?></td>
            <td><?php echo $row['concerned_person']; ?></td>
            <td><?php echo $row['location_name']; ?></td>
            <td><?php echo $row['mobile']; ?></td>
            <td><?php echo $row['exe_name']; ?></td>
            <td><?php echo $row['sd_amount']; ?></td>
            <td><?php echo $row['outstanding_amount']; ?></td>
        </tr>
        <?php } 
        }
        else 
        {
        ?>  
            <tr><td colspan="10" align="center">No Records</span></td></tr>
        <?php   
        } ?>
    </tbody>
</table>
<br><br><br><br>
<p style="position: fixed; bottom: 0; width:100%; text-align: right"><strong>Authorised Signature</strong></p>