<?php

include('koneksi.php');

$sql  = "SELECT  
			ST_AsGeoJSON(geom) AS geometry,
			office_building_id,
			name_of_office_building
		FROM office_building
		";
		$geojson = array(
			'type'      => 'FeatureCollection',
			'features'  => array()
		);
		$query = pg_query($sql);
		if(pg_num_rows($query)==0) return 0;
		while($rows=pg_fetch_assoc($query)){
			$feature = array(
				"type" => 'Feature',
				'geometry' => json_decode($rows['geometry'], true),
				'jenis' => "Office Building",
				'properties' => array(
					'id' => $rows['office_building_id'],
					'nama' => $rows['name_of_office_building']
				)
			);
			array_push($geojson['features'], $feature);
		}


		echo json_encode($geojson);