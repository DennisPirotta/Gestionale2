<div>
    <table class="w-full text-center">
        <thead>
            <tr>
                <td>#</td>
                @foreach(\Carbon\CarbonPeriod::create($start,$end) as $day)
                    <th scope="col">{{ $day->translatedFormat('D') }}<br>{{ $day->format('j') }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @include('livewire.hours.other-hours')
        </tbody>
    </table>

<script>
    $(()=>{
        Livewire.on('hourAdded', () =>{
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                icon: 'success',
                title: 'Ora creata con successo'
            })
        })
        Livewire.on('hourUpdated', () =>{
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                icon: 'success',
                title: 'Ora aggiornata con successo'
            })
        })
        Livewire.on('hourDeleted', () =>{
            Swal.fire({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                icon: 'success',
                title: 'Ora eliminata con successo'
            })
        })
    })
</script>
</div>
