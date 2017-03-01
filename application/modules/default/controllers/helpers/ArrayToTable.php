<?php

require_once 'Zend/Loader/PluginLoader.php';
require_once 'Zend/Controller/Action/Helper/Abstract.php';

/**
 * ArrayToTable Action Helper 
 * 
 * @uses actionHelper Zend_Controller_Action_Helper
 */
class Zend_Controller_Action_Helper_ArrayToTable extends Zend_Controller_Action_Helper_Abstract {
	/**
	 * @var Zend_Loader_PluginLoader
	 */
	public $pluginLoader;
	
	/**
	 * Constructor: initialize plugin loader
	 * 
	 * @return void
	 */
	public function __construct() {
		// TODO Auto-generated Constructor
		$this->pluginLoader = new Zend_Loader_PluginLoader ();
	}
	
	/**
	 * Strategy pattern: call helper as broker method
	 */
	public function direct($rijen,$toonHeader=false,$kolommen=1,$sommeer=false) {
		return $this->GetTable($rijen,$toonHeader ,$kolommen	,$sommeer);
	}
	
	public static function GetTable($rijen,$toonHeader=false,$kolommen=1,$sommeer=false) {
	   /*
	   || Function to build html-table from array.
	   || The rijen parameter is an array with database rows.
	   || If toonHeader is true the names of the first array are used.
	   || The kolommen parameter defines over how many coloumns the table is slpitted.
	   || If $sommeer parameter is true the number of rows is shown.
	   */
	
	   /*We beginnen met het splitsen van rijen-array afhankelijk van het aantal kolommen*/
	   $aantalRijen         = count($rijen);
	   $aantalRijenPerKolom = floor($aantalRijen / $kolommen)+1;
	   $rijenInKolom        = array_chunk($rijen, $aantalRijenPerKolom);
	
	   $tabel= '<table border="0" cellspacing="0" cellpadding="10">'."\n".'<tr>';
	   foreach ($rijenInKolom as $rijInKolom) {
	
	      $tabel.= '<td valign="top">'."\n".'<table border="0" cellspacing="1" cellpadding="3">'."\n";
	      if ($toonHeader){
	         $rij = $rijInKolom[0];
	         $tabel.= '  <tr>'."\n";
	         foreach ($rij as $veld => $waarde) {
	            $tabel.= '  <td>'.$veld.'</td>'."\n";
	         }
	         $tabel.= '  </tr>'."\n";
	         
	      }
	
	      $row_color = 0;
	      foreach ($rijInKolom as $rij) {
	         if( $row_color == 0 )  {
	            $backgrcolor = "resultrowcolor0";
	            $row_color = 1;
	         } else {
	            $backgrcolor = "resultrowcolor1";
	            $row_color = 0;
	         }
	         $tabel.= '  <tr class="'.$backgrcolor.'">'."\n";
	         foreach ($rij as $veld => $waarde) {
	            $posAantal = strpos(strtolower($veld),'aantal');
	            if ($posAantal!==false) {
	               $align='right';
	            }else{
	               $align='left';
	            }
	            $tabel.= '     <td align="'.$align.'">'.$waarde.'</td>'."\n";
	         }
	         $tabel.= '  </tr>'."\n";
	      }
	      $tabel .= '</table>'."\n".'</td>'."\n";
	   }
	   $tabel .= '</tr>'."\n".'</table>'."\n";
	   if ($sommeer) {
	      $tabel .= '<table border="0" cellspacing="0" cellpadding="0"><tr><td>'
	              .'Gevonden records: '.$aantalRijen
	              .'</td></tr></table>'."\n";
	   }
	   return $tabel;
	}
	
}

