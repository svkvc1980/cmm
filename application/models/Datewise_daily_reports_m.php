<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
 * created by maruthi on 21th Feb 2017 9:00AM
*/

class Datewise_daily_reports_m extends CI_Model {
	
	public function get_loose_stock($plant_id,$loose_oil_id,$from_date,$to_date)
	{	
		// check closing balance is taken for on day
			// assigning searched date to searched report date
			//$loose_oil_id =  1;
			$plant_id = (get_ses_block_id() ==1)?$plant_id:get_plant_id();
			$searched_from_date = $from_date;
			$this->db->select('*');
			$this->db->from('oil_stock_balance');
			$this->db->where('on_date',$from_date);
			$this->db->where('loose_oil_id',$loose_oil_id);
			$this->db->where('plant_id',$plant_id);
			$res3 = $this->db->get();	
			/*echo '<pre>';
			print_r($res3->result_array());exit;		*/
			if($res3->num_rows()>0)
			{
				$result3 = $res3->row_array();
				$searched_from_date = $result3['on_date'];
				$opening_balance = $result3['opening_balance'];
			}
			else
			{
				// get latest date opening balance taken
					$qry3 ='SELECT * FROM oil_stock_balance
							 WHERE loose_oil_id="'.$loose_oil_id.'"  AND DATE(on_date) < "'.$from_date.'" 
							 AND plant_id ="'.$plant_id.'" ORDER BY DATE(on_date) DESC ';
					$res3 =$this->db->query($qry3);
					$result3 = $res3->row_array();
					$from_date = $result3['on_date'];
					$first_opening_balance = $result3['opening_balance'];
					/*echo '<pre>';
					print_r($res3->result_array());exit;*/
					//echo $first_opening_balance.'<br>';//exit;

				// get receipts
					$qry ='SELECT sum(tol.gross - tol.tier)/1000 as mrr_data
				             FROM po_oil as pl
				            LEFT JOIN po_oil_tanker as plt ON pl.po_oil_id = plt.po_oil_id
				            LEFT JOIN tanker_register as tr ON tr.tanker_id = plt.tanker_id
				            LEFT JOIN tanker_oil as tol ON tol.tanker_id = tr.tanker_id 
				            LEFT JOIN mrr_oil as mo ON mo.tanker_oil_id = tol.tanker_oil_id
				            WHERE  pl.loose_oil_id ="'.$loose_oil_id.'" AND pl.plant_id ="'.$plant_id.'"
				            AND mo.mrr_date >= "'.$from_date.'" AND mo.mrr_date < "'.$searched_from_date.'"  ';
				    $res2 = $this->db->query($qry);
				    //echo $this->db->last_query();exit;
				    if($res2->num_rows()>0)
				    {
				    	$mrr_res = $res2->row_array();
				    	$mrr_data = ($mrr_res['mrr_data']!='')?$mrr_res['mrr_data']:0;
				    }
				    else
				    {
				    	$mrr_data = 0;
				    }
				    //echo $mrr_data.'<br>';
				// get production 
				    $qry2 ='SELECT sum(pp.quantity*p.items_per_carton*p.oil_weight)/1000 as qty_in_kg
				            FROM plant_production as ptp
				            INNER JOIN production_product as pp ON ptp.plant_production_id = pp.plant_production_id
				            INNER JOIN product as p ON p.product_id =pp.product_id 
				            WHERE ptp.plant_id ="'.$plant_id.'" AND DATE(ptp.production_date) >= "'.$from_date.'"  
				            AND DATE(ptp.production_date) < "'.$searched_from_date.'"  
				            AND p.loose_oil_id="'.$loose_oil_id.'" ';
				    $res2 =$this->db->query($qry2);
				    if($res2->num_rows()>0)
				    {
				        $result2 = $res2->row_array();
				        $range_production = ($result2['qty_in_kg']);
				    }
				    else
				    {
				        $range_production = 0.000;
				    }

				    $leakage_type1 = $this->get_type1_leakage_range_by_looseOil($plant_id,$loose_oil_id,$from_date,$searched_from_date);
				    $leakage_type1 = qty_format($leakage_type1);

				     $leakage_type2 = $this->get_type2_leakage_range_by_looseOil($plant_id,$loose_oil_id,$from_date,$searched_from_date);
				     $leakage_type2 = qty_format($leakage_type2);

				     $processing_loss = $this->get_processing_loss_range_by_looseOil($plant_id,$loose_oil_id,$from_date,$searched_from_date);
				     $processing_loss = qty_format($processing_loss);
				    //echo $range_production.'<br>';exit;
				
						$opening_balance = $first_opening_balance + $mrr_data - $range_production -$leakage_type1 + $leakage_type2 - $processing_loss;
						
			}
			
			//echo $closing_balance;exit;
		
		// get receipts bw dates
			//echo $result1['opening_balance'].'<br>';
			$receipts = dw_receipts($plant_id,$loose_oil_id,$searched_from_date,$to_date);
			//echo $receipts.'<br>';//exit;
		// get production On Searched Date For Loose Oil In MT
		// Note you can directly take from oil stock balance
			$production = dw_production($plant_id,$loose_oil_id,$searched_from_date,$to_date);

			$closing_balance = ($opening_balance + $receipts - $production );
		$loose_data = array(
				'opening'   	 	=> $opening_balance, 
				// Calculate Receipts don't take from oil stock balance
 				'stock_transfer'     =>0,
				'receipts'  	 	=> $receipts,
				'sales' 	 		=> $production, // production on previous day
				'closing_balance' 	=> $closing_balance
				
			);
		//echo '<pre>'; print_r($loose_data);exit;
		//$res = $this->db->get();
		return array($loose_data,$searched_from_date);
	}	
	public function get_packed_stock($plant_id,$loose_oil_id,$from_date,$to_date)
	{
	    // Whole production till today in MT for a Loose Oil
		    $packed_data = get_whole_packed_oil($plant_id,$loose_oil_id);
		    	//echo $packed_data.'<br>';//exit;
	    // Production From searched date to today
		    $production = get_searched_date_to_today_production($plant_id,$from_date,$loose_oil_id);
			//echo $production.'<br>';//exit;

		// Invoice From searched date to today
			$s_invoice_production = get_total_invoice_fromdate_to_today($plant_id,$from_date,$loose_oil_id);
			//echo $s_invoice_production.'<br>';//exit;
	    // Leakeage From Searched Date to Today
			$leakage = get_searched_date_to_today_leakage($plant_id,$from_date,$loose_oil_id);
			//echo $leakage;exit;
			//echo $packed_data.'--'.$production.'--'.$s_invoice_production.'--'.$leakage.'<br>';
		$opening_balance = $packed_data - $production + $s_invoice_production + $leakage;
		//echo $opening_balance;//exit;
	    //  Invoice Data For FRom to dates 
			$dist_invoice_production = dw_invoice($plant_id,$loose_oil_id,$from_date,$to_date); 
		//echo $invoice_production;exit;
			$plant_invoice_production = dw_invoice($plant_id,$loose_oil_id,$from_date,$to_date,2); // 2 for plant dispatches 


	    $packed_data_arr = array(
				'opening'    		 =>$opening_balance,				
				'sales' 			 =>$dist_invoice_production,	// distributor sales
				'stock_transfer'	 =>$plant_invoice_production
			);
		//echo '<pre>'; print_r($packed_data);exit;
		//$res = $this->db->get();
		return $packed_data_arr; 
		
	}
	
