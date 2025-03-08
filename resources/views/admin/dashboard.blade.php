@extends('layouts.base')

@section('contents')

<div class="dash-c">
    <div class="targhetta">
        <div class="title">
            <img src="https://future-plus.it/img/favicon.png" alt="">
            <a href="https://future-plus.it/">
                <h1 >{{config('configurazione.APP_NAME')}}</h1>
            </a>
           
        </div>
       
        <div class="btns"> 
            
            <a class="my_btn_3 " href="{{route('admin.statistics')}}">  
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-clipboard2-data" viewBox="0 0 16 16">
                    <path d="M9.5 0a.5.5 0 0 1 .5.5.5.5 0 0 0 .5.5.5.5 0 0 1 .5.5V2a.5.5 0 0 1-.5.5h-5A.5.5 0 0 1 5 2v-.5a.5.5 0 0 1 .5-.5.5.5 0 0 0 .5-.5.5.5 0 0 1 .5-.5z"/>
                    <path d="M3 2.5a.5.5 0 0 1 .5-.5H4a.5.5 0 0 0 0-1h-.5A1.5 1.5 0 0 0 2 2.5v12A1.5 1.5 0 0 0 3.5 16h9a1.5 1.5 0 0 0 1.5-1.5v-12A1.5 1.5 0 0 0 12.5 1H12a.5.5 0 0 0 0 1h.5a.5.5 0 0 1 .5.5v12a.5.5 0 0 1-.5.5h-9a.5.5 0 0 1-.5-.5z"/>
                    <path d="M10 7a1 1 0 1 1 2 0v5a1 1 0 1 1-2 0zm-6 4a1 1 0 1 1 2 0v1a1 1 0 1 1-2 0zm4-3a1 1 0 0 0-1 1v3a1 1 0 1 0 2 0V9a1 1 0 0 0-1-1"/>
                </svg> <span>Statistiche</span>
            </a>
            
            
                <a class="my_btn_6 " href="{{route('admin.mailer.index')}}"> 
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-arrow-up" viewBox="0 0 16 16">
                        <path d="M0 4a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v4.5a.5.5 0 0 1-1 0V5.383l-7 4.2-1.326-.795-5.64 3.47A1 1 0 0 0 2 13h5.5a.5.5 0 0 1 0 1H2a2 2 0 0 1-2-1.99zm1 7.105 4.708-2.897L1 5.383zM1 4v.217l7 4.2 7-4.2V4a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1"/>
                        <path d="M12.5 16a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7m.354-5.354 1.25 1.25a.5.5 0 0 1-.708.708L13 12.207V14a.5.5 0 0 1-1 0v-1.717l-.28.305a.5.5 0 0 1-.737-.676l1.149-1.25a.5.5 0 0 1 .722-.016"/>
                      </svg> 
                    <span>Email Marketing</span>
                </a>
            
        </div>
    </div>

    
    <div class="top-c">
        <div class="prod">
            <div class="top-p">
                <a class="title" href="{{ route('admin.products.index') }}"> <h2>Clienti</h2></a>
                <a href="{{ route('admin.products.index') }}" class=" plus icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                    </svg>
                </a>
                <a href="{{ route('admin.products.create') }}" class="plus">
                    <div class="line"></div>
                    <div class="line l2"></div>
                </a>
            </div>
            <div class="stat-p">
                <div class="stat">
                    <h2>{{$product_[1]}}</h2>
                    <span>acquisiti</span>
                </div>
                <div class="stat">
                    <h2>{{$product_[2]}}</h2>
                    <span>in prova</span>
                </div>
                <div class="stat">
                    <h2>{{$stat[1]}}</h2>
                    <span>da contattare</span>
                </div>
                <div class="stat">
                    <h2>{{$stat[2]}}</h2>
                    <span>ingredienti</span>
                </div>
            </div>
          
        </div>      
        
            <div class="right-t">
                
                <div class="result-bar">
                    
                    <div class="stat">
                        <h2>€{{$traguard[1] / 100}}</h2>
                        <span>questo mese</span>
                    </div>
                    
                    
                    <div class="stat">
                        <h2> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                            </svg>
                            {{$traguard[3]}}</h2>
                        <span>questo mese</span>
                    </div>
                    
                    
                    <div class="stat">
                        <h2>€{{$traguard[2] / 100}}</h2>
                        <span>questo anno</span>
                    </div>
                    
                    
                    <div class="stat">
                        <h2> 
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-people-fill" viewBox="0 0 16 16">
                            <path d="M7 14s-1 0-1-1 1-4 5-4 5 3 5 4-1 1-1 1zm4-6a3 3 0 1 0 0-6 3 3 0 0 0 0 6m-5.784 6A2.24 2.24 0 0 1 5 13c0-1.355.68-2.75 1.936-3.72A6.3 6.3 0 0 0 5 9c-4 0-5 3-5 4s1 1 1 1zM4.5 8a2.5 2.5 0 1 0 0-5 2.5 2.5 0 0 0 0 5"/>
                            </svg>
                            {{$traguard[4]}}</h2>
                        <span>questo anno</span>
                    </div>
                    
                </div>
                

                <div class="delivery-c">
                    <div class="top-p">
                        <a class="title" href="{{ route('admin.orders.index') }}"> <h3>Pacchetti attivi</h3></a>
                        <a href="{{ route('admin.orders.index') }}" class=" plus icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-boxes" viewBox="0 0 16 16">
                                <path d="M7.752.066a.5.5 0 0 1 .496 0l3.75 2.143a.5.5 0 0 1 .252.434v3.995l3.498 2A.5.5 0 0 1 16 9.07v4.286a.5.5 0 0 1-.252.434l-3.75 2.143a.5.5 0 0 1-.496 0l-3.502-2-3.502 2.001a.5.5 0 0 1-.496 0l-3.75-2.143A.5.5 0 0 1 0 13.357V9.071a.5.5 0 0 1 .252-.434L3.75 6.638V2.643a.5.5 0 0 1 .252-.434zM4.25 7.504 1.508 9.071l2.742 1.567 2.742-1.567zM7.5 9.933l-2.75 1.571v3.134l2.75-1.571zm1 3.134 2.75 1.571v-3.134L8.5 9.933zm.508-3.996 2.742 1.567 2.742-1.567-2.742-1.567zm2.242-2.433V3.504L8.5 5.076V8.21zM7.5 8.21V5.076L4.75 3.504v3.134zM5.258 2.643 8 4.21l2.742-1.567L8 1.076zM15 9.933l-2.75 1.571v3.134L15 13.067zM3.75 14.638v-3.134L1 9.933v3.134z"/>
                            </svg>
                        </a>
                        {{-- <a href="https://demo3-futureplus.netlify.app/ordina" class="plus">
                            <div class="line"></div>
                            <div class="line l2"></div>
                        </a> --}}
                    </div>
                    <div class="stat-p">
                        <div class="grup">
                            <div class="stat">
                                <h3>{{$order[2]}}</h3>
                                <span>Sponsor</span>
                            </div>
                            <div class="stat">
                                <h3>{{$order[1]}}</h3>
                                <span>Essentials</span>
                            </div>
                        </div>
                        <div class="grup">
                            <div class="stat">
                                <h3>{{$order[3]}}</h3>
                                <span>Work on</span>
                            </div>
                            <div class="stat">
                                <h3>{{$order[4]}}</h3>
                                <span>Boost up</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        
        <div class="prod post">  
            <div class="top-p">
                <a class="title" href="{{ route('admin.posts.index') }}"> <h2>Post</h2></a>
                <a href="{{ route('admin.posts.index') }}" class=" plus icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-list-ul" viewBox="0 0 16 16">
                        <path fill-rule="evenodd" d="M5 11.5a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h9a.5.5 0 0 1 0 1h-9a.5.5 0 0 1-.5-.5m-3 1a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2m0 4a1 1 0 1 0 0-2 1 1 0 0 0 0 2"/>
                      </svg>
                </a>
                <a href="{{ route('admin.posts.create') }}" class="plus">
                    <div class="line"></div>
                    <div class="line l2"></div>
                </a>
                
            </div>
            <div class="stat-p">
                <div class="stat">
                    <h2>{{$post[1]}}</h2>
                    <span>totali</span>
                </div>
                <div class="stat">
                    <h2>{{$post[2]}}</h2>
                    <span>pronti</span>
                </div>
                <div class="stat">
                    <h2>{{$post[3]}}</h2>
                    <span>postati</span>
                </div>
                <div class="stat">
                    <h2>{{$post[4]}}</h2>
                    <span>archiviati</span>
                </div>
            </div>   
        </div>
    </div>
    <div class="bottom-c">
        {{-- <div class="date">

                <div class="date_index">
                    <div id="carouselExampleIndicators" class="carousel slide my_carousel">
                        <div class="carousel-indicators">

                            @php 
                                $i = 0; 
                                $currentDay = date("d");
                                $currentMonth = date("m");
                                $currentYear = date("Y");
                            @endphp
                            @foreach ($year as $m)
                                <button  type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="{{$i}}"

                                    class="active" aria-current="true" 
                                
                                aria-label="{{ 'Slide ' . $i }}"></button>
                                @php $i ++ @endphp
                            @endforeach
                        </div>
                        <div class="carousel-inner">
                        @php $i = 0; @endphp
                        @foreach ($year as $m)
                            <div class="carousel-item

                                active 
                            
                            ">
                                
                                <h2 class="my">{{['', 'gennaio', 'febbraio', 'marzo', 'aprile', 'maggio', 'giugno', 'luglio', 'agosto', 'settembre', 'ottobre', 'novembre', 'dicembre'][$m['month']]}} - {{$m['year']}}</h2>
                                <div class="calendar-c">
                                    <a href="{{route('admin.dates.index')}}" class="date-set">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-wide-connected" viewBox="0 0 16 16">
                                            <path d="M7.068.727c.243-.97 1.62-.97 1.864 0l.071.286a.96.96 0 0 0 1.622.434l.205-.211c.695-.719 1.888-.03 1.613.931l-.08.284a.96.96 0 0 0 1.187 1.187l.283-.081c.96-.275 1.65.918.931 1.613l-.211.205a.96.96 0 0 0 .434 1.622l.286.071c.97.243.97 1.62 0 1.864l-.286.071a.96.96 0 0 0-.434 1.622l.211.205c.719.695.03 1.888-.931 1.613l-.284-.08a.96.96 0 0 0-1.187 1.187l.081.283c.275.96-.918 1.65-1.613.931l-.205-.211a.96.96 0 0 0-1.622.434l-.071.286c-.243.97-1.62.97-1.864 0l-.071-.286a.96.96 0 0 0-1.622-.434l-.205.211c-.695.719-1.888.03-1.613-.931l.08-.284a.96.96 0 0 0-1.186-1.187l-.284.081c-.96.275-1.65-.918-.931-1.613l.211-.205a.96.96 0 0 0-.434-1.622l-.286-.071c-.97-.243-.97-1.62 0-1.864l.286-.071a.96.96 0 0 0 .434-1.622l-.211-.205c-.719-.695-.03-1.888.931-1.613l.284.08a.96.96 0 0 0 1.187-1.186l-.081-.284c-.275-.96.918-1.65 1.613-.931l.205.211a.96.96 0 0 0 1.622-.434zM12.973 8.5H8.25l-2.834 3.779A4.998 4.998 0 0 0 12.973 8.5m0-1a4.998 4.998 0 0 0-7.557-3.779l2.834 3.78zM5.048 3.967l-.087.065zm-.431.355A4.98 4.98 0 0 0 3.002 8c0 1.455.622 2.765 1.615 3.678L7.375 8zm.344 7.646.087.065z"/>
                                        </svg>
                                    </a>
                                    <div class="c-name">
                                        @php
                                        $day_name = ['lunedì', 'martedì', 'mercoledì', 'giovedì', 'venerdì', 'sabato', 'domenica'];
                                        @endphp
                                        @foreach ($day_name as $item)
                                            <h4>{{$item}}</h4>
                                        @endforeach
                                    </div>
                                    <div class="calendar">

                                        @foreach ($m['days'] as $d)
                                           
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @php $i ++ @endphp
                        @endforeach

                        </div>
                        <button class="carousel-control-prev" style="width: 7% !important;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                            <div class="lez-c prev">
                                <div class="line"></div>
                                <div class="line l2"></div>
                            </div>
                        </button>
                        <button class="carousel-control-next" style="width: 7% !important;" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                            <div class="lez-c ">
                                <div class="line"></div>
                                <div class="line l2"></div>
                            </div>
                        </button>
                    </div>
                </div>
            
            
            <div class="date-off d-back-g">
                <a href="https://future-plus.it/#pacchetti">Per permettere ai tuoi clienti di prenotare tavoli o ordinare a domicilio o asporto clicca qui e <strong>prenota una call con i nostri consulenti</strong></a>
            </div>
              
            <div class="date-off">
                <a href="{{route('admin.dates.index')}}">Non sono ancora state impostate le disponibilita dei servizi, <strong>clicca QUI</strong> e impostale ora</a>
            </div>
            
            
            <div class="chart">
                <canvas id="chartCanvas"></canvas>
            </div>
            
        </div> --}}
        <form class="setting" action="{{ route('admin.settings.updateAll')}}" method="POST" enctype="multipart/form-data">
            <h2>
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-sliders" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M11.5 2a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M9.05 3a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0V3zM4.5 7a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3M2.05 8a2.5 2.5 0 0 1 4.9 0H16v1H6.95a2.5 2.5 0 0 1-4.9 0H0V8zm9.45 4a1.5 1.5 0 1 0 0 3 1.5 1.5 0 0 0 0-3m-2.45 1a2.5 2.5 0 0 1 4.9 0H16v1h-2.05a2.5 2.5 0 0 1-4.9 0H0v-1z"/>
                </svg>
            Impostazioni</h2>
            
        
        </form>
    </div>



    
    
</div>






@endsection

