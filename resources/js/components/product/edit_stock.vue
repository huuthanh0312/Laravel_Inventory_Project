<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="float-left">
                            <h1 class="h4 text-gray-900 mb-4">Stock Update</h1>
                            </div>
                            
                            <br><br>
                            <hr>  
                            <form @submit.prevent="stockUpdate" enctype="multipart/form-data">
                                <div class="row">
                                   <div class="form-group col-sm-6" >
                                        <label for="product_name">Product Name : </label>
                                        <h4>{{form.product_name}}</h4>
                                    </div>
                                    <div class="form-group col-sm-6">
                                        <label for="product_code">Product Code : </label>
                                        <h4>{{form.product_code}}</h4>
                                    </div>
                                    
                                    <div class="form-group col-sm-12" >
                                        <label for="product_quantity">Product Stock</label>
                                        <input type="text" class="form-control" id="product_quantity" placeholder="Enter Your Product Quantity" v-model="form.product_quantity">
                                        <small class="text-danger" v-if="errors.product_quantity">{{ errors.product_quantity[0]}}</small>
                                    </div>
                                    
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="float-left">
            <router-link to="/stock" class="btn btn-rounded btn-primary">Go Back</router-link>
        </div> 
        <br>
        <br>
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
               product_name: '',
               product_code: '',
                product_quantity: '',
                
           },
           errors:{},
           
       } 
    },
    created() {
        let id  = this.$route.params.id
        axios.get('/api/product/' + id)
        .then(({data}) => (this.form = data) )
        .catch(Notification.error)

    },
    methods: {

        stockUpdate(){
            let id  = this.$route.params.id
            axios.post('/api/stock/update/'+id, this.form)
            .then(() => {
                this.$router.push({name: 'stock'})
                Notification.success()
            })
            .catch(error =>{
                this.errors = error.response.data.errors
                Notification.error()
            })
            
        }
    }
}
</script>

<style scoped>

</style>