	//  OB data
		public function get_pending_obs_qty_in_mts($loose_oil_id,$report_date)
		{			
			$this->db->select('sum(op.pending_qty*op.items_per_carton*p.oil_weight)/1000 as pending_qty');
			$this->db->from('order o');
			$this->db->join('order_product op','o.order_id = op.order_id');
			$this->db->join('product p','p.product_id = op.product_id');			
			$this->db->where('o.lifting_point',get_plant_id());		
			$this->db->where('o.status<=',2);
			$this->db->where('o.order_date<=',$report_date);
			$this->db->where('p.loose_oil_id',$loose_oil_id);
			$res = $this->db->get();
			/*echo $this->db->last_query();//exit;
			echo '<pre>'; print_r($res->result_array());exit;*/
			if($res->num_rows()>0)
			{
				$result = $res->row_array();
				$ob_qty = ($result['pending_qty']!='')?$result['pending_qty']:'0.000';
				return $ob_qty;
			}
			else
			{
				return 0.000;
			}
		}
	// Do  data
		public function get_pending_dos_qty_in_mts($loose_oil_id,$report_date)
		{			
			$this->db->select('sum(dop.pending_qty*dop.items_per_carton*p.oil_weight)/1000 as pending_qty');
			$this->db->from('do d');
			$this->db->join('do_order doo','doo.do_id = d.do_id');
			$this->db->join('do_order_product dop','doo.do_ob_id = dop.do_ob_id');
			$this->db->join('product p','p.product_id = dop.product_id');			
			$this->db->where('d.lifting_point',get_plant_id());		
			$this->db->where('d.status<=',2);
			$this->db->where('d.do_date<=',$report_date);
			$this->db->where('p.loose_oil_id',$loose_oil_id);
			$res = $this->db->get();
			/*echo $this->db->last_query();//exit;
			echo '<pre>'; print_r($res->result_array());exit;*/
			if($res->num_rows()>0)
			{
				$result = $res->row_array();
				$ob_qty = ($result['pending_qty']!='')?$result['pending_qty']:'0.000';
				return $ob_qty;
			}
			else
			{
				return 0.000;
			}
		}
	// Get opening Stock For Products Report
	public function get_opening_stock($loose_oil_id,$product_id,$from_date,$to_date)
	{
		
		// Whole production till today 		    
		    $packed_data = get_total_stock_till_today($loose_oil_id,$product_id);
		    /*echo $this->db->last_query();//exit;
		    echo $packed_data.'<br>';exit;*/
		    //exit;*/
	    // Production From searched date to today
		    
		    $production = get_stock_for_searched_date_to_today($loose_oil_id,$from_date,$product_id);

		    $leakage = get_leakage_for_searched_date_to_today($loose_oil_id,$from_date,$product_id);
				//echo $production.'<br>';//exit;
			// Opening balnce
		

		// Invoice From searched date to today
			
			$s_invoice_production = get_invoice_stock_for_searched_date_to_today($loose_oil_id,$from_date,$product_id);
			    //echo $s_invoice_production.'<br>jjj';
		$opening_balance = $packed_data - $production + $s_invoice_production + $leakage;//exit;
		//echo $opening_balance;exit;
		// get production on report_date		
		$from_to_date_production = dw_stock_production($loose_oil_id,$product_id,$from_date,$to_date);

		$from_to_date_leakage = dw_stock_leakage($loose_oil_id,$product_id,$from_date,$to_date);
		 //echo $on_date_production.'--';//exit;
		// Get Invoices on Report taken date
		
	    $from_to_date_invoice = dw_invoice_stock($loose_oil_id,$product_id,$from_date,$to_date);
	    //echo $on_date_invoice.'<br>kkk';//exit;
	    //echo $opening_balance.'pp'.$on_date_production.'pp'.$on_date_invoice;exit;

	    $final_data =array(	    	
	    	'opening' 		=> $opening_balance,
	    	'production' 	=> $from_to_date_production,
	    	'invoice' 		=> $from_to_date_invoice,
	    	'leakage'		=>$from_to_date_leakage,
	    	'closing_balance' => ($opening_balance + $from_to_date_production - $from_to_date_invoice - $from_to_date_leakage) 
	    	);
	    // echo '<pre>'; print_r($final_data);exit;
	    return $final_data;
	}

