<table  class="table table-bordered table-striped">
    <thead>
    <tr>
        <th>Date d'inscription</th>
        <th>Prénom</th>
        <th>Nom</th>
        <th>Email</th>
        <th>Téléphone</th>
        <th>Ville </th>
        <th>Parrainages</th>
    </tr>
    </thead>
    <tbody>
    @foreach($users as $row)
        <tr>
            <td>{{$row->created_at->format('d-m-Y H:i')}}</td>
            <td>{{$row->first_name}}</td>
            <td>{{$row->last_name}}</td>
            <td>{{$row->email}}</td>
            <td>{{$row->phone}}</td>
            <td>{{$row->country->name}}</td>
            @php
                $refferal = \App\Refferal::where('refferal_user', $row->id)->count();
@endphp
            <td>{{$refferal}}</td>
        </tr>
    @endforeach
    </tbody>
</table>