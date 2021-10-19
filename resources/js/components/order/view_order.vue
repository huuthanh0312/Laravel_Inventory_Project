<template>
<div class="row justify-content-center">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card shadow-sm my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4">Order Details</h1>
                            </div>
                            <div class="row">
                                <div class="col-lg-6 mb-4">
                                <!-- Simple Tables -->
                                    <div class="card">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                                        </div>
                                        <div class="table-responsive">
                                            <ul class="list-group">
                                                <li class="list-group-item"><b>Name</b> : {{orders.name}}</li>
                                                <li class="list-group-item"><b>Phone</b> : {{orders.phone}}</li>
                                                <li class="list-group-item"><b>Address</b> : {{orders.address}}</li>
                                                <li class="list-group-item"><b>Date</b> : {{orders.order_date}}</li>
                                                <li class="list-group-item"><b>Pay By</b> : {{orders.payby}}</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer"></div>
                                    </div>
                                </div>
                                <div class="col-lg-6 mb-4">
                                <!-- Simple Tables -->
                                    <div class="card">
                                        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                                        <h6 class="m-0 font-weight-bold text-primary">Order Details</h6>
                                        </div>
                                        <div class="table-responsive">
                                            <ul class="list-group">
                                                <li class="list-group-item"><b>Sub total</b> : {{orders.sub_total}} $</li>
                                                <li class="list-group-item"><b>Vat</b> : {{orders.vat}} %</li>
                                                <li class="list-group-item"><b>Total</b> : {{orders.total}} $</li>
                                                <li class="list-group-item"><b>Pay Amount</b> : {{orders.pay}} $</li>
                                                <li class="list-group-item"><b>Due Amount</b> : {{orders.due}} $</li>
                                            </ul>
                                        </div>
                                        <div class="card-footer"></div>
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
                                                <th>Product Name</th>
                                                <th>Product Code</th>
                                                <th>Image</th>
                                                <th>Quantity</th>
                                                <th>Unit Price</th>
                                                <th>Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="detail in details" :key="detail.id">
                                                    <td>{{detail.product_name}}</td>
                                                    <td>{{detail.product_code}}</td>
                                                    <td><img :src="'/'+detail.image" alt="" id="em_photo"></td> 
                                                    <td>{{detail.pro_quantity}}</td>
                                                    <td>{{detail.pro_price}} $</td>
                                                    <td>{{detail.sub_total}} $</td>
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
                </div>
            </div>
        </div>
        <div class="float-left">
            <router-link to="/order" class="btn btn-rounded btn-primary">Go Back </router-link>
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
        orders : '',
        details: '',
        errors:{}
       } 
    },
    created() {
        let id  = this.$route.params.id
        axios.get('/api/order/details/' + id)
        .then(({data}) => (this.orders = data) )
        .catch()
        axios.get('/api/order/alldetails/' + id)
        .then(({data}) => (this.details = data) )
        .catch()
    },
    methods: {
        
    }
}
</script>

<style scoped>
#em_photo{
    width: 50px;
    height : 50px;
}
</style>