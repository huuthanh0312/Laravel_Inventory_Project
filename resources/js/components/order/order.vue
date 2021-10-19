<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Today Order</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <input type="text" class="form-control" placeholder="Search Here" v-model="searchItem">
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Total Amount</th>
                                        <th>Pay</th>
                                        <th>Due</th>
                                        <th>PayBy</th>
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="order in filterSearch" :key="order.id">
                                        <td>{{order.name}}</td>
                                        <td>{{order.total}} $</td>
                                        <td>{{order.pay}} $</td>
                                        <td>{{order.due}} $</td>
                                        <td>{{order.payby}}</td>
                                        <td>
                                            <router-link :to="{name: 'view-order', params:{id:order.id}}" class="btn btn-sm btn-primary">
                                                View</router-link>
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
           orders:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.orders.filter(order => {
                return order.name.match(this.searchItem)
            })
        }
    },
    methods: {
        allOrder() {
            axios.get('/api/orders')
                .then(({data}) => this.orders = data)
                .catch()
        },
        
    },
    created() {
        this.allOrder();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>