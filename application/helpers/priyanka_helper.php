<?php

# Email Alert to distributor for Order Booking
function distributor_OB_mail($distributor_id,$products,$order_number) {
    $CI = & get_instance();
    $CI->db->select('u.email,u.name as user,u.user_id');
    $CI->db->from('distributor d');
    $CI->db->join('user u','u.user_id = d.user_id','inner');
    $CI->db->where('d.distributor_id',$distributor_id);
    $CI->db->where('u.status',1);
    $query = $CI->db->get();
    //echo $CI->db->last_query();
    foreach ($query->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: Opportunity expected order conclusion date update is required';
        $message = '<p>Hi <b>'.$row['user'].' </b>,</p>';
        $message .= '<p>Your Order has been Placed successfully with Order Booking Number: <b>'.$order_number.' </b></p>';
        $message .= '<table style="border-collapse: collapse;">
                            <thead style="color:#ffffff; background-color:#6B9BCF;">
                                <tr>
                                    <th style="border: 1px solid black;">Product</th>
                                    <th style="border: 1px solid black;">Price</th>
                                    <th style="border: 1px solid black;">Quantity</th>
                                    <th style="border: 1px solid black;">Total Price</th>
                                </tr>
                            </thead>
                        <tbody>';
        //$results = orderConclusionResultsByUser($row['user_id'],1);
        $grand_total = 0;
        foreach ($products as $row1) {

            $price = $row1['add_price']+$row1['unit_price'];
            $total_price = ($row1['unit_price']+$row1['add_price'])*($row1['quantity']*$row1['items_per_carton']);
            $product_name = get_prod_name($row1['product_id']);
            $message.= '<tr>
                            <td style="border: 1px solid black;">'.$product_name.'</td>
                            <td style="border: 1px solid black;">'.$price.'</td>
                            <td style="border: 1px solid black;">'.$row1['quantity'].'</td>
                            <td style="border: 1px solid black;">'.$total_price.'</td>
                        </tr>';
            $grand_total+= $total_price;
        }
        
        $message .= '<tr>
                            <td style="border: 1px solid black;" align="right" colspan="4"><b>Grand Total:'.$grand_total.'</b></td>
                    </tr>';
        $message .= '</tody>
                    </table><br>';

        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return $message;
    }

}

# Email Alert to Plants for Order Booking
function plants_OB_mail($plant_id,$ob_products,$order_number) {
    $block_id           =  get_block_id($plant_id);
    $designation_id     =  get_managerDesig_id();
    $CI = & get_instance();
    $CI->db->select('email,name as user,user_id');
    $CI->db->from('user');
    $CI->db->where('plant_id',$plant_id);
    $CI->db->where('block_id',$block_id);
    $CI->db->where('designation_id',$designation_id);
    $CI->db->where('status',1);
    $query = $CI->db->get();
    //echo $CI->db->last_query();
    //return $query->result_array();exit;
    foreach ($query->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: Opportunity expected order conclusion date update is required';
        $message = '<p>Hi <b>'.$row['user'].' </b>,</p>';
        $message .= '<p>Your Order has been Placed successfully with Order Booking Number: <b>'.$order_number.' </b></p>';
        $message .= '<table style="border-collapse: collapse;">
                            <thead style="color:#ffffff; background-color:#6B9BCF;">
                                <tr>
                                    <th style="border: 1px solid black;">Product</th>
                                    <th style="border: 1px solid black;">Price</th>
                                    <th style="border: 1px solid black;">Quantity</th>
                                    <th style="border: 1px solid black;">Total Price</th>
                                </tr>
                            </thead>
                        <tbody>';
        //$results = orderConclusionResultsByUser($row['user_id'],1);
        $grand_total = 0;
        foreach ($ob_products as $row1) {

            $price = $row1['add_price']+$row1['unit_price'];
            $total_price = ($row1['unit_price']+$row1['add_price'])*($row1['quantity']*$row1['items_per_carton']);
            $product_name = get_prod_name($row1['product_id']);
            $message.= '<tr>
                            <td style="border: 1px solid black;">'.$product_name.'</td>
                            <td style="border: 1px solid black;">'.$price.'</td>
                            <td style="border: 1px solid black;">'.$row1['quantity'].'</td>
                            <td style="border: 1px solid black;">'.$total_price.'</td>
                        </tr>';
            $grand_total+= $total_price;
        }
        
        $message .= '<tr>
                            <td style="border: 1px solid black;" align="right" colspan="4"><b>Grand Total:'.$grand_total.'</b></td>
                    </tr>';
        $message .= '</tody>
                    </table><br>';

        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return $message;
    }

}

