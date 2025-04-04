<x-basedashboard :data="$data" active_link="{{$active_link}}">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Electricity Data</h6>
                    <form action="{{ route('table') }}" method="GET">

                        <div class="row">
                            <div class="col-6">
                                    <label for="" class="input-label">From</label>
                                    <div class="input-group">
                                        <input type="date" class="form-control" name="from" value="{{ request('from') }}">
                                    </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <label for="" class="input-label">To</label>
                                <div class="input-group">
                                    <input type="date" class="form-control" name="to"  value="{{ request('to') }}">
                                </div>
                            </div>
                        </div>
                        <button class="btn btn-sm btn-primary mt-2" type="submit">Filter</button>
                    </form>

                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="table-responsive p-0">
                        <table class="table align-items-center mb-0">
                            <thead>
                                @foreach ($data['table_header'] as $header) 
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        {{ $header }}
                                    </th>                                
                                @endforeach
                            </thead>
                            <tbody>
                                @foreach ($data['table_data'] as $row)
                                    <tr>
                                        @foreach ($data['table_rows'] as $value)
                                            <td class="align-middle text-center text-sm">
                                                <span class="text-xs font-weight-bold">{{ $row[$value] }}</span>
                                            </td>
                                        @endforeach
                                        
                                    </tr>
                                @endforeach
                                
                            </tbody>
                            <tfoot>


                                
                                
                                

                            </tfoot>
                        </table>
                        <div class="container-fluid py-2">
                            <form action="{{ route('table') }}" method="GET">
                        
                                <div class="row align-items-center">
                                    <div class="col ">
                                        <p class="fw-bold text-sm fs-5 opacity-7  @if($data['total_page'] <= 0) {{ 'd-none' }}  @endif">Pages {{ $data['current_page'] }} of {{ $data['total_page'] }}</p>
                                    </div>
                                    <div class="col">
                                        <div class="container-fluid d-flex flex-row justify-content-center">
                                            @for($i = $data['current_page'] - 3; $i <= ($data['current_page']+3) ; $i++)
                                                @if($i <= 0 || $i > $data['total_page']) @continue @endif
                                                
                                                <a href="{{ route('table', array_merge(request()->query(), ['page' => ($i) ])) }}" class=" btn  @if($i == $data['current_page'] ) {{ 'btn-white text-dark opacity-7'  }} @else {{ 'btn-outline-dark text-dark'}} @endif mx-1">{{$i}}</a>
                                            @endfor
                                        </div>
                                    </div>
                                    <div class="col">
                                        <div
                                            class="container-fluid d-flex flex-row justify-content-end @if($data['total_page'] <= 0) {{ 'd-none' }}  @endif">
                                            <a class="text-dark btn btn-outline-dark mx-2 @if($data['current_page'] <= 1)  {{ 'disabled' }} @endif"
                                                href="{{ route('table', array_merge(request()->query(), ['page' => $data['current_page'] - 1])) }}">Prev</a>
                                            <a class="text-dark btn btn-outline-dark mx-2 @if($data['current_page'] >= $data['total_page'])  {{ 'disabled' }} @endif"
                                                href="{{ route('table', array_merge(request()->query(), ['page' => $data['current_page'] + 1])) }}">Next</a>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    

</x-basedashboard>