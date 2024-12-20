@extends('layout/auth-layout')

@section('title', 'Registro')

@section('body')

@section('legend', 'Registro')

<form action="/registro" method="post" autocomplete="on" id="form">
    @csrf
    <label for='iemail' class="lead">Email:</label><br><input type='text' name='email' id='iemail' minlength='4' required><br>
    <label for='iname' class="lead">Nome:</label><br><input type='text' name='name' id='iname' maxlength='30' minlength='4' required><br>
    <label for='ilastname' class='mb-1 lead'>Sobrenome:</label><br><input type='text' name='lastname' id='ilastname' maxlength='30' minlength='4' required><br>
    <label for='istate' class='mb-1 lead'>Estado:</label><br><select name='state' id='istate' class='p-1' style='width: 199px;' required>
        <option value='AC'>Acre</option>
        <option value='AL'>Alagoas</option>
        <option value='AP'>Amapá</option>
        <option value='AM'>Amazonas</option>
        <option value='BA'>Bahia</option>
        <option value='CE'>Ceará</option>
        <option value='DF'>Distrito Federal</option>
        <option value='ES'>Espírito Santo</option>
        <option value='GO'>Goiás</option>
        <option value='MA'>Maranhão</option>
        <option value='MT'>Mato Grosso</option>
        <option value='MS'>Mato Grosso do Sul</option>
        <option value='MG'>Minas Gerais</option>
        <option value='PA'>Pará</option>
        <option value='PB'>Paraíba</option>
        <option value='PR'>Paraná</option>
        <option value='PE'>Pernambuco</option>
        <option value='PI'>Piauí</option>
        <option value='RJ'>Rio de Janeiro</option>
        <option value='RN'>Rio Grande do Norte</option>
        <option value='RS'>Rio Grande do Sul</option>
        <option value='RO'>Rondônia</option>
        <option value='RR'>Roraima</option>
        <option value='SC'>Santa Catarina</option>
        <option value='SP'>São Paulo</option>
        <option value='SE'>Sergipe</option>
        <option value='TO'>Tocantins</option>
    </select> <br>
    <label for='icity' class="lead">Cidade:</label><br><input type='text' name='city' id='icity' title='Somente primeira letra maiúscula mínimo de 3 caracteres' maxlength='20' required><br>
    <label for='ipass1' class='mt-1 lead'>Insira sua Senha:</label><br><input type='password' class='p-1' name='pass1' id='ipass1' autocomplete='current-password' minlength='8' required maxlength='15' placeholder=' Senha'><br>
    <label for='ipass2' class='mt-1 lead'>Repita a Senha:</label><br><input type='password' class='p-1' name='pass2' id='ipass2' autocomplete='current-password' required minlength='8' maxlength='15' placeholder=' Repita Senha'><br> <input class='btn btn-success my-2' type='submit' value='Entrar'>
</form>

@endsection