# Email Alert to distributor for Invoice
function distributor_invoice_mail($do_ids,$invoice_products,$invoice_number){
    # Get order id array
    $CI = & get_instance();
    $CI->db->select('order_id');
    $CI->db->from('do_order');
    $CI->db->where_in('do_id',$do_ids);
    $CI->db->group_by('order_id');
    $query = $CI->db->get();
    $result = $query->result_array();
    $order_id_arr = array_column($result,'order_id');
    
    # Get distributor id
    $CI = & get_instance();
    $CI->db->select('distributor_id');
    $CI->db->from('distributor_order');
    $CI->db->where_in('order_id',$order_id_arr);
    $CI->db->group_by('distributor_id');
    $qry = $CI->db->get();
    $res = $qry->result_array();
    $distributor_id_arr = array_column($res,'distributor_id');
    //return $distributor_id_arr;exit;

    # Get Distributor mail, name
    $CI = & get_instance();
    $CI->db->select('u.email,u.name as user,u.user_id');
    $CI->db->from('distributor d');
    $CI->db->join('user u','u.user_id = d.user_id','inner');
    $CI->db->where_in('d.distributor_id',$distributor_id_arr);
    $CI->db->where('u.status',1);
    $query1 = $CI->db->get();

    //echo $CI->db->last_query();
    foreach ($query1->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: Invoice Raised';
        $message = '<p>Hi <b>'.$row['user'].' </b>,</p>';
        $message .= '<p>Your Invoice has been Placed successfully with Invoice Number: <b>'.$invoice_number.' </b></p>';
        $message .= '<table style="border-collapse: collapse;">
                            <thead style="color:#ffffff; background-color:#6B9BCF;">
                                <tr>
                                    <th style="border: 1px solid black;">Product</th>
                                    <th style="border: 1px solid black;">Price</th>
                                    <th style="border: 1px solid black;">Pending Quantity</th>
                                    <th style="border: 1px solid black;">Invoice Quantity</th>
                                    <th style="border: 1px solid black;">Total Price</th>
                                </tr>
                            </thead>
                        <tbody>';
        //$results = orderConclusionResultsByUser($row['user_id'],1);
        $grand_total = 0;
        foreach ($invoice_products as $row1) {

            $message.= '<tr>
                            <td style="border: 1px solid black;">'.$row1['p_product_name'].'</td>
                            <td style="border: 1px solid black;">'.$row1['p_price'].'</td>
                            <td style="border: 1px solid black;">'.$row1['p_pending_qty'].'</td>
                            <td style="border: 1px solid black;">'.$row1['p_invoice_qty'].'</td>
                            <td style="border: 1px solid black;">'.$row1['p_total_price'].'</td>
                        </tr>';
            $grand_total+= $row1['p_total_price'];
        }
        
        $message .= '<tr>
                            <td style="border: 1px solid black;" align="right" colspan="5"><b>Grand Total:'.$grand_total.'</b></td>
                    </tr>';
        $message .= '</tody>
                    </table><br>';

        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return $message;
    }

}

# Email Alert to distributor for Payment Receipt
function distributor_payment_receipt_mail($distributor_id,$distributor_code,$payment_details){
    $CI = & get_instance();
    $CI->db->select('u.email,u.name as user,u.user_id');
    $CI->db->from('distributor d');
    $CI->db->join('user u','u.user_id = d.user_id','inner');
    $CI->db->where('d.distributor_id',$distributor_id);
    $CI->db->where('u.status',1);
    $query = $CI->db->get();
    //echo $CI->db->last_query();
    foreach ($query->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: Payment Receipt';
        $message = '<p>Dear <b>'.$row['user'].' </b>,</p>';
        //$message .= '<p>Your Payment has been Updated successfully for Distributor Code: <b>'.$distributor_code.' </b></p>';
        $bank_name = get_bank_name($payment_details['bank_id']);
        $message .= '<p>Your DD No.<b>'.$payment_details['dd_number'].' </b> of <b>'.$bank_name.'</b> for Rs.<b>'.$payment_details['amount'].'</b> credited to your account.</p>';
       
        $message .= '<p>Thanks and have a good day.</p><br>';
        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return $message;
    }

}

