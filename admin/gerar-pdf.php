<?php

require '../vendor/autoload.php';

use Dompdf\Dompdf;

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

$logo =
__DIR__ . '/../assets/img/logo.png';

$caricatura =
__DIR__ . '/../assets/img/caricatura.png';

$html = '

<style>

body{

    font-family: DejaVu Sans;

    color:#0f172a;

    font-size:13px;

    line-height:1.5;

    padding:30px;
}

.header{

    width:100%;

    border-bottom:3px solid #2563eb;

    padding-bottom:20px;

    margin-bottom:30px;

    position:relative;
}

.logo{

    width:160px;

    margin-bottom:15px;
}

.caricatura{

    width:150px;

    position:absolute;

    top:0;

    right:0;
}

h1{

    color:#1e3a8a;

    font-size:28px;

    margin:0 0 10px 0;
}

h2{

    color:#1e3a8a;

    margin-top:30px;

    font-size:22px;
}

.info p{

    margin:4px 0;

    color:#334155;
}

.cliente{

    margin-top:20px;

    background:#f8fafc;

    padding:18px;

    border-radius:10px;

    border:1px solid #e2e8f0;
}

.cliente p{

    margin:6px 0;
}

table{

    width:100%;

    border-collapse:collapse;

    margin-top:30px;
}

table th{

    background:#2563eb;

    color:white;

    padding:12px;

    font-size:13px;

    text-align:left;
}

table td{

    border:1px solid #ddd;

    padding:12px;

    font-size:12px;
}

.total{

    margin-top:30px;

    text-align:right;
}

.total h2{

    color:#2563eb;

    font-size:30px;
}

.footer{

    margin-top:60px;

    text-align:center;

    color:#64748b;

    font-size:11px;
}

</style>

<div class="header">

<img
src="'.$logo.'"
class="logo">

<img
src="'.$caricatura.'"
class="caricatura">

<h1>Giordani Cleaning</h1>

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

</div>

<h2>

ORÇAMENTO #'.$orcamento['id'].'

</h2>

<div class="cliente">

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

<table>

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

';

$dompdf = new Dompdf();

$dompdf->loadHtml($html);

$dompdf->setPaper('A4', 'portrait');

$dompdf->render();

$dompdf->stream(

"orcamento-".$orcamento['id'].".pdf",

array("Attachment" => true)

);

?>