<?php
class MyDateTime extends DateTime
{

    public function fiscalYear()
    {
        $result = array();
        $start = new DateTime();
        $start->setTime(0, 0, 0);
        $end = new DateTime();
        $end->setTime(23, 59, 59);
        $year = $this->format('Y');
        $start->setDate($year, 4, 6);
        if($start <= $this){
            $end->setDate($year +1, 4, 5);
        } else {
            $start->setDate($year - 1, 4, 6);
            $end->setDate($year, 4, 5);
        }
				$result['start'] = $start;
				$result['end'] = $end;
				return $result;
    }
}


?>