	public function get_pm_opening_stock($pm_category_id,$pm_id,$from_date,$to_date)
	{
		// Get total pm_stock Balance
			//$pm_category_id =1;
			//$pm_id =45;
			//$report_date1 = array('report_date' =>$report_date);
			//print_r($report_date1);exit;
			$this->db->select('*');
			$this->db->from('plant_pm');
			$this->db->where('pm_id',$pm_id);
			//$this->db->where('closing_balance IS NULL',NULL);			
			$this->db->where('plant_id',get_plant_id());
			$res = $this->db->get();
			
			if($res->num_rows()>0)
			{
				$result1 = $res->row_array();
				$t_opening_balance = ($result1['quantity']!='')?($result1['quantity']):0.000;				
			}
			else
			{
				$t_opening_balance = 0.000;
			}
			//echo $t_opening_balance.'<br>';//exit;
			/*echo $this->db->last_query();
			echo '<pre>'; print_r($res->row_array()); exit;*/
		
			
		// For Film Type Packing Material Category
			if($pm_category_id == 1 )
			{				
				//  Get Packing Material Consumption In Production Between Searched Date and Current Date 
				    $prd_range_film_qty = get_production_film_consumption($from_date,$pm_id);
					//echo $prd_range_film_qty.'<br>';
				// Get Receipts For Film Betwwen current and search date					
					$mrr_rage_film_qty = get_film_receipts($from_date,$pm_id);
					//echo $mrr_rage_film_qty.'<br>';//exit;

				// From to Date Receipts MRRs					
					$on_date_mrr_data = dw_film_receipts($pm_id,$from_date,$to_date);
					//echo $on_date_mrr_data.'<br>';//exit;
				// On Date Production				
					$on_date_prd_film_qty = dw_production_film_consumption($pm_id,$from_date,$to_date);
					//echo $on_date_prd_film_qty.'<br>';//exit;

				// on date to today
					$range_leakage_qty = on_date_leakage($pm_category_id,$pm_id,$from_date);

				// from to Date leakage
					$dw_leakage_film_qty = dw_leakage_film_and_pm($pm_category_id,$pm_id,$from_date,$to_date);

			}
			else
			{
				//  Get Packing Material Consumption In Production Between Searched Date and Current Date
					$prd_range_film_qty = get_production_pm_consumption($from_date,$pm_id);
						//echo $prd_range_film_qty.'<br>';//exit;
				// Get Receipts For Film Betwwen current and search date					
					$mrr_rage_film_qty  = get_pm_receipts($from_date,$pm_id);
						//echo $mrr_rage_film_qty.'<br>';//exit;
				// on Date MRRs				
					$on_date_mrr_data   = dw_pm_receipts($pm_id,$from_date,$to_date);
					//echo $on_date_mrr_data.'<br>';//exit;
				// On Date Production					
					$on_date_prd_film_qty = dw_production_pm_consumption($pm_id,$from_date,$to_date);
					//echo $on_date_prd_film_qty.'<br>';//exit;
				// from to date leakage 
					$dw_leakage_film_qty = dw_leakage_film_and_pm($pm_category_id,$pm_id,$from_date,$to_date);
				// On date to today leakage qty
				    $range_leakage_qty = on_date_leakage($pm_category_id,$pm_id,$from_date);
			}

			// Get Invoice Pm Between Current Date and Search Date
				$invoice_range_pm = get_invoice_pm($from_date,$pm_id);
				//echo $this->db->last_query();exit;
				//echo $invoice_range_pm;//exit;
			//echo $t_opening_balance.'--'.$prd_range_film_qty.'--'.$mrr_rage_film_qty.'<br>';
				$final_opening_balance = $t_opening_balance + $prd_range_film_qty - $mrr_rage_film_qty + $invoice_range_pm + $range_leakage_qty;
			//echo $final_opening_balance;exit;
		// Free packing Materials Given in Invoice
				
				//echo $inv_pm_data;exit;
				$on_date_invoice_pm = dw_invoice_pm($pm_id,$from_date,$to_date); 
				//echo $on_date_invoice_pm;exit;
				//echo $this->db->last_query();exit;
				/*echo $this->db->last_query();
				echo '<pre>';print_r($inv_pm_data);*///exit;
				//echo $final_opening_balance.'--'.$on_date_mrr_data.'--'.$on_date_prd_film_qty.'--'.$inv_pm_data;exit;
		$closing_balance = $final_opening_balance + $on_date_mrr_data - $on_date_prd_film_qty - $on_date_invoice_pm -$dw_leakage_film_qty;
		//echo $closing_balance;exit;
		$final_arr =array(
					//'pm_id'             =>$pm_id,
					'opening_balance' 	 => $final_opening_balance,
					'receipts'        	 => $on_date_mrr_data,
					'on_date_production' => $on_date_prd_film_qty,
					'on_date_invoice'    => $on_date_invoice_pm,
					'on_date_leakage'    => $dw_leakage_film_qty,
					'closing_balance'    => $closing_balance
						);
		return $final_arr;

		//echo '<pre>'; print_r($final_arr);exit;
	}