# Email Alert to C&Fs for Payment Receipt
function c_and_f_payment_receipt_mail($payment_details){
    $CI = & get_instance();
    $CI->db->select('email,name as user,user_id');
    $CI->db->from('user');
    $CI->db->where('plant_id',$payment_details['plant_id']);
    $CI->db->where('block_id',get_c_and_f_block_id1());
    $CI->db->where('designation_id',get_managerDesig_id());
    $CI->db->where('status',1);
    $query = $CI->db->get();
    //echo $CI->db->last_query();
    foreach ($query->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: Payment Receipt';
        $message = '<p>Dear <b>'.$row['user'].' </b>,</p>';
        //$message .= '<p>Your Payment has been Updated successfully for Distributor Code: <b>'.$distributor_code.' </b></p>';
        $bank_name = get_bank_name($payment_details['bank_id']);
        $message .= '<p>Your DD No.<b>'.$payment_details['dd_number'].' </b> of <b>'.$bank_name.'</b> for Rs.<b>'.$payment_details['amount'].'</b> credited to your account.</p>';
       
        $message .= '<p>Thanks and have a good day.</p><br>';
        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return $message;
    }

}

# Email Alert to distributor for DO
function distributor_DO_mail($distributor_id,$do_products,$do_number,$available_amount,$do_status,$lifing_point_name) {
    $CI = & get_instance();
    $CI->db->select('u.email,u.name as user,u.user_id');
    $CI->db->from('distributor d');
    $CI->db->join('user u','u.user_id = d.user_id','inner');
    $CI->db->where('d.distributor_id',$distributor_id);
    $CI->db->where('u.status',1);
    $query = $CI->db->get();
    //echo $CI->db->last_query();
    foreach ($query->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: DO Placed';
        $message = '<p>Hi <b>'.$row['user'].' </b>,</p>';
        if($do_status >=3)
        {
            $message .= '<p>Your Delivery Order has been Placed successfully with DO Number: <b>'.$do_number.' </b></p>';
        }
        else
        {
            $message .= '<p>Your Delivery Order has been Partially Placed  with DO Number: <b>'.$do_number.' </b></p>';
        }
        $message .= '<p>DO Date: <b>'.date("d-m-Y").' </b><span style="margin-left:5%">Lifting Point: <b>'.$lifing_point_name.' </b></span></p>';
        $message .= '<table style="border-collapse: collapse;">
                            <thead style="color:#ffffff; background-color:#6B9BCF;">
                                <tr>
                                    <th style="border: 1px solid black;">Product</th>
                                    <th style="border: 1px solid black;">Price</th>
                                    <th style="border: 1px solid black;">Ordered Quantity</th>
                                    <th style="border: 1px solid black;">Pending Quantity</th>
                                    <th style="border: 1px solid black;">No of Cartons</th>
                                    <th style="border: 1px solid black;">No of Packets</th>
                                    <th style="border: 1px solid black;">Qty in Kgs</th>
                                    <th style="border: 1px solid black;">Amount</th>
                                </tr>
                            </thead>
                        <tbody>';
        //$results = orderConclusionResultsByUser($row['user_id'],1);
        $grand_total = 0;
        foreach (@$do_products as $row1) {

            //$price = $row1['add_price']+$row1['unit_price'];
            //$total_price = ($row1['unit_price']+$row1['add_price'])*$row1['quantity'];
            //$product_name = get_prod_name($row1['product_id']);
            $pending_qty = $row1['ordered_qty']-$row1['lifting_qty'];
            $total_items = @$row1['lifting_qty']*@$row1['items_per_carton'];
            $qty_in_kgs = $total_items*$row1['oil_weight'];
            $amount = $amount = @$total_items*@$row1['price'];

            $message.= '<tr>
                            <td style="border: 1px solid black;">'.$row1['product_name'].'</td>
                            <td style="border: 1px solid black;">'.@$row1['price'].'</td>
                            <td style="border: 1px solid black;">'.@$row1['ordered_qty'].'</td>
                            <td style="border: 1px solid black;">'.@$pending_qty.'</td>
                             <td style="border: 1px solid black;">'.@$row1['lifting_qty'].'</td>
                            <td style="border: 1px solid black;">'.@$total_items.'</td>
                            <td style="border: 1px solid black;">'.@$qty_in_kgs.'</td>
                            <td style="border: 1px solid black;">'.@$amount.'</td>
                        </tr>';
            @$grand_total+= @$amount;
        }
        
        $message .= '<tr>
                            <td style="border: 1px solid black;" align="right" colspan="8"><b>Grand Total:'.@$grand_total.'</b></td>
                    </tr>';
        $total_available_amount = $available_amount-$grand_total;
        $message .= '<tr>
                            <td style="border: 1px solid black;" align="right" colspan="8"><b>Available Balance:'.$total_available_amount.'</b></td>
                    </tr>';
        $message .= '</tody>
                    </table><br>';

        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return  $to.'<br>'.$subject.'<br>'.$message;
    }

}

