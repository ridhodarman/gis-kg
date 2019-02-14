<?php

include('koneksi.php');

$id=$_GET['id'];

$sql = "SELECT O.office_building_id, O.name_of_office_building, O.building_area, O.land_area, O.parking_area, O.standing_year, O.electricity_capacity, O.address, O.type_of_construction, O.type_of_office,
                                ST_X(ST_Centroid(O.geom)) AS longitude, ST_Y(ST_CENTROID(O.geom)) As latitude,
                                T.name_of_type as constr, J.name_of_type as type,
                                ST_AsText(geom) as geom
					            FROM office_building as O
                                LEFT JOIN type_of_construction as T ON O.type_of_construction=T.type_id
                                LEFT JOIN type_of_office as J ON O.type_of_office=J.type_id
                                WHERE O.office_building_id='$id' 
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
			'longitude' => $row['longitude'],
			'latitude' => $row['latitude'],
			'nama' => $row['name_of_office_building'],
			'bang' => $row['building_area'],
			'lahan' => $row['land_area'],
			'parkir' => $row['parking_area'],
			'tahun' => $row['standing_year'],
			'listrik' => $row['electricity_capacity'],
			'alamat' => $row['address'],
			'konstruksi' => $row['constr'],
			'jenis' => $row['type'],
			'id_k' => $row['type_of_construction'],
			'id_o' => $row['type_of_office']
		)
	);
	array_push($geojson['features'], $feature);
}


echo json_encode($geojson);
