<?php 
require 'lib/buffme.php';

$Buffme = new Buffme;
$Buffme->domain('subgiare.vn');
$Buffme->apikey('eyJpdiI6ImEvZW9jM2ZlZFpKNUdGbUl0NVdjelE9PSIsInZhbHVlIjoiWENBYndFNWNNQ29wc3RUSTh2QWhqNkt0ZmVlOWxqaEpNZ2NsaWZDZ0pxTnZiakt4UmF6amRkbGFWUXNObkRBY2VvOGc5QjF5Z0xRSmVCbGsyaVNKenV5RDdqR0JnSTJOZjdUeVdrRW1UaWFwSW5WLzE0TVpINjFEMTY2c05TNXpZN3pwVjRIRDNYQ3ZOSStLbnIxak9BPT0iLCJtYWMiOiIxYzIyYjMzZTMzN2EzMjg1OGUwYmFhMTMzYWY4YzViZmZkMjRmMGM4YmY4NDBkOTBmYzUzZGZiOTZkZjlmOWQ5IiwidGFnIjoiIn0');
echo json_decode(Buffme::run('facebook', 'sub-vip', ['uid' => '100030199396627', 'server' => 'sv1', 'amount' => '10000', 'note' => null]))->message;
