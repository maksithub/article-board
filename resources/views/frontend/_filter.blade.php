
<div class="row filter">
	<div class="col-md-12">
		<div class="filter_wrapper">
			<ul class="post_filters post_cat theme">
				<li class="cat_item title">테마</li>
				<li class="cat_item"><a href="{{route('index')}}">전체({{$posts_count_all}})</a></li>
				@foreach($categories as $category)
					<li class="cat_item">
						<a href="{{route('index',['cat' => $category->id])}}">{{$category->name}}({{$category->posts_count}})</a>
					</li>
				@endforeach
			</ul>
			<ul class="post_filters post_tag language">
				<li class="cat_item title">언어</li>
				<li class="cat_item"><a href="{{route('index')}}">전체({{$posts_count_all}})</a></li>
				@foreach($langs as $lang)
				<li class="cat_item"><a href="{{route('index',['lang' => $lang->id])}}">{{$lang->name}}({{$lang->posts_count}})</a></li>
				@endforeach
			</ul>
		</div>
	</div>
</div>