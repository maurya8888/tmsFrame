<?php
    $td = mcrypt_module_open('rijndael-256', '', 'ofb', '');

    $iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_DEV_RANDOM);
    $ks = mcrypt_enc_get_key_size($td);

    $key = substr(md5('very secret key'), 0, $ks);

    mcrypt_generic_init($td, $key, $iv);

    $encrypted = mcrypt_generic($td, 'This is very important data');
	echo $encrypted . '<br/>';

    mcrypt_generic_deinit($td);

    mcrypt_generic_init($td, $key, $iv);

    $decrypted = mdecrypt_generic($td, $encrypted);

    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    echo trim($decrypted) . "\n";
?>