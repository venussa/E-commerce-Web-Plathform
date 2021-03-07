<?php

	class get_region extends load{

		function __construct(){

			switch ($this->post("region")) {
				
				case 'kabupaten':
					
					foreach(kabupaten($this->post("kode")) as $key => $value){

						$code1[] = $key;
						$data1[] = "<option value='$key'>$value</option>";

					}

					foreach(kecamatan($code1[0]) as $key => $value){

						$code2[] = $key;
						$data2[] = "<option value='$key'>$value</option>";

					}

					$build[] = implode(null,$data1)."|";
					$build[] = implode(null,$data2)."|";
					$build[] = $code2[0];
					

				break;

				case 'kecamatan':
					
					foreach(kecamatan($this->post("kode")) as $key => $value){

						$kode[] = $key;
						$data1[] = "<option value='$key'>$value</option>";

					}

					$build[] = implode(null,$data1)."|";
					$build[] = $kode[0];

				break;

			}

		echo implode(null,$build);

		}
	}

					

?>