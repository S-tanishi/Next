<?php

namespace App\Calender;

use App\Models\Task;
use Carbon\Carbon;
use Yasumi\Yasumi;

/**
 * 日を出力するためのクラス
 */
class CalendarWeekDay{

    protected $carbon;

    public function __construct($date)
    {
        $this->carbon = new Carbon($date);
    }

    public function getClassName()
    {
        //format()関数に「D」を指定すると「Sun」「Mon」等曜日を省略形式で取得できる
        //小文字に変換をしているので、日曜日はday-sun、月曜日はday-monというクラス名を出力できる。
        return "day-" . strtolower($this->carbon->format("D"));
    }
    /**
     * active_dateを比較するために日付を取得(Y-m-d)
     */
    public function getDateKey()
    {
        return $this->carbon->format("Y-m-d");
    }

    /**
     * @return
     */
    public function render()
    {
        $html = [];
        //日付：format()関数に「j」を指定すると先頭にゼロをつけない日付けを取得できる
        $html[] = '<p class="day">' . $this->carbon->format("j"). '</p>';

        //active_dateと比較するために日付を取得(Y-m-d)
        $date = $this->carbon->format("Y-m-d");
        //日付が一致した場合、ある日のデータを取り出す
        $active_date = Task::where("active_date", "=", $date)->get();

        //Dayにtitle,リンクを表示
        if($active_date)
        {
            $html[] = '<p class="title">' . $active_date->title. '</p>';
            $html[] = '<a href="next/tasks/{task::active_date}"></a>';
        }

        return implode("", $html);
    }

}
