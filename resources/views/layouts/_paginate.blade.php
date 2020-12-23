<ul class="pagination" role="navigation">
    <?php
        $pageItem_per_nav = 10;
        $current = $posts->currentPage();
        $pageItem_last = ceil($posts->total()/$posts->perPage());
        // Get first nav item(ex. 1,11,21,...)
        $nav_first = (ceil($posts->currentPage()/$pageItem_per_nav)-1)*$pageItem_per_nav+1;
        if( ($pageItem_last-$nav_first) <$pageItem_per_nav){
            $nav_last = $pageItem_last;
        }else{
            $nav_last = $nav_first+$pageItem_per_nav-1;
        }
    ?>
    
    <li class="page-item first-page" aria-disabled="true" aria-label="« first">
        <a class="page-link pre_end" href="{{$posts->url(1)}}" rel="prev" aria-label="First">
            <img src="{{ asset('img/bbs_pre_end.gif') }}" alt="">
        </a>
    </li>
    <li class="page-item prev-nav" aria-disabled="true" aria-label="« Previous">
        @if($current<=$pageItem_per_nav)
            <span class="page-link pre" aria-hidden="true"><img src="{{ asset('img/bbs_pre.gif') }}" alt=""></span>
        @else
            <a class="page-link pre" href="{{$posts->url($nav_first-$pageItem_per_nav)}}" rel="prev" aria-label="Prev">
                <img src="{{ asset('img/bbs_pre.gif') }}" alt="">
            </a>
        @endif
    </li>
    @for($i = $nav_first; $i <= $nav_last; $i++)
        <li class="page-item @if($current == $i)active @endif">
            @if($current == $i)
                <span class="page-link" aria-hidden="true">{{$i}}</span>
            @else
                <a class="page-link" href="{!! $posts->url($i) !!}">{{$i}}</a>
            @endif
        </li>
    @endfor
    <li class="page-item last-page next-nav">
        @if(($pageItem_last-$nav_first)<$pageItem_per_nav)
            <span class="page-link next" aria-hidden="true"><img src="{{ asset('img/bbs_next.gif') }}" alt=""></span>
        @else
            <a class="page-link next" href="{{$posts->url($nav_first+$pageItem_per_nav)}}" rel="next" aria-label="Next">
                <img src="{{ asset('img/bbs_next.gif') }}" alt="">
            </a>
        @endif
    </li>
    <li class="page-item last-page">
        <a class="page-link next_end" href="{{$posts->url($pageItem_last)}}" rel="next" aria-label="Last »">
            <img src="{{ asset('img/bbs_next_end.gif') }}" alt="">
        </a>
    </li>
</ul>