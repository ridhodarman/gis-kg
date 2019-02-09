<?php
require 'koneksi.php';
$querysearch="	SELECT row_to_json(fc) 
				FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features 
				FROM (SELECT 'Feature' As type , ST_AsGeoJSON(ST_Transform(ST_SetSrid(nagari.geom,32747), 4326))::json As geometry , row_to_json((SELECT l 
				FROM (SELECT nagari.name_of_nagari, nagari.nagari_id as gid, ST_X(ST_Centroid(nagari.geom)) AS lon, ST_Y(ST_CENTROID(nagari.geom)) As lat) As l )) As properties 
				FROM nagari As nagari  
				) As f ) As fc ";

$hasil=pg_query($querysearch);
while($data=pg_fetch_array($hasil))
	{
		$load=$data['row_to_json'];
	}
	echo $load;


// require 'connect.php';
// $querysearch="	SELECT row_to_json(fc) 
// 				FROM ( SELECT 'FeatureCollection' As type, array_to_json(array_agg(f)) As features 
// 				FROM (SELECT 'Feature' As type , ST_AsGeoJSON(jorong.geom)::json As geometry , row_to_json((SELECT l 
// 				FROM (SELECT jorong.id,ST_X(ST_Centroid(jorong.geom)) AS lon, ST_Y(ST_CENTROID(jorong.geom)) As lat) As l )) As properties 
// 				FROM jorong As jorong  
// 				) As f ) As fc ";

// $hasil=pg_query($querysearch);
// while($data=pg_fetch_array($hasil))
// 	{
// 		$load=$data['row_to_json'];
// 	}
// 	echo $load;
?>