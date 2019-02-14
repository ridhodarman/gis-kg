<?php
 header('content-type: application/json; charset=utf8');
 header("access-control-allow-origin: *");
include('koneksi.php');


$id=$_GET['id'];

$sql = "SELECT W.worship_building_id, W.name_of_worship_building, W.building_area, W.land_area, W.parking_area, W.standing_year, W.electricity_capacity, W.address, W.type_of_construction, W.type_of_worship,
                ST_X(ST_Centroid(W.geom)) AS longitude, ST_Y(ST_CENTROID(W.geom)) As latitude,
                T.name_of_type as constr, J.name_of_type as type,
                ST_AsText(geom) as geom
	            FROM worship_building as W
                LEFT JOIN type_of_construction as T ON W.type_of_construction=T.type_id
                LEFT JOIN type_of_worship as J ON W.type_of_worship=J.type_id
                WHERE W.worship_building_id='$id' 
            ";

$geojson = array(
			'type'      => 'FeatureCollection',
			'features'  => array()
		);
$query = pg_query($sql);
if(pg_num_rows($query)==0) return 0;
while($row=pg_fetch_assoc($query)){
	$feature = array(
		"type" => 'Feature',
		'geometry' => json_decode($rows['geometry'], true),
		'properties' => array(
			'id' => $rows['worship_building_id'],
			'longitude' => $row['longitude'],
		    'latitude' => $row['latitude'],
		    'nama' => $row['name_of_worship_building'],
		    'bang' => $row['building_area'],
		    'lahan' => $row['land_area'],
		    'parkir' => $row['parking_area'],
		    'tahun' => $row['standing_year'],
		    'listrik' => $row['electricity_capacity'],
		    'alamat' => $row['address'],
		    'konstruksi' => $row['constr'],
		    'jenis' => $row['type'],
		    'tipe_k' => $row['type_of_construction'],
		    'tipe_i' => $row['type_of_worship']
		)
	);
	array_push($geojson['features'], $feature);
}


echo json_encode($geojson);