	// mahesh 27 May 2017 07:24 PM
	public function get_type1_leakage($plant_id,$from_date,$to_date)
	{
		if($from_date!=''&&$plant_id!=''&&$to_date!='')
		{
			$this->db->select('SUM((o.leaked_pouches*p.oil_weight)-o.oil_recovered)/1000 as leaked_oil, p.loose_oil_id');
			$this->db->from('ops_leakage o');
			$this->db->join('product p','o.product_id = p.product_id');
			$this->db->where('o.on_date>=',$from_date);
			$this->db->where('o.on_date<=',$to_date);
			$this->db->where('o.plant_id',$plant_id);
			$this->db->where('o.recover_type',1);
			$this->db->group_by('p.loose_oil_id');
			$res = $this->db->get();
			$data = array();
			//echo $this->db->last_query(); exit;
			if($res->num_rows()>0)
			{
				$rows = $res->result_array();
				foreach ($rows as $row) {
					$data[$row['loose_oil_id']] = $row['leaked_oil']; 
				}
				return $data;
			}
		}
	}

	// mahesh 27 May 2017 07:24 PM
	public function get_type2_leakage($plant_id,$from_date,$to_date)
	{
		if($from_date!=''&&$plant_id!=''&&$to_date!='')
		{
			$this->db->select('SUM(((o.leakage_quantity-o.recovered_quantity)*p.items_per_carton*p.oil_weight) + o.oil_recovered)/1000 as tot_rec_oil, SUM((o.leakage_quantity-o.recovered_quantity)*p.items_per_carton*p.oil_weight)/1000 as lost_packed_oil, p.loose_oil_id');
			$this->db->from('ops_leakage o');
			$this->db->join('product p','o.product_id = p.product_id');
			$this->db->where('o.on_date>=',$from_date);
			$this->db->where('o.on_date<=',$to_date);
			$this->db->where('o.plant_id',$plant_id);
			$this->db->where('o.recover_type',2);
			$this->db->group_by('p.loose_oil_id');
			$res = $this->db->get();
			$data = array();
			//echo $this->db->last_query(); exit;
			if($res->num_rows()>0)
			{
				$rows = $res->result_array();
				foreach ($rows as $row) {
					$data[$row['loose_oil_id']]['tot_rec_oil'] = $row['tot_rec_oil']; 
					$data[$row['loose_oil_id']]['lost_packed_oil'] = $row['lost_packed_oil']; 
				}
				return $data;
			}
		}
	}

