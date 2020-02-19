<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{$colaborador->rut}}</title>
    {{-- <link href="https://fonts.googleapis.com/css?family=Roboto:300,300i,400,400i,500,500i&display=swap" rel="stylesheet"> --}}
</head>
<body>
    <style>
 body{
    margin:-50px -50px -50px -50px;
    /* font-family: 'Open Sans', sans-serif; */
}
p{
            font-family: 'Roboto', sans-serif !important;
        }
table {
  border-collapse: collapse;
}

table, td, th {
  border: 0px solid black;
}

/* .tabla td th{
    border: 0px solid black;
} */
.main{
    margin: 0;
}
.footer{
    text-align: center;
    font-size:12pt;
    margin-top:120px;
    margin-bottom:80px;
}
.line{
    width:50%;
    margin-bottom:1px;
    padding-bottom: 0px;
    margin-top:30px;
}
.end-body{
    font-size:12pt
}

.nombre {
    position: relative;
    top: 276;
    left: 50%;
    transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
}
.rut{
     position: relative;
    top: 265;
    left: 50%;
    transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    font-size: 18px;
}
h1{
    text-align:center;
    letter-spacing: 1;
}
.texto-libre {
     position: relative;
    top: 335;
    left: 50%;
    transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    font-size: 14px;
}
.texto-libre2 {
     position: relative;
    top: 275;
    left: 50%;
    transform: translateX(-50%);
    -webkit-transform: translateX(-50%);
    -ms-transform: translateX(-50%);
    font-size: 16px;
}
.titulo {
    position: relative;
    top: 220;
    left: 47%;
    transform: translateX(-52%);
    -webkit-transform: translateX(-52%);
    -ms-transform: translateX(-52%);
    padding-left: 55px;
    padding-right: 195px;
    font-size: 12px;
    letter-spacing: 0.5;
    color: #00B5B5;
}

    </style>

<div class="main">
    <img src="{{url('img/DIPLOMA_FONDO.jpg')}}" style="width:100%;position:absolute;left:0;top:0" />

    <div class="nombre">
        <h1>{{$colaborador->primer_nombre}} {{$colaborador->apellido_paterno}} {{$colaborador->apellido_materno}}</h1>
    </div>
    <div class="rut">
        <p style="text-align:center; font-weight: bold;">{{$colaborador->rut}}</p>
    </div>
    <div class="texto-libre2">
        <p style="text-align:center;">{{$curso->anio}}

    </div>
    <div class="texto-libre">
        <p style="text-align:center;">{{$curso->realizado}}
        <br>{{$curso->horas_cronologicas}} horas cronológicas</p>
    </div>
     <div class="titulo">
        <h1 style="padding-right: 25px; padding-left: 15px;">{{$curso->titulo}}</h1>
    </div>
</div>
</body>
</html>
