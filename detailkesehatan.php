<?php
header('content-type: application/json; charset=utf8');
 header("access-control-allow-origin: *");
include('koneksi.php');


$id=$_GET['id'];

$sql = "SELECT H.health_building_id, H.name_of_health_building, H.building_area, H.land_area, H.parking_area, H.standing_year, H.electricity_capacity, H.address, H.type_of_construction, H.type_of_health_services, H.name_of_head, H.number_of_medical_personnel, H.number_of_nonmedical_personnel,
                                ST_X(ST_Centroid(H.geom)) AS longitude, ST_Y(ST_CENTROID(H.geom)) As latitude,
                                T.name_of_type as constr, J.name_of_type as type,
                                ST_AsText(geom) as geom
					            FROM health_building as H
                                LEFT JOIN type_of_construction as T ON H.type_of_construction=T.type_id
                                LEFT JOIN type_of_health_services as J ON H.type_of_health_services=J.type_id
                                WHERE H.health_building_id='$id' 
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
			"longitude" => $row['longitude'],
	        "latitude" => $row['latitude'],
	        "nama" => $row['name_of_health_building'],
	        "bang" => $row['building_area'],
	        "lahan" => $row['land_area'],
	        "parkir" => $row['parking_area'],
	        "tahun" => $row['standing_year'],
	        "listrik" => $row['electricity_capacity'],
	        "alamat" => $row['address'],
	        "konstruksi" => $row['constr'],
	        "jenis" => $row['type'],
	        "id_k" => $row['type_of_construction'],
	        "id_h" => $row['type_of_health_services'],
	        "kepala" => $row['name_of_head'],
	        "medis" => $row['number_of_medical_personnel'],
	        "non" => $row['number_of_nonmedical_personnel']
		)
	);
	array_push($geojson['features'], $feature);
}


echo json_encode($geojson);