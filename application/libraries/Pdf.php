<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once dirname(__FILE__) . '/tcpdf/tcpdf.php';
class Pdf extends TCPDF
{
    function __construct()
    {
        parent::__construct();
    }
	public $ref,$edate;
	
	public function setRef($ref){
        $this->ref = $ref;
    }
	public function setDate($edate){
        $this->edate = $edate;
    }
    public function setRoleCheck($roleCheck){
    	$this->roleCheck = $roleCheck;
    }
    //Page header
	public function Header() {
		    $file = assets_url() . "layouts/layout3/img/logo.png";
		    $file1 = assets_url() . "layouts/layout3/img/watermark.png";


			

            $this->Image($file, 130, 19, '60', '15', 'PNG', '', 'C', false, 300, '', false, false, 0, false, false, false);
            $this->Image($file1, 55, 100, '100', '90', 'PNG', '', 'M', false, 300, '', false, false, 0, false, false, false);
			$head_content = '<br><br>
			 					<div style="font-size:8px;">
			 					<table>
			 						<tr width="500">
			 							<td>';

			$head_content .='</td>
			 						</tr>
			 						<tr>
			 							<td></td>
			 						</tr>
			 					</table>	
								</div>';          
            $this->writeHTML( $head_content, 130, 19, 60, true, 'L', true); 
	  }

	// Page footer
	public function Footer() 
	{
		   $file = assets_url() . "layouts/layout3/img/menu-toggler.png";
		   $this->writeHtmlCell(102,200,25,281,'<p style="font-size:8px;">Page '.$this->getAliasNumPage().' of  '.' '.$this->getAliasNbPages().'</p>','',1,0,false,'R');
		   //$footer_text = '<img src="'.$file.'" >';               
          // $this->writeHTMLCell(600, 300, '', '', $footer_text, 0, 0, 0, true, 'C', true); 
		   $this->Image($file, -1, 286, '212', '12', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
		   // $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
	  }
}