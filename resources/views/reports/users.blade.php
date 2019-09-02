<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<div class="d-flex justify-content-between align-items-center">
    <h2 class="mt-3 mb-3">Lista de usuários</h2>
</div>

<table class="table table-hover" v-if="users">
    <thead>
        <tr>
            <th scope="col">Nome</th>
            <th scope="col">E-mail</th>
            <th scope="col">Telefone</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ preg_replace('/^(\d{2})(\d{5})(\d{4}).*/', '($1) $2-$3', $user->telefone) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
