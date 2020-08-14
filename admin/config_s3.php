<?php 
$bucket = 'juturu';

if (!defined('awsAccessKey')) define('awsAccessKey', 'AKIAJ3IGXPZ27XC2R2VQ');


if (!defined('awsSecretKey')) define('awsSecretKey', '6uy4MpihP1Dg8RRBqB7wtGNTUWOuVYneFP8gWO1o');

$client = S3Client::factory(
    array(
        'key' =>awsAccessKey,
        'secret' => awsSecretKey
    )
)

?>