<!DOCTYPE html>
<html>
<head>
	<link rel="icon" type="icon" href="logo.png">
	<style type="text/css">
		header{
			background-color: green;
			padding: 0px;
			width: auto;			
		}
		#subm{
			 background-color: lime; border-radius: 4px; height: 30px; width: 200px; box-shadow: 4px 4px 4px #777874; border: none; transition-duration: .4s;
		}
	</style>
</head>
<body>
	<header style="align-content: center;" align="left">
		<a href="../index.php"><input id="subm" type="submit" value="Evaluation Form"></a>
	</header>
</body>
</html>
<?php
if (session_id() == "") session_start(); // Initialize Session data
ob_start();
?>
<?php include_once "phprptinc/ewrcfg9.php" ?>
<?php include_once ((EW_USE_ADODB) ? "adodb5/adodb.inc.php" : "phprptinc/ewmysql.php") ?>
<?php include_once "phprptinc/ewrfn9.php" ?>
<?php include_once "phprptinc/ewrusrfn9.php" ?>
<?php include_once "heuristicrptinfo.php" ?>
<?php

//
// Page class
//

$heuristic_rpt = NULL; // Initialize page object first

class crheuristic_rpt extends crheuristic {

	// Page ID
	var $PageID = 'rpt';

	// Project ID
	var $ProjectID = "{7F45C9B5-7587-4392-8B05-3F952549C7C4}";

	// Page object name
	var $PageObjName = 'heuristic_rpt';

	// Page name
	function PageName() {
		return ewr_CurrentPage();
	}

	// Page URL
	function PageUrl() {
		$PageUrl = ewr_CurrentPage() . "?";
		if ($this->UseTokenInUrl) $PageUrl .= "t=" . $this->TableVar . "&"; // Add page token
		return $PageUrl;
	}

	// Export URLs
	var $ExportPrintUrl;
	var $ExportExcelUrl;
	var $ExportWordUrl;
	var $ExportPdfUrl;
	var $ReportTableClass;
	var $ReportTableStyle = "";

	// Custom export
	var $ExportPrintCustom = FALSE;
	var $ExportExcelCustom = FALSE;
	var $ExportWordCustom = FALSE;
	var $ExportPdfCustom = FALSE;
	var $ExportEmailCustom = FALSE;

	// Message
	function getMessage() {
		return @$_SESSION[EWR_SESSION_MESSAGE];
	}

	function setMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_MESSAGE], $v);
	}

	function getFailureMessage() {
		return @$_SESSION[EWR_SESSION_FAILURE_MESSAGE];
	}

	function setFailureMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_FAILURE_MESSAGE], $v);
	}

	function getSuccessMessage() {
		return @$_SESSION[EWR_SESSION_SUCCESS_MESSAGE];
	}

	function setSuccessMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_SUCCESS_MESSAGE], $v);
	}

	function getWarningMessage() {
		return @$_SESSION[EWR_SESSION_WARNING_MESSAGE];
	}

	function setWarningMessage($v) {
		ewr_AddMessage($_SESSION[EWR_SESSION_WARNING_MESSAGE], $v);
	}

		// Show message
	function ShowMessage() {
		$hidden = FALSE;
		$html = "";

		// Message
		$sMessage = $this->getMessage();
		$this->Message_Showing($sMessage, "");
		if ($sMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sMessage;
			$html .= "<div class=\"alert alert-info ewInfo\">" . $sMessage . "</div>";
			$_SESSION[EWR_SESSION_MESSAGE] = ""; // Clear message in Session
		}

		// Warning message
		$sWarningMessage = $this->getWarningMessage();
		$this->Message_Showing($sWarningMessage, "warning");
		if ($sWarningMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sWarningMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sWarningMessage;
			$html .= "<div class=\"alert alert-warning ewWarning\">" . $sWarningMessage . "</div>";
			$_SESSION[EWR_SESSION_WARNING_MESSAGE] = ""; // Clear message in Session
		}

		// Success message
		$sSuccessMessage = $this->getSuccessMessage();
		$this->Message_Showing($sSuccessMessage, "success");
		if ($sSuccessMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sSuccessMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sSuccessMessage;
			$html .= "<div class=\"alert alert-success ewSuccess\">" . $sSuccessMessage . "</div>";
			$_SESSION[EWR_SESSION_SUCCESS_MESSAGE] = ""; // Clear message in Session
		}

		// Failure message
		$sErrorMessage = $this->getFailureMessage();
		$this->Message_Showing($sErrorMessage, "failure");
		if ($sErrorMessage <> "") { // Message in Session, display
			if (!$hidden)
				$sErrorMessage = "<button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>" . $sErrorMessage;
			$html .= "<div class=\"alert alert-danger ewError\">" . $sErrorMessage . "</div>";
			$_SESSION[EWR_SESSION_FAILURE_MESSAGE] = ""; // Clear message in Session
		}
		echo "<div class=\"ewMessageDialog ewDisplayTable\"" . (($hidden) ? " style=\"display: none;\"" : "") . ">" . $html . "</div>";
	}
	var $PageHeader;
	var $PageFooter;

	// Show Page Header
	function ShowPageHeader() {
		$sHeader = $this->PageHeader;
		$this->Page_DataRendering($sHeader);
		if ($sHeader <> "") // Header exists, display
			echo $sHeader;
	}

	// Show Page Footer
	function ShowPageFooter() {
		$sFooter = $this->PageFooter;
		$this->Page_DataRendered($sFooter);
		if ($sFooter <> "") // Fotoer exists, display
			echo $sFooter;
	}

	// Validate page request
	function IsPageRequest() {
		if ($this->UseTokenInUrl) {
			if (ewr_IsHttpPost())
				return ($this->TableVar == @$_POST("t"));
			if (@$_GET["t"] <> "")
				return ($this->TableVar == @$_GET["t"]);
		} else {
			return TRUE;
		}
	}
	var $Token = "";
	var $CheckToken = EWR_CHECK_TOKEN;
	var $CheckTokenFn = "ewr_CheckToken";
	var $CreateTokenFn = "ewr_CreateToken";

	// Valid Post
	function ValidPost() {
		if (!$this->CheckToken || !ewr_IsHttpPost())
			return TRUE;
		if (!isset($_POST[EWR_TOKEN_NAME]))
			return FALSE;
		$fn = $this->CheckTokenFn;
		if (is_callable($fn))
			return $fn($_POST[EWR_TOKEN_NAME]);
		return FALSE;
	}

	// Create Token
	function CreateToken() {
		global $gsToken;
		if ($this->CheckToken) {
			$fn = $this->CreateTokenFn;
			if ($this->Token == "" && is_callable($fn)) // Create token
				$this->Token = $fn();
			$gsToken = $this->Token; // Save to global variable
		}
	}

	//
	// Page class constructor
	//
	function __construct() {
		global $conn, $ReportLanguage;

		// Language object
		$ReportLanguage = new crLanguage();

		// Parent constuctor
		parent::__construct();

		// Table object (heuristic)
		if (!isset($GLOBALS["heuristic"])) {
			$GLOBALS["heuristic"] = &$this;
			$GLOBALS["Table"] = &$GLOBALS["heuristic"];
		}

		// Initialize URLs
		$this->ExportPrintUrl = $this->PageUrl() . "export=print";
		$this->ExportExcelUrl = $this->PageUrl() . "export=excel";
		$this->ExportWordUrl = $this->PageUrl() . "export=word";
		$this->ExportPdfUrl = $this->PageUrl() . "export=pdf";

		// Page ID
		if (!defined("EWR_PAGE_ID"))
			define("EWR_PAGE_ID", 'rpt', TRUE);

		// Table name (for backward compatibility)
		if (!defined("EWR_TABLE_NAME"))
			define("EWR_TABLE_NAME", 'heuristic', TRUE);

		// Start timer
		$GLOBALS["gsTimer"] = new crTimer();

		// Open connection
		if (!isset($conn)) $conn = ewr_Connect($this->DBID);

		// Export options
		$this->ExportOptions = new crListOptions();
		$this->ExportOptions->Tag = "div";
		$this->ExportOptions->TagClassName = "ewExportOption";

		// Search options
		$this->SearchOptions = new crListOptions();
		$this->SearchOptions->Tag = "div";
		$this->SearchOptions->TagClassName = "ewSearchOption";

		// Filter options
		$this->FilterOptions = new crListOptions();
		$this->FilterOptions->Tag = "div";
		$this->FilterOptions->TagClassName = "ewFilterOption fheuristicrpt";
	}

	// 
	//  Page_Init
	//
	function Page_Init() {
		global $gsExport, $gsExportFile, $gsEmailContentType, $ReportLanguage, $Security;
		global $gsCustomExport;

		// Get export parameters
		if (@$_GET["export"] <> "")
			$this->Export = strtolower($_GET["export"]);
		elseif (@$_POST["export"] <> "")
			$this->Export = strtolower($_POST["export"]);
		$gsExport = $this->Export; // Get export parameter, used in header
		$gsExportFile = $this->TableVar; // Get export file, used in header
		$gsEmailContentType = @$_POST["contenttype"]; // Get email content type

		// Setup placeholder
		// Setup export options

		$this->SetupExportOptions();

		// Global Page Loading event (in userfn*.php)
		Page_Loading();

		// Page Load event
		$this->Page_Load();

		// Check token
		if (!$this->ValidPost()) {
			echo $ReportLanguage->Phrase("InvalidPostRequest");
			$this->Page_Terminate();
			exit();
		}

		// Create Token
		$this->CreateToken();
	}

	// Set up export options
	function SetupExportOptions() {
		global $ReportLanguage;
		$exportid = session_id();

		// Printer friendly
		$item = &$this->ExportOptions->Add("print");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("PrinterFriendly", TRUE)) . "\" href=\"" . $this->ExportPrintUrl . "\">" . $ReportLanguage->Phrase("PrinterFriendly") . "</a>";
		$item->Visible = FALSE;

		// Export to Excel
		$item = &$this->ExportOptions->Add("excel");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToExcel", TRUE)) . "\" href=\"" . $this->ExportExcelUrl . "\">" . $ReportLanguage->Phrase("ExportToExcel") . "</a>";
		$item->Visible = FALSE;

		// Export to Word
		$item = &$this->ExportOptions->Add("word");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToWord", TRUE)) . "\" href=\"" . $this->ExportWordUrl . "\">" . $ReportLanguage->Phrase("ExportToWord") . "</a>";

		//$item->Visible = FALSE;
		$item->Visible = FALSE;

		// Export to Pdf
		$item = &$this->ExportOptions->Add("pdf");
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToPDF", TRUE)) . "\" href=\"" . $this->ExportPdfUrl . "\">" . $ReportLanguage->Phrase("ExportToPDF") . "</a>";
		$item->Visible = FALSE;

		// Uncomment codes below to show export to Pdf link
