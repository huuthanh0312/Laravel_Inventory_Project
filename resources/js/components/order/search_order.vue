<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/order" class="btn btn-rounded btn-primary">Today Order</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-12 text-center">
                                    <h1 class="h4 text-gray-900 mb-4">Search Order</h1>
                                </div>
                            </div> 
                            <div class="">
                                <form @submit.prevent="searchDate">
                                <div class="row">
                                    <div class="form-group col-sm-12" >
                                        <label for="searchbydate">Search By Date</label>
                                        <input type="date" class="form-control" id="searchbydate" placeholder="Enter " v-model="date">
                                        <small class="text-danger" v-if="errors.date">{{ errors.date[0]}}</small>
                                    </div>
                                    
                                    <div class="form-group col-sm-12">
                                        <button type="submit" class="btn btn-primary btn-block">Search</button>
                                    </div>
                                </div>
                            </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12 mb-4">
            <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                    </div>
                    <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                        <tr>
                            <th>Customer Name</th>
                            <th>Quantity</th>
                            <th>SubTotal</th>
                            <th>Vat</th>
                            <th>Total</th>
                            <th>Pay</th>
                            <th>Due</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr v-for="order in orders" :key="order.id">
                                <td>{{order.name}}</td>
                                <td>{{order.qty}}</td>
                                <td>{{order.sub_total}} $</td>
                                <td>{{order.vat}} %</td>
                                <td>{{order.total}} $</td>
                                <td>{{order.pay}} $</td>
                                <td>{{order.due}} $</td>
                            </tr>
                        </tbody>
                    </table>
                    </div>
                    <div class="card-footer"></div>
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
           date: '',
           orders: {},
           errors:{}
       } 
    },
    methods: {
        searchDate(){
            var date = {date: this.date}
            axios.post('/api/search/order', date)
            .then(({data}) => (this.orders = data))
            .catch(error =>{
                this.errors = error.response.data.errors
                Notification.error()
            })
            
        }
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>