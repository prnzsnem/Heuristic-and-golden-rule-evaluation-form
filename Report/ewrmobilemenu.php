<!-- Begin Main Menu -->
<?php

// Generate all menu items
$RootMenu->IsRoot = TRUE;
$RootMenu->AddMenuItem(1, "mmi_questions", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("1", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "questionsrpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(2, "mmi_heuristic", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("2", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "heuristicrpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(3, "mmi_golden", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("3", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "goldenrpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(4, "mmi_evaluationdata", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("4", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "evaluationdatarpt.php", -1, "", TRUE, FALSE);
$RootMenu->AddMenuItem(5, "mmi_data", $ReportLanguage->Phrase("SimpleReportMenuItemPrefix") . $ReportLanguage->MenuPhrase("5", "MenuText") . $ReportLanguage->Phrase("SimpleReportMenuItemSuffix"), "datarpt.php", -1, "", TRUE, FALSE);
$RootMenu->Render();
?>
<!-- End Main Menu -->
