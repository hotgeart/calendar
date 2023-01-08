<?php

/**
 * Generate a 2x A5 landscape PDF month calendar
 *
 * PHP version 8
 *
 * @category Calendar
 * @package  MonthCalendar
 * @author   Frans-Willem Post (FWieP) <fwiep@fwiep.nl>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://www.fwiep.nl/
 */

namespace FWieP;

use \IntlDateFormatter as IDF;
use \Mpdf\Output\Destination as D;

/**
 * Generate a 2x A5 landscape PDF month calendar
 *
 * PHP version 8
 *
 * @category Calendar
 * @package  MonthCalendar
 * @author   Frans-Willem Post (FWieP) <fwiep@fwiep.nl>
 * @license  https://www.gnu.org/copyleft/gpl.html GNU General Public License
 * @link     https://www.fwiep.nl/
 */
class PdfMonthCalendar
{
  private $_work = "";
  private $_agent = "";
  private $_code = "";

  private $_h1 = 0;
  private $_h2 = 0;

  private $_sat = 0;
  private $_sun = 0;
  private $_holi = 0;


  /**
   * This calendar's year
   *
   * @var integer
   */
  private $_year = 0;

  /**
   * This calendar's locale
   * 
   * @var string
   */
  private $_locale = 'fr_FR';

  /**
   * This calendar's timezone
   * 
   * @var \DateTimeZone
   */
  private $_tz;

  /**
   * Wraps the given DateTime and adds/subtracts given amount of days
   *
   * @param \DateTime $dt   DateTime to wrap
   * @param int       $days amount of days to add or subtract, can be negative
   *
   * @return \DateTime
   */
  private static function _dtWrap(\DateTime $dt, int $days): \DateTime
  {
    $outDt = clone $dt;
    $di = new \DateInterval('P' . abs($days) . 'D');

    if ($days < 0) {
      $outDt->sub($di);
    } else {
      $outDt->add($di);
    }
    return $outDt;
  }

  /**
   * Creates a new month calendar
   *
   * @param int $year the year to display
   */
  public function __construct($code, int $year)
  {
    if ($year < 1582 || $year > 3000) {
      throw new \InvalidArgumentException(
        "Year should be between 1582 and 3000!"
      );
    }
    $this->_year = $year;
    $this->_code = $code;
    $this->_tz = new \DateTimeZone('Europe/Amsterdam');

    $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load("./planing.xlsx");

    $dateArray = $spreadsheet->getActiveSheet()
      ->rangeToArray(
        'AT6:AT483',  // The worksheet range that we want to retrieve
        NULL,        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
      );

    $scheduleArray = $spreadsheet->getActiveSheet()
      ->rangeToArray(
        $this->_code . '6:' . $this->_code . '483',  // The worksheet range that we want to retrieve
        NULL,        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
      );

    $agentArray = $spreadsheet->getActiveSheet()
      ->rangeToArray(
        $this->_code . '1',  // The worksheet range that we want to retrieve
        NULL,        // Value that should be returned for empty cells
        TRUE,        // Should formulas be calculated (the equivalent of getCalculatedValue() for each cell)
        TRUE,        // Should values be formatted (the equivalent of getFormattedValue() for each cell)
        TRUE         // Should the array be indexed by cell row and cell column
      );
    $agentTMP = end($agentArray);
    $this->_agent = end($agentTMP);

    $work = [];

    foreach ($dateArray as $k => $v) {
      $v = reset($v);

      if ($v != NULL) {
        $date = explode("/", $v);

        if (checkdate(intval($date[0]), intval($date[1]), intval($date[2]))) {
          $key = $date[0] . '/' . $date[1];
          $work[$key] = reset($scheduleArray[$k]);
        }
      }
    }
    $this->_work = $work;
  }

  /**
   * Generates an HTML-table of the given month
   * 
   * @param int $m the month
   * 
   * @return string the output HTML
   */
  private function _generateMonthTable(int $m): string
  {
    $firstThisMonth = new \DateTime($this->_year . '-' . $m . '-01');
    $loopDate = clone $firstThisMonth;

    $dtfmt = new IDF(
      $this->_locale,
      IDF::NONE,
      IDF::NONE,
      $this->_tz,
      IDF::GREGORIAN
    );
    $html = '<table class="month">';

    $dtfmt->setPattern('MMMM');
    $html .= sprintf(
      '<tr class="title"><th colspan="7" style="text-transform: capitalize;">%s %d</th></tr>',
      $dtfmt->format($firstThisMonth),
      $this->_year
    );
    while ($loopDate->format('N') > 1) {
      $loopDate->sub(new \DateInterval('P1D'));
    }
    // Array of 8 rows for weeknumbers (1) + weekdays (7)
    $rows = array_fill(-1, 8, []);

    // Construct second to eighth rows
    foreach ($rows as $rowIx => &$row) {
      if ($rowIx == -1) {
        continue;
      }
      for ($colIx = -1; $colIx < 6; $colIx++) {
        $dt = self::_dtWrap($loopDate, 7 * $colIx + $rowIx);

        if ($colIx == -1) {
          // Print abbreviated weekday name
          $dtfmt->setPattern('E');
          $row[] = sprintf('<th style="text-transform: capitalize;">%s</th>', $dtfmt->format($dt));
          continue;
        }
        if ($dt->format('m') != $m) {
          // Print empty cell
          $row[] = '<td style="color:white;">xx</td>';
          continue;
        }
        // Print day of month
        $dtfmt->setPattern('d');
        $class = $this->_work[$dt->format('n') . '/' . $dt->format('j')];
        $holidays = array(
          "1/1",
          "4/10",
          "5/1",
          "5/18",
          "5/29",
          "7/21",
          "8/15",
          "11/1",
          "11/11",
          "12/25"
        );
        if (in_array($dt->format('n') . '/' . $dt->format('j'), $holidays)) {
          $holiday = "holiday";
          if($class == "H1" || $class == "H2") {
            $this->_holi = $this->_holi + 1;
          }
        } else {
          $holiday = "";
        }

        switch ($class) {
          case 'H1':
            $this->_h1 = $this->_h1 + 1;

            if($dt->format('w') == 0) {
              $this->_sun = $this->_sun + 1;
            }
    
            if($dt->format('w') == 6) {
              $this->_sat = $this->_sat + 1;
            }
            break;
          case 'H2':
            $this->_h2 = $this->_h2 + 1;

            if($dt->format('w') == 0) {
              $this->_sun = $this->_sun + 1;
            }
    
            if($dt->format('w') == 6) {
              $this->_sat = $this->_sat + 1;
            }
            break;
          
          default:
            # code...
            break;
        }

        $row[] = sprintf('<td class="' . $class . ' ' . $holiday . '">%s</td>', $dtfmt->format($dt));
      }
    }
    foreach ($rows as $rowIx => &$row) {
      if ($rowIx == -1) {
        $html .= '<tr class="week">';
      } else {
        $html .= '<tr>';
      }
      $html .= implode('', $row);
      $html .= '</tr>';
    }
    $html .= '</table>';
    return $html;
  }

