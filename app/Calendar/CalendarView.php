<?php
namespace App\Calendar;

use Carbon\Carbon;
use App\Calendar\CalendarWeek;
use App\Calender\CalendarWeekDay;

/**
 * カレンダーを出力するためのクラス
 */
class CalendarView 
{
    protected $carbon;

    public function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    // タイトルの出力
    public function getTitle()
    {
        return $this->carbon->format('Y年n月');
    }
    // create画面のgetCreateTitle
    public function getCreateTitle()
    {
        return $this->carbon->format('Y年n月d日');
    }
    // create画面のgetCreateFormDate
    public function getCreateFormDate()
    {
        return $this->carbon->format('Ymd');
    }

    // カレンダーを出力する
    public function render()
    {
           

        $html = [];
        $html[] = '<div class="calendar">'; 
        $html[] = '<table class="table">';
        $html[] = '<thead>';
		$html[] = '<tr>';
		$html[] = '<th>日</th>';
		$html[] = '<th>月</th>';
		$html[] = '<th>火</th>';
		$html[] = '<th>水</th>';
		$html[] = '<th>木</th>';
		$html[] = '<th>金</th>';
        $html[] = '<th>土</th>';
		$html[] = '</tr>';
        $html[] = '</thead>';
        
        $html[] = '<tbody>';

        $weeks = $this->getWeeks();
        foreach($weeks as $week)
        {
            $html[] = '<tr class="'.$week->getClassName().'">';
            $days = $week->getDays();
            foreach($days as $day)
            {
                $html[] = '<td class="'.$day->getClassName().'">';
                $html[] = $day->render();
                $html[] = '</td>';
            }
            $html[] = '</tr>';
        }

        $html[] = '<tbody>';

		$html[] = '</table>';
		$html[] = '</div>';
		return implode("", $html);
    }
    
    //一ヶ月分の週カレンダーを用意した$weeksを返却することが目的
    protected function getweeks()
    {
        $weeks = [];

        Carbon::setWeekStartsAt(Carbon::SUNDAY); // 週の最初を日曜日に設定
        Carbon::setWeekEndsAt(Carbon::SATURDAY); // 週の最後を土曜日に設定
        
        $firstDay = $this->carbon->copy()->firstOfMonth();

        $lastDay = $this->carbon->copy()->lastOfMonth();

        //1周目
        $weeks[] = $this->getWeek($firstDay);

        //作業用の日。1w後週の開始日に移動
        $tmpDay = $firstDay->copy()->addDay(7)->startOfWeek();

        //月末までループ
        while($tmpDay->lte($lastDay))
        {
            $weeks[] = $this->getWeek($tmpDay->copy(), count($weeks));
            //次の週=＋７日
            $tmpDay->addDay(7);
        }

        return $weeks;
    }

    protected function getweek(Carbon $date, $index = 0)
    {
        return new CalendarWeek($date, $index);
    }

    public function getNextMonth()
    {
        return $this->carbon->copy()->addMonthsNoOverflow()->format('Y-m');
    }
    public function getPreviousMonth()
    {
        return $this->carbon->copy()->subMonthsNoOverflow()->format('Y-m');
    }
}