
<?php
/*iframe
  width="600"
  height="450"
  frameborder="0" style="border:0; margin-top: -150px;"
  src="https://www.google.com/maps/embed/v1/place?key=AIzaSyBodsu1bZRowWo0767dbprzUHMPvVZe7l0
    &q=59.4375266 	24.7846962" allowfullscreen>
</iframe>

//SELECT Latitude, Longitude FROM `Markers` WHERE ExperimentID = 1 GROUP BY MarkerTime 

?>

path=color:0x0000ff|weight:5|40.737102,-73.990318|40.749825,-73.987963|40.752946,-73.987384|40.755823,-73.986397
*/

/*<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBodsu1bZRowWo0767dbprzUHMPvVZe7l0&callback=initialize"></script> */
?>

       <?php
	    error_reporting(-1);
		$locations=array();
        //$work=$_GET["service"];
        $uname="if17";
        $pass="if17";
        $servername="localhost";
        $dbname="if17_Stressmap";
        $db=new mysqli($servername,$uname,$pass,$dbname);
        $query =  $db->query("SELECT ExperimentID, Longitude, Latitude, MarkerID FROM Markers GROUP BY MarkerTime");
        //$number_of_rows = mysql_num_rows($db);  
        //echo $number_of_rows;
        while( $row = $query->fetch_assoc() ){
            $Exp = $row['ExperimentID'];
            $longitude = $row['Longitude'];                              
            $latitude = $row['Latitude'];
            $Mark=$row['MarkerID'];
            /* Each row is added as a new array */
            $locations[]=array( 'ExperimentID'=>$Exp, 'lat'=>$latitude, 'lng'=>$longitude, 'MarkerID'=>$Mark );
        }
        echo $locations[0]['ExperimentID']."  ".$locations[0]['lat']."  ".$locations[0]['lng']."  ".$locations[0]['MarkerID'].".<br>";
        echo $locations[1]['ExperimentID']."  ".$locations[1]['lat']."  ".$locations[1]['lng']."  ".$locations[1]['MarkerID'].".<br>";
 

  ?>
  
 
  
<script type="text/javascript" src="http://maps.googleapis.com/maps/api/js?key=AIzaSyBodsu1bZRowWo0767dbprzUHMPvVZe7l0"></script>
    <script type="text/javascript">
    var map;
    var Markers = {};
    var infowindow;
    var locations = [
        <?php for($i=0;$i<sizeof($locations);$i++){ $j=$i+1;?>
        [
			'Stressmap',
			'<p><a href="<?php echo $locations[0]['ExperimentID'];?>">Aidake mind palun</a></p>',
            <?php echo $locations[$i]['lat'];?>,
            <?php echo $locations[$i]['lng'];?>,
			0
        ]<?php if($j!=sizeof($locations))echo ","; }?>
    ];
    var origin = new google.maps.LatLng(locations[0][2], locations[0][3]);
    function initialize() {
      var mapOptions = {
        zoom: 9,
        center: origin
      };
      map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
        infowindow = new google.maps.InfoWindow();
        for(i=0; i<locations.length; i++) {
            var position = new google.maps.LatLng(locations[i][2], locations[i][3]);
            var marker = new google.maps.Marker({
                position: position,
                map: map,
            });
            google.maps.event.addListener(marker, 'click', (function(marker, i) {
                return function() {
                    infowindow.setContent(locations[i][1]);
                    infowindow.setOptions({maxWidth: 200});
                    infowindow.open(map, marker);
                }
            }) (marker, i));
            Markers[locations[i][4]] = marker;
			console.log(locations[i][4]);
        }
        locate(0);
		
    }
    function locate(marker_id) {
		console.log
        var myMarker = Markers[marker_id];
        var markerPosition = myMarker.getPosition();
        map.setCenter(markerPosition);
        google.maps.event.trigger(myMarker, 'click');
    }
    google.maps.event.addDomListener(window, 'load', initialize);
    </script>
    <body id="map-canvas">