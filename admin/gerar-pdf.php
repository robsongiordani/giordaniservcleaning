<?php

require '../vendor/autoload.php';

use Dompdf\Dompdf;
use Dompdf\Options;

include '../config/conexao.php';

$id = $_GET['id'];

$orcamento = $db->querySingle("

SELECT
orcamentos.*,
clientes.nome,
clientes.telefone,
clientes.endereco

FROM orcamentos

LEFT JOIN clientes
ON clientes.id = orcamentos.cliente_id

WHERE orcamentos.id = '$id'

", true);

$itens = $db->query("

SELECT *
FROM itens_orcamento

WHERE orcamento_id = '$id'

");

function base64Image($path){

    $type = pathinfo($path, PATHINFO_EXTENSION);

    $data = file_get_contents($path);

    return 'data:image/' . $type . ';base64,' . base64_encode($data);
}

$logo =
base64Image(
__DIR__ . '/../assets/img/logo.png'
);

$caricatura =
base64Image(
__DIR__ . '/../assets/img/caricatura.png'
);

$html = '

<style>

@page {
    margin: 20px;
}

body{

    font-family: DejaVu Sans;

    color:#0f172a;

    font-size:12px;

    padding:25px;
}

.container{

    border:1px solid #dbeafe;

    border-radius:20px;

    padding:30px;
}

.header-table{

    width:100%;

    border:none;

    margin-bottom:25px;
}

.header-table td{

    border:none;

    vertical-align:top;
}

.logo{

    width:120px;

    margin-bottom:10px;
}

.caricatura{

    width:180px;
}

.title{

    font-size:32px;

    color:#1e3a8a;

    font-weight:bold;

    margin-bottom:10px;
}

.info{

    color:#334155;

    line-height:1.6;
}

.orcamento-title{

    margin-top:20px;

    font-size:20px;

    color:#2563eb;

    font-weight:bold;
}

.cliente-box{

    background:#f8fafc;

    padding:15px;

    border-radius:12px;

    margin-top:20px;

    border:1px solid #e2e8f0;
}

.cliente-box p{

    margin:5px 0;
}

table.servicos{

    width:100%;

    border-collapse:collapse;

    margin-top:25px;
}

table.servicos th{

    background:#2563eb;

    color:white;

    padding:12px;

    text-align:left;

    font-size:12px;
}

table.servicos td{

    border:1px solid #dbeafe;

    padding:12px;

    font-size:12px;

    color:#000000;
}

.cliente-box p,
.info p{

    color:#000000;
}

.total{

    margin-top:25px;

    text-align:right;
}

.total h2{

    color:#2563eb;

    font-size:28px;
}

.footer{

    margin-top:40px;

    text-align:center;

    color:#64748b;

    font-size:11px;
}

</style>

<div class="container">

<table class="header-table">

<tr>

<td width="70%">

<img
src="'.$logo.'"
class="logo">

<div class="title">
Giordani Cleaning
</div>

<div class="info">

<p>
(47) 99213-2615
</p>

<p>
(47) 99183-3664
</p>

<p>
Serviços de Limpeza,
Lavanderia e Manutenção
</p>

<p>
Atendimento em Balneário Piçarras,
Penha e Barra Velha
</p>

</div>

</td>

<td width="30%" align="right">

<img
src="'.$caricatura.'"
class="caricatura">

</td>

</tr>

</table>

<div class="orcamento-title">

ORÇAMENTO #'.$orcamento['id'].'

</div>

<div class="cliente-box">

<p>

<strong>Cliente:</strong>
'.$orcamento['nome'].'

</p>

<p>

<strong>Telefone:</strong>
'.$orcamento['telefone'].'

</p>

<p>

<strong>Endereço:</strong>
'.$orcamento['endereco'].'

</p>

<p>

<strong>Data:</strong>
'.$orcamento['data'].'

</p>

</div>

<table class="servicos">

<thead>

<tr>

<th>Serviço</th>
<th>Descrição</th>
<th>Valor</th>

</tr>

</thead>

<tbody>

';

while($item = $itens->fetchArray()){

    $html .= '

    <tr>

    <td>
    '.$item['servico'].'
    </td>

    <td>
'.$item['descricao'].'
</td>

    <td>

    R$ '.number_format(
    $item['valor'],
    2,
    ',',
    '.'
    ).'

    </td>

    </tr>

    ';
}

$html .= '

</tbody>

</table>

<div class="total">

<h2>

Total:
R$ '.number_format(
$orcamento['total'],
2,
',',
'.'
).'

</h2>

</div>

<div class="footer">

<p>
Giordani Cleaning ©
</p>

<p>
Muito obrigado pela preferência!
</p>

</div>

</div>

';

$options = new Options();

$options->set('isRemoteEnabled', true);

$dompdf = new Dompdf($options);
$dompdf->loadHtml(
mb_convert_encoding(
$html,
'HTML-ENTITIES',
'UTF-8'
)
);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream(

"orcamento-".$orcamento['id'].".pdf",

array("Attachment" => true)

);

?>