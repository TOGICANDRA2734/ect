<!-- 
    qry1
 -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coba coba</title>
</head>
<body>
    <h1>Date</h1>    
    <!-- <ul>
        <li>Tanggal Awal    : {{$tglAwal->toDateString()}}</li>
        <li>Tanggal Akhir   : {{$tglAwal->endOfMonth()->toDateString()}}</li>
    </ul> -->

    <form method="GET" action="asda">
        <label for="file_sql">File Sql</label>
        <input type="file" name="file_sql" id="file_sql">

        <button>Tekan tombol</button>
    </form>
    

    @foreach ($data as $dt)
    <div class="border border-red-100 pr-2">
        {{$dt->NOM_UNIT}}
        {{$dt->WH}}
        {{$dt->BD}}
        {{$dt->STB}}
        {{$dt->MOHH}}
    </div>
    @endforeach
</body>
</html>