@extends('admin.layout')

@section('content')
    <div class="content">
        <div class="row">
            <div class="col-lg-12">
            @foreach ($hasil_iterasi as $key => $value)
                <div class="card card-default">
                    <div class="card-header card-header-border-bottom">
                        <h2>Iterasi {{$key+1}}</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <th>#</th>
                                <th>C1</th>
                                <th>C2</th>
                                <th>C3</th>
                                <th>C4</th>
                                <th>C5</th>
                                <th>Min</th>
                                <th>cluster</th>
                            </thead>
                            <tbody>
                                @foreach ($value as $key_data => $value_data)
                                <tr>    
                                    <td class="text-center" scope="row">{{ $key_data+1 }}</td>
                                    <!-- <td class="text-center">{{$name[$key_data]}}</td> -->
                                    <td class="text-center">{{$value_data['data'][0]}}</td>
                                    <td class="text-center">{{$value_data['data'][1]}}</td>
                                    <td class="text-center">{{$value_data['data'][2]}}</td>
                                    <td class="text-center">{{$value_data['data'][3]}}</td>
                                    <td class="text-center">{{$value_data['data'][4]}}</td>
                                    <td>{{ $value_data['jarak_terdekat']['value'] }}</td>										
                                    <td>{{ $value_data['jarak_terdekat']['cluster'] }}</td>	
                                </tr>
                                @endforeach
                                
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
@endsection