# Email Alert to Plants for DO
function plant_DO_mail($plant_id,$do_products,$do_number,$do_status,$lifing_point_name) {
    $block_id           =  get_block_id($plant_id);
    $designation_id     =  get_managerDesig_id();
    $CI = & get_instance();
    $CI->db->select('email,name as user,user_id');
    $CI->db->from('user');
    $CI->db->where('plant_id',$plant_id);
    $CI->db->where('block_id',$block_id);
    $CI->db->where('designation_id',$designation_id);
    $CI->db->where('status',1);
    $query = $CI->db->get();
    //echo $CI->db->last_query();
    foreach ($query->result_array() as $row) {
        
        // send email reminder
        $to = @$row['email'];
        $subject = 'Reminder: DO Placed';
        $message = '<p>Hi <b>'.$row['user'].' </b>,</p>';
        if($do_status >=3)
        {
            $message .= '<p>Your Delivery Order has been Placed successfully with DO Number: <b>'.$do_number.' </b></p>';
        }
        else
        {
            $message .= '<p>Your Delivery Order has been Partially Placed  with DO Number: <b>'.$do_number.' </b></p>';
        }
        $message .= '<p>DO Date: <b>'.date("d-m-Y").' </b><span style="margin-left:5%">Lifting Point: <b>'.$lifing_point_name.' </b></span></p>';
        $message .= '<table style="border-collapse: collapse;">
                            <thead style="color:#ffffff; background-color:#6B9BCF;">
                                <tr>
                                    <th style="border: 1px solid black;">Product</th>
                                    <th style="border: 1px solid black;">Price</th>
                                    <th style="border: 1px solid black;">Ordered Quantity</th>
                                    <th style="border: 1px solid black;">Pending Quantity</th>
                                    <th style="border: 1px solid black;">No of Cartons</th>
                                    <th style="border: 1px solid black;">No of Packets</th>
                                    <th style="border: 1px solid black;">Qty in Kgs</th>
                                    <th style="border: 1px solid black;">Amount</th>
                                </tr>
                            </thead>
                        <tbody>';
        //$results = orderConclusionResultsByUser($row['user_id'],1);
        $grand_total = 0;
        foreach (@$do_products as $row1) {

            //$price = $row1['add_price']+$row1['unit_price'];
            //$total_price = ($row1['unit_price']+$row1['add_price'])*$row1['quantity'];
            //$product_name = get_prod_name($row1['product_id']);
            $pending_qty = $row1['ordered_qty']-$row1['lifting_qty'];
            $total_items = @$row1['lifting_qty']*@$row1['items_per_carton'];
            $qty_in_kgs = $total_items*$row1['oil_weight'];
            $amount = $amount = @$total_items*@$row1['price'];

            $message.= '<tr>
                            <td style="border: 1px solid black;">'.$row1['product_name'].'</td>
                            <td style="border: 1px solid black;">'.@$row1['price'].'</td>
                            <td style="border: 1px solid black;">'.@$row1['ordered_qty'].'</td>
                            <td style="border: 1px solid black;">'.@$pending_qty.'</td>
                             <td style="border: 1px solid black;">'.@$row1['lifting_qty'].'</td>
                            <td style="border: 1px solid black;">'.@$total_items.'</td>
                            <td style="border: 1px solid black;">'.@$qty_in_kgs.'</td>
                            <td style="border: 1px solid black;">'.@$amount.'</td>
                        </tr>';
            @$grand_total+= @$amount;
        }
        
        $message .= '<tr>
                            <td style="border: 1px solid black;" align="right" colspan="8"><b>Grand Total:'.@$grand_total.'</b></td>
                    </tr>';
        $message .= '</tody>
                    </table><br>';

        $message .= '<p>Regards,</p>';
        $message .= '<p>AP OIL FED<br>Priyanka</p>';

        if(@PRINT_MAIL==1)
        echo $to.'<br>'.$subject.'<br>'.$message;
        // sending email
        //send_email($to,$subject,$message);
        return  $to.'<br>'.$subject.'<br>'.$message;
    }

}

