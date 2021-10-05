<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/store-product" class="btn btn-rounded btn-primary">Add Product</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Product List</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <input type="text" class="form-control" placeholder="Search Product Here" v-model="searchItem">
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Code</th>
                                        <th>Photo</th>
                                        <th>Category</th>
                                        <th>Buying Price</th>
                                        <th>Selling Price</th>
                                        <th>Root</th>
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in filterSearch" :key="product.id">
                                        <td>{{product.product_name}}</td>
                                        <td>{{product.product_code}}</td>
                                        <td><img :src="product.image" alt="" id="em_photo"></td>
                                        <td>{{product.category_name}}</td>
                                        <td>{{product.buying_price}} $</td>
                                        <td>{{product.selling_price}} $</td>
                                        <td>{{product.root}}</td>
                                        <td>
                                            <router-link :to="{name: 'edit-product', params:{id:product.id}}" class="btn btn-sm btn-warning">
                                                Edit</router-link>
                                            <a @click="deleteProduct(product.id)" class="btn btn-sm btn-danger text-white">Delete</a>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</template>


<script>
export default {
    created() {
        if(!User.loggedIn()){
            this.$router.push({name: '/'})
        }
    },
    data() {
       return {
           products:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.products.filter(product => {
                return product.name.match(this.searchItem)
            })
        }
    },
    methods: {
        allProduct() {
            axios.get('/api/product')
                .then(({data}) => this.products = data)
                .catch()
        },
        deleteProduct(id) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
            if (result.isConfirmed) {
                axios.delete('/api/product/' + id)
                .then(() => {
                    this.products = this.products.filter( product => {
                        return product.id != id
                    })
                })
                Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
                )
            }
        })
    }
    },
    created() {
        this.allProduct();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>