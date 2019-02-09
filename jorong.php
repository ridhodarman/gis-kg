<?php

include('koneksi.php');

$sql  = "SELECT  
			ST_AsGeoJSON(geom) AS geometry,
			jorong_id,
			name_of_jorong
		FROM jorong
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
				'jenis' => "Jorong",
				'properties' => array(
					'id' => $rows['jorong_id'],
					'nama' => $rows['name_of_jorong']
				)
			);
			array_push($geojson['features'], $feature);
		}


		echo json_encode($geojson);