  /**
   * Generates a 2x A5 landscape year calendar PDF and outputs it to the browser
   *
   * @return void
   */
  public function getPDF(): void
  {
    $pdfConfig = [
      'format' => 'A5',
      'margin_left' => 5,
      'margin_right' => 5,
      'margin_top' => 5,
      'margin_bottom' => 5,
      'margin_header' => 0,
      'margin_footer' => 0,
      'orientation' => 'L',
    ];
    $pdf = new \Mpdf\Mpdf($pdfConfig);
    $pdf->SetTitle('Planning ' . $this->_year);
    $pdf->SetAuthor('THOMAS MESTER');

    $css = file_get_contents('style.css');
    $pdf->WriteHTML($css, \Mpdf\HTMLParserMode::HEADER_CSS);

    $pdf->AddPage();
    $html = '<h1>' . $this->_agent . '</h1>';
    $html .= '<table class="scaffold"><tr>';
    for ($m = 1; $m <= 3; $m++) {
      // Add january - march to the first page's first row
      $html .= '<td>' . $this->_generateMonthTable($m) . '</td>';
    }
    $html .= '</tr><tr>';
    for ($m = 4; $m <= 6; $m++) {
      // Add april - june to the first page's second row
      $html .= '<td>' . $this->_generateMonthTable($m) . '</td>';
    }
    $html .= '</tr></table>';
    $html .= '<div class="legend"><span class="H1">H1</span> <strong>08h15</strong> (pause : 12h45 - 13h15) <strong>17h45</strong></div>';
    $html .= '<div class="legend"><span class="H2">H2</span> <strong>12h15</strong> (pause : 16h45 - 17h15) <strong>21h45</strong></div>';
    $pdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    $pdf->AddPage();
    $html = '<h1>' . $this->_agent . '</h1>';
    $html .= '<table class="scaffold"><tr>';
    for ($m = 7; $m <= 9; $m++) {
      // Add july - september to the second page's first row
      $html .= '<td>' . $this->_generateMonthTable($m) . '</td>';
    }
    $html .= '</tr><tr>';
    for ($m = 10; $m <= 12; $m++) {
      // Add october - december to the second page's second row
      $html .= '<td>' . $this->_generateMonthTable($m) . '</td>';
    }
    $html .= '</tr></table>';
    $html .= '<div class="legend"><span class="H1">H1</span> <strong>08h15</strong> (pause : 12h45 - 13h15) <strong>17h45</strong></div>';
    $html .= '<div class="legend"><span class="H2">H2</span> <strong>12h15</strong> (pause : 16h45 - 17h15) <strong>21h45</strong></div>';
    $pdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    // Stats
    $pdf->AddPage();
    $html = '<h1>' . $this->_agent . '</h1>';
    $html .= '<table class="scaffold month stats">';

    $html .= "<tr class='title'>";
    $html .= '<td colspan="2"><strong>Statistiques</strong></td>';
    $html .= "</tr>";

    $html .= "<tr>";
    $html .= '<td>Nombre de jours <span class="H1">H1</span></td><td align="right">'.$this->_h1.'</td>';
    $html .= "</tr>";

    $html .= "<tr>";
    $html .= '<td>Nombre de jours <span class="H2">H2</span></td><td align="right">'.$this->_h2.'</td>';
    $html .= "</tr>";

    $html .= "<tr>";
    $html .= '<td><strong>Total</strong> (H1+H2)</td><td align="right"><strong>'.$this->_h1+$this->_h2.'</strong></td>';
    $html .= "</tr>";

    $html .= "<tr>";
    $html .= '<td>Nombre de jours fériés au travail</td><td align="right">'.$this->_holi.'</td>';
    $html .= "</tr>";

    $html .= "<tr>";
    $html .= '<td>Nombre de Samedi au travail</td><td align="right">'.$this->_sat.'</td>';
    $html .= "</tr>";

    $html .= "<tr>";
    $html .= '<td>Nombre de Dimanche au travail</td><td align="right">'.$this->_sun.'</td>';
    $html .= "</tr>";

    $html .= '</tr></table>';

    $pdf->WriteHTML($html, \Mpdf\HTMLParserMode::HTML_BODY);

    $pdf->Output('Planning '. $this->_agent .' '. $this->_year . '.pdf', D::DOWNLOAD);
  }
}
