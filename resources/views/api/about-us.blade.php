

  @if(isset($Info))
        @php($PageID = $BlogDetail->Page_ID)
        @php($Content = $BlogDetail->about_us)   
  @endif

<div bgcolor="#fafafa">
  <div style="background-color:#fafafa"> 
           {!! $Content !!}   
  </div>
</div>
