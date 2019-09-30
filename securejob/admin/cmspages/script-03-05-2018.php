<?php
require_once("../../config.php");

	$aColumns = array( 'title', 'slug', 'is_active');
	
	$sIndexColumn = "page_id";
	
	$sTable = "tblcmspages";
	
	/* Database connection information */
	$gaSql['user']       = $dbUser;
	$gaSql['password']   = $dbPass;
	$gaSql['db']         = $dbName;
	$gaSql['server']     = $dbHost;

	$gaSql['link'] =  @mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) or
		die( 'Could not open connection to server' );
	
	@mysql_select_db( $gaSql['db'], $gaSql['link'] ) or 
		die( 'Could not select database '. $gaSql['db'] );

	/* 
	 * Paging
	 */
	$sLimit = "";
	if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' )
	{
		$sLimit = "LIMIT ".mysql_real_escape_string( $_GET['iDisplayStart'] ).", ".
			mysql_real_escape_string( $_GET['iDisplayLength'] );
	}
	
	/*
	 * Ordering
	 */
	if ( isset( $_GET['iSortCol_0'] ) )
	{
		$sOrder = "ORDER BY  ";
		for ( $i=0 ; $i < intval( $_GET['iSortingCols'] ) ; $i++ )
		{
			if ( $_GET[ 'bSortable_'.intval($_GET['iSortCol_'.$i]) ] == "true" )
			{
				$sOrder .= $aColumns[ intval( $_GET['iSortCol_'.$i] ) ]."
				 	".mysql_real_escape_string( $_GET['sSortDir_'.$i] ) .", ";
			}
		}
		
		$sOrder = substr_replace( $sOrder, "", -2 );
		if ( $sOrder == "ORDER BY" )
		{
			$sOrder = "";
		}
	}
	
	/* 
	 * Filtering
	 * NOTE this does not match the built-in DataTables filtering which does it
	 * word by word on any field. It's possible to do here, but concerned about efficiency
	 * on very large tables, and MySQL's regex functionality is very limited
	 */
	$sWhere = "";
	if ( $_GET['sSearch'] != "" )
	{

		$sWhere = "and ( tblcmspages.title LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' or tblcmspages.is_active LIKE '%".mysql_real_escape_string( $_GET['sSearch'] )."%' )";
	}
	
		
	/*
	 * SQL queries
	 * Get data to display
	 */
	 
	if($sOrder=='')
	{
		$sOrder=" order by tblcmspages.title asc";
	}		
	 
	 
	$sQuery = "SELECT tblcmspages.* FROM tblcmspages where 1 $sWhere GROUP BY tblcmspages.page_id $sOrder $sLimit";
	
	$rResult = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	
	/* Data set length after filtering */
	$sQuery = "SELECT FOUND_ROWS()";
	
	$rResultFilterTotal = mysql_query( $sQuery, $gaSql['link'] ) or die(mysql_error());
	$aResultFilterTotal = mysql_fetch_array($rResultFilterTotal);
	$iFilteredTotal = $aResultFilterTotal[0];
	
	/* Total data set length */
	$sQuery1 = "SELECT tblcmspages.page_id FROM tblcmspages where 1 $sWhere GROUP BY tblcmspages.page_id ORDER BY tblcmspages.title";
	$rResultTotal = mysql_query( $sQuery1, $gaSql['link'] ) or die(mysql_error());
	$aResultTotal = mysql_num_rows($rResultTotal);
	$iTotal = $aResultTotal;
	
	
	/*
	 * Output
	 */
	$output = array(
		"sEcho" => intval($_GET['sEcho']),
		"iTotalRecords" => $iTotal,
		"iTotalDisplayRecords" => $iTotal,
		"aaData" => array()
	);
	
	while ( $aRow = mysql_fetch_array( $rResult ) )
	{
		$row = array();		
		$id=$aRow['page_id'];
		$status=$aRow['is_active'];
			
			/* $row[] = "<input type='checkbox' name='del[]' value='$id' />"; */
			$row[] = $aRow['title'];		
			//$row[] = $aRow['slug'];		
			$status = $aRow['is_active'];	
			
			 $action='viewAction("'.$status.'",'.$id.');';
			
			$data ="<span id='txtAction-$id' style='cursor: pointer;'><a onclick='$action' style='text-transform: capitalize;'>$status</a></span>";		
			$row[] = $data; 
			
			 $confirm="return confirm('Are you want to delete this page?')"; 
			$row[] = '<a href='.ADMIN_URL.'main.php?pg=addcms&id='.$id.' class="btn btn-primary">Modify</a>&nbsp;<a href='.ADMIN_URL.'main.php?pg=viewcms&delId='.$id.' onclick="'.$confirm.'" class="btn btn-warning" title="Are you want to delete this page?"> Delete </a>';
								 

		$output['aaData'][] = $row;
	}
	
	echo json_encode( $output );
?>