//		$item->Visible = FALSE;
		// Export to Email

		$item = &$this->ExportOptions->Add("email");
		$url = $this->PageUrl() . "export=email";
		$item->Body = "<a title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ExportToEmail", TRUE)) . "\" id=\"emf_heuristic\" href=\"javascript:void(0);\" onclick=\"ewr_EmailDialogShow({lnk:'emf_heuristic',hdr:ewLanguage.Phrase('ExportToEmail'),url:'$url',exportid:'$exportid',el:this});\">" . $ReportLanguage->Phrase("ExportToEmail") . "</a>";
		$item->Visible = FALSE;

		// Drop down button for export
		$this->ExportOptions->UseDropDownButton = FALSE;
		$this->ExportOptions->UseButtonGroup = TRUE;
		$this->ExportOptions->UseImageAndText = $this->ExportOptions->UseDropDownButton;
		$this->ExportOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("ButtonExport");

		// Add group option item
		$item = &$this->ExportOptions->Add($this->ExportOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter panel button
		$item = &$this->SearchOptions->Add("searchtoggle");
		$SearchToggleClass = " active";
		$item->Body = "<button type=\"button\" class=\"btn btn-default ewSearchToggle" . $SearchToggleClass . "\" title=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-caption=\"" . $ReportLanguage->Phrase("SearchBtn", TRUE) . "\" data-toggle=\"button\" data-form=\"fheuristicrpt\">" . $ReportLanguage->Phrase("SearchBtn") . "</button>";
		$item->Visible = FALSE;

		// Reset filter
		$item = &$this->SearchOptions->Add("resetfilter");
		$item->Body = "<button type=\"button\" class=\"btn btn-default\" title=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" data-caption=\"" . ewr_HtmlEncode($ReportLanguage->Phrase("ResetAllFilter", TRUE)) . "\" onclick=\"location='" . ewr_CurrentPage() . "?cmd=reset'\">" . $ReportLanguage->Phrase("ResetAllFilter") . "</button>";
		$item->Visible = FALSE;

		// Button group for reset filter
		$this->SearchOptions->UseButtonGroup = TRUE;

		// Add group option item
		$item = &$this->SearchOptions->Add($this->SearchOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Filter button
		$item = &$this->FilterOptions->Add("savecurrentfilter");
		$item->Body = "<a class=\"ewSaveFilter\" data-form=\"fheuristicrpt\" href=\"#\">" . $ReportLanguage->Phrase("SaveCurrentFilter") . "</a>";
		$item->Visible = TRUE;
		$item = &$this->FilterOptions->Add("deletefilter");
		$item->Body = "<a class=\"ewDeleteFilter\" data-form=\"fheuristicrpt\" href=\"#\">" . $ReportLanguage->Phrase("DeleteFilter") . "</a>";
		$item->Visible = TRUE;
		$this->FilterOptions->UseDropDownButton = TRUE;
		$this->FilterOptions->UseButtonGroup = !$this->FilterOptions->UseDropDownButton; // v8
		$this->FilterOptions->DropDownButtonPhrase = $ReportLanguage->Phrase("Filters");

		// Add group option item
		$item = &$this->FilterOptions->Add($this->FilterOptions->GroupOptionName);
		$item->Body = "";
		$item->Visible = FALSE;

		// Set up options (extended)
		$this->SetupExportOptionsExt();

		// Hide options for export
		if ($this->Export <> "") {
			$this->ExportOptions->HideAllOptions();
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Set up table class
		if ($this->Export == "word" || $this->Export == "excel" || $this->Export == "pdf")
			$this->ReportTableClass = "ewTable";
		else
			$this->ReportTableClass = "table ewTable";
	}

	//
	// Page_Terminate
	//
	function Page_Terminate($url = "") {
		global $ReportLanguage, $EWR_EXPORT, $gsExportFile;

		// Page Unload event
		$this->Page_Unload();

		// Global Page Unloaded event (in userfn*.php)
		Page_Unloaded();

		// Export
		if ($this->Export <> "" && array_key_exists($this->Export, $EWR_EXPORT)) {
			$sContent = ob_get_contents();

			// Remove all <div data-tagid="..." id="orig..." class="hide">...</div> (for customviewtag export, except "googlemaps")
			if (preg_match_all('/<div\s+data-tagid=[\'"]([\s\S]*?)[\'"]\s+id=[\'"]orig([\s\S]*?)[\'"]\s+class\s*=\s*[\'"]hide[\'"]>([\s\S]*?)<\/div\s*>/i', $sContent, $divmatches, PREG_SET_ORDER)) {
				foreach ($divmatches as $divmatch) {
					if ($divmatch[1] <> "googlemaps")
						$sContent = str_replace($divmatch[0], '', $sContent);
				}
			}
			$fn = $EWR_EXPORT[$this->Export];
			if ($this->Export == "email") { // Email
				ob_end_clean();
				echo $this->$fn($sContent);
				ewr_CloseConn(); // Close connection
				exit();
			} else {
				$this->$fn($sContent);
			}
		}

		 // Close connection
		ewr_CloseConn();

		// Go to URL if specified
		if ($url <> "") {
			if (!EWR_DEBUG_ENABLED && ob_get_length())
				ob_end_clean();
			header("Location: " . $url);
		}
		exit();
	}

	// Initialize common variables
	var $ExportOptions; // Export options
	var $SearchOptions; // Search options
	var $FilterOptions; // Filter options

	// Paging variables
	var $RecIndex = 0; // Record index
	var $RecCount = 0; // Record count
	var $StartGrp = 0; // Start group
	var $StopGrp = 0; // Stop group
	var $TotalGrps = 0; // Total groups
	var $GrpCount = 0; // Group count
	var $GrpCounter = array(); // Group counter
	var $DisplayGrps = 3; // Groups per page
	var $GrpRange = 10;
	var $Sort = "";
	var $Filter = "";
	var $PageFirstGroupFilter = "";
	var $UserIDFilter = "";
	var $DrillDown = FALSE;
	var $DrillDownInPanel = FALSE;
	var $DrillDownList = "";

	// Clear field for ext filter
	var $ClearExtFilter = "";
	var $PopupName = "";
	var $PopupValue = "";
	var $FilterApplied;
	var $SearchCommand = FALSE;
	var $ShowHeader;
	var $GrpFldCount = 0;
	var $SubGrpFldCount = 0;
	var $DtlFldCount = 0;
	var $Cnt, $Col, $Val, $Smry, $Mn, $Mx, $GrandCnt, $GrandSmry, $GrandMn, $GrandMx;
	var $TotCount;
	var $GrandSummarySetup = FALSE;
	var $GrpIdx;

	//
	// Page main
	//
	function Page_Main() {
		global $rs;
		global $rsgrp;
		global $Security;
		global $gsFormError;
		global $gbDrillDownInPanel;
		global $ReportBreadcrumb;
		global $ReportLanguage;

		// Aggregate variables
		// 1st dimension = no of groups (level 0 used for grand total)
		// 2nd dimension = no of fields

		$nDtls = 38;
		$nGrps = 1;
		$this->Val = &ewr_InitArray($nDtls, 0);
		$this->Cnt = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Smry = &ewr_Init2DArray($nGrps, $nDtls, 0);
		$this->Mn = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->Mx = &ewr_Init2DArray($nGrps, $nDtls, NULL);
		$this->GrandCnt = &ewr_InitArray($nDtls, 0);
		$this->GrandSmry = &ewr_InitArray($nDtls, 0);
		$this->GrandMn = &ewr_InitArray($nDtls, NULL);
		$this->GrandMx = &ewr_InitArray($nDtls, NULL);

		// Set up array if accumulation required: array(Accum, SkipNullOrZero)
		$this->Col = array(array(FALSE, FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE), array(FALSE,FALSE));

		// Set up groups per page dynamically
		$this->SetUpDisplayGrps();

		// Set up Breadcrumb
		if ($this->Export == "")
			$this->SetupBreadcrumb();

		// Load custom filters
		$this->Page_FilterLoad();

		// Set up popup filter
		$this->SetupPopup();

		// Load group db values if necessary
		$this->LoadGroupDbValues();

		// Handle Ajax popup
		$this->ProcessAjaxPopup();

		// Extended filter
		$sExtendedFilter = "";

		// Build popup filter
		$sPopupFilter = $this->GetPopupFilter();

		//ewr_SetDebugMsg("popup filter: " . $sPopupFilter);
		ewr_AddFilter($this->Filter, $sPopupFilter);

		// No filter
		$this->FilterApplied = FALSE;
		$this->FilterOptions->GetItem("savecurrentfilter")->Visible = FALSE;
		$this->FilterOptions->GetItem("deletefilter")->Visible = FALSE;

		// Call Page Selecting event
		$this->Page_Selecting($this->Filter);
		$this->SearchOptions->GetItem("resetfilter")->Visible = $this->FilterApplied;

		// Get sort
		$this->Sort = $this->GetSort();

		// Get total count
		$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), $this->getSqlOrderBy(), $this->Filter, $this->Sort);
		$this->TotalGrps = $this->GetCnt($sSql);
		if ($this->DisplayGrps <= 0 || $this->DrillDown) // Display all groups
			$this->DisplayGrps = $this->TotalGrps;
		$this->StartGrp = 1;

		// Show header
		$this->ShowHeader = ($this->TotalGrps > 0);

		// Set up start position if not export all
		if ($this->ExportAll && $this->Export <> "")
		    $this->DisplayGrps = $this->TotalGrps;
		else
			$this->SetUpStartGroup(); 

		// Set no record found message
		if ($this->TotalGrps == 0) {
				if ($this->Filter == "0=101") {
					$this->setWarningMessage($ReportLanguage->Phrase("EnterSearchCriteria"));
				} else {
					$this->setWarningMessage($ReportLanguage->Phrase("NoRecord"));
				}
		}

		// Hide export options if export
		if ($this->Export <> "")
			$this->ExportOptions->HideAllOptions();

		// Hide search/filter options if export/drilldown
		if ($this->Export <> "" || $this->DrillDown) {
			$this->SearchOptions->HideAllOptions();
			$this->FilterOptions->HideAllOptions();
		}

		// Get current page records
		$rs = $this->GetRs($sSql, $this->StartGrp, $this->DisplayGrps);
		$this->SetupFieldCount();
	}

	// Accummulate summary
	function AccumulateSummary() {
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				if ($this->Col[$iy][0]) { // Accumulate required
					$valwrk = $this->Val[$iy];
					if (is_null($valwrk)) {
						if (!$this->Col[$iy][1])
							$this->Cnt[$ix][$iy]++;
					} else {
						$accum = (!$this->Col[$iy][1] || !is_numeric($valwrk) || $valwrk <> 0);
						if ($accum) {
							$this->Cnt[$ix][$iy]++;
							if (is_numeric($valwrk)) {
								$this->Smry[$ix][$iy] += $valwrk;
								if (is_null($this->Mn[$ix][$iy])) {
									$this->Mn[$ix][$iy] = $valwrk;
									$this->Mx[$ix][$iy] = $valwrk;
								} else {
									if ($this->Mn[$ix][$iy] > $valwrk) $this->Mn[$ix][$iy] = $valwrk;
									if ($this->Mx[$ix][$iy] < $valwrk) $this->Mx[$ix][$iy] = $valwrk;
								}
							}
						}
					}
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = 0; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0]++;
		}
	}

	// Reset level summary
	function ResetLevelSummary($lvl) {

		// Clear summary values
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$cnty = count($this->Smry[$ix]);
			for ($iy = 1; $iy < $cnty; $iy++) {
				$this->Cnt[$ix][$iy] = 0;
				if ($this->Col[$iy][0]) {
					$this->Smry[$ix][$iy] = 0;
					$this->Mn[$ix][$iy] = NULL;
					$this->Mx[$ix][$iy] = NULL;
				}
			}
		}
		$cntx = count($this->Smry);
		for ($ix = $lvl; $ix < $cntx; $ix++) {
			$this->Cnt[$ix][0] = 0;
		}

		// Reset record count
		$this->RecCount = 0;
	}

	// Accummulate grand summary
	function AccumulateGrandSummary() {
		$this->TotCount++;
		$cntgs = count($this->GrandSmry);
		for ($iy = 1; $iy < $cntgs; $iy++) {
			if ($this->Col[$iy][0]) {
				$valwrk = $this->Val[$iy];
				if (is_null($valwrk) || !is_numeric($valwrk)) {
					if (!$this->Col[$iy][1])
						$this->GrandCnt[$iy]++;
				} else {
					if (!$this->Col[$iy][1] || $valwrk <> 0) {
						$this->GrandCnt[$iy]++;
						$this->GrandSmry[$iy] += $valwrk;
						if (is_null($this->GrandMn[$iy])) {
							$this->GrandMn[$iy] = $valwrk;
							$this->GrandMx[$iy] = $valwrk;
						} else {
							if ($this->GrandMn[$iy] > $valwrk) $this->GrandMn[$iy] = $valwrk;
							if ($this->GrandMx[$iy] < $valwrk) $this->GrandMx[$iy] = $valwrk;
						}
					}
				}
			}
		}
	}

	// Get count
	function GetCnt($sql) {
		$conn = &$this->Connection();
		$rscnt = $conn->Execute($sql);
		$cnt = ($rscnt) ? $rscnt->RecordCount() : 0;
		if ($rscnt) $rscnt->Close();
		return $cnt;
	}

	// Get recordset
	function GetRs($wrksql, $start, $grps) {
		$conn = &$this->Connection();
		$conn->raiseErrorFn = $GLOBALS["EWR_ERROR_FN"];
		$rswrk = $conn->SelectLimit($wrksql, $grps, $start - 1);
		$conn->raiseErrorFn = '';
		return $rswrk;
	}

	// Get row values
	function GetRow($opt) {
		global $rs;
		if (!$rs)
			return;
		if ($opt == 1) { // Get first row

	//		$rs->MoveFirst(); // NOTE: no need to move position
				$this->FirstRowData = array();
				$this->FirstRowData['ID'] = ewr_Conv($rs->fields('ID'),3);
				$this->FirstRowData['qa'] = ewr_Conv($rs->fields('qa'),200);
				$this->FirstRowData['ra'] = ewr_Conv($rs->fields('ra'),3);
				$this->FirstRowData['ma'] = ewr_Conv($rs->fields('ma'),200);
				$this->FirstRowData['qb'] = ewr_Conv($rs->fields('qb'),200);
				$this->FirstRowData['rb'] = ewr_Conv($rs->fields('rb'),3);
				$this->FirstRowData['mb'] = ewr_Conv($rs->fields('mb'),200);
				$this->FirstRowData['qc'] = ewr_Conv($rs->fields('qc'),200);
				$this->FirstRowData['rc'] = ewr_Conv($rs->fields('rc'),3);
				$this->FirstRowData['mc'] = ewr_Conv($rs->fields('mc'),200);
				$this->FirstRowData['qd'] = ewr_Conv($rs->fields('qd'),200);
				$this->FirstRowData['rd'] = ewr_Conv($rs->fields('rd'),3);
				$this->FirstRowData['md'] = ewr_Conv($rs->fields('md'),3);
				$this->FirstRowData['qe'] = ewr_Conv($rs->fields('qe'),200);
				$this->FirstRowData['re'] = ewr_Conv($rs->fields('re'),3);
				$this->FirstRowData['me'] = ewr_Conv($rs->fields('me'),200);
				$this->FirstRowData['qf'] = ewr_Conv($rs->fields('qf'),200);
				$this->FirstRowData['rf'] = ewr_Conv($rs->fields('rf'),3);
				$this->FirstRowData['mf'] = ewr_Conv($rs->fields('mf'),200);
				$this->FirstRowData['qg'] = ewr_Conv($rs->fields('qg'),200);
				$this->FirstRowData['rg'] = ewr_Conv($rs->fields('rg'),3);
				$this->FirstRowData['mg'] = ewr_Conv($rs->fields('mg'),200);
				$this->FirstRowData['qh'] = ewr_Conv($rs->fields('qh'),200);
				$this->FirstRowData['rh'] = ewr_Conv($rs->fields('rh'),3);
				$this->FirstRowData['mh'] = ewr_Conv($rs->fields('mh'),200);
				$this->FirstRowData['qi'] = ewr_Conv($rs->fields('qi'),200);
				$this->FirstRowData['ri'] = ewr_Conv($rs->fields('ri'),3);
				$this->FirstRowData['mi'] = ewr_Conv($rs->fields('mi'),200);
				$this->FirstRowData['qj'] = ewr_Conv($rs->fields('qj'),200);
				$this->FirstRowData['rj'] = ewr_Conv($rs->fields('rj'),3);
				$this->FirstRowData['mj'] = ewr_Conv($rs->fields('mj'),200);
				$this->FirstRowData['qk'] = ewr_Conv($rs->fields('qk'),200);
				$this->FirstRowData['rk'] = ewr_Conv($rs->fields('rk'),3);
				$this->FirstRowData['mk'] = ewr_Conv($rs->fields('mk'),200);
				$this->FirstRowData['ql'] = ewr_Conv($rs->fields('ql'),200);
				$this->FirstRowData['rl'] = ewr_Conv($rs->fields('rl'),3);
				$this->FirstRowData['ml'] = ewr_Conv($rs->fields('ml'),200);
		} else { // Get next row
			$rs->MoveNext();
		}
		if (!$rs->EOF) {
			$this->ID->setDbValue($rs->fields('ID'));
			$this->qa->setDbValue($rs->fields('qa'));
			$this->ra->setDbValue($rs->fields('ra'));
			$this->ma->setDbValue($rs->fields('ma'));
			$this->qb->setDbValue($rs->fields('qb'));
			$this->rb->setDbValue($rs->fields('rb'));
			$this->mb->setDbValue($rs->fields('mb'));
			$this->qc->setDbValue($rs->fields('qc'));
			$this->rc->setDbValue($rs->fields('rc'));
			$this->mc->setDbValue($rs->fields('mc'));
			$this->qd->setDbValue($rs->fields('qd'));
			$this->rd->setDbValue($rs->fields('rd'));
			$this->md->setDbValue($rs->fields('md'));
			$this->qe->setDbValue($rs->fields('qe'));
			$this->re->setDbValue($rs->fields('re'));
			$this->me->setDbValue($rs->fields('me'));
			$this->qf->setDbValue($rs->fields('qf'));
			$this->rf->setDbValue($rs->fields('rf'));
			$this->mf->setDbValue($rs->fields('mf'));
			$this->qg->setDbValue($rs->fields('qg'));
			$this->rg->setDbValue($rs->fields('rg'));
			$this->mg->setDbValue($rs->fields('mg'));
			$this->qh->setDbValue($rs->fields('qh'));
			$this->rh->setDbValue($rs->fields('rh'));
			$this->mh->setDbValue($rs->fields('mh'));
			$this->qi->setDbValue($rs->fields('qi'));
			$this->ri->setDbValue($rs->fields('ri'));
			$this->mi->setDbValue($rs->fields('mi'));
			$this->qj->setDbValue($rs->fields('qj'));
			$this->rj->setDbValue($rs->fields('rj'));
			$this->mj->setDbValue($rs->fields('mj'));
			$this->qk->setDbValue($rs->fields('qk'));
			$this->rk->setDbValue($rs->fields('rk'));
			$this->mk->setDbValue($rs->fields('mk'));
			$this->ql->setDbValue($rs->fields('ql'));
			$this->rl->setDbValue($rs->fields('rl'));
			$this->ml->setDbValue($rs->fields('ml'));
			$this->Val[1] = $this->ID->CurrentValue;
			$this->Val[2] = $this->qa->CurrentValue;
			$this->Val[3] = $this->ra->CurrentValue;
			$this->Val[4] = $this->ma->CurrentValue;
			$this->Val[5] = $this->qb->CurrentValue;
			$this->Val[6] = $this->rb->CurrentValue;
			$this->Val[7] = $this->mb->CurrentValue;
			$this->Val[8] = $this->qc->CurrentValue;
			$this->Val[9] = $this->rc->CurrentValue;
			$this->Val[10] = $this->mc->CurrentValue;
			$this->Val[11] = $this->qd->CurrentValue;
			$this->Val[12] = $this->rd->CurrentValue;
			$this->Val[13] = $this->md->CurrentValue;
			$this->Val[14] = $this->qe->CurrentValue;
			$this->Val[15] = $this->re->CurrentValue;
			$this->Val[16] = $this->me->CurrentValue;
			$this->Val[17] = $this->qf->CurrentValue;
			$this->Val[18] = $this->rf->CurrentValue;
			$this->Val[19] = $this->mf->CurrentValue;
			$this->Val[20] = $this->qg->CurrentValue;
			$this->Val[21] = $this->rg->CurrentValue;
			$this->Val[22] = $this->mg->CurrentValue;
			$this->Val[23] = $this->qh->CurrentValue;
			$this->Val[24] = $this->rh->CurrentValue;
			$this->Val[25] = $this->mh->CurrentValue;
			$this->Val[26] = $this->qi->CurrentValue;
			$this->Val[27] = $this->ri->CurrentValue;
			$this->Val[28] = $this->mi->CurrentValue;
			$this->Val[29] = $this->qj->CurrentValue;
			$this->Val[30] = $this->rj->CurrentValue;
			$this->Val[31] = $this->mj->CurrentValue;
			$this->Val[32] = $this->qk->CurrentValue;
			$this->Val[33] = $this->rk->CurrentValue;
			$this->Val[34] = $this->mk->CurrentValue;
			$this->Val[35] = $this->ql->CurrentValue;
			$this->Val[36] = $this->rl->CurrentValue;
			$this->Val[37] = $this->ml->CurrentValue;
		} else {
			$this->ID->setDbValue("");
			$this->qa->setDbValue("");
			$this->ra->setDbValue("");
			$this->ma->setDbValue("");
			$this->qb->setDbValue("");
			$this->rb->setDbValue("");
			$this->mb->setDbValue("");
			$this->qc->setDbValue("");
			$this->rc->setDbValue("");
			$this->mc->setDbValue("");
			$this->qd->setDbValue("");
			$this->rd->setDbValue("");
			$this->md->setDbValue("");
			$this->qe->setDbValue("");
			$this->re->setDbValue("");
			$this->me->setDbValue("");
			$this->qf->setDbValue("");
			$this->rf->setDbValue("");
			$this->mf->setDbValue("");
			$this->qg->setDbValue("");
			$this->rg->setDbValue("");
			$this->mg->setDbValue("");
			$this->qh->setDbValue("");
			$this->rh->setDbValue("");
			$this->mh->setDbValue("");
			$this->qi->setDbValue("");
			$this->ri->setDbValue("");
			$this->mi->setDbValue("");
			$this->qj->setDbValue("");
			$this->rj->setDbValue("");
			$this->mj->setDbValue("");
			$this->qk->setDbValue("");
			$this->rk->setDbValue("");
			$this->mk->setDbValue("");
			$this->ql->setDbValue("");
			$this->rl->setDbValue("");
			$this->ml->setDbValue("");
		}
	}

	//  Set up starting group
	function SetUpStartGroup() {

		// Exit if no groups
		if ($this->DisplayGrps == 0)
			return;

		// Check for a 'start' parameter
		if (@$_GET[EWR_TABLE_START_GROUP] != "") {
			$this->StartGrp = $_GET[EWR_TABLE_START_GROUP];
			$this->setStartGroup($this->StartGrp);
		} elseif (@$_GET["pageno"] != "") {
			$nPageNo = $_GET["pageno"];
			if (is_numeric($nPageNo)) {
				$this->StartGrp = ($nPageNo-1)*$this->DisplayGrps+1;
				if ($this->StartGrp <= 0) {
					$this->StartGrp = 1;
				} elseif ($this->StartGrp >= intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1) {
					$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps)*$this->DisplayGrps+1;
				}
				$this->setStartGroup($this->StartGrp);
			} else {
				$this->StartGrp = $this->getStartGroup();
			}
		} else {
			$this->StartGrp = $this->getStartGroup();
		}

		// Check if correct start group counter
		if (!is_numeric($this->StartGrp) || $this->StartGrp == "") { // Avoid invalid start group counter
			$this->StartGrp = 1; // Reset start group counter
			$this->setStartGroup($this->StartGrp);
		} elseif (intval($this->StartGrp) > intval($this->TotalGrps)) { // Avoid starting group > total groups
			$this->StartGrp = intval(($this->TotalGrps-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to last page first group
			$this->setStartGroup($this->StartGrp);
		} elseif (($this->StartGrp-1) % $this->DisplayGrps <> 0) {
			$this->StartGrp = intval(($this->StartGrp-1)/$this->DisplayGrps) * $this->DisplayGrps + 1; // Point to page boundary
			$this->setStartGroup($this->StartGrp);
		}
	}

	// Load group db values if necessary
	function LoadGroupDbValues() {
		$conn = &$this->Connection();
	}

	// Process Ajax popup
	function ProcessAjaxPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		$fld = NULL;
		if (@$_GET["popup"] <> "") {
			$popupname = $_GET["popup"];

			// Check popup name
			// Output data as Json

			if (!is_null($fld)) {
				$jsdb = ewr_GetJsDb($fld, $fld->FldType);
				ob_end_clean();
				echo $jsdb;
				exit();
			}
		}
	}

	// Set up popup
	function SetupPopup() {
		global $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->DrillDown)
			return;

		// Process post back form
		if (ewr_IsHttpPost()) {
			$sName = @$_POST["popup"]; // Get popup form name
			if ($sName <> "") {
				$cntValues = (is_array(@$_POST["sel_$sName"])) ? count($_POST["sel_$sName"]) : 0;
				if ($cntValues > 0) {
					$arValues = ewr_StripSlashes($_POST["sel_$sName"]);
					if (trim($arValues[0]) == "") // Select all
						$arValues = EWR_INIT_VALUE;
					$_SESSION["sel_$sName"] = $arValues;
					$_SESSION["rf_$sName"] = ewr_StripSlashes(@$_POST["rf_$sName"]);
					$_SESSION["rt_$sName"] = ewr_StripSlashes(@$_POST["rt_$sName"]);
					$this->ResetPager();
				}
			}

		// Get 'reset' command
		} elseif (@$_GET["cmd"] <> "") {
			$sCmd = $_GET["cmd"];
			if (strtolower($sCmd) == "reset") {
				$this->ResetPager();
			}
		}

		// Load selection criteria to array
	}

	// Reset pager
	function ResetPager() {

		// Reset start position (reset command)
		$this->StartGrp = 1;
		$this->setStartGroup($this->StartGrp);
	}

	// Set up number of groups displayed per page
	function SetUpDisplayGrps() {
		$sWrk = @$_GET[EWR_TABLE_GROUP_PER_PAGE];
		if ($sWrk <> "") {
			if (is_numeric($sWrk)) {
				$this->DisplayGrps = intval($sWrk);
			} else {
				if (strtoupper($sWrk) == "ALL") { // Display all groups
					$this->DisplayGrps = -1;
				} else {
					$this->DisplayGrps = 3; // Non-numeric, load default
				}
			}
			$this->setGroupPerPage($this->DisplayGrps); // Save to session

			// Reset start position (reset command)
			$this->StartGrp = 1;
			$this->setStartGroup($this->StartGrp);
		} else {
			if ($this->getGroupPerPage() <> "") {
				$this->DisplayGrps = $this->getGroupPerPage(); // Restore from session
			} else {
				$this->DisplayGrps = 3; // Load default
			}
		}
	}

	// Render row
	function RenderRow() {
		global $rs, $Security, $ReportLanguage;
		$conn = &$this->Connection();
		if ($this->RowTotalType == EWR_ROWTOTAL_GRAND && !$this->GrandSummarySetup) { // Grand total
			$bGotCount = FALSE;
			$bGotSummary = FALSE;

			// Get total count from sql directly
			$sSql = ewr_BuildReportSql($this->getSqlSelectCount(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
			$rstot = $conn->Execute($sSql);
			if ($rstot) {
				$this->TotCount = ($rstot->RecordCount()>1) ? $rstot->RecordCount() : $rstot->fields[0];
				$rstot->Close();
				$bGotCount = TRUE;
			} else {
				$this->TotCount = 0;
			}
		$bGotSummary = TRUE;

			// Accumulate grand summary from detail records
			if (!$bGotCount || !$bGotSummary) {
				$sSql = ewr_BuildReportSql($this->getSqlSelect(), $this->getSqlWhere(), $this->getSqlGroupBy(), $this->getSqlHaving(), "", $this->Filter, "");
				$rs = $conn->Execute($sSql);
				if ($rs) {
					$this->GetRow(1);
					while (!$rs->EOF) {
						$this->AccumulateGrandSummary();
						$this->GetRow(2);
					}
					$rs->Close();
				}
			}
			$this->GrandSummarySetup = TRUE; // No need to set up again
		}

		// Call Row_Rendering event
		$this->Row_Rendering();

		//
		// Render view codes
		//

		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
			$this->RowAttrs["class"] = ($this->RowTotalType == EWR_ROWTOTAL_PAGE || $this->RowTotalType == EWR_ROWTOTAL_GRAND) ? "ewRptGrpAggregate" : "ewRptGrpSummary" . $this->RowGroupLevel; // Set up row class

			// ID
			$this->ID->HrefValue = "";

			// qa
			$this->qa->HrefValue = "";

			// ra
			$this->ra->HrefValue = "";

			// ma
			$this->ma->HrefValue = "";

			// qb
			$this->qb->HrefValue = "";

			// rb
			$this->rb->HrefValue = "";

			// mb
			$this->mb->HrefValue = "";

			// qc
			$this->qc->HrefValue = "";

			// rc
			$this->rc->HrefValue = "";

			// mc
			$this->mc->HrefValue = "";

			// qd
			$this->qd->HrefValue = "";

			// rd
			$this->rd->HrefValue = "";

			// md
			$this->md->HrefValue = "";

			// qe
			$this->qe->HrefValue = "";

			// re
			$this->re->HrefValue = "";

			// me
			$this->me->HrefValue = "";

			// qf
			$this->qf->HrefValue = "";

			// rf
			$this->rf->HrefValue = "";

			// mf
			$this->mf->HrefValue = "";

			// qg
			$this->qg->HrefValue = "";

			// rg
			$this->rg->HrefValue = "";

			// mg
			$this->mg->HrefValue = "";

			// qh
			$this->qh->HrefValue = "";

			// rh
			$this->rh->HrefValue = "";

			// mh
			$this->mh->HrefValue = "";

			// qi
			$this->qi->HrefValue = "";

			// ri
			$this->ri->HrefValue = "";

			// mi
			$this->mi->HrefValue = "";

			// qj
			$this->qj->HrefValue = "";

			// rj
			$this->rj->HrefValue = "";

			// mj
			$this->mj->HrefValue = "";

			// qk
			$this->qk->HrefValue = "";

			// rk
			$this->rk->HrefValue = "";

			// mk
			$this->mk->HrefValue = "";

			// ql
			$this->ql->HrefValue = "";

			// rl
			$this->rl->HrefValue = "";

			// ml
			$this->ml->HrefValue = "";
		} else {

			// ID
			$this->ID->ViewValue = $this->ID->CurrentValue;
			$this->ID->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qa
			$this->qa->ViewValue = $this->qa->CurrentValue;
			$this->qa->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ra
			$this->ra->ViewValue = $this->ra->CurrentValue;
			$this->ra->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ma
			$this->ma->ViewValue = $this->ma->CurrentValue;
			$this->ma->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qb
			$this->qb->ViewValue = $this->qb->CurrentValue;
			$this->qb->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rb
			$this->rb->ViewValue = $this->rb->CurrentValue;
			$this->rb->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mb
			$this->mb->ViewValue = $this->mb->CurrentValue;
			$this->mb->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qc
			$this->qc->ViewValue = $this->qc->CurrentValue;
			$this->qc->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rc
			$this->rc->ViewValue = $this->rc->CurrentValue;
			$this->rc->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mc
			$this->mc->ViewValue = $this->mc->CurrentValue;
			$this->mc->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qd
			$this->qd->ViewValue = $this->qd->CurrentValue;
			$this->qd->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rd
			$this->rd->ViewValue = $this->rd->CurrentValue;
			$this->rd->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// md
			$this->md->ViewValue = $this->md->CurrentValue;
			$this->md->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qe
			$this->qe->ViewValue = $this->qe->CurrentValue;
			$this->qe->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// re
			$this->re->ViewValue = $this->re->CurrentValue;
			$this->re->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// me
			$this->me->ViewValue = $this->me->CurrentValue;
			$this->me->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qf
			$this->qf->ViewValue = $this->qf->CurrentValue;
			$this->qf->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rf
			$this->rf->ViewValue = $this->rf->CurrentValue;
			$this->rf->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mf
			$this->mf->ViewValue = $this->mf->CurrentValue;
			$this->mf->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qg
			$this->qg->ViewValue = $this->qg->CurrentValue;
			$this->qg->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rg
			$this->rg->ViewValue = $this->rg->CurrentValue;
			$this->rg->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mg
			$this->mg->ViewValue = $this->mg->CurrentValue;
			$this->mg->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qh
			$this->qh->ViewValue = $this->qh->CurrentValue;
			$this->qh->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rh
			$this->rh->ViewValue = $this->rh->CurrentValue;
			$this->rh->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mh
			$this->mh->ViewValue = $this->mh->CurrentValue;
			$this->mh->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qi
			$this->qi->ViewValue = $this->qi->CurrentValue;
			$this->qi->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ri
			$this->ri->ViewValue = $this->ri->CurrentValue;
			$this->ri->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mi
			$this->mi->ViewValue = $this->mi->CurrentValue;
			$this->mi->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qj
			$this->qj->ViewValue = $this->qj->CurrentValue;
			$this->qj->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rj
			$this->rj->ViewValue = $this->rj->CurrentValue;
			$this->rj->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mj
			$this->mj->ViewValue = $this->mj->CurrentValue;
			$this->mj->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// qk
			$this->qk->ViewValue = $this->qk->CurrentValue;
			$this->qk->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rk
			$this->rk->ViewValue = $this->rk->CurrentValue;
			$this->rk->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// mk
			$this->mk->ViewValue = $this->mk->CurrentValue;
			$this->mk->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ql
			$this->ql->ViewValue = $this->ql->CurrentValue;
			$this->ql->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// rl
			$this->rl->ViewValue = $this->rl->CurrentValue;
			$this->rl->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ml
			$this->ml->ViewValue = $this->ml->CurrentValue;
			$this->ml->CellAttrs["class"] = ($this->RecCount % 2 <> 1) ? "ewTableAltRow" : "ewTableRow";

			// ID
			$this->ID->HrefValue = "";

			// qa
			$this->qa->HrefValue = "";

			// ra
			$this->ra->HrefValue = "";

			// ma
			$this->ma->HrefValue = "";

			// qb
			$this->qb->HrefValue = "";

			// rb
			$this->rb->HrefValue = "";

			// mb
			$this->mb->HrefValue = "";

			// qc
			$this->qc->HrefValue = "";

			// rc
			$this->rc->HrefValue = "";

			// mc
			$this->mc->HrefValue = "";

			// qd
			$this->qd->HrefValue = "";

			// rd
			$this->rd->HrefValue = "";

			// md
			$this->md->HrefValue = "";

			// qe
			$this->qe->HrefValue = "";

			// re
			$this->re->HrefValue = "";

			// me
			$this->me->HrefValue = "";

			// qf
			$this->qf->HrefValue = "";

			// rf
			$this->rf->HrefValue = "";

			// mf
			$this->mf->HrefValue = "";

			// qg
			$this->qg->HrefValue = "";

			// rg
			$this->rg->HrefValue = "";

			// mg
			$this->mg->HrefValue = "";

			// qh
			$this->qh->HrefValue = "";

			// rh
			$this->rh->HrefValue = "";

			// mh
			$this->mh->HrefValue = "";

			// qi
			$this->qi->HrefValue = "";

			// ri
			$this->ri->HrefValue = "";

			// mi
			$this->mi->HrefValue = "";

			// qj
			$this->qj->HrefValue = "";

			// rj
			$this->rj->HrefValue = "";

			// mj
			$this->mj->HrefValue = "";

			// qk
			$this->qk->HrefValue = "";

			// rk
			$this->rk->HrefValue = "";

			// mk
			$this->mk->HrefValue = "";

			// ql
			$this->ql->HrefValue = "";

			// rl
			$this->rl->HrefValue = "";

			// ml
			$this->ml->HrefValue = "";
		}

		// Call Cell_Rendered event
		if ($this->RowType == EWR_ROWTYPE_TOTAL) { // Summary row
		} else {

			// ID
			$CurrentValue = $this->ID->CurrentValue;
			$ViewValue = &$this->ID->ViewValue;
			$ViewAttrs = &$this->ID->ViewAttrs;
			$CellAttrs = &$this->ID->CellAttrs;
			$HrefValue = &$this->ID->HrefValue;
			$LinkAttrs = &$this->ID->LinkAttrs;
			$this->Cell_Rendered($this->ID, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qa
			$CurrentValue = $this->qa->CurrentValue;
			$ViewValue = &$this->qa->ViewValue;
			$ViewAttrs = &$this->qa->ViewAttrs;
			$CellAttrs = &$this->qa->CellAttrs;
			$HrefValue = &$this->qa->HrefValue;
			$LinkAttrs = &$this->qa->LinkAttrs;
			$this->Cell_Rendered($this->qa, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ra
			$CurrentValue = $this->ra->CurrentValue;
			$ViewValue = &$this->ra->ViewValue;
			$ViewAttrs = &$this->ra->ViewAttrs;
			$CellAttrs = &$this->ra->CellAttrs;
			$HrefValue = &$this->ra->HrefValue;
			$LinkAttrs = &$this->ra->LinkAttrs;
			$this->Cell_Rendered($this->ra, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ma
			$CurrentValue = $this->ma->CurrentValue;
			$ViewValue = &$this->ma->ViewValue;
			$ViewAttrs = &$this->ma->ViewAttrs;
			$CellAttrs = &$this->ma->CellAttrs;
			$HrefValue = &$this->ma->HrefValue;
			$LinkAttrs = &$this->ma->LinkAttrs;
			$this->Cell_Rendered($this->ma, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qb
			$CurrentValue = $this->qb->CurrentValue;
			$ViewValue = &$this->qb->ViewValue;
			$ViewAttrs = &$this->qb->ViewAttrs;
			$CellAttrs = &$this->qb->CellAttrs;
			$HrefValue = &$this->qb->HrefValue;
			$LinkAttrs = &$this->qb->LinkAttrs;
			$this->Cell_Rendered($this->qb, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rb
			$CurrentValue = $this->rb->CurrentValue;
			$ViewValue = &$this->rb->ViewValue;
			$ViewAttrs = &$this->rb->ViewAttrs;
			$CellAttrs = &$this->rb->CellAttrs;
			$HrefValue = &$this->rb->HrefValue;
			$LinkAttrs = &$this->rb->LinkAttrs;
			$this->Cell_Rendered($this->rb, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mb
			$CurrentValue = $this->mb->CurrentValue;
			$ViewValue = &$this->mb->ViewValue;
			$ViewAttrs = &$this->mb->ViewAttrs;
			$CellAttrs = &$this->mb->CellAttrs;
			$HrefValue = &$this->mb->HrefValue;
			$LinkAttrs = &$this->mb->LinkAttrs;
			$this->Cell_Rendered($this->mb, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qc
			$CurrentValue = $this->qc->CurrentValue;
			$ViewValue = &$this->qc->ViewValue;
			$ViewAttrs = &$this->qc->ViewAttrs;
			$CellAttrs = &$this->qc->CellAttrs;
			$HrefValue = &$this->qc->HrefValue;
			$LinkAttrs = &$this->qc->LinkAttrs;
			$this->Cell_Rendered($this->qc, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rc
			$CurrentValue = $this->rc->CurrentValue;
			$ViewValue = &$this->rc->ViewValue;
			$ViewAttrs = &$this->rc->ViewAttrs;
			$CellAttrs = &$this->rc->CellAttrs;
			$HrefValue = &$this->rc->HrefValue;
			$LinkAttrs = &$this->rc->LinkAttrs;
			$this->Cell_Rendered($this->rc, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mc
			$CurrentValue = $this->mc->CurrentValue;
			$ViewValue = &$this->mc->ViewValue;
			$ViewAttrs = &$this->mc->ViewAttrs;
			$CellAttrs = &$this->mc->CellAttrs;
			$HrefValue = &$this->mc->HrefValue;
			$LinkAttrs = &$this->mc->LinkAttrs;
			$this->Cell_Rendered($this->mc, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qd
			$CurrentValue = $this->qd->CurrentValue;
			$ViewValue = &$this->qd->ViewValue;
			$ViewAttrs = &$this->qd->ViewAttrs;
			$CellAttrs = &$this->qd->CellAttrs;
			$HrefValue = &$this->qd->HrefValue;
			$LinkAttrs = &$this->qd->LinkAttrs;
			$this->Cell_Rendered($this->qd, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rd
			$CurrentValue = $this->rd->CurrentValue;
			$ViewValue = &$this->rd->ViewValue;
			$ViewAttrs = &$this->rd->ViewAttrs;
			$CellAttrs = &$this->rd->CellAttrs;
			$HrefValue = &$this->rd->HrefValue;
			$LinkAttrs = &$this->rd->LinkAttrs;
			$this->Cell_Rendered($this->rd, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// md
			$CurrentValue = $this->md->CurrentValue;
			$ViewValue = &$this->md->ViewValue;
			$ViewAttrs = &$this->md->ViewAttrs;
			$CellAttrs = &$this->md->CellAttrs;
			$HrefValue = &$this->md->HrefValue;
			$LinkAttrs = &$this->md->LinkAttrs;
			$this->Cell_Rendered($this->md, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qe
			$CurrentValue = $this->qe->CurrentValue;
			$ViewValue = &$this->qe->ViewValue;
			$ViewAttrs = &$this->qe->ViewAttrs;
			$CellAttrs = &$this->qe->CellAttrs;
			$HrefValue = &$this->qe->HrefValue;
			$LinkAttrs = &$this->qe->LinkAttrs;
			$this->Cell_Rendered($this->qe, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// re
			$CurrentValue = $this->re->CurrentValue;
			$ViewValue = &$this->re->ViewValue;
			$ViewAttrs = &$this->re->ViewAttrs;
			$CellAttrs = &$this->re->CellAttrs;
			$HrefValue = &$this->re->HrefValue;
			$LinkAttrs = &$this->re->LinkAttrs;
			$this->Cell_Rendered($this->re, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// me
			$CurrentValue = $this->me->CurrentValue;
			$ViewValue = &$this->me->ViewValue;
			$ViewAttrs = &$this->me->ViewAttrs;
			$CellAttrs = &$this->me->CellAttrs;
			$HrefValue = &$this->me->HrefValue;
			$LinkAttrs = &$this->me->LinkAttrs;
			$this->Cell_Rendered($this->me, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qf
			$CurrentValue = $this->qf->CurrentValue;
			$ViewValue = &$this->qf->ViewValue;
			$ViewAttrs = &$this->qf->ViewAttrs;
			$CellAttrs = &$this->qf->CellAttrs;
			$HrefValue = &$this->qf->HrefValue;
			$LinkAttrs = &$this->qf->LinkAttrs;
			$this->Cell_Rendered($this->qf, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rf
			$CurrentValue = $this->rf->CurrentValue;
			$ViewValue = &$this->rf->ViewValue;
			$ViewAttrs = &$this->rf->ViewAttrs;
			$CellAttrs = &$this->rf->CellAttrs;
			$HrefValue = &$this->rf->HrefValue;
			$LinkAttrs = &$this->rf->LinkAttrs;
			$this->Cell_Rendered($this->rf, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mf
			$CurrentValue = $this->mf->CurrentValue;
			$ViewValue = &$this->mf->ViewValue;
			$ViewAttrs = &$this->mf->ViewAttrs;
			$CellAttrs = &$this->mf->CellAttrs;
			$HrefValue = &$this->mf->HrefValue;
			$LinkAttrs = &$this->mf->LinkAttrs;
			$this->Cell_Rendered($this->mf, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qg
			$CurrentValue = $this->qg->CurrentValue;
			$ViewValue = &$this->qg->ViewValue;
			$ViewAttrs = &$this->qg->ViewAttrs;
			$CellAttrs = &$this->qg->CellAttrs;
			$HrefValue = &$this->qg->HrefValue;
			$LinkAttrs = &$this->qg->LinkAttrs;
			$this->Cell_Rendered($this->qg, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rg
			$CurrentValue = $this->rg->CurrentValue;
			$ViewValue = &$this->rg->ViewValue;
			$ViewAttrs = &$this->rg->ViewAttrs;
			$CellAttrs = &$this->rg->CellAttrs;
			$HrefValue = &$this->rg->HrefValue;
			$LinkAttrs = &$this->rg->LinkAttrs;
			$this->Cell_Rendered($this->rg, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mg
			$CurrentValue = $this->mg->CurrentValue;
			$ViewValue = &$this->mg->ViewValue;
			$ViewAttrs = &$this->mg->ViewAttrs;
			$CellAttrs = &$this->mg->CellAttrs;
			$HrefValue = &$this->mg->HrefValue;
			$LinkAttrs = &$this->mg->LinkAttrs;
			$this->Cell_Rendered($this->mg, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qh
			$CurrentValue = $this->qh->CurrentValue;
			$ViewValue = &$this->qh->ViewValue;
			$ViewAttrs = &$this->qh->ViewAttrs;
			$CellAttrs = &$this->qh->CellAttrs;
			$HrefValue = &$this->qh->HrefValue;
			$LinkAttrs = &$this->qh->LinkAttrs;
			$this->Cell_Rendered($this->qh, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rh
			$CurrentValue = $this->rh->CurrentValue;
			$ViewValue = &$this->rh->ViewValue;
			$ViewAttrs = &$this->rh->ViewAttrs;
			$CellAttrs = &$this->rh->CellAttrs;
			$HrefValue = &$this->rh->HrefValue;
			$LinkAttrs = &$this->rh->LinkAttrs;
			$this->Cell_Rendered($this->rh, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mh
			$CurrentValue = $this->mh->CurrentValue;
			$ViewValue = &$this->mh->ViewValue;
			$ViewAttrs = &$this->mh->ViewAttrs;
			$CellAttrs = &$this->mh->CellAttrs;
			$HrefValue = &$this->mh->HrefValue;
			$LinkAttrs = &$this->mh->LinkAttrs;
			$this->Cell_Rendered($this->mh, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qi
			$CurrentValue = $this->qi->CurrentValue;
			$ViewValue = &$this->qi->ViewValue;
			$ViewAttrs = &$this->qi->ViewAttrs;
			$CellAttrs = &$this->qi->CellAttrs;
			$HrefValue = &$this->qi->HrefValue;
			$LinkAttrs = &$this->qi->LinkAttrs;
			$this->Cell_Rendered($this->qi, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ri
			$CurrentValue = $this->ri->CurrentValue;
			$ViewValue = &$this->ri->ViewValue;
			$ViewAttrs = &$this->ri->ViewAttrs;
			$CellAttrs = &$this->ri->CellAttrs;
			$HrefValue = &$this->ri->HrefValue;
			$LinkAttrs = &$this->ri->LinkAttrs;
			$this->Cell_Rendered($this->ri, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mi
			$CurrentValue = $this->mi->CurrentValue;
			$ViewValue = &$this->mi->ViewValue;
			$ViewAttrs = &$this->mi->ViewAttrs;
			$CellAttrs = &$this->mi->CellAttrs;
			$HrefValue = &$this->mi->HrefValue;
			$LinkAttrs = &$this->mi->LinkAttrs;
			$this->Cell_Rendered($this->mi, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qj
			$CurrentValue = $this->qj->CurrentValue;
			$ViewValue = &$this->qj->ViewValue;
			$ViewAttrs = &$this->qj->ViewAttrs;
			$CellAttrs = &$this->qj->CellAttrs;
			$HrefValue = &$this->qj->HrefValue;
			$LinkAttrs = &$this->qj->LinkAttrs;
			$this->Cell_Rendered($this->qj, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rj
			$CurrentValue = $this->rj->CurrentValue;
			$ViewValue = &$this->rj->ViewValue;
			$ViewAttrs = &$this->rj->ViewAttrs;
			$CellAttrs = &$this->rj->CellAttrs;
			$HrefValue = &$this->rj->HrefValue;
			$LinkAttrs = &$this->rj->LinkAttrs;
			$this->Cell_Rendered($this->rj, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mj
			$CurrentValue = $this->mj->CurrentValue;
			$ViewValue = &$this->mj->ViewValue;
			$ViewAttrs = &$this->mj->ViewAttrs;
			$CellAttrs = &$this->mj->CellAttrs;
			$HrefValue = &$this->mj->HrefValue;
			$LinkAttrs = &$this->mj->LinkAttrs;
			$this->Cell_Rendered($this->mj, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// qk
			$CurrentValue = $this->qk->CurrentValue;
			$ViewValue = &$this->qk->ViewValue;
			$ViewAttrs = &$this->qk->ViewAttrs;
			$CellAttrs = &$this->qk->CellAttrs;
			$HrefValue = &$this->qk->HrefValue;
			$LinkAttrs = &$this->qk->LinkAttrs;
			$this->Cell_Rendered($this->qk, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rk
			$CurrentValue = $this->rk->CurrentValue;
			$ViewValue = &$this->rk->ViewValue;
			$ViewAttrs = &$this->rk->ViewAttrs;
			$CellAttrs = &$this->rk->CellAttrs;
			$HrefValue = &$this->rk->HrefValue;
			$LinkAttrs = &$this->rk->LinkAttrs;
			$this->Cell_Rendered($this->rk, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// mk
			$CurrentValue = $this->mk->CurrentValue;
			$ViewValue = &$this->mk->ViewValue;
			$ViewAttrs = &$this->mk->ViewAttrs;
			$CellAttrs = &$this->mk->CellAttrs;
			$HrefValue = &$this->mk->HrefValue;
			$LinkAttrs = &$this->mk->LinkAttrs;
			$this->Cell_Rendered($this->mk, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ql
			$CurrentValue = $this->ql->CurrentValue;
			$ViewValue = &$this->ql->ViewValue;
			$ViewAttrs = &$this->ql->ViewAttrs;
			$CellAttrs = &$this->ql->CellAttrs;
			$HrefValue = &$this->ql->HrefValue;
			$LinkAttrs = &$this->ql->LinkAttrs;
			$this->Cell_Rendered($this->ql, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// rl
			$CurrentValue = $this->rl->CurrentValue;
			$ViewValue = &$this->rl->ViewValue;
			$ViewAttrs = &$this->rl->ViewAttrs;
			$CellAttrs = &$this->rl->CellAttrs;
			$HrefValue = &$this->rl->HrefValue;
			$LinkAttrs = &$this->rl->LinkAttrs;
			$this->Cell_Rendered($this->rl, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);

			// ml
			$CurrentValue = $this->ml->CurrentValue;
			$ViewValue = &$this->ml->ViewValue;
			$ViewAttrs = &$this->ml->ViewAttrs;
			$CellAttrs = &$this->ml->CellAttrs;
			$HrefValue = &$this->ml->HrefValue;
			$LinkAttrs = &$this->ml->LinkAttrs;
			$this->Cell_Rendered($this->ml, $CurrentValue, $ViewValue, $ViewAttrs, $CellAttrs, $HrefValue, $LinkAttrs);
		}

		// Call Row_Rendered event
		$this->Row_Rendered();
		$this->SetupFieldCount();
	}

	// Setup field count
	function SetupFieldCount() {
		$this->GrpFldCount = 0;
		$this->SubGrpFldCount = 0;
		$this->DtlFldCount = 0;
		if ($this->ID->Visible) $this->DtlFldCount += 1;
		if ($this->qa->Visible) $this->DtlFldCount += 1;
		if ($this->ra->Visible) $this->DtlFldCount += 1;
		if ($this->ma->Visible) $this->DtlFldCount += 1;
		if ($this->qb->Visible) $this->DtlFldCount += 1;
		if ($this->rb->Visible) $this->DtlFldCount += 1;
		if ($this->mb->Visible) $this->DtlFldCount += 1;
		if ($this->qc->Visible) $this->DtlFldCount += 1;
		if ($this->rc->Visible) $this->DtlFldCount += 1;
		if ($this->mc->Visible) $this->DtlFldCount += 1;
		if ($this->qd->Visible) $this->DtlFldCount += 1;
		if ($this->rd->Visible) $this->DtlFldCount += 1;
		if ($this->md->Visible) $this->DtlFldCount += 1;
		if ($this->qe->Visible) $this->DtlFldCount += 1;
		if ($this->re->Visible) $this->DtlFldCount += 1;
		if ($this->me->Visible) $this->DtlFldCount += 1;
		if ($this->qf->Visible) $this->DtlFldCount += 1;
		if ($this->rf->Visible) $this->DtlFldCount += 1;
		if ($this->mf->Visible) $this->DtlFldCount += 1;
		if ($this->qg->Visible) $this->DtlFldCount += 1;
		if ($this->rg->Visible) $this->DtlFldCount += 1;
		if ($this->mg->Visible) $this->DtlFldCount += 1;
		if ($this->qh->Visible) $this->DtlFldCount += 1;
		if ($this->rh->Visible) $this->DtlFldCount += 1;
		if ($this->mh->Visible) $this->DtlFldCount += 1;
		if ($this->qi->Visible) $this->DtlFldCount += 1;
		if ($this->ri->Visible) $this->DtlFldCount += 1;
		if ($this->mi->Visible) $this->DtlFldCount += 1;
		if ($this->qj->Visible) $this->DtlFldCount += 1;
		if ($this->rj->Visible) $this->DtlFldCount += 1;
		if ($this->mj->Visible) $this->DtlFldCount += 1;
		if ($this->qk->Visible) $this->DtlFldCount += 1;
		if ($this->rk->Visible) $this->DtlFldCount += 1;
		if ($this->mk->Visible) $this->DtlFldCount += 1;
		if ($this->ql->Visible) $this->DtlFldCount += 1;
		if ($this->rl->Visible) $this->DtlFldCount += 1;
		if ($this->ml->Visible) $this->DtlFldCount += 1;
	}

	// Set up Breadcrumb
	function SetupBreadcrumb() {
		global $ReportBreadcrumb;
		$ReportBreadcrumb = new crBreadcrumb();
		$url = substr(ewr_CurrentUrl(), strrpos(ewr_CurrentUrl(), "/")+1);
		$url = preg_replace('/\?cmd=reset(all){0,1}$/i', '', $url); // Remove cmd=reset / cmd=resetall
		$ReportBreadcrumb->Add("rpt", $this->TableVar, $url, "", $this->TableVar, TRUE);
	}

	function SetupExportOptionsExt() {
		global $ReportLanguage;
	}

	// Return popup filter
	function GetPopupFilter() {
		$sWrk = "";
		if ($this->DrillDown)
			return "";
		return $sWrk;
	}

	//-------------------------------------------------------------------------------
	// Function GetSort
	// - Return Sort parameters based on Sort Links clicked
	// - Variables setup: Session[EWR_TABLE_SESSION_ORDER_BY], Session["sort_Table_Field"]
	function GetSort() {
		if ($this->DrillDown)
			return "";

		// Check for a resetsort command
		if (strlen(@$_GET["cmd"]) > 0) {
			$sCmd = @$_GET["cmd"];
			if ($sCmd == "resetsort") {
				$this->setOrderBy("");
				$this->setStartGroup(1);
				$this->ID->setSort("");
				$this->qa->setSort("");
				$this->ra->setSort("");
				$this->ma->setSort("");
				$this->qb->setSort("");
				$this->rb->setSort("");
				$this->mb->setSort("");
				$this->qc->setSort("");
				$this->rc->setSort("");
				$this->mc->setSort("");
				$this->qd->setSort("");
				$this->rd->setSort("");
				$this->md->setSort("");
				$this->qe->setSort("");
				$this->re->setSort("");
				$this->me->setSort("");
				$this->qf->setSort("");
				$this->rf->setSort("");
				$this->mf->setSort("");
				$this->qg->setSort("");
				$this->rg->setSort("");
				$this->mg->setSort("");
				$this->qh->setSort("");
				$this->rh->setSort("");
				$this->mh->setSort("");
				$this->qi->setSort("");
				$this->ri->setSort("");
				$this->mi->setSort("");
				$this->qj->setSort("");
				$this->rj->setSort("");
				$this->mj->setSort("");
				$this->qk->setSort("");
				$this->rk->setSort("");
				$this->mk->setSort("");
				$this->ql->setSort("");
				$this->rl->setSort("");
				$this->ml->setSort("");
			}

		// Check for an Order parameter
		} elseif (@$_GET["order"] <> "") {
			$this->CurrentOrder = ewr_StripSlashes(@$_GET["order"]);
			$this->CurrentOrderType = @$_GET["ordertype"];
			$sSortSql = $this->SortSql();
			$this->setOrderBy($sSortSql);
			$this->setStartGroup(1);
		}
		return $this->getOrderBy();
	}

	// Page Load event
	function Page_Load() {

		//echo "Page Load";
	}

	// Page Unload event
	function Page_Unload() {

		//echo "Page Unload";
	}

	// Message Showing event
	// $type = ''|'success'|'failure'|'warning'
	function Message_Showing(&$msg, $type) {
		if ($type == 'success') {

			//$msg = "your success message";
		} elseif ($type == 'failure') {

			//$msg = "your failure message";
		} elseif ($type == 'warning') {

			//$msg = "your warning message";
		} else {

			//$msg = "your message";
		}
	}

	// Page Render event
	function Page_Render() {

		//echo "Page Render";
	}

	// Page Data Rendering event
	function Page_DataRendering(&$header) {

		// Example:
		//$header = "your header";

	}

	// Page Data Rendered event
	function Page_DataRendered(&$footer) {

		// Example:
		//$footer = "your footer";

	}

	// Form Custom Validate event
	function Form_CustomValidate(&$CustomError) {

		// Return error message in CustomError
		return TRUE;
	}
}
?>
<?php ewr_Header(FALSE) ?>
<?php

// Create page object
if (!isset($heuristic_rpt)) $heuristic_rpt = new crheuristic_rpt();
if (isset($Page)) $OldPage = $Page;
$Page = &$heuristic_rpt;

// Page init
$Page->Page_Init();

// Page main
$Page->Page_Main();

// Global Page Rendering event (in ewrusrfn*.php)
Page_Rendering();

// Page Rendering event
$Page->Page_Render();
?>
<?php include_once "phprptinc/header.php" ?>
<script type="text/javascript">

// Create page object
var heuristic_rpt = new ewr_Page("heuristic_rpt");

// Page properties
heuristic_rpt.PageID = "rpt"; // Page ID
var EWR_PAGE_ID = heuristic_rpt.PageID;

// Extend page with Chart_Rendering function
heuristic_rpt.Chart_Rendering = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }

// Extend page with Chart_Rendered function
heuristic_rpt.Chart_Rendered = 
 function(chart, chartid) { // DO NOT CHANGE THIS LINE!

 	//alert(chartid);
 }
</script>
<?php if (!$Page->DrillDown) { ?>
<?php } ?>
<?php if (!$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your client script here, no need to add script tags.
</script>
<?php } ?>
<!-- container (begin) -->
<div id="ewContainer" class="ewContainer">
<!-- top container (begin) -->
<div id="ewTop" class="ewTop">
<a id="top"></a>
<!-- top slot -->
<div class="ewToolbar">
<?php if (!$Page->DrillDown || !$Page->DrillDownInPanel) { ?>
<?php if ($ReportBreadcrumb) $ReportBreadcrumb->Render(); ?>
<?php } ?>
<?php
if (!$Page->DrillDownInPanel) {
	$Page->ExportOptions->Render("body");
	$Page->SearchOptions->Render("body");
	$Page->FilterOptions->Render("body");
}
?>
<?php if (!$Page->DrillDown) { ?>
<?php echo $ReportLanguage->SelectionForm(); ?>
<?php } ?>
<div class="clearfix"></div>
</div>
<?php $Page->ShowPageHeader(); ?>
<?php $Page->ShowMessage(); ?>
</div>
<!-- top container (end) -->
	<!-- left container (begin) -->
	<div id="ewLeft" class="ewLeft">
	<!-- Left slot -->
	</div>
	<!-- left container (end) -->
	<!-- center container - report (begin) -->
	<div id="ewCenter" class="ewCenter">
	<!-- center slot -->
<!-- summary report starts -->
<div id="report_summary">
<?php

// Set the last group to display if not export all
if ($Page->ExportAll && $Page->Export <> "") {
	$Page->StopGrp = $Page->TotalGrps;
} else {
	$Page->StopGrp = $Page->StartGrp + $Page->DisplayGrps - 1;
}

// Stop group <= total number of groups
if (intval($Page->StopGrp) > intval($Page->TotalGrps))
	$Page->StopGrp = $Page->TotalGrps;
$Page->RecCount = 0;
$Page->RecIndex = 0;

// Get first row
if ($Page->TotalGrps > 0) {
	$Page->GetRow(1);
	$Page->GrpCount = 1;
}
$Page->GrpIdx = ewr_InitArray(2, -1);
$Page->GrpIdx[0] = -1;
$Page->GrpIdx[1] = $Page->StopGrp - $Page->StartGrp + 1;
while ($rs && !$rs->EOF && $Page->GrpCount <= $Page->DisplayGrps || $Page->ShowHeader) {

	// Show dummy header for custom template
	// Show header

	if ($Page->ShowHeader) {
?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<thead>
	<!-- Table header -->
	<tr class="ewTableHeader">
<?php if ($Page->ID->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ID"><div class="heuristic_ID"><span class="ewTableHeaderCaption"><?php echo $Page->ID->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ID">
<?php if ($Page->SortUrl($Page->ID) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_ID">
			<span class="ewTableHeaderCaption"><?php echo $Page->ID->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_ID" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ID) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ID->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ID->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ID->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qa->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qa"><div class="heuristic_qa"><span class="ewTableHeaderCaption"><?php echo $Page->qa->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qa">
<?php if ($Page->SortUrl($Page->qa) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qa">
			<span class="ewTableHeaderCaption"><?php echo $Page->qa->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qa" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qa) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qa->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qa->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qa->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ra->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ra"><div class="heuristic_ra"><span class="ewTableHeaderCaption"><?php echo $Page->ra->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ra">
<?php if ($Page->SortUrl($Page->ra) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_ra">
			<span class="ewTableHeaderCaption"><?php echo $Page->ra->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_ra" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ra) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ra->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ra->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ra->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ma->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ma"><div class="heuristic_ma"><span class="ewTableHeaderCaption"><?php echo $Page->ma->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ma">
<?php if ($Page->SortUrl($Page->ma) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_ma">
			<span class="ewTableHeaderCaption"><?php echo $Page->ma->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_ma" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ma) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ma->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ma->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ma->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qb->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qb"><div class="heuristic_qb"><span class="ewTableHeaderCaption"><?php echo $Page->qb->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qb">
<?php if ($Page->SortUrl($Page->qb) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qb">
			<span class="ewTableHeaderCaption"><?php echo $Page->qb->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qb" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qb) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qb->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rb->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rb"><div class="heuristic_rb"><span class="ewTableHeaderCaption"><?php echo $Page->rb->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rb">
<?php if ($Page->SortUrl($Page->rb) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rb">
			<span class="ewTableHeaderCaption"><?php echo $Page->rb->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rb" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rb) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rb->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mb->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mb"><div class="heuristic_mb"><span class="ewTableHeaderCaption"><?php echo $Page->mb->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mb">
<?php if ($Page->SortUrl($Page->mb) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mb">
			<span class="ewTableHeaderCaption"><?php echo $Page->mb->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mb" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mb) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mb->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mb->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mb->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qc->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qc"><div class="heuristic_qc"><span class="ewTableHeaderCaption"><?php echo $Page->qc->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qc">
<?php if ($Page->SortUrl($Page->qc) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qc">
			<span class="ewTableHeaderCaption"><?php echo $Page->qc->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qc" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qc) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qc->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rc->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rc"><div class="heuristic_rc"><span class="ewTableHeaderCaption"><?php echo $Page->rc->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rc">
<?php if ($Page->SortUrl($Page->rc) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rc">
			<span class="ewTableHeaderCaption"><?php echo $Page->rc->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rc" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rc) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rc->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mc->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mc"><div class="heuristic_mc"><span class="ewTableHeaderCaption"><?php echo $Page->mc->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mc">
<?php if ($Page->SortUrl($Page->mc) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mc">
			<span class="ewTableHeaderCaption"><?php echo $Page->mc->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mc" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mc) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mc->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mc->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mc->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qd->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qd"><div class="heuristic_qd"><span class="ewTableHeaderCaption"><?php echo $Page->qd->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qd">
<?php if ($Page->SortUrl($Page->qd) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qd">
			<span class="ewTableHeaderCaption"><?php echo $Page->qd->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qd" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qd) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qd->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qd->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qd->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rd->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rd"><div class="heuristic_rd"><span class="ewTableHeaderCaption"><?php echo $Page->rd->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rd">
<?php if ($Page->SortUrl($Page->rd) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rd">
			<span class="ewTableHeaderCaption"><?php echo $Page->rd->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rd" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rd) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rd->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rd->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rd->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->md->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="md"><div class="heuristic_md"><span class="ewTableHeaderCaption"><?php echo $Page->md->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="md">
<?php if ($Page->SortUrl($Page->md) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_md">
			<span class="ewTableHeaderCaption"><?php echo $Page->md->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_md" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->md) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->md->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->md->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->md->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qe->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qe"><div class="heuristic_qe"><span class="ewTableHeaderCaption"><?php echo $Page->qe->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qe">
<?php if ($Page->SortUrl($Page->qe) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qe">
			<span class="ewTableHeaderCaption"><?php echo $Page->qe->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qe" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qe) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qe->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qe->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qe->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->re->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="re"><div class="heuristic_re"><span class="ewTableHeaderCaption"><?php echo $Page->re->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="re">
<?php if ($Page->SortUrl($Page->re) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_re">
			<span class="ewTableHeaderCaption"><?php echo $Page->re->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_re" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->re) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->re->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->re->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->re->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->me->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="me"><div class="heuristic_me"><span class="ewTableHeaderCaption"><?php echo $Page->me->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="me">
<?php if ($Page->SortUrl($Page->me) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_me">
			<span class="ewTableHeaderCaption"><?php echo $Page->me->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_me" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->me) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->me->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->me->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->me->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qf->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qf"><div class="heuristic_qf"><span class="ewTableHeaderCaption"><?php echo $Page->qf->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qf">
<?php if ($Page->SortUrl($Page->qf) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qf">
			<span class="ewTableHeaderCaption"><?php echo $Page->qf->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qf" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qf) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qf->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qf->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qf->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rf->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rf"><div class="heuristic_rf"><span class="ewTableHeaderCaption"><?php echo $Page->rf->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rf">
<?php if ($Page->SortUrl($Page->rf) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rf">
			<span class="ewTableHeaderCaption"><?php echo $Page->rf->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rf" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rf) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rf->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rf->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rf->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mf->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mf"><div class="heuristic_mf"><span class="ewTableHeaderCaption"><?php echo $Page->mf->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mf">
<?php if ($Page->SortUrl($Page->mf) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mf">
			<span class="ewTableHeaderCaption"><?php echo $Page->mf->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mf" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mf) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mf->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mf->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mf->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qg->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qg"><div class="heuristic_qg"><span class="ewTableHeaderCaption"><?php echo $Page->qg->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qg">
<?php if ($Page->SortUrl($Page->qg) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qg">
			<span class="ewTableHeaderCaption"><?php echo $Page->qg->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qg" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qg) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qg->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qg->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qg->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rg->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rg"><div class="heuristic_rg"><span class="ewTableHeaderCaption"><?php echo $Page->rg->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rg">
<?php if ($Page->SortUrl($Page->rg) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rg">
			<span class="ewTableHeaderCaption"><?php echo $Page->rg->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rg" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rg) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rg->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rg->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rg->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mg->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mg"><div class="heuristic_mg"><span class="ewTableHeaderCaption"><?php echo $Page->mg->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mg">
<?php if ($Page->SortUrl($Page->mg) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mg">
			<span class="ewTableHeaderCaption"><?php echo $Page->mg->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mg" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mg) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mg->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mg->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mg->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qh->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qh"><div class="heuristic_qh"><span class="ewTableHeaderCaption"><?php echo $Page->qh->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qh">
<?php if ($Page->SortUrl($Page->qh) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qh">
			<span class="ewTableHeaderCaption"><?php echo $Page->qh->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qh" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qh) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qh->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rh->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rh"><div class="heuristic_rh"><span class="ewTableHeaderCaption"><?php echo $Page->rh->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rh">
<?php if ($Page->SortUrl($Page->rh) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rh">
			<span class="ewTableHeaderCaption"><?php echo $Page->rh->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rh" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rh) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rh->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mh->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mh"><div class="heuristic_mh"><span class="ewTableHeaderCaption"><?php echo $Page->mh->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mh">
<?php if ($Page->SortUrl($Page->mh) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mh">
			<span class="ewTableHeaderCaption"><?php echo $Page->mh->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mh" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mh) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mh->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mh->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mh->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qi->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qi"><div class="heuristic_qi"><span class="ewTableHeaderCaption"><?php echo $Page->qi->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qi">
<?php if ($Page->SortUrl($Page->qi) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qi">
			<span class="ewTableHeaderCaption"><?php echo $Page->qi->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qi" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qi) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qi->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ri->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ri"><div class="heuristic_ri"><span class="ewTableHeaderCaption"><?php echo $Page->ri->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ri">
<?php if ($Page->SortUrl($Page->ri) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_ri">
			<span class="ewTableHeaderCaption"><?php echo $Page->ri->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_ri" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ri) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ri->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ri->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ri->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mi->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mi"><div class="heuristic_mi"><span class="ewTableHeaderCaption"><?php echo $Page->mi->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mi">
<?php if ($Page->SortUrl($Page->mi) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mi">
			<span class="ewTableHeaderCaption"><?php echo $Page->mi->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mi" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mi) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mi->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mi->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mi->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qj->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qj"><div class="heuristic_qj"><span class="ewTableHeaderCaption"><?php echo $Page->qj->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qj">
<?php if ($Page->SortUrl($Page->qj) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qj">
			<span class="ewTableHeaderCaption"><?php echo $Page->qj->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qj" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qj) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qj->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qj->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qj->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rj->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rj"><div class="heuristic_rj"><span class="ewTableHeaderCaption"><?php echo $Page->rj->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rj">
<?php if ($Page->SortUrl($Page->rj) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rj">
			<span class="ewTableHeaderCaption"><?php echo $Page->rj->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rj" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rj) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rj->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rj->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rj->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mj->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mj"><div class="heuristic_mj"><span class="ewTableHeaderCaption"><?php echo $Page->mj->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mj">
<?php if ($Page->SortUrl($Page->mj) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mj">
			<span class="ewTableHeaderCaption"><?php echo $Page->mj->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mj" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mj) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mj->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mj->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mj->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->qk->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="qk"><div class="heuristic_qk"><span class="ewTableHeaderCaption"><?php echo $Page->qk->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="qk">
<?php if ($Page->SortUrl($Page->qk) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_qk">
			<span class="ewTableHeaderCaption"><?php echo $Page->qk->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_qk" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->qk) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->qk->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->qk->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->qk->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rk->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rk"><div class="heuristic_rk"><span class="ewTableHeaderCaption"><?php echo $Page->rk->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rk">
<?php if ($Page->SortUrl($Page->rk) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rk">
			<span class="ewTableHeaderCaption"><?php echo $Page->rk->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rk" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rk) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rk->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rk->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rk->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->mk->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="mk"><div class="heuristic_mk"><span class="ewTableHeaderCaption"><?php echo $Page->mk->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="mk">
<?php if ($Page->SortUrl($Page->mk) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_mk">
			<span class="ewTableHeaderCaption"><?php echo $Page->mk->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_mk" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->mk) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->mk->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->mk->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->mk->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ql->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ql"><div class="heuristic_ql"><span class="ewTableHeaderCaption"><?php echo $Page->ql->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ql">
<?php if ($Page->SortUrl($Page->ql) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_ql">
			<span class="ewTableHeaderCaption"><?php echo $Page->ql->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_ql" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ql) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ql->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ql->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ql->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->rl->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="rl"><div class="heuristic_rl"><span class="ewTableHeaderCaption"><?php echo $Page->rl->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="rl">
<?php if ($Page->SortUrl($Page->rl) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_rl">
			<span class="ewTableHeaderCaption"><?php echo $Page->rl->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_rl" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->rl) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->rl->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->rl->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->rl->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
<?php if ($Page->ml->Visible) { ?>
<?php if ($Page->Export <> "" || $Page->DrillDown) { ?>
	<td data-field="ml"><div class="heuristic_ml"><span class="ewTableHeaderCaption"><?php echo $Page->ml->FldCaption() ?></span></div></td>
<?php } else { ?>
	<td data-field="ml">
<?php if ($Page->SortUrl($Page->ml) == "") { ?>
		<div class="ewTableHeaderBtn heuristic_ml">
			<span class="ewTableHeaderCaption"><?php echo $Page->ml->FldCaption() ?></span>
		</div>
<?php } else { ?>
		<div class="ewTableHeaderBtn ewPointer heuristic_ml" onclick="ewr_Sort(event,'<?php echo $Page->SortUrl($Page->ml) ?>',0);">
			<span class="ewTableHeaderCaption"><?php echo $Page->ml->FldCaption() ?></span>
			<span class="ewTableHeaderSort"><?php if ($Page->ml->getSort() == "ASC") { ?><span class="caret ewSortUp"></span><?php } elseif ($Page->ml->getSort() == "DESC") { ?><span class="caret"></span><?php } ?></span>
		</div>
<?php } ?>
	</td>
<?php } ?>
<?php } ?>
	</tr>
</thead>
<tbody>
<?php
		if ($Page->TotalGrps == 0) break; // Show header only
		$Page->ShowHeader = FALSE;
	}
	$Page->RecCount++;
	$Page->RecIndex++;

		// Render detail row
		$Page->ResetAttrs();
		$Page->RowType = EWR_ROWTYPE_DETAIL;
		$Page->RenderRow();
?>
	<tr<?php echo $Page->RowAttributes(); ?>>
<?php if ($Page->ID->Visible) { ?>
		<td data-field="ID"<?php echo $Page->ID->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_ID"<?php echo $Page->ID->ViewAttributes() ?>><?php echo $Page->ID->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qa->Visible) { ?>
		<td data-field="qa"<?php echo $Page->qa->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qa"<?php echo $Page->qa->ViewAttributes() ?>><?php echo $Page->qa->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ra->Visible) { ?>
		<td data-field="ra"<?php echo $Page->ra->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_ra"<?php echo $Page->ra->ViewAttributes() ?>><?php echo $Page->ra->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ma->Visible) { ?>
		<td data-field="ma"<?php echo $Page->ma->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_ma"<?php echo $Page->ma->ViewAttributes() ?>><?php echo $Page->ma->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qb->Visible) { ?>
		<td data-field="qb"<?php echo $Page->qb->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qb"<?php echo $Page->qb->ViewAttributes() ?>><?php echo $Page->qb->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rb->Visible) { ?>
		<td data-field="rb"<?php echo $Page->rb->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rb"<?php echo $Page->rb->ViewAttributes() ?>><?php echo $Page->rb->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mb->Visible) { ?>
		<td data-field="mb"<?php echo $Page->mb->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mb"<?php echo $Page->mb->ViewAttributes() ?>><?php echo $Page->mb->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qc->Visible) { ?>
		<td data-field="qc"<?php echo $Page->qc->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qc"<?php echo $Page->qc->ViewAttributes() ?>><?php echo $Page->qc->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rc->Visible) { ?>
		<td data-field="rc"<?php echo $Page->rc->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rc"<?php echo $Page->rc->ViewAttributes() ?>><?php echo $Page->rc->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mc->Visible) { ?>
		<td data-field="mc"<?php echo $Page->mc->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mc"<?php echo $Page->mc->ViewAttributes() ?>><?php echo $Page->mc->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qd->Visible) { ?>
		<td data-field="qd"<?php echo $Page->qd->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qd"<?php echo $Page->qd->ViewAttributes() ?>><?php echo $Page->qd->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rd->Visible) { ?>
		<td data-field="rd"<?php echo $Page->rd->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rd"<?php echo $Page->rd->ViewAttributes() ?>><?php echo $Page->rd->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->md->Visible) { ?>
		<td data-field="md"<?php echo $Page->md->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_md"<?php echo $Page->md->ViewAttributes() ?>><?php echo $Page->md->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qe->Visible) { ?>
		<td data-field="qe"<?php echo $Page->qe->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qe"<?php echo $Page->qe->ViewAttributes() ?>><?php echo $Page->qe->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->re->Visible) { ?>
		<td data-field="re"<?php echo $Page->re->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_re"<?php echo $Page->re->ViewAttributes() ?>><?php echo $Page->re->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->me->Visible) { ?>
		<td data-field="me"<?php echo $Page->me->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_me"<?php echo $Page->me->ViewAttributes() ?>><?php echo $Page->me->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qf->Visible) { ?>
		<td data-field="qf"<?php echo $Page->qf->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qf"<?php echo $Page->qf->ViewAttributes() ?>><?php echo $Page->qf->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rf->Visible) { ?>
		<td data-field="rf"<?php echo $Page->rf->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rf"<?php echo $Page->rf->ViewAttributes() ?>><?php echo $Page->rf->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mf->Visible) { ?>
		<td data-field="mf"<?php echo $Page->mf->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mf"<?php echo $Page->mf->ViewAttributes() ?>><?php echo $Page->mf->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qg->Visible) { ?>
		<td data-field="qg"<?php echo $Page->qg->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qg"<?php echo $Page->qg->ViewAttributes() ?>><?php echo $Page->qg->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rg->Visible) { ?>
		<td data-field="rg"<?php echo $Page->rg->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rg"<?php echo $Page->rg->ViewAttributes() ?>><?php echo $Page->rg->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mg->Visible) { ?>
		<td data-field="mg"<?php echo $Page->mg->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mg"<?php echo $Page->mg->ViewAttributes() ?>><?php echo $Page->mg->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qh->Visible) { ?>
		<td data-field="qh"<?php echo $Page->qh->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qh"<?php echo $Page->qh->ViewAttributes() ?>><?php echo $Page->qh->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rh->Visible) { ?>
		<td data-field="rh"<?php echo $Page->rh->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rh"<?php echo $Page->rh->ViewAttributes() ?>><?php echo $Page->rh->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mh->Visible) { ?>
		<td data-field="mh"<?php echo $Page->mh->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mh"<?php echo $Page->mh->ViewAttributes() ?>><?php echo $Page->mh->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qi->Visible) { ?>
		<td data-field="qi"<?php echo $Page->qi->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qi"<?php echo $Page->qi->ViewAttributes() ?>><?php echo $Page->qi->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ri->Visible) { ?>
		<td data-field="ri"<?php echo $Page->ri->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_ri"<?php echo $Page->ri->ViewAttributes() ?>><?php echo $Page->ri->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mi->Visible) { ?>
		<td data-field="mi"<?php echo $Page->mi->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mi"<?php echo $Page->mi->ViewAttributes() ?>><?php echo $Page->mi->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qj->Visible) { ?>
		<td data-field="qj"<?php echo $Page->qj->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qj"<?php echo $Page->qj->ViewAttributes() ?>><?php echo $Page->qj->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rj->Visible) { ?>
		<td data-field="rj"<?php echo $Page->rj->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rj"<?php echo $Page->rj->ViewAttributes() ?>><?php echo $Page->rj->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mj->Visible) { ?>
		<td data-field="mj"<?php echo $Page->mj->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mj"<?php echo $Page->mj->ViewAttributes() ?>><?php echo $Page->mj->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->qk->Visible) { ?>
		<td data-field="qk"<?php echo $Page->qk->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_qk"<?php echo $Page->qk->ViewAttributes() ?>><?php echo $Page->qk->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rk->Visible) { ?>
		<td data-field="rk"<?php echo $Page->rk->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rk"<?php echo $Page->rk->ViewAttributes() ?>><?php echo $Page->rk->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->mk->Visible) { ?>
		<td data-field="mk"<?php echo $Page->mk->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_mk"<?php echo $Page->mk->ViewAttributes() ?>><?php echo $Page->mk->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ql->Visible) { ?>
		<td data-field="ql"<?php echo $Page->ql->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_ql"<?php echo $Page->ql->ViewAttributes() ?>><?php echo $Page->ql->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->rl->Visible) { ?>
		<td data-field="rl"<?php echo $Page->rl->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_rl"<?php echo $Page->rl->ViewAttributes() ?>><?php echo $Page->rl->ListViewValue() ?></span></td>
<?php } ?>
<?php if ($Page->ml->Visible) { ?>
		<td data-field="ml"<?php echo $Page->ml->CellAttributes() ?>>
<span data-class="tpx<?php echo $Page->RecCount ?>_<?php echo $Page->RecCount ?>_heuristic_ml"<?php echo $Page->ml->ViewAttributes() ?>><?php echo $Page->ml->ListViewValue() ?></span></td>
<?php } ?>
	</tr>
<?php

		// Accumulate page summary
		$Page->AccumulateSummary();

		// Get next record
		$Page->GetRow(2);
	$Page->GrpCount++;
} // End while
?>
<?php if ($Page->TotalGrps > 0) { ?>
</tbody>
<tfoot>
	</tfoot>
<?php } elseif (!$Page->ShowHeader && FALSE) { // No header displayed ?>
<div class="panel panel-default ewGrid"<?php echo $Page->ReportTableStyle ?>>
<!-- Report grid (begin) -->
<div class="<?php if (ewr_IsResponsiveLayout()) { echo "table-responsive "; } ?>ewGridMiddlePanel">
<table class="<?php echo $Page->ReportTableClass ?>">
<?php } ?>
<?php if ($Page->TotalGrps > 0 || FALSE) { // Show footer ?>
</table>
</div>
<?php if (!($Page->DrillDown && $Page->TotalGrps > 0)) { ?>
<div class="panel-footer ewGridLowerPanel">
<?php include "heuristicrptpager.php" ?>
<div class="clearfix"></div>
</div>
<?php } ?>
</div>
<?php } ?>
</div>
<!-- Summary Report Ends -->
	</div>
	<!-- center container - report (end) -->
	<!-- right container (begin) -->
	<div id="ewRight" class="ewRight">
	<!-- Right slot -->
	</div>
	<!-- right container (end) -->
<div class="clearfix"></div>
<!-- bottom container (begin) -->
<div id="ewBottom" class="ewBottom">
	<!-- Bottom slot -->
	</div>
<!-- Bottom Container (End) -->
</div>
<!-- Table Container (End) -->
<?php $Page->ShowPageFooter(); ?>
<?php if (EWR_DEBUG_ENABLED) echo ewr_DebugMsg(); ?>
<?php

// Close recordsets
if ($rsgrp) $rsgrp->Close();
if ($rs) $rs->Close();
?>
<?php if (!$Page->DrillDown) { ?>
<script type="text/javascript">

// Write your table-specific startup script here
// document.write("page loaded");

</script>
<?php } ?>
<?php include_once "phprptinc/footer.php" ?>
<?php
$Page->Page_Terminate();
if (isset($OldPage)) $Page = $OldPage;
?>
