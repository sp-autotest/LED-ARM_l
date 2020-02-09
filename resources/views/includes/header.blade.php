@php
	$headerClass = (!empty($headerInverse)) ? 'navbar-inverse ' : 'navbar-default ';
	$headerMenu = (!empty($headerMenu)) ? $headerMenu : '';
	$hiddenSearch = (!empty($headerLanguageBar)) ? 'hidden-xs' : '';
	$headerMegaMenu = (!empty($headerMegaMenu)) ? $headerMegaMenu : ''; 
@endphp
<!-- begin #header -->
<div id="header" class="header {{ $headerClass }}">
	<!-- begin navbar-header -->
	<div class="navbar-header">
		<a href="/admin" class="navbar-brand"><img src="/logo_itm.png" style="max-height: 100%;"><span>system</span></a>
		@if (!$sidebarHide)
		<button type="button" class="navbar-toggle" data-click="sidebar-toggled">
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
			<span class="icon-bar"></span>
		</button>
		@endif
		@if ($headerMegaMenu)
			<button type="button" class="navbar-toggle p-0 m-r-5" data-toggle="collapse" data-target="#top-navbar">
				<span class="fa-stack fa-lg text-inverse m-t-2">
					<i class="far fa-square fa-stack-2x"></i>
					<i class="fa fa-cog fa-stack-1x"></i>
				</span>
			</button>
		@endIf
	</div>
	<!-- end navbar-header -->
	
	@includeWhen($headerMegaMenu, 'includes.header-mega-menu')

	<div class="header-info-block">
		<div id="USD">Доллар США $ — 00,0000 руб.</div>
        <div id="EUR">Евро € — 00,0000 руб.</div>
		<div class="balance-block">
			Баланс
			<span>{{ $balance }}</span>
		</div>
		<div class="company-block">
			Компания
			<span>{{ $myCompanyName }}</span>
		</div>
	</div>


<script>
function CBR_XML_Daily_Ru(rates) {
  function trend(current, previous) {
    if (current > previous) return ' ▲';
    if (current < previous) return ' ▼';
    return '';
  }
	
  var USDrate = rates.Valute.USD.Value.toFixed(4).replace('.', ',');
  var USD = document.getElementById('USD');
  USD.innerHTML = USD.innerHTML.replace('00,0000', USDrate);
  USD.innerHTML += trend(rates.Valute.USD.Value, rates.Valute.USD.Previous);

  var EURrate = rates.Valute.EUR.Value.toFixed(4).replace('.', ',');
  var EUR = document.getElementById('EUR');
  EUR.innerHTML = EUR.innerHTML.replace('00,0000', EURrate);
  EUR.innerHTML += trend(rates.Valute.EUR.Value, rates.Valute.EUR.Previous);
}
</script>
<script src="//www.cbr-xml-daily.ru/daily_jsonp.js" async></script>
	<div class="header-splitter"></div>

	<!-- begin header-nav -->
	<ul class="navbar-nav navbar-right">
		<li class="dropdown">
			<a href="/admin/messages" data-toggle="dropdown-item" class="dropdown-toggle f-s-14">
				<i class="fa fa-bell"></i>
				<span class="label">5</span>
			</a>
			<!--
			<ul class="dropdown-menu media-list dropdown-menu-right">
				<li class="dropdown-header">NOTIFICATIONS (5)</li>
				<li class="media">
					<a href="javascript:;">
						<div class="media-left">
							<i class="fa fa-bug media-object bg-silver-darker"></i>
						</div>
						<div class="media-body">
							<h6 class="media-heading">Server Error Reports <i class="fa fa-exclamation-circle text-danger"></i></h6>
							<div class="text-muted f-s-11">3 minutes ago</div>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="javascript:;">
						<div class="media-left">
						@if (isset($profile->avatar))
                        <img src="/storage/avatars/{{ $profile->avatar }}" style="width:50px; height:50px; float:left;" />
                          <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>
                         @else

                          <img src="/assets/img/user/user-2.jpg" style="width:50px; height:50px; float:left;" />
                          <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>
                        @endif
						</div>
						<div class="media-body">
							<h6 class="media-heading">John Smith</h6>
							<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
							<div class="text-muted f-s-11">25 minutes ago</div>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="javascript:;">
						<div class="media-left">
							@if (isset($profile->avatar))

                        <img src="/storage/app/public/avatars/{{ $profile->avatar }}" style="width:50px; height:50px; float:left;" />
                          <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>
                         @else

                          <img src="/assets/img/user/user-2.jpg" style="width:50px; height:50px; float:left;" />
                          <i class="fab fa-facebook-messenger text-primary media-object-icon"></i>
                        @endif

						</div>
						<div class="media-body">
							<h6 class="media-heading">Olivia</h6>
							<p>Quisque pulvinar tellus sit amet sem scelerisque tincidunt.</p>
							<div class="text-muted f-s-11">35 minutes ago</div>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="javascript:;">
						<div class="media-left">
							<i class="fa fa-plus media-object bg-silver-darker"></i>
						</div>
						<div class="media-body">
							<h6 class="media-heading"> New User Registered</h6>
							<div class="text-muted f-s-11">1 hour ago</div>
						</div>
					</a>
				</li>
				<li class="media">
					<a href="javascript:;">
						<div class="media-left">
							<i class="fa fa-envelope media-object bg-silver-darker"></i>
							<i class="fab fa-google text-warning media-object-icon f-s-14"></i>
						</div>
						<div class="media-body">
							<h6 class="media-heading"> New Email From John</h6>
							<div class="text-muted f-s-11">2 hour ago</div>
						</div>
					</a>
				</li>
				<li class="dropdown-footer text-center">
					<a href="javascript:;">View more</a>
				</li>
			</ul>
			-->
		</li>
		@isset($headerLanguageBar)
		<li class="dropdown navbar-language">
			<a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown">
				<span class="flag-icon flag-icon-us" title="us"></span>
				<span class="name">EN</span> <b class="caret"></b>
			</a>
			<ul class="dropdown-menu p-b-0">
				<li class="arrow"></li>
				<li><a href="javascript:;"><span class="flag-icon flag-icon-us" title="us"></span> English</a></li>
				<li><a href="javascript:;"><span class="flag-icon flag-icon-cn" title="cn"></span> Chinese</a></li>
				<li><a href="javascript:;"><span class="flag-icon flag-icon-jp" title="jp"></span> Japanese</a></li>
				<li><a href="javascript:;"><span class="flag-icon flag-icon-be" title="be"></span> Belgium</a></li>
				<li class="divider m-b-0"></li>
				<li class="text-center"><a href="javascript:;">more options</a></li>
			</ul>
		</li>
		@endisset
		<li><a href="#" data-toggle="dropdown-item" class="dropdown-toggle f-s-14"><i class="fa fa-search"></i></a></li>
		<li class="dropdown navbar-user">
			<a href="{{ url('/profile') }}" class="dropdown-toggle" data-toggle="dropdown">
						@if (isset($profile->avatar))
							<img src="/storage/avatars/{{ $profile->avatar }}"  style="width:40px; height:40px; float:left;" />
						@else
							<img src="/assets/img/avatars/user-1.jpg" style="width:40px; height:40px; float:left;" />
                        @endif
			</a>
			<div class="dropdown-menu dropdown-menu-right">
				<a href="{{ url('/profile') }}" class="dropdown-item">Редактировать Профиль</a>
				<div class="dropdown-divider"></div>
				 <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    Выход
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
				
			</div>
		</li>
	</ul>
	<!-- end header navigation right -->
</div>
<!-- end #header -->
