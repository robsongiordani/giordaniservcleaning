<?php

require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config/conexao.php';

$id = $_GET['id'];

$agenda = $db->querySingle("

SELECT *
FROM agenda

WHERE orcamento_id = '$id'

ORDER BY id DESC

", true);

if(!$agenda){

    die('Serviço não encontrado.');

}

function base64Image($path){

    if(!file_exists($path)){
        return '';
    }

    $type = pathinfo($path, PATHINFO_EXTENSION);

    $data = file_get_contents($path);

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

$logo = base64Image(
__DIR__ . '/../assets/img/logo.png'
);

$html = '

<style>

body{
    font-family: DejaVu Sans;
    padding:30px;
    color:#111827;
}

.logo{
    width:150px;
    margin-bottom:20px;
}

h1{
    color:#2563eb;
    margin-bottom:20px;
}

.box{
    border:1px solid #ddd;
    border-radius:12px;
    padding:15px;
    margin-bottom:20px;
}

.box p{
    margin:8px 0;
}

.footer{
    margin-top:50px;
    text-align:center;
}

</style>

<img src="'.$logo.'" class="logo">

<h1>RECIBO DE SERVIÇO</h1>

<div class="box">

<p>
<strong>OS:</strong>
'.$agenda['os_numero'].'
</p>

<p>
<strong>Cliente:</strong>
'.$agenda['cliente'].'
</p>

<p>
<strong>Telefone:</strong>
'.$agenda['telefone'].'
</p>

<p>
<strong>Data:</strong>
'.$agenda['data'].'
</p>

<p>
<strong>Horário:</strong>
'.$agenda['horario'].'
</p>

<p>
<strong>Serviços:</strong>
'.$agenda['servicos'].'
</p>

<p>
<strong>Observações:</strong>
'.$agenda['observacoes'].'
</p>

</div>

<p>

Declaramos que os serviços acima foram executados pela
<strong>Giordani Cleaning</strong>.

</p>

<div class="footer">

<br><br><br>

____________________________________

<br>

Giordani Cleaning

</div>

';

$options = new Options();

$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream(

"recibo-".$agenda['os_numero'].".pdf",

array("Attachment" => false)

);