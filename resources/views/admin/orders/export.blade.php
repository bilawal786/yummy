<table class="table table-striped" id="maintable">
    <thead>
    <tr>
        <th>{{ __('Numéro') }}</th>
        <th>{{ __('Nom') }}</th>
        <th>{{ __('Commerçant') }}</th>
        <th>{{ __('Date') }}</th>
        <th>{{ __('Status') }}</th>
        <th>{{ __('Total') }}</th>
    </tr>
    </thead>
    <tbody>
    @foreach($orders as $row)
        <tr>
            <td>{{$row->order_code}}</td>
            <td>{{$row->user->first_name}} {{$row->user->last_name}}</td>
            <td>{{$row->shop->user->first_name}} {{$row->shop->user->last_name}}</td>
            <td>{{\Carbon\Carbon::parse($row->created_at)->format('d M Y, H:i')}}</td>
            <td>
                @if ($row->status == 20)
                    Vendu
                @elseif ($row->status == 10)
                    Annuler
                @else
                    Prêt à récupérer
                @endif
            </td>
            <td>{{$row->total.'€'}}</td>

        </tr>
    @endforeach
    </tbody>
</table>