	// mahesh 28 May 2017 04:50 PM
	public function get_type1_leakage_range_by_looseOil($plant_id,$loose_oil_id,$report_date,$searched_report_date)
	{
		if($loose_oil_id!=''&&$plant_id!=''&&$report_date!=''&&$searched_report_date!='')
		{
			$this->db->select('SUM((o.leaked_pouches*p.oil_weight)-o.oil_recovered)/1000 as leaked_oil, p.loose_oil_id');
			$this->db->from('ops_leakage o');
			$this->db->join('product p','o.product_id = p.product_id');
			$this->db->where('o.on_date>=',$report_date);
			$this->db->where('o.on_date<',$searched_report_date);
			$this->db->where('o.plant_id',$plant_id);
			$this->db->where('p.loose_oil_id',$loose_oil_id);
			$this->db->where('o.recover_type',1);
			$this->db->group_by('p.loose_oil_id');
			$res = $this->db->get();
			$data = array();
			//echo $this->db->last_query(); exit;
			if($res->num_rows()>0)
			{
				$row = $res->row_array();
				return ($row['leaked_oil']>0)?$row['leaked_oil']:0;
			}
		}
		return 0;
	}

	// mahesh 28 May 2017 04:50 PM
	public function get_type2_leakage_range_by_looseOil($plant_id,$loose_oil_id,$report_date,$searched_report_date)
	{
		if($loose_oil_id!=''&&$plant_id!=''&&$report_date!=''&&$searched_report_date!='')
		{
			$this->db->select('SUM(((o.leakage_quantity-o.recovered_quantity)*p.items_per_carton*p.oil_weight) + o.oil_recovered)/1000 as tot_rec_oil');
			$this->db->from('ops_leakage o');
			$this->db->join('product p','o.product_id = p.product_id');
			$this->db->where('o.on_date>=',$report_date);
			$this->db->where('o.on_date<',$searched_report_date);
			$this->db->where('o.plant_id',$plant_id);
			$this->db->where('p.loose_oil_id',$loose_oil_id);
			$this->db->where('o.recover_type',2);
			$this->db->group_by('p.loose_oil_id');
			$res = $this->db->get();
			$data = array();
			//echo $this->db->last_query(); exit;
			if($res->num_rows()>0)
			{
				$row = $res->row_array();
				return ($row['tot_rec_oil']>0)?$row['tot_rec_oil']:0;
			}
		}
		return 0;
	}

