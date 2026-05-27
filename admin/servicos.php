<form>

<div class="input-group">

<label>Cliente</label>

<select>

<option>Selecionar Cliente</option>
<option>Maria Oliveira</option>

</select>

</div>

<div class="input-group">

<label>Tipo de Serviço</label>

<select name="tipo">

<option>Selecionar Serviço</option>

<option>Faxina</option>
<option>Meia-faxina</option>
<option>Pós-obra</option>
<option>Pós-reforma</option>
<option>Airbnb</option>
<option>Manutenção</option>
<option>Lavanderia</option>

</select>

</div>

<div class="input-group">

<label>Colaborador</label>

<select>

<option>Selecionar Colaborador</option>

<option>João</option>

</select>

</div>

<div class="input-group">

<label>Valor do Atendimento</label>

<input
type="number"
step="0.01"
name="valor"
placeholder="0,00"
required>

</div>

<div class="input-group">

<label>Data</label>

<input type="date">

</div>

<div class="input-group">

<label>Status</label>

<select>

<option>Pendente</option>
<option>Andamento</option>
<option>Concluído</option>

</select>

</div>

<div class="input-group">

<label>Observações</label>

<input
type="text"
placeholder="Observações do serviço">

</div>

<button>

Salvar Atendimento

</button>

</form>