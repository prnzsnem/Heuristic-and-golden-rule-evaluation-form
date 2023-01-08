<!-- Begin Main Menu -->
<div class="ewMenu">
<?php $RootMenu = new crMenu(EWR_MENUBAR_ID); ?>
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mi_questions", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("1", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "questionsrpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(2, "mi_heuristic", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("2", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "heuristicrpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mi_golden", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("3", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "goldenrpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mi_evaluationdata", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("4", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "evaluationdatarpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mi_data", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("5", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "datarpt.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
</div>
<!-- End Main Menu -->
