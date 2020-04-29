<?php
require ('pdf_header.php');
$pdf = new PDF();
$pdf->AliasNbPages();
if (($_GET['type']) && ($_GET['type'] == "download_child_card")) {
    $child_id = Input::get('child_id');
    $querychild = "SELECT * FROM child_protection_card WHERE Id='$child_id' order by Id desc LIMIT 1";


    $pdf->AddPage();
    $pdf->SetTextColor(0, 0, 0);
    $pdf->createHeader('BWINDI COMMUNITY HOSPITAL', 185);
    $pdf->Cell(0, 5, "(We treat but God heals)", 0, 1, "C");
    $pdf->Cell(0, 5, "CHILD PROTECTION CARD", 0, 1, "C");
    $pdf->Cell(0, 10, "", 0, 1, "C");

    $pdf->SetTextColor(0, 0, 0);
    $childData = DB::getInstance()->querySample($querychild);
    $pdf->SetDash(0.2, 1);
    $line_height = 44;
    $write_height = 0;
    foreach ($childData as $childdata) {
        $pdf->SetFont("Arial", "", 8);
        $pdf->Cell(20, 7, "Name:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 9, "$childdata->Child_Name");
        $pdf->Line(40, $line_height + 7, 170, $line_height + 7);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "YEAR OF BIRTH:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Year_Of_Birth");
        $pdf->Line(40, $line_height + 14, 170, $line_height + 14);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "NEXT OF KIN:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Next_Of_Kin");
        $pdf->Line(40, $line_height + 21, 170, $line_height + 21);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "SEX:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Gender");
        $pdf->Line(40, $line_height + 28, 170, $line_height + 28);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "RELIGION:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Religion");
        $pdf->Line(40, $line_height + 35, 170, $line_height + 35);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "TRIBE:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Tribe");
        $pdf->Line(40, $line_height + 42, 170, $line_height + 42);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "EDUCATION:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Education");
        $pdf->Line(40, $line_height + 49, 170, $line_height + 49);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "VILLAGE:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Village");
        $pdf->Line(40, $line_height + 56, 170, $line_height + 56);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "PARISH:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Parish");
        $pdf->Line(40, $line_height + 63, 170, $line_height + 63);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "SUB-COUNTY:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Sub_County");
        $pdf->Line(40, $line_height + 70, 170, $line_height + 70);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "DISTRICT:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->District");
        $pdf->Line(40, $line_height + 77, 170, $line_height + 77);

        $pdf->Cell(0, 7, "", 0, 1);
        $pdf->Cell(20, 7, "DISABILITY:  ", 0, 0, "L");
        $pdf->SetX(40);
        $pdf->Write($write_height + 8, "$childdata->Disability");
        $pdf->Line(40, $line_height + 84, 170, $line_height + 84);

        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(0, 10, "", 0, 1);
        $pdf->Cell(0, 7, "CASE HISTORY:  ", 0, 1, "C");
        $pdf->SetX(0);
        $pdf->SetFont("Arial", "", 8);
        $casehistory = strip_tags($childdata->Case_History);
        $pdf->Write($write_height + 10, "$casehistory");

        $pdf->SetFont("Arial", "B", 8);
        $pdf->Cell(0, 10, "", 0, 1);
        $pdf->Cell(20, 7, "OTHER RELATIVE HISTORY(Pregnancy, family planning,orphan,habits):  ", 0, 1, "L");
        $pdf->SetX(10);
        $pdf->SetFont("Arial", "U", 8);
        $pdf->Write($write_height + 10, "$childdata->Other_History");
    }
    $pdf->AutoPrint();
    $pdf->Output();
    //$pdf->output('D', 'PATIENT ADMISSION FACE SHEET' . ' ' . date("Ymdhis") . '.pdf');
} else if (($_GET['type']) && ($_GET['type'] == "export_child_protection_card")) {
    $child_protectioncardQuery = $crypt->decode($_GET['child_protectioncardQuery']);

    header("Content-Type: application/xls");
    header("Content-Disposition: attachment; filename=" . $admissionReportName . ".xls");
    header("Pragma: no-cache");
    header("Expires: 0");
    echo $admissionReportName . "<br/>";
    ?>
    <table style="font-size: 15px;" border="1">
        <tr>
            <th>NAME</th>
            <th>YEAR OF BIRTH </th>
            <th>NEXT OF KIN</th>
            <th>SEX</th>
            <th>RELIGION</th>
            <th>TRIBE</th>
            <th>EDUCATION</th>
            <th>VILLAGE</th>
            <th>PARISH</th>
            <th>SUBCOUNTY</th>
            <th>DISTRICT</th>
            <th>DISABILITY</th>
            <th style="width: 1000px;">CASE HISTORY</th>
            <th>OTHER HISTORY</th>
        </tr>

        <?php
        $childcard_list = DB::getInstance()->query($child_protectioncardQuery);
        foreach ($childcard_list->results() as $childcard):
            $provisional_diagnosis_array = unserialize($childcard->Provisional_Diagnosis);
            ?>
            <tr>
                <td><?php echo $childcard->Child_Name ?></td>
                <td><?php echo $childcard->Year_Of_Birth ?></td>
                <td><?php echo $childcard->Next_Of_Kin ?></td>
                <td><?php echo $childcard->Gender ?></td>
                <td><?php echo $childcard->Religion ?></td>
                <td><?php echo $childcard->Tribe ?></td>
                <td><?php echo $childcard->Education ?></td>
                <td><?php echo $childcard->Village ?></td>
                <td><?php echo $childcard->Parish ?></td>
                <td><?php echo $childcard->Sub_County ?></td>
                <td><?php echo $childcard->District ?></td>
                <td><?php echo $childcard->Disability ?></td>
                <td style="width: 1000px;"><?php echo $childcard->Case_History ?></td>
                <td><?php echo $childcard->Other_History ?></td>


            </tr>
            <?php
        endforeach;
        ?>  </table>
    <?php
}
?>
