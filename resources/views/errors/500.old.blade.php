@extends('errors::layout')

@section('title', 'Error')

@section('message')

    <style type="text/css">
        .red-system {
            background-color: red;
            padding: 4px 10px;
            border-radius: 12px;
            color: white;
            text-decoration: none;
        }
        .red-system:hover {
            text-decoration: underline;
        }
    </style>

    {!! 'Whoops, sepertinya ada yang salah. <br />
    '.(isset($incidentCode) ? 'Mohon Kontak <a href="http://www.redsystem.id" target="_blank" class="red-system">Red System</a> <br /><br />
    dengan Kode : '.$incidentCode : '') !!}
@endsection

