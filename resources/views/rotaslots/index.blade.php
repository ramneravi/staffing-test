@extends('layouts.master')

@section('content')
    <h4>Staff rota shift data</h4>
    
    <table class="table table-bordered" id="rotaslots-table">
        <thead>
            <tr>
                <th></th>
                @foreach($totalHoursByDay as $day => $totalHours)
                    <th> {{intToDayOfWeek($day)}}</th>
                @endforeach
            </tr>
            <tr>
                <td>Staff Id</td>
                @foreach($totalHoursByDay as $day => $totalHours)
                    <td>Time <br />Start - End</td>
                @endforeach
            </tr>
        </thead>
        <tfoot>
            <tr>
                <td>Total working Hrs</td>
                @foreach($totalHoursByDay as $day => $totalHours)
                    <td> {{floatToHoursMinutes($totalHours)}}</td>
                @endforeach
            </tr>
            <tr>
                <td>Staff members worked <br /> alone  in the shop</td>
                @foreach($totalNonOverlapHoursByDay as $day => $totalNonOverlapHours)
                    <td>{{ $totalNonOverlapHours }} mins    </td>
                @endforeach
            </tr>
        </tfoot>
    </table>
    
@stop

@push('scripts')
<script>
    $(function() {
        $('#rotaslots-table').DataTable({
            processing: true,
            serverSide: false,
            bPaginate: false,
            searching: false,
            ajax: '{!! route('rotaslotstaff.data') !!}',
            columns: [
                { data: 'staffId', name: 'StaffId' },
                { data: 0, name: 0 },
                { data: 1, name: 1 },
                { data: 2, name: 2 },
                { data: 3, name: 3 },
                { data: 4, name: 4 },
                { data: 5, name: 5 },
                { data: 6, name: 6 }
            ]

        });
    });
</script>
@endpush
