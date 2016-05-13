<?php
class Calendar {
	private $year;
	private $month;
	private $val;
	private $weeks = array ('日', '一', '二', '三', '四', '五', '六' );
	
	function __construct($options = array(), $val) {
		$this->year = date ( 'Y' );
		$this->month = date ( 'm' );
		$this->val = $val;
		
		$vars = get_class_vars ( get_class ( $this ) );
		foreach ( $options as $key => $value ) {
			if (array_key_exists ( $key, $vars )) {
				$this->$key = $value;
			}
		}
	}
	
	function display() {
		$value .= '<table class="calendar">';
		$value .= $this->showChangeDate ();
		$value .= $this->showWeeks ();
		$value .= $this->showDays ( $this->year, $this->month );
		$value .= '</table>';
		return $value;
	}
	
	private function showWeeks() {
		$value .= '<tr>';
		foreach ( $this->weeks as $title ) {
			$value .= '<th>' . $title . '</th>';
		}
		$value .= '</tr>';
		return $value;
	}
	
	private function showDays($year, $month) {
		$firstDay = mktime ( 0, 0, 0, $month, 1, $year );
		$starDay = date ( 'w', $firstDay );
		$days = date ( 't', $firstDay );
		
		$value .= '<tr>';
		for($i = 0; $i < $starDay; $i ++) {
			$value .= '<td>&nbsp;</td>';
		}
		
		$day = $this->val;
		$count = count ( $day );
		$flag = false;
		for($j = 1; $j <= $days; $j ++) {
			$i ++;
			for($m = 0; $m < $count; $m ++) {
				$dd = $day [$m] ['si_day'];
				if ($dd == $j) {
					$flag = true;
					break;
				} else {
					$flag = false;
				}
			}
			if ($j == date ( 'd' )) {
				if ($flag) {
					$value .= '<td class="today dd">' . $j . '</td>';
				} else {
					$value .= '<td class="dd">' . $j . '</td>';
				}
			} else {
				if ($flag) {
					$value .= '<td class="today">' . $j . '</td>';
				} else {
					$value .= '<td>' . $j . '</td>';
				}
			}
			
			if ($i % 7 == 0) {
				$value .= '</tr><tr>';
			}
		}
		
		$value .= '</tr>';
		return $value;
	}
	
	private function showChangeDate() {
		
		$url = basename ( $_SERVER ['PHP_SELF'] );
		
		$value = '<tr>';
		$value .= '<td><a href="?' . $this->preYearUrl ( $this->year, $this->month ) . '">' . '上年' . '</a></td>';
		$value .= '<td><a href="?' . $this->preMonthUrl ( $this->year, $this->month ) . '">' . '上月' . '</a></td>';
		$value .= '<td colspan="3"><form>';
		
		$value .= '<select name="year" onchange="window.location=\'' . $url . '?year=\'+this.options[selectedIndex].value+\'&month=' . $this->month . '\'">';
		for($ye = 1970; $ye <= 2038; $ye ++) {
			$selected = ($ye == $this->year) ? 'selected' : '';
			$value .= '<option ' . $selected . ' value="' . $ye . '">' . $ye . '</option>';
		}
		$value .= '</select>';
		$value .= '<select name="month" onchange="window.location=\'' . $url . '?year=' . $this->year . '&month=\'+this.options[selectedIndex].value+\'\'">';
		
		for($mo = 1; $mo <= 12; $mo ++) {
			$selected = ($mo == $this->month) ? 'selected' : '';
			$value .= '<option ' . $selected . ' value="' . $mo . '">' . $mo . '</option>';
		}
		$value .= '</select>';
		$value .= '</form></td>';
		$value .= '<td><a href="?' . $this->nextMonthUrl ( $this->year, $this->month ) . '">' . '下月' . '</a></td>';
		$value .= '<td><a href="?' . $this->nextYearUrl ( $this->year, $this->month ) . '">' . '下年' . '</a></td>';
		$value .= '</tr>';
		return $value;
	}
	
	private function preYearUrl($year, $month) {
		$year = ($this->year <= 1970) ? 1970 : $year - 1;
		
		return 'year=' . $year . '&month=' . $month;
	}
	
	private function nextYearUrl($year, $month) {
		$year = ($year >= 2038) ? 2038 : $year + 1;
		
		return 'year=' . $year . '&month=' . $month;
	}
	
	private function preMonthUrl($year, $month) {
		if ($month == 1) {
			$month = 12;
			$year = ($year <= 1970) ? 1970 : $year - 1;
		} else {
			$month --;
		}
		
		return 'year=' . $year . '&month=' . $month;
	}
	
	private function nextMonthUrl($year, $month) {
		if ($month == 12) {
			$month = 1;
			$year = ($year >= 2038) ? 2038 : $year + 1;
		} else {
			$month ++;
		}
		return 'year=' . $year . '&month=' . $month;
	}

}