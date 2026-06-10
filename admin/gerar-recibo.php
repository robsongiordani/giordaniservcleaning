<?php

ob_start();

error_reporting(E_ALL);
ini_set('display_errors', 0);

require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config/conexao.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$servicos = $_POST['servicos'] ?? [];

if(empty($servicos)){
    die('Nenhum serviço selecionado.');
}

$ids = implode(',', array_map('intval', $servicos));

$dados = $db->query("

SELECT
historico_servicos.*,
clientes.cpf_cnpj,
clientes.endereco,
clientes.telefone

FROM historico_servicos

LEFT JOIN clientes
ON clientes.nome = historico_servicos.cliente

WHERE historico_servicos.orcamento_id IN ($ids)

ORDER BY data_execucao ASC

");

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

$linhas = '';

$total = 0;
$cliente = '';
$cpf_cnpj = '';
$endereco = '';
$telefone = '';

while($item = $dados->fetchArray()){

    $cliente = $item['cliente'];

    $cpf_cnpj = $item['cpf_cnpj'];
$endereco = $item['endereco'];
$telefone = $item['telefone'];

    $total += $item['valor'];

    $linhas .= '

    <tr>

        <td style="text-align: center;">'.$item['data_execucao'].'</td>

        <td style="text-align: center;">'.$item['servico'].'</td>

        <td style="text-align: center;">R$ '.number_format(
            $item['valor'],
            2,
            ',',
            '.'
        ).'</td>

    </tr>

    ';
}

$nomeArquivo = 'recibo.pdf';

$html = '

<style>

body{
    font-family: DejaVu Sans;
    padding:25px;
    color:#111827;
    font-size:12px;
}

h1{
    color:#2563eb;
    margin-bottom:12px;
    text-align:center;
    font-size:24px;
}

.box{
    border:1px solid #ddd;
    border-radius:12px;
    padding:14px;
    margin-bottom:17px;
}

.box p{
    margin:8px 0;
}

.footer{
    margin-top:50px;
    text-align:center;
}

</style>

<table style="width:100%; margin-bottom:30px;">

<tr>

<td style="width:160px; border:none;">

<img src="'.$logo.'" style="width:180px;">

</td>

<td style="border:none; vertical-align:top;">

<h2 style="
margin:0;
color:#1e3a8a;
font-size:18px;
">

Giordani Cleaning (059.766.909-04)
Fernanda e Robson

</h2>

<p style="margin:4px 0;">
Serviços de Limpeza, Lavanderia e Pequenas Manutenções
</p>

<p style="margin:4px 0;">
Balneário Piçarras - SC
</p>

<p style="margin:4px 0;">
(47) 99183-6334 | (47) 99213-2615
</p>

<p style="margin:4px 0;">
cleaning.giordani.net.br
</p>

</td>

</tr>

</table>

<h1>RECIBO DE SERVIÇO</h1>

<div class="box">

<p>
<strong>Cliente:</strong>
'.$cliente.'
</p>

<p>
<strong>CPF/CNPJ:</strong>
'.$cpf_cnpj.'
</p>

<p>
<strong>Endereço:</strong>
'.$endereco.'
</p>

<p>
<strong>Telefone:</strong>
'.$telefone.'
</p>

</div>

<table
style="width:100%;
border-collapse:collapse;
margin-top:20px;">

<tr>

<th style="
background:#2563eb;
color:white;
padding:11px;">
Data
</th>

<th style="
background:#2563eb;
color:white;
padding:12px;">
Serviço
</th>

<th style="
background:#2563eb;
color:white;
padding:12px;">
Valor
</th>

</tr>

'.$linhas.'

</table>

<div style="
margin-top:25px;
border:1px solid #d1d5db;
border-radius:10px;
padding:16px;
">

<table style="
width:100%;
border:none;
">

<tr>

<td style="
border:none;
font-size:18px;
font-weight:bold;
">

Total dos serviços prestados:

</td>

<td style="
border:none;
text-align:left;
font-size:28px;
font-weight:bold;
color:#2563eb;
width:220px;
">

R$ '.number_format(
$total,
2,
',',
'.'
).'

</td>

</tr>

</table>

</div>

<p>


Declaramos que os serviços acima foram executados pela
<strong>Giordani Cleaning</strong>.

</p>

<div class="footer">

<br><br>

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

if(empty($linhas)){
    die('Nenhum serviço encontrado.');
}

$dompdf->render();

while (ob_get_level()) {
    ob_end_clean();
}

$dompdf->stream(
    $nomeArquivo,
    array("Attachment" => false)
);

exit;