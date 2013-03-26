<?php

echo php_logo_guid() + php_egg_logo_guid().php_real_logo_guid();

mcrypt_cbc();
mcrypt_cfb();
mcrypt_ecb();
mcrypt_ofb();

# user defined function should be possible now
function php_logo_guid() { }
?>
<?= php_logo_guid(); ?>

<?php

class MySuperTestClass {

	public function php_logo_guid() {
		
	}
}