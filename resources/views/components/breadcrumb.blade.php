<style>
  /*ul.page-breadcrumb
  {
    padding-left: 0px;
    margin-bottom: 0px;
    font-size: 12px;
    font-weight: bold;
  }
  ul.page-breadcrumb li {
    display: inline-block;
  }
  ul.page-breadcrumb li:after {
    content: ">";
    padding: 4px 8px;
    color: rgba(0, 0, 0, .45);
    font-weight: 800;
  }
  ul.page-breadcrumb li:last-of-type:after {
    content: none;
  }*/
</style>

<!-- <ul class="page-breadcrumb mt-2">
    <li>
        <i class="fa fa-home"></i>
        <a href="{{route('dashboard')}}">Home</a>
    </li>
    {!! $breadCrumb !!}
</ul> --> 

<nav style="--falcon-breadcrumb-divider: url(&#34;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8'%3E%3Cpath d='M2.5 0L1 1.5 3.5 4 1 6.5 2.5 8l4-4-4-4z' fill='%23748194'/%3E%3C/svg%3E&#34;);" aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item">
      <i class="fa fa-home"></i>
      <a href="{{route('dashboard')}}">Home</a>
    </li>
    {!! $breadCrumb !!}
  </ol>
</nav>
