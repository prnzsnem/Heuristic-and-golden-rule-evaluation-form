<?php

// Global variable for table object
$golden = NULL;

//
// Table class for golden
//
class crgolden extends crTableBase {
	var $ID;
	var $qa;
	var $ra;
	var $ma;
	var $qb;
	var $rb;
	var $mb;
	var $qc;
	var $rc;
	var $mc;
	var $qd;
	var $rd;
	var $md;
	var $qe;
	var $re;
	var $me;
	var $qf;
	var $rf;
	var $mf;
	var $qg;
	var $rg;
	var $mg;
	var $qh;
	var $rh;
	var $mh;

	//
	// Table class constructor
	//
	function __construct() {
		global $ReportLanguage;
		$this->TableVar = 'golden';
		$this->TableName = 'golden';
		$this->TableType = 'TABLE';
		$this->DBID = 'DB';
		$this->ExportAll = FALSE;
		$this->ExportPageBreakCount = 0;

		// ID
		$this->ID = new crField('golden', 'golden', 'x_ID', 'ID', '`ID`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ID->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ID'] = &$this->ID;
		$this->ID->DateFilter = "";
		$this->ID->SqlSelect = "";
		$this->ID->SqlOrderBy = "";

		// qa
		$this->qa = new crField('golden', 'golden', 'x_qa', 'qa', '`qa`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qa'] = &$this->qa;
		$this->qa->DateFilter = "";
		$this->qa->SqlSelect = "";
		$this->qa->SqlOrderBy = "";

		// ra
		$this->ra = new crField('golden', 'golden', 'x_ra', 'ra', '`ra`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->ra->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['ra'] = &$this->ra;
		$this->ra->DateFilter = "";
		$this->ra->SqlSelect = "";
		$this->ra->SqlOrderBy = "";

		// ma
		$this->ma = new crField('golden', 'golden', 'x_ma', 'ma', '`ma`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['ma'] = &$this->ma;
		$this->ma->DateFilter = "";
		$this->ma->SqlSelect = "";
		$this->ma->SqlOrderBy = "";

		// qb
		$this->qb = new crField('golden', 'golden', 'x_qb', 'qb', '`qb`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qb'] = &$this->qb;
		$this->qb->DateFilter = "";
		$this->qb->SqlSelect = "";
		$this->qb->SqlOrderBy = "";

		// rb
		$this->rb = new crField('golden', 'golden', 'x_rb', 'rb', '`rb`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rb->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rb'] = &$this->rb;
		$this->rb->DateFilter = "";
		$this->rb->SqlSelect = "";
		$this->rb->SqlOrderBy = "";

		// mb
		$this->mb = new crField('golden', 'golden', 'x_mb', 'mb', '`mb`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mb'] = &$this->mb;
		$this->mb->DateFilter = "";
		$this->mb->SqlSelect = "";
		$this->mb->SqlOrderBy = "";

		// qc
		$this->qc = new crField('golden', 'golden', 'x_qc', 'qc', '`qc`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qc'] = &$this->qc;
		$this->qc->DateFilter = "";
		$this->qc->SqlSelect = "";
		$this->qc->SqlOrderBy = "";

		// rc
		$this->rc = new crField('golden', 'golden', 'x_rc', 'rc', '`rc`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rc->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rc'] = &$this->rc;
		$this->rc->DateFilter = "";
		$this->rc->SqlSelect = "";
		$this->rc->SqlOrderBy = "";

		// mc
		$this->mc = new crField('golden', 'golden', 'x_mc', 'mc', '`mc`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mc'] = &$this->mc;
		$this->mc->DateFilter = "";
		$this->mc->SqlSelect = "";
		$this->mc->SqlOrderBy = "";

		// qd
		$this->qd = new crField('golden', 'golden', 'x_qd', 'qd', '`qd`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qd'] = &$this->qd;
		$this->qd->DateFilter = "";
		$this->qd->SqlSelect = "";
		$this->qd->SqlOrderBy = "";

		// rd
		$this->rd = new crField('golden', 'golden', 'x_rd', 'rd', '`rd`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rd->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rd'] = &$this->rd;
		$this->rd->DateFilter = "";
		$this->rd->SqlSelect = "";
		$this->rd->SqlOrderBy = "";

		// md
		$this->md = new crField('golden', 'golden', 'x_md', 'md', '`md`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['md'] = &$this->md;
		$this->md->DateFilter = "";
		$this->md->SqlSelect = "";
		$this->md->SqlOrderBy = "";

		// qe
		$this->qe = new crField('golden', 'golden', 'x_qe', 'qe', '`qe`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qe'] = &$this->qe;
		$this->qe->DateFilter = "";
		$this->qe->SqlSelect = "";
		$this->qe->SqlOrderBy = "";

		// re
		$this->re = new crField('golden', 'golden', 'x_re', 're', '`re`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->re->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['re'] = &$this->re;
		$this->re->DateFilter = "";
		$this->re->SqlSelect = "";
		$this->re->SqlOrderBy = "";

		// me
		$this->me = new crField('golden', 'golden', 'x_me', 'me', '`me`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['me'] = &$this->me;
		$this->me->DateFilter = "";
		$this->me->SqlSelect = "";
		$this->me->SqlOrderBy = "";

		// qf
		$this->qf = new crField('golden', 'golden', 'x_qf', 'qf', '`qf`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qf'] = &$this->qf;
		$this->qf->DateFilter = "";
		$this->qf->SqlSelect = "";
		$this->qf->SqlOrderBy = "";

		// rf
		$this->rf = new crField('golden', 'golden', 'x_rf', 'rf', '`rf`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rf->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rf'] = &$this->rf;
		$this->rf->DateFilter = "";
		$this->rf->SqlSelect = "";
		$this->rf->SqlOrderBy = "";

		// mf
		$this->mf = new crField('golden', 'golden', 'x_mf', 'mf', '`mf`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mf'] = &$this->mf;
		$this->mf->DateFilter = "";
		$this->mf->SqlSelect = "";
		$this->mf->SqlOrderBy = "";

		// qg
		$this->qg = new crField('golden', 'golden', 'x_qg', 'qg', '`qg`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qg'] = &$this->qg;
		$this->qg->DateFilter = "";
		$this->qg->SqlSelect = "";
		$this->qg->SqlOrderBy = "";

		// rg
		$this->rg = new crField('golden', 'golden', 'x_rg', 'rg', '`rg`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rg->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rg'] = &$this->rg;
		$this->rg->DateFilter = "";
		$this->rg->SqlSelect = "";
		$this->rg->SqlOrderBy = "";

		// mg
		$this->mg = new crField('golden', 'golden', 'x_mg', 'mg', '`mg`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mg'] = &$this->mg;
		$this->mg->DateFilter = "";
		$this->mg->SqlSelect = "";
		$this->mg->SqlOrderBy = "";

		// qh
		$this->qh = new crField('golden', 'golden', 'x_qh', 'qh', '`qh`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['qh'] = &$this->qh;
		$this->qh->DateFilter = "";
		$this->qh->SqlSelect = "";
		$this->qh->SqlOrderBy = "";

		// rh
		$this->rh = new crField('golden', 'golden', 'x_rh', 'rh', '`rh`', 3, EWR_DATATYPE_NUMBER, -1);
		$this->rh->FldDefaultErrMsg = $ReportLanguage->Phrase("IncorrectInteger");
		$this->fields['rh'] = &$this->rh;
		$this->rh->DateFilter = "";
		$this->rh->SqlSelect = "";
		$this->rh->SqlOrderBy = "";

		// mh
		$this->mh = new crField('golden', 'golden', 'x_mh', 'mh', '`mh`', 200, EWR_DATATYPE_STRING, -1);
		$this->fields['mh'] = &$this->mh;
		$this->mh->DateFilter = "";
		$this->mh->SqlSelect = "";
		$this->mh->SqlOrderBy = "";
	}

	// Single column sort
	function UpdateSort(&$ofld) {
		if ($this->CurrentOrder == $ofld->FldName) {
			$sLastSort = $ofld->getSort();
			if ($this->CurrentOrderType == "ASC" || $this->CurrentOrderType == "DESC") {
				$sThisSort = $this->CurrentOrderType;
			} else {
				$sThisSort = ($sLastSort == "ASC") ? "DESC" : "ASC";
			}
			$ofld->setSort($sThisSort);
		} else {
			if ($ofld->GroupingFieldId == 0) $ofld->setSort("");
		}
	}

	// Get Sort SQL
	function SortSql() {
		$sDtlSortSql = "";
		$argrps = array();
		foreach ($this->fields as $fld) {
			if ($fld->getSort() <> "") {
				if ($fld->GroupingFieldId > 0) {
					if ($fld->FldGroupSql <> "")
						$argrps[$fld->GroupingFieldId] = str_replace("%s", $fld->FldExpression, $fld->FldGroupSql) . " " . $fld->getSort();
					else
						$argrps[$fld->GroupingFieldId] = $fld->FldExpression . " " . $fld->getSort();
				} else {
					if ($sDtlSortSql <> "") $sDtlSortSql .= ", ";
					$sDtlSortSql .= $fld->FldExpression . " " . $fld->getSort();
				}
			}
		}
		$sSortSql = "";
		foreach ($argrps as $grp) {
			if ($sSortSql <> "") $sSortSql .= ", ";
			$sSortSql .= $grp;
		}
		if ($sDtlSortSql <> "") {
			if ($sSortSql <> "") $sSortSql .= ",";
			$sSortSql .= $sDtlSortSql;
		}
		return $sSortSql;
	}

	// Table level SQL
	// From

	var $_SqlFrom = "";

	function getSqlFrom() {
		return ($this->_SqlFrom <> "") ? $this->_SqlFrom : "`golden`";
	}

	function SqlFrom() { // For backward compatibility
		return $this->getSqlFrom();
	}

	function setSqlFrom($v) {
		$this->_SqlFrom = $v;
	}

	// Select
	var $_SqlSelect = "";

	function getSqlSelect() {
		return ($this->_SqlSelect <> "") ? $this->_SqlSelect : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelect() { // For backward compatibility
		return $this->getSqlSelect();
	}

	function setSqlSelect($v) {
		$this->_SqlSelect = $v;
	}

	// Where
	var $_SqlWhere = "";

	function getSqlWhere() {
		$sWhere = ($this->_SqlWhere <> "") ? $this->_SqlWhere : "";
		return $sWhere;
	}

	function SqlWhere() { // For backward compatibility
		return $this->getSqlWhere();
	}

	function setSqlWhere($v) {
		$this->_SqlWhere = $v;
	}

	// Group By
	var $_SqlGroupBy = "";

	function getSqlGroupBy() {
		return ($this->_SqlGroupBy <> "") ? $this->_SqlGroupBy : "";
	}

	function SqlGroupBy() { // For backward compatibility
		return $this->getSqlGroupBy();
	}

	function setSqlGroupBy($v) {
		$this->_SqlGroupBy = $v;
	}

	// Having
	var $_SqlHaving = "";

	function getSqlHaving() {
		return ($this->_SqlHaving <> "") ? $this->_SqlHaving : "";
	}

	function SqlHaving() { // For backward compatibility
		return $this->getSqlHaving();
	}

	function setSqlHaving($v) {
		$this->_SqlHaving = $v;
	}

	// Order By
	var $_SqlOrderBy = "";

	function getSqlOrderBy() {
		return ($this->_SqlOrderBy <> "") ? $this->_SqlOrderBy : "";
	}

	function SqlOrderBy() { // For backward compatibility
		return $this->getSqlOrderBy();
	}

	function setSqlOrderBy($v) {
		$this->_SqlOrderBy = $v;
	}

	// Select Aggregate
	var $_SqlSelectAgg = "";

	function getSqlSelectAgg() {
		return ($this->_SqlSelectAgg <> "") ? $this->_SqlSelectAgg : "SELECT * FROM " . $this->getSqlFrom();
	}

	function SqlSelectAgg() { // For backward compatibility
		return $this->getSqlSelectAgg();
	}

	function setSqlSelectAgg($v) {
		$this->_SqlSelectAgg = $v;
	}

	// Aggregate Prefix
	var $_SqlAggPfx = "";

	function getSqlAggPfx() {
		return ($this->_SqlAggPfx <> "") ? $this->_SqlAggPfx : "";
	}

	function SqlAggPfx() { // For backward compatibility
		return $this->getSqlAggPfx();
	}

	function setSqlAggPfx($v) {
		$this->_SqlAggPfx = $v;
	}

	// Aggregate Suffix
	var $_SqlAggSfx = "";

	function getSqlAggSfx() {
		return ($this->_SqlAggSfx <> "") ? $this->_SqlAggSfx : "";
	}

	function SqlAggSfx() { // For backward compatibility
		return $this->getSqlAggSfx();
	}

	function setSqlAggSfx($v) {
		$this->_SqlAggSfx = $v;
	}

	// Select Count
	var $_SqlSelectCount = "";

	function getSqlSelectCount() {
		return ($this->_SqlSelectCount <> "") ? $this->_SqlSelectCount : "SELECT COUNT(*) FROM " . $this->getSqlFrom();
	}

	function SqlSelectCount() { // For backward compatibility
		return $this->getSqlSelectCount();
	}

	function setSqlSelectCount($v) {
		$this->_SqlSelectCount = $v;
	}

	// Sort URL
	function SortUrl(&$fld) {
		return "";
	}

	// Table level events
	// Page Selecting event
	function Page_Selecting(&$filter) {

		// Enter your code here	
	}

	// Page Breaking event
	function Page_Breaking(&$break, &$content) {

		// Example:
		//$break = FALSE; // Skip page break, or
		//$content = "<div style=\"page-break-after:always;\">&nbsp;</div>"; // Modify page break content

	}

	// Row Rendering event
	function Row_Rendering() {

		// Enter your code here	
	}

	// Cell Rendered event
	function Cell_Rendered(&$Field, $CurrentValue, &$ViewValue, &$ViewAttrs, &$CellAttrs, &$HrefValue, &$LinkAttrs) {

		//$ViewValue = "xxx";
		//$ViewAttrs["style"] = "xxx";

	}

	// Row Rendered event
	function Row_Rendered() {

		// To view properties of field class, use:
		//var_dump($this-><FieldName>); 

	}

	// User ID Filtering event
	function UserID_Filtering(&$filter) {

		// Enter your code here
	}

	// Load Filters event
	function Page_FilterLoad() {

		// Enter your code here
		// Example: Register/Unregister Custom Extended Filter
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A', 'GetStartsWithAFilter'); // With function, or
		//ewr_RegisterFilter($this-><Field>, 'StartsWithA', 'Starts With A'); // No function, use Page_Filtering event
		//ewr_UnregisterFilter($this-><Field>, 'StartsWithA');

	}

	// Page Filter Validated event
	function Page_FilterValidated() {

		// Example:
		//$this->MyField1->SearchValue = "your search criteria"; // Search value

	}

	// Page Filtering event
	function Page_Filtering(&$fld, &$filter, $typ, $opr = "", $val = "", $cond = "", $opr2 = "", $val2 = "") {

		// Note: ALWAYS CHECK THE FILTER TYPE ($typ)! Example:
		// if ($typ == "dropdown" && $fld->FldName == "MyField") // Dropdown filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "extended" && $fld->FldName == "MyField") // Extended filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "popup" && $fld->FldName == "MyField") // Popup filter
		//     $filter = "..."; // Modify the filter
		// if ($typ == "custom" && $opr == "..." && $fld->FldName == "MyField") // Custom filter, $opr is the custom filter ID
		//     $filter = "..."; // Modify the filter

	}

	// Email Sending event
	function Email_Sending(&$Email, &$Args) {

		//var_dump($Email); var_dump($Args); exit();
		return TRUE;
	}

	// Lookup Selecting event
	function Lookup_Selecting($fld, &$filter) {

		// Enter your code here
	}
}
?>
