<?php

namespace App\Calendar;

use Carbon\Carbon;
use App\Calender\CalendarWeekDay;
use App\Calendar\CalendarWeekBlankDay;

/**
 * 週を出力するためのクラス
 */
class CalendarWeek 
{

    protected $carbon;
    protected $index = 0;

    public function __construct($date, $index = 0)
    {
        $this->carbon = new Carbon($date);
        $this->index = $index;
    }

    public function getClassName()
    {
        return "week-" . $this->index;
    }
    
    /**
     * @return CalendarWeekDay[]
     */
    public function getDays()
    {
        $days = [];
      
        //Carbonを利用して、開始日〜終了日の作成
        $startDay = $this->carbon->copy()->startOfWeek();
        $lastDay = $this->carbon->copy()->endOfWeek();

        //作業用
        $tmpDay = $startDay->copy();

        //月〜日までループ
        while($tmpDay->lte($lastDay))
        {
            //前の月or後ろの月の場合空白を表示。
            //月を比較して違う場合は前or後ろの余白なので処理を分ける
            if($tmpDay->month != $this->carbon->month)
            {
                $day = new CalendarWeekBlankDay($tmpDay->copy());
                $days[] =$day;
                $tmpDay->addDay(1);
                continue;
            }

            //今月
            $days[] = $this->getDay($tmpDay->copy());
            //翌月に移動
            $tmpDay->addDay(1);
        }

        return $days;

    }

    /**
     * @return CalendarWeekday
     */
    public function getDay(Carbon $date)
    {
        $day = new CalendarWeekDay($date);
 
        return $day;
    }

}
