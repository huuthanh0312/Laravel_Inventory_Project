<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Add Product</h1>
                            </div>
                            <div class="float-right">
                                <router-link to="/product" class="btn btn-rounded btn-primary">All Product</router-link>
                            </div>
                            <br><br>
                            <hr>  
                            <form @submit.prevent="productInsert" enctype="multipart/form-data">
                                <div class="row">
                                    <div class="form-group col-sm-6" >
                                        <label for="product_name">Product Name</label>
                                        <input type="text" class="form-control" id="product_name" placeholder="Enter Your Product Name" v-model="form.product_name">
                                        <small class="text-danger" v-if="errors.product_name">{{ errors.product_name[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="product_code">Product Code</label>
                                        <input type="text" class="form-control" id="product_code" aria-describedby="emailHelp"
                                        placeholder="Enter Your Product Code" v-model="form.product_code">
                                        <small class="text-danger" v-if="errors.product_code">{{ errors.product_code[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="exampleFormControlSelect1">Product Category</label>
                                        <select class="form-control" id="exampleFormControlSelect1" v-model="form.category_id">
                                            
                                            <option :value="category.id" v-for="category in categories">
                                                {{category.category_name}}
                                            </option>
                                    
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="supplier_id">Product Supplier</label>
                                        <select class="form-control" id="supplier_id" v-model="form.supplier_id">
                                            
                                            <option :value="supplier.id" v-for="supplier in suppliers">
                                                {{supplier.name}}
                                            </option>
                                           
                                        </select>
                                    </div>
                                    <div class="form-group col-sm-4" >
                                        <label for="root">Product Root</label>
                                        <input type="text" class="form-control" id="root" placeholder="Enter Your Product Root" v-model="form.root">
                                        <small class="text-danger" v-if="errors.root">{{ errors.root[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-4" >
                                        <label for="buying_price">Buying Price</label>
                                        <input type="text" class="form-control" id="buying_price" placeholder="Enter Your Buying Price" v-model="form.buying_price">
                                        <small class="text-danger" v-if="errors.buying_price">{{ errors.buying_price[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-4" >
                                        <label for="selling_price">Selling Price</label>
                                        <input type="text" class="form-control" id="selling_price" placeholder="Enter Your Selling Price" v-model="form.selling_price">
                                        <small class="text-danger" v-if="errors.selling_price">{{ errors.selling_price[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6" >
                                        <label for="buying_date">Buying Date</label>
                                        <input type="date" class="form-control" id="buying_date" placeholder="Enter Your Buying Date" v-model="form.buying_date">
                                        <small class="text-danger" v-if="errors.buying_date">{{ errors.buying_date[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6" >
                                        <label for="product_quantity">Product Quantity</label>
                                        <input type="text" class="form-control" id="product_quantity" placeholder="Enter Your Product Quantity" v-model="form.product_quantity">
                                        <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0]}}</small>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="customFile" @change="onFileSelected">
                                            <label class="custom-file-label" for="customFile">Choose file</label>
                                            <small class="text-danger" v-if="errors.image">{{ errors.image[0]}}</small>
                                        </div>                                      
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <img :src="form.image" alt="" style="width: 50px; height:50px;">                                   
                                    </div>
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">Submit</button>
                                    </div>
                                </div>
                            </form>
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
           form:{
                category_id: null,
                product_name: null,
                product_code: null,
                root: null,
                buying_price: null,
                selling_price: null,
                supplier_id: null,
                buying_date: null,
                image: null,
                product_quantity: null,
           },
           errors:{},
           suppliers:{},
           categories:{},
       } 
    },
    methods: {
        onFileSelected(event){
            let file = event.target.files[0];
            if(file.size > 5242880){
                Notification.image_validation()
            }else{
                let reader = new FileReader();
                reader.onload = event => {
                    this.form.image = event.target.result
    
                };
                reader.readAsDataURL(file);
            }
        },
        productInsert(){
            
            axios.post('/api/product', this.form)
            .then(() => {
                this.$router.push({name: 'product'})
                Notification.success()
            })
            .catch(error =>{
                this.errors = error.response.data.errors
                Notification.error()
            })
            
        }
    },
    created() {
        axios.get('/api/supplier')
            .then(({data}) => { this.suppliers = data})

        axios.get('/api/category')
            .then(({data}) => { this.categories = data})
    }
}
</script>

<style scoped>

</style>