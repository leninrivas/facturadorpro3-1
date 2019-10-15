 <style>
#header_bar .header-menu {
    max-height: 300px !important;
   
    overflow-y: auto;
}
#header_bar .header-menu::-webkit-scrollbar-track
{
	-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.1);
	background-color: #fdfdfd;
}

#header_bar .header-menu::-webkit-scrollbar
{
	width: 6px;
	background-color: #fdfdfd;
}

#header_bar .header-menu::-webkit-scrollbar-thumb
{
	background-color: #0187cc;
}
.header-dropdown a img {
    border-radius: 8px;
    padding: 4px;
}


.header-menu ul a {
    padding: 3px 6px;
}

.header-menu {
    box-shadow: 0 0 2px rgba(0,0,0,0.1);
    padding: 0 !important;
    border: none;
    border-radius:10px;
 }

 .header-menu a:hover, .header-menu a:focus {
    color: #0187cc;   
    background-color: #f4f4f4;
}

.header-menu ul a {
    text-transform: capitalize !important;
}

.search_input{
    margin-bottom: 0.1rem; border-radius: 20px 20px 20px 20px;

}
.search_title{

}
.search_price{
    
}
.search_btn{
    
}


 </style>

 <header class="header">
     <div class="header-top">
         <div class="container">
             <div class="header-left header-dropdowns">

             </div><!-- End .header-left -->

             <div class="header-right">


                 <div class="header-dropdown dropdown-expanded">
                     <a href="#">Links</a>
                     <div class="header-menu">
                         <ul>

                             @guest
                             <li><a href="{{route('tenant_ecommerce_login')}}" class="login-link">LOG IN</a></li>
                             @else
                             <li><a href="#">{{ Auth::user()->email }}</a></li>
                             <li>
                                 <a role="menuitem" href="{{ route('logout') }}"
                                     onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                     <i class="fas fa-power-off"></i> @lang('app.buttons.logout')
                                 </a>
                                 <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                     style="display: none;">
                                     @csrf
                                 </form>
                             </li>
                             @endguest


                         </ul>
                     </div><!-- End .header-menu -->
                 </div><!-- End .header-dropown -->
             </div><!-- End .header-right -->
         </div><!-- End .container -->
     </div><!-- End .header-top -->

     <div class="header-middle">
         <div class="container">
             <div class="header-left">
                 <a href="{{ route("tenant.ecommerce.index") }}" class="logo" style="max-width: 180px">
                    @if($vc_company->logo)
                        <img src="{{ asset('storage/uploads/logos/'.$vc_company->logo) }}" alt="Logo" />
                    @else
                        <img src="{{asset('logo/700x300.jpg')}}" alt="Logo" />
                    @endif
                 </a>
             </div><!-- End .header-left -->

             <div id="header_bar" class="header-center header-dropdowns">



                 <div class="header-dropdown" style="width:400px;">
                     <input placeholder="Buscar..." type="text" class="search_input form-control form-control-lg" v-model="value"
                         v-on:keyup="autoComplete" />
                     <div class="header-menu">
                         <ul>
                             <li v-for="result in results"><a 
                                     :href="'/ecommerce/item/' + result.id"><img style="max-width: 90px"
                                         :src="result.image_url_small" alt="England flag"> <span class="search_title"
                                         style="font-size: 1.0em;"> @{{ result.description }} </span>  <span class="search_price" >@{{result.sale_unit_price}}</span>  <div class="search_btn btn btn-default">Comprar</div>  </a>   </li>

                         </ul>
                     </div><!-- End .header-menu -->
                 </div><!-- End .header-dropown -->


             </div><!-- End .headeer-center -->

             <div class="header-right">
                 <button class="mobile-menu-toggler" type="button">
                     <i class="icon-menu"></i>
                 </button>
                 <div class="header-contact">
                     <span>Call us now</span>
                     <a href="tel:#"><strong>+999 111 888</strong></a>
                 </div><!-- End .header-contact -->
                 @include('tenant.layouts.partials_ecommerce.cart_dropdown')

             </div><!-- End .header-right -->
         </div><!-- End .container -->
     </div><!-- End .header-middle -->

     <div class="header-bottom sticky-header">
         <div class="container">
             <nav class="main-nav">

             </nav>
         </div><!-- End .header-bottom -->
     </div><!-- End .header-bottom -->
 </header><!-- End .header -->

 @push('scripts')

 <script type="text/javascript">
     var app = new Vue({
         el: '#header_bar',
         data: {
             value: '',
             suggestions: [],
             resource: 'ecommerce',
             results: [],
         },
         created() {
             this.getItems()
         },
         methods: {
             autoComplete() {
                 if (this.value) {
                    let val = this.value.toUpperCase()
                    this.results = this.suggestions.filter((obj) => {
                         let desc = obj.description.toUpperCase()
                         let internal_id = obj.internal_id ? obj.internal_id.toUpperCase() : ''
                         return desc.includes(val) ||  internal_id.includes(val)
                    })

                 } else {
                     this.results = this.suggestions
                 }
             },
             getItems() {
                 let contex = this
                 fetch(`/${this.resource}/items_bar`)
                     .then(function (response) {
                         return response.json();
                     })
                     .then(function (myJson) {
                         // console.log(myJson.data);
                         contex.suggestions = myJson.data
                         contex.results = contex.suggestions
                     });
             },
             suggestionClick(item) {
                 console.log(item)
                 this.results = []
                 this.value = item.description
             }

         }
     })

 </script>

 @endpush