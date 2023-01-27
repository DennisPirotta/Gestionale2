<script src="https://code.jquery.com/jquery-3.6.2.min.js" integrity="sha256-2krYZKh//PcchRtd+H+VyyQoZ/e3EcrkxhM8ycwASPA=" crossorigin="anonymous"></script>
<style>
    td, th {
        border: 1px solid black;
        width: 20px;
        max-width: 20px;
        text-align: center;
        background-color: #a7dcea;
        padding: 5px;
    }

    data{
        display: none;
    }

    th[scope=row] {
        min-width: 100px !important;
    }

    table {
        width: 100%;
        border-spacing: 0;
        border-collapse: collapse;
    }

    @media print {
        @page {
            size: landscape
        }
    }
</style>
<table>
    <thead>
    <tr>
        <th scope="col" class="py-2 px-4">
            #
        </th>
        @foreach($period as $day)
            <th scope="col">{{ $day->format('D j') }}</th>
        @endforeach
    </tr>
    </thead>
    <tbody>
        @include('hours.partial.order-table-section')
        @include('hours.partial.technical-report-table-section')
        @include('hours.partial.other-hours-table-section')
    </tbody>
</table>

<script>
    $(()=>{
        $('td > div[data-technical-report-id]').on('focusout',(e)=>{
            let val = $(e.target).find('data').text()
            if (val){
                // ora presente
            }else{
                // ora nuova
            }
        })
    })
</script>
