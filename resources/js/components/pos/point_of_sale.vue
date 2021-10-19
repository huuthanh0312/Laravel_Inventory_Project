<template>
  <div>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
      <h1 class="h3 mb-0 text-gray-800">POS Dashboard</h1>
      <ol class="breadcrumb">
        <li class="breadcrumb-item"><router-link to="/">Home</router-link></li>
        <li class="breadcrumb-item active" aria-current="page">POS</li>
      </ol>
    </div>

    <div class="row mb-3">
 
 

      <!-- Area Chart -->
      <div class="col-xl-5 col-lg-5">
        <div class="card">
          <div class="card-header align-items-center justify-content-between ">
            <h6 class="m-0 font-weight-bold text-primary">
              Expense Insert
              <router-link to="/store-custommer" class="float-right text-white btn btn-primary">
                Add Customer
            </router-link>
            </h6>
          </div>
          
            <div class="">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush" >
                    <thead class="thead-light">
                        <tr>
                        <th>Name</th>
                        <th>Qty</th>
                        <th>Unit</th>
                        <th>Total</th>
                        <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="cart in carts" :key="cart.id">
                        <td>{{cart.pro_name}}</td>
                        <td >
                          <input type="text" :value="cart.pro_quantity" style="width:20px;">
                          <button @click.prevent="increment(cart.id)" class="btn btn-sm btn-primary">+</button>
                          <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger"
                            v-if="cart.pro_quantity >=2" >-</button>
                          <button @click.prevent="decrement(cart.id)" class="btn btn-sm btn-danger" v-else="" disabled>-</button>
                        </td>
                        <td>{{cart.product_price}} $</td>
                        <td>{{cart.sub_total}} $</td>
                        <td><a @click="removeCart(cart.id)" class="btn btn-sm btn-danger text-white">X</a></td>
                        </tr>
                    </tbody>
                    </table>
                </div>
            </div>
            <div class="card-body">
                <ul class="list-group">
                    <li class="list-group-item d-flex align-items-center justify-content-between">Total Quantity : <strong>{{qty}}</strong></li>
                    <li class="list-group-item d-flex align-items-center justify-content-between">Sub Total : <strong>{{subtotal}}$</strong></li>
                    <li class="list-group-item d-flex align-items-center justify-content-between">Vat : <strong>{{vats.vat}} %</strong></li>
                    <li class="list-group-item d-flex align-items-center justify-content-between">Total : <strong>{{subtotal*vats.vat/100 + subtotal}} $</strong></li>
                </ul>
            </div>
            <div class="card-footer">
                <form @submit.prevent="orderDone" >
                    <div class="form-group">
                        <label for="Customer">Customer</label>
                        <select class="form-control" id="Customer" v-model="customer_id"> 
                            
                            <option :value="customer.id" v-for="customer in customers">
                                {{customer.name}}
                            </option>
                    
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="pay">Pay</label>
                        <input type="text" class="form-control" id="pay" aria-describedby="emailHelp" v-model="pay">                       
                    </div>
                    <div class="form-group">
                        <label for="due">Due</label>
                        <input type="text" class="form-control" id="due" aria-describedby="emailHelp" v-model="due">
                        
                    </div>
                    <div class="form-group">
                        <label for="pay">Pay By</label>
                        <select name="" id="" class="form-control" v-model="payby">
                            <option value="HashCash">HashCash</option>
                            <option value="Cheaque">Cheaque</option>
                            <option value="GifCard">Gif Card</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

      <!-- Pie Chart -->
      <div class="col-xl-7 col-lg-7">
        <div class="card mb-4">
            <div class="card-header py-3  align-items-center justify-content-between ">
                <h6 class="m-0 font-weight-bold text-primary">Product Sold </h6>
          </div>
          <hr>     
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" 
                aria-controls="home" aria-selected="true">All Product</a>
            </li>
            <li class="nav-item" v-for="category in categories" :key="category.id">
                <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" 
                aria-controls="profile" aria-selected="false" 
                    @click="subProduct(category.id)">
                    {{category.category_name}}
                </a>
            </li>
        
        </ul>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                    <div class="row">
                        <div class=" col-lg-12 m-2 pr-3">
                        <input type="text" class="form-control" placeholder="Search Product Here" v-model="getSearchItem">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-6  mb-3" v-for="product in filterSearch" :key="product.id">
                            <button class="btn btn-sm" @click="addToCart(product.id)">
                            <div class="card" style="width: 8.5rem;" >
                                <img class="card-img-top" :src="product.image" alt="Card image cap" id="em_photo">
                                <div class="card-body">
                                    <h5 class="card-title">{{product.product_name}}</h5>
                                    <td v-if="product.product_quantity >=1"> 
                                        <span class="badge badge-success">Avalible {{product.product_quantity}}</span>                                       
                                    </td>
                                    <td v-else=" "> 
                                        <span class="badge badge-danger">Stock out</span>                                       
                                    </td>
                                </div>
                            </div>
                            </button>
                        </div>
                        
                    </div>
                </div>
                <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="row">
                        <div class=" col-lg-12 m-2 pr-4">
                        <input type="text" class="form-control" placeholder="Search Product Here" v-model="searchItem">
                        </div>
                        <div class="col-lg-3 col-md-3 col-sm-6 col-6 mb-3" v-for="product in getFilterSearch" :key="product.id">
                            <button class="btn btn-sm" @click="addToCart(product.id)">
                            <div class="card" style="width: 8.5rem;" >
                                <img class="card-img-top" :src="product.image" alt="Card image cap" id="em_photo">
                                <div class="card-body">
                                    <h5 class="card-title">{{product.product_name}}</h5>
                                    <td v-if="product.product_quantity >=1"> 
                                        <span class="badge badge-success">Avalible {{product.product_quantity}}</span>                                       
                                    </td>
                                    <td v-else=" "> 
                                        <span class="badge badge-danger">Stock out</span>                                       
                                    </td>
                                </div>
                            </div>
                            </button>
                        </div>
                        
                    </div>
                </div>                      
            </div>
          
        </div>
      </div>
    <!--Row-->
    </div>
  </div>
  </div>
