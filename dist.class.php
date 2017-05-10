<?php
/**
 * Calculating distance between two Zip/Postal Codes
 *
 * @category Class
 * @package  PHPClasses
 * @author   Harold Scholtz <harold@skollas.co.za>
 * @license  http://www.gnu.org/copyleft/gpl.html GNU General Public License
 */
class Distance
{
    /**
     * Calculates Driving Distance from Latitude and Longitude Pairs
     * 
     * @param array $pair1 Array of first Pair
     * @param array $pair2 Array of second Pair
     * 
     * @return string
     */
    function ConvertLatLong($pair1, $pair2)
    {
		$pair1[0] = $pair1['lat'];
		$pair1[1] = $pair1['lng'];
		
		$pair2[0] = $pair2['lat'];
		$pair2[1] = $pair2['lng'];
		
        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.urlencode("$pair1[0], $pair1[1]").'&sensor=false&language=en-En';

        $result = @file_get_contents($url);
        $data = json_decode(utf8_encode($result), true);
        $address1 = $data['results'][0]['formatted_address'];

        $url = 'http://maps.googleapis.com/maps/api/geocode/json?latlng='.urlencode("$pair2[0], $pair2[1]").'&sensor=false&language=en-En';

        $result = @file_get_contents($url);
        $data = json_decode(utf8_encode($result), true);
        $address2 = $data['results'][0]['formatted_address'];
		
        return $this->GetDistance($address1, $address2);
    }

    /**
     * Calculates Driving Distance from Addresses
     * 
     * @param string $address1 First Address
     * @param string $address2 Second Address
     * 
     * @return string
     */
    private function GetDistance($address1, $address2)
    {
        $url  = "http://maps.googleapis.com/maps/api/distancematrix/json?origins=".urlencode($address1);
        $url .= "&destinations=".urlencode($address2)."&mode=car&language=en-EN&sensor=false";
		
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url
        ));
        $result = curl_exec($curl);
        curl_close($curl);
        $data = json_decode(utf8_encode($result), true);

        if (isset($data['rows'][0]['elements'][0]['distance']['text'])) {
            $kmText = $data['rows'][0]['elements'][0]['distance']['text'];
            $kmText = explode(" ", $kmText);
            $km = str_replace(',','',$kmText[0]);

            $miles = $km * 0.621371192;
            return array("KM" => round($km, 2), "Mile" => round($miles, 2));
        } else {
            return array("error"=>true, "msg"=>"Please check your provided Parameters.");
        }
    }

	function getLnt($zip){
		$url = "http://maps.googleapis.com/maps/api/geocode/json?address=
		".urlencode($zip)."&sensor=false";
		$result_string = file_get_contents($url);
		$result = json_decode($result_string, true);
		$result1[]=$result['results'][0];
		$result2[]=$result1[0]['geometry'];
		$result3[]=$result2[0]['location'];
		return $result3[0];
	}
}