function send1_email( $to,$subject = "---", $body,$cc=NULL,$from='noreply@skanray-access.com',$from_name='AP OIL FED', $bcc=NULL, $replyto=NULL,  $attachments=[]) {
    $ci = & get_instance();
    $ci->load->helper('email');
    $ci->load->library('email');
    
    /*$config['protocol'] = 'smtp';
    $config['smtp_host'] = '192.168.173.27';
    $config['smtp_port'] = '25';
    $config['smtp_timeout'] = '7';*/
   $config['protocol'] = 'smtp';
    $config['smtp_host'] = 'ssl://smtp.gmail.com';
    $config['smtp_port'] = '465';
    $config['smtp_timeout'] = '7';
    $config['smtp_user'] = 'priyanka.cse888@gmail.com'; // test gmail email id
    $config['smtp_pass'] = 'priyanka@1012'; // and password...
    $config['charset'] = 'utf-8';
    $config['newline'] = "\r\n";
    $config['mailtype'] = 'html'; // or html
    $config['validation'] = TRUE; // bool whether to validate email or not  
    $ci->email->initialize($config);
    $email_object = $ci->email;

    $email_object->from($from,$from_name);
    $email_object->to($to);
    $email_object->cc($cc);
    // $email_object->cc("rajender.jakka@gmail.com");
    $email_object->subject($subject);
    $email_object->message($body);
    $email_object->bcc($bcc);
    $email_object->reply_to($replyto);
    
    if(count($attachments)>0){
        foreach($attachments as $temp_name=>$path){
            $email_object->attach($path, 'attachment',$temp_name);
        }
    }
    $status = $email_object->send();
    
    return $status;

    //echo $ci->email->print_debugger();

   
    $email_object->clear(TRUE);
}


function get_tanker_register_details($tanker_in_num)
{
    $CI = & get_instance();
    $CI->db->select('l.*');
    $CI->db->from('location l');            
    $CI->db->where('tl.name','State');
    $CI->db->join('territory_level tl ','tl.level_id = l.level_id');
    $res = $CI->db->get();
    if($res->num_rows()>0)    
        return $res->result_array();   
    else
        return FALSE;    
}
function get_c_and_f_block_id1()
{
    return 4;
}
function get_stock_point_block_id()
{
    return 3;
}
function get_scheme_type_id()
{
    return 1;
}
function get_packed_products_unloading()
{
    return 6;
}
function get_unit_mrp_price($plant_id,$product_id,$price_type_id)
{
    $regural_price_type_id  = 1;
    if($price_type_id == $regural_price_type_id)
    {
        $type_id = $regural_price_type_id;
    }
    else
    {
        $type_id = $price_type_id;
    }

    $ci = & get_instance();
    $ci->db->select('value');
    $ci->db->from('product_price');
    $ci->db->where('product_id',$product_id);
    $ci->db->where('plant_id',$plant_id);
    $ci->db->where('price_type_id',$type_id);
   $ci->db->order_by('start_date DESC');
    $ci->db->limit('1');
    $res = $ci->db->get();
    if($res->num_rows()>0)
    {
        $row = $res->row_array();
        return $row['value'];
    }
    else
    {
        return 0;
    }
    
}

