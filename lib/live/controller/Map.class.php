<?php
/**
 * creates the javascript for the google maps api
 * @author joh
 *
 */
class Map {
	/**
	 * stack of stations
	 * @var unknown
	 */
	private $stations;
	
	/**
	 * result stack string builder
	 * @var unknown
	 */
	private $result;
	
	/**
	 * stations converted to markers
	 * @var unknown
	 */
	private $marker;
	
	/**
	 * init zoom
	 * @var unknown
	 */
	private $opt_zoom = "13";
	
	/**
	 * coords of paderborn
	 * @var unknown
	 */
	private $opt_center = array("51.718921","8.757509");
	
	/**
	 * init maptype
	 * @var unknown
	 */
	private $opt_mapTypeId = "google.maps.MapTypeId.ROADMAP";
	
	/**
	 * map canvas
	 * @var unknown
	 */
	private $mapCanvas = "document.getElementById('mapCanvas')";

	/**
	 * icon for stations
	 * @var unknown
	 */
	private $mStation = "./template/bike.png";
	
	/**
	 * icon for location
	 * @var unknown
	 */
	private $mLocation = "./template/location.png";
	
	/**
	 * construct
	 */
	function __construct() {
		$this->stations = new Stack();
		$this->result = new Stack();
		$this->marker = new Stack();
	}
	
	/**
	 * add a Station to the Map
	 * @param Station $s
	 */
	function addStation(Station $s, $element = null) {
		$this->stations->push(array("station" => $s, "link" => $element));
	}
	
	/**
	 * string builder for result
	 * @param unknown $str
	 */
	private function result($str) {
		$this->result->push($str);
	}
	
	/**
	 * returns javascript new google maps position
	 * @param unknown $arr
	 * @param string $long
	 * @return string
	 */
	private function gPosition($arr, $long=NULL) {
		if($long === NULL) {
			return "new google.maps.LatLng(".
						$arr[0].", ".$arr[1].")";
		}

		return "new google.maps.LatLng(".
				$arr.", ".$long.")";
	}
	
	/**
	 * renders the JS output
	 */
	private function renderJS() {
		// styles + options json
		/*$styles = "[".
					  "{".
					   "\"stylers\": [ ".
					      "{ \"saturation\": -13 }, ".
					      "{ \"hue\": \"#004cff\" }, ".
					      "{ \"invert_lightness\": true }, ".
					      "{ \"lightness\": 12 }, ".
					      "{ \"gamma\": 1.54 } ".
					    "]".
					  "}".
					"]"; 	*/
		
		$options = 	"{".
						"zoom : ". $this->opt_zoom.", ".
						"center : ".$this->gPosition($this->opt_center).", ".
						"mapTypeId : ".$this->opt_mapTypeId.", ".
						"mapTypeControl: false, ".
						"panControlOptions: { position: google.maps.ControlPosition.TOP_RIGHT }, ".
						"streetViewControl: false ".
					"}";
		
		
		// JS for Google Maps Api
		$this->result(	"<script type=\"text/javascript\" src=\"http://maps.google.com/maps/api/js?sensor=true&callback=initializeGMaps\"></script>");
		
		$this->result(	"<script type=\"text/javascript\">".
						"function initializeGMaps() {"	);
		
		// initialize map
		$this->result(	"var map = new google.maps.Map(".$this->mapCanvas.",".$options.");");

		$this->rGeoLocation();
		$this->rMarker();
		
		/*$this->result( 	"map.mapTypes.set('map_style', ".
						"new google.maps.StyledMapType(".$styles.", {name: \"Styled Map\"}));".
  						"map.setMapTypeId('map_style');"
				);*/
		
		
		$this->result(	"} </script>"	);
	}
	
	/**
	 * renders the Markers in javascript
	 */
	private function rMarker() {
		$this->initMarkers();

		$this->result(	"var iw = new google.maps.InfoWindow({ content : \"...\", maxWidth : 320 });");
		$this->result(	"var ms = new Array(); ");
		
		$i = 0;
		while($marker = $this->marker->pop()) {
			$this->result(	"ms.push(new google.maps.Marker({".
								"position: ".$this->gPosition($marker['lat'],$marker['long']).", ".
								"title: '".$marker['title']."', ".
								"content: '".$marker['body']."', ".
								"icon: '".$this->mStation."' ".
							"})); ");


			$this->result(	"ms[".$i."].setMap(map); ".
					"google.maps.event.addListener(ms[".$i."], 'click', function() { ".
					"iw.setContent(this.content); ".
					"iw.open(map, this); ".
					"}); ");
			$this->result( "$('".$marker['link']."').data('marker', ms[".$i."]); ");
			$this->result( "$('".$marker['link']."').click(function() { google.maps.event.trigger($('".$marker['link']."').data('marker'), 'click') }); ");
			$i++;
		}
		
		
		$this->result( 	"google.maps.event.addListener(map, 'click', function() { iw.close(); });" );
	}
	
	/**
	 * renders the geolocation
	 */
	private function rGeoLocation() {
		$this->result(	"function hGeoErr() { ".
							"map.setCenter(".$this->gPosition($this->opt_center)."); ".
						"}");
		
		$this->result( "if (navigator.geolocation) { ");
		
		$this->result( 
				"navigator.geolocation.getCurrentPosition(function(position) { ".
					"map.setCenter(".$this->gPosition("position.coords.latitude","position.coords.longitude")."); ".
					"new google.maps.Marker({".
						"position: ".$this->gPosition("position.coords.latitude","position.coords.longitude").", ".
						"title: 'Ich', ".
						"icon: '".$this->mLocation."' ".
					"}).setMap(map); ".
				"}, hGeoErr()); "
			);
		
		$this->result("} else hGeoErr();");
	}
	
	/**
	 * returns the output string
	 * @return Ambigous <string, mixed>
	 */
	function getHtml() {
		$this->renderJS();
		
		$str = "";
		$this->result->reverse();
		while($row = $this->result->pop())
			$str .= $row;
		
		return $str;
	}
	
	/**
	 * initializes the Markers
	 */
	private function initMarkers() {
		$_stations = clone $this->stations;
		
		while($station = $_stations->pop()) {
			$link = $station['link'];
			$station = $station['station'];
			$aBikes = $station->availableBikes();
			
			// generate body
			$body = "<div>";
			
			// title and bike pool
			$body .= "<h1>".$station->getTitle()."</h1>";
			$body .= "<p><i class=\"icon-map-marker\"></i> (".date("H:i").") Räder status: ".$aBikes."/".$station->getSlots()."</p>";

			// power status
			$body .= ($station->getPower()?
					"<p><i class=\"icon-ok-circle\"></i> Diese Station bietet Strom</p>":
					"<p><i class=\"icon-ban-circle\"></i> Diese Station bietet <strong>keinen</strong> Strom</p>"
					);
			
			// booking / reservation
			if($aBikes > 0) {
				$body .= "<p><a href=\"bookingForm.php?sstation=".$station->getId()."\" ".
						"class=\"btn btn-large btn-block btn-primary\">anfragen</a></p>";
			} else {
				$body .= "<p><a href=\"bookingForm.php?sstation=".$station->getId()."\" ".
						"class=\"btn btn-large btn-block\">anfragen</a></p>";
			}
			$body .= "</div>";
			
			// add to markers
			$this->marker->push(array(
					"long" => $station->getLong(),
					"lat" => $station->getLat(),
					"body" => $body,
					"title" => $station->getTitle(),
					"link" => $link
				));
		}
	}
}
?>