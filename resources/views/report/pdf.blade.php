@extends('layouts.app')

@section('content')
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
<style type="text/css">
    body{
        background: #ffffff;
        font-family: 'Arial';
    }
</style>

<div class="upper">
    {{-- <div class="image-container">
        <img src="https://readersmagnet.com/wp-content/uploads/2019/08/ReadersMagnet-Favicon.png" height="150px" width="150px" alt="Readers Magnet Image" srcset="">
    </div>
    <div class="detail-container" style="position:absolute; right:0; top:40px;">
        <b style="position: relative; bottom: 10px;">Readers Magnet</b>
        <br>
        <a href="info@readersmagnet.com" style="position: relative; bottom: 10px;">info@readersmagnet.com</a>
        <p>(800) 805-0762</p>
    </div> --}}

    <img src="https://res.cloudinary.com/dadkdj2t7/image/upload/v1660771247/header_m3yppc.png" alt="" srcset="" style="width:100%">
</div>
<div id="lower">
    {{-- <div class="title" style="text-align: center;">
        <h6 style="font-size: 30px;">Royalty Statement</h6>
    </div> --}}
    <div class="details" style="margin-top: 30px;">
       {{$currentDate}}
        <br><br>
        <h6 class="mt-4" style="font-size: 15px;"><b>{{$author->getFullName()}}</b></h6>
    </div>
    <div class="details" style="margin-top: 30px; font-family: calibri;" >
      Dear {{$author->firstname}},<br>
      <br>
      Enclosed is the royalty payment amounting to <strong>${{substr($totalPods['royalty'],0,-1)}}<!--{{$totalRoyalties}}--></strong> ({{$numberFormatter}}).
        <br>
        <span  style="font-size: 15px;">Royalty statement details below:</span>
    </div>

    <div class="transaction" style="margin-top: 30px;">
        <span>Statement Period: <b>{{App\Helpers\MonthHelper::getStringMonth($fromMonth)}} {{$fromYear}}</b> to <b>{{App\Helpers\MonthHelper::getStringMonth($toMonth)}} {{$toYear}}</b></span>
       <br><br>
        @if(count($pods) > 0)
        <table style="width:100%;font-size: 14px; font-family:Courier;">
            <thead style="background-color:#4C403E;border: 1px solid;font-size: 12px; color:#EBD5D1;">
                <tr style="text-align:center;">
                    <th style="border: 1px solid;">Book Title</th>
                    <th style="border: 1px solid;">Format</th>
                    <th style="border: 1px solid;">Month</th>
                    <th style="border: 1px solid;">Year</th>
                    <th style="border: 1px solid;">Copies Sold</th>
                    <th style="border: 1px solid;">Retail Price</th>
                    <th style="border: 1px solid;">Gross Revenue</th>
                    <th style="border: 1px solid;">15% Royalty</th>
                </tr>
            </thead>
            <tbody style="">
                @foreach ($pods as $pod)
                    @if(App\Helpers\UtilityHelper::hasTotalString($pod))
                        <tr>
                            <td colspan="4" style="border: 1px solid; width:90px; background-color:#7BF116 ;"><b>{{$pod['title']}}</b></td>
                            <td style="border: 1px solid; width:70px; background-color:#7BF116 ; text-align:center;"><b>{{$pod['quantity']}}</b></td>
                            <td style="border: 1px solid; width:70px; background-color:#7BF116 ;text-align:center;"><b>${{$pod['price']}}</b></td>
                            <td style="border: 1px solid; width:70px; background-color:#7BF116 ;text-align:center;"><b>${{$pod['revenue']}}</b></td>
                            <td style="border: 1px solid; width:70px; background-color:#7BF116 ;text-align:center;"><b><!--${{$pod['royalty1']}} --> ${{substr($pod['royalty'],0,-1)}}</b></td>
                        </tr>
                    @else
                        <tr>
                            <td style="border: 1px solid; width:230px;" >{{$pod['title']}}</td>
                            <td style="border: 1px solid; width:90px; text-align:center;">{{$pod['format']}}</td>
                            <td style="border: 1px solid; width:50px; text-align:center;">{{App\Helpers\MonthHelper::getStringMonth($pod['month'])}}</td>
                            <td style="border: 1px solid; width:50px; text-align:center;">{{$pod['year']}}</td>
                            <td style="border: 1px solid; width:70px; text-align:center;">{{$pod['quantity']}}</td>
                            <td style="border: 1px solid; width:70px; text-align:center;">{{$pod['price']}}</td>
                            <td style="border: 1px solid; width:70px; text-align:center;">{{$pod['revenue']}}</td>
                            <td style="border: 1px solid; width:70px; text-align:center;">{{substr($pod['royalty'],0,-1)}}</td>
                        </tr>
                    @endif
                @endforeach
                <tr>
                <td colspan="4" style="border: 1px solid; width:90px;  background-color:#B51313; color: #FFFFFF;"><b>{{$totalPods['title']}}</b></td>
                    <td style="border: 1px solid; width:70px;background-color:#B51313; color: #FFFFFF; text-align:center;"><b>{{$totalPods['quantity']}}</b></td>
                    <td style="border: 1px solid; width:70px;background-color:#B51313; color: #FFFFFF; text-align:center;"><b>${{$totalPods['price']}}</b></td>     
        
                    <td style="border: 1px solid; width:70px;background-color:#B51313; color: #FFFFFF; text-align:center;"><b>${{$totalPods['revenue']}}</b></td>
                    <td style="border: 1px solid; width:70px;background-color:#B51313; color: #FFFFFF; text-align:center;"><b><!--${{$totalPods['royalty1']}}--> <i>${{substr($totalPods['royalty'],0,-1)}}</i></b></td>
                </tr>
            </tbody>
        </table>
        @endif
    </div>
    @if(count($ebooks) > 0)
    <div class="transaction" style="margin-top: 30px;">
        <table style="width:100%;font-size: 14px;">
            <thead style="background-color: #e3edf3;border: 1px solid;font-size: 12px;">
                <tr style="text-align:center;">
                    <th style="border: 1px solid;">eBook</th>
                    <th style="border: 1px solid;">Month</th>
                    <th style="border: 1px solid;">Year</th>
                    <th style="border: 1px solid;">Quantity</th>
                    <th style="border: 1px solid;">Retail Price</th>
                    <th style="border: 1px solid;">Author Royalty</th>
                </tr>
            </thead>
            <tbody style="">
                @foreach ($ebooks as $ebook)
                    @if(App\Helpers\UtilityHelper::hasTotalString($ebook))
                    <tr>
                        <td colspan="3" style="border: 1px solid; width:90px; "><b>{{$ebook['title']}}</b></td>
                        <td style="border: 1px solid; width:70px; text-align:center;"><b>{{$ebook['quantity']}}</b></td>
                        <td style="border: 1px solid; width:70px; text-align:center;"><b>${{$ebook['price']}}</b></td>
                        <td style="border: 1px solid; width:70px; text-align:center;">${{$pod['revenue']}}</td>
                        <td style="border: 1px solid; width:70px; text-align:center;"><b>${{$ebook['royalty']}}</b></td>
                    </tr>
                    @else
                    <tr>
                        <td style="border: 1px solid; width:230px;" >{{$ebook['title']}}</td>
                        <td style="border: 1px solid; width:90px; text-align:center;">{{App\Helpers\MonthHelper::getStringMonth($ebook['month'])}}</td>
                        <td style="border: 1px solid; width:50px; text-align:center;">{{$ebook['year']}}</td>
                        <td style="border: 1px solid; width:50px; text-align:center;">{{$ebook['quantity']}}</td>
                        <td style="border: 1px solid; width:70px; text-align:center;">${{$ebook['price']}}</td>
                        <td style="border: 1px solid; width:70px; text-align:center;">${{$ebook['royalty']}}</td>
                    </tr>
                    @endif
                @endforeach
                <tr>
                    <td colspan="3" style="border: 1px solid; width:90px; "><b>{{$totalEbooks['title']}}</b></td>
                    <td style="border: 1px solid; width:70px; text-align:center;"><b>{{$totalEbooks['quantity']}}</b></td>
                    <td style="border: 1px solid; width:70px; text-align:center;"></td>
                    <td style="border: 1px solid; width:70px; text-align:center;"><b>${{$totalEbooks['royalty']}}</b></td>
                </tr>
            </tbody>
        </table>
    </div>
    @endif
    <h5 class="mt-4 my-4" style="font-size: 15px;">Thank You</h5>

    <span style="font-size: 15px;">Sincerely,</span>
    <h5 style="font-size: 15px;"><b>ReadersMagnet Team</b></h5>
</div>

@endsection
