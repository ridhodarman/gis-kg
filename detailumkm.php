<?php
header('content-type: application/json; charset=utf8');
 header("access-control-allow-origin: *");
include('koneksi.php');


$id=$_GET['id'];

$sql = "SELECT M.msme_building_id, M.name_of_msme_building, M.building_area, M.land_area, M.parking_area, M.standing_year, M.electricity_capacity, M.address, M.type_of_construction, M.type_of_msme, M.owner_name, M.number_of_employee, M.monthly_income, M.contact_person,
                                ST_X(ST_Centroid(M.geom)) AS longitude, ST_Y(ST_CENTROID(M.geom)) As latitude,
                                T.name_of_type as constr, J.name_of_type as type,
                                ST_AsText(geom) as geom
					            FROM msme_building as M
                                LEFT JOIN type_of_construction as T ON M.type_of_construction=T.type_id
                                LEFT JOIN type_of_msme as J ON M.type_of_msme=J.type_id
                                WHERE M.msme_building_id='$id' 
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
			"nama" => $row['name_of_msme_building'],
			"bang" => $row['building_area'],
			"lahan" => $row['land_area'],
			"parkir" => $row['parking_area'],
			"tahun" => $row['standing_year'],
			"listrik" => $row['electricity_capacity'],
			"alamat" => $row['address'],
			"konstruksi" => $row['constr'],
			"jenis" => $row['type'],
			"id_k" => $row['type_of_construction'],
			"id_m" => $row['type_of_msme'],
			"pemilik" => $row['owner_name'],
			"pegawai" => $row['number_of_employee'],
			"penghasilan" => $row['monthly_income'],
			"kontak" => $row['contact_person']
		)
	);
	array_push($geojson['features'], $feature);
}


echo json_encode($geojson);