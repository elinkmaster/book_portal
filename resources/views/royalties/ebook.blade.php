@extends('layouts.authenticated')

@section('content')
    <div class="container ">
        <div class="p-3 my-3 w-100 ">
            <div class="d-flex">
            
                <form action="{{ route('er.search') }}" method="get" class="d-flex gap-2">
                    <div class="form-group my-2">
                        <select name="author_id" id="author_id" class="form-control select2 w-50">
                            <option value="all" selected>Search Author</option>
                            @foreach ($author as $x)
                                @if (request()->get('id') == $x->id)
                                    <option value="{{ $x->id }}" selected>{{ $x->firstname}} {{ $x->lastname}}</option>
                                @else
                                    <option value="{{ $x->id }}">{{ $x->firstname}} {{ $x->lastname}}</option>
                                @endif
                            @endforeach
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                                class="bi bi-search" viewBox="0 0 16 16">
                                <path
                                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
                <div class="d-flex-right">
                     
                    <span>
                    <form action="{{ route('er.sort') }}" method="get">
                    <label >Sort</label>
                  
                        
                        <select name="sort" value="Sort" id="sort" class="form-control">
                          <option value="ASC">Sort By Author (ASC)</option>
                          <option value="DESC">Sort By Author (DESC)</option>
                          <option value="EASC">Sort By Author and Royalty (ASC)</option>
                          <option value="EDSC">Sort By Author and Royalty (DESC)</option>
                        </select>
                        <button type="submit" class="btn btn-sm btn-primary">
                           SORT
                        </button>
            
                </form>
                OR
                 <form action="{{ route('er.filter') }}" method="get">
                     <label >Filter By Year</label>
                     <select name="years" id="years" class="form-select">
                                <option value="" disabled selected>Select Year</option>
                                <option value="all" >All</option>
                               
                                @for ($x = 2017; $x <= now()->year; $x++)
                                    <option value="{{ $x }}">{{ $x }}</option>
                                @endfor
                            </select>
                         
                        
                         <button type="submit" class="btn btn-sm btn-primary">
                            Sort
                         </button>
             
                 </form>
                </span>
                    </div> 
                <div class="ms-auto">
                <div class="d-flex-right" style="padding-left:525px;">
                     
                     <span>
                     <form action="{{ route('er.search') }}" method="get">
                     <label >Sort By month</label>
                     <select name="months" id="months" class="form-select">
                                <option value="" disabled selected>Select one</option>
                                <option value="all" >All</option>
                                @foreach ($months as $key => $value)
                                   
                                        <option value="{{$key}}" selected>{{$value}}</option>
                                   
                                @endforeach
                            </select>
                         
                        
                         <button type="submit" class="btn btn-sm btn-primary">
                            SORT
                         </button>
             
                 </form>
                 </span>
                     </div>  
                </div>
            </div>
            <div class="bg-light p-2 shadow rounded">
                <h5 class="text-center my-3">Ebook Royalty</h5>
                <table class="table table-bordered table-hover mt-2">
                    <thead>
                        <tr class="text-center">
                            <th>Author</th>
                            <th>Book</th>
                            <th>Year</th>
                            <th>Month</th>
                            <th>Trade Class</th>
                            <th>CopySold</th>
                            <th>Price</th>
                            <th>Revenue</th>
                            <th>Royalty</th>
                    
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($ebook_transactions as $ebook)
                            <tr>
                                <td>{{ $ebook->author->firstname }} {{ $ebook->author->lastname }}</td>
                                <td>{{ Str::title($ebook->book->title) }}</td>
                                <td>{{ $ebook->year }}</td>
                                <td>{{ App\Helpers\MonthHelper::getStringMonth($ebook->month) }}</td>
                            
                                <td>{{ $ebook->class_of_trade }}</td>
                                
                                <td>{{ $ebook->quantity }}</td>
                               
                                <td>${{ number_format($ebook->price,2) }}</td>
                              
                                <td>${{ number_format($ebook->price * $ebook->quantity,2)  }}</td>
                             
                             
                                <td>${{ number_format($ebook->proceeds /2 ,2)  }}</td>
                             
                            </tr>
                        @empty
                            <tr>
                                <td colspan="11" class="text-center">No record found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-2">
            {{ $ebook_transactions->withQueryString()->links() }}
            </div>
        </div>
    </div>
    <script>
        // In your Javascript (external .js resource or <script> tag)
        $(document).ready(function() {
            $('.select2').select2();
        });
    </script>
@endsection
