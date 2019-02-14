<?php
 header('content-type: application/json; charset=utf8');
 header("access-control-allow-origin: *");
include('koneksi.php');


$id=$_GET['id'];

$sql = "SELECT E.educational_building_id, E.name_of_educational_building, E.building_area, E.land_area, E.parking_area, E.standing_year, E.electricity_capacity, E.address, E.type_of_construction, E.id_level_of_education, E.headmaster_name, E.total_students, E.total_teachers, E.school_type,
                                ST_X(ST_Centroid(E.geom)) AS longitude, ST_Y(ST_CENTROID(E.geom)) As latitude,
                                T.name_of_type as constr, L.name_of_level as level,
                                ST_AsText(geom) as geom
					            FROM educational_building as E
                                LEFT JOIN type_of_construction as T ON E.type_of_construction=T.type_id
                                LEFT JOIN level_of_education as L ON E.id_level_of_education=L.level_id
                                WHERE E.educational_building_id='$id' 
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
			"nama" => $row['name_of_educational_building'],
			"bang" => $row['building_area'],
			"lahan" => $row['land_area'],
			"parkir" => $row['parking_area'],
			"tahun" => $row['standing_year'],
			"listrik" => $row['electricity_capacity'],
			"alamat" => $row['address'],
			"konstruksi" => $row['constr'],
			"tingkat" => $row['level'],
			"kepala" => $row['headmaster_name'],
			"murid" => $row['total_students'],
			"guru" => $row['total_teachers'],
			"id_k" => $row['type_of_construction'],
			"id_l" => $row['id_level_of_education'],
			"id_t" => $row['school_type']
		)
	);
	array_push($geojson['features'], $feature);
}


echo json_encode($geojson);
