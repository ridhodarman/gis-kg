<?php

include('koneksi.php');

$sql  = "SELECT  
			ST_AsGeoJSON(geom)::json As geometry,
			health_building_id,
			name_of_health_building
		FROM health_building
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
				'jenis' => "Health Building",
				'properties' => array(
					'id' => $rows['health_building_id'],
					'nama' => $rows['name_of_health_building']
				)
			);
			array_push($geojson['features'], $feature);
		}


		echo json_encode($geojson);