</template>


<script>
export default {
  created() {
    if (!User.loggedIn()) {
      this.$router.push({ name: "/" });
    }
  },
  created() {
    this.allProduct();
    this.allCategory();
    this.allCustomer();
    this.cartProduct();
    this.vat();
    Reload.$on('afterAdd', () => {
      this.cartProduct();
    });
  },
  data() {
    return {
        // form:{
        //     customer_id: null,
        //     pay: null,
        //     due: null,
        //     payby: null,
        //    },
        customer_id: '',
        pay: '',
        due: '',
        payby: '',
        products: [],
        carts: '',
        categories: '',
        getproducts: [],
        searchItem: '',
        getSearchItem: '',
        customers: '',
        vats: '',
        errors: '',
    };
  },
  computed: {
    filterSearch() {
      return this.products.filter((product) => {
        return product.product_name.match(this.searchItem);
      });
    },
    getFilterSearch() {
      return this.getproducts.filter((getproduct) => {
        return getproduct.product_name.match(this.getSearchItems);
      });
    },
    qty() {
      let sum = 0;
      for (let i = 0; i < this.carts.length; i++) {
        sum += parseFloat(this.carts[i].pro_quantity);
      }
      return sum;
    },
    subtotal() {
      let sum = 0;
      for (let i = 0; i < this.carts.length; i++) {
        sum += parseFloat(this.carts[i].sub_total);
      }
      return sum;
    },
  },
  methods: {
    addToCart(id){
        axios.get("/api/addToCart/" + id)
        .then(() => {
          Reload.$emit('afterAdd')
            Notification.card_success()
        })
        .catch();
    },
    removeCart(id){
    axios.get("/api/remove/cart/" + id)
      .then(() => {
        Reload.$emit('afterAdd')
        Notification.card_delete()
      })
      .catch();
    },
    increment(id){
    axios.get("/api/increment/cart/" + id)
      .then(() => {
        Reload.$emit('afterAdd')
      })
      .catch();
    },
    decrement(id){
    axios.get("/api/decrement/cart/" + id)
      .then(() => {
        Reload.$emit('afterAdd')
      })
      .catch();
    },
    cartProduct() {
      axios.get("/api/cart/product")
        .then(({ data }) => (this.carts = data))
        .catch();
    },
    vat(){
      axios.get("/api/vats")
        .then(({ data }) => (this.vats = data))
        .catch();
    },
    allProduct() {
      axios.get("/api/product")
        .then(({ data }) => (this.products = data))
        .catch();
    },
    allCategory() {
      axios.get("/api/category")
        .then(({ data }) => (this.categories = data))
        .catch();
    },
    subProduct(id) {
      axios.get("/api/getting/product/" + id)
        .then(({ data }) => (this.getproducts = data))
        .catch();
    },
    allCustomer() {
        axios.get("/api/customer")
        .then(({ data }) => (this.customers = data))
        .catch();
    },
    orderDone() {
      let total = this.subtotal* this.vats.vat/100 + this.subtotal;
      var data = {
        qty : this.qty,
        customer_id : this.customer_id,
        subtotal : this.subtotal,
        pay : this.pay,
        due : this.due,
        vat : this.vats.vat,
        payby : this.payby,
        total : total,
      }
      axios.post("/api/orderdone", data)
      .then(() => {
        this.$router.push({ name: "home" })
        Notification.success()
      })
      .catch();
    }
  },
};
</script>

<style scoped>
#em_photo {
  width: 100px;
  height: 135px;
}
</style>