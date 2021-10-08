<template>
<div class="row justify-content-center">
      
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="float-right">
                <router-link to="/store-customer" class="btn btn-rounded btn-primary">Add Customer</router-link>
        </div> 
        <div class="card shadow-sm my-5">            
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="login-form">
                            <div class="row">
                                <div class=" col-lg-4">
                                    <h1 class="h4 text-gray-900 mb-4">Customer List</h1>
                                </div>
                                <div class=" col-lg-8">
                                    <input type="text" class="form-control" placeholder="Search Customer Here" v-model="searchItem">
                                </div>
                                
                            </div> 
                            <hr> 
                            <div class="table-responsive">
                            <table class="table align-items-center table-flush">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Photo</th>
                                        <th>Phone</th>
                                        <th>Address</th>
                                        <th width="20%">Adction</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="customer in filterSearch" :key="customer.id">
                                        <td>{{customer.name}}</td>
                                        <td><img :src="customer.photo" alt="" id="em_photo"></td>
                                        <td>{{customer.phone}}</td>
                                        <td>{{customer.address}}</td>
                                        <td>
                                            <router-link :to="{name: 'edit-customer', params:{id:customer.id}}" class="btn btn-sm btn-warning">
                                                Edit</router-link>
                                            <a @click="deleteCustomer(customer.id)" class="btn btn-sm btn-danger text-white">Delete</a>
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
           customers:[],
           searchItem:''
       } 
    },
    computed:{
        filterSearch(){
            return this.customers.filter(customer => {
                return customer.name.match(this.searchItem)
            })
        }
    },
    methods: {
        allCustomer() {
            axios.get('/api/customer')
                .then(({data}) => this.customers = data)
                .catch()
        },
        deleteCustomer(id) {
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
                axios.delete('/api/customer/' + id)
                .then(() => {
                    this.customers = this.customers.filter( customer => {
                        return customer.id != id
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
        this.allCustomer();
    }
}
</script>

<style scoped>

#em_photo{
    width: 40px;
    height: 40px;
}
</style>