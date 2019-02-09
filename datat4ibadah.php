<?php

include('koneksi.php');

$sql  = "SELECT  
			ST_AsGeoJSON(geom)::json As geometry,
			worship_building_id,
			name_of_worship_building
		FROM worship_building
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
				'jenis' => "Worship Building",
				'properties' => array(
					'id' => $rows['worship_building_id'],
					'nama' => $rows['name_of_worship_building']
				)
			);
			array_push($geojson['features'], $feature);
		}


		echo json_encode($geojson);