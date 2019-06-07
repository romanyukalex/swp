<?php
//
// +----------------------------------------------------------------------+
// | PHP Day & Night v1.2.2 02.10.2002                                    |
// +----------------------------------------------------------------------+
// | Copyright (c) 2002 Christian Prior                                   |
// +----------------------------------------------------------------------+
// | These functions                                                      |
// |  - return an approximate value of the astronomical sunrise    [eng]  |
// |  - may be used to change a webpage from 'day' to 'night' mode        |
// | For further information please refer to the file README.             |
// | You will find further explanation here:                              |
// | http://www.moonstick.com/sunriseset.htm                              |
// | http://aa.usno.navy.mil/faq/docs/RST_defs.html                       |
// +----------------------------------------------------------------------+
// | Author: Christian Prior public@prior-i.de                            |
// |                         http://prioR-I.DE                            |
// +----------------------------------------------------------------------+
// | This script is free software; you can redistribute it and/or         |
// | modify it under the terms of the GNU Lesser General Public           |
// | License as published by the Free Software Foundation; either         |
// | version 2.1 of the License, or (at your option) any later version.   |
// |                                                                      |
// | This script is distributed in the hope that it will be useful,       |
// | but WITHOUT ANY WARRANTY; without even the implied warranty of       |
// | MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU    |
// | Lesser General Public License for more details.                      |
// |                                                                      |
// | You should have received a copy of the GNU Lesser General Public     |
// | License along with this library; if not, write to the Free Software  |
// | Foundation Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307 US|
// +----------------------------------------------------------------------+
//
//
    


    /**
    * A wrapper function for _getTimestamps
    *
    * Pass these 4 variables to the function: 1) longitude of the locations timezone, e.g. 0 for british
    * locations, 15 for Rome or Berlin, -75 for New York. 2) the longitude of the location, 3) the latitude
    * of the location and 4) the offset of the locations timezone to the servers time.
    *
    * Usage example for a server in the MEZ timezone (Central Europe):
    *
    * <?php
    * include_once "PHP_day_and_night_phpweather.php";
    * // Berlins daylight status
    * echo returnDayNight(15, 13.4, 52.3, 0);
    * // Londons daylight status
    * echo returnDayNight(0, -0.17, 51.5, -1);
    * // New Yorks daylight status
    * echo returnDayNight(-75, -73.98, 40.75, -6);
    * // Moscows daylight status
    * echo returnDayNight(30, 37.7, 55.57, 2);
    * ?>
    *
    * @param: the longitude of the locations timezone, e.g. 0 for Heathrow, -75 for New York, 15 for Rome
    * @param: the longitude of the location
    * @param: the latitude of the location
    * @param: the offset of the servers and the locations timezone
    *
    * @access: public
    * @return string day, night or error
    */

    function returnDayNight($longitude_timezone_location, $longitude_location, $latitude_location, $timezone_offset)
    {

        /**
        * the last variable in the following function call is probably the most important one:
        * it determines what degree of darkness is considered to be day or night.
        * for further explanation search Google for 'civil twilight':
        * http://www.google.com/search?q=civil+twilight .
        * Don't try and adjust this each day, though: Dust in the air, weather conditions and many more
        * factors will have influence. Something between 12 (brighter) and 18 (pitch black) should work.
        */
        $handle = _getTimestamps($longitude_timezone_location, $longitude_location, $latitude_location, $timezone_offset, 18);
        $now = _deltaServerTime ($timezone_offset);

        if ($now < $handle[rise]) {
            return 'night';
        //  echo 'night';
        }

        elseif ($now >= $handle[rise] && $now <= $handle[set]) {
            return 'day';
        // echo 'day';
        }

        elseif ($now > $handle[set]) {
            return 'night';
        // echo 'night';
        }

        else {
            return 'Unbekannter Fehler / unknown error';
        //  echo 'Unbekannter Fehler / unknown error';
    }

    } // end public function hellDunkel



    /**
    * calculates the offset between server time and location time
    *
    * @todo: find a way to get valid sunrises with malconfigured webservers
    * @access: private
    * @return: integer
    */

    function _deltaServerTime ($timezone_offset)
    {

        return time() + ($timezone_offset * 3600);

    } // end private function _deltaServerTime



    /**
    * calculates todays sunrise / sunset
    *
    * This is the workhorse of the script: It takes the variables from the wrapper function returnDayNight
    * and calculates todays sunrise with a pretty precise result. Note that this function uses a levelled
    * orbit of the earth around the sun and therefore small differences up to 3/4 minutes may occur.
    * The formula comes from Roland Brodbecks Webpage at http://lexikon.astronomie.info/zeitgleichung/
    * (I contacted him when I first ported his work to PHP) and many thanks go to Mr. Rothenberger
    * from the Peoples Observatory in Berlin for detailled explanations via the phone!
    *
    * @access: private
    */

    function _getTimestamps($longitude_timezone_location, $longitude_location, $latitude_location, $timezone_offset, $twilight)
    {

        /**
        * some preparatory stuff
        *
        * some variables are defined and the current time is calculated.
        * Any rewrite for other means of calculating the time starts here and in _deltaServerTime
        *
        * @see _deltaServerTime
        * @return array
        */
        $now = _deltaServerTime ($timezone_offset);
        $latitude_in_arcminutes = (pi() * $latitude_location / 180);
        $h = -0.00145;
        $day_info = getdate($now);
        $day_nr = $day_info[yday];

        /**
        * I know the variable names are rather long but I intended to keep the function readable.
        */
        $equation_of_time = -0.1752 * sin(0.033430 * $day_nr + 0.5474) - 0.1340 * sin(0.018234 * $day_nr - 0.1939);
        $todays_declination = 0.40954 * sin(0.01691 * ($day_nr - 79.349740));
        $sunrise_ante_noon = $twilight * acos((sin($h) - sin($latitude_in_arcminutes) * sin($todays_declination)) / (cos($latitude_in_arcminutes) * cos($todays_declination)))/pi();

        $sunrise_true_localtime = 12-$sunrise_ante_noon;
        $sunset_true_localtime = 12+$sunrise_ante_noon;

        $sunrise_medium_localtime = $sunrise_true_localtime - $equation_of_time;
        $sunrise_timezone = $sunrise_medium_localtime + ($longitude_timezone_location - $longitude_location) * 4/60;
        $sunset_medium_localtime = $sunset_true_localtime - $equation_of_time;
        $sunset_timezone = $sunset_medium_localtime + ($longitude_timezone_location - $longitude_location) * 4/60;

        $hour_sunrise = floor($sunrise_timezone);
        $rest = $sunrise_timezone - $hour_sunrise;
        $minute_sunrise = $rest * 60;
        $minute_sunrise = round($minute_sunrise);

        $hour_sunset = floor($sunset_timezone);
        $rest = $sunset_timezone - $hour_sunset;
        $minute_sunset = $rest * 60;
        $minute_sunset = round($minute_sunset);

        $sun[rise] = mktime ($hour_sunrise, $minute_sunrise, 0, date("m"), date("d"), date("Y"));
        $sun[set] = mktime ($hour_sunset, $minute_sunset, 0, date("m"), date("d"), date("Y"));

        // Anpassung an Sommerzeit:
        // daylight saving time recalculation:
        $sztestsr = (localtime($sun[rise],1));
            if ($sztestsr[tm_isdst] == 1)	{
                $sun[rise] = $sun[rise] + 3600;
            }
        $sztestss = (localtime($sun[set],1));
            if ($sztestss[tm_isdst] == 1)	{
                $sun[set] = $sun[set] - 3600;
            }

        return $sun;

    } // end private function getTimestamps

?>