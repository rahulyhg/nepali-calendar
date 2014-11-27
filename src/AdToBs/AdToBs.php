<?php

namespace NepaliCalendar\AdToBs;

class AdToBs implements AdToBsInterface
{
    private function getDateTime()
    {
        $datetime  = new \DateTime('now', new \DateTimeZone('Asia/Kathmandu'));
        $timestamp = strtotime($datetime->format('Y-m-d H:i:s'));
        return getdate($timestamp);
    }

    private function isLeapYear($year)
    {
        $is_leap_year = false;
        if (($year % 4) == 0 && (($year % 100) != 0 || ($year % 400) == 0)) {
            $is_leap_year = true;
        }
        return $is_leap_year;
    }

    private function convertAdToBs($ad_year, $ad_month, $ad_day)
    {
        $bs = array(
            0   => array(31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30),
            1   => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            2   => array(30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            3   => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            4   => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            5   => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            6   => array(30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31),
            7   => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            8   => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            9   => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            10  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31),
            11  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            12  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            13  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            14  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            15  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            16  => array(31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            17  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            18  => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            19  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            20  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            21  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            22  => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            23  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            24  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            25  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            26  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            27  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            28  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            29  => array(30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            30  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            31  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            32  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            33  => array(30, 32, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31),
            34  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            35  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            36  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            37  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 29, 31),
            38  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            39  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            40  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            41  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            42  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            43  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            44  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            45  => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            46  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            47  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            48  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            49  => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            50  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            51  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            52  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            53  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            54  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            55  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            56  => array(30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            57  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            58  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            59  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            60  => array(30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            61  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            62  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            63  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            64  => array(31, 31, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31),
            65  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            66  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            67  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            68  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            69  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            70  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            71  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            72  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            73  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            74  => array(31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            75  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            76  => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            77  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            78  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            79  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            80  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            81  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            82  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            83  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            84  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            85  => array(31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30),
            86  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            87  => array(30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            88  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            89  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            90  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            91  => array(31, 31, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31),
            92  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            93  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            94  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            95  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            96  => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            97  => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            98  => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            99  => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            100 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            101 => array(31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            102 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            103 => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            104 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            105 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            106 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            107 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            108 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            109 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            110 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            111 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            112 => array(31, 31, 32, 31, 32, 30, 30, 29, 30, 29, 30, 30),
            113 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            114 => array(30, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            115 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            116 => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            117 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            118 => array(31, 31, 31, 32, 31, 31, 29, 30, 29, 30, 29, 31),
            119 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            120 => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            121 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            122 => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            123 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            124 => array(31, 31, 32, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            125 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            126 => array(31, 31, 31, 32, 31, 31, 29, 30, 30, 29, 30, 30),
            127 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            128 => array(31, 32, 31, 32, 31, 30, 30, 29, 30, 29, 30, 30),
            129 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 31),
            130 => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            131 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            132 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            133 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            134 => array(31, 31, 31, 32, 31, 31, 30, 29, 30, 29, 30, 30),
            135 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
            136 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 29, 30, 30),
            137 => array(31, 32, 31, 32, 31, 30, 30, 30, 29, 30, 29, 31),
            138 => array(31, 31, 32, 31, 31, 31, 30, 29, 30, 29, 30, 30),
        );

        // 0 => non-leap year.
        // 1 => leap year.
        $ad = array(
            0 => array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31),
            1 => array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31),
        );

        // Cycles every 139 years.
        $cycle = 139;

        $ad_index = $this->isLeapYear($ad_year) ? 1 : 0;

        $ad_yday = 0;

        for ($i = 0; $i < $ad_month - 1; $i++) {
            $ad_yday = $ad_yday + $ad[$ad_index][$i];
        }

        // Total number days till date in the specified year (AD).
        $ad_yday += $ad_day;

        $bs_year = $ad_year + 56;

        $bs_index = ($bs_year % $cycle) + 2;

        $bs_year_total_days = array_sum($bs[$bs_index]);

        $ad_year_exception = array(
            1901,
            1902,
            1905,
            1906,
            1909,
            1910,
            1913,
            1914,
            1917,
            1918,
            1921,
            1922,
            1925,
            1926,
            1929,
            1930,
            1933,
            1934,
            1937,
            1938,
            1941,
            1942,
            1945,
            1946,
            1949,
            1950,
            1953,
            1954,
            1957,
            1958,
            1961,
            1962,
            1965,
            1966,
            1969,
            1970,
            1973,
            1974,
            1977,
            1978,
            1981,
            1982,
            1985,
            1986,
            1989,
            1990,
            1993,
            1994,
            1997,
            1998,
            2001,
            2002,
            2005,
            2006,
            2009,
            2010,
            2013,
            2017,
            2018,
            2021,
            2022,
            2025,
            2026,
            2029,
            2030,
        );

        if (in_array($ad_year, $ad_year_exception)) {
            $adjust_day = 263;
        } else {
            $adjust_day = 262;
        }

        $total_days = $ad_yday + $adjust_day;

        $flag = false;

        if ($total_days > $bs_year_total_days) {
            $flag = true;
            // Increment B.S. year by 1.
            ++$bs_year;
            // Remaining number of days.
            $bs_remaining_days = $total_days - $bs_year_total_days;
        } else {
            $bs_remaining_days = $total_days;
        }

        $days_temp = 0;

        $i = 0;

        while ($days_temp < $bs_remaining_days) {
            if ($flag) {
                $days_temp += $bs[$bs_index + 1][$i];
            } else {
                $days_temp += $bs[$bs_index][$i];
            }
            ++$i;
        }

        // Baisakh = 1, Jestha = 2 and so on.
        $bs_month = $i;

        if ($flag) {
            $days_temp -= $bs[$bs_index + 1][$i - 1];
        } else {
            $days_temp -= $bs[$bs_index][$i - 1];
        }

        $bs_day = $bs_remaining_days - $days_temp;

        $return = array(
            'year'  => $bs_year,
            'month' => $bs_month,
            'day'   => $bs_day,
        );

        return $return;
    }

    public function getNepaliDate()
    {

        $today = $this->getDateTime();

        $date = $this->convertAdToBs($today['year'], $today['mon'], $today['mday']);

        $datetime = array(
            'Y' => $date['year'],
            'n' => $date['month'],
            'm' => str_pad($date['month'], 2, '0', STR_PAD_LEFT),
            'F' => $this->month($date['month']),
            'j' => $date['day'],
            'd' => str_pad($date['day'], 2, '0', STR_PAD_LEFT),
            'H' => str_pad($today['hours'], 2, '0', STR_PAD_LEFT),
            'i' => str_pad($today['minutes'], 2, '0', STR_PAD_LEFT),
            's' => str_pad($today['seconds'], 2, '0', STR_PAD_LEFT),
            'w' => $today['wday'],
            'l' => $today['weekday'],
        );
        return $datetime;
    }

    public function month($month)
    {
        $months = array(
            1  => 'Baishakh',
            2  => 'Jestha',
            3  => 'Ashadh',
            4  => 'Shrawan',
            5  => 'Bhadra',
            6  => 'Ashwin',
            7  => 'Kartik',
            8  => 'Mangsir',
            9  => 'Poush',
            10 => 'Magh',
            11 => 'Falgun',
            12 => 'Chaitra',
        );
        return $months[$month];
    }
}