function get_regular_type_id()
{
    return 1;
}
function get_mrp_type_id()
{
    return 2;
}
function get_plant_ob_number()
{

    $financial_year = get_financial_year();
    $ci = & get_instance();
    $ci->db->select('max(o.order_number) as csno');
    $ci->db->from('order o');
    $ci->db->where('DATE(o.created_time)>=',$financial_year['start_date']);
    $ci->db->where('DATE(o.created_time)<=',$financial_year['end_date']);
    //$ci->db->where('o.lifting_point',$plant_id);
    $res = $ci->db->get();
    if($res->num_rows()>0)
    {
        $row = $res->row_array();
        return $row['csno']+1;
    }
    else
    {
        return 1;
    }
    
}
function get_plant($plant_id)
{
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->from('plant');
    $ci->db->where('plant_id',$plant_id);
    $ci->db->where('status',1);
    $res = $ci->db->get();
    $row = $res->row_array();
    return $row['name'];
}
function get_bank_name($bank_id)
{
    $ci = & get_instance();
    $ci->db->select('name');
    $ci->db->from('bank');
    $ci->db->where('bank_id',$bank_id);
    $ci->db->where('status',1);
    $res = $ci->db->get();
    $row = $res->row_array();
    return $row['name'];
}
function get_block_id($plant_id)
{
    $ci = & get_instance();
    $ci->db->select('block_id');
    $ci->db->from('plant_block');
    $ci->db->where('plant_id',$plant_id);
    $ci->db->where('status',1);
    $res = $ci->db->get();
    $row = $res->row_array();
    return $row['block_id'];
}

# Designation id(Manager) = 3
function get_managerDesig_id()
{
    return 3;
}
function c_and_f_id()
{
    return 4;
}
function plant_order_type_id()
{
    return 2;
}

function get_ob_product_do_qtuantity($order_id,$product_id)
{
    if($order_id!=''&&$product_id!='')
    {
        $ci = & get_instance();
        $ci->db->select('sum(dop.quantity) as tot_do_qty');
        $ci->db->from('do_order do');
        $ci->db->join('do_order_product dop','dop.do_ob_id = do.do_ob_id','left');
        $ci->db->where('do.order_id',$order_id);
        $ci->db->where('dop.product_id',$product_id);
        $res = $ci->db->get();
        if($res->num_rows()>0)
        {
            $row = $res->row_array();
            return ($row['tot_do_qty']>0)?$row['tot_do_qty']:0;
        }
        
    }
    return 0;
}

function get_plant_do_number1($plant_id)
{

    $financial_year = get_financial_year();
    $ci = & get_instance();
    $ci->db->select('max(d.do_number) as csno');
    $ci->db->from('do d');
    $ci->db->join('do_order do','d.do_id = do.do_id','left');
    $ci->db->where('DATE(d.created_time)>=',$financial_year['start_date']);
    $ci->db->where('DATE(d.created_time)<=',$financial_year['end_date']);
    $ci->db->where('o.lifting_point',$plant_id);
    $res = $ci->db->get();
    if($res->num_rows()>0)
    {
        $row = $res->row_array();
        return $row['csno']+1;
    }
    else
    {
        return 1;
    }
    
}

function get_product_list($loose_oil_id)
{
    if($loose_oil_id>0)
    {
        $ci = & get_instance();
        $ci->db->select('product_id,name as product_name');
        $ci->db->from('product');
        $ci->db->where('status',1);
        $ci->db->where('loose_oil_id',$loose_oil_id);
        $res = $ci->db->get();
        $row = $res->result_array();
        //print_r($row);exit;
        if($row != '')
        {
            return $row;
        }

    }
    return array();

}

function get_looseOilName($loose_oil_id)
{
    if($loose_oil_id)
    {
        $CI = & get_instance();
        $CI->db->select('name as loose_oil_name');
        $CI->db->from('loose_oil');   
        $CI->db->where('loose_oil_id', $loose_oil_id);    
        $res=$CI->db->get();
        $result= $res->row_array();
        return $result['loose_oil_name'];
    }
}


function get_prod_name($product_id)
{
   if($product_id != '')
    {
        $CI = & get_instance();
        $CI->db->select('name');
        $CI->db->from('product');   
        $CI->db->where('product_id', $product_id);    
        $res=$CI->db->get();
        $result= $res->row_array();
        return $result['name'];
    } 
}

function get_free_gift_name($product_id)
{
   if($product_id != '')
    {
        $CI = & get_instance();
        $CI->db->select('name');
        $CI->db->from('free_gift');   
        $CI->db->where('free_gift_id', $product_id);    
        $res=$CI->db->get();
        $result= $res->row_array();
        return $result['name'];
    } 
}