	// mahesh 30 May 2017 11:13 PM
	public function get_processing_loss($plant_id,$from_date,$to_date)
	{
		if($from_date!=''&&$plant_id!=''&&$to_date!='')
		{
			$this->db->select('SUM(o.quantity)/1000 as processing_loss, o.loose_oil_id');
			$this->db->from('ops_processing_loss o');
			$this->db->join('loose_oil l','l.loose_oil_id = o.loose_oil_id');
			$this->db->where('o.on_date>=',$from_date);
			$this->db->where('o.on_date<=',$to_date);
			$this->db->where('o.plant_id',$plant_id);
			$this->db->group_by('o.loose_oil_id');
			$res = $this->db->get();
			$data = array();
			//echo $this->db->last_query(); exit;
			if($res->num_rows()>0)
			{
				$rows = $res->result_array();
				foreach ($rows as $row) {
					$data[$row['loose_oil_id']] = $row['processing_loss']; 
				}
				return $data;
			}
		}
	}

	// mahesh 30 May 2017 11:27 PM
	public function get_processing_loss_range_by_looseOil($plant_id,$loose_oil_id,$report_date,$searched_report_date)
	{
		if($loose_oil_id!=''&&$plant_id!=''&&$report_date!=''&&$searched_report_date!='')
		{
			$this->db->select('SUM(o.quantity)/1000 as processing_loss, o.loose_oil_id');
			$this->db->from('ops_processing_loss o');
			$this->db->join('loose_oil l','l.loose_oil_id = o.loose_oil_id');
			$this->db->where('o.on_date>=',$report_date);
			$this->db->where('o.on_date<',$searched_report_date);
			$this->db->where('o.plant_id',$plant_id);
			$this->db->where('l.loose_oil_id',$loose_oil_id);
			$this->db->group_by('o.loose_oil_id');
			$res = $this->db->get();
			$data = array();
			//echo $this->db->last_query(); exit;
			if($res->num_rows()>0)
			{
				$row = $res->row_array();
				return ($row['processing_loss']>0)?$row['processing_loss']:0;
			}
		}
		return 0;
	}

}

