<?php
namespace  Cinhetic\PublicBundle\Twig;

/**
 * Class CinheticExtension
 * Override Twig Extensions
 * @package Cinhetic\PublicBundle\Twig
 */
class CinheticExtension extends \Twig_Extension
{

    /**
     * get All filters
     * @return array
     */
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('price', array($this, 'priceFilter')),
            new \Twig_SimpleFilter('ago', array($this, 'createdAgo')),
            new \Twig_SimpleFilter('begin', array($this, 'beginIn')),
            new \Twig_SimpleFilter('urldecode', array($this, 'urlDecode')),
            new \Twig_SimpleFilter('notecomment', array($this, 'noteComment')),
            new \Twig_SimpleFilter('date_period', array($this, 'datePeriod')),
            new \Twig_SimpleFilter('truncatemonth', array($this, 'truncateMonth')),
            new \Twig_SimpleFilter('jsondecode', array($this, 'jsonDecode'))
        );
    }

    /**
     * Format a price
     * @param $number
     * @param int $decimals
     * @param string $decPoint
     * @param string $thousandsSep
     * @return string
     */
    public function priceFilter($number, $decimals = 0, $decPoint = '.', $thousandsSep = ',')
    {
        $price = number_format($number, $decimals, $decPoint, $thousandsSep);
        $price = '$' . $price;

        return $price;
    }


    /**
     * Created ago function
     * @param $dateTime
     * @return null|string
     * @throws \Exception
     */
    public function createdAgo($dateTime)
    {

        if (!$dateTime)
            return null;

        $delta = time() - $dateTime->getTimestamp();
        if ($delta < 0)
            throw new \Exception("createdAgo is unable to handle dates in the future");
        $duration = "";
        if ($delta < 60) {
            // Seconds
            if ($delta < 60) {
                // Secondes
                $time = $delta;
                $duration = $time . " seconde" . (($time === 0 || $time > 1) ? "s" : "") . "";
            }
        } else if ($delta <= 3600) {
            // Mins
            $time = floor($delta / 60);
            $duration = $time . " minute" . (($time > 1) ? "s" : "") . "";
        } else if ($delta <= 86400) {
            // Hours
            $time = floor($delta / 3600);
            $duration = $time . " heure" . (($time > 1) ? "s" : "") . "";
        } else {
            // Days
            $time = floor($delta / 86400);
            $duration = $time . " jour" . (($time > 1) ? "s" : "") . "";
        }
        return $duration;
    }


    /**
     * Begin in function
     * @param \DateTime $dateTime
     * @return null|string
     */
    public function beginIn(\DateTime $dateTime)
    {
        if (!$dateTime)
            return null;

        $delta = time() - $dateTime->getTimestamp();

        $duration = "";
        if ($delta > 60) {
            // Seconds
            if ($delta > 60) {
                // Secondes
                $time = $delta;
                $duration = abs($time) . " seconde" . ((abs($time) === 0 || abs($time) > 1) ? "s" : "") . "";
            }
        } else if ($delta >= 3600) {
            // Mins
            $time = floor($delta / 60);
            $duration = abs($time) . " minute" . ((abs($time) > 1) ? "s" : "") . "";
        } else if ($delta >= 86400) {
            // Hours
            $time = floor($delta / 3600);
            $duration = abs($time) . " heure" . ((abs($time) > 1) ? "s" : "") . "";
        } else {
            // Days
            $time = floor($delta / 86400);
            $duration = abs($time) . " jour" . ((abs($time) > 1) ? "s" : "") . "";
        }
        return $duration;
    }


    /**
     * Transforme note in string
     * @param $rate
     * @return mixed
     */
    public function noteComment($rate)
    {
        $arrayNot = array(
            1 => 'Déçu',
            2 => 'M\'ouais',
            3 => 'Pas mal',
            4 => 'Réussi',
            5 => 'Comblé');
        if ($rate <= 5) {
            return $arrayNot[$rate];
        } else {
            return $arrayNot[4];
        }
    }

    /**
     * URL Decode a string
     * @param string $url
     * @return string The decoded URL
     */
    public function urlDecode($url)
    {
        return urldecode($url);
    }


    /**
     * Get period between 2 dates
     * @param $begin
     * @param $end
     * @param int $daysInterval
     * @return \DatePeriod
     */
    public function datePeriod($begin, $end, $daysInterval = 1)
    {
        # Dates : String pour DateTime::modify or DateTime directly
        if (is_string($begin))
            $begin = new \Datetime($begin);
        else
            $dateBegin = $begin;

        $dateEnd = clone $dateBegin;
        if (is_string($end))
            $dateEnd->modify($end);
        else
            $dateEnd = $end;

        # Interval
        $interval = new \DateInterval("P" . $daysInterval . "D");

        # Periode
        $period = new \DatePeriod($dateBegin, $interval, $dateEnd);

        return $period;
    }


    /**
     * To truncate a month date
     * @param $date
     * @return string
     */
    public function truncateMonth($date)
    {
        if (mb_strlen($date, 'utf8') > 4)
            $date = mb_substr($date, 0, 3 + ($date == "juillet" ? 1 : 0), 'utf8') . ".";
        return $date;
    }

    /**
     * JSON decode
     * @param $val
     * @return mixed
     */
    public function jsonDecode($val)
    {
        return json_decode($val);
    }

    /**
     * Get name of my extension
     * @return string
     */
    public function getName()
    {
        return 'cinhetic_extension';
    }


}