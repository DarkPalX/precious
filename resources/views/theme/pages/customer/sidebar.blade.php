
<div class="tablet-view">
    <a href="javascript:void(0)" class="closebtn d-block d-lg-none" onclick="closeNav()">&times;</a>

    <div class="card border-0">
        <h3>Quicklinks</h3>
        <div class="side-menu">
            <ul class="mb-0 pb-0">
                <li class="active"><a href="#"><div><i class="icon-note"></i> Dashboard</div></a></li>
                <li><a href="{{ route('customer.manage-account') }}"><div><i class="icon-user"></i> Profile</div></a></li>
                <li><a href="#"><div><i class="icon-book"></i> My Library</div></a></li>
                <li><a href="{{ route('profile.sales') }}"><div><i class="icon-money-bill"></i> Transactions</div></a></li>
                <li><a href="#"><div><i class="icon-coins"></i> E-Credit</div></a></li>
                <li><a href="javascript:;" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><div><i class="icon-door-open"></i> Sign Out</div></a></li>
                <li><a href="#"><div><i class="icon-phone-sign"></i> Contact Precious</div></a></li>
            </ul>
        </div>
    </div>
</div>